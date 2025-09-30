<?php
// model/parceiroModel.php
require_once __DIR__ . '/conexaoModel.php';

class ParceiroModel {
    private $pdo;

    public function __construct() {
        $this->pdo = (new conexaoDb())->conectar();
    }

    /**
     * Busca os dados de um parceiro específico pela sua chave (ex: 'dj').
     */
    public function buscarPorChave($chave) {
        $stmt = $this->pdo->prepare("SELECT * FROM parceiros WHERE chave = :chave");
        $stmt->execute([':chave' => $chave]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Atualiza o título e a descrição de um parceiro.
     */
    public function atualizarParceiro($chave, $titulo, $descricao) {
        $stmt = $this->pdo->prepare(
            "UPDATE parceiros SET titulo = :titulo, descricao = :descricao WHERE chave = :chave"
        );
        return $stmt->execute([
            ':chave'     => $chave,
            ':titulo'    => $titulo,
            ':descricao' => $descricao
        ]);
    }

    /**
     * Lista todas as imagens de um parceiro específico.
     * @param int $parceiro_id - O ID do parceiro.
     * @param bool $somenteVisiveis - Se true, retorna apenas imagens visíveis.
     */
    public function listarImagens($parceiro_id, $somenteVisiveis = true) {
        $sql = "SELECT * FROM parceiros_imagens WHERE parceiro_id = :parceiro_id";
        if ($somenteVisiveis) {
            $sql .= " AND visivel = 1";
        }
        $sql .= " ORDER BY id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':parceiro_id' => $parceiro_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Insere uma nova imagem para um parceiro.
     */
    public function inserirImagem($parceiro_id, $caminho_arquivo, $titulo_alt) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO parceiros_imagens (parceiro_id, caminho_arquivo, titulo_alt) VALUES (:parceiro_id, :caminho, :titulo_alt)"
        );
        return $stmt->execute([
            ':parceiro_id' => $parceiro_id,
            ':caminho'     => $caminho_arquivo,
            ':titulo_alt'  => $titulo_alt
        ]);
    }

    /**
     * Busca uma imagem de parceiro pelo seu ID.
     */
    public function buscarImagemPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM parceiros_imagens WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Exclui uma imagem de parceiro.
     */
    public function excluirImagem($id) {
        $stmt = $this->pdo->prepare("DELETE FROM parceiros_imagens WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Atualiza o status de visibilidade de uma imagem de parceiro.
     */
    public function atualizarVisibilidadeImagem($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE parceiros_imagens SET visivel = :status WHERE id = :id");
        return $stmt->execute([
            ':id' => $id,
            ':status' => $status
        ]);
    }
}
?>