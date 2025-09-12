document.addEventListener('DOMContentLoaded', () => {
    // --- Seleção dos Elementos ---
    const html = document.documentElement;
    const toggleButton = document.getElementById('accessibility-toggle');
    const closeButton = document.getElementById('accessibility-close');
    const sidebar = document.getElementById('accessibility-sidebar');
    const overlay = document.getElementById('accessibility-overlay');

    const btnContrast = document.getElementById('btn-contrast');
    const btnIncreaseFont = document.getElementById('btn-increase-font');
    const btnDecreaseFont = document.getElementById('btn-decrease-font');
    const selectColorFilter = document.getElementById('select-color-filter'); // <-- NOVO
    const btnReset = document.getElementById('btn-reset-accessibility');

    // --- Configurações Padrão ---
    const defaultSettings = {
        contrast: false,
        fontScale: 1.0,
        colorFilter: 'none' // <-- NOVO
    };

    // --- Carrega configurações salvas ou usa o padrão ---
    let settings = JSON.parse(localStorage.getItem('accessibilitySettings')) || defaultSettings;

    // --- Funções Principais ---
    const openSidebar = () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    };

    const closeSidebar = () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    };

    const applySettings = () => {
        // Aplica tema de contraste
        html.setAttribute('data-theme', settings.contrast ? 'high-contrast' : 'default');
        
        // Aplica escala da fonte
        html.setAttribute('data-font-scale', settings.fontScale);

        // Aplica filtro de cor <-- NOVO
        html.setAttribute('data-color-filter', settings.colorFilter);
        selectColorFilter.value = settings.colorFilter; // Atualiza o select
    };

    const saveSettings = () => {
        localStorage.setItem('accessibilitySettings', JSON.stringify(settings));
    };

    // --- Event Listeners ---
    toggleButton.addEventListener('click', openSidebar);
    closeButton.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    btnContrast.addEventListener('click', () => {
        settings.contrast = !settings.contrast;
        applyAndSave();
    });

    btnIncreaseFont.addEventListener('click', () => {
        if (settings.fontScale < 1.2) {
            settings.fontScale = parseFloat((settings.fontScale + 0.1).toFixed(1));
            applyAndSave();
        }
    });

    btnDecreaseFont.addEventListener('click', () => {
        if (settings.fontScale > 0.8) {
            settings.fontScale = parseFloat((settings.fontScale - 0.1).toFixed(1));
            applyAndSave();
        }
    });
    
    // Evento para o select de filtro de cor <-- NOVO
    selectColorFilter.addEventListener('change', () => {
        settings.colorFilter = selectColorFilter.value;
        applyAndSave();
    });
    
    btnReset.addEventListener('click', () => {
        settings = JSON.parse(JSON.stringify(defaultSettings));
        applyAndSave();
    });
    
    function applyAndSave() {
        applySettings();
        saveSettings();
    }

    // --- Aplica as configurações ao carregar a página ---
    applySettings();
});