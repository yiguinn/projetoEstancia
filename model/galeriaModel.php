<?php
// model/galeriaModel.php
require_once __DIR__ . '/conexaoModel.php';

class GaleriaModel {
    private $pdo;

    public function __construct() {
        $this->pdo = (new conexaoDb())->conectar();
    }

    /**
     * Lista imagens de uma categoria.
     * @param bool $somenteVisiveis - Se true, retorna apenas as imagens marcadas como visíveis.
     */
    public function listarPorCategoria($categoria, $somenteVisiveis = true) {
        $sql = "SELECT * FROM galeria_imagens WHERE categoria = :categoria";
        
        if ($somenteVisiveis) {
            $sql .= " AND visivel = 1"; // Adiciona a condição para buscar apenas as visíveis
        }
        
        $sql .= " ORDER BY id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':categoria' => $categoria]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Insere uma nova imagem no banco de dados.
     */
    public function inserir($titulo, $caminho_arquivo, $categoria) {
        // A imagem é inserida com visivel = 1 por padrão (definido no banco de dados)
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
    
    /**
     * NOVO: Atualiza o status de visibilidade de uma imagem.
     */
    public function atualizarVisibilidade($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE galeria_imagens SET visivel = :status WHERE id = :id");
        return $stmt->execute([
            ':id' => $id,
            ':status' => $status
        ]);
    }
}
?>