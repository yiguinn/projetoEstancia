document.addEventListener('DOMContentLoaded', () => {
    
    // --- 1. SELEÇÃO DOS ELEMENTOS ---
    // Menu Mobile
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const mobileOverlay = document.getElementById('mobile-overlay');
    const mobileCloseBtn = document.getElementById('mobile-menu-close');

    // Acessibilidade
    const accBtn = document.getElementById('accessibility-toggle');
    const accSidebar = document.getElementById('accessibility-sidebar');
    const accOverlay = document.getElementById('accessibility-overlay');
    const accCloseBtn = document.getElementById('accessibility-close');

    // --- 2. FUNÇÕES DE TOGGLE COM TRAVA ---
    
    function toggleMobileMenu() {
        // TRAVA: Se a acessibilidade estiver aberta, não abre o menu mobile
        if (!accSidebar.classList.contains('-translate-x-full')) return;

        const isClosed = mobileSidebar.classList.contains('translate-x-full');
        if (isClosed) {
            // Abrir
            mobileSidebar.classList.remove('translate-x-full');
            mobileOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            // Fechar
            mobileSidebar.classList.add('translate-x-full');
            mobileOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    function toggleAccMenu() {
        // TRAVA: Se o menu mobile estiver aberto, não abre a acessibilidade
        if (!mobileSidebar.classList.contains('translate-x-full')) return;

        const isClosed = accSidebar.classList.contains('-translate-x-full');
        if (isClosed) {
            // Abrir
            accSidebar.classList.remove('-translate-x-full');
            accOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            // Fechar
            accSidebar.classList.add('-translate-x-full');
            accOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // --- 3. EVENT LISTENERS (CLIQUES) ---
    
    if(mobileBtn) mobileBtn.addEventListener('click', toggleMobileMenu);
    if(mobileCloseBtn) mobileCloseBtn.addEventListener('click', toggleMobileMenu);
    if(mobileOverlay) mobileOverlay.addEventListener('click', toggleMobileMenu);

    if(accBtn) accBtn.addEventListener('click', toggleAccMenu);
    if(accCloseBtn) accCloseBtn.addEventListener('click', toggleAccMenu);
    if(accOverlay) accOverlay.addEventListener('click', toggleAccMenu);


    // --- 4. LÓGICA INTERNA DE ACESSIBILIDADE (FONTE, CONTRASTE) ---
    
    const html = document.documentElement;
    const btnContrast = document.getElementById('btn-contrast');
    const btnIncreaseFont = document.getElementById('btn-increase-font');
    const btnDecreaseFont = document.getElementById('btn-decrease-font');
    const selectColorFilter = document.getElementById('select-color-filter');
    const btnReset = document.getElementById('btn-reset-accessibility');

    // Carrega configurações salvas
    let settings = JSON.parse(localStorage.getItem('accessibilitySettings')) || {
        contrast: false,
        fontScale: 1.0,
        colorFilter: 'none'
    };

    function applySettings() {
        // Aplica Contraste
        html.setAttribute('data-theme', settings.contrast ? 'high-contrast' : 'default');
        
        // Aplica Fonte
        html.setAttribute('data-font-scale', settings.fontScale.toFixed(1));
        
        // Aplica Filtro
        html.setAttribute('data-color-filter', settings.colorFilter);
        if(selectColorFilter) selectColorFilter.value = settings.colorFilter;
        
        localStorage.setItem('accessibilitySettings', JSON.stringify(settings));
    }

    if(btnContrast) {
        btnContrast.addEventListener('click', () => {
            settings.contrast = !settings.contrast;
            applySettings();
        });
    }

    if(btnIncreaseFont) {
        btnIncreaseFont.addEventListener('click', () => {
            if (settings.fontScale < 1.3) {
                settings.fontScale += 0.1;
                applySettings();
            }
        });
    }

    if(btnDecreaseFont) {
        btnDecreaseFont.addEventListener('click', () => {
            if (settings.fontScale > 0.8) {
                settings.fontScale -= 0.1;
                applySettings();
            }
        });
    }

    if(selectColorFilter) {
        selectColorFilter.addEventListener('change', () => {
            settings.colorFilter = selectColorFilter.value;
            applySettings();
        });
    }

    if(btnReset) {
        btnReset.addEventListener('click', () => {
            settings = { contrast: false, fontScale: 1.0, colorFilter: 'none' };
            applySettings();
        });
    }

    // Aplica ao carregar a página
    applySettings();
});