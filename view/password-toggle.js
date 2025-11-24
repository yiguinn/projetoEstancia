function togglePasswordVisibility(button) {
    // Encontra o input que está no mesmo container do botão
    const container = button.parentElement;
    const input = container.querySelector('input');
    const icon = button.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
        icon.classList.add('text-rosa-vibrante'); // Destaque visual
    } else {
        input.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
        icon.classList.remove('text-rosa-vibrante');
    }
}