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
        $stmtCheck = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmtCheck->execute([':email' => $email]);
        if ($stmtCheck->fetch()) {
            return false; // Email já existe
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare(
            "INSERT INTO users (nome, email, telefone, password) VALUES (:nome, :email, :telefone, :password)"
        );
        return $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':telefone' => $telefone,
            ':password' => $hashedPassword
        ]);
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

    // Atualiza nome e telefone
    public function atualizarDados($id, $nome, $telefone) {
        $stmt = $this->pdo->prepare("UPDATE users SET nome = :nome, telefone = :telefone WHERE id = :id");
        return $stmt->execute([':nome' => $nome, ':telefone' => $telefone, ':id' => $id]);
    }

    // Atualiza apenas a foto (Avatar)
    public function atualizarAvatar($id, $nomeArquivo) {
        $stmt = $this->pdo->prepare("UPDATE users SET avatar = :avatar WHERE id = :id");
        return $stmt->execute([':avatar' => $nomeArquivo, ':id' => $id]);
    }

    // Verifica se a senha atual está correta (para troca de senha)
    public function verificarSenha($id, $senhaDigitada) {
        $stmt = $this->pdo->prepare("SELECT password FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            return password_verify($senhaDigitada, $user['password']);
        }
        return false;
    }

    // Salva a nova senha criptografada
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
}
?>