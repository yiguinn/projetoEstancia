<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lógica para garantir que os caminhos funcionem na Raiz
// Como este arquivo é usado na index.php (raiz), os caminhos são diretos
$pathRoot = './';
$pathView = 'view/';
$pathController = 'controller/';
$pathUploads = 'view/uploads/';

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
    <link rel="stylesheet" href="<?= $pathView ?>style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="icon" type="image/png" href="<?= $pathView ?>imagens/logo.png">
    <style>
        /* Estilos de acessibilidade */
        html[data-theme='high-contrast'] { --rosa-vibrante: #FFFF00; --texto-principal: #FFFFFF; --texto-secundario: #DDDDDD; --fundo-principal: #000000; --fundo-secundario: #1a1a1a; --borda: #FFFF00; }
        html[data-theme='high-contrast'] body, html[data-theme='high-contrast'] header { background-color: var(--fundo-principal) !important; color: var(--texto-principal) !important; }
        html[data-theme='high-contrast'] .text-rosa-vibrante { color: var(--rosa-vibrante) !important; }
        html[data-theme='high-contrast'] .text-gray-600, html[data-theme='high-contrast'] .text-gray-700 { color: var(--texto-secundario) !important; }
        html[data-theme='high-contrast'] .bg-white { background: var(--fundo-secundario) !important; border: 1px solid var(--borda); }
    </style>
</head>
<body class="min-h-screen">
    <header class="w-full bg-white border-b border-gray-100 px-4 md:px-8 py-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between relative">

            <button id="accessibility-toggle" class="absolute left-0 top-1/2 -translate-y-1/2 p-3 text-gray-600 hover:text-rosa-vibrante">
                <i class="fas fa-universal-access fa-xl"></i>
            </button>

            <a href="<?= $pathRoot ?>index.php" class="flex items-center space-x-3 pl-12">
                <img src="<?= $pathView ?>imagens/logo.png" width="50" alt="Logo">
                <div>
                    <h1 class="text-xl font-medium text-rosa-vibrante">Estância</h1>
                    <p class="text-sm text-gray-600 -mt-1">Ilha da Madeira</p>
                </div>
            </a>

            <nav class="hidden md:flex items-center space-x-8">
                <a href="#inicio" class="nav-link text-gray-700 hover:text-rosa-vibrante">Início</a> 
                <a href="#servicos" class="nav-link text-gray-700 hover:text-rosa-vibrante">Serviços</a> 
                <a href="#galeria" class="nav-link text-gray-700 hover:text-rosa-vibrante">Galeria</a> 
                
                <?php if ($is_admin): ?>
                    <a href="<?= $pathView ?>painelAdmin.php" class="nav-link font-bold text-blue-600 hover:text-blue-800">Painel Admin</a> 
                <?php endif; ?>
            </nav>

            <div class="hidden md:flex items-center space-x-4">
                <?php if ($is_logged_in): 
                    $avatarFile = isset($_SESSION['user_avatar']) && !empty($_SESSION['user_avatar']) ? $_SESSION['user_avatar'] : null;
                    $avatarUrl = $avatarFile ? $pathView . 'uploads/avatars/' . $avatarFile : "https://ui-avatars.com/api/?name=" . urlencode($_SESSION['user_nome']) . "&background=C53366&color=fff";
                ?>
                    <div class="relative group">
                        <button class="flex items-center space-x-2 focus:outline-none py-2">
                            <span class="text-sm font-medium text-gray-700"><?= htmlspecialchars($_SESSION['user_nome']) ?></span>
                            <img src="<?= $avatarUrl ?>" alt="Avatar" class="w-9 h-9 rounded-full object-cover border border-gray-200">
                            <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform group-hover:rotate-180"></i>
                        </button>
                        <div class="absolute right-0 mt-0 w-56 bg-white rounded-md shadow-xl py-2 z-50 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 border border-gray-100">
                            <div class="px-4 py-2 border-b border-gray-50"><p class="text-xs text-gray-500">Logado como</p><p class="text-sm font-bold text-gray-800 truncate"><?= htmlspecialchars($_SESSION['user_email']) ?></p></div>
                            <a href="<?= $pathView ?>perfil.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-rosa-suave hover:text-rosa-vibrante transition-colors"><i class="fas fa-user-circle mr-2 w-4 text-center"></i> Meu Perfil</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="<?= $pathController ?>authController.php?action=logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"><i class="fas fa-sign-out-alt mr-2 w-4 text-center"></i> Sair</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= $pathView ?>login.php" class="text-gray-700 hover:text-rosa-vibrante text-sm">Login</a>
                    <a href="<?= $pathView ?>cadastro.php" class="bg-rosa-vibrante hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm">Cadastre-se</a>
                <?php endif; ?>
            </div>
            <button id="mobile-menu-btn" class="md:hidden">...</button>
        </div>
    </header>
    <div id="accessibility-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>
    <aside id="accessibility-sidebar" class="fixed top-0 left-0 h-full w-72 bg-white shadow-lg z-50 transform -translate-x-full transition-transform duration-300 ease-in-out">
        <div class="p-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Acessibilidade</h2>
                <button id="accessibility-close" aria-label="Fechar menu de acessibilidade" class="p-2 -mr-2 text-gray-500 hover:text-black"><i class="fas fa-times fa-lg"></i></button>
            </div>
            <ul class="space-y-3">
                <li><button id="btn-contrast" class="w-full text-left p-3 rounded-md hover:bg-gray-100 flex items-center space-x-3"><i class="fas fa-adjust w-5 text-center"></i><span>Alternar Alto Contraste</span></button></li>
                <li>
                    <div class="p-3">
                        <label for="select-color-filter" class="block text-sm font-medium text-gray-700 mb-2">Filtro de Cor (Daltonismo)</label>
                        <select id="select-color-filter" class="w-full border-gray-300 rounded-md shadow-sm focus:border-rosa-vibrante focus:ring-rosa-vibrante">
                            <option value="none">Desativado</option>
                            <option value="protanopia">Protanopia (Não vê Vermelho)</option>
                            <option value="deuteranopia">Deuteranopia (Não vê Verde)</option>
                            <option value="tritanopia">Tritanopia (Não vê Azul)</option>
                            <option value="achromatopsia">Acromatopsia (Preto e Branco)</option>
                        </select>
                    </div>
                </li>
                <li><button id="btn-increase-font" class="w-full text-left p-3 rounded-md hover:bg-gray-100 flex items-center space-x-3"><i class="fas fa-font w-5 text-center"></i><span>Aumentar Fonte</span></button></li>
                <li><button id="btn-decrease-font" class="w-full text-left p-3 rounded-md hover:bg-gray-100 flex items-center space-x-3"><i class="fas fa-font w-5 text-center text-xs"></i><span>Diminuir Fonte</span></button></li>
            </ul>
            <div class="border-t mt-6 pt-4"><button id="btn-reset-accessibility" class="w-full flex items-center justify-center py-2 px-4 rounded-md border border-rosa-vibrante text-rosa-vibrante hover:bg-rosa-vibrante hover:text-white transition-colors duration-200 text-sm"><i class="fas fa-undo mr-2"></i><span>Redefinir Opções</span></button></div>
        </div>
    </aside>
    <svg id="svg-color-filters" style="position: absolute; height: 0; width: 0; visibility: hidden;" xmlns="http://www.w3.org/2000/svg"><defs><filter id="protanopia"><feColorMatrix type="matrix" values="0.567, 0.433, 0, 0, 0, 0.558, 0.442, 0, 0, 0, 0, 0.242, 0.758, 0, 0, 0, 0, 0, 1, 0"/></filter><filter id="deuteranopia"><feColorMatrix type="matrix" values="0.625, 0.375, 0, 0, 0, 0.700, 0.300, 0, 0, 0, 0, 0.300, 0.7, 0, 0, 0, 0, 0, 1, 0"/></filter><filter id="tritanopia"><feColorMatrix type="matrix" values="0.95, 0.05, 0, 0, 0, 0, 0.433, 0.567, 0, 0, 0, 0.475, 0.525, 0, 0, 0, 0, 0, 1, 0"/></filter><filter id="achromatopsia"><feColorMatrix type="matrix" values="0.299, 0.587, 0.114, 0, 0, 0.299, 0.587, 0.114, 0, 0, 0, 0.299, 0.587, 0.114, 0, 0, 0, 0, 0, 1, 0"/></filter></defs></svg>
</body>