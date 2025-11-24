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

    // --- VALIDAÇÃO FORTE DE SENHA NO BACKEND ---
    // Verifica: 8 chars, 1 maiúscula, 1 minúscula, 1 número, 1 especial
    $senhaSegura = true;
    if (strlen($password) < 8) $senhaSegura = false;
    if (!preg_match('/[A-Z]/', $password)) $senhaSegura = false;
    if (!preg_match('/[a-z]/', $password)) $senhaSegura = false;
    if (!preg_match('/[0-9]/', $password)) $senhaSegura = false;
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) $senhaSegura = false;

    if (!$senhaSegura) {
        header('Location: ../view/cadastro.php?status=erro_senha_fraca');
        exit();
    }
    // ------------------------------------------

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
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_telefone'] = $user['telefone'];

        // Redireciona com base no cargo (role) do usuário
        if ($user['role'] === 'admin') {
            // Admin vai para o painel principal (dentro de /view)
            header('Location: ../view/painelAdmin.php'); 
        } else {
            // CORRIGIDO: Usuário comum volta para a raiz do site
            header('Location: ../index.php'); 
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
    // CORRIGIDO: Ao sair, volta para a raiz do site
    header('Location: ../index.php');
    exit();
}

// Se nenhuma ação válida for encontrada, redireciona para a página de login por segurança
header('Location: ../view/login.php');
exit();