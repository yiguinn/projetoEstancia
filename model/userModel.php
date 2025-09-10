<?php
// model/userModel.php
require_once __DIR__ . '/conexaoModel.php';

class UserModel {
    private $pdo;

    public function __construct() {
        $this->pdo = (new conexaoDb())->conectar();
    }

    /**
     * Cadastra um novo usuário. O cargo padrão é 'user'.
     */
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

    /**
     * Busca um usuário pelo email para o processo de login.
     */
    public function buscarPorEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>