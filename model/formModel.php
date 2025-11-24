<?php
require_once '../model/conexaoModel.php';

class formModel {
    private $pdo;

    public function __construct(){
        $conexao = new conexaoDb();
        $this->pdo = $conexao->conectar();
    }

    // Agora aceita userId (padrão null para visitantes não logados)
    public function inserir($nome, $telefone, $email, $tipoCerimonia, $dataPref, $qtdConvidados, $mensagemCerimonia, $userId = null){
        try {
            $stmtInfo = $this->pdo->prepare("
                INSERT INTO info (nomeUsuario, telefoneUsuario, emailUsuario, tipoCerimonia, dataPref, qtdConvidados, mensagemCerimonia, user_id) 
                VALUES (:nome, :telefone, :email, :tipoCerimonia, :dataPref, :qtdConvidados, :mensagemCerimonia, :userId)
            ");
            $stmtInfo->bindParam(':nome', $nome);
            $stmtInfo->bindParam(':telefone', $telefone);
            $stmtInfo->bindParam(':email', $email);
            $stmtInfo->bindParam(':tipoCerimonia', $tipoCerimonia);
            $stmtInfo->bindParam(':dataPref', $dataPref);
            $stmtInfo->bindParam(':qtdConvidados', $qtdConvidados, PDO::PARAM_INT);
            $stmtInfo->bindParam(':mensagemCerimonia', $mensagemCerimonia);
            
            // Bind correto para user_id (pode ser null)
            if ($userId === null) {
                $stmtInfo->bindValue(':userId', null, PDO::PARAM_NULL);
            } else {
                $stmtInfo->bindValue(':userId', $userId, PDO::PARAM_INT);
            }
            
            $stmtInfo->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Erro ao inserir: " . $e->getMessage());
            return false;
        }
    }

    public function listar() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM info ORDER BY idUsuario DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro listar: " . $e->getMessage());
            return [];
        }
    }

    // Lista apenas as solicitações de um usuário específico
    public function listarPorUsuario($userId) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM info WHERE user_id = :id ORDER BY idUsuario DESC");
            $stmt->execute([':id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function excluir($idUsuario) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM info WHERE idUsuario = :id");
            return $stmt->execute([':id' => $idUsuario]);
        } catch (PDOException $e) {
            error_log("Erro excluir: " . $e->getMessage());
            return false;
        }
    }
}
?>