<?php
// controller/adminController.php
if (session_status() === PHP_SESSION_NONE) session_start();

// Segurança extra
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

require_once __DIR__ . '/../model/formModel.php';
$model = new formModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Apenas Excluir
    if (isset($_POST['delete']) && !empty($_POST['id'])) {
        $id = (int) $_POST['id'];
        $model->excluir($id);
    }
}

// Sempre redireciona de volta para a tela admin
header("Location: ../view/telaAdmin.php");
exit();
?>