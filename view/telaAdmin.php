<?php
// view/telaAdmin.php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php?status=acesso_negado');
    exit();
}
require_once __DIR__ . '/../model/formModel.php';
$model = new formModel();
$registros = $model->listar();

// --- CONFIGURAÇÃO DO SUPER ADMIN ---
$superAdminEmail = 'Mi15sud@gmail.com';
$isSuperAdmin = (isset($_SESSION['user_email']) && trim($_SESSION['user_email']) === $superAdminEmail);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Solicitações de Contato - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-['SF_Pro_Display',_sans_serif]">

<header class="bg-white shadow-sm mb-6">
    <div class="max-w-7xl mx-auto py-4 px-4 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Solicitações Recebidas</h1>
            <?php if ($isSuperAdmin): ?>
                 <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Modo Exclusão Ativo</span>
            <?php endif; ?>
        </div>
        <a href="painelAdmin.php" class="text-blue-600 hover:underline">&larr; Voltar ao Painel</a>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 pb-12">
    
    <?php if (isset($_GET['status']) && $_GET['status'] === 'erro_perm'): ?>
        <div class="mb-4 p-4 rounded-md bg-red-100 text-red-800 border-l-4 border-red-500">
            Apenas o Super Admin pode excluir solicitações.
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-3 font-semibold text-gray-600">ID</th>
                    <th class="p-3 font-semibold text-gray-600">Nome</th>
                    <th class="p-3 font-semibold text-gray-600">Contato</th>
                    <th class="p-3 font-semibold text-gray-600">Evento/Data</th>
                    <th class="p-3 font-semibold text-gray-600">Qtd.</th>
                    <th class="p-3 font-semibold text-gray-600 w-1/3">Mensagem</th>
                    <?php if ($isSuperAdmin): ?>
                        <th class="p-3 font-semibold text-gray-600">Ação</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($registros)): ?>
                    <?php foreach ($registros as $r): ?>
                        <tr class="border-b hover:bg-gray-50 align-top">
                            <td class="p-3 text-gray-500">#<?= htmlspecialchars($r['idUsuario']) ?></td>
                            <td class="p-3 font-medium"><?= htmlspecialchars($r['nomeUsuario']) ?></td>
                            <td class="p-3 text-sm">
                                <div><?= htmlspecialchars($r['telefoneUsuario']) ?></div>
                                <div class="text-gray-500"><?= htmlspecialchars($r['emailUsuario']) ?></div>
                            </td>
                            <td class="p-3 text-sm">
                                <div class="font-medium capitalize"><?= htmlspecialchars($r['tipoCerimonia']) ?></div>
                                <div class="text-gray-500"><?= htmlspecialchars(date('d/m/Y', strtotime($r['dataPref']))) ?></div>
                            </td>
                            <td class="p-3"><?= htmlspecialchars($r['qtdConvidados']) ?></td>
                            <td class="p-3 text-sm text-gray-600 italic">
                                "<?= nl2br(htmlspecialchars($r['mensagemCerimonia'])) ?>"
                            </td>
                            
                            <?php if ($isSuperAdmin): ?>
                                <td class="p-3">
                                    <form method="POST" action="../controller/adminController.php" onsubmit="return confirm('Apagar esta solicitação permanentemente?');">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($r['idUsuario']) ?>">
                                        <button type="submit" name="delete" class="text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded transition" title="Excluir">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            <?php endif; ?>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= $isSuperAdmin ? 7 : 6 ?>" class="p-8 text-center text-gray-500">Nenhuma solicitação encontrada no momento.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>