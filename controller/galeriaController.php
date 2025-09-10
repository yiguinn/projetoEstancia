<?php
// controller/galeriaController.php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../model/galeriaModel.php';

// Proteção: Apenas admins podem executar estas ações
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    die("Acesso negado.");
}

$model = new GaleriaModel();
$categoria = $_POST['categoria'] ?? ''; // Pega a categoria do formulário

// --- LÓGICA PARA ADICIONAR IMAGEM ---
if (isset($_POST['add_image'])) {
    $titulo = $_POST['titulo'] ?? 'Sem título';
    $imagem = $_FILES['imagem'] ?? null;
    $status = '';

    // Validações básicas
    if (empty($titulo) || $imagem['error'] !== UPLOAD_ERR_OK) {
        $status = 'erro_campos';
    } else {
        $pasta_destino = __DIR__ . '/../view/uploads/galeria/';
        $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
        $nome_arquivo_unico = uniqid('img_', true) . '.' . $extensao;
        $caminho_completo = $pasta_destino . $nome_arquivo_unico;

        // Valida o tipo de arquivo
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($extensao, $extensoes_permitidas)) {
            // Move o arquivo para a pasta de uploads
            if (move_uploaded_file($imagem['tmp_name'], $caminho_completo)) {
                // Insere no banco de dados
                if ($model->inserir($titulo, $nome_arquivo_unico, $categoria)) {
                    $status = 'sucesso_add';
                } else {
                    $status = 'erro_db';
                    unlink($caminho_completo); // Remove o arquivo se a inserção no DB falhar
                }
            } else {
                $status = 'erro_upload';
            }
        } else {
            $status = 'erro_extensao';
        }
    }
    header("Location: ../view/gerenciarGaleria.php?categoria=$categoria&status=$status");
    exit();
}


// --- LÓGICA PARA EXCLUIR IMAGEM ---
if (isset($_POST['delete_image'])) {
    $id = $_POST['id'] ?? 0;
    $status = '';
    
    // Busca a imagem no banco para pegar o nome do arquivo
    $imagem = $model->buscarPorId($id);
    if ($imagem) {
        // Tenta excluir o arquivo físico
        $caminho_arquivo = __DIR__ . '/../view/uploads/galeria/' . $imagem['caminho_arquivo'];
        if (file_exists($caminho_arquivo)) {
            unlink($caminho_arquivo); // Exclui o arquivo do servidor
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