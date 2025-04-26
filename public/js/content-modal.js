/**
 * public/js/content-modal.js
 * Versão atualizada para integrar com teaser_code dos vídeos
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
    const teaserContainer = contentModal.querySelector('.teaser-container');
    
    // Verificar se todos os elementos necessários existem
    const requiredElements = [modalClose, modalTitle, modalThumbnail, modalDuration, viewersCount, btnWatch, btnSubscribe, playButton, teaserContainer];
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
            const teaserCode = card.getAttribute('data-teaser-code') || '';
            
            // Obter elementos que podem não existir e definir valores padrão
            const duration = card.querySelector('.duration')?.textContent || '1:30:00';
            const viewersText = card.querySelector('.watching-info')?.textContent.trim() || '1.2K assistindo';
            
            // Remover qualquer vídeo anterior ou iframe
            cleanTeaserContainer();
            
            // Garantir que a imagem seja visível novamente
            if (modalThumbnail) {
                modalThumbnail.style.display = '';
            }
            
            // Garantir que o botão de play e o badge de prévia estejam visíveis
            if (playButton) playButton.style.display = '';
            const previewBadge = contentModal.querySelector('.preview-badge');
            if (previewBadge) previewBadge.style.display = '';
            
            // Log para debug
            console.log('Dados do card:', { title, thumbnail, duration, viewersText, teaserCode });
            
            // Preencher dados na modal
            modalTitle.textContent = title;
            modalThumbnail.src = thumbnail;
            modalDuration.textContent = duration.replace(' restantes', '');
            viewersCount.textContent = viewersText;
            
            // Armazenar o código do teaser para uso posterior
            contentModal.setAttribute('data-teaser-code', teaserCode);
            
            // Exibir a modal
            openModal();
        }
    });
    
    // Função para limpar o conteúdo do teaser container
    function cleanTeaserContainer() {
        // Remover qualquer iframe existente
        const existingIframe = teaserContainer.querySelector('iframe');
        if (existingIframe) {
            existingIframe.remove();
        }
        
        // Remover qualquer vídeo existente
        const existingVideo = teaserContainer.querySelector('video');
        if (existingVideo) {
            existingVideo.pause();
            existingVideo.remove();
        }
    }
    
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
            
            // Limpar conteúdo do teaser
            cleanTeaserContainer();
            
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
            
            // Verificar se já existe um iframe ou vídeo
            if (teaserContainer.querySelector('iframe') || teaserContainer.querySelector('video')) {
                console.log('Iframe ou vídeo já existe');
                return;
            }
            
            // Mostrar indicador de carregamento
            if (loadingIndicator) {
                loadingIndicator.style.display = 'block';
            }
            
            // Esconder imagem de thumbnail, botão de play e badge de prévia
            if (modalThumbnail) modalThumbnail.style.display = 'none';
            
            const playButtonWrapper = teaserContainer.querySelector('.play-button-wrapper');
            if (playButtonWrapper) playButtonWrapper.style.display = 'none';
            
            const previewBadge = teaserContainer.querySelector('.preview-badge');
            if (previewBadge) previewBadge.style.display = 'none';
            
            // Obter o código do teaser da modal
            const teaserCode = contentModal.getAttribute('data-teaser-code');
            
            if (teaserCode && teaserCode.trim() !== '') {
                // Inserir o HTML do iframe diretamente no container
                const iframeWrapper = document.createElement('div');
                iframeWrapper.className = 'iframe-wrapper';
                iframeWrapper.innerHTML = teaserCode;
                
                // Garantir que o iframe ocupe 100% do espaço
                const iframe = iframeWrapper.querySelector('iframe');
                if (iframe) {
                    iframe.style.width = '100%';
                    iframe.style.height = '100%';
                    iframe.style.border = 'none';
                    iframe.allow = 'autoplay; fullscreen';
                    iframe.allowFullscreen = true;
                }
                
                teaserContainer.appendChild(iframeWrapper);
                console.log('Iframe do teaser adicionado');
                
                // Esconder o indicador de carregamento após um pequeno delay
                setTimeout(() => {
                    if (loadingIndicator) {
                        loadingIndicator.style.display = 'none';
                    }
                }, 1500);
            } else {
                console.log('Código de teaser não encontrado, usando vídeo padrão');
                
                // Criar e adicionar vídeo padrão se não houver teaser_code
                const videoElement = document.createElement('video');
                videoElement.className = 'teaser-video';
                videoElement.controls = true;
                videoElement.autoplay = true;
                videoElement.muted = false;
                videoElement.playsInline = true;
                
                // Usar vídeo de stock gratuito do Pexels
                videoElement.innerHTML = `
                    <source src="https://www.gov.br/pt-br/midias-agorabrasil/video-fundo.mp4" type="video/mp4">
                    <p>Seu navegador não suporta vídeos HTML5.</p>
                `;
                
                // Adicionar o vídeo ao container
                teaserContainer.appendChild(videoElement);
                
                // Esconder o indicador de carregamento quando o vídeo estiver pronto
                videoElement.addEventListener('canplay', function() {
                    if (loadingIndicator) {
                        loadingIndicator.style.display = 'none';
                    }
                });
                
                // Adicionar evento para quando o vídeo terminar
                videoElement.addEventListener('ended', function() {
                    // Remover o vídeo
                    this.remove();
                    
                    // Mostrar o thumbnail e controles novamente
                    if (modalThumbnail) modalThumbnail.style.display = '';
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
                    
                    // Mostrar o thumbnail e controles novamente
                    if (modalThumbnail) modalThumbnail.style.display = '';
                    if (playButtonWrapper) playButtonWrapper.style.display = '';
                    if (previewBadge) previewBadge.style.display = '';
                    
                    // Remover o vídeo com erro
                    this.remove();
                });
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
        if (viewersCount && contentModal.classList.contains('active')) {
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
    
    // Inicializar atributos data-teaser-code para os cards existentes
    function initTeaserCodes() {
        const contentCards = document.querySelectorAll('.content-card');
        const videoElements = document.querySelectorAll('.hero-slide');
        
        // Processando cards de conteúdo
        contentCards.forEach(card => {
            if (!card.hasAttribute('data-teaser-code')) {
                // Se não tiver o atributo, verificar se tem ID de vídeo
                const videoId = card.getAttribute('data-video-id');
                
                if (videoId) {
                    // Construir um código de iframe usando o video_id
                    const defaultIframe = `<iframe allow="autoplay; fullscreen;" allowfullscreen class="jmvplayer" frameborder="0" src="https://player.jmvstream.com/qAGjxuwNoNQIj2i9kkVHgLMIxUuMu7/${videoId}" width="100%" height="100%"></iframe>`;
                    card.setAttribute('data-teaser-code', defaultIframe);
                } else {
                    // Caso não tenha nenhuma informação, deixar em branco para usar o vídeo padrão
                    card.setAttribute('data-teaser-code', '');
                }
            }
        });
        
        // Processando slides do hero carousel
        videoElements.forEach(slide => {
            if (slide.hasAttribute('data-video-id') && !slide.hasAttribute('data-teaser-code')) {
                const videoId = slide.getAttribute('data-video-id');
                if (videoId) {
                    const defaultIframe = `<iframe allow="autoplay; fullscreen;" allowfullscreen class="jmvplayer" frameborder="0" src="https://player.jmvstream.com/qAGjxuwNoNQIj2i9kkVHgLMIxUuMu7/${videoId}" width="100%" height="100%"></iframe>`;
                    slide.setAttribute('data-teaser-code', defaultIframe);
                }
            }
        });
    }
    
    // Chamar a inicialização
    initTeaserCodes();
    
    // Log de inicialização para confirmar que o script foi carregado corretamente
    console.log('Script da modal de conteúdo inicializado com sucesso');
});