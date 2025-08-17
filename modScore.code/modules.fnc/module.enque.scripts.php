<?php

/**
 * Plugin Name: MyTheme Enqueue Manager
 * Description: Handles enqueueing of scripts for the theme in a production-grade manner.
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL-2.0-or-later
 */

// Prevent direct access
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Class MyTheme_Enqueue
 *
 * Manages the enqueueing of scripts for the theme.
 * Uses best practices for performance, security, and maintainability.
 */
class MyTheme_Enqueue
{

  /**
   * Constructor: Sets up actions.
   */
  public function __construct()
  {
    add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    add_action('wp_enqueue_scripts', [$this, 'conditional_enqueues'], 20);
    add_filter('script_loader_tag', [$this, 'add_script_attributes'], 10, 3);
  }

  /**
   * Enqueues the scripts.
   */
  public function enqueue_scripts()
  {
    // Always use WP's jQuery
    wp_enqueue_script('jquery');

    // Define script configurations (filterable for extensibility)
    $scripts = apply_filters('mytheme_scripts', [
      'popper' => [
        'src'        => 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js',
        'deps'       => [],
        'ver'        => '2.11.8',
        'in_footer'  => true,
        'integrity'  => 'sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r', // Placeholder: Replace with actual SHA384 hash
        'attributes' => ['defer' => true],
      ],
      'bootstrap' => [
        'src'        => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js',
        'deps'       => ['jquery', 'popper'],
        'ver'        => '5.3.7',
        'in_footer'  => true,
        'integrity'  => 'sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK', // Placeholder: Replace with actual SHA384 hash
        'attributes' => ['defer' => true],
      ],
      'swiper' => [
        'src'        => 'https://cdn.jsdelivr.net/npm/swiper@11.2.10/swiper-bundle.min.js',
        'deps'       => [],
        'ver'        => '11.2.10',
        'in_footer'  => true,
        'integrity'  => 'sha384-2UI1PfnXFjVMQ7/ZDEF70CR943oH3v6uZrFQGGqJYlvhh4g6z6uVktxYbOlAczav', // Placeholder: Replace with actual SHA384 hash
        'attributes' => ['defer' => true],
      ],
      'my-plugins' => [
        'src'        => get_template_directory_uri() . '/bin.asset/js/plugins.js',
        'deps'       => ['jquery'],
        'ver'        => $this->get_file_version('/bin.asset/js/plugins.js'),
        'in_footer'  => true,
        'attributes' => ['defer' => true],
      ],
      'lightbox' => [
        'src'        => get_template_directory_uri() . '/bin.asset/js/lightbox.min.js',
        'deps'       => ['jquery'],
        'ver'        => $this->get_file_version('/bin.asset/js/lightbox.min.js'),
        'in_footer'  => true,
        'attributes' => ['defer' => true],
      ],
      'isotope' => [
        'src'        => 'https://unpkg.com/isotope-layout@3.0.6/dist/isotope.pkgd.min.js',
        'deps'       => ['jquery'],
        'ver'        => '3.0.6',
        'in_footer'  => true,
        'integrity'  => 'sha384-vtH+5pZsjdWxaTWlFSCrWM6i0TIG0HKOqJbPo91LB35dvWpVzuWdJeVoNweP+eoY', // Placeholder: Replace with actual SHA384 hash
        'attributes' => ['defer' => true],
      ],
      'my-script' => [
        'src'        => get_template_directory_uri() . '/bin.asset/js/script.js',
        'deps'       => ['jquery'],
        'ver'        => $this->get_file_version('/bin.asset/js/script.js'),
        'in_footer'  => true,
        'attributes' => ['defer' => true],
      ],
    ]);

    // Enqueue each script with validation
    foreach ($scripts as $handle => $config) {
      if (empty($config['src'])) {
        $this->log_error("Missing source for script handle '$handle'");
        continue;
      }

      wp_enqueue_script(
        $handle,
        $config['src'],
        $config['deps'] ?? [],
        $config['ver'] ?? null,
        $config['in_footer'] ?? true
      );

      // Store attributes and integrity for later use in filter (using script extra data)
      wp_script_add_data($handle, 'integrity', $config['integrity'] ?? '');
      wp_script_add_data($handle, 'attributes', $config['attributes'] ?? []);
    }
  }

  /**
   * Conditionally enqueues scripts based on context to optimize performance.
   */
  public function conditional_enqueues()
  {
    // Example: Enqueue isotope only if on a page with portfolio/gallery
    if (is_page_template('template-gallery.php') || has_block('core/gallery')) {
      wp_enqueue_script('isotope');
    }

    // Example: Enqueue lightbox only on pages/posts with images
    if (has_block('core/image') || has_block('core/gallery')) {
      wp_enqueue_script('lightbox');
    }

    // Add more conditions as needed for other scripts
  }

  /**
   * Adds custom attributes (e.g., defer, integrity) to script tags.
   *
   * @param string $tag    The script tag.
   * @param string $handle The script handle.
   * @param string $src    The script source.
   * @return string Modified tag.
   */
  public function add_script_attributes($tag, $handle, $src)
  {
    $integrity = wp_scripts()->get_data($handle, 'integrity');
    $attributes = wp_scripts()->get_data($handle, 'attributes');

    if ($integrity) {
      $tag = str_replace('<script ', "<script integrity='{$integrity}' crossorigin='anonymous' ", $tag);
    }

    if (is_array($attributes)) {
      foreach ($attributes as $attr => $value) {
        if ($value === true) {
          $tag = str_replace('<script ', "<script {$attr} ", $tag);
        } else {
          $tag = str_replace('<script ', "<script {$attr}='{$value}' ", $tag);
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
      error_log('MyTheme Enqueue: ' . $message);
    }
  }
}

// Instantiate the class
new MyTheme_Enqueue();
