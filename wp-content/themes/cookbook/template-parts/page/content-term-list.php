<?php if($args['terms']) : ?>
<h2><?php echo $args['title']; ?></h2>
<ul class="content-term-list row row-cols-2 row-cols-sm-3 row-cols-md-4 g-2 g-sm-4 mb-5 mt-2">
    <?php foreach ($args['terms'] as $key => $value) : ?>
        <li class="col">
            <div class="card p-2 p-sm-5 text-center">
                <a href="<?php echo get_term_link($value->term_id) ?>" class="text-link1"><?php echo $value->name ?></a>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
