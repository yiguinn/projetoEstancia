<?php
// controller/profileController.php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit();
}

require_once __DIR__ . '/../model/userModel.php';
require_once __DIR__ . '/../model/formModel.php';

$userModel = new UserModel();
$formModel = new formModel();
$userId = $_SESSION['user_id'];

// --- 1. ATUALIZAR DADOS PESSOAIS (NOME/TELEFONE) ---
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

// --- 2. ATUALIZAR EMAIL ---
if (isset($_POST['update_email'])) {
    $novoEmail = $_POST['email'] ?? '';

    if (filter_var($novoEmail, FILTER_VALIDATE_EMAIL)) {
        if ($userModel->atualizarEmail($userId, $novoEmail)) {
            $_SESSION['user_email'] = $novoEmail; // Atualiza sessão
            header("Location: ../view/perfil.php?status=sucesso_email");
        } else {
            header("Location: ../view/perfil.php?status=erro_email_existente");
        }
    } else {
        header("Location: ../view/perfil.php?status=erro_email_invalido");
    }
    exit();
}

// --- 3. UPLOAD DE FOTO DE PERFIL ---
if (isset($_POST['upload_avatar'])) {
    $imagem = $_FILES['avatar'] ?? null;

    if ($imagem && $imagem['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($extensao, $permitidas)) {
            $novoNome = "avatar_" . $userId . "_" . uniqid() . "." . $extensao;
            $dirDestino = __DIR__ . '/../view/uploads/avatars/';
            
            if (!is_dir($dirDestino)) {
                mkdir($dirDestino, 0777, true);
            }

            $destinoCompleto = $dirDestino . $novoNome;

            if (move_uploaded_file($imagem['tmp_name'], $destinoCompleto)) {
                $userModel->atualizarAvatar($userId, $novoNome);
                $_SESSION['user_avatar'] = $novoNome; 
                header("Location: ../view/perfil.php?status=sucesso_avatar");
            } else {
                header("Location: ../view/perfil.php?status=erro_upload_move");
            }
        } else {
            header("Location: ../view/perfil.php?status=erro_formato");
        }
    } else {
        header("Location: ../view/perfil.php?status=erro_arquivo");
    }
    exit();
}

// --- 4. ALTERAR SENHA ---
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

    if (strlen($novaSenha) < 8 || !preg_match('/[A-Z]/', $novaSenha) || !preg_match('/[0-9]/', $novaSenha)) {
        header("Location: ../view/perfil.php?status=erro_senha_fraca");
        exit();
    }

    if (!$userModel->verificarSenha($userId, $senhaAtual)) {
        header("Location: ../view/perfil.php?status=erro_senha_atual");
        exit();
    }

    if ($userModel->atualizarSenha($userId, $novaSenha)) {
        header("Location: ../view/perfil.php?status=sucesso_senha");
    } else {
        header("Location: ../view/perfil.php?status=erro_db");
    }
    exit();
}

// --- 5. EXCLUIR SOLICITAÇÃO ---
if (isset($_POST['delete_request'])) {
    $requestId = $_POST['request_id'];
    
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