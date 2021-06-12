<?php if($args['terms']) : ?>
<h2>
    <?php echo $args['title']; ?>
    <?php if($args['link']) : ?>
        <a href="<?php echo $args['link']; ?>" class="text-link1 text-more"><small class="text-muted">더보기</small></a>
    <?php endif; ?>
</h2>
<div class="content-term-list swiper-container mySwiper mb-2 mb-md-5">
    <ul class="swiper-wrapper">
        <?php foreach ($args['terms'] as $key => $value) : ?>
            <li class="swiper-slide term-item">
                <div class="card p-2 py-4 p-sm-5 text-center">
                    <a href="<?php echo get_term_link($value->term_id) ?>" class="text-link1"><?php echo $value->name ?></a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>