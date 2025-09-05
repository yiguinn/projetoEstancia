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
}
?>
