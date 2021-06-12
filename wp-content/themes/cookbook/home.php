<?php
use CookBook\Classes\Refrigerator;
get_header();
?>
<div class="container">
    <?php
    $Refrigerator = new Refrigerator;
    $param = [
        'title' => '내 재료로 만들수 있는 요리',
        'wp_query' => $Refrigerator->getPosts(),
    ];

    get_template_part( 'template-parts/content/content', 'grid', $param);

    $args = [
      'post_type' => 'cookbook',
    ];

    $cookbook = new WP_Query( $args );
    $param = [
        'title' => '최근글',
        'wp_query' => $cookbook,
    ];

    get_template_part( 'template-parts/content/content', 'grid', $param);

    $args = [
        'title' => '카테고리',
        'terms' => get_terms('cookCategory', ['orderby' => 'count']),
    ];
    get_template_part('template-parts/page/content', 'term-list', $args);

    $args = [
        'title' => '재료',
        'terms' => get_terms('material', ['orderby' => 'count', 'number' => '20']),
    ];
    get_template_part('template-parts/page/content', 'term-list', $args);

    $args = [
        'title' => '태그',
        'terms' => get_terms('cookTag', ['orderby' => 'count']),
    ];
    get_template_part('template-parts/page/content', 'term-list', $args);
    ?>
</div>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css" />
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<?php
get_footer();
