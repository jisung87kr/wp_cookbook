<?php
global $POSTTYPES;

$category = get_the_terms( $post->ID, 'cookCategory' );
$categoryId = wp_list_pluck($category, 'term_id');
$tag = get_the_terms( $post->ID, 'cookTag' );

$queryArray = array(
    'posts_per_page' => -1,
    'limit' => 10,
    'post_type' => $POSTTYPES,
    'tax_query' => array(
        array(
            'taxonomy' => 'cookCategory',
            'terms' => $categoryId,
            'operator' => 'IN',
        )
    )
);

$posts_array = get_posts($queryArray);

if(!$posts_array){
    $queryArray = array(
        'posts_per_page' => 10,
        'post_type' => $POSTTYPES,
    );
}

$posts_array = get_posts($queryArray);
?>
<h5>내용 더보기</h5>
<div class="card">
    <div class="card-body related-list">
        <?php foreach ($posts_array as $index => $item) : ?>
            <?php
            $thumb = rwmb_get_value( 'cook_thumb', null, $item->ID );
            ?>
            <div class="row mb-3 item">
                <div class="item-image">
                    <?php if($thumb['sizes']['medium']['url']) :?>
                        <img src="<?php echo $thumb['sizes']['medium']['url'] ?>" alt="" style="width: 100px">
                    <?php else : ?>
                        <img class="mr-3" src="https://via.placeholder.com/100x60" style="width: 100px; height: 60px;">
                    <?php endif; ?>
                </div>
                <div class="item-body">
                    <a href="<?php the_permalink($item->ID)?>">
                        <div class="mt-0">
                            <?php echo wp_trim_words( $item->post_title, 7, '...' ) ?>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>