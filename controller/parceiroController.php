<?php
// controller/parceiroController.php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../model/parceiroModel.php';

// Proteção: Apenas administradores logados podem executar estas ações
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    die("Acesso negado.");
}

$model = new ParceiroModel();
$status = ''; // Variável para a mensagem de status no redirecionamento

// Pega a chave do parceiro (ex: 'dj') para saber para qual página redirecionar
$parceiro_chave = $_POST['parceiro_chave'] ?? '';


// --- AÇÃO: ATUALIZAR TEXTOS DO PARCEIRO ---
if (isset($_POST['update_parceiro'])) {
    $titulo = $_POST['titulo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';

    if ($model->atualizarParceiro($parceiro_chave, $titulo, $descricao)) {
        $status = 'sucesso_texto';
    } else {
        $status = 'erro_db';
    }
    header("Location: ../view/gerenciarParceiros.php?parceiro=$parceiro_chave&status=$status");
    exit();
}


// --- AÇÃO: ADICIONAR NOVA IMAGEM ---
if (isset($_POST['add_image'])) {
    $parceiro_id = $_POST['parceiro_id'] ?? 0;
    $titulo_alt = $_POST['titulo_alt'] ?? 'Imagem de parceiro';
    $imagem = $_FILES['imagem'] ?? null;

    if (!$parceiro_id || $imagem['error'] !== UPLOAD_ERR_OK) {
        $status = 'erro_campos';
    } else {
        $pasta_destino = __DIR__ . '/../view/uploads/parceiros/';
        $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
        $nome_arquivo_unico = uniqid('parceiro_', true) . '.' . $extensao;
        $caminho_completo = $pasta_destino . $nome_arquivo_unico;

        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($extensao, $extensoes_permitidas)) {
            if (move_uploaded_file($imagem['tmp_name'], $caminho_completo)) {
                if ($model->inserirImagem($parceiro_id, $nome_arquivo_unico, $titulo_alt)) {
                    $status = 'sucesso_add_img';
                } else {
                    $status = 'erro_db';
                    unlink($caminho_completo); 
                }
            } else {
                $status = 'erro_upload';
            }
        } else {
            $status = 'erro_extensao';
        }
    }
    header("Location: ../view/gerenciarParceiros.php?parceiro=$parceiro_chave&status=$status");
    exit();
}


// --- AÇÃO: EXCLUIR IMAGEM ---
if (isset($_POST['delete_image'])) {
    $imagem_id = $_POST['imagem_id'] ?? 0;
    
    $imagem = $model->buscarImagemPorId($imagem_id);
    if ($imagem) {
        $caminho_arquivo = __DIR__ . '/../view/uploads/parceiros/' . $imagem['caminho_arquivo'];
        if (file_exists($caminho_arquivo)) {
            unlink($caminho_arquivo);
        }
        if ($model->excluirImagem($imagem_id)) {
            $status = 'sucesso_delete_img';
        } else {
            $status = 'erro_db';
        }
    } else {
        $status = 'erro_nao_encontrado';
    }
    header("Location: ../view/gerenciarParceiros.php?parceiro=$parceiro_chave&status=$status");
    exit();
}


// --- AÇÃO: ALTERNAR VISIBILIDADE DA IMAGEM ---
if (isset($_POST['toggle_visibility'])) {
    $imagem_id = $_POST['imagem_id'] ?? 0;
    $status_atual = $_POST['status_atual'] ?? 0;
    $novo_status = 1 - (int)$status_atual;

    if ($model->atualizarVisibilidadeImagem($imagem_id, $novo_status)) {
        $status = 'sucesso_toggle';
    } else {
        $status = 'erro_db';
    }
    header("Location: ../view/gerenciarParceiros.php?parceiro=$parceiro_chave&status=$status");
    exit();
}

// Se nenhuma ação válida for encontrada, redireciona para a página principal de gerenciamento.
header('Location: ../view/gerenciarParceiros.php');
exit();
?>