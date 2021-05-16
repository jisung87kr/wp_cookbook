<?php
/**
 * Displays the menus and widgets at the end of the main element.
 * Visually, this output is presented as part of the footer element.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

$has_footer_menu = has_nav_menu( 'footer' );
$has_social_menu = has_nav_menu( 'social' );

$has_sidebar_1 = is_active_sidebar( 'sidebar-1' );

// Only output the container if there are elements to display.
if ( $has_footer_menu || $has_social_menu || $has_sidebar_1 ) {
	?>

	<div class="footer-nav-widgets-wrapper container">
		<div class="footer-inner section-inner">

			<?php if ( $has_sidebar_1 ) { ?>

				<aside class="footer-widgets-outer-wrapper" role="complementary">

					<div class="footer-widgets-wrapper">

						<?php if ( $has_sidebar_1 ) { ?>
                        <?php
                            error_reporting(E_ALL);
                            ini_set('display_errors', '1');
                            ?>
							<div class="footer-widgets row row-cols-2 g-4">
								<?php dynamic_sidebar( 'sidebar-1' ); ?>
							</div>

						<?php } ?>

					</div><!-- .footer-widgets-wrapper -->

				</aside><!-- .footer-widgets-outer-wrapper -->

			<?php } ?>

		</div><!-- .footer-inner -->

	</div><!-- .footer-nav-widgets-wrapper -->

<?php } ?>
