<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lógica Inteligente de Caminhos (Corrige o erro dos botões não clicarem)
// Se o arquivo atual estiver dentro de '/view/', usamos '../' para voltar.
// Se estiver na raiz (index.php), usamos './' ou 'view/'.
$isInViewFolder = strpos($_SERVER['SCRIPT_NAME'], '/view/') !== false;

$pathRoot = $isInViewFolder ? '../' : './';
$pathView = $isInViewFolder ? './' : 'view/';
$pathController = $isInViewFolder ? '../controller/' : 'controller/';
$pathUploads = $isInViewFolder ? '../view/uploads/' : 'view/uploads/'; // Caminho para exibir imagens

$is_logged_in = isset($_SESSION['user_id']);
$is_admin = $is_logged_in && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estancia Ilha da Madeira</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $pathView ?>style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="icon" type="image/png" href="<?= $pathView ?>imagens/logo.png">
</head>
<body class="min-h-screen">
    <header class="w-full bg-white border-b border-gray-100 px-4 md:px-8 py-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between relative">

            <button id="accessibility-toggle" class="absolute left-0 top-1/2 -translate-y-1/2 p-3 text-gray-600 hover:text-rosa-vibrante">
                <i class="fas fa-universal-access fa-xl"></i>
            </button>

            <a href="<?= $pathRoot ?>index.php" class="flex items-center space-x-3 pl-12">
                <img src="<?= $pathView ?>imagens/logo.png" width="50" alt="Logo">
                <div>
                    <h1 class="text-xl font-medium text-rosa-vibrante">Estância</h1>
                    <p class="text-sm text-gray-600 -mt-1">Ilha da Madeira</p>
                </div>
            </a>

            <nav class="hidden md:flex items-center space-x-8">
                <a href="<?= $pathRoot ?>index.php#inicio" class="nav-link text-gray-700 hover:text-rosa-vibrante">Início</a> 
                <a href="<?= $pathRoot ?>index.php#servicos" class="nav-link text-gray-700 hover:text-rosa-vibrante">Serviços</a> 
                <a href="<?= $pathRoot ?>index.php#galeria" class="nav-link text-gray-700 hover:text-rosa-vibrante">Galeria</a> 
                
                <?php if ($is_admin): ?>
                    <a href="<?= $pathView ?>painelAdmin.php" class="nav-link font-bold text-blue-600 hover:text-blue-800">Painel Admin</a> 
                <?php endif; ?>
            </nav>

            <div class="hidden md:flex items-center space-x-4">
                <?php if ($is_logged_in): 
                    // Lógica do Avatar
                    $avatarFile = isset($_SESSION['user_avatar']) && !empty($_SESSION['user_avatar']) 
                        ? $_SESSION['user_avatar'] 
                        : null;
                    
                    $avatarUrl = $avatarFile 
                        ? $pathView . 'uploads/avatars/' . $avatarFile 
                        : "https://ui-avatars.com/api/?name=" . urlencode($_SESSION['user_nome']) . "&background=C53366&color=fff";
                ?>
                    
                    <div class="relative group">
                        <button class="flex items-center space-x-2 focus:outline-none py-2">
                            <span class="text-sm font-medium text-gray-700"><?= htmlspecialchars($_SESSION['user_nome']) ?></span>
                            <img src="<?= $avatarUrl ?>" alt="Avatar" class="w-9 h-9 rounded-full object-cover border border-gray-200">
                            <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform group-hover:rotate-180"></i>
                        </button>

                        <div class="absolute right-0 mt-0 w-56 bg-white rounded-md shadow-xl py-2 z-50 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 border border-gray-100 transform origin-top-right">
                            <div class="px-4 py-2 border-b border-gray-50">
                                <p class="text-xs text-gray-500">Logado como</p>
                                <p class="text-sm font-bold text-gray-800 truncate"><?= htmlspecialchars($_SESSION['user_email']) ?></p>
                            </div>
                            
                            <a href="<?= $pathView ?>perfil.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-rosa-suave hover:text-rosa-vibrante transition-colors">
                                <i class="fas fa-user-circle mr-2 w-4 text-center"></i> Meu Perfil
                            </a>
                            
                            <div class="border-t border-gray-100 my-1"></div>
                            
                            <a href="<?= $pathController ?>authController.php?action=logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2 w-4 text-center"></i> Sair
                            </a>
                        </div>
                    </div>

                <?php else: ?>
                    <a href="<?= $pathView ?>login.php" class="text-gray-700 hover:text-rosa-vibrante text-sm">Login</a>
                    <a href="<?= $pathView ?>cadastro.php" class="bg-rosa-vibrante hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm">
                        Cadastre-se
                    </a>
                <?php endif; ?>
            </div>
            
            <button id="mobile-menu-btn" class="md:hidden text-gray-700">
                <i class="fas fa-bars fa-lg"></i>
            </button>
        </div>
    </header>
    
    ```

**Importante:** Como atualizei o header para ser inteligente, você deve usar este mesmo código dentro de `headerIndex.php` também (ou simplesmente deletar o `headerIndex.php` e fazer o `index.php` incluir `view/header.php`).

---

### 2. `model/userModel.php` (Adicionado Troca de Email)

```php
<?php
// model/userModel.php
require_once __DIR__ . '/conexaoModel.php';

class UserModel {
    private $pdo;

    public function __construct() {
        $this->pdo = (new conexaoDb())->conectar();
    }

    // --- AUTENTICAÇÃO E CADASTRO ---
    public function cadastrar($nome, $email, $telefone, $password) {
        if ($this->emailExiste($email)) {
            return false; 
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (nome, email, telefone, password) VALUES (:nome, :email, :telefone, :password)");
        return $stmt->execute([':nome' => $nome, ':email' => $email, ':telefone' => $telefone, ':password' => $hashedPassword]);
    }

    public function buscarPorEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- FUNÇÕES DE PERFIL (USUÁRIO) ---

    public function atualizarDados($id, $nome, $telefone) {
        $stmt = $this->pdo->prepare("UPDATE users SET nome = :nome, telefone = :telefone WHERE id = :id");
        return $stmt->execute([':nome' => $nome, ':telefone' => $telefone, ':id' => $id]);
    }

    public function atualizarAvatar($id, $nomeArquivo) {
        $stmt = $this->pdo->prepare("UPDATE users SET avatar = :avatar WHERE id = :id");
        return $stmt->execute([':avatar' => $nomeArquivo, ':id' => $id]);
    }

    // NOVO: Atualizar Email
    public function atualizarEmail($id, $novoEmail) {
        // Verifica se o email já é usado por OUTRO usuário
        $stmtCheck = $this->pdo->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
        $stmtCheck->execute([':email' => $novoEmail, ':id' => $id]);
        if ($stmtCheck->fetch()) {
            return false; // Email já existe
        }

        $stmt = $this->pdo->prepare("UPDATE users SET email = :email WHERE id = :id");
        return $stmt->execute([':email' => $novoEmail, ':id' => $id]);
    }

    // Funções de Senha
    public function verificarSenha($id, $senhaDigitada) {
        $stmt = $this->pdo->prepare("SELECT password FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($user && password_verify($senhaDigitada, $user['password']));
    }

    public function atualizarSenha($id, $novaSenha) {
        $hash = password_hash($novaSenha, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE users SET password = :senha WHERE id = :id");
        return $stmt->execute([':senha' => $hash, ':id' => $id]);
    }

    // --- FUNÇÕES ADMINISTRATIVAS ---
    public function listarTodos() {
        $stmt = $this->pdo->query("SELECT id, nome, email, telefone, role, created_at FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluir($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function alterarRole($id, $novoRole) {
        $stmt = $this->pdo->prepare("UPDATE users SET role = :role WHERE id = :id");
        return $stmt->execute([':role' => $novoRole, ':id' => $id]);
    }

    // Auxiliar privado
    private function emailExiste($email) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }
}
?>