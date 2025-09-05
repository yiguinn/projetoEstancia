<?php
// duds dados hardcoded aq so mudar pelo backend dps
$solicitacoes = [
    [
        'id' => 1,
        'nome' => 'Ana Carolina',
        'email' => 'ana.carolina@email.com',
        'telefone' => '(11) 98765-4321',
        'mensagem' => 'Gostaria de agendar uma visita para conhecer o espaço no próximo sábado. É possível?',
        'data_envio' => '2025-09-01 10:30:00'
    ],
    [
        'id' => 2,
        'nome' => 'Bruno Vilar',
        'email' => 'bruno.vilar@email.com',
        'telefone' => '(21) 91234-5678',
        'mensagem' => 'Olá, gostaria de saber mais sobre os pacotes de casamento para 150 convidados.',
        'data_envio' => '2025-09-02 14:00:00'
    ],
    [
        'id' => 3,
        'nome' => 'Camila Dias',
        'email' => 'camila.dias@email.com',
        'telefone' => '(31) 99999-8888',
        'mensagem' => 'Vocês oferecem serviço de decoração incluso? Quais são os estilos disponíveis?',
        'data_envio' => '2025-09-04 09:15:00'
    ],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Estância Ilha da Madeira</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-white font-['SF_Pro_Display',_sans_serif]">

    <header class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <h1 class="text-xl font-medium text-rosa-vibrante">Painel Administrativo</h1>
                <span class="text-sm text-gray-500">- Estância Ilha da Madeira</span>
            </div>
            <a href="../view/index.php" class="text-sm text-rosa-vibrante hover:underline">
                Voltar ao Site
            </a>
        </div>
    </header>

    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Solicitações de Contato Recebidas</h2>

            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-full divide-y divide-gray-200">
                        <thead class="bg-rosa-vibrante">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Nome</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Contato</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Mensagem</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Data de Envio</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($solicitacoes as $solicitacao): ?>
                                <tr class="even:bg-rose-50 hover:bg-rose-100 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($solicitacao['nome']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700"><?= htmlspecialchars($solicitacao['email']) ?></div>
                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($solicitacao['telefone']) ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-700 max-w-sm whitespace-pre-wrap"><?= htmlspecialchars($solicitacao['mensagem']) ?></p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= date('d/m/Y H:i', strtotime($solicitacao['data_envio'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <?php if (empty($solicitacoes)): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        Nenhuma solicitação de contato encontrada.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

</body>
</html>