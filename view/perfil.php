<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Verifica login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once __DIR__ . '/../model/userModel.php';
require_once __DIR__ . '/../model/formModel.php';

$userModel = new UserModel();
$formModel = new formModel();

// Busca dados atualizados do banco
$user = $userModel->buscarPorId($_SESSION['user_id']);
$minhasSolicitacoes = $formModel->listarPorUsuario($_SESSION['user_id']);

// Lógica para exibir o avatar (caminho local ou gerador automático)
$avatarPath = !empty($user['avatar']) ? "uploads/avatars/" . $user['avatar'] : "https://ui-avatars.com/api/?name=" . urlencode($user['nome']) . "&background=C53366&color=fff";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil - Estância</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-['SF_Pro_Display',_sans_serif]">

<?php include 'header.php'; ?>

<main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="md:col-span-1 space-y-6">
            
            <div class="bg-white p-6 rounded-lg shadow text-center relative">
                <div class="relative inline-block group">
                    <img src="<?= $avatarPath ?>" alt="Foto de Perfil" class="w-32 h-32 rounded-full object-cover border-4 border-gray-100 mx-auto">
                    
                    <label for="avatarInput" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                        <i class="fas fa-camera mr-2"></i> Alterar
                    </label>
                </div>
                
                <form action="../controller/profileController.php" method="POST" enctype="multipart/form-data" id="avatarForm">
                    <input type="file" name="avatar" id="avatarInput" class="hidden" accept="image/*" onchange="document.getElementById('avatarForm').submit()">
                    <input type="hidden" name="upload_avatar" value="1">
                </form>

                <h2 class="mt-4 text-xl font-bold text-gray-800"><?= htmlspecialchars($user['nome']) ?></h2>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($user['email']) ?></p>
                
                <div class="mt-3">
                    <?php if($user['role'] === 'admin'): ?>
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold uppercase">Administrador</span>
                    <?php else: ?>
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold uppercase">Cliente</span>
                    <?php endif; ?>
                </div>

                <?php if (isset($_GET['status'])): ?>
                    <div class="mt-4 text-xs p-2 rounded font-medium
                        <?php echo strpos($_GET['status'], 'erro') !== false ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'; ?>">
                        <?php
                            switch($_GET['status']) {
                                case 'sucesso_dados': echo "Dados pessoais atualizados!"; break;
                                case 'sucesso_avatar': echo "Foto de perfil atualizada!"; break;
                                case 'sucesso_senha': echo "Senha alterada com sucesso!"; break;
                                case 'sucesso_delete': echo "Solicitação cancelada."; break;
                                case 'erro_senha_atual': echo "A senha atual está incorreta."; break;
                                case 'erro_senha_diferente': echo "As novas senhas não conferem."; break;
                                case 'erro_senha_fraca': echo "A nova senha é muito fraca."; break;
                                case 'erro_formato': echo "Formato de imagem inválido."; break;
                                default: echo "Operação concluída."; 
                            }
                        ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold text-gray-800 mb-4 border-b pb-2">Meus Dados</h3>
                <form action="../controller/profileController.php" method="POST" class="space-y-4">
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-bold">Nome Completo</label>
                        <input type="text" name="nome" value="<?= htmlspecialchars($user['nome']) ?>" class="w-full border p-2 rounded focus:border-rosa-vibrante outline-none text-sm">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-bold">Telefone</label>
                        <input type="text" name="telefone" id="telefone" value="<?= htmlspecialchars($user['telefone']) ?>" class="w-full border p-2 rounded focus:border-rosa-vibrante outline-none text-sm">
                    </div>
                    <button type="submit" name="update_profile" class="w-full bg-rosa-vibrante text-white py-2 rounded hover:opacity-90 transition text-sm font-medium">Salvar Alterações</button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-400">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-lock mr-2 text-yellow-500"></i> Segurança
                </h3>
                <form action="../controller/profileController.php" method="POST" class="space-y-3">
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-bold">Senha Atual</label>
                        <input type="password" name="senha_atual" required class="w-full border p-2 rounded text-sm focus:border-yellow-400 outline-none">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-bold">Nova Senha</label>
                        <input type="password" name="nova_senha" required class="w-full border p-2 rounded text-sm focus:border-yellow-400 outline-none" placeholder="Mín. 8 caracteres">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase font-bold">Confirmar Nova Senha</label>
                        <input type="password" name="confirma_senha" required class="w-full border p-2 rounded text-sm focus:border-yellow-400 outline-none">
                    </div>
                    <button type="submit" name="update_password" class="w-full bg-gray-800 text-white py-2 rounded hover:bg-black transition text-sm font-medium">
                        Alterar Senha
                    </button>
                </form>
            </div>

        </div>

        <div class="md:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow h-full">
                <h3 class="font-semibold text-gray-800 mb-6 flex items-center text-lg">
                    <i class="fas fa-history text-rosa-vibrante mr-2"></i> Histórico de Solicitações
                </h3>

                <?php if(empty($minhasSolicitacoes)): ?>
                    <div class="text-center py-12 text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                        <i class="far fa-folder-open fa-3x mb-3 text-gray-300"></i>
                        <p class="text-lg font-medium">Nenhuma solicitação encontrada</p>
                        <p class="text-sm mb-4">Você ainda não pediu nenhum orçamento.</p>
                        <a href="../#contato" class="text-white bg-rosa-vibrante px-4 py-2 rounded hover:opacity-90 inline-block transition">Fazer solicitação</a>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach($minhasSolicitacoes as $req): ?>
                            <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow bg-white flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-3">
                                        <span class="font-bold text-gray-800 text-lg capitalize"><?= htmlspecialchars($req['tipoCerimonia']) ?></span>
                                        <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full font-medium border border-yellow-200">Enviado</span>
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        <i class="far fa-calendar-alt mr-1"></i> Data Preferencial: <span class="text-gray-700 font-medium"><?= date('d/m/Y', strtotime($req['dataPref'])) ?></span>
                                        <span class="mx-2 text-gray-300">|</span>
                                        <i class="fas fa-users mr-1"></i> <?= $req['qtdConvidados'] ?> convidados
                                    </p>
                                    <?php if(!empty($req['mensagemCerimonia'])): ?>
                                        <div class="mt-2 text-sm text-gray-600 bg-gray-50 p-2 rounded border border-gray-100 italic">
                                            "<?= substr(htmlspecialchars($req['mensagemCerimonia']), 0, 100) ?><?= strlen($req['mensagemCerimonia']) > 100 ? '...' : '' ?>"
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <form action="../controller/profileController.php" method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar esta solicitação?');" class="mt-4 sm:mt-0">
                                    <input type="hidden" name="request_id" value="<?= $req['idUsuario'] ?>">
                                    <button type="submit" name="delete_request" class="text-red-500 hover:text-white border border-red-200 hover:bg-red-500 text-sm font-medium px-4 py-2 rounded transition flex items-center">
                                        <i class="fas fa-trash-alt mr-2"></i> Cancelar
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</main>

<script src="telefone.js"></script>
</body>
</html>