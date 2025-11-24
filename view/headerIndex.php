<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- CONFIGURAÇÃO DE CAMINHOS (COM ../) ---
$path_css = "../view/style.css";
$path_img = "../view/imagens/logo.png";
$path_avatar_dir = "../view/uploads/avatars/";
$path_js_acc = "../view/accessibility.js"; 

// Links de Navegação
$link_home = "../index.php";
$link_servicos = "../index.php#servicos";
$link_galeria = "../index.php#galeria";
$link_contato = "../index.php#contato"; 

// Links do Usuário
$link_painel = "../view/painelAdmin.php";
$link_perfil = "../view/perfil.php";
$link_login = "../view/login.php";
$link_cadastro = "../view/cadastro.php";
$link_logout = "../controller/authController.php?action=logout";

$is_logged_in = isset($_SESSION['user_id']);
$is_admin = $is_logged_in && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estancia Ilha da Madeira</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= $path_css ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="icon" type="image/png" href="<?= $path_img ?>">
    
    <style>
        /* Estilos de Acessibilidade */
        html[data-theme='high-contrast'] { --rosa-vibrante: #FFFF00; --texto-principal: #FFFFFF; --texto-secundario: #DDDDDD; --fundo-principal: #000000; --fundo-secundario: #1a1a1a; --borda: #FFFF00; }
        html[data-theme='high-contrast'] body, html[data-theme='high-contrast'] header { background-color: var(--fundo-principal) !important; color: var(--texto-principal) !important; }
        html[data-theme='high-contrast'] .text-rosa-vibrante { color: var(--rosa-vibrante) !important; }
        html[data-theme='high-contrast'] .text-gray-600, html[data-theme='high-contrast'] .text-gray-700 { color: var(--texto-secundario) !important; }
        html[data-theme='high-contrast'] .bg-white { background: var(--fundo-secundario) !important; border: 1px solid var(--borda); }
        
        html[data-color-filter="protanopia"] { filter: url('#protanopia'); }
        html[data-color-filter="deuteranopia"] { filter: url('#deuteranopia'); }
        html[data-color-filter="tritanopia"] { filter: url('#tritanopia'); }
        html[data-color-filter="achromatopsia"] { filter: url('#achromatopsia'); }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <header class="w-full bg-white border-b border-gray-100 px-4 md:px-8 py-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between relative">

            <button id="accessibility-toggle" class="absolute left-0 top-1/2 -translate-y-1/2 p-3 text-gray-600 hover:text-rosa-vibrante">
                <i class="fas fa-universal-access fa-xl"></i>
            </button>

            <a href="<?= $link_home ?>" class="flex items-center space-x-3 pl-12">
                <img src="<?= $path_img ?>" width="50" alt="Logo">
                <div>
                    <h1 class="text-xl font-medium text-rosa-vibrante">Estância</h1>
                    <p class="text-sm text-gray-600 -mt-1">Ilha da Madeira</p>
                </div>
            </a>

            <nav class="hidden md:flex items-center space-x-8">
                <a href="<?= $link_home ?>" class="nav-link text-gray-700 hover:text-rosa-vibrante">Início</a> 
                <a href="<?= $link_servicos ?>" class="nav-link text-gray-700 hover:text-rosa-vibrante">Serviços</a> 
                <a href="<?= $link_galeria ?>" class="nav-link text-gray-700 hover:text-rosa-vibrante">Galeria</a> 
                <a href="<?= $link_contato ?>" class="nav-link text-gray-700 hover:text-rosa-vibrante">Contato</a>
                
                <?php if ($is_admin): ?>
                    <a href="<?= $link_painel ?>" class="nav-link font-bold text-blue-600 hover:text-blue-800">Painel Admin</a> 
                <?php endif; ?>
            </nav>

            <div class="hidden md:flex items-center space-x-4">
                <?php if ($is_logged_in): 
                    $avatarFile = isset($_SESSION['user_avatar']) && !empty($_SESSION['user_avatar']) ? $_SESSION['user_avatar'] : null;
                    $avatarUrl = $avatarFile ? $path_avatar_dir . $avatarFile : "https://ui-avatars.com/api/?name=" . urlencode($_SESSION['user_nome']) . "&background=C53366&color=fff";
                ?>
                    <div class="relative group">
                        <button class="flex items-center space-x-2 focus:outline-none py-2">
                            <span class="text-sm font-medium text-gray-700"><?= htmlspecialchars($_SESSION['user_nome']) ?></span>
                            <img src="<?= $avatarUrl ?>" alt="Avatar" class="w-9 h-9 rounded-full object-cover border border-gray-200">
                            <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform group-hover:rotate-180"></i>
                        </button>
                        <div class="absolute right-0 mt-0 w-56 bg-white rounded-md shadow-xl py-2 z-50 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 border border-gray-100 transform origin-top-right">
                            <div class="px-4 py-2 border-b border-gray-50">
                                <p class="text-xs text-gray-500">Logado como</p>
                                <p class="text-sm font-bold text-gray-800 truncate"><?= htmlspecialchars($_SESSION['user_email']) ?></p>
                            </div>
                            <a href="<?= $link_perfil ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-rosa-suave hover:text-rosa-vibrante transition-colors"><i class="fas fa-user-circle mr-2 w-4 text-center"></i> Meu Perfil</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="<?= $link_logout ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"><i class="fas fa-sign-out-alt mr-2 w-4 text-center"></i> Sair</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= $link_login ?>" class="text-gray-700 hover:text-rosa-vibrante text-sm">Login</a>
                    <a href="<?= $link_cadastro ?>" class="bg-rosa-vibrante hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm">Cadastre-se</a>
                <?php endif; ?>
            </div>
            
            <button id="mobile-menu-btn" class="md:hidden text-gray-700 focus:outline-none p-2">
                <i class="fas fa-bars fa-2x"></i>
            </button>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 absolute top-full left-0 w-full shadow-lg z-40">
            <nav class="flex flex-col p-4 space-y-3">
                <a href="<?= $link_home ?>" class="text-gray-700 hover:text-rosa-vibrante py-2 border-b border-gray-50">Início</a> 
                <a href="<?= $link_servicos ?>" class="text-gray-700 hover:text-rosa-vibrante py-2 border-b border-gray-50">Serviços</a> 
                <a href="<?= $link_galeria ?>" class="text-gray-700 hover:text-rosa-vibrante py-2 border-b border-gray-50">Galeria</a> 
                <a href="<?= $link_contato ?>" class="text-gray-700 hover:text-rosa-vibrante py-2 border-b border-gray-50">Contato</a>
                
                <?php if ($is_admin): ?>
                    <a href="<?= $link_painel ?>" class="text-blue-600 font-bold py-2 border-b border-gray-50">Painel Admin</a>
                <?php endif; ?>

                <?php if ($is_logged_in): ?>
                    <div class="mt-4 pt-4 border-t border-gray-100 bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center space-x-3 mb-3">
                            <?php 
                                $avatarFile = isset($_SESSION['user_avatar']) && !empty($_SESSION['user_avatar']) ? $_SESSION['user_avatar'] : null;
                                $avatarUrl = $avatarFile ? $path_avatar_dir . $avatarFile : "https://ui-avatars.