/**
 * Script para gerenciar o modal de vídeo
 */
document.addEventListener('DOMContentLoaded', function() {
    // Elementos do modal
    const videoModal = document.getElementById('videoModal');
    const modalTitle = document.getElementById('videoModalTitle');
    const modalThumbnail = document.getElementById('videoModalThumbnail');
    const modalDuration = document.getElementById('videoModalDuration');
    const modalViewers = document.getElementById('videoViewersCount');
    const closeButton = videoModal.querySelector('.modal-close');
    const playButton = videoModal.querySelector('.play-button');
    const loadingIndicator = videoModal.querySelector('.loading-indicator');
    
    // Verificar se todos os elementos necessários existem
    if (!videoModal || !modalTitle || !modalThumbnail) {
        console.error('Elementos necessários para o modal de vídeo não encontrados');
        return;
    }
    
    // Abrir modal ao clicar em elementos com classe .open-video-modal
    document.addEventListener('click', function(event) {
        const trigger = event.target.closest('.open-video-modal');
        if (trigger) {
            event.preventDefault();
            
            // Obter dados do elemento que acionou o modal
            const videoId = trigger.getAttribute('data-video-id') || '';
            const title = trigger.getAttribute('data-title') || 'Vídeo Premium';
            const thumbnail = trigger.getAttribute('data-thumbnail') || '';
            const viewers = Math.floor(Math.random() * 2000) + 500; // Número aleatório entre 500 e 2500
            
            // Preencher o modal com os dados
            modalTitle.textContent = title;
            modalThumbnail.src = thumbnail;
            modalViewers.textContent = formatViewers(viewers) + ' assistindo';
            
            // Garantir que não há vídeo sendo exibido
            removeExistingVideo();
            
            // Mostrar o modal
            openModal();
        }
    });
    
    // Fechar modal ao clicar no botão de fechar
    if (closeButton) {
        closeButton.addEventListener('click', closeModal);
    }
    
    // Fechar modal ao clicar fora do conteúdo
    videoModal.addEventListener('click', function(e) {
        if (e.target === videoModal) {
            closeModal();
        }
    });
    
    // Ação do botão de play
    if (playButton) {
        playButton.addEventListener('click', function() {
            const trigger = document.querySelector('.open-video-modal[data-video-id]');
            const videoId = trigger ? trigger.getAttribute('data-video-id') : '';
            
            if (videoId) {
                playVideo(videoId);
            } else {
                // Se não houver ID de vídeo, usar um vídeo de exemplo
                playVideo('demo-video');
            }
        });
    }
    
    // Fechar modal com a tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && videoModal.classList.contains('active')) {
            closeModal();
        }
    });
    
    // Função para abrir o modal
    function openModal() {
        videoModal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Impedir rolagem da página
    }
    
    // Função para fechar o modal
    function closeModal() {
        videoModal.classList.remove('active');
        document.body.style.overflow = ''; // Restaurar rolagem da página
        removeExistingVideo();
    }
    
    // Função para remover vídeo existente
    function removeExistingVideo() {
        const videoElement = videoModal.querySelector('video');
        if (videoElement) {
            videoElement.pause();
            videoElement.remove();
        }
        
        // Mostrar thumbnail e botões novamente
        if (modalThumbnail) modalThumbnail.style.display = '';
        const playButtonWrapper = videoModal.querySelector('.play-button-wrapper');
        if (playButtonWrapper) playButtonWrapper.style.display = '';
        const previewBadge = videoModal.querySelector('.preview-badge');
        if (previewBadge) previewBadge.style.display = '';
    }
    
    // Função para reproduzir vídeo
    function playVideo(videoId) {
        console.log('Reproduzindo vídeo:', videoId);
        
        // Remover vídeo existente
        removeExistingVideo();
        
        // Obter o container do teaser
        const teaserContainer = videoModal.querySelector('.teaser-container');
        if (!teaserContainer) return;
        
        // Mostrar indicador de carregamento
        if (loadingIndicator) loadingIndicator.style.display = 'block';
        
        // Esconder thumbnail
        modalThumbnail.style.display = 'none';
        
        // Esconder botão de play e badge
        const playButtonWrapper = videoModal.querySelector('.play-button-wrapper');
        if (playButtonWrapper) playButtonWrapper.style.display = 'none';
        const previewBadge = videoModal.querySelector('.preview-badge');
        if (previewBadge) previewBadge.style.display = 'none';
        
        // Criar elemento de vídeo
        const videoElement = document.createElement('video');
        videoElement.className = 'teaser-video';
        videoElement.controls = true;
        videoElement.autoplay = true;
        videoElement.playsInline = true;
        videoElement.muted = false;
        
        // Definir a fonte do vídeo com base no ID
        // Você precisará adaptar esta parte para usar os vídeos reais do seu sistema
        const videoSrc = getVideoSourceFromId(videoId);
        
        videoElement.innerHTML = `
            <source src="${videoSrc}" type="video/mp4">
            <p>Seu navegador não suporta vídeos HTML5.</p>
        `;
        
        // Adicionar o vídeo ao container
        teaserContainer.appendChild(videoElement);
        
        // Eventos do vídeo
        videoElement.addEventListener('canplay', function() {
            // Esconder o indicador de carregamento
            if (loadingIndicator) loadingIndicator.style.display = 'none';
        });
        
        videoElement.addEventListener('ended', function() {
            // Remover vídeo
            this.remove();
            // Mostrar CTA para login/assinatura
            modalThumbnail.style.display = '';
            if (playButtonWrapper) playButtonWrapper.style.display = '';
            if (previewBadge) previewBadge.style.display = '';
        });
        
        videoElement.addEventListener('error', function(e) {
            console.error('Erro ao carregar o vídeo:', e);
            // Mostrar mensagem de erro
            alert('Não foi possível carregar o vídeo. Por favor, tente novamente mais tarde.');
            // Remover vídeo com erro
            this.remove();
            // Restaurar elementos visuais
            modalThumbnail.style.display = '';
            if (playButtonWrapper) playButtonWrapper.style.display = '';
            if (previewBadge) previewBadge.style.display = '';
            if (loadingIndicator) loadingIndicator.style.display = 'none';
        });
    }
    
    // Função para obter fonte do vídeo a partir do ID
    function getVideoSourceFromId(videoId) {
        // Aqui você pode implementar a lógica para buscar a URL real do vídeo
        // Por enquanto, vamos usar um vídeo demo
        return 'https://player.vimeo.com/external/426879954.sd.mp4?s=df4cadb04245941a14c4eb6f33fe8809d55fe5f4&profile_id=164&oauth2_token_id=57447761';
    }
    
    // Função para formatar número de visualizações
    function formatViewers(num) {
        if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + 'M';
        } else if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num.toString();
    }
    
    // Atualizar número de visualizações periodicamente
    setInterval(() => {
        if (videoModal.classList.contains('active') && modalViewers) {
            // Extrair número atual
            const currentText = modalViewers.textContent;
            const currentNumber = parseInt(currentText.replace(/[^0-9]/g, ''));
            
            if (!isNaN(currentNumber)) {
                // Variação aleatória entre -5 e +15
                const variation = Math.floor(Math.random() * 21) - 5;
                let newNumber = currentNumber + variation;
                
                // Garantir número mínimo
                if (newNumber < 100) newNumber = 100 + Math.floor(Math.random() * 50);
                
                // Formatar e atualizar
                modalViewers.textContent = formatViewers(newNumber) + ' assistindo';
            }
        }
    }, 8000); // Atualizar a cada 8 segundos
});