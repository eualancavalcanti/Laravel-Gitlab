@extends('layouts.page')

@section('title', 'Busca - HotBoys')

@section('page-title', 'Busca')

@section('page-content')
    <div class="hb-search-container">
        <!-- Formulário de busca principal -->
        <div class="hb-search-form-container">
            <form class="hb-search-form" id="hb-search-main-form" action="{{ route('search') }}" method="GET">
                <div class="hb-search-input-group">
                    <input type="text" name="q" id="hb-search-input" class="hb-search-input" 
                           placeholder="Buscar conteúdo, modelos ou categorias" 
                           value="{{ request()->get('q', '') }}" autocomplete="off">
                    <button type="submit" class="hb-search-button">
                        <i class="lucide-search"></i>
                        <span>Buscar</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Filtros -->
        <div class="hb-search-filters">
            <div class="hb-filter-categories">
                <button class="hb-filter-btn active" data-filter="all">Todos</button>
                <button class="hb-filter-btn" data-filter="videos">Vídeos</button>
                <button class="hb-filter-btn" data-filter="creators">Modelos</button>
                <button class="hb-filter-btn" data-filter="categories">Categorias</button>
            </div>
            
            <div class="hb-filter-controls">
                <div class="hb-filter-group">
                    <label for="hb-filter-type">Tipo</label>
                    <select id="hb-filter-type" class="hb-filter-select">
                        <option value="all">Todos</option>
                        <option value="exclusive">Exclusivo</option>
                        <option value="vip">VIP</option>
                        <option value="ppv">Pay-per-view</option>
                    </select>
                </div>
                
                <div class="hb-filter-group">
                    <label for="hb-filter-duration">Duração</label>
                    <select id="hb-filter-duration" class="hb-filter-select">
                        <option value="all">Qualquer</option>
                        <option value="short">Até 10 min</option>
                        <option value="medium">10-30 min</option>
                        <option value="long">Mais de 30 min</option>
                    </select>
                </div>
                
                <div class="hb-filter-group">
                    <label for="hb-filter-sort">Ordenar por</label>
                    <select id="hb-filter-sort" class="hb-filter-select">
                        <option value="relevance">Relevância</option>
                        <option value="newest">Mais recentes</option>
                        <option value="oldest">Mais antigos</option>
                        <option value="popularity">Popularidade</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Resultados da busca -->
        <div class="hb-search-results">
            <div class="hb-results-count">
                Exibindo <span id="hb-visible-count">0</span> de <span id="hb-total-count">0</span> resultados
                @if(request()->get('q'))
                para "<strong>{{ request()->get('q') }}</strong>"
                @endif
            </div>
            
            <!-- Grid de resultados -->
            <div class="hb-results-grid" id="hb-search-results-container">
                <!-- Se não há termo de busca (página inicial de busca) -->
                @if(!request()->get('q'))
                    <div class="hb-empty-search">
                        <div class="hb-empty-search-icon">
                            <i class="lucide-search"></i>
                        </div>
                        <h3>O que você está procurando?</h3>
                        <p>Digite um termo para buscar por vídeos, modelos ou categorias.</p>
                        <div class="hb-search-suggestions">
                            <h4>Sugestões populares:</h4>
                            <div class="hb-suggestion-tags">
                                <a href="{{ route('search', ['q' => 'amador']) }}" class="hb-suggestion-tag">Amador</a>
                                <a href="{{ route('search', ['q' => 'jovem']) }}" class="hb-suggestion-tag">Jovem</a>
                                <a href="{{ route('search', ['q' => 'bareback']) }}" class="hb-suggestion-tag">Bareback</a>
                                <a href="{{ route('search', ['q' => 'trio']) }}" class="hb-suggestion-tag">Trio</a>
                                <a href="{{ route('search', ['q' => 'exclusivo']) }}" class="hb-suggestion-tag">Exclusivo</a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Loader enquanto a busca está sendo realizada -->
                    <div class="hb-search-loading">
                        <div class="hb-loading-spinner"></div>
                        <p>Buscando resultados...</p>
                    </div>
                    
                    <!-- Template para mostrar quando não há resultados -->
                    <div class="hb-no-results" style="display: none;">
                        <div class="hb-no-results-icon">
                            <i class="lucide-search-x"></i>
                        </div>
                        <h3>Nenhum resultado encontrado</h3>
                        <p>Não encontramos resultados para sua busca. Tente usar termos diferentes ou verifique os filtros aplicados.</p>
                        <button class="hb-reset-search-btn">Limpar busca</button>
                    </div>
                    
                    <!-- Aqui seriam mostrados os resultados da busca -->
                    <!-- Simulação de resultados para demonstração do template -->
                    <div class="hb-result-item hb-video-result" data-type="videos" data-duration="medium" data-category="exclusive">
                        <div class="hb-thumbnail">
                            <img src="{{ asset('images/placeholder-video.jpg') }}" alt="Thumbnail do vídeo" loading="lazy">
                            <div class="hb-duration">12:45</div>
                            <div class="hb-content-badge exclusive">EXCLUSIVO</div>
                        </div>
                        <div class="hb-result-info">
                            <h3 class="hb-result-title">Vídeo Exclusivo com Modelos Premium</h3>
                            <div class="hb-result-meta">
                                <div class="hb-creator">Por <a href="#">Marcos Silva</a></div>
                                <div class="hb-views"><i class="lucide-eye"></i> 15.3K</div>
                                <div class="hb-date">Há 2 dias</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="hb-result-item hb-creator-result" data-type="creators">
                        <div class="hb-creator-card">
                            <div class="hb-creator-image">
                                <img src="{{ asset('images/placeholder-creator.jpg') }}" alt="Imagem do modelo" loading="lazy">
                                <div class="hb-creator-badges">
                                    <span class="hb-badge hb-badge-vip">VIP</span>
                                    <span class="hb-verified-badge"><i class="lucide-badge-check"></i></span>
                                </div>
                            </div>
                            <div class="hb-creator-info">
                                <h3>Rafael Mendes</h3>
                                <div class="hb-creator-stats">
                                    <div class="hb-stat"><i class="lucide-video"></i> 32</div>
                                    <div class="hb-stat"><i class="lucide-heart"></i> 8.5K</div>
                                </div>
                                <a href="#" class="hb-creator-action">Ver Perfil</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="hb-result-item hb-category-result" data-type="categories">
                        <div class="hb-category-card">
                            <div class="hb-category-icon">
                                <i class="lucide-folder"></i>
                            </div>
                            <div class="hb-category-info">
                                <h3>Amador</h3>
                                <p>359 vídeos</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mais resultados simulados para demonstração -->
                    <div class="hb-result-item hb-video-result" data-type="videos" data-duration="short" data-category="vip">
                        <div class="hb-thumbnail">
                            <img src="{{ asset('images/placeholder-video.jpg') }}" alt="Thumbnail do vídeo" loading="lazy">
                            <div class="hb-duration">8:30</div>
                            <div class="hb-content-badge vip">VIP</div>
                        </div>
                        <div class="hb-result-info">
                            <h3 class="hb-result-title">Conteúdo VIP com Entretenimento Premium</h3>
                            <div class="hb-result-meta">
                                <div class="hb-creator">Por <a href="#">André Torres</a></div>
                                <div class="hb-views"><i class="lucide-eye"></i> 8.7K</div>
                                <div class="hb-date">Há 5 dias</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="hb-result-item hb-video-result" data-type="videos" data-duration="long" data-category="ppv">
                        <div class="hb-thumbnail">
                            <img src="{{ asset('images/placeholder-video.jpg') }}" alt="Thumbnail do vídeo" loading="lazy">
                            <div class="hb-duration">45:12</div>
                            <div class="hb-content-badge ppv">PAY-PER-VIEW</div>
                        </div>
                        <div class="hb-result-info">
                            <h3 class="hb-result-title">Conteúdo Premium em Alta Qualidade</h3>
                            <div class="hb-result-meta">
                                <div class="hb-creator">Por <a href="#">Lucas Cardoso</a></div>
                                <div class="hb-views"><i class="lucide-eye"></i> 12.9K</div>
                                <div class="hb-date">Há 1 semana</div>
                            </div>
                            <div class="hb-ppv-price">
                                <span class="hb-price-tag">R$ 29,90</span>
                                <button class="hb-buy-btn">Comprar</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Paginação -->
            <div class="hb-pagination">
                <button class="hb-pagination-btn hb-prev" disabled>
                    <i class="lucide-chevron-left"></i>
                </button>
                <div class="hb-pagination-numbers">
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <span class="hb-pagination-dots">...</span>
                    <a href="#">10</a>
                </div>
                <button class="hb-pagination-btn hb-next">
                    <i class="lucide-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/search.js') }}"></script>
@endpush
