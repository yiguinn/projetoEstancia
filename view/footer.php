<script>
// Função para ABRIR a janela modal com uma mensagem
function openModal(msg) {
  document.getElementById("modal-text").textContent = msg;
  document.getElementById("modal").classList.remove("hidden");
}

// Função para FECHAR a janela modal
function closeModal() {
  document.getElementById("modal").classList.add("hidden");
}

// Lógica principal que é executada quando a página carrega
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contact-form");
  
  // Garante que o código só vai rodar se o formulário existir na página
  if (form) {
    form.addEventListener("submit", async function(e) {
      e.preventDefault(); // Impede o envio tradicional da página

      try {
        // Envia os dados do formulário para o controller em segundo plano
        const response = await fetch("controller/formController.php", {
          method: "POST",
          body: new FormData(form),
        });

        const json = await response.json();

        // 1. Mostra a mensagem de confirmação (de sucesso ou erro) na janela modal
        openModal(json.message);

        // 2. Se o envio teve sucesso, limpa os campos preenchidos pelo usuário
        if (json.success) {
          // Limpa apenas os campos que o usuário pode editar
          form.querySelector('#data').value = '';
          form.querySelector('#convidados').value = '';
          form.querySelector('#mensagem').value = '';
          form.querySelector('#evento').value = '';
        }

      } catch (err) {
        // Se houver um erro de conexão ou outro problema, mostra um erro genérico
        openModal("❌ Ocorreu um erro inesperado. Tente novamente mais tarde.");
        console.error("Erro no envio do formulário:", err);
      }
    });
  }
});
</script>

<div id="service-modal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-[9999] hidden">
    <div class="absolute inset-0"></div>

    <div class="relative bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 md:p-8">
            <button id="close-service-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-800">
                <i class="fas fa-times fa-2x"></i>
            </button>

            <h2 id="modal-service-title" class="text-3xl font-bold text-rosa-vibrante mb-4"></h2>
            
            <p id="modal-service-description" class="text-gray-600 leading-relaxed mb-6"></p>

            <div id="modal-service-gallery" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                </div>
        </div>
    </div>
</div>

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
                <p class="text-gray-400 mb-6 max-w-md">Transformando sonhos em realidade há mais de 25 anos. Seu casamento perfeito nos espera em meio à natureza exuberante de São Paulo.</p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-rosa-vibrante rounded-full flex items-center justify-center hover:opacity-80 transition-opacity">
                        <span class="text-sm font-bold">f</span>
                    </a>
                    <a href="https://www.instagram.com/estanciailhadamadeira" 
class="w-10 h-10 bg-rosa-vibrante rounded-full flex items-center justify-center hover:opacity-80 transition-opacity text-white" aria-label="Link para o Instagram"
>
<i class="fa-brands fa-instagram text-xl"></i>
</a>
                    <a href="#" class="w-10 h-10 bg-rosa-vibrante rounded-full flex items-center justify-center hover:opacity-80 transition-opacity">
                        <span class="text-sm font-bold">in</span>
                    </a>
                    <a href="https://api.whatsapp.com/send/?phone=5511961006060&text=Olá%21+Gostaria+de+saber+mais+sobre+os+serviços+da+Estância+Ilha+da+Madeira+para+casamentos.&type=phone_number&app_absent=0" class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center hover:opacity-80 transition-opacity">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="font-medium mb-4">Links Rápidos</h4>
                <div class="space-y-2 text-gray-400">
                    <a href="#inicio" class="block hover:text-white transition-colors">Início</a>
                    <a href="#servicos" class="block hover:text-white transition-colors">Serviços</a>
                    <a href="#galeria" class="block hover:text-white transition-colors">Galeria</a>
                    <a href="#sobre" class="block hover:text-white transition-colors">Sobre</a>
                    <a href="#contato" class="block hover:text-white transition-colors">Contato</a>
                </div>
            </div>

            <div>
                <h4 class="font-medium mb-4">Contato</h4>
                <div class="space-y-2 text-gray-400">
                    <p>(11) 96100-6060</p>
                    <p>sitio_ilhadamadeira@hotmail.com</p>
                    <p>Estrada da Vargem Grande, 3151</p>
                    <p>São Paulo, SP</p>
                    <p class="pt-2 text-sm">Segunda a Sexta: 8h às 18h</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8">
            <div class="grid md:grid-cols-2 gap-4 items-center">
                <div class="text-gray-400">
                    <p>&copy; 2025 Estância Ilha da Madeira. Todos os direitos reservados.</p>
                </div>
                <div class="text-gray-400 text-sm md:text-right">
                    <a href="view/PRIVACY_POLICY.php" class="hover:text-white transition-colors">Política de Privacidade</a>
                    <span class="mx-2">|</span>
                    <a href="view/TERMS_AND_CONDITIONS.php" class="hover:text-white transition-colors">Termos de Uso</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="view/scriptcelular.js"></script>
<script src="view/telefone.js"></script>
<script src="view/accessibility.js"></script>
<script src="view/service-modal.js"></script>
<script src="view/read-more.js"></script>

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

</body>
</html>