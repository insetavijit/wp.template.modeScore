<?php if (have_rows('services', 'option')): ?>
  <div class="container">
    <div class="row justify-content-center">
      <?php while (have_rows('services', 'option')): the_row();
        $icon = get_sub_field('icon');
        $title = get_sub_field('title_service');
        $desc = get_sub_field('description_of_service');
      ?>
        <div class="col-lg-3">
          <div class="d-flex gap-4 align-items-start">
            <div class="icon">
              <svg class="text-primary <?php echo esc_attr($icon); ?>" width="50" height="50">
                <use xlink:href="#<?php echo esc_attr($icon); ?>"></use>
              </svg>
            </div>
            <div class="text-md-start">
              <h5><?php echo esc_html($title); ?></h5>
              <p class="postf"><?php echo esc_html($desc); ?></p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
<?php endif; ?>


<!-- Skillset\ part - 3 -->
<section class="p-5 ">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-3">
        <div class="d-flex gap-4 align-items-start">
          <div class="icon">
            <svg class="text-primary monitor" width="50" height="50">
              <use xlink:href="#monitor"></use>
            </svg>
          </div>
          <div class="text-md-start">
            <h5>
              UI/UX Design
            </h5>
            <p class="postf">
              At in proin consequat ut cursus venenatis sapien.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="d-flex gap-4 align-items-start">
          <div class="icon">
            <svg class="text-primary notes" width="50" height="50">
              <use xlink:href="#notes"></use>
            </svg>
          </div>
          <div class="text-md-start">
            <h5>
              Illustration
            </h5>
            <p class="postf">
              At in proin consequat ut cursus venenatis sapien.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="d-flex gap-4 align-items-start">
          <div class="icon">
            <svg class="text-primary laptop" width="50" height="50">
              <use xlink:href="#laptop"></use>
            </svg>
          </div>
          <div class="text-md-start">
            <h5>
              Graphic Design
            </h5>
            <p class="postf">
              At in proin consequat ut cursus venenatis sapien.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>