<?php

/**
 * Plugin Name: MyTheme Style Enqueue Manager
 * Description: Handles enqueueing of styles for the theme in a production-grade manner.
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL-2.0-or-later
 */

// Prevent direct access
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Class MyTheme_Style_Enqueue
 *
 * Manages the enqueueing of styles for the theme.
 * Uses best practices for performance, security, and maintainability.
 */
class MyTheme_Style_Enqueue
{

  /**
   * Constructor: Sets up actions.
   */
  public function __construct()
  {
    add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
    add_action('wp_enqueue_scripts', [$this, 'conditional_enqueues'], 20);
    add_filter('style_loader_tag', [$this, 'add_style_attributes'], 10, 3);
  }

  /**
   * Enqueues the styles.
   */
  public function enqueue_styles()
  {
    // Define style configurations (filterable for extensibility)
    $styles = apply_filters('mytheme_styles', [
      'work-sans' => [
        'src'        => 'https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap',
        'deps'       => [],
        'ver'        => null,
        'media'      => 'all',
        'attributes' => ['rel' => 'stylesheet'], // Google Fonts requires 'stylesheet' rel
      ],
      'bootstrap' => [
        'src'        => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        'deps'       => [],
        'ver'        => '5.3.3',
        'media'      => 'all',
        'integrity'  => 'sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH',
        'attributes' => ['crossorigin' => 'anonymous'],
      ],
      'swiper' => [
        'src'        => 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        'deps'       => [],
        'ver'        => '11.1.14',
        'media'      => 'all',
        'integrity'  => 'sha384-gAPqlBuTCdtVcYt9ocMOYWrnBZ4XSL6q+4eXqwNycOr4iFczhNKtnYhF3NEXJM51', // Placeholder: Replace with actual SHA384 hash
        'attributes' => ['crossorigin' => 'anonymous'],
      ],
      'lightbox' => [
        'src'        => get_template_directory_uri() . '/bin.asset/css/lightbox.min.css',
        'deps'       => [],
        'ver'        => $this->get_file_version('/bin.asset/css/lightbox.min.css'),
        'media'      => 'all',
        'attributes' => [],
      ],
      'theme-style' => [
        'src'        => get_template_directory_uri() . '/bin.asset/css/style.css',
        'deps'       => ['bootstrap'],
        'ver'        => $this->get_file_version('/bin.asset/css/style.css'),
        'media'      => 'all',
        'attributes' => [],
      ],
    ]);

    // Enqueue each style with validation
    foreach ($styles as $handle => $config) {
      if (empty($config['src'])) {
        $this->log_error("Missing source for style handle '$handle'");
        continue;
      }

      wp_enqueue_style(
        $handle,
        $config['src'],
        $config['deps'] ?? [],
        $config['ver'] ?? null,
        $config['media'] ?? 'all'
      );

      // Store attributes and integrity for later use in filter (using style extra data)
      wp_style_add_data($handle, 'integrity', $config['integrity'] ?? '');
      wp_style_add_data($handle, 'attributes', $config['attributes'] ?? []);
    }
  }

  /**
   * Conditionally enqueues styles based on context to optimize performance.
   */
  public function conditional_enqueues()
  {
    // Enqueue lightbox styles only on pages/posts with images or galleries
    if (has_block('core/image') || has_block('core/gallery')) {
      wp_enqueue_style('lightbox');
    }

    // Enqueue Swiper styles only on pages with sliders
    if (has_block('core/columns') || is_page_template('template-home.php')) {
      wp_enqueue_style('swiper');
    }
  }

  /**
   * Adds custom attributes (e.g., integrity) to style tags.
   *
   * @param string $tag    The style tag.
   * @param string $handle The style handle.
   * @param string $src    The style source.
   * @return string Modified tag.
   */
  public function add_style_attributes($tag, $handle, $src)
  {
    $integrity = wp_styles()->get_data($handle, 'integrity');
    $attributes = wp_styles()->get_data($handle, 'attributes');

    if ($integrity) {
      $tag = str_replace('<link ', "<link integrity='{$integrity}' ", $tag);
    }

    if (is_array($attributes)) {
      foreach ($attributes as $attr => $value) {
        if ($value === true) {
          $tag = str_replace('<link ', "<link {$attr} ", $tag);
        } else {
          $tag = str_replace('<link ', "<link {$attr}='{$value}' ", $tag);
        }
      }
    }

    return $tag;
  }

  /**
   * Gets the file version based on last modified time for cache busting.
   *
   * @param string $relative_path Relative path to the file in theme directory.
   * @return string|int File version or timestamp.
   */
  private function get_file_version($relative_path)
  {
    $file_path = get_template_directory() . $relative_path;
    return file_exists($file_path) ? filemtime($file_path) : '1.0.0';
  }

  /**
   * Logs errors if WP_DEBUG is enabled.
   *
   * @param string $message Error message.
   */
  private function log_error($message)
  {
    if (defined('WP_DEBUG') && WP_DEBUG) {
      error_log('MyTheme Style Enqueue: ' . $message);
    }
  }
}

// Instantiate the class
new MyTheme_Style_Enqueue();
