<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php?status=acesso_negado');
    exit();
}

require_once __DIR__ . '/../model/userModel.php';
$model = new UserModel();
$usuarios = $model->listarTodos();

// --- CONFIGURAÇÃO DO SUPER ADMIN ---
$superAdminEmail = 'Mi15sud@gmail.com'; 
$isSuperAdmin = (isset($_SESSION['user_email']) && trim($_SESSION['user_email']) === $superAdminEmail);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Usuários - Estância</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../view/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../view/imagens/logo.png">
    <link rel="apple-touch-icon" href="../view/imagens/logo.png">
</head>
<body class="bg-gray-100 font-['SF_Pro_Display',_sans_serif]">

<header class="bg-white shadow-sm mb-6">
    <div class="max-w-7xl mx-auto py-4 px-4 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Gerenciar Usuários</h1>
            <?php if(!$isSuperAdmin): ?>
                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Modo Visualização (Restrito)</span>
            <?php else: ?>
                <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">Modo Super Admin</span>
            <?php endif; ?>
        </div>
        <a href="painelAdmin.php" class="text-blue-600 hover:underline">&larr; Voltar ao Painel</a>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 pb-12">
    <?php if (isset($_GET['status'])): ?>
        <div class="mb-4 p-4 rounded-md shadow-sm <?php echo strpos($_GET['status'], 'erro') !== false ? 'bg-red-50 border-l-4 border-red-500 text-red-700' : 'bg-green-50 border-l-4 border-green-500 text-green-700'; ?>">
            <?php
                switch($_GET['status']) {
                    case 'erro_self': echo "Você não pode alterar sua própria conta."; break;
                    case 'erro_perm': echo "Acesso negado. Apenas o Super Admin pode realizar esta ação."; break;
                    case 'sucesso_delete': echo "Usuário excluído com sucesso."; break;
                    case 'sucesso_role': echo "Cargo atualizado com sucesso."; break;
                    default: echo "Ação realizada.";
                }
            ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="p-4 font-semibold text-gray-600 text-sm">ID</th>
                    <th class="p-4 font-semibold text-gray-600 text-sm">Usuário</th>
                    <th class="p-4 font-semibold text-gray-600 text-sm">Contato</th>
                    <th class="p-4 font-semibold text-gray-600 text-sm">Cargo</th>
                    <th class="p-4 font-semibold text-gray-600 text-sm">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($usuarios as $u): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-500 text-sm">#<?= $u['id'] ?></td>
                        <td class="p-4">
                            <div class="font-medium text-gray-900"><?= htmlspecialchars($u['nome']) ?></div>
                            <div class="text-xs text-gray-500">Cadastrado em: <?= date('d/m/Y', strtotime($u['created_at'])) ?></div>
                        </td>
                        <td class="p-4 text-sm">
                            <div class="text-gray-800"><?= htmlspecialchars($u['email']) ?></div>
                            <div class="text-gray-500"><?= htmlspecialchars($u['telefone']) ?></div>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-xs rounded-full font-bold border 
                                <?= $u['role'] === 'admin' ? 'bg-purple-50 text-purple-700 border-purple-200' : 'bg-gray-100 text-gray-600 border-gray-200' ?>">
                                <?= $u['role'] === 'admin' ? 'ADMINISTRADOR' : 'USUÁRIO' ?>
                            </span>
                        </td>
                        <td class="p-4 flex items-center space-x-3">
                            
                            <?php if ($isSuperAdmin && $u['id'] != $_SESSION['user_id']): ?>
                                
                                <form action="../controller/usuarioAdminController.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                    <input type="hidden" name="current_role" value="<?= $u['role'] ?>">
                                    <button type="submit" name="toggle_role" class="text-xs px-3 py-1.5 rounded border border-blue-200 bg-blue-50 text-blue-600 hover:bg-blue-100 transition font-medium" title="Alterar nível de acesso">
                                        <i class="fas fa-exchange-alt mr-1"></i> Mudar Cargo
                                    </button>
                                </form>

                                <form action="../controller/usuarioAdminController.php" method="POST" onsubmit="return confirm('ATENÇÃO: Isso excluirá o usuário permanentemente. Continuar?');">
                                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                    <button type="submit" name="delete_user" class="text-xs px-3 py-1.5 rounded border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 transition font-medium">
                                        <i class="fas fa-trash-alt mr-1"></i> Excluir
                                    </button>
                                </form>

                            <?php elseif ($u['id'] == $_SESSION['user_id']): ?>
                                <span class="text-xs text-gray-400 italic">Você</span>
                            <?php else: ?>
                                <span class="text-xs text-gray-400 italic"><i class="fas fa-lock"></i> Restrito</span>
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