<?php
$logo = get_field('brand_logo', 'option'); // or get_the_ID() if per post/page
$logo_url = wp_get_attachment_image_url($logo, 'full');
?>

<div class="d-flex align-items-center g-4">
    <a class="navbar-brand d-flex" href="index.html">
        <img src="<?php echo esc_url($logo_url); ?>" class="img-fluid" id="logo" alt="Site Logo">
    </a>

    <?php if (have_rows('social_connect', 'option')): ?>
        <div class="icon px-5">
            <?php while (have_rows('social_connect', 'option')): the_row();
                $icon = get_sub_field('icon');       // SVG URL
                $link = get_sub_field('link');       // Social media link
            ?>
                <a href="<?php echo esc_url($link); ?>" class="text-decoration-none">
                    <img src="<?php echo esc_url($icon); ?>" style="height:1.5em;" alt="">
                </a>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>