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
                <a href="https://www.facebook.com/ilha.madeira.1/?locale=pt_BR" class="w-10 h-10 bg-rosa-vibrante rounded-full flex items-center justify-center hover:opacity-80 transition-opacity">
                        <span class="text-sm font-bold">f</span>
                    </a>
                    <a href="https://www.instagram.com/estanciailhadamadeira" target="_blank" class="w-10 h-10 bg-rosa-vibrante rounded-full flex items-center justify-center hover:opacity-80 transition-opacity text-white">
                        <i class="fa-brands fa-instagram text-xl"></i>
                    </a>
                    
                    <a href="https://api.whatsapp.com/send?phone=5511961006060&text=Ol%C3%A1!%20Gostaria%20de%20saber%20mais%20sobre%20os%20servi%C3%A7os%20da%20Est%C3%A2ncia%20Ilha%20da%20Madeira." target="_blank" class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center hover:opacity-80 transition-opacity">
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
                    <a href="../view/PRIVACY_POLICY.php" class="hover:text-white transition-colors">Política de Privacidade</a>
                    <span class="mx-2">|</span>
                    <a href="../view/TERMS_AND_CONDITIONS.php" class="hover:text-white transition-colors">Termos de Uso</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<div id="lightbox-modal" class="fixed inset-0 z-[99999] bg-black bg-opacity-95 hidden items-center justify-center p-4 backdrop-blur-sm transition-opacity duration-300 select-none">
    
    <button id="lightbox-close" class="absolute top-5 right-5 text-gray-400 hover:text-white transition-colors focus:outline-none z-[100000] cursor-pointer p-2">
        <i class="fas fa-times fa-2x"></i>
    </button>

    <button id="lightbox-prev" class="absolute left-2 md:left-8 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white hover:bg-white/10 rounded-full p-4 transition-all z-[100000]">
        <i class="fas fa-chevron-left fa-2x"></i>
    </button>

    <img id="lightbox-img" src="" alt="Zoom" class="max-w-[90vw] max-h-[85vh] object-contain rounded-lg shadow-2xl">

    <button id="lightbox-next" class="absolute right-2 md:right-8 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white hover:bg-white/10 rounded-full p-4 transition-all z-[100000]">
        <i class="fas fa-chevron-right fa-2x"></i>
    </button>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('lightbox-modal');
    const modalImg = document.getElementById('lightbox-img');
    const closeBtn = document.getElementById('lightbox-close');
    const nextBtn = document.getElementById('lightbox-next');
    const prevBtn = document.getElementById('lightbox-prev');
    
    let currentGalleryImages = [];
    let currentIndex = 0;

    // DETECTA CLIQUE DINÂMICO
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('zoomable')) {
            e.preventDefault();
            currentGalleryImages = Array.from(document.querySelectorAll('.zoomable'));
            currentIndex = currentGalleryImages.indexOf(e.target);
            updateImage();
            openModal();
        }
    });

    function updateImage() {
        if (currentGalleryImages.length === 0) return;
        const img = currentGalleryImages[currentIndex];
        modalImg.src = img.src;
        modalImg.alt = img.alt || 'Imagem';
    }

    function nextImage(e) {
        if(e) e.stopPropagation();
        if (currentGalleryImages.length === 0) return;
        currentIndex++;
        if (currentIndex >= currentGalleryImages.length) currentIndex = 0;
        updateImage();
    }

    function prevImage(e) {
        if(e) e.stopPropagation();
        if (currentGalleryImages.length === 0) return;
        currentIndex--;
        if (currentIndex < 0) currentIndex = currentGalleryImages.length - 1;
        updateImage();
    }

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modalImg.src = '';
        document.body.style.overflow = 'auto';
    }

    closeBtn.addEventListener('click', closeModal);
    nextBtn.addEventListener('click', nextImage);
    prevBtn.addEventListener('click', prevImage);

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    document.addEventListener('keydown', (e) => {
        if (modal.classList.contains('hidden')) return;
        if (e.key === 'Escape') closeModal();
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'ArrowLeft') prevImage();
    });
});
</script>

<style>
    div[vw] {
        left: auto !important;
        right: 20px !important;
        top: auto !important;
        bottom: 20px !important;
    }
</style>

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