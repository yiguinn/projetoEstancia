<footer class="bg-gray-900 text-white px-4 md:px-8 py-12">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            <div class="md:col-span-2">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-rosa-vibrante rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-medium">Estância Ilha da Madeira</h3>
                    </div>
                </div>
                <p class="text-gray-400 mb-6 max-w-md">Transformando sonhos em realidade há mais de 25 anos.</p>
                
                <div class="flex space-x-4">
                    <a href="https://www.instagram.com/estanciailhadamadeira" target="_blank" class="w-10 h-10 bg-rosa-vibrante rounded-full flex items-center justify-center hover:opacity-80 transition-opacity text-white">
                        <i class="fa-brands fa-instagram text-xl"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send/?phone=5511961006060" target="_blank" class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center hover:opacity-80 transition-opacity">
                        <i class="fa-brands fa-whatsapp text-xl"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="font-medium mb-4">Links Rápidos</h4>
                <div class="space-y-2 text-gray-400">
                    <a href="../index.php#inicio" class="block hover:text-white transition-colors">Início</a>
                    <a href="../index.php#servicos" class="block hover:text-white transition-colors">Serviços</a>
                    <a href="../index.php#galeria" class="block hover:text-white transition-colors">Galeria</a>
                    <a href="../index.php#contato" class="block hover:text-white transition-colors">Contato</a>
                </div>
            </div>

            <div>
                <h4 class="font-medium mb-4">Contato</h4>
                <div class="space-y-2 text-gray-400">
                    <p>(11) 96100-6060</p>
                    <p>sitio_ilhadamadeira@hotmail.com</p>
                    <p>Estrada da Vargem Grande, 3151</p>
                    <p>São Paulo, SP</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8">
            <div class="grid md:grid-cols-2 gap-4 items-center">
                <div class="text-gray-400">
                    <p>&copy; 2025 Estância Ilha da Madeira.</p>
                </div>
                <div class="text-gray-400 text-sm md:text-right">
                    <a href="PRIVACY_POLICY.php" class="hover:text-white transition-colors">Privacidade</a>
                    <span class="mx-2">|</span>
                    <a href="TERMS_AND_CONDITIONS.php" class="hover:text-white transition-colors">Termos</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<div id="lightbox-modal" class="fixed inset-0 z-[99999] bg-black bg-opacity-95 hidden items-center justify-center p-4 backdrop-blur-sm transition-opacity duration-300">
    
    <button id="lightbox-close" class="absolute top-5 right-5 text-white text-5xl hover:text-rosa-vibrante transition-colors focus:outline-none z-[100000] cursor-pointer">
        &times;
    </button>

    <img id="lightbox-img" src="" alt="Zoom" class="max-w-[95vw] max-h-[90vh] object-contain rounded-lg shadow-2xl select-none">
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('lightbox-modal');
    const modalImg = document.getElementById('lightbox-img');
    const closeBtn = document.getElementById('lightbox-close');
    
    // Seleciona todas as imagens que tem a classe 'zoomable'
    const images = document.querySelectorAll('.zoomable');

    if(images.length > 0) {
        images.forEach(img => {
            img.addEventListener('click', function() {
                modalImg.src = this.src; // Pega a foto clicada
                modal.classList.remove('hidden');
                modal.classList.add('flex'); // Centraliza
                document.body.style.overflow = 'hidden'; // Trava o scroll do fundo
            });
        });
    }

    // Função Fechar
    function fecharModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modalImg.src = '';
        document.body.style.overflow = 'auto'; // Libera scroll
    }

    // Eventos de Fechamento
    closeBtn.addEventListener('click', fecharModal);
    
    modal.addEventListener('click', (e) => {
        if (e.target === modal) fecharModal(); // Fecha se clicar no fundo preto
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') fecharModal(); // Fecha com ESC
    });
});
</script>

<div vw class="enabled">
  <div vw-access-button class="active"></div>
  <div vw-plugin-wrapper>
    <div class="vw-plugin-top-wrapper"></div>
  </div>
</div>
<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
<script>
  new window.VLibras.Widget('https://vlibras.gov.br/app');
</script>