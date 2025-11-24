document.addEventListener('DOMContentLoaded', () => {
    const passwordInput = document.getElementById('password');
    const submitButton = document.querySelector('button[name="cadastro"]');
    
    // Lista de requisitos (Elementos HTML)
    const requirements = {
        length: document.getElementById('req-length'),
        upper: document.getElementById('req-upper'),
        lower: document.getElementById('req-lower'),
        number: document.getElementById('req-number'),
        special: document.getElementById('req-special')
    };

    // Ícones para trocar (FontAwesome)
    const checkIcon = '<i class="fas fa-check-circle mr-2"></i>';
    const circleIcon = '<i class="far fa-circle mr-2"></i>';

    // Desabilita o botão inicialmente
    if(submitButton) {
        submitButton.disabled = true;
        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
    }

    passwordInput.addEventListener('input', () => {
        const value = passwordInput.value;
        let allValid = true;

        // 1. Mínimo 8 caracteres
        if (value.length >= 8) {
            setValid(requirements.length, true);
        } else {
            setValid(requirements.length, false);
            allValid = false;
        }

        // 2. Letra Maiúscula
        if (/[A-Z]/.test(value)) {
            setValid(requirements.upper, true);
        } else {
            setValid(requirements.upper, false);
            allValid = false;
        }

        // 3. Letra Minúscula
        if (/[a-z]/.test(value)) {
            setValid(requirements.lower, true);
        } else {
            setValid(requirements.lower, false);
            allValid = false;
        }

        // 4. Número
        if (/[0-9]/.test(value)) {
            setValid(requirements.number, true);
        } else {
            setValid(requirements.number, false);
            allValid = false;
        }

        // 5. Caractere Especial (!@#$%^&*)
        if (/[!@#$%^&*(),.?":{}|<>]/.test(value)) {
            setValid(requirements.special, true);
        } else {
            setValid(requirements.special, false);
            allValid = false;
        }

        // Habilita ou desabilita o botão de cadastro
        if (submitButton) {
            if (allValid) {
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
    });

    function setValid(element, isValid) {
        if (isValid) {
            element.classList.remove('text-gray-500');
            element.classList.add('text-green-600', 'font-medium');
            element.innerHTML = checkIcon + element.innerText.replace(/<[^>]*>/g, '').trim();
        } else {
            element.classList.remove('text-green-600', 'font-medium');
            element.classList.add('text-gray-500');
            // Remove o ícone antigo e põe a bolinha vazia (recupera o texto original simples)
            const text = element.innerText.replace(/<[^>]*>/g, '').trim(); // Limpa ícones antigos
            element.innerHTML = circleIcon + text;
        }
    }
});