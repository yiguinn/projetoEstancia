<?php
    require_once '../model/formModel.php';
    
    $conn = new formModel();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nometxt'];
        $telefone = $_POST['telefonenum'];
        $email = $_POST['emailtxt'];
        $evento = $_POST['eventotxt'];
        $data = $_POST['data_preferencial'];
        $convidados = $_POST['numero_convidados'];
        $mensagem = $_POST['mensagemtxt'];

        $conn->inserir($nome, $telefone, $email, $evento, $data, $convidados, $mensagem);
        
        print_r($nome);
        print_r($telefone);
        print_r($email);
        print_r($evento);
        print_r($data);
        print_r($convidados);
        print_r($mensagem);
        exit();
    }
?>