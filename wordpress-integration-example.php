<?php
/**
 * WordPress Integration Example
 * 
 * This file shows how to integrate the enhanced hero section
 * into different WordPress theme structures.
 * 
 * @package WordPress
 * @subpackage Hero_Section
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Example 1: Integration with header.php
 * Add this to your theme's header.php file
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- Enhanced Header with Hero Integration -->
<header class="header" id="header">
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>
            
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'nav-menu',
                'fallback_cb' => 'wp_page_menu',
                'walker' => new Hero_Nav_Walker(),
            ));
            ?>
            
            <div class="nav-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>
</header>

<?php
/**
 * Example 2: Front Page Template (front-page.php)
 */
?>
<?php get_header(); ?>

<!-- Include Hero Section -->
<?php get_template_part('template-parts/hero-section'); ?>

<!-- Rest of front page content -->
<main id="main" class="site-main">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <div class="container">
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </div>
        <?php
    endwhile;
    ?>
</main>

<?php get_footer(); ?>

<?php
/**
 * Example 3: Custom Page Template (page-hero.php)
 */
?>
<?php
/*
Template Name: Hero Landing Page
*/
get_header(); ?>

<?php get_template_part('template-parts/hero-section'); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>

<?php
/**
 * Example 4: Custom Navigation Walker
 * Extend WP's navigation walker for hero section compatibility
 */
class Hero_Nav_Walker extends Walker_Nav_Menu {
    
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }
    
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
        $attributes .= ! empty($item->xfn) ? ' rel="'    . esc_attr($item->xfn) .'"' : '';
        $attributes .= ! empty($item->url) ? ' href="'   . esc_attr($item->url) .'"' : '';
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a class="nav-link"' . $attributes .'>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}

/**
 * Example 5: Shortcode Implementation
 */
function hero_section_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => get_theme_mod('hero_title', 'Transform Your Digital Presence'),
        'description' => get_theme_mod('hero_description', 'Create stunning websites that drive results.'),
        'button_text' => get_theme_mod('hero_button_primary_text', 'Get Started'),
        'button_url' => get_theme_mod('hero_button_primary_url', '#contact'),
        'background_image' => get_theme_mod('hero_background_image', ''),
        'show_cards' => get_theme_mod('enable_floating_cards', true),
    ), $atts, 'enhanced_hero');
    
    ob_start();
    
    // Set temporary theme mods for the shortcode
    set_theme_mod('hero_title', $atts['title']);
    set_theme_mod('hero_description', $atts['description']);
    set_theme_mod('hero_button_primary_text', $atts['button_text']);
    set_theme_mod('hero_button_primary_url', $atts['button_url']);
    set_theme_mod('hero_background_image', $atts['background_image']);
    set_theme_mod('enable_floating_cards', $atts['show_cards']);
    
    // Load the hero section template
    get_template_part('template-parts/hero-section');
    
    return ob_get_clean();
}
add_shortcode('enhanced_hero', 'hero_section_shortcode');

/**
 * Example 6: Gutenberg Block Registration
 */
function register_hero_section_block() {
    if (function_exists('register_block_type')) {
        register_block_type('theme/hero-section', array(
            'editor_script' => 'hero-section-block-editor',
            'editor_style' => 'hero-section-block-editor-style',
            'style' => 'hero-section-block-style',
            'render_callback' => 'render_hero_section_block',
            'attributes' => array(
                'title' => array(
                    'type' => 'string',
                    'default' => 'Transform Your Digital Presence',
                ),
                'description' => array(
                    'type' => 'string',
                    'default' => 'Create stunning websites that drive results.',
                ),
                'buttonText' => array(
                    'type' => 'string',
                    'default' => 'Get Started',
                ),
                'buttonUrl' => array(
                    'type' => 'string',
                    'default' => '#contact',
                ),
                'backgroundImage' => array(
                    'type' => 'string',
                    'default' => '',
                ),
                'showCards' => array(
                    'type' => 'boolean',
                    'default' => true,
                ),
            ),
        ));
    }
}
add_action('init', 'register_hero_section_block');

function render_hero_section_block($attributes) {
    return hero_section_shortcode($attributes);
}

/**
 * Example 7: Theme Customizer Live Preview
 */
function hero_section_customizer_live_preview() {
    wp_enqueue_script(
        'hero-section-customizer',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array('jquery', 'customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'hero_section_customizer_live_preview');

/**
 * Example 8: Plugin Compatibility
 */
function hero_section_plugin_compatibility() {
    // Elementor compatibility
    if (defined('ELEMENTOR_VERSION')) {
        add_action('elementor/widgets/widgets_registered', 'register_elementor_hero_widget');
    }
    
    // WPBakery Page Builder compatibility
    if (defined('WPB_VC_VERSION')) {
        add_action('vc_before_init', 'hero_section_vc_map');
    }
    
    // Beaver Builder compatibility
    if (class_exists('FLBuilder')) {
        add_action('init', 'hero_section_beaver_builder_module');
    }
}
add_action('plugins_loaded', 'hero_section_plugin_compatibility');

/**
 * Example 9: Performance Optimization
 */
function hero_section_performance_optimizations() {
    // Preload critical resources
    add_action('wp_head', function() {
        echo '<link rel="preload" href="' . get_template_directory_uri() . '/assets/css/hero-section.css" as="style">';
        echo '<link rel="preload" href="' . get_template_directory_uri() . '/assets/js/hero-section.js" as="script">';
        
        // Preload hero background image if set
        $bg_image = get_theme_mod('hero_background_image');
        if ($bg_image) {
            echo '<link rel="preload" href="' . esc_url($bg_image) . '" as="image">';
        }
    }, 1);
    
    // Add resource hints
    add_action('wp_head', function() {
        echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">';
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    }, 1);
}
add_action('after_setup_theme', 'hero_section_performance_optimizations');
?>