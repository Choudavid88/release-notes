<?php
/**
 * Template Name: Full Width Page
 *
 * The template for displaying full width pages with no sidebar.
 *
 * @package Nu Themes
 */

get_header(); ?>

	<div class="row">
		<main id="content" class="col-xs-12 content-area" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>

			<?php endwhile; ?>

		<!-- #content --></main>
	<!-- .row --></div>

<?php get_footer(); ?>