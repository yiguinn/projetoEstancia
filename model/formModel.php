<?php
require_once '../model/conexaoModel.php';

class formModel {
    private $pdo;

    public function __construct(){
        $conexao = new conexaoDb();
        $this->pdo = $conexao->conectar();
    }

    public function inserir($nome, $telefone, $email, $tipoCerimonia, $dataPref, $qtdConvidados, $mensagemCerimonia){
        try {
            $stmtInfo = $this->pdo->prepare("
                INSERT INTO info (nomeUsuario, telefoneUsuario, emailUsuario, tipoCerimonia, dataPref, qtdConvidados, mensagemCerimonia) 
                VALUES (:nome, :telefone, :email, :tipoCerimonia, :dataPref, :qtdConvidados, :mensagemCerimonia)
            ");
            $stmtInfo->bindParam(':nome', $nome);
            $stmtInfo->bindParam(':telefone', $telefone);
            $stmtInfo->bindParam(':email', $email);
            $stmtInfo->bindParam(':tipoCerimonia', $tipoCerimonia);
            $stmtInfo->bindParam(':dataPref', $dataPref);
            $stmtInfo->bindParam(':qtdConvidados', $qtdConvidados, PDO::PARAM_INT);
            $stmtInfo->bindParam(':mensagemCerimonia', $mensagemCerimonia);
            $stmtInfo->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Erro ao inserir: " . $e->getMessage());
            return false;
        }
    }
    // === CRUD admin (adicionar dentro da classe formModel, após inserir) ===

public function listar() {
    try {
        $stmt = $this->pdo->query("SELECT * FROM info ORDER BY idUsuario DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erro listar: " . $e->getMessage());
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

public function atualizar($idUsuario, $nome, $telefone, $email, $tipoCerimonia, $dataPref, $qtdConvidados, $mensagemCerimonia) {
    try {
        $sql = "UPDATE info SET
                    nomeUsuario = :nome,
                    telefoneUsuario = :telefone,
                    emailUsuario = :email,
                    tipoCerimonia = :tipoCerimonia,
                    dataPref = :dataPref,
                    qtdConvidados = :qtdConvidados,
                    mensagemCerimonia = :mensagemCerimonia
                WHERE idUsuario = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $idUsuario,
            ':nome' => $nome,
            ':telefone' => $telefone,
            ':email' => $email,
            ':tipoCerimonia' => $tipoCerimonia,
            ':dataPref' => $dataPref,
            ':qtdConvidados' => $qtdConvidados,
            ':mensagemCerimonia' => $mensagemCerimonia
        ]);
    } catch (PDOException $e) {
        error_log("Erro atualizar: " . $e->getMessage());
        return false;
    }
}

}
?>
