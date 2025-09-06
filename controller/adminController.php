<?php
// controller/adminController.php
require_once __DIR__ . '/../model/formModel.php';

$model = new formModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Excluir
    if (isset($_POST['delete']) && !empty($_POST['id'])) {
        $id = (int) $_POST['id'];
        $model->excluir($id);
        header("Location: ../view/telaAdmin.php");
        exit();
    }

    // Atualizar (edição)
    if (isset($_POST['update']) && !empty($_POST['id'])) {
        $id = (int) $_POST['id'];

        // Note: usamos os mesmos names dos inputs do form (como no index.php)
        $nome = $_POST['nometxt'] ?? '';
        $telefone = $_POST['telefonenum'] ?? '';
        $email = $_POST['emailtxt'] ?? '';
        $tipoCerimonia = $_POST['eventotxt'] ?? '';
        $dataPref = $_POST['data_preferencial'] ?? null;
        $qtdConvidados = isset($_POST['numero_convidados']) ? (int) $_POST['numero_convidados'] : 0;
        $mensagemCerimonia = $_POST['mensagemtxt'] ?? '';

        $model->atualizar($id, $nome, $telefone, $email, $tipoCerimonia, $dataPref, $qtdConvidados, $mensagemCerimonia);
        header("Location: ../view/telaAdmin.php");
        exit();
    }
}

// Se chegou aqui sem POST esperado, redireciona
header("Location: ../view/telaAdmin.php");
exit();
?>
