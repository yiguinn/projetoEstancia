<?php
// controller/authController.php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../model/userModel.php';

$model = new UserModel();

// --- LÓGICA DE CADASTRO ---
if (isset($_POST['cadastro'])) {
    $nome = $_POST['nometxt'] ?? '';
    $email = $_POST['emailtxt'] ?? '';
    $telefone = $_POST['telefonenum'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($nome) || empty($email) || empty($password)) {
        header('Location: ../view/cadastro.php?status=erro_campos');
        exit();
    }

    if ($model->cadastrar($nome, $email, $telefone, $password)) {
        header('Location: ../view/login.php?status=sucesso_cadastro');
    } else {
        header('Location: ../view/cadastro.php?status=erro_existente');
    }
    exit();
}

// --- LÓGICA DE LOGIN ---
if (isset($_POST['login'])) {
    $email = $_POST['emailtxt'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $model->buscarPorEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        // Login bem-sucedido: armazena dados na sessão
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nome'] = $user['nome'];
        $_SESSION['user_role'] = $user['role']; // GUARDA O CARGO!

        // Redireciona com base no cargo (role)
        if ($user['role'] === 'admin') {
            header('Location: ../view/telaAdmin.php');
        } else {
            header('Location: ../view/index.php'); // Usuário comum volta para o site
        }
        exit();
    } else {
        header('Location: ../view/login.php?status=erro_login');
        exit();
    }
}

// --- LÓGICA DE LOGOUT ---
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: ../view/index.php'); // Ao sair, volta para a home
    exit();
}

header('Location: ../view/login.php');
exit();
?>