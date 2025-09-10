<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Estância Ilha da Madeira</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-sm bg-white p-8 rounded-lg shadow-md">
        <a href="index.php" class="flex justify-center mb-6">
            <img src="imagens/logo.png" width="60" alt="Logo Estância">
        </a>
        <h1 class="text-2xl font-bold text-center text-rosa-vibrante mb-6">Acessar sua Conta</h1>

        <?php if (isset($_GET['status'])): ?>
            <div class="p-3 rounded mb-4 text-sm
                <?php if ($_GET['status'] === 'sucesso_cadastro'): ?> bg-green-100 text-green-700 <?php endif; ?>
                <?php if ($_GET['status'] === 'erro_login'): ?> bg-red-100 text-red-700 <?php endif; ?>
            ">
                <?php
                    if ($_GET['status'] === 'sucesso_cadastro') echo "Cadastro realizado com sucesso! Faça o login para continuar.";
                    if ($_GET['status'] === 'erro_login') echo "Email ou senha inválidos. Tente novamente.";
                ?>
            </div>
        <?php endif; ?>

        <form action="../controller/authController.php" method="POST" class="space-y-4">
            <div>
                <label for="emailtxt" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="emailtxt" id="emailtxt" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-rosa-vibrante focus:border-rosa-vibrante sm:text-sm">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" name="password" id="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-rosa-vibrante focus:border-rosa-vibrante sm:text-sm">
            </div>
            <div>
                <button type="submit" name="login" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rosa-vibrante hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rosa-vibrante">
                    Entrar
                </button>
            </div>
        </form>
         <p class="text-center text-sm text-gray-600 mt-6">
            Não tem uma conta? <a href="cadastro.php" class="font-medium text-rosa-vibrante hover:underline">Cadastre-se</a>
        </p>
    </div>
</body>
</html>