<?php
// model/formModel.php
require_once __DIR__ . '/conexaoModel.php';

class formModel {
    private $pdo;

    public function __construct(){
        $conexao = new conexaoDb();
        $this->pdo = $conexao->conectar();
    }

    // Método INSERIR corrigido para garantir gravação do ID
    public function inserir($nome, $telefone, $email, $tipoCerimonia, $dataPref, $qtdConvidados, $mensagemCerimonia, $userId = null){
        try {
            // Query explícita
            $sql = "INSERT INTO info (nomeUsuario, telefoneUsuario, emailUsuario, tipoCerimonia, dataPref, qtdConvidados, mensagemCerimonia, user_id) 
                    VALUES (:nome, :telefone, :email, :tipoCerimonia, :dataPref, :qtdConvidados, :mensagemCerimonia, :userId)";
            
            $stmtInfo = $this->pdo->prepare($sql);
            
            $stmtInfo->bindParam(':nome', $nome);
            $stmtInfo->bindParam(':telefone', $telefone);
            $stmtInfo->bindParam(':email', $email);
            $stmtInfo->bindParam(':tipoCerimonia', $tipoCerimonia);
            $stmtInfo->bindParam(':dataPref', $dataPref);
            $stmtInfo->bindParam(':qtdConvidados', $qtdConvidados, PDO::PARAM_INT);
            $stmtInfo->bindParam(':mensagemCerimonia', $mensagemCerimonia);
            
            // Tratamento especial para o UserID (aceitar NULL ou INT)
            if (empty($userId)) {
                $stmtInfo->bindValue(':userId', null, PDO::PARAM_NULL);
            } else {
                $stmtInfo->bindValue(':userId', $userId, PDO::PARAM_INT);
            }
            
            $stmtInfo->execute();
            return true;

        } catch (PDOException $e) {
            // Log de erro para debug
            error_log("Erro FormModel::inserir: " . $e->getMessage());
            return false;
        }
    }

    // Listar TUDO (Para o Admin)
    public function listar() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM info ORDER BY idUsuario DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Listar APENAS do usuário logado (Para o Histórico)
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
            return false;
        }
    }

    public function atualizar($idUsuario, $nome, $telefone, $email, $tipoCerimonia, $dataPref, $qtdConvidados, $mensagemCerimonia) {
        // Mantido para compatibilidade, caso use no futuro
        try {
            $sql = "UPDATE info SET nomeUsuario = :n, telefoneUsuario = :t, emailUsuario = :e, tipoCerimonia = :ev, dataPref = :d, qtdConvidados = :q, mensagemCerimonia = :m WHERE idUsuario = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':n'=>$nome, ':t'=>$telefone, ':e'=>$email, ':ev'=>$tipoCerimonia, ':d'=>$dataPref, ':q'=>$qtdConvidados, ':m'=>$mensagemCerimonia, ':id'=>$idUsuario]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>