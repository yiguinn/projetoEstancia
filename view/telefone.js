document.addEventListener('DOMContentLoaded', () => {
  // 1. Seleciona os elementos do HTML que vamos manipular.
  // 'inputTelefone' é o campo onde o usuário digita o telefone.
  // 'telefoneError' é o 'span' onde a mensagem de erro será exibida.
  const inputTelefone = document.getElementById('telefone');
  const telefoneError = document.getElementById('telefone-error');

  // 2. Função para formatar o telefone enquanto o usuário digita.
  // Esta função adiciona os parênteses, espaço e o traço automaticamente.
  const formatTelefone = (value) => {
      // Remove tudo que não for um dígito.
      const cleanedValue = value.replace(/\D/g, '');
      const { length } = cleanedValue;
      
      // Limita a 11 dígitos (DDD + 9 dígitos do celular).
      if (length === 0) {
          return '';
      }

      // Formato: (XX
      if (length <= 2) {
          return `(${cleanedValue}`;
      }

      // Formato: (XX) XXXXX
      if (length <= 7) {
          return `(${cleanedValue.slice(0, 2)}) ${cleanedValue.slice(2)}`;
      }

      // Formato final: (XX) XXXXX-XXXX
      return `(${cleanedValue.slice(0, 2)}) ${cleanedValue.slice(2, 7)}-${cleanedValue.slice(7, 11)}`;
  };

  // 3. Função para validar o telefone.
  const validateTelefone = (telefone) => {
      // Remove a formatação para validar apenas os dígitos.
      const cleanedTelefone = telefone.replace(/\D/g, '');
      
      // Um telefone válido no Brasil tem 10 (fixo) ou 11 (celular) dígitos.
      return cleanedTelefone.length === 10 || cleanedTelefone.length === 11;
  };

  // 4. Adiciona um 'ouvinte' de eventos ao campo de telefone.
  // O evento 'input' é disparado a cada vez que o usuário digita.
  inputTelefone.addEventListener('input', (event) => {
      const telefoneValue = event.target.value;
      const formattedTelefone = formatTelefone(telefoneValue);

      // Atualiza o valor do campo com o telefone já formatado.
      inputTelefone.value = formattedTelefone;
  });

  // 5. Adiciona um 'ouvinte' de evento para quando o campo perde o foco.
  // A validação é feita quando o usuário clica fora do campo.
  inputTelefone.addEventListener('blur', (event) => {
      const telefoneValue = event.target.value;
      
      // Se o campo não estiver vazio, faz a validação.
      if (telefoneValue.length > 0) {
          if (validateTelefone(telefoneValue)) {
              // Se for válido, esconde a mensagem de erro.
              telefoneError.textContent = '';
              telefoneError.style.display = 'none';
          } else {
              // Se for inválido, exibe a mensagem de erro.
              telefoneError.textContent = 'Telefone inválido.';
              telefoneError.style.display = 'block';
          }
      } else {
          // Se o campo estiver vazio, esconde a mensagem de erro.
          telefoneError.textContent = '';
          telefoneError.style.display = 'none';
      }
  });
});



