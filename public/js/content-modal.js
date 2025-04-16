/**
 * public/js/content-modal.js
 * Versão corrigida com melhorias de posicionamento e proporção
 */

document.addEventListener('DOMContentLoaded', function() {
    // Referências para elementos da modal e conteúdo
    const contentCards = document.querySelectorAll('.content-card');
    const contentModal = document.getElementById('contentModal');
    
    // Verificação mais robusta dos elementos
    if (!contentModal) {
        console.warn('Modal de conteúdo não encontrada no DOM. Verifique se o componente content-modal.blade.php está incluído no layout.');
        return;
    }
    
    // Log para debug - verificar se os cards estão sendo encontrados
    console.log('Cards de conteúdo encontrados:', contentCards.length);
    
    // Elementos da modal
    const modalClose = contentModal.querySelector('.modal-close');
    const modalTitle = document.getElementById('modalTitle');
    const modalThumbnail = document.getElementById('modalThumbnail');
    const modalDuration = document.getElementById('modalDuration');
    const viewersCount = document.getElementById('viewersCount');
    const btnWatch = contentModal.querySelector('.btn-watch');
    const btnSubscribe = contentModal.querySelector('.btn-subscribe');
    const playButton = contentModal.querySelector('.play-button');
    const loadingIndicator = contentModal.querySelector('.loading-indicator');
    
    // Verificar se todos os elementos necessários existem
    const requiredElements = [modalClose, modalTitle, modalThumbnail, modalDuration, viewersCount, btnWatch, btnSubscribe, playButton];
    const missingElements = requiredElements.filter(element => !element);
    
    if (missingElements.length > 0) {
        console.warn('Elementos necessários não encontrados na modal. Verifique o HTML da modal.');
        return;
    }
    
    // Evento de clique nos cards de conteúdo - usando delegação de eventos para maior confiabilidade
    document.addEventListener('click', function(event) {
        // Encontra o card mais próximo que foi clicado
        const card = event.target.closest('.content-card');
        
        if (card) {
            // Log para debug
            console.log('Card clicado:', card);
            
            // Extrair dados do card
            const title = card.querySelector('.content-overlay h3')?.textContent || 'Conteúdo Exclusivo';
            const thumbnail = card.querySelector('img')?.src || '';
            const teaserVideo = card.getAttribute('data-teaser-video') || 'https://player.vimeo.com/external/426879954.sd.mp4?s=df4cadb04245941a14c4eb6f33fe8809d55fe5f4&profile_id=164&oauth2_token_id=57447761';
            
            // Obter elementos que podem não existir e definir valores padrão
            const duration = card.querySelector('.duration')?.textContent || '1:30:00';
            const viewersText = card.querySelector('.watching-info')?.textContent.trim() || '1.2K assistindo';
            
            // Remover qualquer vídeo anterior
            const existingVideo = contentModal.querySelector('video');
            if (existingVideo) {
                existingVideo.pause();
                existingVideo.remove();
            }
            
            // Garantir que a imagem seja visível novamente
            if (modalThumbnail) {
                modalThumbnail.style.display = '';
            }
            
            // Garantir que o botão de play e o badge de prévia estejam visíveis
            if (playButton) playButton.style.display = '';
            const previewBadge = contentModal.querySelector('.preview-badge');
            if (previewBadge) previewBadge.style.display = '';
            
            // Log para debug
            console.log('Dados do card:', { title, thumbnail, duration, viewersText, teaserVideo });
            
            // Preencher dados na modal
            modalTitle.textContent = title;
            modalThumbnail.src = thumbnail;
            modalDuration.textContent = duration.replace(' restantes', '');
            viewersCount.textContent = viewersText;
            
            // Exibir a modal
            openModal();
        }
    });
    
    // Função para abrir a modal com verificações de segurança
    function openModal() {
        if (!contentModal.classList.contains('active')) {
            contentModal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Impedir rolagem da página
            
            // Log para debug
            console.log('Modal aberta com sucesso');
        }
    }
    
    // Fechar a modal quando clicar no botão de fechar
    if (modalClose) {
        modalClose.addEventListener('click', closeModal);
    }
    
    // Fechar a modal quando clicar fora do conteúdo
    contentModal.addEventListener('click', function(e) {
        if (e.target === contentModal) {
            closeModal();
        }
    });
    
    // Função para fechar a modal com verificações de segurança
    function closeModal() {
        if (contentModal.classList.contains('active')) {
            contentModal.classList.remove('active');
            document.body.style.overflow = ''; // Restaurar rolagem da página
            
            // Limpar vídeo ou áudio se estiver sendo reproduzido
            const videoElement = contentModal.querySelector('video');
            if (videoElement) {
                videoElement.pause();
                videoElement.remove(); // Remover completamente o vídeo
            }
            
            // Garantir que a imagem esteja visível para a próxima abertura
            if (modalThumbnail) {
                modalThumbnail.style.display = '';
            }
            
            // Garantir que o botão de play esteja visível para a próxima abertura
            if (playButton) playButton.style.display = '';
            const previewBadge = contentModal.querySelector('.preview-badge');
            if (previewBadge) previewBadge.style.display = '';
            
            // Log para debug
            console.log('Modal fechada com sucesso');
        }
    }
    
    // Botão de assistir completo
    if (btnWatch) {
        btnWatch.addEventListener('click', function() {
            // Aqui você pode adicionar a lógica para verificar se o usuário está logado
            // e redirecionar para a página de login se necessário
            
            // Para este exemplo, vamos apenas abrir o modal de login
            const loginModal = document.getElementById('loginModal');
            if (loginModal) {
                closeModal();
                setTimeout(() => {
                    loginModal.classList.add('show');
                }, 300);
            } else {
                // Se o modal de login não existir, mostrar uma mensagem ou redirecionar
                alert('Você precisa estar logado para assistir ao conteúdo completo.');
                // window.location.href = '/signup';
            }
        });
    }
    
    // Botão de assinar
    if (btnSubscribe) {
        btnSubscribe.addEventListener('click', function() {
            // Direcionar para a página de assinatura ou abrir modal de login
            const loginModal = document.getElementById('loginModal');
            if (loginModal) {
                closeModal();
                setTimeout(() => {
                    loginModal.classList.add('show');
                }, 300);
            } else {
                // Redirecionar para a página de assinatura
                window.location.href = '/signup';
            }
        });
    }
    
    // Link para visualizar planos
    const viewPlansLink = contentModal.querySelector('.view-plans-link');
    if (viewPlansLink) {
        viewPlansLink.addEventListener('click', function(e) {
            e.preventDefault();
            closeModal();
            
            // Redirecionar para a página de planos
            setTimeout(() => {
                window.location.href = this.getAttribute('href') || '/plans';
            }, 300);
        });
    }
    
    // Interação com botão de play para reproduzir prévia
    if (playButton) {
        playButton.addEventListener('click', function() {
            console.log('Botão de play clicado');
            
            // Encontrar o container do teaser
            const teaserContainer = contentModal.querySelector('.teaser-container');
            if (!teaserContainer) {
                console.error('Container do teaser não encontrado');
                return;
            }
            
            // Verificar se já existe um elemento de vídeo
            let videoElement = teaserContainer.querySelector('video');
            
            if (!videoElement) {
                console.log('Criando novo elemento de vídeo');
                
                // Mostrar indicador de carregamento
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'block';
                }
                
                // Esconder imagem de thumbnail
                const thumbnailImg = teaserContainer.querySelector('img.teaser-image');
                if (thumbnailImg) {
                    thumbnailImg.style.display = 'none';
                    console.log('Thumbnail escondido');
                } else {
                    console.warn('Imagem de thumbnail não encontrada');
                }
                
                // Esconder o botão de play e o badge de prévia
                const playButtonWrapper = teaserContainer.querySelector('.play-button-wrapper');
                if (playButtonWrapper) playButtonWrapper.style.display = 'none';
                const previewBadge = teaserContainer.querySelector('.preview-badge');
                if (previewBadge) previewBadge.style.display = 'none';
                
                // Obter a URL do vídeo teaser
                const card = document.querySelector('.content-card');
                const teaserVideo = card?.getAttribute('data-teaser-video') || 'https://player.vimeo.com/external/426879954.sd.mp4?s=df4cadb04245941a14c4eb6f33fe8809d55fe5f4&profile_id=164&oauth2_token_id=57447761';
                
                // Criar e adicionar vídeo
                videoElement = document.createElement('video');
                videoElement.className = 'teaser-video';
                videoElement.controls = true;
                videoElement.autoplay = true;
                videoElement.muted = false;
                videoElement.playsInline = true;
                
                // Usar vídeo de stock gratuito do Pexels ou o teaser específico do conteúdo
                videoElement.innerHTML = `
                    <source src="${teaserVideo}" type="video/mp4">
                    <p>Seu navegador não suporta vídeos HTML5.</p>
                `;
                
                // Adicionar o vídeo ao container
                teaserContainer.appendChild(videoElement);
                console.log('Vídeo adicionado ao container');
                
                // Evento para quando o vídeo estiver pronto para reprodução
                videoElement.addEventListener('canplay', function() {
                    // Esconder o indicador de carregamento
                    if (loadingIndicator) {
                        loadingIndicator.style.display = 'none';
                    }
                    console.log('Vídeo pronto para reprodução');
                });
                
                // Adicionar evento para quando o vídeo terminar
                videoElement.addEventListener('ended', function() {
                    console.log('Vídeo terminou, voltando para o thumbnail');
                    
                    // Remover o vídeo
                    this.remove();
                    
                    // Mostrar o thumbnail novamente
                    if (thumbnailImg) thumbnailImg.style.display = '';
                    
                    // Mostrar o botão de play novamente quando o vídeo terminar
                    if (playButtonWrapper) playButtonWrapper.style.display = '';
                    if (previewBadge) previewBadge.style.display = '';
                });
                
                // Evento para tratamento de erros no vídeo
                videoElement.addEventListener('error', function(e) {
                    console.error('Erro ao carregar o vídeo:', e);
                    
                    // Esconder o indicador de carregamento
                    if (loadingIndicator) {
                        loadingIndicator.style.display = 'none';
                    }
                    
                    // Mostrar mensagem de erro
                    alert('Não foi possível carregar o vídeo. Por favor, tente novamente mais tarde.');
                    
                    // Mostrar o botão de play novamente
                    if (playButtonWrapper) playButtonWrapper.style.display = '';
                    
                    // Mostrar o thumbnail novamente
                    if (thumbnailImg) thumbnailImg.style.display = '';
                    
                    // Mostrar o badge de prévia novamente
                    if (previewBadge) previewBadge.style.display = '';
                    
                    // Remover o vídeo com erro
                    this.remove();
                });
            } else {
                // Se o vídeo já existe, apenas fazer play/pause
                if (videoElement.paused) {
                    videoElement.play();
                    if (playButton) playButton.style.display = 'none';
                } else {
                    videoElement.pause();
                    if (playButton) playButton.style.display = '';
                }
            }
        });
    }
    
    // Fechar modal com a tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && contentModal.classList.contains('active')) {
            closeModal();
        }
    });
    
    // Mostrar número dinâmico de usuários assistindo para criar urgência
    setInterval(() => {
        if (viewersCount) {
            // Extrair o número atual
            const currentText = viewersCount.textContent;
            const currentNumber = parseInt(currentText.replace(/[^0-9]/g, ''));
            
            // Se é um número válido, fazer uma pequena variação
            if (!isNaN(currentNumber)) {
                // Variação aleatória entre -5 e +10
                const variation = Math.floor(Math.random() * 16) - 5;
                let newNumber = currentNumber + variation;
                
                // Garantir que o número não fique negativo ou muito pequeno
                if (newNumber < 50) newNumber = 50 + Math.floor(Math.random() * 30);
                
                // Formatar o número
                let formattedNumber;
                if (newNumber >= 1000) {
                    formattedNumber = (newNumber / 1000).toFixed(1) + 'K';
                } else {
                    formattedNumber = newNumber.toString();
                }
                
                // Atualizar o texto mantendo a palavra "assistindo"
                viewersCount.textContent = `${formattedNumber} assistindo`;
                
                // Adicionar uma classe de destaque temporária
                viewersCount.classList.add('count-highlight');
                setTimeout(() => {
                    viewersCount.classList.remove('count-highlight');
                }, 500);
            }
        }
    }, 15000); // Atualizar a cada 15 segundos
    
    // Inicializar atributos data-teaser-video para os cards existentes
    function initTeaserVideos() {
        const contentCards = document.querySelectorAll('.content-card');
        contentCards.forEach(card => {
            if (!card.hasAttribute('data-teaser-video')) {
                // Se não tiver o atributo, definir um vídeo padrão
                card.setAttribute('data-teaser-video', 'https://player.vimeo.com/external/426879954.sd.mp4?s=df4cadb04245941a14c4eb6f33fe8809d55fe5f4&profile_id=164&oauth2_token_id=57447761');
            }
        });
    }
    
    // Chamar a inicialização
    initTeaserVideos();
    
    // Log de inicialização para confirmar que o script foi carregado corretamente
    console.log('Script da modal de conteúdo inicializado com sucesso');
});