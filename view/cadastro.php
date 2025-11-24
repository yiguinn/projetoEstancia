<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crie sua Conta - Estância Ilha da Madeira</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="/view/imagens/logo.png">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-12">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <a href="index.php" class="flex justify-center mb-6">
            <img src="../view/imagens/logo.png" width="60" alt="Logo Estância">
        </a>
        <h1 class="text-2xl font-bold text-center text-rosa-vibrante mb-6">Crie sua Conta</h1>

        <?php if (isset($_GET['status'])): ?>
            <div class="p-3 rounded mb-4 text-sm
                <?php if ($_GET['status'] === 'erro_campos' || $_GET['status'] === 'erro_senha_fraca'): ?> bg-red-100 text-red-700 <?php endif; ?>
                <?php if ($_GET['status'] === 'erro_existente'): ?> bg-red-100 text-red-700 <?php endif; ?>
            ">
                <?php
                    if ($_GET['status'] === 'erro_campos') echo "Por favor, preencha todos os campos.";
                    if ($_GET['status'] === 'erro_existente') echo "Este email já está cadastrado.";
                    if ($_GET['status'] === 'erro_senha_fraca') echo "Sua senha não atende aos requisitos de segurança.";
                ?>
            </div>
        <?php endif; ?>

        <form action="../controller/authController.php" method="POST" class="space-y-4">
            <div>
                <label for="nometxt" class="block text-sm font-medium text-gray-700">Nome Completo</label>
                <input type="text" name="nometxt" id="nometxt" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-rosa-vibrante focus:border-rosa-vibrante sm:text-sm">
            </div>
             <div>
                <label for="emailtxt" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="emailtxt" id="emailtxt" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-rosa-vibrante focus:border-rosa-vibrante sm:text-sm">
            </div>
            <div>
                <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
                <input type="tel" name="telefonenum" id="telefone" required placeholder="(XX) XXXXX-XXXX" maxlength="15" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-rosa-vibrante focus:border-rosa-vibrante sm:text-sm">
                <span id="telefone-error" class="text-red-500 text-sm mt-1" style="display: none;"></span>
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" name="password" id="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-rosa-vibrante focus:border-rosa-vibrante sm:text-sm">
                
                <div class="mt-3 bg-gray-50 p-3 rounded-md text-sm text-gray-500 space-y-1">
                    <p class="font-medium text-gray-700 mb-2">A senha deve conter:</p>
                    <ul class="space-y-1">
                        <li id="req-length" class="flex items-center"><i class="far fa-circle mr-2"></i> Mínimo de 8 caracteres</li>
                        <li id="req-upper" class="flex items-center"><i class="far fa-circle mr-2"></i> Pelo menos uma letra maiúscula</li>
                        <li id="req-lower" class="flex items-center"><i class="far fa-circle mr-2"></i> Pelo menos uma letra minúscula</li>
                        <li id="req-number" class="flex items-center"><i class="far fa-circle mr-2"></i> Pelo menos um número</li>
                        <li id="req-special" class="flex items-center"><i class="far fa-circle mr-2"></i> Um caractere especial (!@#$...)</li>
                    </ul>
                </div>
            </div>

            <div>
                <button type="submit" name="cadastro" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rosa-vibrante hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rosa-vibrante transition-opacity disabled:opacity-50 disabled:cursor-not-allowed">
                    Cadastrar
                </button>
            </div>
        </form>
        <p class="text-center text-sm text-gray-600 mt-6">
            Já tem uma conta? <a href="login.php" class="font-medium text-rosa-vibrante hover:underline">Faça login</a>
        </p>
    </div>
    
    <script src="telefone.js"></script>
    <script src="password-validation.js"></script> </body>
</html>