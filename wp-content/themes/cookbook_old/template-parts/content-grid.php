<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */
?>

<ul>
    <?php
    if ( have_posts() ) {
        $i = 0;
        while ( have_posts() ) {
            $i++;
            the_post();
            ?>
            <li <?php post_class(); ?> id="post-<?php the_ID(); ?>">
                <div>
                    <a href="">
                        <img src="" alt="">
                    </a>
                </div>
                <div>
                    <div>제목</div>
                    <div>내용</div>
                    <div>
                        <div>카테고리</div>
                        <div>태그</div>
                    </div>
                </div>
            </li>
        <?php
        }
    } elseif ( is_search() ) {
        ?>
        <div class="no-search-results-form section-inner thin">
            <?php
            get_search_form(
                array(
                    'label' => __( 'search again', 'twentytwenty' ),
                )
            );
            ?>

        </div><!-- .no-search-results -->

        <?php
    }
    ?>

    <?php get_template_part( 'template-parts/pagination' ); ?>
</ul>
