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
<body class="bg-gray-100">

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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <i class="fas fa-envelope-open-text fa-2x text-rosa-vibrante mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Solicitações</h2>
                <p class="text-gray-600 mb-4 text-sm">Mensagens recebidas pelo site.</p>
                <a href="telaAdmin.php" class="font-medium text-rosa-vibrante hover:underline">Acessar &rarr;</a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <i class="fas fa-users fa-2x text-indigo-600 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Usuários</h2>
                <p class="text-gray-600 mb-4 text-sm">Gerencie cadastros e admins.</p>
                <a href="gerenciarUsuarios.php" class="font-medium text-indigo-600 hover:underline">Gerenciar &rarr;</a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <i class="fas fa-images fa-2x text-blue-500 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Galerias</h2>
                <div class="grid grid-cols-2 gap-2 mt-2 text-sm text-blue-600">
                    <a href="gerenciarGaleria.php?categoria=casamento" class="hover:underline">Casamento</a>
                    <a href="gerenciarGaleria.php?categoria=cerimonia" class="hover:underline">Cerimônia</a>
                    <a href="gerenciarGaleria.php?categoria=decoracao" class="hover:underline">Decoração</a>
                    <a href="gerenciarGaleria.php?categoria=espaco" class="hover:underline">Espaço</a>
                    <a href="gerenciarGaleria.php?categoria=evento" class="hover:underline">Evento</a>
                    <a href="gerenciarGaleria.php?categoria=recepcao" class="hover:underline">Recepção</a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <i class="fas fa-handshake fa-2x text-teal-500 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Parceiros</h2>
                <p class="text-gray-600 mb-4 text-sm">Fotos e textos dos serviços.</p>
                <a href="gerenciarParceiros.php" class="font-medium text-teal-600 hover:underline">Acessar &rarr;</a>
            </div>
        </div>
    </main>
</body>
</html>