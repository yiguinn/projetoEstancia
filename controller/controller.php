<?php
    require_once '../model/formModel.php';
    class formController {

        private $controle;

        public function __construct() {
            $this->controle = new usuarioModel();
        }

        public function cadastrar() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nome = $_POST['nometxt'];
                $telefone = $_POST['telefonenum'];
                $email = $_POST['emailtxt'];
                $evento = $_POST['eventotxt'];
                $data = $_POST['data_preferencial'];
                $convidados = $_POST['numero_convidados'];
                $mensagem = $_POST['mensagemtxt'];
                $this->controle->inserir($nome, $telefone, $email, $evento, $data, $convidados, $mensagem);

                echo "<script>alert('Cadastro realizado com sucesso!');</script>";
                
            }
            var_dump($nome);
        }
        
    }
?>
