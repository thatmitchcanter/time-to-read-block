<?php
/**
 * Plugin Name: Time to Read Block
 * Description: A Gutenberg block that displays the estimated reading time for articles.
 * Version: 1.0.0
 * Author: Mitch Canter
 * Author URI: https://mitchcanter.me
 * License: GPL v2 or later
 * Text Domain: time-to-read-block
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('TTRB_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TTRB_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Initialize the plugin
function ttrb_init() {
    // Register block script
    wp_register_script(
        'ttrb-block-editor',
        TTRB_PLUGIN_URL . 'build/index.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data')
    );

    // Register block style
    wp_register_style(
        'ttrb-block-editor',
        TTRB_PLUGIN_URL . 'build/index.css',
        array()
    );

    // Register block
    register_block_type('ttrb/time-to-read', array(
        'editor_script' => 'ttrb-block-editor',
        'editor_style' => 'ttrb-block-editor',
        'render_callback' => 'ttrb_render_block',
        'uses_context' => array('postId', 'postType'),
        'supports' => array(
            'color' => array(
                'text' => true,
                'background' => true
            ),
            'typography' => array(
                'fontSize' => true,
                'fontFamily' => true,
                'fontWeight' => true,
                'lineHeight' => true,
                'letterSpacing' => true,
                'textTransform' => true
            ),
            'spacing' => array(
                'padding' => true,
                'margin' => true
            ),
            'dimensions' => array(
                'minHeight' => true
            ),
            '__experimentalBorder' => array(
                'color' => true,
                'radius' => true,
                'style' => true,
                'width' => true
            )
        )
    ));
}
add_action('init', 'ttrb_init');

// Render callback function
function ttrb_render_block($attributes, $content, $block) {
    // Get the current post ID from context (works in query loops and single pages)
    $post_id = null;
    
    // Check if we're in a query loop context
    if (isset($block->context['postId'])) {
        $post_id = $block->context['postId'];
    } 
    // Fallback to current post
    else {
        $post_id = get_the_ID();
    }
    
    $reading_time = ttrb_calculate_reading_time($post_id);
    
    if (!$reading_time) {
        return '<p>Unable to calculate reading time.</p>';
    }

    // Get block wrapper attributes (WordPress handles all styling)
    $wrapper_attributes = get_block_wrapper_attributes();
    
    return sprintf(
        '<div %s>
            <span class="ttrb-text">%s</span>
        </div>',
        $wrapper_attributes,
        esc_html($reading_time)
    );
}

// Calculate reading time function
function ttrb_calculate_reading_time($page_id) {
    $post = get_post($page_id);
    
    if (!$post) {
        return false;
    }
    
    // Get post content
    $content = $post->post_content;
    
    // Strip HTML tags and shortcodes
    $content = strip_tags($content);
    $content = strip_shortcodes($content);
    
    // Count words
    $word_count = str_word_count($content);
    
    // Calculate reading time (275 words per minute)
    $reading_speed = 275;
    $minutes = ceil($word_count / $reading_speed);
    
    if ($minutes < 1) {
        return 'Reading time: Less than 1 minute ';
    } elseif ($minutes == 1) {
        return 'Reading time:1 minute';
    } else {
        return sprintf('Reading time: %d minute%s', $minutes, $minutes > 1 ? 's' : '');
    }
}

// Add admin menu
function ttrb_admin_menu() {
    add_options_page(
        'Time to Read Block Settings',
        'Time to Read Block',
        'manage_options',
        'ttrb-settings',
        'ttrb_settings_page'
    );
}
add_action('admin_menu', 'ttrb_admin_menu');

// Settings page
function ttrb_settings_page() {
    ?>
    <div class="wrap">
        <h1>Time to Read Block Settings</h1>
        <p>This plugin adds a Gutenberg block that displays the estimated reading time for articles.</p>
        <p><strong>Reading speed:</strong> 275 words per minute</p>
        <h2>Usage</h2>
        <p>Add the "Time to Read" block to your posts or pages. The block will automatically:</p>
        <ul>
            <li>Calculate reading time for the current post/page</li>
            <li>Work within Query Loop blocks to show reading time for each post</li>
            <li>Allow optional customization of text and background colors</li>
        </ul>
    </div>
    <?php
}

// Enqueue frontend styles
function ttrb_enqueue_frontend_styles() {
    wp_enqueue_style(
        'ttrb-frontend',
        TTRB_PLUGIN_URL . 'build/index.css',
        array(),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'ttrb_enqueue_frontend_styles');
