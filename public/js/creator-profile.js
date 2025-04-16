document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Show corresponding content
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    // Modal functionality 
    const modalTriggers = document.querySelectorAll('[data-toggle="modal"]');
    const closeModalButtons = document.querySelectorAll('.close');
    
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const targetModal = document.querySelector(this.getAttribute('data-target'));
            targetModal.classList.add('show');
            document.body.style.overflow = 'hidden';
        });
    });
    
    closeModalButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        });
    });
    
    // Click outside modal to close
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });
    });
    
    // Add animation to content cards
    const contentCards = document.querySelectorAll('.content-card');
    contentCards.forEach((card, index) => {
        // Add staggered animation
        setTimeout(() => {
            card.classList.add('animated');
        }, index * 100);
    });
    
    // Make profile banner/image more interactive
    const profilePhoto = document.querySelector('.profile-photo');
    if (profilePhoto) {
        profilePhoto.addEventListener('mouseenter', function() {
            this.querySelector('img').style.transform = 'scale(1.05)';
        });
        
        profilePhoto.addEventListener('mouseleave', function() {
            this.querySelector('img').style.transform = '';
        });
    }
});

// Adicionar ao arquivo public/js/creator-profile.js

// Função para mostrar prévia do conteúdo
function setupContentPreviews() {
    const contentCards = document.querySelectorAll('.content-card');
    
    contentCards.forEach(card => {
        card.addEventListener('click', function() {
            // Obter dados do card
            const title = this.querySelector('.content-title').textContent;
            const isExclusive = this.querySelector('.content-badge.exclusive') !== null;
            const isVip = this.querySelector('.content-badge.vip') !== null;
            const isPack = this.querySelector('.content-badge.pack') !== null;
            
            // Criar modal de prévia
            const previewModal = document.createElement('div');
            previewModal.className = 'preview-modal';
            previewModal.innerHTML = `
                <div class="preview-container">
                    <div class="preview-header">
                        <h3>${title}</h3>
                        <button class="close-preview">&times;</button>
                    </div>
                    <div class="preview-content">
                        <div class="preview-image" style="background-image: url('${this.querySelector('img').src}')">
                            <div class="preview-blur"></div>
                            <div class="preview-play">
                                <svg viewBox="0 0 24 24" width="64" height="64" fill="none" stroke="white" stroke-width="2">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                            <div class="preview-duration">Prévia: 0:30</div>
                        </div>
                        <div class="preview-info">
                            <p>Experimente ${isVip ? 'nosso plano VIP' : 'este conteúdo exclusivo'} para desbloquear o vídeo completo e muito mais!</p>
                            <div class="preview-action">
                                ${isVip ? 
                                    '<button class="btn-preview-vip">Assinar VIP</button>' : 
                                    `<button class="btn-preview-buy">Comprar por R$ ${(Math.random() * 30 + 19.9).toFixed(2).replace('.', ',')}</button>`
                                }
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(previewModal);
            
            // Mostrar modal com animação
            setTimeout(() => {
                previewModal.classList.add('show');
            }, 10);
            
            // Fechar modal
            previewModal.querySelector('.close-preview').addEventListener('click', () => {
                previewModal.classList.remove('show');
                setTimeout(() => {
                    previewModal.remove();
                }, 300);
            });
            
            // Ações dos botões
            const buyBtn = previewModal.querySelector('.btn-preview-buy');
            const vipBtn = previewModal.querySelector('.btn-preview-vip');
            
            if (buyBtn) {
                buyBtn.addEventListener('click', () => {
                    window.location.href = '#loginModal';
                    previewModal.remove();
                    document.getElementById('loginModal').classList.add('show');
                });
            }
            
            if (vipBtn) {
                vipBtn.addEventListener('click', () => {
                    window.location.href = '#loginModal';
                    previewModal.remove();
                    document.getElementById('loginModal').classList.add('show');
                });
            }
        });
    });
}

// Inicializar quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    // Código existente...
    
    // Adicionar funcionalidade de prévia
    setupContentPreviews();
});

// Adicionar ao arquivo public/js/creator-profile.js

// Função para controlar as abas do modal de login
function setupLoginTabs() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.login-tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remover classes ativas
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Adicionar classe ativa ao botão clicado
            this.classList.add('active');
            
            // Mostrar conteúdo correspondente
            const tabId = this.getAttribute('data-tab') + '-tab';
            document.getElementById(tabId).classList.add('active');
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Código existente...
    
    // Configurar abas do modal de login
    setupLoginTabs();
});

