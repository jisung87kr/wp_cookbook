<?php if($args['terms']) : ?>
<div class="row row-cols-4 g-4 content-term-list mb-5">
    <div class="col-12">
        <h3><?php echo $args['title']; ?></h3>
    </div>
    <?php foreach ($args['terms'] as $key => $value) : ?>
        <div class="col">
            <div class="card p-5 text-center">
                <a href="<?php echo get_term_link($value->term_id) ?>" class="text-link1"><?php echo $value->name ?></a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
