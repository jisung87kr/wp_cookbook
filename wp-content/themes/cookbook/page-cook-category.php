<?php
get_header();
?>
    <div class="container">
        <?php
        $args = [
            'title' => '카테고리',
            'terms' => get_terms('cookCategory', ['orderby' => 'count']),
        ];
        get_template_part('template-parts/page/content', 'term-list', $args);

        $args = [
            'title' => '재료',
            'terms' => get_terms('material', ['orderby' => 'count']),
        ];
        get_template_part('template-parts/page/content', 'term-list', $args);

        $args = [
            'title' => '태그',
            'terms' => get_terms('cookTag', ['orderby' => 'count']),
        ];
        get_template_part('template-parts/page/content', 'term-list', $args);
        ?>
    </div>
<?php
get_footer();
