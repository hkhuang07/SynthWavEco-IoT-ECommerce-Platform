/**
 * ================================================
 * SYNWAVECO HOMEPAGE - LIVESHOW CAROUSEL MANAGER
 * ================================================
 * 
 * Manages the featured products and articles 
 * liveshow carousels with smooth transitions
 */

(function() {
    'use strict';

    // Configuration
    const CONFIG = {
        autoplayDelay: 5000,        // 5 seconds
        transitionSpeed: 600,       // 600ms
        enableKeyboard: true,
        enableMouseWheel: false,
        enableTouchSwipe: true,
        fadeEffect: true
    };

    // State Management
    const state = {
        productsSwiper: null,
        articlesSwiper: null,
        isAutoplayEnabled: true,
        currentProductIndex: 0,
        currentArticleIndex: 0
    };

    /**
     * Initialize Swiper Carousels
     */
    function initializeSwipers() {
        // Initialize Products Swiper
        if (document.querySelector('.hero-products-swiper')) {
            state.productsSwiper = new Swiper('.hero-products-swiper', {
                loop: true,
                speed: CONFIG.transitionSpeed,
                effect: CONFIG.fadeEffect ? 'fade' : 'slide',
                fadeEffect: {
                    crossFade: true
                },
                autoplay: {
                    delay: CONFIG.autoplayDelay,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
                pagination: {
                    el: '.hero-products-section .hero-pagination',
                    clickable: true,
                    dynamicBullets: false,
                    type: 'bullets'
                },
                keyboard: CONFIG.enableKeyboard ? {
                    enabled: true,
                    onlyInViewport: true
                } : false,
                touchEventsTarget: CONFIG.enableTouchSwipe ? 'wrapper' : 'container',
                slidesPerView: 1,
                spaceBetween: 0,
                on: {
                    slideChange: function() {
                        state.currentProductIndex = this.realIndex;
                        handleProductSlideChange();
                    },
                    autoplay: function() {
                        updateAutoplayIndicator('products');
                    }
                }
            });
        }

        // Initialize Articles Swiper
        if (document.querySelector('.hero-articles-swiper')) {
            state.articlesSwiper = new Swiper('.hero-articles-swiper', {
                loop: true,
                speed: CONFIG.transitionSpeed,
                effect: CONFIG.fadeEffect ? 'fade' : 'slide',
                fadeEffect: {
                    crossFade: true
                },
                autoplay: {
                    delay: CONFIG.autoplayDelay,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
                pagination: {
                    el: '.hero-articles-section .hero-pagination',
                    clickable: true,
                    dynamicBullets: false,
                    type: 'bullets'
                },
                keyboard: CONFIG.enableKeyboard ? {
                    enabled: true,
                    onlyInViewport: true
                } : false,
                touchEventsTarget: CONFIG.enableTouchSwipe ? 'wrapper' : 'container',
                slidesPerView: 1,
                spaceBetween: 0,
                on: {
                    slideChange: function() {
                        state.currentArticleIndex = this.realIndex;
                        handleArticleSlideChange();
                    },
                    autoplay: function() {
                        updateAutoplayIndicator('articles');
                    }
                }
            });
        }

        // Initialize Categories Carousel
        if (document.querySelector('.categories-swiper')) {
            new Swiper('.categories-swiper', {
                slidesPerView: 'auto',
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false
                },
                breakpoints: {
                    320: {
                        spaceBetween: 10
                    },
                    768: {
                        spaceBetween: 15
                    },
                    1024: {
                        spaceBetween: 20
                    }
                }
            });
        }
    }

    /**
     * Handle Product Slide Change
     */
    function handleProductSlideChange() {
        const productItems = document.querySelectorAll('.hero-product-item');
        productItems.forEach((item, index) => {
            if (index === state.currentProductIndex) {
                item.classList.add('active');
                item.style.animation = 'slideInRight 0.6s ease-out';
            } else {
                item.classList.remove('active');
            }
        });

        // Trigger analytics if available
        if (window.gtag) {
            gtag('event', 'featured_product_viewed', {
                product_index: state.currentProductIndex
            });
        }
    }

    /**
     * Handle Article Slide Change
     */
    function handleArticleSlideChange() {
        const articleItems = document.querySelectorAll('.hero-article-item');
        articleItems.forEach((item, index) => {
            if (index === state.currentArticleIndex) {
                item.classList.add('active');
                item.style.animation = 'slideInUp 0.6s ease-out';
            } else {
                item.classList.remove('active');
            }
        });

        // Trigger analytics if available
        if (window.gtag) {
            gtag('event', 'featured_article_viewed', {
                article_index: state.currentArticleIndex
            });
        }
    }

    /**
     * Update Autoplay Indicator
     */
    function updateAutoplayIndicator(type) {
        const indicator = document.querySelector(
            type === 'products' 
                ? '.hero-products-section::after' 
                : '.hero-articles-section::after'
        );
        if (indicator) {
            indicator.style.animation = 'slideProgress 5s linear';
            setTimeout(() => {
                indicator.style.animation = 'none';
            }, 50);
        }
    }

    /**
     * Add Keyboard Navigation Controls
     */
    function setupKeyboardControls() {
        document.addEventListener('keydown', function(e) {
            if (!state.isAutoplayEnabled) return;

            const productsSection = document.querySelector('.hero-products-section');
            const articlesSection = document.querySelector('.hero-articles-section');

            if (e.key === 'ArrowLeft') {
                if (state.productsSwiper) state.productsSwiper.slidePrev();
                if (state.articlesSwiper) state.articlesSwiper.slidePrev();
            } else if (e.key === 'ArrowRight') {
                if (state.productsSwiper) state.productsSwiper.slideNext();
                if (state.articlesSwiper) state.articlesSwiper.slideNext();
            } else if (e.key === ' ') {
                e.preventDefault();
                toggleAutoplay();
            }
        });
    }

    /**
     * Toggle Autoplay
     */
    function toggleAutoplay() {
        state.isAutoplayEnabled = !state.isAutoplayEnabled;

        if (state.productsSwiper) {
            if (state.isAutoplayEnabled) {
                state.productsSwiper.autoplay.start();
            } else {
                state.productsSwiper.autoplay.stop();
            }
        }

        if (state.articlesSwiper) {
            if (state.isAutoplayEnabled) {
                state.articlesSwiper.autoplay.start();
            } else {
                state.articlesSwiper.autoplay.stop();
            }
        }

        updateAutoplayUI();
    }

    /**
     * Update Autoplay UI
     */
    function updateAutoplayUI() {
        const indicator = document.createElement('div');
        indicator.className = 'autoplay-indicator';
        indicator.textContent = state.isAutoplayEnabled ? 'Auto' : 'Paused';
        indicator.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${state.isAutoplayEnabled ? '#00CD66' : '#FF3030'};
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            z-index: 1000;
            animation: fadeIn 0.3s ease-in;
        `;

        // Remove existing indicator
        const existing = document.querySelector('.autoplay-indicator');
        if (existing) existing.remove();

        // Add new indicator
        document.body.appendChild(indicator);

        // Auto-remove indicator
        setTimeout(() => {
            indicator.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => indicator.remove(), 300);
        }, 2000);
    }

    /**
     * Setup Mouse/Touch Controls
     */
    function setupMouseControls() {
        const productsSection = document.querySelector('.hero-products-section');
        const articlesSection = document.querySelector('.hero-articles-section');

        if (productsSection) {
            productsSection.addEventListener('mouseenter', function() {
                if (state.productsSwiper && state.productsSwiper.autoplay) {
                    state.productsSwiper.autoplay.pause();
                }
                showNavigationHints(productsSection);
            });

            productsSection.addEventListener('mouseleave', function() {
                if (state.productsSwiper && state.productsSwiper.autoplay) {
                    state.productsSwiper.autoplay.resume();
                }
                hideNavigationHints(productsSection);
            });

            // Click to navigate
            productsSection.addEventListener('click', function(e) {
                const rect = productsSection.getBoundingClientRect();
                const centerX = rect.width / 2;
                const clickX = e.clientX - rect.left;

                if (clickX < centerX) {
                    state.productsSwiper.slidePrev();
                } else {
                    state.productsSwiper.slideNext();
                }
            });
        }

        if (articlesSection) {
            articlesSection.addEventListener('mouseenter', function() {
                if (state.articlesSwiper && state.articlesSwiper.autoplay) {
                    state.articlesSwiper.autoplay.pause();
                }
                showNavigationHints(articlesSection);
            });

            articlesSection.addEventListener('mouseleave', function() {
                if (state.articlesSwiper && state.articlesSwiper.autoplay) {
                    state.articlesSwiper.autoplay.resume();
                }
                hideNavigationHints(articlesSection);
            });

            // Click to navigate
            articlesSection.addEventListener('click', function(e) {
                const rect = articlesSection.getBoundingClientRect();
                const centerX = rect.width / 2;
                const clickX = e.clientX - rect.left;

                if (clickX < centerX) {
                    state.articlesSwiper.slidePrev();
                } else {
                    state.articlesSwiper.slideNext();
                }
            });
        }
    }

    /**
     * Show Navigation Hints
     */
    function showNavigationHints(element) {
        const hint = element.getAttribute('data-hint');
        if (hint) return; // Already shown

        const hintEl = document.createElement('div');
        hintEl.className = 'navigation-hint';
        hintEl.innerHTML = `
            <div class="hint-arrow hint-left">← Click</div>
            <div class="hint-arrow hint-right">Click →</div>
        `;
        hintEl.style.cssText = `
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            padding: 0 2rem;
            transform: translateY(-50%);
            pointer-events: none;
            z-index: 5;
        `;

        element.style.position = 'relative';
        element.appendChild(hintEl);
        element.setAttribute('data-hint', 'shown');
    }

    /**
     * Hide Navigation Hints
     */
    function hideNavigationHints(element) {
        const hint = element.querySelector('.navigation-hint');
        if (hint) {
            hint.remove();
            element.removeAttribute('data-hint');
        }
    }

    /**
     * Setup Scroll Animations
     */
    function setupScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.querySelectorAll(
            '.topic-card, .category-card, .manufacturer-item, .feature-card, .partnership-card'
        ).forEach(el => {
            observer.observe(el);
        });
    }

    /**
     * Setup Responsive Behaviors
     */
    function setupResponsiveBehaviors() {
        const mediaQuery = window.matchMedia('(max-width: 768px)');

        function handleResponsive(e) {
            if (e.matches) {
                // Mobile view
                CONFIG.autoplayDelay = 4000;
            } else {
                // Desktop view
                CONFIG.autoplayDelay = 5000;
            }

            // Update swipers with new delay
            if (state.productsSwiper && state.productsSwiper.autoplay) {
                state.productsSwiper.autoplay.start();
            }
            if (state.articlesSwiper && state.articlesSwiper.autoplay) {
                state.articlesSwiper.autoplay.start();
            }
        }

        mediaQuery.addEventListener('change', handleResponsive);
        handleResponsive(mediaQuery);
    }

    /**
     * Add Analytics Tracking
     */
    function setupAnalytics() {
        if (!window.gtag) return;

        // Track page view
        gtag('event', 'page_view', {
            page_title: 'Home',
            page_location: window.location.href
        });

        // Track carousel interactions
        document.addEventListener('click', function(e) {
            if (e.target.closest('.swiper-pagination-bullet')) {
                const parent = e.target.closest('.swiper-pagination');
                const type = parent.classList.contains('hero-products-section') 
                    ? 'product' 
                    : 'article';
                
                gtag('event', 'carousel_pagination', {
                    carousel_type: type,
                    button_index: Array.from(parent.querySelectorAll('.swiper-pagination-bullet')).indexOf(e.target)
                });
            }
        });
    }

    /**
     * Main Initialization
     */
    function init() {
        // Wait for Swiper to be loaded
        if (typeof Swiper === 'undefined') {
            console.warn('Swiper not loaded. Retrying...');
            setTimeout(init, 500);
            return;
        }

        // Initialize all components
        initializeSwipers();
        setupKeyboardControls();
        setupMouseControls();
        setupScrollAnimations();
        setupResponsiveBehaviors();
        setupAnalytics();

        // Emit custom event
        window.dispatchEvent(new CustomEvent('liveshowInitialized', {
            detail: { state: state }
        }));

        console.log('✓ Liveshow Manager Initialized');
    }

    /**
     * Public API
     */
    window.LiveshowManager = {
        toggleAutoplay: toggleAutoplay,
        nextProduct: () => state.productsSwiper?.slideNext(),
        prevProduct: () => state.productsSwiper?.slidePrev(),
        nextArticle: () => state.articlesSwiper?.slideNext(),
        prevArticle: () => state.articlesSwiper?.slidePrev(),
        goToProduct: (index) => state.productsSwiper?.slideTo(index),
        goToArticle: (index) => state.articlesSwiper?.slideTo(index),
        getState: () => ({ ...state }),
        updateConfig: (config) => Object.assign(CONFIG, config)
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

/**
 * Utility: Add fade animations
 */
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-visible {
        animation: fadeIn 0.6s ease-in-out;
    }
`;
document.head.appendChild(style);
