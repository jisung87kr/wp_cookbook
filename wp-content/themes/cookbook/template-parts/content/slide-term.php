<?php if($args['terms']) : ?>
<h2><?php echo $args['title']; ?></h2>
<div class="content-term-list swiper-container mySwiper mb-2 mb-md-5">
    <ul class="swiper-wrapper">
        <?php foreach ($args['terms'] as $key => $value) : ?>
            <li class="swiper-slide term-item">
                <div class="card p-2 p-sm-5 text-center">
                    <a href="<?php echo get_term_link($value->term_id) ?>" class="text-link1"><?php echo $value->name ?></a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>