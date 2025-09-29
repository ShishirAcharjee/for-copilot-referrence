// Enhanced Hero Section JavaScript
document.addEventListener('DOMContentLoaded', function() {
    
    // Header scroll effect
    const header = document.getElementById('header');
    const hero = document.getElementById('hero');
    
    function handleScroll() {
        const scrolled = window.pageYOffset;
        const heroHeight = hero.offsetHeight;
        
        if (scrolled > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }
    
    // Mobile menu toggle
    const mobileMenu = document.getElementById('mobile-menu');
    const navMenu = document.querySelector('.nav-menu');
    
    mobileMenu.addEventListener('click', function() {
        mobileMenu.classList.toggle('active');
        navMenu.classList.toggle('active');
    });
    
    // Close mobile menu when clicking on a link
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            navMenu.classList.remove('active');
        });
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Parallax effect for hero background
    function handleParallax() {
        const scrolled = window.pageYOffset;
        const heroBackground = document.querySelector('.hero-background');
        if (heroBackground) {
            const speed = scrolled * 0.5;
            heroBackground.style.transform = `translateY(${speed}px)`;
        }
    }
    
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observe demo cards for scroll animations
    const demoCards = document.querySelectorAll('.demo-card');
    demoCards.forEach(card => {
        observer.observe(card);
    });
    
    // Throttle scroll events for performance
    let ticking = false;
    
    function updateOnScroll() {
        handleScroll();
        handleParallax();
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateOnScroll);
            ticking = true;
        }
    }
    
    // Event listeners
    window.addEventListener('scroll', requestTick, { passive: true });
    window.addEventListener('resize', handleScroll, { passive: true });
    
    // Initialize on load
    handleScroll();
    
    // Add loading class removal for smooth entrance
    setTimeout(() => {
        document.body.classList.add('loaded');
    }, 100);
    
    // Enhanced button interactions
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function(e) {
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Floating cards mouse tracking effect
    const floatingCards = document.querySelectorAll('.floating-card');
    const heroVisual = document.querySelector('.hero-visual');
    
    if (heroVisual && floatingCards.length > 0) {
        heroVisual.addEventListener('mousemove', (e) => {
            const rect = heroVisual.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            floatingCards.forEach((card, index) => {
                const speed = (index + 1) * 0.02;
                const moveX = (x - rect.width / 2) * speed;
                const moveY = (y - rect.height / 2) * speed;
                
                card.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });
        });
        
        heroVisual.addEventListener('mouseleave', () => {
            floatingCards.forEach(card => {
                card.style.transform = '';
            });
        });
    }
    
    // Scroll indicator auto-hide
    const scrollIndicator = document.querySelector('.hero-scroll-indicator');
    if (scrollIndicator) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            if (scrolled > 100) {
                scrollIndicator.style.opacity = '0';
            } else {
                scrollIndicator.style.opacity = '1';
            }
        }, { passive: true });
    }
    
    // Performance optimization: Reduce animations on low-end devices
    if (navigator.hardwareConcurrency && navigator.hardwareConcurrency <= 2) {
        document.documentElement.style.setProperty('--transition-smooth', '0.15s ease');
        document.documentElement.style.setProperty('--transition-slow', '0.2s ease');
    }
});

// WordPress compatibility functions
window.WordPressHero = {
    // Function to initialize hero section in WordPress theme
    init: function(options = {}) {
        const defaults = {
            headerSelector: '.site-header',
            heroSelector: '.hero-section',
            enableParallax: true,
            enableMobileMenu: true
        };
        
        const settings = Object.assign(defaults, options);
        
        // Custom initialization for WordPress themes
        if (settings.headerSelector !== '#header') {
            const customHeader = document.querySelector(settings.headerSelector);
            if (customHeader) {
                customHeader.id = 'header';
            }
        }
        
        if (settings.heroSelector !== '#hero') {
            const customHero = document.querySelector(settings.heroSelector);
            if (customHero) {
                customHero.id = 'hero';
            }
        }
        
        console.log('WordPress Hero Section initialized with settings:', settings);
    },
    
    // Function to update hero content dynamically
    updateContent: function(title, description, buttonText, buttonLink) {
        const heroTitle = document.querySelector('.hero-title');
        const heroDescription = document.querySelector('.hero-description');
        const primaryButton = document.querySelector('.btn-primary');
        
        if (heroTitle) heroTitle.innerHTML = title;
        if (heroDescription) heroDescription.textContent = description;
        if (primaryButton) {
            primaryButton.textContent = buttonText;
            primaryButton.href = buttonLink;
        }
    },
    
    // Function to set background image
    setBackgroundImage: function(imageUrl) {
        const heroBackground = document.querySelector('.hero-background');
        if (heroBackground && imageUrl) {
            heroBackground.style.backgroundImage = `url('${imageUrl}')`;
        }
    }
};