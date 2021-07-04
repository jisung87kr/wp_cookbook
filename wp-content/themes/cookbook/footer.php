<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
<footer id="site-footer" role="contentinfo" class="header-footer-group">
    <hr>
    <div class="mt-5">
        <?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>
    </div>
    <div class="text-center pt-4 mt-5">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-link1 text-muted"><?php bloginfo( 'name' ); ?></a>
        <p class="powered-by-wordpress">
            <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'twentytwenty' ) ); ?>" class="text-link1 text-muted">
<!--                <small>--><?php //_e( 'Powered by WordPress', 'twentytwenty' ); ?><!--</small>-->
                <small><a href="mailto:<?php echo get_bloginfo('admin_email');?>"><?php echo get_bloginfo('admin_email');?></a></small>
            </a>
        </p><!-- .powered-by-wordpress -->
    </div>
</footer><!-- #site-footer -->
<?php wp_footer(); ?>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
</body>
</html>
