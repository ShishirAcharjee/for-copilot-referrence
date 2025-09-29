<?php
/**
 * Enhanced Hero Section Functions for WordPress
 * 
 * This file contains all the PHP functions needed to integrate
 * the enhanced hero section into a WordPress theme.
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
 * Enqueue hero section styles and scripts
 */
function enqueue_hero_section_assets() {
    // Enqueue CSS
    wp_enqueue_style(
        'hero-section-styles',
        get_template_directory_uri() . '/assets/css/hero-section.css',
        array(),
        '1.0.0'
    );
    
    // Enqueue Google Fonts
    wp_enqueue_style(
        'hero-section-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );
    
    // Enqueue JavaScript
    wp_enqueue_script(
        'hero-section-script',
        get_template_directory_uri() . '/assets/js/hero-section.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    // Localize script for AJAX and WordPress data
    wp_localize_script('hero-section-script', 'heroAjax', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('hero_section_nonce'),
        'siteUrl' => home_url(),
        'isAdmin' => current_user_can('manage_options'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_hero_section_assets');

/**
 * Add theme support for hero section customization
 */
function hero_section_theme_support() {
    // Add theme support for custom background
    add_theme_support('custom-background');
    
    // Add theme support for custom header
    add_theme_support('custom-header', array(
        'default-image' => '',
        'width' => 1920,
        'height' => 1080,
        'flex-height' => true,
        'flex-width' => true,
    ));
    
    // Add theme support for post thumbnails
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'hero_section_theme_support');

/**
 * Register customizer settings for hero section
 */
function hero_section_customize_register($wp_customize) {
    // Add Hero Section Panel
    $wp_customize->add_panel('hero_section_panel', array(
        'title' => __('Hero Section', 'textdomain'),
        'description' => __('Customize the hero section of your website', 'textdomain'),
        'priority' => 30,
    ));
    
    // Content Section
    $wp_customize->add_section('hero_content_section', array(
        'title' => __('Content', 'textdomain'),
        'panel' => 'hero_section_panel',
        'priority' => 10,
    ));
    
    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default' => 'Transform Your<br><span class="hero-title-accent">Digital Presence</span>',
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'textdomain'),
        'section' => 'hero_content_section',
        'type' => 'textarea',
        'description' => __('HTML allowed. Use <br> for line breaks and <span class="hero-title-accent"> for accent text.', 'textdomain'),
    ));
    
    // Hero Description
    $wp_customize->add_setting('hero_description', array(
        'default' => 'Create stunning, responsive websites that engage your audience and drive results. Our expert team delivers modern solutions tailored to your business needs.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('hero_description', array(
        'label' => __('Hero Description', 'textdomain'),
        'section' => 'hero_content_section',
        'type' => 'textarea',
    ));
    
    // Primary Button
    $wp_customize->add_setting('hero_button_primary_text', array(
        'default' => 'Get Started',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('hero_button_primary_text', array(
        'label' => __('Primary Button Text', 'textdomain'),
        'section' => 'hero_content_section',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('hero_button_primary_url', array(
        'default' => '#contact',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('hero_button_primary_url', array(
        'label' => __('Primary Button URL', 'textdomain'),
        'section' => 'hero_content_section',
        'type' => 'url',
    ));
    
    // Secondary Button
    $wp_customize->add_setting('hero_button_secondary_text', array(
        'default' => 'Learn More',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('hero_button_secondary_text', array(
        'label' => __('Secondary Button Text', 'textdomain'),
        'section' => 'hero_content_section',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('hero_button_secondary_url', array(
        'default' => '#about',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('hero_button_secondary_url', array(
        'label' => __('Secondary Button URL', 'textdomain'),
        'section' => 'hero_content_section',
        'type' => 'url',
    ));
    
    // Visual Section
    $wp_customize->add_section('hero_visual_section', array(
        'title' => __('Visual Settings', 'textdomain'),
        'panel' => 'hero_section_panel',
        'priority' => 20,
    ));
    
    // Background Image
    $wp_customize->add_setting('hero_background_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label' => __('Background Image', 'textdomain'),
        'section' => 'hero_visual_section',
        'description' => __('Optional background image for the hero section.', 'textdomain'),
    )));
    
    // Enable Floating Cards
    $wp_customize->add_setting('enable_floating_cards', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('enable_floating_cards', array(
        'label' => __('Enable Floating Cards', 'textdomain'),
        'section' => 'hero_visual_section',
        'type' => 'checkbox',
    ));
    
    // Enable Scroll Indicator
    $wp_customize->add_setting('enable_scroll_indicator', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('enable_scroll_indicator', array(
        'label' => __('Enable Scroll Indicator', 'textdomain'),
        'section' => 'hero_visual_section',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'hero_section_customize_register');

/**
 * Add selective refresh support for hero section
 */
function hero_section_customize_partial_refresh($wp_customize) {
    // Hero Title
    $wp_customize->selective_refresh->add_partial('hero_title', array(
        'selector' => '.hero-title',
        'render_callback' => function() {
            return wp_kses_post(get_theme_mod('hero_title'));
        },
    ));
    
    // Hero Description
    $wp_customize->selective_refresh->add_partial('hero_description', array(
        'selector' => '.hero-description',
        'render_callback' => function() {
            return esc_html(get_theme_mod('hero_description'));
        },
    ));
    
    // Primary Button
    $wp_customize->selective_refresh->add_partial('hero_button_primary_text', array(
        'selector' => '.btn-primary',
        'render_callback' => function() {
            return esc_html(get_theme_mod('hero_button_primary_text'));
        },
    ));
}
add_action('customize_register', 'hero_section_customize_partial_refresh');

/**
 * Add admin styles for hero section customization
 */
function hero_section_admin_styles() {
    echo '<style>
        .customize-control-description {
            font-style: italic;
            color: #666;
        }
        .customize-panel-hero_section_panel .customize-panel-description {
            padding: 10px 0;
            color: #555;
        }
    </style>';
}
add_action('customize_controls_print_styles', 'hero_section_admin_styles');

/**
 * Register menu location for header navigation
 */
function hero_section_register_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Navigation', 'textdomain'),
        'mobile' => __('Mobile Navigation', 'textdomain'),
    ));
}
add_action('init', 'hero_section_register_menus');

/**
 * Add body classes for hero section
 */
function hero_section_body_classes($classes) {
    if (is_front_page() || is_page_template('page-hero.php')) {
        $classes[] = 'has-hero-section';
    }
    
    if (get_theme_mod('enable_floating_cards', true)) {
        $classes[] = 'has-floating-cards';
    }
    
    return $classes;
}
add_filter('body_class', 'hero_section_body_classes');

/**
 * Add schema markup for hero section
 */
function hero_section_schema_markup() {
    if (is_front_page()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'url' => home_url(),
        );
        
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'hero_section_schema_markup');

/**
 * Preload critical resources for better performance
 */
function hero_section_preload_resources() {
    echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
    echo '<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"></noscript>';
    
    // Preload hero background image if set
    $bg_image = get_theme_mod('hero_background_image');
    if ($bg_image) {
        echo '<link rel="preload" href="' . esc_url($bg_image) . '" as="image">';
    }
}
add_action('wp_head', 'hero_section_preload_resources', 1);
?>