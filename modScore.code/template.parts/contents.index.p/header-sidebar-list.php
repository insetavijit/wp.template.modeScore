<!-- Lorem ipsum dolor sit amet. -->
<div class="offcanvas offcanvas-end text-white bg-black" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
  <div class="offcanvas-header">
    <button type="button" class="btn-close btn-close-white ms-3" data-bs-dismiss="offcanvas"
      aria-label="Close"></button>
  </div>

  <div class="offcanvas-body">


    <?php
    $locations = get_nav_menu_locations();
    $menu_id   = $locations['menu-1'] ?? null;

    if ($menu_id) {
      $menu_items = wp_get_nav_menu_items($menu_id);

      echo '<ul class="navbar-nav flex-grow-1 p-4">';
      foreach ($menu_items as $item) {
        // Detect active item
        $active = (get_permalink() === $item->url) ? ' active' : '';

        echo '<li class="nav-item' . $active . '">';
        echo '<a class="nav-link text-uppercase ls-4 text-white' . $active . '" href="' . esc_url($item->url) . '">';
        echo esc_html($item->title);
        echo '</a>';
        echo '</li>';
      }
      echo '</ul>';
    }
    ?>

  </div>
</div>
<!-- Lorem ipsum dolor sit amet. -->