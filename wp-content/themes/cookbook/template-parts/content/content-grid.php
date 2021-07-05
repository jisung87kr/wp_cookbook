<?php
use CookBook\Classes\CookBook;
use CookBook\Classes\Refrigerator;
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage cookbook
 * @since cookbook 1.0
 */
$GLOBALS['wp_query'] = $args['wp_query'];
$CookBook = new CookBook;
?>
<?php if($GLOBALS['wp_query']->post_count) : ?>
    <h2><?php echo $args['title']; ?></h2>
<?php endif; ?>
<ul class="content-grid row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4 p-0 mb-5">
    <?php
    if ( have_posts() ) :
        $i = 0;
        while ( have_posts() ) :
            $i++;
            the_post();
            $category = get_the_terms( $post->ID, 'cookCategory' );
            $oembed = rwmb_meta( 'cook_oembed' );
            $tag = get_the_terms( $post->ID, 'cookTag' );
            $thumb = rwmb_get_value( 'cook_thumb' );
            $group = rwmb_get_value( 'material_group' );

            $materialDiff = $CookBook->getMaterialDiff($group);
            ?>
            <li id="post-<?php the_ID() ?>" class="post-item col">
                <input type="hidden" name="post_id" value="<?= the_ID() ?>" class="post_id" id="postid_<?= the_ID() ?>">
                <div class="card h-100">
                    <a href="<?php the_permalink() ?>">
                        <?php if($oembed) :?>
                            <div class="youtube"><?php echo $oembed; ?></div>
                        <?php elseif ($thumb['sizes']['large']['url']): ?>
                            <img src="<?php echo $thumb['sizes']['large']['url'] ?>" alt="">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/500x300" class="card-img-top" alt="...">
                        <?php endif; ?>
                    </a>
                    <div class="card-body">
                        <div class="card-title">
                            <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                            <div class="bookmark-box">
                                <a href="" class="text-link1">
                                    <?php $isActive = $CookBook->isFavorited($post->ID, get_current_user_id()) == true ? 'active' : ''; ?>
                                    <i class="bi bi-bookmark-star-fill bookmark bookmark-fill <?= $isActive ?>"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-text">
                            <?php echo wp_trim_words( get_the_content(), 10, '...' ) ?>
                            <?php if($materialDiff['hasCnt']) :?>
                                <div>
                                    <small class="text-muted"><?php echo $materialDiff['text']; ?></small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="text-muted mt-2">
                            <small><?php echo human_time_diff(get_the_time('U')) ?> 전</small>
                        </div>
                    </div>
                    <?php if($category || $tag) :?>
                        <div class="card-footer">
                            <?php if($category) :?>
                                <div>
                                    <i class="bi bi-archive"></i>
                                    <?php foreach ($category as $index => $item) : $term = get_term_link($item, 'cookCategory'); ?>
                                        <a href="<?= $term ?>">
                                            <small class="text-muted"><?= $item->name ?></small>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <?php if($tag) :?>
                                <div>
                                    <i class="bi bi-tag"></i>
                                    <?php foreach ($tag as $index => $item) : $term = get_term_link($item, 'cookTag'); ?>
                                        <a href="<?php echo $term ?>">
                                            <small class="text-muted"><?php echo $item->name ?></small>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </li>
        <?php
        endwhile;
    endif;
    ?>
</ul>
<script>
    $("document").ready(function(){
        var is_login = '<?php echo is_user_logged_in() ?>';
       $(".bookmark").click(function(e){
           e.preventDefault();
           if(is_login != 1){
               window.location.href = '<?php echo wp_login_url(); ?>';
               return false;
           }
           var themeUrl = "<?php echo get_template_directory_uri(); ?>";
           var post_id = $(this).parents('.post-item').find('.post_id').val();
           $(this).toggleClass('active');

           if($(this).hasClass('active')){
               var act = 'addFavorite';
           } else {
               var act = 'deleteFavorite';
           }

           $.ajax({
               data: {
                   'act': act,
                   'post_id' : post_id,
               },
               url: themeUrl + '/requests.php',
               async: true,
               dataType: 'json',
               method: 'POST',
               success: function (data) {
                   console.log(data);
               },
               error: function(data){
                   console.log(data);
               },
           });
       });
    });
</script>
<?php bootstrap_pagination(); ?>
