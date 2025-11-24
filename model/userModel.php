<?php
// model/userModel.php
require_once __DIR__ . '/conexaoModel.php';

class UserModel {
    private $pdo;

    public function __construct() {
        $this->pdo = (new conexaoDb())->conectar();
    }

    // --- Métodos Existentes ---
    public function cadastrar($nome, $email, $telefone, $password) {
        $stmtCheck = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmtCheck->execute([':email' => $email]);
        if ($stmtCheck->fetch()) {
            return false; 
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

    // --- NOVOS MÉTODOS PARA O ADMIN ---

    // 1. Listar todos os usuários (exceto o próprio, opcionalmente, mas vamos listar todos)
    public function listarTodos() {
        $stmt = $this->pdo->query("SELECT id, nome, email, telefone, role, created_at FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Excluir usuário pelo ID
    public function excluir($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // 3. Alternar cargo (Promover a Admin ou Rebaixar a User)
    public function alterarRole($id, $novoRole) {
        $stmt = $this->pdo->prepare("UPDATE users SET role = :role WHERE id = :id");
        return $stmt->execute([':role' => $novoRole, ':id' => $id]);
    }
}
?>  