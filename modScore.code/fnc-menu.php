<?php

/**
 * Theme Functions
 *
 * This file contains the theme's custom functions and setups for navigation menus and related functionality.
 *
 * @package YourTheme
 * @since 1.0.0
 */

namespace YourTheme\Navigation;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Class Theme_Navigation
 *
 * Handles navigation menu registration and customization for the theme.
 *
 * @since 1.0.0
 */
class Theme_Navigation
{
    /**
     * Theme text domain.
     *
     * @var string
     */
    private static $text_domain = 'yourtheme';

    /**
     * Initialize the navigation setup.
     *
     * @since 1.0.0
     */
    public static function init()
    {
        // Register navigation menus
        add_action('after_setup_theme', [__CLASS__, 'register_menus']);

        // Add Bootstrap classes for navigation
        add_filter('nav_menu_css_class', [__CLASS__, 'add_menu_item_classes'], 10, 3);
        add_filter('nav_menu_link_attributes', [__CLASS__, 'add_menu_link_classes'], 10, 3);
        add_filter('nav_menu_submenu_css_class', [__CLASS__, 'add_submenu_classes'], 10, 3);
    }

    /**
     * Registers navigation menus for the theme.
     *
     * @since 1.0.0
     */
    public static function register_menus()
    {
        // Check if theme support for menus is enabled
        if (!current_theme_supports('menus')) {
            add_theme_support('menus');
        }

        register_nav_menus(
            array(
                'loreMenu' => esc_html__('Lore Menu', self::$text_domain),
            )
        );
    }

    /**
     * Adds Bootstrap 'nav-item' and 'dropdown' classes to menu <li> elements.
     *
     * @param array    $classes Array of CSS classes for the menu item.
     * @param WP_Post  $item    The current menu item object.
     * @param stdClass $args    An object of wp_nav_menu() arguments.
     * @return array Modified array of CSS classes.
     * @since 1.0.0
     */
    public static function add_menu_item_classes($classes, $item, $args)
    {
        if ($args->theme_location === 'loreMenu') {
            $classes[] = 'nav-item';

            // Add 'dropdown' class for items with submenus
            if (in_array('menu-item-has-children', $classes)) {
                $classes[] = 'dropdown';
            }
        }
        return array_unique($classes);
    }

    /**
     * Adds Bootstrap classes to menu <a> elements and 'active' class for current item.
     *
     * @param array    $atts  The HTML attributes applied to the menu item's <a> tag.
     * @param WP_Post  $item  The current menu item object.
     * @param stdClass $args  An object of wp_nav_menu() arguments.
     * @return array Modified array of HTML attributes.
     * @since 1.0.0
     */
    public static function add_menu_link_classes($atts, $item, $args)
    {
        if ($args->theme_location === 'loreMenu') {
            $atts['class'] = !empty($atts['class']) ? $atts['class'] . ' nav-link text-uppercase ls-4 text-white' : 'nav-link text-uppercase ls-4 text-white';

            // Add 'active' class for current menu item
            if (in_array('current-menu-item', $item->classes)) {
                $atts['class'] .= ' active';
            }

            // Add Bootstrap dropdown attributes for parent items
            if (in_array('menu-item-has-children', $item->classes)) {
                $atts['class'] .= ' dropdown-toggle';
                $atts['data-bs-toggle'] = 'dropdown';
                $atts['role'] = 'button';
                $atts['aria-expanded'] = 'false';
            }
        }
        return $atts;
    }

    /**
     * Adds Bootstrap 'dropdown-menu' class to submenu <ul> elements.
     *
     * @param array    $classes Array of CSS classes for the submenu.
     * @param stdClass $args    An object of wp_nav_menu() arguments.
     * @param int      $depth   The depth of the submenu.
     * @return array Modified array of CSS classes.
     * @since 1.0.0
     */
    public static function add_submenu_classes($classes, $args, $depth)
    {
        if ($args->theme_location === 'loreMenu') {
            $classes[] = 'dropdown-menu';
        }
        return array_unique($classes);
    }
}

// Initialize the navigation class
Theme_Navigation::init();
