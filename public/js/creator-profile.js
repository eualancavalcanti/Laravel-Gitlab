document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidade de troca de abas
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Remove a classe ativa de todas as abas
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Adiciona classe ativa à aba atual
            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    // Animação de overlay de bloqueio nos cards de conteúdo
    const contentCards = document.querySelectorAll('.content-card');
    
    contentCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Prevenir padrão apenas se não estiver clicando em um link real
            if (!e.target.closest('a')) {
                e.preventDefault();
                
                // Mostrar modal de login
                $('#loginModal').modal('show');
            }
        });
    });
    
    // Animações suaves ao rolar
    const animateOnScroll = function() {
        const cards = document.querySelectorAll('.content-card');
        
        cards.forEach((card, index) => {
            const cardPosition = card.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.2;
            
            if (cardPosition < screenPosition) {
                setTimeout(() => {
                    card.classList.add('animated');
                }, index * 50); // Animação escalonada
            }
        });
    };
    
    // Executar ao carregar
    animateOnScroll();
    
    // Executar ao rolar
    window.addEventListener('scroll', animateOnScroll);
});