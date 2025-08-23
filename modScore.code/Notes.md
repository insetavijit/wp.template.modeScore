i will try embadded svg in next project

---

21Aug25 : Learned acf a lot Specially the repiters block

```
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
```

## 21AUG25 :

goals ;

- make `skillset` part Super Dinamic
- must be editable in block editor
- elementor Compatable
