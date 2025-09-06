<script>
function openModal(msg) {
  document.getElementById("modal-text").textContent = msg;
  document.getElementById("modal").classList.remove("hidden");
}
function closeModal() {
  document.getElementById("modal").classList.add("hidden");
}

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contact-form");
  if (form) {
    form.addEventListener("submit", async function(e) {
      e.preventDefault(); // impede o envio normal

      try {
        const resp = await fetch("../controller/formController.php", {
          method: "POST",
          body: new FormData(form),
          headers: { "X-Requested-With": "XMLHttpRequest" }
        });

        const json = await resp.json();
        openModal(json.message);

        if (json.success) form.reset();
      } catch (err) {
        openModal("❌ Erro inesperado: " + err);
      }
    });
  }
});
</script>

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
                <p class="text-gray-400 mb-6 max-w-md">Transformando sonhos em realidade há mais de 15 anos. Seu casamento perfeito nos espera em meio à natureza exuberante de São Paulo.</p>
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
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
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
                    <a href="#" class="hover:text-white transition-colors">Política de Privacidade</a>
                    <span class="mx-2">|</span>
                    <a href="#" class="hover:text-white transition-colors">Termos de Uso</a>
                </div>
            </div>
        </div>
    </div>
</footer>


</body>
</html>


<script src="scriptcelular.js"></script>
<script src="telefone.js"></script>

</body>
</html>