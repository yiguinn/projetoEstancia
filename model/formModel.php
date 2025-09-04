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
            $stmtUsuario = $this->pdo->prepare("
                INSERT INTO usuario (nomeUsuario, telefoneUsuario, emailUsuario) 
                VALUES (:nome, :telefone, :email)
            ");
            $stmtUsuario->bindParam(':nome', $nome);
            $stmtUsuario->bindParam(':telefone', $telefone);
            $stmtUsuario->bindParam(':email', $email);
            $stmtUsuario->execute();

            $idUsuario = $this->pdo->lastInsertId();

            $stmtCerimonia = $this->pdo->prepare("
                INSERT INTO cerimonia (idUsuario, tipoCerimonia, dataPref, qtdConvidados, mensagemCerimonia) 
                VALUES (:idUsuario, :tipoCerimonia, :dataPref, :qtdConvidados, :mensagemCerimonia)
            ");
            $stmtCerimonia->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmtCerimonia->bindParam(':tipoCerimonia', $tipoCerimonia);
            $stmtCerimonia->bindParam(':dataPref', $dataPref);
            $stmtCerimonia->bindParam(':qtdConvidados', $qtdConvidados, PDO::PARAM_INT);
            $stmtCerimonia->bindParam(':mensagemCerimonia', $mensagemCerimonia);
            $stmtCerimonia->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Erro ao inserir: " . $e->getMessage());
            return false;
        }
    }
}
?>
