<?php
// controller/galeriaController.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../model/galeriaModel.php';

// Proteção: Apenas administradores logados podem executar estas ações
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    // Se não for admin, interrompe a execução e exibe uma mensagem de erro.
    die("Acesso negado. Você não tem permissão para executar esta ação.");
}

$model = new GaleriaModel();
$categoria = $_POST['categoria'] ?? '';
$status = ''; // Variável para a mensagem de status no redirecionamento

// --- LÓGICA PARA ADICIONAR IMAGEM ---
if (isset($_POST['add_image'])) {
    $titulo = $_POST['titulo'] ?? 'Sem título';
    $imagem = $_FILES['imagem'] ?? null;

    // Validações básicas do formulário e do upload
    if (empty($titulo) || !$imagem || $imagem['error'] !== UPLOAD_ERR_OK) {
        $status = 'erro_campos';
    } else {
        $pasta_destino = __DIR__ . '/../view/uploads/galeria/';
        $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
        $nome_arquivo_unico = uniqid('img_', true) . '.' . $extensao;
        $caminho_completo = $pasta_destino . $nome_arquivo_unico;

        // Valida o tipo de arquivo (extensão)
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($extensao, $extensoes_permitidas)) {
            // Tenta mover o arquivo para a pasta de uploads
            if (move_uploaded_file($imagem['tmp_name'], $caminho_completo)) {
                // Se o arquivo foi salvo, insere no banco de dados
                if ($model->inserir($titulo, $nome_arquivo_unico, $categoria)) {
                    $status = 'sucesso_add';
                } else {
                    $status = 'erro_db';
                    // Importante: Remove o arquivo se a inserção no DB falhar
                    unlink($caminho_completo); 
                }
            } else {
                $status = 'erro_upload';
            }
        } else {
            $status = 'erro_extensao';
        }
    }
    // Redireciona de volta para a página de gerenciamento com uma mensagem de status
    header("Location: ../view/gerenciarGaleria.php?categoria=$categoria&status=$status");
    exit();
}


// --- LÓGICA PARA EXCLUIR IMAGEM ---
if (isset($_POST['delete_image'])) {
    $id = $_POST['id'] ?? 0;
    
    // Busca a imagem no banco para pegar o nome do arquivo
    $imagem = $model->buscarPorId($id);
    if ($imagem) {
        // Tenta excluir o arquivo físico do servidor
        $caminho_arquivo = __DIR__ . '/../view/uploads/galeria/' . $imagem['caminho_arquivo'];
        if (file_exists($caminho_arquivo)) {
            unlink($caminho_arquivo);
        }

        // Exclui o registro do banco de dados
        if ($model->excluir($id)) {
            $status = 'sucesso_delete';
        } else {
            $status = 'erro_db';
        }
    } else {
        $status = 'erro_nao_encontrado';
    }
    header("Location: ../view/gerenciarGaleria.php?categoria=$categoria&status=$status");
    exit();
}


// --- LÓGICA PARA ALTERNAR VISIBILIDADE ---
if (isset($_POST['toggle_visibility'])) {
    $id = $_POST['id'] ?? 0;
    $status_atual = $_POST['status_atual'] ?? 0;

    // Inverte o status: se era 1 vira 0, se era 0 vira 1
    $novo_status = 1 - (int)$status_atual;

    if ($model->atualizarVisibilidade($id, $novo_status)) {
        $status = 'sucesso_toggle';
    } else {
        $status = 'erro_db';
    }
    header("Location: ../view/gerenciarGaleria.php?categoria=$categoria&status=$status");
    exit();
}

// Se o script for acessado sem uma ação válida, redireciona para o painel principal.
header('Location: ../view/painelAdmin.php');
exit();