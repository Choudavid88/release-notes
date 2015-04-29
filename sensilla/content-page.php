<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Nu Themes
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<center><h1 class="entry-title"><?php the_title(); ?></h1></center>
	<!-- .entry-header --></header>

	<div class="clearfix entry-content">
		<p style="font-size:16px;"><strong><?php echo get_the_date(); ?></strong></p><p style="font-size:16px;"><?php the_content(); ?></p>
		<hr>
<p style="font-size:12px;">As always, you’re encouraged to tell us what you think, or file a bug in <a target="_blank" href="https://infoblox.service-now.com">ServiceNow</a> or by sending email to <a href="mailto:requests-marketing@infoblox.com">requests-marketing@infoblox.com</a>. 
If interested, please see the complete list of changes in this release.</p>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'nuthemes' ),
				'after'  => '</div>',
			) );
		?>
	<!-- .entry-content --></div>

	<?php edit_post_link( __( 'Edit', 'nuthemes' ), '<footer class="entry-footer entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
<!-- #post-<?php the_ID(); ?> --></article>