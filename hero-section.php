<?php
/**
 * Enhanced Hero Section Template for WordPress
 * 
 * This file contains the HTML structure for the enhanced hero section
 * that can be integrated into any WordPress theme.
 * 
 * @package WordPress
 * @subpackage Hero_Section
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Get customizer values or set defaults
$hero_title = get_theme_mod('hero_title', 'Transform Your<br><span class="hero-title-accent">Digital Presence</span>');
$hero_description = get_theme_mod('hero_description', 'Create stunning, responsive websites that engage your audience and drive results. Our expert team delivers modern solutions tailored to your business needs.');
$hero_button_primary_text = get_theme_mod('hero_button_primary_text', 'Get Started');
$hero_button_primary_url = get_theme_mod('hero_button_primary_url', '#contact');
$hero_button_secondary_text = get_theme_mod('hero_button_secondary_text', 'Learn More');
$hero_button_secondary_url = get_theme_mod('hero_button_secondary_url', '#about');
$hero_background_image = get_theme_mod('hero_background_image', '');
$enable_floating_cards = get_theme_mod('enable_floating_cards', true);
$enable_scroll_indicator = get_theme_mod('enable_scroll_indicator', true);
?>

<!-- Enhanced Hero Section -->
<section class="hero" id="hero">
    <div class="hero-background" <?php if ($hero_background_image): ?>style="background-image: url('<?php echo esc_url($hero_background_image); ?>');"<?php endif; ?>>
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-container">
        <div class="hero-content">
            <h1 class="hero-title">
                <?php echo wp_kses_post($hero_title); ?>
            </h1>
            <p class="hero-description">
                <?php echo esc_html($hero_description); ?>
            </p>
            <div class="hero-buttons">
                <?php if ($hero_button_primary_text && $hero_button_primary_url): ?>
                    <a href="<?php echo esc_url($hero_button_primary_url); ?>" class="btn btn-primary">
                        <?php echo esc_html($hero_button_primary_text); ?>
                    </a>
                <?php endif; ?>
                
                <?php if ($hero_button_secondary_text && $hero_button_secondary_url): ?>
                    <a href="<?php echo esc_url($hero_button_secondary_url); ?>" class="btn btn-secondary">
                        <?php echo esc_html($hero_button_secondary_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if ($enable_floating_cards): ?>
        <div class="hero-visual">
            <div class="hero-image-container">
                <div class="floating-card card-1">
                    <div class="card-icon"><?php echo apply_filters('hero_card_1_icon', '📊'); ?></div>
                    <div class="card-text"><?php echo apply_filters('hero_card_1_text', __('Analytics', 'textdomain')); ?></div>
                </div>
                <div class="floating-card card-2">
                    <div class="card-icon"><?php echo apply_filters('hero_card_2_icon', '🚀'); ?></div>
                    <div class="card-text"><?php echo apply_filters('hero_card_2_text', __('Performance', 'textdomain')); ?></div>
                </div>
                <div class="floating-card card-3">
                    <div class="card-icon"><?php echo apply_filters('hero_card_3_icon', '💡'); ?></div>
                    <div class="card-text"><?php echo apply_filters('hero_card_3_text', __('Innovation', 'textdomain')); ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <?php if ($enable_scroll_indicator): ?>
    <div class="hero-scroll-indicator">
        <div class="scroll-arrow"></div>
    </div>
    <?php endif; ?>
</section>

<?php
/**
 * Action hook for adding content after the hero section
 * 
 * @since 1.0.0
 */
do_action('after_hero_section');
?>