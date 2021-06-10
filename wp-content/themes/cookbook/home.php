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
    ?>
</div>
<?php
get_footer();
