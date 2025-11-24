<?php
// controller/usuarioAdminController.php
if (session_status() === PHP_SESSION_NONE) session_start();

// 1. Verifica se está logado e é Admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

require_once __DIR__ . '/../model/userModel.php';
$model = new UserModel();

// --- CONFIGURAÇÃO DO SUPER ADMIN ---
$superAdminEmail = 'Mi15sud@gmail.com'; // Mude aqui também se for um email completo
$isSuperAdmin = (trim($_SESSION['user_email']) === $superAdminEmail);

// Função auxiliar para negar acesso se não for Super Admin
function verificarSuperAdmin($isSuperAdmin) {
    if (!$isSuperAdmin) {
        header("Location: ../view/gerenciarUsuarios.php?status=erro_perm");
        exit();
    }
}

// --- EXCLUIR USUÁRIO ---
if (isset($_POST['delete_user'])) {
    verificarSuperAdmin($isSuperAdmin); // Bloqueia quem não é o mi15sud

    $id = (int)$_POST['id'];
    
    if ($id === $_SESSION['user_id']) {
        header("Location: ../view/gerenciarUsuarios.php?status=erro_self");
        exit();
    }

    if ($model->excluir($id)) {
        header("Location: ../view/gerenciarUsuarios.php?status=sucesso_delete");
    } else {
        header("Location: ../view/gerenciarUsuarios.php?status=erro_db");
    }
    exit();
}

// --- ALTERAR CARGO (ROLE) ---
if (isset($_POST['toggle_role'])) {
    verificarSuperAdmin($isSuperAdmin); // Bloqueia quem não é o mi15sud

    $id = (int)$_POST['id'];
    $roleAtual = $_POST['current_role'];
    
    if ($id === $_SESSION['user_id']) {
        header("Location: ../view/gerenciarUsuarios.php?status=erro_self");
        exit();
    }

    $novoRole = ($roleAtual === 'admin') ? 'user' : 'admin';

    if ($model->alterarRole($id, $novoRole)) {
        header("Location: ../view/gerenciarUsuarios.php?status=sucesso_role");
    } else {
        header("Location: ../view/gerenciarUsuarios.php?status=erro_db");
    }
    exit();
}

header("Location: ../view/gerenciarUsuarios.php");
exit();
?>