<?php
// controller/adminController.php
if (session_status() === PHP_SESSION_NONE) session_start();

// Segurança Básica
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

require_once __DIR__ . '/../model/formModel.php';
$model = new formModel();

// --- CONFIGURAÇÃO DO SUPER ADMIN ---
$superAdminEmail = 'Mi15sud@gmail.com'; 

// Verifica se quem está tentando excluir é o Super Admin
$isSuperAdmin = (isset($_SESSION['user_email']) && trim($_SESSION['user_email']) === $superAdminEmail);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Apenas Excluir Solicitações
    if (isset($_POST['delete']) && !empty($_POST['id'])) {
        
        // TRAVA DE SEGURANÇA: Se não for o Super Admin, chuta de volta
        if (!$isSuperAdmin) {
            header("Location: ../view/telaAdmin.php?status=erro_perm");
            exit();
        }

        $id = (int) $_POST['id'];
        $model->excluir($id);
    }
}

header("Location: ../view/telaAdmin.php");
exit();
?>