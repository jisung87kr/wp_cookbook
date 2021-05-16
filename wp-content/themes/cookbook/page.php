<?php
get_header();
$meta = get_post_meta($post->ID);
$terms = get_terms( $meta['type'] );
?>
<div class="container">
    <div class="row row-cols-4 g-4">
        <?php foreach ($terms as $key => $value) : ?>
            <div class="col">
                <div class="card p-5 text-center">
                    <a href="<?php echo get_term_link($value->term_id) ?>" class="text-link1"><?php echo $value->name ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
get_footer();
