<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php?status=acesso_negado');
    exit();
}

require_once __DIR__ . '/../model/userModel.php';
$model = new UserModel();
$usuarios = $model->listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Usuários - Estância</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-100 font-['SF_Pro_Display',_sans_serif]">

<header class="bg-white shadow-sm mb-6">
    <div class="max-w-7xl mx-auto py-4 px-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Gerenciar Usuários</h1>
        <a href="painelAdmin.php" class="text-blue-600 hover:underline">&larr; Voltar ao Painel</a>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4">

    <?php if (isset($_GET['status'])): ?>
        <div class="mb-4 p-4 rounded-md <?php echo strpos($_GET['status'], 'erro') !== false ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'; ?>">
            <?php
                switch($_GET['status']) {
                    case 'erro_self': echo "Você não pode excluir ou alterar sua própria conta."; break;
                    case 'sucesso_delete': echo "Usuário excluído com sucesso."; break;
                    case 'sucesso_role': echo "Cargo do usuário atualizado com sucesso."; break;
                    default: echo "Ação realizada.";
                }
            ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-4 font-semibold text-gray-600">ID</th>
                    <th class="p-4 font-semibold text-gray-600">Nome</th>
                    <th class="p-4 font-semibold text-gray-600">Email</th>
                    <th class="p-4 font-semibold text-gray-600">Telefone</th>
                    <th class="p-4 font-semibold text-gray-600">Cargo (Role)</th>
                    <th class="p-4 font-semibold text-gray-600">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 text-gray-500">#<?= $u['id'] ?></td>
                        <td class="p-4 font-medium"><?= htmlspecialchars($u['nome']) ?></td>
                        <td class="p-4"><?= htmlspecialchars($u['email']) ?></td>
                        <td class="p-4"><?= htmlspecialchars($u['telefone']) ?></td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-xs rounded-full font-bold 
                                <?= $u['role'] === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-200 text-gray-700' ?>">
                                <?= strtoupper($u['role']) ?>
                            </span>
                        </td>
                        <td class="p-4 flex space-x-2">
                            <?php if($u['id'] != $_SESSION['user_id']): ?>
                                <form action="../controller/usuarioAdminController.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                    <input type="hidden" name="current_role" value="<?= $u['role'] ?>">
                                    <button type="submit" name="toggle_role" class="text-sm px-3 py-1 rounded bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                                        <?= $u['role'] === 'admin' ? 'Tornar User' : 'Tornar Admin' ?>
                                    </button>
                                </form>

                                <form action="../controller/usuarioAdminController.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                    <button type="submit" name="delete_user" class="text-sm px-3 py-1 rounded bg-red-50 text-red-600 hover:bg-red-100 transition">
                                        Excluir
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-xs text-gray-400 italic">Você</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>