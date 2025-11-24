<?php
// controller/formController.php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../model/formModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model = new formModel();

    // Coleta dados
    $n = $_POST['nometxt'] ?? '';
    $t = $_POST['telefonenum'] ?? '';
    $e = $_POST['emailtxt'] ?? '';
    $ev = $_POST['eventotxt'] ?? '';
    $d = $_POST['data_preferencial'] ?? null;
    $num = $_POST['numero_convidados'] ?? null;
    $msg = $_POST['mensagemtxt'] ?? '';
    
    // --- CORREÇÃO PRINCIPAL ---
    // Verifica se existe usuário logado na sessão para salvar no histórico dele
    $userId = null;
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
    }

    // Passa o userId para o model
    $sucesso = $model->inserir($n, $t, $e, $ev, $d, $num, $msg, $userId);

    // Retorno JSON para o JavaScript
    header('Content-Type: application/json; charset=utf-8');
    
    if ($sucesso) {
        echo json_encode([
            "success" => true,
            "message" => "✅ Solicitação enviada com sucesso! Consulte o histórico no seu perfil."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "❌ Ocorreu um erro ao enviar. Tente novamente."
        ]);
    }
    exit();
}
?>