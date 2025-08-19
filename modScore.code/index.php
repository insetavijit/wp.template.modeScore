<?php
//>>>>Starting - Diamic Headings >> 
get_template_part("./template.parts/header", "main");

echo '<body class="' . implode(' ', get_body_class()) . '">';

//>>>>>Body Content ====================================

get_template_part("./template.parts/theme.contents/social", "links");
get_template_part("./template.parts/theme.contents/header", "block");



// get_template_part("./template.parts/theme.contents/banner", "block");

// get_template_part("./template.parts/theme.contents/skillset", "block");

// get_template_part("./template.parts/theme.contents/bio", "block");

// get_template_part("./template.parts/theme.contents/intro", "block");


// get_template_part("./template.parts/theme.contents/gallery", "block");
// get_template_part("./template.parts/theme.contents/testimonials", "block");
// get_template_part("./template.parts/theme.contents/faqs", "block");

// get_template_part("./template.parts/theme.contents/news", "block");
// get_template_part("./template.parts/theme.contents/contact", "form");


// get_template_part("./template.parts/theme.contents/footer", "block");


// >>>> Ended evrithing - Now relax and listen Osho====
wp_footer();
echo "</body></html>";
//>>>>>>
