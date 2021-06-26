<?php
use CookBook\Classes\Refrigerator;
get_header();
?>
<div class="home-content">
    <?php
    $Refrigerator = new Refrigerator;
    $param = [
        'title' => '내 재료로 만들수 있는 요리',
        'wp_query' => $Refrigerator->getPosts2(),
        'link' => '/refrigerator',
    ];

    get_template_part( 'template-parts/content/slide', 'post', $param);

    $args = [
      'post_type' => 'cookbook',
    ];

    $cookbook = new WP_Query( $args );
    $param = [
        'title' => '최근글',
        'wp_query' => $cookbook,
        'link' => '/cookbook',
    ];

    get_template_part( 'template-parts/content/slide', 'post', $param);

    $args = [
        'title' => '카테고리',
        'terms' => get_terms('cookCategory', ['orderby' => 'count', 'order' => 'DESC']),
        'link' => '/cook-category?type=cookCategory',
    ];
    get_template_part('template-parts/content/slide', 'term', $args);

    $args = [
        'title' => '재료',
        'terms' => get_terms('material', ['orderby' => 'count', 'order' => 'DESC', 'number' => '20', 'childless' => true]),
        'link' => '/cook-category?type=material',
    ];
    get_template_part('template-parts/content/slide', 'term', $args);

    $args = [
        'title' => '태그',
        'terms' => get_terms('cookTag', ['orderby' => 'count', 'order' => 'DESC']),
        'link' => '/cook-category?type=cookTag',
    ];
    get_template_part('template-parts/content/slide', 'term', $args);
    ?>
</div>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css" />
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            var grid = new Swiper(".content-grid", {
                on: {
                    afterInit: function(_this){
                        $(_this.$el).addClass("on");
                    }
                },
                autoHeight: true,
                // slidesPerView: 2,
                slidesPerView: "auto",
                spaceBetween: 15,
                // centeredSlides: true,
                // loop: true,
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 15,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 15,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 15,
                    },
                },
                // centeredSlides: true,
                // autoplay: {
                //     delay: 2500,
                //     disableOnInteraction: false,
                // },
            });

            var term = new Swiper(".content-term-list", {
                on: {
                    afterInit: function(_this){
                        $(_this.$el).addClass("on");
                    }
                },
                autoHeight: true,
                slidesPerView: 3,
                spaceBetween: 5,
                breakpoints: {
                    640: {
                        slidesPerView: 3,
                        spaceBetween: 15,
                    },
                    768: {
                        slidesPerView: 5,
                        spaceBetween: 15,
                    },
                    1024: {
                        slidesPerView: 6,
                        spaceBetween: 15,
                    },
                },
                // autoplay: {
                //     delay: 2500,
                //     disableOnInteraction: false,
                // },
            });
        });
    </script>
<?php
get_footer();
