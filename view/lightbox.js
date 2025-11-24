document.addEventListener('DOMContentLoaded', () => {
    // Elementos do Modal
    const modal = document.getElementById('lightbox-modal');
    const modalImg = document.getElementById('lightbox-img');
    const closeBtn = document.getElementById('lightbox-close');

    // Seleciona todas as imagens que têm a classe 'zoomable'
    const images = document.querySelectorAll('.zoomable');

    images.forEach(img => {
        img.addEventListener('click', function() {
            // Pega o SRC da imagem clicada e põe no modal
            modalImg.src = this.src;
            modal.classList.remove('hidden');
            modal.classList.add('flex'); // Usa flex para centralizar
            document.body.style.overflow = 'hidden'; // Impede rolagem do fundo
        });
    });

    // Função para fechar
    const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modalImg.src = ''; // Limpa a imagem
        document.body.style.overflow = 'auto'; // Libera rolagem
    };

    // Fecha ao clicar no X
    closeBtn.addEventListener('click', closeModal);

    // Fecha ao clicar fora da imagem (no fundo preto)
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Fecha com a tecla ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
});