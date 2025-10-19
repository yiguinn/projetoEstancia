<?php
// Busca as imagens dinamicamente
require_once __DIR__ . '/../model/galeriaModel.php';
$categoria = 'casamento'; // Define a categoria desta página
$model = new GaleriaModel();
$imagens = $model->listarPorCategoria($categoria);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria de Casamento - Estância Ilha da Madeira</title>
</head>
<?php include_once ("header.php")?>
<body class="bg-white">

    <section class="min-h-screen px-4 md:px-8 py-16">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center space-x-4 mb-8">
                <a href="../index.php#galeria" class="text-gray-700 hover:text-rosa-vibrante transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                </a>
                <h1 class="text-3xl md:text-4xl font-normal text-rosa-vibrante">Galeria de Casamento</h1>
            </div>

            <p class="text-lg text-gray-600 mb-12">
                Momentos mágicos capturados em nosso espaço.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php if (empty($imagens)): ?>
                    <p class="text-gray-500 col-span-full">Em breve, novas fotos nesta galeria!</p>
                <?php else: ?>
                    <?php foreach ($imagens as $img): ?>
                        <div class="overflow-hidden rounded-xl shadow-lg">
                             <img src="uploads/galeria/<?= htmlspecialchars($img['caminho_arquivo']) ?>" 
                                 alt="<?= htmlspecialchars($img['titulo']) ?>" 
                                 class="w-full h-64 object-cover hover:scale-110 transition-transform duration-300">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include_once ("footer.php")?>
</body>
</html>