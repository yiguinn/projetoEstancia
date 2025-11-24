<?php
// Proteção e inicialização
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php?status=acesso_negado');
    exit();
}

require_once __DIR__ . '/../model/galeriaModel.php';

// Pega a categoria da URL (ex: ?categoria=casamento)
$categoria = $_GET['categoria'] ?? 'casamento';
$model = new GaleriaModel();
$imagens = $model->listarPorCategoria($categoria, false); // O "false" diz para buscar TODAS, não apenas as visíveis
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Galeria: <?= ucfirst($categoria) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="../view/imagens/logo.png">
    <link rel="apple-touch-icon" href="../view/imagens/logo.png">
</head>
<body class="bg-gray-100">

    <header class="bg-white shadow-sm mb-8">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">
                Gerenciar Galeria: <span class="text-rosa-vibrante"><?= ucfirst($categoria) ?></span>
            </h1>
            <a href="painelAdmin.php" class="text-sm text-blue-600 hover:underline">&larr; Voltar ao Painel</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-xl font-semibold mb-4">Adicionar Nova Imagem</h2>
            <form action="../controller/galeriaController.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="categoria" value="<?= $categoria ?>">
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-700">Título da Imagem</label>
                    <input type="text" name="titulo" id="titulo" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>
                <div>
    <label class="block text-sm font-medium text-gray-700">Arquivo da Imagem (jpg, png, gif, webp)</label>
    <label for="imagem" class="cursor-pointer mt-1 inline-block bg-rosa-vibrante text-white px-4 py-2 rounded-md hover:opacity-90">
        Escolher arquivo
    </label>
    <input type="file" name="imagem" id="imagem" required accept="image/*" class="hidden">
    
                    <button type="submit" name="add_image" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Enviar Imagem</button>

</div>
<br>
<span id="file-name" class="ml-3 text-sm text-gray-500"></span>

            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Imagens Atuais</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                <?php if (empty($imagens)): ?>
                    <p class="text-gray-500 col-span-full">Nenhuma imagem encontrada para esta categoria.</p>
                <?php else: ?>
                    <?php foreach ($imagens as $img): ?>
                        <div class="relative group <?= $img['visivel'] ? '' : 'opacity-40' ?>">
                            <img src="/view/uploads/galeria/<?= htmlspecialchars($img['caminho_arquivo']) ?>" alt="<?= htmlspecialchars($img['titulo']) ?>" class="w-full h-40 object-cover rounded-md">
                            
                            <span class="absolute top-2 left-2 text-xs font-bold text-white px-2 py-1 rounded-full <?= $img['visivel'] ? 'bg-green-600' : 'bg-gray-700' ?>">
                                <?= $img['visivel'] ? 'Visível' : 'Oculto' ?>
                            </span>

                            <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <form action="../controller/galeriaController.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $img['id'] ?>">
                                    <input type="hidden" name="categoria" value="<?= $categoria ?>">
                                    <input type="hidden" name="status_atual" value="<?= $img['visivel'] ?>">
                                    <button type="submit" name="toggle_visibility" class="text-white text-sm px-3 py-1 rounded-md <?= $img['visivel'] ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' ?>">
                                        <?= $img['visivel'] ? 'Ocultar' : 'Mostrar' ?>
                                    </button>
                                </form>

                                <form action="../controller/galeriaController.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta imagem PERMANENTEMENTE?');">
                                    <input type="hidden" name="id" value="<?= $img['id'] ?>">
                                    <input type="hidden" name="categoria" value="<?= $categoria ?>">
                                    <button type="submit" name="delete_image" class="text-white text-sm bg-red-600 px-3 py-1 rounded-md hover:bg-red-700">Excluir</button>
                                </form>
                            </div>
                            <p class="text-xs text-gray-600 mt-1 truncate" title="<?= htmlspecialchars($img['titulo']) ?>"><?= htmlspecialchars($img['titulo']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
document.getElementById('imagem').addEventListener('change', function() {
  var fileName = this.files[0] ? this.files[0].name : "Nenhum arquivo selecionado";
  document.getElementById('file-name').textContent = fileName;
});
</script>
</body>
</html>