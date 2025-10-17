<?php
// controller/authController.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../model/userModel.php';

$model = new UserModel();

// --- LÓGICA DE CADASTRO ---
if (isset($_POST['cadastro'])) {
    $nome = $_POST['nometxt'] ?? '';
    $email = $_POST['emailtxt'] ?? '';
    $telefone = $_POST['telefonenum'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validação simples de campos obrigatórios
    if (empty($nome) || empty($email) || empty($telefone) || empty($password)) {
        header('Location: ../view/cadastro.php?status=erro_campos');
        exit();
    }

    $sucesso = $model->cadastrar($nome, $email, $telefone, $password);

    if ($sucesso) {
        header('Location: ../view/login.php?status=sucesso_cadastro');
        exit();
    } else {
        header('Location: ../view/cadastro.php?status=erro_existente');
        exit();
    }
}

// --- LÓGICA DE LOGIN ---
if (isset($_POST['login'])) {
    $email = $_POST['emailtxt'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $model->buscarPorEmail($email);

    // Verifica se o usuário existe e se a senha está correta
    if ($user && password_verify($password, $user['password'])) {
        // Login bem-sucedido: armazena todos os dados importantes na sessão
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nome'] = $user['nome'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_email'] = $user['email'];       // <-- Adicionado
        $_SESSION['user_telefone'] = $user['telefone']; // <-- Adicionado

        // Redireciona com base no cargo (role) do usuário
        if ($user['role'] === 'admin') {
            header('Location: ../view/painelAdmin.php'); // Admin vai para o painel principal
        } else {
            header('Location: ../view/index.php'); // Usuário comum volta para o site
        }
        exit();

    } else {
        // Falha no login
        header('Location: ../view/login.php?status=erro_login');
        exit();
    }
}

// --- LÓGICA DE LOGOUT ---
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: ../index.php'); // Ao sair, volta para a home do site
    exit();
}

// Se nenhuma ação válida for encontrada, redireciona para a página de login por segurança
header('Location: ../view/login.php');
exit();