<?php
// Proteção e inicialização
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php?status=acesso_negado');
    exit();
}

require_once __DIR__ . '/../model/parceiroModel.php';
$model = new ParceiroModel();

// Pega a chave do parceiro da URL (ex: ?parceiro=dj)
$parceiro_chave = $_GET['parceiro'] ?? null;
$parceiro_dados = null;
$imagens = [];

if ($parceiro_chave) {
    // Se um parceiro foi selecionado, busca seus dados e imagens
    $parceiro_dados = $model->buscarPorChave($parceiro_chave);
    if ($parceiro_dados) {
        // O "false" aqui é para buscar TODAS as imagens (visíveis e ocultas) para o painel de admin
        $imagens = $model->listarImagens($parceiro_dados['id'], false);
    }
}

// Lógica para exibir mensagens de status
$status = $_GET['status'] ?? '';
$messages = [
    'sucesso_texto' => ['tipo' => 'sucesso', 'texto' => 'Informações do parceiro salvas com sucesso!'],
    'sucesso_add_img' => ['tipo' => 'sucesso', 'texto' => 'Nova imagem adicionada com sucesso!'],
    'sucesso_delete_img' => ['tipo' => 'sucesso', 'texto' => 'Imagem excluída com sucesso!'],
    'sucesso_toggle' => ['tipo' => 'sucesso', 'texto' => 'Visibilidade da imagem alterada com sucesso!'],
    'erro_db' => ['tipo' => 'erro', 'texto' => 'Ocorreu um erro ao comunicar com o banco de dados.'],
    'erro_campos' => ['tipo' => 'erro', 'texto' => 'Por favor, preencha todos os campos obrigatórios.'],
    'erro_upload' => ['tipo' => 'erro', 'texto' => 'Ocorreu um erro durante o upload da imagem.'],
    'erro_extensao' => ['tipo' => 'erro', 'texto' => 'Tipo de arquivo não permitido.'],
];
$message = $messages[$status] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Serviços Parceiros</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100 pb-16">

    <header class="bg-white shadow-sm mb-8">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Gerenciar Serviços Parceiros</h1>
            <a href="painelAdmin.php" class="text-sm text-blue-600 hover:underline">&larr; Voltar ao Painel</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?php if ($message): ?>
            <div class="p-4 rounded-md mb-6 <?= $message['tipo'] === 'sucesso' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= htmlspecialchars($message['texto']) ?>
            </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <label for="parceiro_select" class="block text-lg font-medium text-gray-700">Selecione o parceiro para editar:</label>
            <select id="parceiro_select" onchange="if(this.value) window.location.href = this.value" class="mt-2 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-rosa-vibrante focus:border-rosa-vibrante sm:text-sm rounded-md">
                <option value="gerenciarParceiros.php">-- Escolha um serviço --</option>
                <option value="gerenciarParceiros.php?parceiro=fotografo" <?= $parceiro_chave === 'fotografo' ? 'selected' : '' ?>>Fotografia</option>
                <option value="gerenciarParceiros.php?parceiro=dj" <?= $parceiro_chave === 'dj' ? 'selected' : '' ?>>Som & DJ</option>
                <option value="gerenciarParceiros.php?parceiro=bartender" <?= $parceiro_chave === 'bartender' ? 'selected' : '' ?>>Serviço de Bar</option>
                <option value="gerenciarParceiros.php?parceiro=cerimonialista" <?= $parceiro_chave === 'cerimonialista' ? 'selected' : '' ?>>Cerimonialista</option>
            </select>
        </div>

        <?php if ($parceiro_dados): ?>
            <div class="space-y-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Editar Informações de <span class="text-rosa-vibrante"><?= ucfirst($parceiro_chave) ?></span></h2>
                    <form action="../controller/parceiroController.php" method="POST" class="space-y-4">
                        <input type="hidden" name="parceiro_chave" value="<?= $parceiro_chave ?>">
                        <div>
                            <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                            <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($parceiro_dados['titulo']) ?>" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                        </div>
                        <div>
                            <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea name="descricao" id="descricao" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-md p-2"><?= htmlspecialchars($parceiro_dados['descricao']) ?></textarea>
                        </div>
                        <button type="submit" name="update_parceiro" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Salvar Textos</button>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Gerenciar Imagens de <span class="text-rosa-vibrante"><?= ucfirst($parceiro_chave) ?></span></h2>
                    
                    <form action="../controller/parceiroController.php" method="POST" enctype="multipart/form-data" class="space-y-4 mb-8 border-b pb-8">
                        <input type="hidden" name="parceiro_chave" value="<?= $parceiro_chave ?>">
                        <input type="hidden" name="parceiro_id" value="<?= $parceiro_dados['id'] ?>">
                        <div>
                            <label for="titulo_alt" class="block text-sm font-medium text-gray-700">Título da Imagem (texto alternativo)</label>
                            <input type="text" name="titulo_alt" id="titulo_alt" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Arquivo da Imagem</label>
                            <label for="imagem" class="cursor-pointer mt-1 inline-block bg-rosa-vibrante text-white px-4 py-2 rounded-md hover:opacity-90">Escolher arquivo</label>
                            <input type="file" name="imagem" id="imagem" required accept="image/*" class="hidden">
                            <span id="file-name" class="ml-3 text-sm text-gray-500"></span>
                        </div>
                        <button type="submit" name="add_image" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Enviar Imagem</button>
                    </form>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                        <?php if (empty($imagens)): ?>
                            <p class="text-gray-500 col-span-full">Nenhuma imagem encontrada para este parceiro.</p>
                        <?php else: ?>
                            <?php foreach ($imagens as $img): ?>
                                <div class="relative group <?= $img['visivel'] ? '' : 'opacity-40' ?>">
                                    <img src="../view/uploads/parceiros/<?= htmlspecialchars($img['caminho_arquivo']) ?>" alt="<?= htmlspecialchars($img['titulo_alt']) ?>" class="w-full h-40 object-cover rounded-md">
                                    <span class="absolute top-2 left-2 text-xs font-bold text-white px-2 py-1 rounded-full <?= $img['visivel'] ? 'bg-green-600' : 'bg-gray-700' ?>"><?= $img['visivel'] ? 'Visível' : 'Oculto' ?></span>
                                    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <form action="../controller/parceiroController.php" method="POST">
                                            <input type="hidden" name="parceiro_chave" value="<?= $parceiro_chave ?>">
                                            <input type="hidden" name="imagem_id" value="<?= $img['id'] ?>">
                                            <input type="hidden" name="status_atual" value="<?= $img['visivel'] ?>">
                                            <button type="submit" name="toggle_visibility" class="text-white text-sm px-3 py-1 rounded-md <?= $img['visivel'] ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' ?>"><?= $img['visivel'] ? 'Ocultar' : 'Mostrar' ?></button>
                                        </form>
                                        <form action="../controller/parceiroController.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta imagem PERMANENTEMENTE?');">
                                            <input type="hidden" name="parceiro_chave" value="<?= $parceiro_chave ?>">
                                            <input type="hidden" name="imagem_id" value="<?= $img['id'] ?>">
                                            <button type="submit" name="delete_image" class="text-white text-sm bg-red-600 px-3 py-1 rounded-md hover:bg-red-700">Excluir</button>
                                        </form>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1 truncate" title="<?= htmlspecialchars($img['titulo_alt']) ?>"><?= htmlspecialchars($img['titulo_alt']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <script>
        // Script para mostrar o nome do arquivo selecionado no input de upload
        const fileInput = document.getElementById('imagem');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const fileNameSpan = document.getElementById('file-name');
                fileNameSpan.textContent = this.files[0] ? this.files[0].name : "";
            });
        }
    </script>
</body>
</html>