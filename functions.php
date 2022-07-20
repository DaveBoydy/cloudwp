<?php

/**
 * CloudWP functions and definitions
 *
 * @package CloudWP
 */

/**
 * Enqueue scripts and styles.
 *
 * @return void
 */
function cloudwp_scripts()
{
    // Register and Enqueue the main stylesheet.
    wp_enqueue_style('cloudwp-main-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
}

add_action('wp_enqueue_scripts', 'cloudwp_scripts');


if (!function_exists('cloudwp_excerpt_length')) :

    /**
     * Change excerpt length for default posts
     *
     * @param int $length Length of excerpt in number of words.
     * @return int
     */
    function cloudwp_excerpt_length($length)
    {
        if (is_admin()) {
            return $length;
        }

        return apply_filters('cloudwp_excerpt_length', 28);
    }

endif;

add_filter('excerpt_length', 'cloudwp_excerpt_length');


if (!function_exists('cloudwp_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * @return void
     */
    function cloudwp_setup()
    {

        /**
         * Enable themes to opt-in to slightly more opinionated styles for the front end.
         * 
         * @see 'wp-includes/css/dist/block-library/theme.css'
         */
        add_theme_support('wp-block-styles');

        /**
         * Editor Styles allow you to provide the CSS used by WordPress’ Visual Editor so that it can match the frontend styling.
         */
        add_editor_style('style.css');
    }

endif;

add_action('after_setup_theme', 'cloudwp_setup');

if (!function_exists('cloudwp_register_block_pattern_categories')) :
    /**
     * Registers the themes custom block pattern categories.
     *
     * @return void
     */
    function cloudwp_register_block_pattern_categories()
    {

        /**
         * @param array[] $block_pattern_categories An associative array of block pattern categories, keyed by category name.
         */
        $block_pattern_categories = array(

            'cloudwp-tagline'    => array('label' => esc_html__('cloudwp: Tagline', 'cloudwp')),
        );

        foreach ($block_pattern_categories as $name => $properties) {
            if (!WP_Block_Pattern_Categories_Registry::get_instance()->is_registered($name)) {
                register_block_pattern_category($name, $properties);
            }
        }
    }

endif;

add_action('init', 'cloudwp_register_block_pattern_categories', 9);

if (!function_exists('cloudwp_block_classes')) :
    /**
     * Register block HTML classes for gutenberg core blocks.
     * 
     * @return void
     */
    function cloudwp_block_classes()
    {

        /**
         * @param array[] $block_classes A two dimensional array with an inner associative array
         * of block HTML classes, keyed by class name.
         */
        $block_classes = array(
            'core/query-pagination'           => array(
                'buttons-pagination'   => esc_html__('Buttons', 'cloudwp'),
            ),
            'core/list'           => array(
                'circle-bullet'   => esc_html__('Circle Bullets', 'cloudwp'),
                'square-bullet'   => esc_html__('Square Bullets', 'cloudwp'),
            ),
            'core/archives'           => array(
                'circle-bullet'   => esc_html__('Circle Bullets', 'cloudwp'),
                'square-bullet'   => esc_html__('Square Bullets', 'cloudwp'),
            ),
            'core/categories'           => array(
                'circle-bullet'   => esc_html__('Circle Bullets', 'cloudwp'),
                'square-bullet'   => esc_html__('Square Bullets', 'cloudwp'),
            ),
            'core/site-title'           => array(
                'no-decoration'   => __('No Decoration', 'cloudwp'),
                'simple-highlight'   => __('Simple Highlight', 'cloudwp'),
            ),
            'core/post-terms'           => array(
                'no-decoration'   => __('No Decoration', 'cloudwp'),
            ),
            'core/post-title'           => array(
                'hover-underline'   => __('Hover Underline', 'cloudwp'),
                'simple-highlight'   => __('Simple Highlight', 'cloudwp'),
            ),
            'core/tag-cloud'           => [
                'boxed'   => __('Boxed', 'cloudwp'),
            ],
            'core/search'           => [
                'simple-inside'   => __('Simple Inside', 'cloudwp'),
                'simple-icon-inside'   => __('Simple Icon Inside', 'cloudwp'),
            ],
            'core/comment-template'           => [
                'enhanced-comments'   => __('Enhanced Comment', 'cloudwp'),
            ],
            'core/post-comments-form'           => [
                'bottom-border'   => __('Bottom Border', 'cloudwp'),
            ],
        );

        foreach ($block_classes as $block => $classes) {
            foreach ($classes as $class_name => $style_label) {
                register_block_style(
                    $block,
                    array(
                        'name'  => $class_name,
                        'label' => $style_label,
                    )
                );
            }
        }
    }

endif;

add_action('init', 'cloudwp_block_classes');
