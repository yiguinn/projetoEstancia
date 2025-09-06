<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Estância Ilha da Madeira</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-white font-['SF_Pro_Display',_sans_serif]">

    <header class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <h1 class="text-xl font-medium text-rosa-vibrante">Painel Administrativo</h1>
                <span class="text-sm text-gray-500">- Estância Ilha da Madeira</span>
            </div>
            <a href="../view/index.php" class="text-sm text-rosa-vibrante hover:underline">
                Voltar ao Site
            </a>
        </div>
    </header>

    <?php
    require_once __DIR__ . '/../model/formModel.php';
    $model = new formModel();
    $registros = $model->listar();
    ?>

    <main class="max-w-7xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Admin - Solicitações</h1>

        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-2 py-1 text-left">ID</th>
                        <th class="border px-2 py-1 text-left">Nome</th>
                        <th class="border px-2 py-1 text-left">Telefone</th>
                        <th class="border px-2 py-1 text-left">Email</th>
                        <th class="border px-2 py-1 text-left">Evento</th>
                        <th class="border px-2 py-1 text-left">Data Pref.</th>
                        <th class="border px-2 py-1 text-left">Convidados</th>
                        <th class="border px-2 py-1 text-left">Mensagem</th>
                        <th class="border px-2 py-1 text-left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($registros)): ?>
                        <?php foreach ($registros as $r): ?>
                            <tr>
                                <td class="border px-2 py-1"><?= htmlspecialchars($r['idUsuario']) ?></td>
                                <td class="border px-2 py-1"><?= htmlspecialchars($r['nomeUsuario']) ?></td>
                                <td class="border px-2 py-1"><?= htmlspecialchars($r['telefoneUsuario']) ?></td>
                                <td class="border px-2 py-1"><?= htmlspecialchars($r['emailUsuario']) ?></td>
                                <td class="border px-2 py-1"><?= htmlspecialchars($r['tipoCerimonia']) ?></td>
                                <td class="border px-2 py-1"><?= htmlspecialchars($r['dataPref']) ?></td>
                                <td class="border px-2 py-1"><?= htmlspecialchars($r['qtdConvidados']) ?></td>
                                <td class="border px-2 py-1"><?= htmlspecialchars($r['mensagemCerimonia']) ?></td>
                                <td class="border px-2 py-1">

                                    <!-- Editar (abre modal) -->
                                    <button
                                        class="bg-blue-600 text-white px-2 py-1 rounded edit-btn"
                                        data-id="<?= htmlspecialchars($r['idUsuario']) ?>"
                                        data-nome="<?= htmlspecialchars($r['nomeUsuario'], ENT_QUOTES) ?>"
                                        data-telefone="<?= htmlspecialchars($r['telefoneUsuario'], ENT_QUOTES) ?>"
                                        data-email="<?= htmlspecialchars($r['emailUsuario'], ENT_QUOTES) ?>"
                                        data-evento="<?= htmlspecialchars($r['tipoCerimonia'], ENT_QUOTES) ?>"
                                        data-data="<?= htmlspecialchars($r['dataPref'], ENT_QUOTES) ?>"
                                        data-convidados="<?= htmlspecialchars($r['qtdConvidados'], ENT_QUOTES) ?>"
                                        data-mensagem="<?= htmlspecialchars($r['mensagemCerimonia'], ENT_QUOTES) ?>">Editar</button>

                                    <!-- Excluir (form POST) -->
                                    <form method="POST" action="../controller/adminController.php" style="display:inline">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($r['idUsuario']) ?>">
                                        <button type="submit" name="delete" class="bg-red-600 text-white px-2 py-1 rounded">Excluir</button>
                                    </form>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-gray-500">Nenhuma solicitação encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal de edição -->
    <div id="edit-modal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-[9999]">
        <div class="bg-white p-6 rounded shadow-xl w-full max-w-2xl">
            <h2 class="text-xl font-semibold mb-4">Editar Solicitação</h2>
            <form method="POST" action="../controller/adminController.php" id="edit-form" class="space-y-3">
                <input type="hidden" name="id" id="edit-id">

                <label class="block">
                    <span class="text-sm">Nome</span>
                    <input type="text" name="nometxt" id="edit-nome" class="border p-2 w-full">
                </label>

                <label class="block">
                    <span class="text-sm">Telefone</span>
                    <input type="text" name="telefonenum" id="edit-telefone" class="border p-2 w-full">
                </label>

                <label class="block">
                    <span class="text-sm">E-mail</span>
                    <input type="email" name="emailtxt" id="edit-email" class="border p-2 w-full">
                </label>

                <label class="block">
                    <span class="text-sm">Tipo de Cerimônia</span>
                    <input type="text" name="eventotxt" id="edit-evento" class="border p-2 w-full">
                </label>

                <label class="block">
                    <span class="text-sm">Data Preferencial</span>
                    <input type="date" name="data_preferencial" id="edit-data" class="border p-2 w-full">
                </label>

                <label class="block">
                    <span class="text-sm">Número de Convidados</span>
                    <input type="number" name="numero_convidados" id="edit-convidados" class="border p-2 w-full">
                </label>

                <label class="block">
                    <span class="text-sm">Mensagem</span>
                    <textarea name="mensagemtxt" id="edit-mensagem" class="border p-2 w-full" rows="4"></textarea>
                </label>

                <div class="flex items-center justify-end">
                    <button type="button" onclick="fecharModal()" class="mr-2 bg-gray-600 text-white px-4 py-2 rounded">Cancelar</button>
                    <button type="submit" name="update" class="bg-green-600 text-white px-4 py-2 rounded">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Abre modal preenchendo campos a partir dos data-attributes
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const ds = this.dataset;
                    document.getElementById('edit-id').value = ds.id || '';
                    document.getElementById('edit-nome').value = ds.nome || '';
                    document.getElementById('edit-telefone').value = ds.telefone || '';
                    document.getElementById('edit-email').value = ds.email || '';
                    document.getElementById('edit-evento').value = ds.evento || '';
                    document.getElementById('edit-data').value = ds.data || '';
                    document.getElementById('edit-convidados').value = ds.convidados || '';
                    document.getElementById('edit-mensagem').value = ds.mensagem || '';
                    document.getElementById('edit-modal').classList.remove('hidden');
                });
            });
        });

        function fecharModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }
    </script>

</body>

</html>