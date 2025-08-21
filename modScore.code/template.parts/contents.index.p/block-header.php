  <header id="top" class="position-sticky top-0 start-0" style="z-index:10;">
    <nav class="navbar bg-white">
      <div class="container-fluid">

        <!-- Nav > logo + links (Main) -->
        <?php get_template_part('template.parts/contents.index.p/header', 'nav-main'); ?>
        <!-- Lorem ipsum dolor sit amet. -->

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas"
          data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
          <span class="navabar-toggler-icon">
            <svg class="text-primary menu" width="32" height="32">
              <use xlink:href="#menu"></use>
            </svg>
          </span>
        </button>

        <!-- Nav > sideBar ("link ./banner-block.php")-->
        <?php get_template_part('template.parts/contents.index.p/header', 'sidebar-list'); ?>
        <!-- Lorem ipsum dolor sit amet. -->

      </div>
    </nav>
  </header>