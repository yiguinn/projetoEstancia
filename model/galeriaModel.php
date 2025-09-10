<?php
// model/galeriaModel.php
require_once __DIR__ . '/conexaoModel.php';

class GaleriaModel {
    private $pdo;

    public function __construct() {
        $this->pdo = (new conexaoDb())->conectar();
    }

    /**
     * Lista todas as imagens de uma categoria específica.
     */
    public function listarPorCategoria($categoria) {
        $stmt = $this->pdo->prepare("SELECT * FROM galeria_imagens WHERE categoria = :categoria ORDER BY id DESC");
        $stmt->execute([':categoria' => $categoria]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Insere uma nova imagem no banco de dados.
     */
    public function inserir($titulo, $caminho_arquivo, $categoria) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO galeria_imagens (titulo, caminho_arquivo, categoria) VALUES (:titulo, :caminho, :categoria)"
        );
        return $stmt->execute([
            ':titulo' => $titulo,
            ':caminho' => $caminho_arquivo,
            ':categoria' => $categoria
        ]);
    }

    /**
     * Busca uma imagem pelo seu ID.
     */
     public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM galeria_imagens WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Exclui uma imagem do banco de dados.
     */
    public function excluir($id) {
        $stmt = $this->pdo->prepare("DELETE FROM galeria_imagens WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>