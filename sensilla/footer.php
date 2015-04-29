<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Nu Themes
 */
?>
		<!-- #main --></div>

		<?php
			/* A sidebar in the footer? Yep. You can can customize
			 * your footer with up to four columns of widgets.
			 */
			get_sidebar( 'footer' );
		?>

		<footer id="footer" class="site-footer" role="contentinfo">
		<!-- #footer --></footer>

		<?php wp_footer(); ?>
	</body>
</html>