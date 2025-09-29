# Enhanced Hero Section for WordPress

A modern, responsive hero section with transparent header functionality designed for WordPress themes. Features smooth animations, gradient overlays, floating cards, and comprehensive customization options.

## Features

### 🎨 Design Elements
- **Transparent Header**: Becomes solid on scroll with smooth transitions
- **Background Support**: Custom background images with gradient overlays
- **Floating Cards**: Interactive animated cards with hover effects
- **Gradient Text**: Eye-catching animated gradient text effects
- **Scroll Indicator**: Animated scroll indicator with auto-hide functionality

### 📱 Responsive Design
- Mobile-first approach
- Breakpoints for tablet and desktop
- Touch-friendly mobile menu
- Optimized for all screen sizes
- Retina display ready

### ⚡ Performance
- CSS Grid and Flexbox layout
- Hardware-accelerated animations
- Lazy loading compatible
- Optimized for Core Web Vitals
- Minimal JavaScript footprint

### 🔧 WordPress Integration
- Customizer integration
- Theme mod support
- Action hooks and filters
- Schema markup
- SEO optimized

## Installation

### Method 1: Direct Integration

1. **Copy files to your theme directory:**
   ```
   your-theme/
   ├── assets/
   │   ├── css/
   │   │   └── hero-section.css
   │   └── js/
   │       └── hero-section.js
   ├── template-parts/
   │   └── hero-section.php
   └── functions.php (add the hero section functions)
   ```

2. **Add to your theme's functions.php:**
   ```php
   // Include hero section functions
   require_once get_template_directory() . '/inc/hero-section-functions.php';
   ```

3. **Include in your template:**
   ```php
   // In front-page.php, index.php, or page.php
   get_template_part('template-parts/hero-section');
   ```

### Method 2: Plugin Integration

1. Create a custom plugin with the provided files
2. Activate the plugin
3. Use shortcode `[enhanced_hero]` or template function

## Usage

### Basic Template Usage

```php
<?php
// Include in your template file (front-page.php, page.php, etc.)
get_template_part('template-parts/hero-section');
?>
```

### Customizer Integration

The hero section adds a new "Hero Section" panel in the WordPress Customizer with the following options:

#### Content Settings
- **Hero Title**: Main headline with HTML support
- **Hero Description**: Subtitle text
- **Primary Button Text & URL**: Main call-to-action button
- **Secondary Button Text & URL**: Secondary action button

#### Visual Settings
- **Background Image**: Optional hero background
- **Enable Floating Cards**: Toggle animated cards
- **Enable Scroll Indicator**: Toggle scroll arrow

### Programmatic Customization

```php
// Update hero content dynamically
function customize_hero_content() {
    add_filter('hero_card_1_icon', function() { return '🎯'; });
    add_filter('hero_card_1_text', function() { return 'Targeting'; });
    
    add_filter('hero_card_2_icon', function() { return '⚡'; });
    add_filter('hero_card_2_text', function() { return 'Speed'; });
    
    add_filter('hero_card_3_icon', function() { return '🔒'; });
    add_filter('hero_card_3_text', function() { return 'Security'; });
}
add_action('init', 'customize_hero_content');
```

## Configuration Options

### CSS Custom Properties

The hero section uses CSS custom properties for easy customization:

```css
:root {
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    --accent-color: #10b981;
    --text-primary: #1f2937;
    --text-light: #ffffff;
    --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --transition-smooth: 0.3s ease;
}
```

### JavaScript Options

```javascript
// Initialize with custom options
WordPressHero.init({
    headerSelector: '.site-header',
    heroSelector: '.hero-section',
    enableParallax: true,
    enableMobileMenu: true
});

// Update content dynamically
WordPressHero.updateContent(
    'New Title',
    'New description',
    'New Button Text',
    '/new-link'
);

// Set background image
WordPressHero.setBackgroundImage('/path/to/image.jpg');
```

## Customization Examples

### Changing Colors

```css
/* Override primary colors */
:root {
    --primary-color: #ff6b6b;
    --primary-dark: #ee5a52;
    --gradient-primary: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
}
```

### Custom Button Styles

```css
.btn-primary {
    background: linear-gradient(45deg, #ff6b6b, #ffa500);
    border-radius: 25px;
    padding: 1rem 2rem;
}

.btn-primary:hover {
    transform: translateY(-3px) scale(1.05);
}
```

### Adding Custom Animations

```css
@keyframes customFadeIn {
    from {
        opacity: 0;
        transform: translateY(50px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.hero-content {
    animation: customFadeIn 1s ease-out;
}
```

## Browser Support

- **Modern Browsers**: Chrome 60+, Firefox 60+, Safari 12+, Edge 79+
- **Mobile**: iOS Safari 12+, Chrome Mobile 60+
- **Fallbacks**: Graceful degradation for older browsers
- **Features**: CSS Grid, Flexbox, CSS Custom Properties, backdrop-filter

## Performance Optimization

### Loading Performance
- Critical CSS inlined
- Non-critical resources lazy loaded
- Preload hints for fonts and images
- Optimized animation performance

### Best Practices
- Use WebP images with fallbacks
- Optimize background images
- Enable browser caching
- Minimize reflows and repaints

## Accessibility Features

- **Keyboard Navigation**: Full keyboard support
- **Screen Readers**: Proper ARIA labels and semantic HTML
- **Reduced Motion**: Respects `prefers-reduced-motion`
- **Color Contrast**: WCAG AA compliant color ratios
- **Focus Management**: Visible focus indicators

## SEO Optimization

- **Schema Markup**: Structured data for better search results
- **Semantic HTML**: Proper heading hierarchy
- **Meta Tags**: Dynamic Open Graph and Twitter Card support
- **Performance**: Optimized Core Web Vitals

## Troubleshooting

### Common Issues

1. **Header not becoming solid on scroll**
   - Check if `#header` ID is present
   - Verify JavaScript is loaded
   - Check for JavaScript errors in console

2. **Animations not working**
   - Verify CSS animations are enabled
   - Check for `prefers-reduced-motion` setting
   - Ensure proper CSS loading order

3. **Mobile menu not working**
   - Check if mobile menu toggle has correct ID
   - Verify click event listeners are attached
   - Test on actual mobile devices

### Debug Mode

Enable debug mode by adding to your wp-config.php:
```php
define('HERO_SECTION_DEBUG', true);
```

This will:
- Log JavaScript events to console
- Show CSS loading status
- Display performance metrics

## License

MIT License - feel free to use in commercial and personal projects.

## Support

For issues and feature requests, please create an issue in the GitHub repository.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## Changelog

### Version 1.0.0
- Initial release
- Transparent header functionality
- Responsive hero section
- WordPress Customizer integration
- Floating cards animation
- Mobile menu support
- Performance optimizations
- Accessibility features