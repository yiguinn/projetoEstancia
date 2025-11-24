<?php
// Proteção da página
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php?status=acesso_negado');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Estância</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../view/style.css">
</head>
<body class="bg-gray-100 font-['SF_Pro_Display',_sans_serif]">

<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Painel Administrativo</h1>
            <p class="text-sm text-gray-500">Bem-vindo, <?= htmlspecialchars($_SESSION['user_nome']) ?>!</p>
        </div>
        <div class="flex items-center space-x-4">
            <a href="../" class="text-sm text-rosa-vibrante hover:underline">
                Voltar ao Site
            </a>
            <a href="../controller/authController.php?action=logout" class="text-sm text-red-600 hover:underline">
                Sair
            </a>
        </div>
    </div>
</header>

    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-rosa-vibrante">
                <i class="fas fa-envelope-open-text fa-2x text-rosa-vibrante mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Solicitações</h2>
                <p class="text-gray-600 mb-4 text-sm">Ver mensagens recebidas.</p>
                <a href="telaAdmin.php" class="font-medium text-rosa-vibrante hover:underline">Acessar &rarr;</a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-indigo-600">
                <i class="fas fa-users fa-2x text-indigo-600 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Usuários</h2>
                <p class="text-gray-600 mb-4 text-sm">Gerenciar acessos.</p>
                <a href="gerenciarUsuarios.php" class="font-medium text-indigo-600 hover:underline">Acessar &rarr;</a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-teal-500">
                <i class="fas fa-handshake fa-2x text-teal-500 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Parceiros</h2>
                <p class="text-gray-600 mb-4 text-sm">Editar serviços parceiros.</p>
                <a href="gerenciarParceiros.php" class="font-medium text-teal-600 hover:underline">Acessar &rarr;</a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow border-t-4 border-blue-500">
            <div class="flex items-center space-x-3 mb-4">
                <i class="fas fa-images fa-2x text-blue-500"></i>
                <h2 class="text-xl font-semibold text-gray-800">Gerenciar Galerias</h2>
            </div>
            <p class="text-gray-600 mb-4">Adicione ou remova fotos das galerias do site.</p>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
                <a href="gerenciarGaleria.php?categoria=casamento" class="text-center bg-gray-50 p-3 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">Casamento</a>
                <a href="gerenciarGaleria.php?categoria=cerimonia" class="text-center bg-gray-50 p-3 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">Cerimônia</a>
                <a href="gerenciarGaleria.php?categoria=decoracao" class="text-center bg-gray-50 p-3 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">Decoração</a>
                <a href="gerenciarGaleria.php?categoria=espaco" class="text-center bg-gray-50 p-3 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">Espaço</a>
                <a href="gerenciarGaleria.php?categoria=evento" class="text-center bg-gray-50 p-3 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">Evento</a>
                <a href="gerenciarGaleria.php?categoria=recepcao" class="text-center bg-gray-50 p-3 rounded-md hover:bg-blue-50 hover:text-blue-600 transition">Recepção</a>
            </div>
        </div>
   
    </main>
</body>
</html>