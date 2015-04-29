<?php
/**
 * The template for displaying all pages.
 *
 * @package Nu Themes
 */

get_header(); ?>
<link rel="stylesheet" href="http://go.infoblox.com/release-notes/css/ff.css" />

	<div class="row">
		<main id="content" class="col-sm-8 content-area" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>


			<?php endwhile; ?>

		<!-- #content --></main>

		<?php get_sidebar(); ?>
	<!-- .row --></div>

<?php get_footer(); ?>