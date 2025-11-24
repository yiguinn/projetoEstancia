document.addEventListener('DOMContentLoaded', () => {
    
    // ==========================================
    // 1. CONTROLE DOS MENUS (Mobile & Acessibilidade)
    // ==========================================
    
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const mobileOverlay = document.getElementById('mobile-overlay');
    const mobileCloseBtn = document.getElementById('mobile-menu-close');

    const accBtn = document.getElementById('accessibility-toggle');
    const accSidebar = document.getElementById('accessibility-sidebar');
    const accOverlay = document.getElementById('accessibility-overlay');
    const accCloseBtn = document.getElementById('accessibility-close');

    function toggleMobileMenu() {
        // Se a acessibilidade estiver aberta, não abre o mobile
        if (accSidebar && !accSidebar.classList.contains('-translate-x-full')) return;

        if (mobileSidebar) {
            const isClosed = mobileSidebar.classList.contains('translate-x-full');
            if (isClosed) {
                mobileSidebar.classList.remove('translate-x-full');
                if(mobileOverlay) mobileOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                mobileSidebar.classList.add('translate-x-full');
                if(mobileOverlay) mobileOverlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }
    }

    function toggleAccMenu() {
        // Se o mobile estiver aberto, não abre a acessibilidade
        if (mobileSidebar && !mobileSidebar.classList.contains('translate-x-full')) return;

        if (accSidebar) {
            const isClosed = accSidebar.classList.contains('-translate-x-full');
            if (isClosed) {
                accSidebar.classList.remove('-translate-x-full');
                if(accOverlay) accOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                accSidebar.classList.add('-translate-x-full');
                if(accOverlay) accOverlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }
    }

    // Event Listeners (Menus)
    if(mobileBtn) mobileBtn.addEventListener('click', toggleMobileMenu);
    if(mobileCloseBtn) mobileCloseBtn.addEventListener('click', toggleMobileMenu);
    if(mobileOverlay) mobileOverlay.addEventListener('click', toggleMobileMenu);

    if(accBtn) accBtn.addEventListener('click', toggleAccMenu);
    if(accCloseBtn) accCloseBtn.addEventListener('click', toggleAccMenu);
    if(accOverlay) accOverlay.addEventListener('click', toggleAccMenu);


    // ==========================================
    // 2. LÓGICA DE ACESSIBILIDADE (CORRIGIDA)
    // ==========================================
    
    const html = document.documentElement;
    const btnContrast = document.getElementById('btn-contrast');
    const btnIncreaseFont = document.getElementById('btn-increase-font');
    const btnDecreaseFont = document.getElementById('btn-decrease-font');
    const selectColorFilter = document.getElementById('select-color-filter');
    const btnReset = document.getElementById('btn-reset-accessibility');

    // Carrega configurações salvas ou padrão
    let settings = JSON.parse(localStorage.getItem('accessibilitySettings')) || {
        contrast: false,
        fontScale: 1.0,
        colorFilter: 'none'
    };

    function applySettings() {
        // Aplica Contraste
        html.setAttribute('data-theme', settings.contrast ? 'high-contrast' : 'default');
        
        // Aplica Fonte (Com .toFixed(1) para garantir formato "1.1", "1.2")
        html.setAttribute('data-font-scale', settings.fontScale.toFixed(1));
        
        // Aplica Filtro
        html.setAttribute('data-color-filter', settings.colorFilter);
        
        // Atualiza o Select visualmente se ele existir na página
        if(selectColorFilter) selectColorFilter.value = settings.colorFilter;
        
        // Salva no navegador
        localStorage.setItem('accessibilitySettings', JSON.stringify(settings));
    }

    // Botão Contraste
    if(btnContrast) {
        btnContrast.addEventListener('click', () => {
            settings.contrast = !settings.contrast;
            applySettings();
        });
    }

    // Botão Aumentar Fonte (CORRIGIDO)
    if(btnIncreaseFont) {
        btnIncreaseFont.addEventListener('click', () => {
            if (settings.fontScale < 1.3) { // Limite máximo
                // parseFloat e toFixed evitam erros de matemática (ex: 1.099999)
                settings.fontScale = parseFloat((settings.fontScale + 0.1).toFixed(1));
                applySettings();
            }
        });
    }

    // Botão Diminuir Fonte (CORRIGIDO)
    if(btnDecreaseFont) {
        btnDecreaseFont.addEventListener('click', () => {
            if (settings.fontScale > 0.8) { // Limite mínimo
                settings.fontScale = parseFloat((settings.fontScale - 0.1).toFixed(1));
                applySettings();
            }
        });
    }

    // Select Filtro de Cor
    if(selectColorFilter) {
        selectColorFilter.addEventListener('change', () => {
            settings.colorFilter = selectColorFilter.value;
            applySettings();
        });
    }

    // Botão Resetar
    if(btnReset) {
        btnReset.addEventListener('click', () => {
            settings = { contrast: false, fontScale: 1.0, colorFilter: 'none' };
            applySettings();
        });
    }

    // Aplica as configurações assim que o script carrega
    applySettings();
});