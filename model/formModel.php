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
            $stmtUsuario->execute([
                ':nome' => $nome,
                ':telefone' => $telefone,
                ':email' => $email
            ]);

            $idUsuario = $this->pdo->lastInsertId();

            $stmtCerimonia = $this->pdo->prepare("
                INSERT INTO cerimonia (idUsuario, tipoCerimonia, dataPref, qtdConvidados, mensagemCerimonia) 
                VALUES (:idUsuario, :tipoCerimonia, :dataPref, :qtdConvidados, :mensagemCerimonia)
            ");
            $stmtCerimonia->execute([
                ':idUsuario' => $idUsuario,
                ':tipoCerimonia' => $tipoCerimonia,
                ':dataPref' => $dataPref,
                ':qtdConvidados' => $qtdConvidados,
                ':mensagemCerimonia' => $mensagemCerimonia
            ]);

            return true;

        } catch (PDOException $e) {
            error_log("Erro ao inserir: " . $e->getMessage());
            return false;
        }
    }
}
?>