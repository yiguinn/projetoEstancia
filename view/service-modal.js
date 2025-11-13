document.addEventListener('DOMContentLoaded', () => {
    
    // A variável 'serviceData' agora vem do script que colocamos no index.php
    
    // --- Seleção dos Elementos do DOM ---
    const serviceModal = document.getElementById('service-modal');
    const closeModalButton = document.getElementById('close-service-modal');
    const openModalButtons = document.querySelectorAll('.open-service-modal');
    
    const modalTitle = document.getElementById('modal-service-title');
    const modalDescription = document.getElementById('modal-service-description');
    const modalGallery = document.getElementById('modal-service-gallery');

    // --- Funções ---
    const openModal = (serviceKey) => {
        // A lógica agora é simples: apenas busca os dados no objeto que já existe
        const data = serviceData[serviceKey];
        if (!data) return;

        // Preenche o conteúdo do modal
        modalTitle.textContent = data.titulo;
        modalDescription.textContent = data.descricao;
        
        // Limpa e preenche a galeria de fotos
        modalGallery.innerHTML = '';
        if (data.imagens && data.imagens.length > 0) {
            data.imagens.forEach(img => {
                const imgElement = document.createElement('img');
                imgElement.src = `/view/uploads/parceiros/${img.caminho_arquivo}`;
                imgElement.alt = img.titulo_alt;
                imgElement.className = 'w-full h-40 object-cover rounded-lg';
                modalGallery.appendChild(imgElement);
            });
        } else {
             modalGallery.innerHTML = '<p class="text-gray-500 col-span-full">Nenhuma imagem disponível para este serviço.</p>';
        }

        // Mostra o modal
        serviceModal.classList.remove('hidden');
    };

    const closeModal = () => {
        serviceModal.classList.add('hidden');
    };

    // --- Event Listeners ---
    openModalButtons.forEach(button => {
        button.addEventListener('click', () => {
            const serviceKey = button.dataset.service;
            openModal(serviceKey);
        });
    });

    closeModalButton.addEventListener('click', closeModal);
    serviceModal.addEventListener('click', (event) => {
        if (event.target === serviceModal) {
            closeModal();
        }
    });
});