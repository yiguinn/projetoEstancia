<?php
// Busca as imagens dinamicamente do Banco de Dados
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-white font-['SF_Pro_Display',_sans_serif]">

    <?php include_once ("header.php")?>

    <section class="min-h-screen px-4 md:px-8 py-16">
        <div class="max-w-7xl mx-auto">
            
            <div class="flex items-center space-x-4 mb-8">
                <a href="../index.php#galeria" class="text-gray-700 hover:text-rosa-vibrante transition-colors" title="Voltar para a Home">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                </a>
                <h1 class="text-3xl md:text-4xl font-normal text-rosa-vibrante">Galeria de Casamento</h1>
            </div>

            <p class="text-lg text-gray-600 mb-12">
                Momentos mágicos capturados em nosso espaço. Clique nas fotos para ampliar.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php if (empty($imagens)): ?>
                    <div class="col-span-full text-center py-12 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                        <i class="fas fa-images fa-3x text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Em breve, novas fotos nesta galeria!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($imagens as $img): ?>
                        <div class="overflow-hidden rounded-xl shadow-lg bg-gray-100 relative group">
                             
                             <img src="uploads/galeria/<?= htmlspecialchars($img['caminho_arquivo']) ?>" 
                                  alt="<?= htmlspecialchars($img['titulo']) ?>" 
                                  class="w-full h-64 object-cover hover:scale-110 transition-transform duration-500 cursor-pointer zoomable"
                                  loading="lazy">
                                  
                             <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                 <p class="text-white text-sm font-medium truncate"><?= htmlspecialchars($img['titulo']) ?></p>
                             </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include_once ("footer.php")?>
</body>
</html>