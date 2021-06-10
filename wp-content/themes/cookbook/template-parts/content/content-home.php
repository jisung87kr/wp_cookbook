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
$posts = [];
?>
<h2><?php echo $args['title']; ?></h2>
<ul class="row row-cols-1 row-cols-lg-4 row-cols-md-2 g-4 p-0 mb-5">

</ul>
<?php bootstrap_pagination(); ?>
