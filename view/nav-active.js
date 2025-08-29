document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll('nav a');

    // Função para remover a classe de cor de todos os links e adicionar ao clicado
    function setActiveLink(event) {
        // Impede a ação padrão do link (ir para o topo da página)
        event.preventDefault();
        
        // Remove as classes de "ativo" de todos os links
        navLinks.forEach(link => {
            link.classList.remove('text-rosa-vibrante', 'font-medium');
            link.classList.add('text-gray-700');
        });

        // Adiciona as classes de "ativo" ao link clicado
        const clickedLink = event.target;
        clickedLink.classList.remove('text-gray-700');
        clickedLink.classList.add('text-rosa-vibrante', 'font-medium');

        // Rola a página para a seção correspondente ao link
        const targetId = clickedLink.getAttribute('href').substring(1);
        const targetSection = document.getElementById(targetId);
        if (targetSection) {
            targetSection.scrollIntoView({ behavior: 'smooth' });
        }

        // Fecha o menu mobile, se estiver aberto
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenu && mobileMenu.classList.contains('active')) {
            mobileMenu.classList.remove('active');
        }
    }

    // Adiciona o evento de clique a todos os links de navegação
    navLinks.forEach(link => {
        link.addEventListener('click', setActiveLink);
    });
});