<!-- Index:2 -->

<?php
// Background Image
$bg_image_id = get_field('back_ground_image', 'option');
$bg_image_url = wp_get_attachment_image_url($bg_image_id, 'full');

// Subtitle
$subtitle = get_field('subtitle', 'option');

// Main Title
$main_title = get_field('main_title', 'option');

// Stats (Repeater)
// $stats = get_field('stats_', 'option');


?>

<section>
  <div class="container">
    <div class="banner rounded-4 p-5"

      style="background-image: url( <?php echo $bg_image_url; ?>); 
      background-size: cover ; background-repeat: no-repeat;
      background-position: center;">

      <div class="text-content text-white py-5 my-5">
        <p class="fs-4">
          <?php echo $subtitle; ?>
        </p>
        <h1 class="display-1">
          <?php
          #===================================
          $sting =  explode(' ', $main_title);
          echo implode('<br/>', $sting);
          #===================================
          ?>
        </h1>
      </div>

      <!-- this is the doc like thing bellow the image  -->

      <?php if (have_rows('stats_', 'option')): ?>
        <div class="row text-uppercase bg-black rounded-4 p-3 mt-5">
          <?php while (have_rows('stats_', 'option')): the_row(); ?>
            <?php
            $label = get_sub_field('number_');
            $value = get_sub_field('label_');
            ?>

            <div class="col-md-3">
              <div class="d-flex align-items-center gap-4">
                <h2 class="display-2 text-light">
                  <?php echo esc_html($label); ?>
                </h2>
                <p class="text-light-emphasis justify-content-center m-0 ls-4">
                  <?php echo esc_html($value); ?>
                </p>
              </div>
            </div>
          <?php endwhile; ?>

        </div>
      <?php endif; ?>


    </div>
  </div>
</section>