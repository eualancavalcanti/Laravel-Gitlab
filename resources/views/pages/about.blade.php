<!-- resources/views/pages/about.blade.php -->
@extends('layouts.page')

@section('title', 'Sobre Nós - HotBoys')

@section('page-title', 'Sobre Nós')

@section('page-content')
    <div class="about-container">
        <div class="about-section">
            <h2>Nossa História</h2>
            <p>Fundada em 2020, a HotBoys surgiu com uma visão clara: revolucionar a forma como o conteúdo adulto é oferecido no Brasil, priorizando qualidade, segurança e uma experiência premium para nossos usuários.</p>
            
            <p>O que começou como uma pequena startup em São Paulo rapidamente cresceu para se tornar uma das principais plataformas de conteúdo adulto do país, com uma base crescente de assinantes satisfeitos e uma reputação sólida no mercado.</p>
        </div>
        
        <div class="about-section">
            <h2>Nossa Missão</h2>
            <p>Na HotBoys, nossa missão é proporcionar uma experiência de entretenimento adulto segura, transparente e de alta qualidade, mantendo o respeito pelos nossos criadores de conteúdo e usuários.</p>
            
            <p>Acreditamos que o entretenimento adulto pode ser consumido de forma ética e responsável, com condições justas para todos os envolvidos no processo – desde os criadores de conteúdo até nossos assinantes.</p>
        </div>
        
        <div class="about-section value-cards">
            <h2>Nossos Valores</h2>
            
            <div class="value-card">
                <i class="lucide-shield-check"></i>
                <h3>Segurança e Privacidade</h3>
                <p>Investimos constantemente nas mais avançadas tecnologias de segurança para proteger os dados dos nossos usuários e garantir uma navegação privada e anônima.</p>
            </div>
            
            <div class="value-card">
                <i class="lucide-award"></i>
                <h3>Qualidade Premium</h3>
                <p>Oferecemos apenas conteúdo de alta qualidade, com rigorosos padrões de seleção e produção para garantir a melhor experiência possível aos nossos assinantes.</p>
            </div>
            
            <div class="value-card">
                <i class="lucide-check-square"></i>
                <h3>Transparência</h3>
                <p>Mantemos total transparência em nossas políticas, termos e cobranças. O que você vê é o que você paga, sem surpresas ou taxas ocultas.</p>
            </div>
            
            <div class="value-card">
                <i class="lucide-heart"></i>
                <h3>Respeito</h3>
                <p>Valorizamos e respeitamos todos os nossos colaboradores, criadores de conteúdo e assinantes, promovendo um ambiente livre de discriminação e preconceito.</p>
            </div>
        </div>
        
        <div class="about-section team-section">
            <h2>Nossa Equipe</h2>
            <p>Somos um time diversificado de profissionais apaixonados pelo que fazem, desde desenvolvimento de software e design até marketing e atendimento ao cliente. Cada membro da nossa equipe contribui para criar a melhor experiência possível para nossos usuários.</p>
            
            <div class="team-stats">
                <div class="stat-card">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Profissionais</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">11</div>
                    <div class="stat-label">Nacionalidades</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Suporte</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">5+</div>
                    <div class="stat-label">Anos de Experiência</div>
                </div>
            </div>
        </div>
        
        <div class="about-section join-section">
            <h2>Junte-se a Nós</h2>
            <p>Estamos sempre em busca de talentos para expandir nossa equipe. Se você é apaixonado por tecnologia, design, marketing ou atendimento ao cliente e quer fazer parte de uma empresa inovadora e em crescimento, consulte nossas vagas disponíveis.</p>
            
            <a href="#" class="btn-primary">Ver Vagas Abertas</a>
        </div>
        
        <div class="about-section cta-section">
            <h2>Experimente a Diferença HotBoys</h2>
            <p>Junte-se aos milhares de usuários satisfeitos que já descobriram por que a HotBoys é a plataforma preferida para conteúdo adulto no Brasil.</p>
            
            <div class="cta-buttons">
                <a href="#" class="btn-primary">Assinar Agora</a>
                <a href="#" class="btn-secondary">Conheça Nossos Planos</a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .about-container {
        display: flex;
        flex-direction: column;
        gap: 3rem;
    }
    
    .about-section {
        margin-bottom: 1rem;
    }
    
    .about-section h2 {
        margin-top: 0;
        margin-bottom: 1.2rem;
        color: var(--hot-red);
    }
    
    .value-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    
    .value-card {
        background: rgba(255, 255, 255, 0.05);
        padding: 1.5rem;
        border-radius: 10px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .value-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 51, 51, 0.05);
        border-color: rgba(255, 51, 51, 0.2);
    }
    
    .value-card i {
        color: var(--hot-red);
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    
    .value-card h3 {
        margin-top: 0;
        margin-bottom: 1rem;
    }
    
    .value-card p {
        margin: 0;
        color: var(--text-secondary);
    }
    
    .team-stats {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    
    .stat-card {
        background: rgba(255, 255, 255, 0.05);
        padding: 1.5rem;
        border-radius: 10px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .stat-card:hover {
        background: rgba(255, 51, 51, 0.05);
        border-color: rgba(255, 51, 51, 0.2);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--hot-red);
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: var(--text-secondary);
        font-size: 1rem;
    }
    
    .join-section {
        background: linear-gradient(135deg, rgba(255, 51, 51, 0.1), rgba(255, 26, 26, 0.05));
        padding: 2rem;
        border-radius: 10px;
        text-align: center;
        border: 1px solid rgba(255, 51, 51, 0.2);
    }
    
    .join-section .btn-primary {
        margin-top: 1rem;
    }
    
    .cta-section {
        text-align: center;
        padding: 3rem 2rem;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.1));
        border: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 2rem;
    }
    
    .cta-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .cta-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .cta-buttons a {
            width: 100%;
            max-width: 300px;
            text-align: center;
        }
    }
</style>
@endpush