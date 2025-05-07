// HotBoys - Componente React moderno para página de planos premium
// Implementação com hooks, animações e design responsivo

// Importações necessárias (adicione ao seu projeto)
// import React, { useState, useEffect, useRef } from 'react';
// import axios from 'axios';
// import { motion, AnimatePresence } from 'framer-motion';

// Componente principal para a página de planos
const PlansPage = () => {
  // Estados para gerenciar os dados e UI
  const [plans, setPlans] = useState([]);
  const [isLoading, setIsLoading] = useState(true);
  const [selectedPaymentType, setSelectedPaymentType] = useState('pix'); // 'pix' ou 'cartao'
  const [error, setError] = useState(null);
  
  // Refs para animações de interseção
  const plansRef = useRef(null);
  
  // Efeito para carregar dados dos planos
  useEffect(() => {
    const fetchPlans = async () => {
      try {
        setIsLoading(true);
        
        // Simular tempo de carregamento para UX
        await new Promise(resolve => setTimeout(resolve, 800));
        
        // Chamada à API
        const response = await axios.get('/api/planos/principais');
        
        // Organizar os planos por duração
        const plansMap = new Map();
        
        response.data.forEach(plan => {
          // Verificar se já existe um plano com esta duração
          const existingPlan = plansMap.get(plan.duracao_dias);
          
          // Substituir o plano existente apenas se: 
          // 1. Não existe plano para esta duração ainda, ou
          // 2. O tipo de pagamento do plano coincide com o selecionado e difere do existente
          if (!existingPlan || 
              (existingPlan.tipo_pagamento !== plan.tipo_pagamento && 
               plan.tipo_pagamento === selectedPaymentType)) {
            plansMap.set(plan.duracao_dias, plan);
          }
          
          // Caso especial: Se este plano for marcado como popular (180 dias) e tiver o tipo
          // de pagamento selecionado, garantimos que ele seja usado
          if (plan.popular === 1 && plan.tipo_pagamento === selectedPaymentType) {
            plansMap.set(plan.duracao_dias, plan);
          }
        });
        
        // Converter para array e ordenar
        const sortedPlans = Array.from(plansMap.values()).sort((a, b) => a.duracao_dias - b.duracao_dias);
        
        setPlans(sortedPlans);
        setIsLoading(false);
      } catch (err) {
        console.error('Erro ao carregar planos:', err);
        setError('Não foi possível carregar os planos. Tente novamente mais tarde.');
        setIsLoading(false);
      }
    };
    
    fetchPlans();
  }, [selectedPaymentType]);
  
  // Efeito para animações baseadas em interseção
  useEffect(() => {
    // Configurar observador de interseção para animações ao scrollar
    const options = {
      threshold: 0.1,
      rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate-in');
          observer.unobserve(entry.target);
        }
      });
    }, options);
    
    // Observar elementos para animação
    const planCards = document.querySelectorAll('.plan-card');
    planCards.forEach(card => {
      observer.observe(card);
    });
    
    // Cleanup
    return () => {
      planCards.forEach(card => {
        observer.unobserve(card);
      });
    };
  }, [plans]);
  
  // Funções auxiliares
  const formatCurrency = (value) => {
    return new Intl.NumberFormat('pt-BR', {
      style: 'currency',
      currency: 'BRL'
    }).format(value);
  };
  
  const calculateSavings = (regularPrice, discountPrice) => {
    const savings = ((regularPrice - discountPrice) / regularPrice) * 100;
    return Math.round(savings);
  };
  
  const getDurationText = (days) => {
    switch (days) {
      case 30: return 'Mensal';
      case 180: return 'Semestral';
      case 365: return 'Anual';
      default: return `${days} dias`;
    }
  };
  
  // Alternar entre métodos de pagamento
  const togglePaymentType = (type) => {
    setSelectedPaymentType(type);
  };
  
  // Rendererização condicional para estado de carregamento
  if (isLoading) {
    return (
      <div className="plans-container loading-state">
        <div className="plans-header">
          <h1 className="plans-title">Carregando <span>Planos</span>...</h1>
          <div className="loader-container">
            <div className="pulse-loader"></div>
          </div>
        </div>
      </div>
    );
  }
  
  // Renderização para estado de erro
  if (error) {
    return (
      <div className="plans-container error-state">
        <div className="plans-header">
          <h1 className="plans-title">Oops! <span>Algo deu errado</span></h1>
          <p className="plans-subtitle">{error}</p>
          <button className="cta-button" onClick={() => window.location.reload()}>
            <i className="fas fa-sync-alt"></i> Tentar Novamente
          </button>
        </div>
      </div>
    );
  }
  
  return (
    <div className="plans-container" ref={plansRef}>
      {/* Cabeçalho Principal */}
      <motion.div 
        className="plans-header"
        initial={{ opacity: 0, y: 30 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.6, ease: "easeOut" }}
      >
        <h1 className="plans-title">Escolha seu <span>Plano Premium</span></h1>
        <p className="plans-subtitle">
          Acesso ilimitado ao conteúdo mais quente do Brasil com atualizações semanais.
          Escolha o plano que combina com você.
        </p>
      </motion.div>
      
      {/* Seletor de Método de Pagamento */}
      <motion.div 
        className="tabs-header"
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.5, delay: 0.2 }}
      >
        <button 
          className={`tab-link ${selectedPaymentType === 'pix' ? 'active' : ''}`}
          onClick={() => togglePaymentType('pix')}
        >
          <i className="fas fa-qrcode"></i> PIX
        </button>
        <button 
          className={`tab-link ${selectedPaymentType === 'cartao' ? 'active' : ''}`}
          onClick={() => togglePaymentType('cartao')}
        >
          <i className="fas fa-credit-card"></i> Cartão
        </button>
      </motion.div>
      
      {/* Grid de Planos */}
      <motion.div 
        className="plans-grid"
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        transition={{ duration: 0.5, delay: 0.4 }}
      >
        <AnimatePresence>
          {plans.map((plan, index) => {
            // Determinar se é plano em destaque com base no atributo popular ou outros critérios
            // Agora permitimos que outros planos também sejam destacados
            const isFeatured = plan.popular === 1 || 
                              (plan.duracao_dias === 90) || // Adiciona destaque para planos trimestrais
                              (plan.duracao_dias === 365 && plan.tipo === 'premium'); // Adiciona destaque para planos anuais premium
            
            // Calcular economia (comparado com mensal)
            const monthlyPlan = plans.find(p => p.duracao_dias === 30);
            const monthlyEquivalent = monthlyPlan ? (monthlyPlan.valor * (plan.duracao_dias / 30)) : 0;
            const savings = monthlyEquivalent > 0 ? calculateSavings(monthlyEquivalent, plan.valor) : 0;
            
            return (
              <motion.div
                key={plan.id}
                className={`plan-card ${isFeatured ? 'featured' : ''}`}
                initial={{ opacity: 0, y: 50 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ 
                  duration: 0.6, 
                  delay: 0.3 + (index * 0.2),
                  ease: "easeOut"
                }}
                whileHover={{ 
                  y: -15,
                  transition: { duration: 0.3, ease: "easeOut" }
                }}
              >
                {/* Background spotlight effect */}
                <div className="spotlight"></div>
                
                {/* Cabeçalho do plano */}
                <div className="plan-head">
                  {isFeatured && (
                    <div className="plan-badge">Mais Popular</div>
                  )}
                  
                  <h3 className="plan-name">
                    Plano {getDurationText(plan.duracao_dias)}
                  </h3>
                  
                  <div className="plan-price" data-price={plan.valor}>
                    <span className="currency">R$</span>
                    <span className="price-value">{formatCurrency(plan.valor).replace('R$', '')}</span>
                  </div>
                  
                  <div className="plan-period">
                    {plan.duracao_dias === 30 ? 'por mês' : `por ${plan.duracao_dias / 30} meses`}
                  </div>
                  
                  {savings > 0 && (
                    <div className="save-badge">
                      Economize {savings}%
                    </div>
                  )}
                </div>
                
                {/* Lista de recursos */}
                <ul className="plan-features">
                  <li className="feature-item highlight">
                    <i className="fas fa-check-circle"></i>
                    <span>Acesso Ilimitado ao Conteúdo</span>
                  </li>
                  <li className="feature-item">
                    <i className="fas fa-check-circle"></i>
                    <span>Atualizações Semanais</span>
                  </li>
                  <li className="feature-item">
                    <i className="fas fa-check-circle"></i>
                    <span>Conteúdo Exclusivo</span>
                  </li>
                  
                  {plan.duracao_dias === 30 && (
                    <li className="feature-item">
                      <i className="fas fa-check-circle"></i>
                      <span>Cancele Quando Quiser</span>
                    </li>
                  )}
                  
                  {isFeatured && (
                    <li className="feature-item highlight">
                      <i className="fas fa-star"></i>
                      <span>Plano Mais Escolhido</span>
                    </li>
                  )}
                  
                  {plan.duracao_dias === 365 && (
                    <li className="feature-item highlight">
                      <i className="fas fa-award"></i>
                      <span>Estabilidade e Comprometimento</span>
                    </li>
                  )}
                  
                  {(plan.duracao_dias === 180 || plan.duracao_dias === 365) && (
                    <li className="feature-item">
                      <i className="fas fa-check-circle"></i>
                      <span>Suporte Prioritário</span>
                    </li>
                  )}
                </ul>
                
                {/* Botão de ação */}
                <div className="plan-action">
                  <button 
                    className={`plan-button ${isFeatured ? 'primary-button' : 'secondary-button'}`}
                    onClick={() => window.location.href = `/checkout/${plan.id}`}
                  >
                    <i className="fas fa-fire"></i>
                    Assine Já
                  </button>
                </div>
              </motion.div>
            );
          })}
        </AnimatePresence>
      </motion.div>
      
      {/* Seção CTA */}
      <motion.div 
        className="plans-cta"
        initial={{ opacity: 0, y: 50 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.7, delay: 0.8 }}
      >
        <h2 className="cta-title">Entre para o Clube</h2>
        <p className="cta-text">
          Junte-se a milhares de assinantes satisfeitos e tenha acesso ao melhor 
          conteúdo adulto brasileiro. Assine agora e comece a aproveitar imediatamente!
        </p>
        <button className="cta-button" onClick={() => window.location.href = '#plans'}>
          <i className="fas fa-arrow-up"></i>
          Escolha seu Plano
        </button>
      </motion.div>
    </div>
  );
};

// Componente para ser montado no DOM
const mountPlansComponent = () => {
  const root = document.getElementById('plans-react-root');
  if (root) {
    // Para React 18:
    const reactRoot = ReactDOM.createRoot(root);
    reactRoot.render(React.createElement(PlansPage));
  }
};

// Inicializador
document.addEventListener('DOMContentLoaded', () => {
  // Se já estiver utilizando React no projeto
  if (typeof React !== 'undefined' && typeof ReactDOM !== 'undefined') {
    mountPlansComponent();
  } else {
    // Carregar React dinamicamente
    const loadReactDependencies = () => {
      // Carregar React
      const reactScript = document.createElement('script');
      reactScript.src = 'https://unpkg.com/react@18/umd/react.production.min.js';
      reactScript.crossOrigin = '';
      
      // Carregar ReactDOM
      const reactDOMScript = document.createElement('script');
      reactDOMScript.src = 'https://unpkg.com/react-dom@18/umd/react-dom.production.min.js';
      reactDOMScript.crossOrigin = '';
      
      // Carregar Framer Motion (opcional para animações avançadas)
      const framerScript = document.createElement('script');
      framerScript.src = 'https://unpkg.com/framer-motion@10.12.16/dist/framer-motion.umd.min.js';
      framerScript.crossOrigin = '';
      
      // Carregar Babel para JSX (apenas para desenvolvimento)
      const babelScript = document.createElement('script');
      babelScript.src = 'https://unpkg.com/babel-standalone@6/babel.min.js';
      
      // Adicionar scripts ao documento
      document.head.appendChild(reactScript);
      document.head.appendChild(reactDOMScript);
      document.head.appendChild(framerScript);
      document.head.appendChild(babelScript);
      
      // Esperar carregamento
      reactDOMScript.onload = () => {
        // Criar elemento para a montagem
        const plansRoot = document.createElement('div');
        plansRoot.id = 'plans-react-root';
        
        // Substituir container existente ou adicionar ao DOM
        const plansContainer = document.querySelector('.plans-container');
        if (plansContainer) {
          plansContainer.parentNode.replaceChild(plansRoot, plansContainer);
        } else {
          document.querySelector('main') || document.body.appendChild(plansRoot);
        }
        
        // Montar componente
        mountPlansComponent();
      };
    };
    
    // Iniciar carregamento
    loadReactDependencies();
  }
  
  // Para compatibilidade com código existente, manter animações antigas
  // para elementos que não são do React
});

// Backend - Rota de API para fornecer os planos (Laravel)
/*
Route::get('/api/planos/principais', 'PlanoController@getPrincipais');

// Controller
public function getPrincipais()
{
    $planos = DB::select("
        SELECT p1.*
        FROM planos p1
        JOIN (
            SELECT duracao_dias, 
                   MIN(CASE WHEN tipo_pagamento = 'cartao' AND popular = 1 THEN id 
                            WHEN tipo_pagamento = 'cartao' THEN id ELSE NULL END) as id_cartao,
                   MIN(CASE WHEN tipo_pagamento = 'pix' AND popular = 1 THEN id
                            WHEN tipo_pagamento = 'pix' THEN id ELSE NULL END) as id_pix
            FROM planos
            WHERE duracao_dias IN (30, 180, 365) AND status = 'ativo'
            GROUP BY duracao_dias
        ) p2 ON p1.duracao_dias = p2.duracao_dias AND (p1.id = p2.id_cartao OR p1.id = p2.id_pix)
        ORDER BY p1.duracao_dias, p1.tipo_pagamento
    ");

    return response()->json($planos);
}
*/