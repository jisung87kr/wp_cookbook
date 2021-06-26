<?php
get_header();
?>
    <div class="container">
        <?php
        $type = $_REQUEST['type'];
        if(isset($type) && $type !=''){
            $taxonomy = get_taxonomy($type);
            $args = [
                'title' => $taxonomy->label,
                'terms' => get_terms($type, ['orderby' => 'count']),
            ];
            get_template_part('template-parts/page/content', 'term-list', $args);
        } else {
            $args = [
                'title' => '카테고리',
                'terms' => get_terms('cookCategory', ['orderby' => 'count', 'order' => 'DESC']),
            ];
            get_template_part('template-parts/page/content', 'term-list', $args);

            $args = [
                'title' => '재료',
                'terms' => get_terms('material', ['orderby' => 'count', 'order' => 'DESC', 'childless' => true]),
            ];
            get_template_part('template-parts/page/content', 'term-list', $args);

            $args = [
                'title' => '태그',
                'terms' => get_terms('cookTag', ['orderby' => 'count', 'order' => 'DESC']),
            ];
            get_template_part('template-parts/page/content', 'term-list', $args);
        }

        ?>
    </div>
<?php
get_footer();
