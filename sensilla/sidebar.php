<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Nu Themes
 */
?>
	<div id="secondary" class="col-sm-4 site-sidebar widget-area" role="complementary">
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

			<aside id="widget-search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="widget-archives" class="widget">
				<h3 class="widget-title"><?php _e( 'Archives', 'nuthemes' ); ?></h3>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<aside id="widget-meta" class="widget">
				<h3 class="widget-title"><?php _e( 'Meta', 'nuthemes' ); ?></h3>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
	<!-- #secondary --></div>