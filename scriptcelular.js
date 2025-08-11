 document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('active');
        });

        // Smooth scrolling functions
        function scrollToContact() {
            document.getElementById('contato').scrollIntoView({
                behavior: 'smooth'
            });
        }

        function scrollToSpaces() {
            document.getElementById('espacos').scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Package selection
        function selectPackage(packageType) {
            alert(`Você selecionou o pacote ${packageType}. Em breve você será redirecionado para mais informações!`);
            scrollToContact();
        }

        // WhatsApp function
        function openWhatsApp() {
            const phoneNumber = '5519997624321';
            const message = 'Olá! Gostaria de saber mais sobre os serviços da Estância Ilha da Madeira para casamentos.';
            const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
            window.open(url, '_blank');
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
                // Close mobile menu if open
                document.getElementById('mobile-menu').classList.remove('active');
            });
        });

        // Add scroll effect to header
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 100) {
                header.classList.add('shadow-lg');
            } else {
                header.classList.remove('shadow-lg');
            }
        });

        // Contact form submission
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Simple validation
            if (!data.nome_noiva || !data.nome_noivo || !data.telefone || !data.email) {
                alert('Por favor, preencha todos os campos obrigatórios.');
                return;
            }
            
            // Simulate form submission
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            submitButton.innerHTML = '<div class="animate-pulse">Enviando...</div>';
            submitButton.disabled = true;
            
            setTimeout(() => {
                alert('Solicitação enviada com sucesso! Entraremos em contato em breve.');
                this.reset();
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }, 2000);
        });

        // Form input animations
        document.querySelectorAll('input, textarea, select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });