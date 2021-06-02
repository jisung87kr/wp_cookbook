<?php
get_header();
?>
    <div class="container">
        <?php
        $args = [
            'title' => '재료',
            'terms' => get_terms('material'),
        ];
        get_template_part('template-parts/page/content', 'refrigerator', $args);
        ?>
    </div>
<?php
get_footer();
