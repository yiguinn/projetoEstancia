<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estancia Ilha da Madeira - Casamentos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="min-h-screen">
    <?php /* Top Bar */ ?>
    <!-- <div class="bg-rosa-vibrante text-white px-4 md:px-8 py-2">
        <div class="max-w-7xl mx-auto flex items-center justify-between text-sm">
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                    </svg>
                    <span>(11) 96100-6060</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    <span>São Paulo, SP</span>
                </div>
            </div>
            <div class="text-sm">Segunda a Sexta: 8h às 18h</div>
        </div>
    </div> -->

    <?php /* Main Header */ ?>
    <header class="w-full bg-white border-b border-gray-100 px-4 md:px-8 py-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <?php /* Logo */ ?>
            <div class="flex items-center space-x-3">
                <a href="../view/index.php">
                    <img src="imagens/logo.png" width="50" alt="">
                    <div class="flex flex-col">
                        <h1 class="text-xl font-medium text-rosa-vibrante">Estância</h1>
                        <p class="text-sm text-gray-600 -mt-1">Ilha da Madeira</p>
                </a>
                </div>
            </div>

            <?php /* Navigation */ ?>
            <nav class="hidden md:flex items-center space-x-8">
                <a href="#inicio" class="nav-link text-rosa-vibrante font-medium">Início</a>
                <a href="#servicos" class="nav-link text-gray-700 hover:text-rosa-vibrante transition-colors">Serviços</a>
                <a href="#galeria" class="nav-link text-gray-700 hover:text-rosa-vibrante transition-colors">Galeria</a>
                <a href="#sobre" class="nav-link text-gray-700 hover:text-rosa-vibrante transition-colors">Sobre</a>
                <a href="#contato" class="nav-link text-gray-700 hover:text-rosa-vibrante transition-colors">Contato</a>
            </nav>

            <?php /* CTA Button */ ?>
            <button onclick="scrollToContact()" class="bg-rosa-vibrante hover:opacity-90 text-white px-6 py-2 rounded-lg transition-opacity">
                Agendar Visita
            </button>

            <?php /* Mobile Menu Button */ ?>
            <button id="mobile-menu-btn" class="md:hidden flex flex-col space-y-1">
                <div class="w-6 h-0.5 bg-gray-600"></div>
                <div class="w-6 h-0.5 bg-gray-600"></div>
                <div class="w-6 h-0.5 bg-gray-600"></div>
            </button>
        </div>

        <?php /* Mobile Navigation */ ?>
        <nav id="mobile-menu" class="mobile-menu md:hidden mt-4 pb-4 border-t border-gray-100">
            <div class="flex flex-col space-y-4 pt-4">
                <a href="#inicio" class="nav-link text-rosa-vibrante font-medium">Início</a>
                <a href="#espacos" class="nav-link text-gray-700">Espaços</a>
                <a href="#servicos" class="nav-link text-gray-700">Serviços</a>
                <a href="#pacotes" class="nav-link text-gray-700">Pacotes</a>
                <a href="#galeria" class="nav-link text-gray-700">Galeria</a>
                <a href="#sobre" class="nav-link text-gray-700">Sobre</a>
                <a href="#contato" class="nav-link text-gray-700">Contato</a>
            </div>
        </nav>
    </header>

<script src="scriptcelular.js"></script>
<script src="telefone.js"></script>
<script src="nav-active.js"></script>
</body>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Projeto Estância</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen">

<!-- Modal central -->
<div id="modal" 
     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-[9999]">
  <div class="bg-white p-6 rounded shadow-xl relative z-[10000]">
    <p id="modal-text">Mensagem aqui</p>
    <button onclick="closeModal()" 
            class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">Fechar</button>
  </div>
</div>

</html>