<?php
// controller/profileController.php
if (session_status() === PHP_SESSION_NONE) session_start();

// Verifica se está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit();
}

require_once __DIR__ . '/../model/userModel.php';
require_once __DIR__ . '/../model/formModel.php';

$userModel = new UserModel();
$formModel = new formModel();
$userId = $_SESSION['user_id'];

// --- 1. ATUALIZAR DADOS PESSOAIS ---
if (isset($_POST['update_profile'])) {
    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';

    if ($userModel->atualizarDados($userId, $nome, $telefone)) {
        $_SESSION['user_nome'] = $nome; // Atualiza sessão
        $_SESSION['user_telefone'] = $telefone;
        header("Location: ../view/perfil.php?status=sucesso_dados");
    } else {
        header("Location: ../view/perfil.php?status=erro_db");
    }
    exit();
}

// --- 2. UPLOAD DE FOTO DE PERFIL ---
if (isset($_POST['upload_avatar'])) {
    $imagem = $_FILES['avatar'] ?? null;

    if ($imagem && $imagem['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($extensao, $permitidas)) {
            // Cria nome único para evitar cache
            $novoNome = "avatar_" . $userId . "_" . uniqid() . "." . $extensao;
            $destino = __DIR__ . '/../view/uploads/avatars/' . $novoNome;

            // Cria a pasta se não existir
            if (!is_dir(__DIR__ . '/../view/uploads/avatars/')) {
                mkdir(__DIR__ . '/../view/uploads/avatars/', 0777, true);
            }

            if (move_uploaded_file($imagem['tmp_name'], $destino)) {
                $userModel->atualizarAvatar($userId, $novoNome);
                $_SESSION['user_avatar'] = $novoNome; // Atualiza sessão
                header("Location: ../view/perfil.php?status=sucesso_avatar");
            } else {
                header("Location: ../view/perfil.php?status=erro_upload");
            }
        } else {
            header("Location: ../view/perfil.php?status=erro_formato");
        }
    } else {
        header("Location: ../view/perfil.php?status=erro_arquivo");
    }
    exit();
}

// --- 3. ALTERAR SENHA ---
if (isset($_POST['update_password'])) {
    $senhaAtual = $_POST['senha_atual'] ?? '';
    $novaSenha = $_POST['nova_senha'] ?? '';
    $confirmaSenha = $_POST['confirma_senha'] ?? '';

    if (empty($senhaAtual) || empty($novaSenha) || empty($confirmaSenha)) {
        header("Location: ../view/perfil.php?status=erro_campos_senha");
        exit();
    }

    if ($novaSenha !== $confirmaSenha) {
        header("Location: ../view/perfil.php?status=erro_senha_diferente");
        exit();
    }

    // Validação de força da senha
    $senhaSegura = true;
    if (strlen($novaSenha) < 8 || 
        !preg_match('/[A-Z]/', $novaSenha) || 
        !preg_match('/[a-z]/', $novaSenha) || 
        !preg_match('/[0-9]/', $novaSenha) || 
        !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $novaSenha)) {
        
        header("Location: ../view/perfil.php?status=erro_senha_fraca");
        exit();
    }

    // Verifica senha antiga
    if (!$userModel->verificarSenha($userId, $senhaAtual)) {
        header("Location: ../view/perfil.php?status=erro_senha_atual");
        exit();
    }

    // Atualiza
    if ($userModel->atualizarSenha($userId, $novaSenha)) {
        header("Location: ../view/perfil.php?status=sucesso_senha");
    } else {
        header("Location: ../view/perfil.php?status=erro_db");
    }
    exit();
}

// --- 4. EXCLUIR SOLICITAÇÃO ---
if (isset($_POST['delete_request'])) {
    $requestId = $_POST['request_id'];
    
    // Verifica se a solicitação pertence ao usuário logado
    $requests = $formModel->listarPorUsuario($userId);
    $pertence = false;
    foreach($requests as $req) {
        if($req['idUsuario'] == $requestId) $pertence = true;
    }

    if ($pertence) {
        $formModel->excluir($requestId);
        header("Location: ../view/perfil.php?status=sucesso_delete");
    } else {
        header("Location: ../view/perfil.php?status=erro_perm");
    }
    exit();
}

header("Location: ../view/perfil.php");
exit();
?>