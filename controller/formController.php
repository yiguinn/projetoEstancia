<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../model/formModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model = new formModel();

    // Dados do form
    $n = $_POST['nometxt'] ?? '';
    $t = $_POST['telefonenum'] ?? '';
    $e = $_POST['emailtxt'] ?? '';
    $ev = $_POST['eventotxt'] ?? '';
    $d = $_POST['data_preferencial'] ?? null;
    $num = $_POST['numero_convidados'] ?? null;
    $msg = $_POST['mensagemtxt'] ?? '';
    
    // AQUI ESTÁ O SEGREDO: Se estiver logado (mesmo como admin), pega o ID
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Salva no banco com o ID
    $sucesso = $model->inserir($n, $t, $e, $ev, $d, $num, $msg, $userId);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        "success" => (bool)$sucesso,
        "message" => $sucesso 
            ? "✅ Solicitação enviada! Verifique seu histórico." 
            : "❌ Erro ao enviar."
    ]);
    exit();
}
?>