<!-- resources/views/pages/system-status.blade.php -->
@extends('layouts.page')

@section('title', 'Status do Sistema - HotBoys')

@section('page-title', 'Status do Sistema')

@section('page-content')
    <div class="status-container">
        <div class="status-overview">
            <div class="status-header">
                <h2>Estado Atual do Sistema</h2>
                <div class="status-indicator operational">
                    <span class="dot"></span>
                    <span class="text">Todos os sistemas operacionais</span>
                </div>
            </div>
            
            <p class="last-updated">Última atualização: {{ date('d/m/Y H:i') }} (UTC-3)</p>
            
            <div class="refresh-button">
                <button class="btn-secondary btn-sm" id="refresh-status">
                    <i class="lucide-refresh-cw"></i> Atualizar Status
                </button>
            </div>
        </div>
        
        <div class="status-components">
            <div class="component-group">
                <h3>Serviços Principais</h3>
                
                <div class="component operational">
                    <div class="component-name">Website</div>
                    <div class="component-status">
                        <span class="dot"></span>
                        <span class="text">Operacional</span>
                    </div>
                </div>
                
                <div class="component operational">
                    <div class="component-name">API</div>
                    <div class="component-status">
                        <span class="dot"></span>
                        <span class="text">Operacional</span>
                    </div>
                </div>
                
                <div class="component operational">
                    <div class="component-name">CDN</div>
                    <div class="component-status">
                        <span class="dot"></span>
                        <span class="text">Operacional</span>
                    </div>
                </div>
                
                <div class="component operational">
                    <div class="component-name">Sistema de Streaming</div>
                    <div class="component-status">
                        <span class="dot"></span>
                        <span class="text">Operacional</span>
                    </div>
                </div>
            </div>
            
            <div class="component-group">
                <h3>Pagamentos</h3>
                
                <div class="component operational">
                    <div class="component-name">Processamento de Pagamentos</div>
                    <div class="component-status">
                        <span class="dot"></span>
                        <span class="text">Operacional</span>
                    </div>
                </div>
                
                <div class="component operational">
                    <div class="component-name">Assinaturas</div>
                    <div class="component-status">
                        <span class="dot"></span>
                        <span class="text">Operacional</span>
                    </div>
                </div>
                
                <div class="component partial">
                    <div class="component-name">Pay-per-view</div>
                    <div class="component-status">
                        <span class="dot"></span>
                        <span class="text">Desempenho Reduzido</span>
                    </div>
                </div>
            </div>
            
            <div class="component-group">
                <h3>Funcionalidades</h3>
                
                <div class="component operational">
                    <div class="component-name">Busca</div>
                    <div class="component-status">
                        <span class="dot"></span>
                        <span class="text">Operacional</span>
                    </div>
                </div>
                
                <div class="component operational">
                    <div class="component-name">Recomendações</div>
                    <div class="component-status">
                        <span class="dot"></span>
                        <span class="text">Operacional</span>
                    </div>
                </div>
                
                <div class="component operational">
                    <div class="component-name">Downloads</div>
                    <div class="component-status">
                        <span class="dot"></span>
                        <span class="text">Operacional</span>
                    </div>
                </div>
                
                <div class="component operational">
                    <div class="component-name">Comentários</div>
                    <div class="component-status">
                        <span class="dot"></span>
                        <span class="text">Operacional</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="incident-history">
            <h3>Histórico de Incidentes</h3>
            
            <div class="incident">
                <div class="incident-date">{{ date('d/m/Y', strtotime('-2 days')) }}</div>
                <div class="incident-details resolved">
                    <h4>Resolvido: Instabilidade no Streaming</h4>
                    <div class="incident-timeline">
                        <div class="timeline-entry">
                            <span class="time">{{ date('H:i', strtotime('-2 days 15:45')) }}</span>
                            <span class="description">Problema resolvido. Todos os serviços de streaming estão funcionando normalmente.</span>
                        </div>
                        <div class="timeline-entry">
                            <span class="time">{{ date('H:i', strtotime('-2 days 14:20')) }}</span>
                            <span class="description">Nossas equipes identificaram o problema e estão implementando uma solução.</span>
                        </div>
                        <div class="timeline-entry">
                            <span class="time">{{ date('H:i', strtotime('-2 days 14:05')) }}</span>
                            <span class="description">Estamos investigando relatos de lentidão e buffering em vídeos de alta resolução.</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="incident">
                <div class="incident-date">{{ date('d/m/Y', strtotime('-7 days')) }}</div>
                <div class="incident-details resolved">
                    <h4>Resolvido: Manutenção Programada</h4>
                    <div class="incident-timeline">
                        <div class="timeline-entry">
                            <span class="time">{{ date('H:i', strtotime('-7 days 04:30')) }}</span>
                            <span class="description">Manutenção concluída. Todos os sistemas estão operacionais.</span>
                        </div>
                        <div class="timeline-entry">
                            <span class="time">{{ date('H:i', strtotime('-7 days 02:00')) }}</span>
                            <span class="description">Iniciada manutenção programada. Alguns serviços podem ficar indisponíveis por curtos períodos.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="status-subscribe">
            <h3>Receba Atualizações de Status</h3>
            <p>Inscreva-se para receber notificações sobre interrupções de serviço e manutenções programadas.</p>
            
            <form id="status-subscription-form" class="subscription-form">
                <div class="form-group">
                    <input type="email" id="status-email" name="status-email" placeholder="Seu e-mail" required>
                    <button type="submit" class="btn-primary">Inscrever-se</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .status-container {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    
    .status-overview {
        background: rgba(255, 255, 255, 0.05);
        padding: 1.5rem;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .status-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .status-header h2 {
        margin: 0;
    }
    
    .status-indicator {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
    }
    
    .status-indicator.operational {
        background: rgba(46, 204, 113, 0.1);
        color: #2ecc71;
    }
    
    .status-indicator.partial {
        background: rgba(241, 196, 15, 0.1);
        color: #f1c40f;
    }
    
    .status-indicator.outage {
        background: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
    }
    
    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }
    
    .operational .dot {
        background-color: #2ecc71;
    }
    
    .partial .dot {
        background-color: #f1c40f;
    }
    
    .outage .dot {
        background-color: #e74c3c;
    }
    
    .last-updated {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin: 0;
    }
    
    .refresh-button {
        margin-top: 1rem;
        text-align: right;
    }
    
    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
    }
    
    .status-components {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .component-group {
        background: rgba(255, 255, 255, 0.03);
        padding: 1.5rem;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .component-group h3 {
        margin-top: 0;
        margin-bottom: 1.2rem;
        font-size: 1.1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .component {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.8rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .component:last-child {
        border-bottom: none;
    }
    
    .component-name {
        font-weight: 500;
    }
    
    .component-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }
    
    .incident-history {
        margin-top: 1rem;
    }
    
    .incident {
        margin-bottom: 2rem;
    }
    
    .incident-date {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: var(--text-secondary);
    }
    
    .incident-details {
        background: rgba(255, 255, 255, 0.03);
        padding: 1.5rem;
        border-radius: 10px;
        border-left: 4px solid;
    }
    
    .incident-details.resolved {
        border-left-color: #2ecc71;
    }
    
    .incident-details.ongoing {
        border-left-color: #e74c3c;
    }
    
    .incident-details h4 {
        margin-top: 0;
        margin-bottom: 1rem;
    }
    
    .incident-timeline {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .timeline-entry {
        display: flex;
        gap: 1rem;
    }
    
    .timeline-entry .time {
        min-width: 50px;
        font-weight: 500;
        color: var(--text-secondary);
    }
    
    .status-subscribe {
        background: linear-gradient(135deg, rgba(255, 51, 51, 0.1), rgba(255, 26, 26, 0.05));
        padding: 2rem;
        border-radius: 10px;
        text-align: center;
        border: 1px solid rgba(255, 51, 51, 0.2);
        margin-top: 1rem;
    }
    
    .status-subscribe h3 {
        margin-top: 0;
    }
    
    .subscription-form {
        max-width: 500px;
        margin: 1.5rem auto 0;
    }
    
    .subscription-form .form-group {
        display: flex;
        gap: 0.5rem;
    }
    
    .subscription-form input {
        flex: 1;
        padding: 0.8rem 1rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 5px;
        color: white;
        font-size: 1rem;
    }
    
    .subscription-form input:focus {
        outline: none;
        border-color: var(--hot-red);
        background: rgba(255, 255, 255, 0.15);
    }
    
    @media (max-width: 768px) {
        .status-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .subscription-form .form-group {
            flex-direction: column;
        }
        
        .timeline-entry {
            flex-direction: column;
            gap: 0.3rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const refreshBtn = document.getElementById('refresh-status');
        const subscriptionForm = document.getElementById('status-subscription-form');
        
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="lucide-loader"></i> Atualizando...';
                this.disabled = true;
                
                // Simulate refresh
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                    
                    // Update last updated time
                    const lastUpdated = document.querySelector('.last-updated');
                    if (lastUpdated) {
                        const now = new Date();
                        const hours = now.getHours().toString().padStart(2, '0');
                        const minutes = now.getMinutes().toString().padStart(2, '0');
                        const formattedDate = `${now.getDate().toString().padStart(2, '0')}/${(now.getMonth() + 1).toString().padStart(2, '