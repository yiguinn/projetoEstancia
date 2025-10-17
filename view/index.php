<?php
// Carrega os dados de todos os parceiros para passar ao JavaScript
require_once __DIR__ . '/../model/parceiroModel.php';
$parceiroModel = new ParceiroModel();

$chaves_parceiros = ['fotografo', 'dj', 'bartender', 'cerimonialista'];
$dados_parceiros_para_js = [];

foreach ($chaves_parceiros as $chave) {
    $parceiro = $parceiroModel->buscarPorChave($chave);
    if ($parceiro) {
        $imagens = $parceiroModel->listarImagens($parceiro['id'], true); // true = apenas visíveis
        $dados_parceiros_para_js[$chave] = [
            'titulo' => $parceiro['titulo'],
            'descricao' => $parceiro['descricao'],
            'imagens' => $imagens
        ];
    }
}

// O include do header vem DEPOIS de carregar os dados
include_once("header.php");
?>

<div id="modal" 
     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-[9999]">
  <div class="bg-white p-6 rounded-lg shadow-xl text-center">
    <p id="modal-text" class="text-lg text-gray-800"></p>
    <button onclick="closeModal()" 
            class="mt-4 px-6 py-2 bg-rosa-vibrante text-white rounded-lg hover:opacity-90">
        OK
    </button>
  </div>
</div>
<?php /* Hero Section */ ?>

<section id="inicio" class="gradient-bg px-4 md:px-8 py-16">
    <div class="max-w-7xl mx-auto">
        <?php /* Rating */ ?>

        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <?php /* Left Content */ ?>
            <div class="space-y-8">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-normal leading-tight text-rosa-vibrante">
                    O Cenário Perfeito<br />
                    para o Seu Sim
                </h1>

                <p class="text-lg text-gray-700 max-w-lg leading-relaxed">
                    Na Estância Ilha da Madeira, sua cerimônia de casamento ganha vida em meio à natureza exuberante. Um espaço único onde cada detalhe é pensado para tornar seu dia inesquecível.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#sobre"><button class="bg-rosa-vibrante hover:opacity-90 text-white px-8 py-3 rounded-lg transition-opacity">
                            Conhecer nossa história →
                        </button></a>
                    <button onclick="scrollToContact()" class="border border-rosa-vibrante text-rosa-vibrante hover:bg-rosa-vibrante hover:text-white px-8 py-3 rounded-lg transition-colors">
                        Agendar Visita
                    </button>
                </div>
            </div>

            <?php /* Right Content */ ?>
            <div class="relative">
                <img
                    src="view/imagens/img7.png"
                    alt="Cerimônia de casamento"
                    class="w-full h-[500px] object-cover rounded-2xl shadow-2xl" />

                <div class="absolute bottom-8 left-8 bg-white rounded-xl p-4 shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-rosa-suave flex items-center justify-center">
                            <svg class="w-5 h-5 text-rosa-vibrante" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Ambiente Natural</div>
                            <div class="text-sm text-gray-500">Paisagem Exuberante</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php /* Statistics */ ?>
        <div class="grid grid-cols-3 gap-8 pt-16 mt-16 border-t border-gray-200">
            <div class="text-center">
                <div class="text-4xl font-medium text-rosa-vibrante mb-2">Centenas</div>
                <div class="text-gray-600">De Casamentos Realizados</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-medium text-rosa-vibrante mb-2">25+</div>
                <div class="text-gray-600">Anos de Experiência</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-medium text-rosa-vibrante mb-2">100%</div>
                <div class="text-gray-600">Sonhos Realizados</div>
            </div>
        </div>
    </div>
</section>

<?php /* Services Section */ ?>
<section id="servicos" class=" px-4 md:px-8 py-16">
    <div class="max-w-7xl mx-auto">
        <?php /* Header */ ?>
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-normal text-rosa-vibrante mb-4">
                Serviços Completos
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Oferecemos tudo que você precisa para tornar seu casamento perfeito
            </p>
        </div>

        <?php /* Services Grid */ ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
    <div class="text-center p-6 border border-gray-200 rounded-lg">
        <div class="w-16 h-16 bg-blue-100 text-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-camera-retro fa-2x"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 mb-3">Fotografia Profissional</h3>
        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
            Parceiros especializados em capturar cada momento inesquecível do seu evento.
        </p>
        <button data-service="fotografo" class="open-service-modal border border-rosa-vibrante text-rosa-vibrante hover:bg-rosa-vibrante hover:text-white px-6 py-2 rounded-lg transition-colors">
            Saiba Mais
        </button>
    </div>

    <div class="text-center p-6 border border-gray-200 rounded-lg">
        <div class="w-16 h-16 bg-purple-100 text-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-compact-disc fa-2x"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 mb-3">Som & DJ</h3>
        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
            Equipamentos de ponta e os melhores DJs para garantir a trilha sonora perfeita.
        </p>
        <button data-service="dj" class="open-service-modal border border-rosa-vibrante text-rosa-vibrante hover:bg-rosa-vibrante hover:text-white px-6 py-2 rounded-lg transition-colors">
            Saiba Mais
        </button>
    </div>

    <div class="text-center p-6 border border-gray-200 rounded-lg">
        <div class="w-16 h-16 bg-orange-100 text-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-martini-glass-citrus fa-2x"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 mb-3">Serviço de Bar</h3>
        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
            Bartenders experientes e um cardápio de drinks criativo para seus convidados.
        </p>
        <button data-service="bartender" class="open-service-modal border border-rosa-vibrante text-rosa-vibrante hover:bg-rosa-vibrante hover:text-white px-6 py-2 rounded-lg transition-colors">
            Saiba Mais
        </button>
    </div>

    <div class="text-center p-6 border border-gray-200 rounded-lg">
        <div class="w-16 h-16 bg-green-100 text-green-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-clipboard-list fa-2x"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 mb-3">Cerimonialista</h3>
        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
            Organização e planejamento impecáveis para que seu único trabalho seja aproveitar o dia.
        </p>
        <button data-service="cerimonialista" class="open-service-modal border border-rosa-vibrante text-rosa-vibrante hover:bg-rosa-vibrante hover:text-white px-6 py-2 rounded-lg transition-colors">
            Saiba Mais
        </button>
    </div>
</div>
</section>

<?php /* Gallery Section */ ?>
<section id="galeria" class="gradient-bg px-4 md:px-8 py-16">
    <div class="max-w-7xl mx-auto">
        <?php /* Header */ ?>
        <div class="text-center mb-12">

            <h2 class="text-3xl md:text-4xl font-normal text-rosa-vibrante mb-4">
                Momentos Únicos, Memórias Eternas
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Veja alguns dos casamentos mais especiais já realizados em nossos espaços
            </p>
        </div>

        <?php /* Gallery Grid */ ?>
        <div class="grid md:grid-cols-3 gap-6">
            <?php /* Gallery Item 1 */ ?>
            <a href="view/galeriaCerimonia.php" class="relative group overflow-hidden rounded-2xl">
                <img src="view/imagens/img2.png" alt="Cerimônia" class="w-full h-64 object-cover transition-transform group-hover:scale-110">
                <div class="gallery-overlay absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="bg-white text-rosa-vibrante px-3 py-1 rounded-full text-sm font-medium">Cerimônia</span>
                </div>
                <div class="absolute top-4 left-4">
                    <span class="bg-rosa-vibrante text-white px-3 py-1 rounded-full text-sm font-medium">Cerimônia</span>
                </div>
            </a>

            <?php /* Gallery Item 2 */ ?>
            <a href="view/galeriaEvento.php" class="relative group overflow-hidden rounded-2xl">
                <img src="view/imagens/img4.png" alt="Evento" class="w-full h-64 object-cover transition-transform group-hover:scale-110">
                <div class="gallery-overlay absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="bg-white text-rosa-vibrante px-3 py-1 rounded-full text-sm font-medium">Evento</span>
                </div>
                <div class="absolute top-4 left-4">
                    <span class="bg-rosa-vibrante text-white px-3 py-1 rounded-full text-sm font-medium">Evento</span>
                </div>
            </a>

            <?php /* Gallery Item 3 */ ?>
            <a href="view/galeriaCasamento.php" class="relative group overflow-hidden rounded-2xl">
                <img src="view/imagens/img3.png" alt="Casamento" class="w-full h-64 object-cover transition-transform group-hover:scale-110">
                <div class="gallery-overlay absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="bg-white text-rosa-vibrante px-3 py-1 rounded-full text-sm font-medium">Casamento</span>
                </div>
                <div class="absolute top-4 left-4">
                    <span class="bg-rosa-vibrante text-white px-3 py-1 rounded-full text-sm font-medium">Casamento</span>
                </div>
            </a>

            <?php /* Gallery Item 4 */ ?>
            <a href="view/galeriaRecepcao.php" class="relative group overflow-hidden rounded-2xl">
                <img src="view/imagens/img6.png" alt="Recepção" class="w-full h-64 object-cover transition-transform group-hover:scale-110">
                <div class="gallery-overlay absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="bg-white text-rosa-vibrante px-3 py-1 rounded-full text-sm font-medium">Recepção</span>
                </div>
                <div class="absolute top-4 left-4">
                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium">Recepção</span>
                </div>
            </a>

            <?php /* Gallery Item 5 */ ?>
            <a href="view/galeriaDecoracao.php" class="relative group overflow-hidden rounded-2xl">
                <img src="view/imagens/img1.png" alt="Decoração" class="w-full h-64 object-cover transition-transform group-hover:scale-110">
                <div class="gallery-overlay absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="bg-white text-rosa-vibrante px-3 py-1 rounded-full text-sm font-medium">Decoração</span>
                </div>
                <div class="absolute top-4 left-4">
                    <span class="bg-purple-500 text-white px-3 py-1 rounded-full text-sm font-medium">Decoração</span>
                </div>
            </a>

            <?php /* Gallery Item 6 */ ?>
            <a href="view/galeriaEspaco.php" class="relative group overflow-hidden rounded-2xl">
                <img src="view/imagens/img5.png" alt="Espaço" class="w-full h-64 object-cover transition-transform group-hover:scale-110">
                <div class="gallery-overlay absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="bg-white text-rosa-vibrante px-3 py-1 rounded-full text-sm font-medium">Espaço</span>
                </div>
                <div class="absolute top-4 left-4">
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">Espaço</span>
                </div>
            </a>
        </div>
    </div>
</section>

<?php /* About Section */ ?>
<section id="sobre" class=" bg-white px-4 md:px-8 py-16">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <?php /* Left Content */ ?>
            <div class="space-y-8">
                <h2 class="text-3xl md:text-4xl font-normal text-rosa-vibrante">
                    Nossa História de Amor com Casamentos
                </h2>

                <div class="space-y-6 text-gray-600 leading-relaxed">
    <p class="text-lg">
        Há <strong>25 anos</strong>, nossa paixão é transformar o sonho do casamento perfeito em realidade. Uma jornada dedicada a construir histórias de amor, lapidadas com a confiança de centenas de casais que nos escolheram para o seu grande dia.
    </p>
    <p>
        Acreditamos que a excelência está nos detalhes. Por isso, estamos em uma busca constante por aperfeiçoamento, desde a curadoria de nossas decorações até a qualidade de nossos materiais. Nosso objetivo vai além de realizar o sonho dos noivos; buscamos emocionar cada convidado, fazendo com que se sintam bem-vindos e percebam a organização impecável como a assinatura de nosso serviço.
    </p>
    <p>
        Cada evento é uma promessa de que a dedicação, o cuidado e a busca pela perfeição farão do seu casamento um momento autêntico e inesquecível para todos.
    </p>
</div>

                <div class="bg-rosa-suave/30 p-6 rounded-xl">
                    <div class="flex items-start space-x-4">
                        <svg class="w-6 h-6 text-rosa-vibrante mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="font-medium text-rosa-vibrante mb-2">Nossa Missão</h3>
                            <p class="text-gray-600 text-sm">Realizar sonhos através de cerimônias únicas que celebram o amor de forma autêntica e memorável.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-medium text-rosa-vibrante mb-1">Michelle Mendonça</div>
                        <div class="text-sm text-gray-600">Fundadora & CEO</div>
                    </div>
                    
                </div>
            </div>

            <?php /* Right Content */ ?>
<div class="relative">
    <img src="view/imagens/img8.png" alt="Nossa história" class="w-full h-[500px] object-cover rounded-2xl shadow-2xl">

    <?php /* Testimonial Card com "Ler Mais" */ ?>
    <div class="absolute bottom-8 right-8 bg-white rounded-xl p-6 shadow-lg max-w-sm">
        <div class="flex items-center mb-4">
            <img src="https://placehold.co/48x48/EED0E0/C53366?text=I" alt="Avatar da cliente" class="w-10 h-10 rounded-full mr-3">
            <div>
                <p class="font-semibold text-gray-800 text-sm">Isabelly</p>
                <div class="text-yellow-400">
                    <i class="fas fa-star text-xs"></i><i class="fas fa-star text-xs"></i><i class="fas fa-star text-xs"></i><i class="fas fa-star text-xs"></i><i class="fas fa-star text-xs"></i>
                </div>
            </div>
        </div>
        
        <p class="text-gray-600 text-sm italic review-text" data-full-text="Não podia ter escolhido melhor, o lugar é incrível!!! A Michelle e sua equipe é mais ainda. Tudo muito bem organizado, no dia não precisei me preocupar com nada, somente aproveitei cada detalhe. Foi como eu sempre sonhei, a decoração estava maravilhosa, tanto da cerimônia como do salão e a comida muito gostosa! Todos os convidados saíram maravilhados, elogiando muitooo. Foi simplesmente perfeito, realmente não tem nada que saiu do conformes ou que eu não tenha gostado, estou encantada com a experiência incrível que tivemos. Recomendo de olhos fechados, e desejo que todos os noivos tenham uma experiência tão especial quanto a que tivemos nesse momento tão sonhado de nossas vidas">
            </p>
        <button class="ler-mais-btn text-rosa-vibrante font-semibold mt-2 text-sm text-left hover:underline">Ler mais</button>
    </div>
</div>
        </div>

       <?php  /* Statistics Row 
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-16 pt-16 border-t border-gray-200">
            <div class="text-center">
                <div class="text-3xl font-medium text-rosa-vibrante mb-2">Top 1</div>
                <div class="text-gray-600 text-sm">Melhor Espaço<br>Santos Exclusivos</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-medium text-rosa-vibrante mb-2">Top 10</div>
                <div class="text-gray-600 text-sm">Venues<br>São Paulo Wedding</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-medium text-rosa-vibrante mb-2">5 Estrelas</div>
                <div class="text-gray-600 text-sm">Avaliação Clientes</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-medium text-rosa-vibrante mb-2">ISO</div>
                <div class="text-gray-600 text-sm">Certificado<br>Qualidade Garantida</div>
            </div>
        </div>*/ ?>
    </div>
</section>

<?php /* Contact Section */ ?>
<section id="contato" class="contact-bg px-4 md:px-8 py-16">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-12">
            <?php /* Left Content */ ?>
            <div class="space-y-8">

                <h2 class="text-3xl md:text-4xl font-normal text-rosa-vibrante">
                    Vamos Realizar Seu Sonho
                </h2>

                <p class="text-lg text-gray-600 leading-relaxed">
                    Entre em contato conosco e vamos começar a planejar o casamento dos seus sonhos. Nossa equipe está pronta para criar uma experiência única e inesquecível.
                </p>

                <?php /* Contact Info */ ?>
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-rosa-vibrante rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 mb-1">Telefone</h3>
                            <p class="text-rosa-vibrante font-medium">(11) 96100-6060</p>
                            <p class="text-sm text-gray-600">Segunda a Sexta - 8h às 18h</p>
                            <p class="text-sm text-gray-600">Resposta em até 24h</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-rosa-vibrante rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 mb-1">E-mail</h3>
                            <p class="text-rosa-vibrante font-medium">sitio_ilhadamadeira@hotmail.com</p>
                            <p class="text-sm text-gray-600">Resposta em até 24h</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-rosa-vibrante rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 mb-1">Localização</h3>
                            <p class="text-rosa-vibrante font-medium">Estrada da Vargem Grande, 3151 - São Paulo, SP</p>
                            <p class="text-sm text-gray-600">Fácil acesso e estacionamento</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-rosa-vibrante rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 mb-1">WhatsApp</h3>
                            <p class="text-rosa-vibrante font-medium">Atendimento rápido e personalizado</p>
                            <button onclick="openWhatsApp()" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-600 transition-colors mt-2">
                                Conversar Agora
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <?php /* Right Content - Contact Form */ ?>
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <h3 class="text-2xl font-medium text-rosa-vibrante mb-6">Agende Sua Visita</h3>

                <form method="post" id="contact-form" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-4">
                    <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nome do(a) contratante</label>
                            <input
                                type="text"
                                name="nometxt"
                                id="nome"
                                required
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-rosa-vibrante outline-none 
                                    <?php if (isset($_SESSION['user_id'])): ?> bg-gray-100 cursor-not-allowed <?php endif; ?>"
                                placeholder="Digite seu nome"
                                value="<?= isset($_SESSION['user_nome']) ? htmlspecialchars($_SESSION['user_nome']) : '' ?>"
                                <?php if (isset($_SESSION['user_id'])): ?> readonly <?php endif; ?>
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Comemoração</label>
                            <select
                                name="eventotxt"
                                id="evento"
                                required
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-rosa-vibrante focus:border-transparent outline-none transition-colors">
                                <option value="">Selecione</option>
                                <option value="aniversario">Aniversário</option>
                                <option value="casamento">Casamento</option>
                                <option value="bodas">Bodas</option>
                                <option value="empresa">Comemorações para Empresas</option>
                                <option value="outro">Outro(a)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">

                    <div>
                        <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                        <input
                            type="tel"
                            name="telefonenum"
                            id="telefone" required
                            maxlength="15" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-rosa-vibrante outline-none
                                <?php if (isset($_SESSION['user_id'])): ?> bg-gray-100 cursor-not-allowed <?php endif; ?>"
                            placeholder="(XX) XXXXX-XXXX"
                            value="<?= isset($_SESSION['user_telefone']) ? htmlspecialchars($_SESSION['user_telefone']) : '' ?>"
                            <?php if (isset($_SESSION['user_id'])): ?> readonly <?php endif; ?>
                        >
                        <span id="telefone-error" class="text-red-500 text-sm mt-1" style="display: none;"></span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                        <input
                            type="email"
                            name="emailtxt"
                            id="email"
                            required
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-rosa-vibrante outline-none
                                <?php if (isset($_SESSION['user_id'])): ?> bg-gray-100 cursor-not-allowed <?php endif; ?>"
                            placeholder="seu@email.com"
                            value="<?= isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : '' ?>"
                            <?php if (isset($_SESSION['user_id'])): ?> readonly <?php endif; ?>
                        >
                    </div>

                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Data Preferencial</label>
                            <input
                                type="date"
                                id="data"
                                name="data_preferencial"
                                required
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-rosa-vibrante focus:border-transparent outline-none transition-colors"
                                placeholder="mm/dd/yyyy">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Número de Convidados</label>
                            <select
                                name="numero_convidados"
                                id="convidados"
                                required
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-rosa-vibrante focus:border-transparent outline-none transition-colors">
                                <option value="">Selecione</option>
                                <option value="50">Até 50 pessoas</option>
                                <option value="100">50 a 100 pessoas</option>
                                <option value="150">100 a 150 pessoas</option>
                                <option value="200">150 a 200 pessoas</option>
                                <option value="250">Mais de 200 pessoas</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mensagem (Opcional)</label>
                        <textarea maxlength="2500"
                            name="mensagemtxt"
                            rows="4"
                            id="mensagem"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-rosa-vibrante focus:border-transparent outline-none transition-colors resize-none"
                            placeholder="Conte-nos um pouco sobre o casamento dos seus sonhos..."></textarea>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-rosa-vibrante hover:opacity-90 text-white py-4 rounded-lg font-medium transition-opacity flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        <span>Enviar Solicitação</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

</section>

<script>
    const serviceData = <?= json_encode($dados_parceiros_para_js); ?>;
</script>

<?php include_once("footer.php"); ?>