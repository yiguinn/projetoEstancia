<?php
require_once '../model/formModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model = new formModel();

    $sucesso = $model->inserir(
        $_POST['nometxt'],
        $_POST['telefonenum'],
        $_POST['emailtxt'],
        $_POST['eventotxt'],
        $_POST['data_preferencial'], 
        $_POST['numero_convidados'],
        $_POST['mensagemtxt']
    );

    if ($sucesso) {
        echo "<script>alert('Sua solicitação foi enviada!'); window.location.href = '../view/index.php';</script>"; 
    } else {
        echo "erro";
    }
}
?>
