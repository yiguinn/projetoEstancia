<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- CAMINHOS COM ../ (Como você pediu) ---
$path_css = "../view/style.css";
$path_img = "../view/imagens/logo.png";
$path_avatar_dir = "../view/uploads/avatars/";
$path_js = "../view/header-script.js"; // <--- CAMINHO CORRIGIDO

$link_home = "../index.php";
$link_servicos = "../index.php#servicos";
$link_galeria = "../index.php#galeria";
$link_contato = "../index.php#contato"; 

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
        html[data-theme='high-contrast'] { --rosa-vibrante: #FFFF00; --texto-principal: #FFFFFF; --texto-secundario: #DDDDDD; --fundo-principal: #000000; --fundo-secundario: #1a1a1a; --borda: #FFFF00; }
        html[data-theme='high-contrast'] body, html[data-theme='high-contrast'] header { background-color: var(--fundo-principal) !important; color: var(--texto-principal) !important; }
        html[data-theme='high-contrast'] .text-rosa-vibrante { color: var(--rosa-vibrante) !important; }
        html[data-theme='high-contrast'] .text-gray-600, html[data-theme='high-contrast'] .text-gray-700 { color: var(--texto-secundario) !important; }
        html[data-theme='high-contrast'] .bg-white { background: var(--fundo-secundario) !important; border: 1px solid var(--borda); }
        
        html[data-color-filter="protanopia"] { filter: url('#protanopia'); }
        html[data-color-filter="deuteranopia"] { filter: url('#deuteranopia'); }
        html[data-color-filter="tritanopia"] { filter: url('#tritanopia'); }
        html[data-color-filter="achromatopsia"] { filter: url('#achromatopsia'); }

        /* Adicione isso dentro da tag <style> do seu header */
html { font-size: 16px; transition: font-size 0.2s ease; } /* Tamanho Base */

html[data-font-scale='0.8'] { font-size: 13px; }
html[data-font-scale='0.9'] { font-size: 14.5px; }
html[data-font-scale='1.0'] { font-size: 16px; }
html[data-font-scale='1.1'] { font-size: 17.6px; }
html[data-font-scale='1.2'] { font-size: 19.2px; }
html[data-font-scale='1.3'] { font-size: 20.8px; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    
    <header class="w-full bg-white border-b border-gray-100 px-4 md:px-8 py-4 sticky top-0 z-40">
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
    </header>

    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-[60] hidden transition-opacity duration-300"></div>
    <aside id="mobile-sidebar" class="fixed top-0 right-0 h-full w-72 bg-white shadow-2xl z-[70] transform translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">
        <div class="p-4 flex justify-between items-center border-b border-gray-100">
            <span class="font-bold text-gray-800 text-lg">Menu</span>
            <button id="mobile-menu-close" class="text-gray-500 hover:text-rosa-vibrante p-2 focus:outline-none"><i class="fas fa-times fa-lg"></i></button>
        </div>
        <nav class="flex flex-col p-4 space-y-1">
            <a href="<?= $link_home ?>" class="block px-4 py-3 text-gray-700 hover:bg-rosa-suave hover:text-rosa-vibrante rounded-lg transition-colors"><i class="fas fa-home w-5 text-center mr-3 text-gray-700"></i> Início</a> 
            <a href="<?= $link_servicos ?>" class="block px-4 py-3 text-gray-700 hover:bg-rosa-suave hover:text-rosa-vibrante rounded-lg transition-colors"><i class="fas fa-concierge-bell w-5 text-center mr-3 text-gray-700"></i> Serviços</a> 
            <a href="<?= $link_galeria ?>" class="block px-4 py-3 text-gray-700 hover:bg-rosa-suave hover:text-rosa-vibrante rounded-lg transition-colors"><i class="fas fa-images w-5 text-center mr-3 text-gray-700"></i> Galeria</a> 
            <a href="<?= $link_contato ?>" class="block px-4 py-3 text-gray-700 hover:bg-rosa-suave hover:text-rosa-vibrante rounded-lg transition-colors"><i class="fas fa-envelope w-5 text-center mr-3 text-gray-700"></i> Contato</a>
            <?php if ($is_admin): ?><a href="<?= $link_painel ?>" class="block px-4 py-3 text-blue-600 font-bold bg-blue-50 rounded-lg mt-2"><i class="fas fa-cogs w-5 text-center mr-3"></i> Painel Admin</a><?php endif; ?>
            <div class="border-t border-gray-100 my-4"></div>
            <?php if ($is_logged_in): ?>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center space-x-3 mb-3">
                        <img src="<?= $avatarUrl ?>" alt="Avatar" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                        <div class="overflow-hidden"><p class="text-sm font-bold text-gray-800 truncate"><?= htmlspecialchars($_SESSION['user_nome']) ?></p><p class="text-xs text-gray-500 truncate"><?= htmlspecialchars($_SESSION['user_email']) ?></p></div>
                    </div>
                    <a href="<?= $link_perfil ?>" class="block w-full text-left py-2 text-sm text-gray-700 hover:text-rosa-vibrante"><i class="fas fa-user-circle mr-2 text-gray-700"></i> Meu Perfil</a>
                    <a href="<?= $link_logout ?>" class="block w-full text-left py-2 text-sm text-red-600 hover:text-red-800"><i class="fas fa-sign-out-alt mr-2"></i> Sair</a>
                </div>
            <?php else: ?>
                <div class="flex flex-col space-y-3"><a href="<?= $link_login ?>" class="text-center w-full py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">Login</a><a href="<?= $link_cadastro ?>" class="text-center w-full py-3 bg-rosa-vibrante text-white rounded-lg hover:opacity-90 font-medium">Cadastre-se</a></div>
            <?php endif; ?>
        </nav>
    </aside>

    <div id="accessibility-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-[80] hidden transition-opacity duration-300"></div>
    
    <aside id="accessibility-sidebar" class="fixed top-0 left-0 h-full w-72 bg-white shadow-2xl z-[90] transform -translate-x-full transition-transform duration-300 ease-in-out">
        <div class="p-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Acessibilidade</h2>
                <button id="accessibility-close" aria-label="Fechar menu de acessibilidade" class="p-2 -mr-2 text-gray-500 hover:text-black"><i class="fas fa-times fa-lg"></i></button>
            </div>
            <ul class="space-y-3">
                <li><button id="btn-contrast" class="w-full text-left p-3 rounded-md hover:bg-gray-100 flex items-center space-x-3"><i class="fas fa-adjust w-5 text-center"></i><span>Alternar Alto Contraste</span></button></li>
                <li>
                    <div class="p-3">
                        <label for="select-color-filter" class="block text-sm font-medium text-gray-700 mb-2">Filtro de Cor</label>
                        <select id="select-color-filter" class="w-full border-gray-300 rounded-md shadow-sm focus:border-rosa-vibrante focus:ring-rosa-vibrante">
                            <option value="none">Desativado</option>
                            <option value="protanopia">Protanopia (Sem Vermelho)</option>
                            <option value="deuteranopia">Deuteranopia (Sem Verde)</option>
                            <option value="tritanopia">Tritanopia (Sem Azul)</option>
                            <option value="achromatopsia">Acromatopsia (P&B)</option>
                        </select>
                    </div>
                </li>
                <li><button id="btn-increase-font" class="w-full text-left p-3 rounded-md hover:bg-gray-100 flex items-center space-x-3"><i class="fas fa-font w-5 text-center"></i><span>Aumentar Fonte</span></button></li>
                <li><button id="btn-decrease-font" class="w-full text-left p-3 rounded-md hover:bg-gray-100 flex items-center space-x-3"><i class="fas fa-font w-5 text-center text-xs"></i><span>Diminuir Fonte</span></button></li>
                <li><button id="btn-reset-accessibility" class="w-full flex items-center justify-center py-2 px-4 rounded-md border border-rosa-vibrante text-rosa-vibrante hover:bg-rosa-vibrante hover:text-white transition-colors duration-200 text-sm mt-4"><i class="fas fa-undo mr-2"></i><span>Redefinir Opções</span></button></li>
            </ul>
        </div>
    </aside>
    
    <svg id="svg-color-filters" style="position: absolute; height: 0; width: 0; visibility: hidden;" xmlns="http://www.w3.org/2000/svg"><defs><filter id="protanopia"><feColorMatrix type="matrix" values="0.567, 0.433, 0, 0, 0, 0.558, 0.442, 0, 0, 0, 0, 0.242, 0.758, 0, 0, 0, 0, 0, 1, 0"/></filter><filter id="deuteranopia"><feColorMatrix type="matrix" values="0.625, 0.375, 0, 0, 0, 0.700, 0.300, 0, 0, 0, 0, 0.300, 0.7, 0, 0, 0, 0, 0, 1, 0"/></filter><filter id="tritanopia"><feColorMatrix type="matrix" values="0.95, 0.05, 0, 0, 0, 0, 0.433, 0.567, 0, 0, 0, 0.475, 0.525, 0, 0, 0, 0, 0, 1, 0"/></filter><filter id="achromatopsia"><feColorMatrix type="matrix" values="0.299, 0.587, 0.114, 0, 0, 0.299, 0.587, 0.114, 0, 0, 0, 0.299, 0.587, 0.114, 0, 0, 0, 0, 0, 1, 0"/></filter></defs></svg>

    <script src="<?= $path_js ?>"></script>
</body>
</html>