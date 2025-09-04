<?php
    require_once '../model/conexaoModel.php';

    class formModel {
        private $pdo;

        public function __construct(){
            $conexao = new conexaoDb();
            $this->pdo = $conexao->conectar();
        }
        public function inserir($nome, $telefone, $email){
            $stmtUsuario = $this->pdo->prepare("INSERT INTO usuario(nomeUsuario, telefoneUsuario, emailUsuario) VALUES (:nome, :telefone, :email)");
            $stmtUsuario->bindParam(':nome', $nome);
            $stmtUsuario->bindParam(':telefone', $telefone);
            $stmtUsuario->bindParam(':email', $email);
        
            if ($stmtUsuario->execute()) {
                $idUsuario = $this->pdo->lastInsertId();
                $stmtTipo = $this ->pdo->prepare("INSERT INTO cerimonia (idUsuario, tipoCerimonia, dataPref, qtdConvidados, mensagemCerimonia) VALUES (:idUsuario, :tipoCerimonia, :dataPref, :qtdConvidados, :mensagemCerimonia)");
                $stmtTipo ->bindParam(':idUsuario', $idUsuario);
                $stmtTipo ->bindParam(':tipoCerimonia', $evento);
                $stmtTipo ->bindParam(':dataPref', $data);
                $stmtTipo ->bindParam(':qtdConvidados', $convidados);
                $stmtTipo ->bindParam(':mensagemCerimonia', $mensagem);
                $stmtTipo ->execute();
            }
        }
    }
?>