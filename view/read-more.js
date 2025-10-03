document.addEventListener('DOMContentLoaded', () => {
    const reviewTexts = document.querySelectorAll('.review-text');
    const readMoreButtons = document.querySelectorAll('.ler-mais-btn');
    const initialCharLimit = 180; // Defina quantos caracteres mostrar inicialmente

    reviewTexts.forEach((textElement, index) => {
        const fullText = textElement.dataset.fullText;
        const lerMaisBtn = readMoreButtons[index];

        if (fullText.length > initialCharLimit) {
            // Se o texto for longo, mostra o trecho e o botão "Ler Mais"
            textElement.textContent = fullText.substring(0, initialCharLimit) + '...';
            lerMaisBtn.style.display = 'block'; // Garante que o botão esteja visível
        } else {
            // Se o texto for curto, mostra tudo e esconde o botão
            textElement.textContent = fullText;
            lerMaisBtn.style.display = 'none';
        }

        lerMaisBtn.addEventListener('click', () => {
            if (textElement.textContent.endsWith('...')) {
                // Se está encurtado, expande
                textElement.textContent = fullText;
                lerMaisBtn.textContent = 'Ler menos';
            } else {
                // Se está expandido, encurta
                textElement.textContent = fullText.substring(0, initialCharLimit) + '...';
                lerMaisBtn.textContent = 'Ler mais';
            }
        });
    });
});