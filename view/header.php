<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_logged_in = isset($_SESSION['user_id']);
$is_admin = $is_logged_in && $_SESSION['user_role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estancia Ilha da Madeira - Casamentos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="min-h-screen">
    <header class="w-full bg-white border-b border-gray-100 px-4 md:px-8 py-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="index.php" class="flex items-center space-x-3">
                <img src="imagens/logo.png" width="50" alt="Logo Estância">
                <div>
                    <h1 class="text-xl font-medium text-rosa-vibrante">Estância</h1>
                    <p class="text-sm text-gray-600 -mt-1">Ilha da Madeira</p>
                </div>
            </a>

            <nav class="hidden md:flex items-center space-x-8">
                <a href="index.php#inicio" class="nav-link text-gray-700 hover:text-rosa-vibrante">Início</a>
                <a href="index.php#servicos" class="nav-link text-gray-700 hover:text-rosa-vibrante">Serviços</a>
                <a href="index.php#galeria" class="nav-link text-gray-700 hover:text-rosa-vibrante">Galeria</a>
                
                <?php if ($is_admin): ?>
                    <a href="painelAdmin.php" class="nav-link font-bold text-blue-600 hover:text-blue-800">Painel Admin</a>
                <?php endif; ?>
            </nav>

            <div class="hidden md:flex items-center space-x-4">
                <?php if ($is_logged_in): ?>
                    <span class="text-sm text-gray-600">Olá, <?= htmlspecialchars($_SESSION['user_nome']) ?>!</span>
                    <a href="../controller/authController.php?action=logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                        Sair
                    </a>
                <?php else: ?>
                    <a href="login.php" class="text-gray-700 hover:text-rosa-vibrante text-sm">Login</a>
                    <a href="cadastro.php" class="bg-rosa-vibrante hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm">
                        Cadastre-se
                    </a>
                <?php endif; ?>
            </div>
            
            <button id="mobile-menu-btn" class="md:hidden">...</button> 
        </div>

        <nav id="mobile-menu" class="mobile-menu md:hidden mt-4">
            </nav>
    </header>