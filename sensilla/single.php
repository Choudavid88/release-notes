
<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Nu Themes
 */

get_header(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="http://go.infoblox.com/release-notes/css/ff.css" />
<link rel="stylesheet" href="http://use.typekit.net/c/57be61/1w;proxima-nova,2,b5v:R:i3,b5x:R:i4,b5r:R:n1,b5t:R:n3,b5w:R:n4,b5y:R:n6,bBh:R:n7/d?3bb2a6e53c9684ffdc9a98fe1b5b2a620731315e89a90029ece964c997c9d5e2ed8e1af06758833812c2b2a78757d0dabfe5a594afd8f977a7594e071a50d13ed39b10a5e6dafc9118de05d7161e4dcebf3991a320ddb43e326b748a2add2df24d9ec437da03f05d21a526ce6bfb46a1c666f7b924a262057b51ee35f5b632bb87d97376db1d67288eb16163224bc5094d8299a4142cc13ed61d6a50543796c03e34f94e5c756a07108deaa76d706b52e9d8274294b047f7167a4aab12913437c5851da104c9a9a533bdbd4ab6331823e5b60f9b02a89372491b96a33dbe7236953e197f9c955a828f5a6c7fb293ed8aa7c9e15e9a9225b43f4a191575eae5e7a0c08ead7d219dd7c759757c845ec51de6e4b3a6fd4e4fba7a">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

	<div class="row">
		<main id="content" class="col-sm-8 content-area" role="main">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

		
			<?php endwhile; ?>
		<article class="post type-post format-standard hentry">


			<h3> What's New</h3>
			<ul class="section-items tagged">
		<hr>
		<div id="new" class="title"> 
		</div>
		
		<div id="changed" class="title">
		</div>

		<div id="fixed" class="title">
		</div>
			</ul>


		</article>



		<!-- #content --></main>

		<?php get_sidebar(); ?>
	<!-- .row --></div>

<?php get_footer(); ?>

<style>
.tag{
	position: relative !important;
	top: -0.4rem !important;
	margin-right: 2em !important;
}
</style>

<?php
if ( $keys = get_post_custom_keys() ) {
	//	echo "<ul class='section-items tagged'>\n";
		foreach ( (array) $keys as $key ) {
			$keyt = trim($key);
			if ( is_protected_meta( $keyt, 'post' ) )
				continue;
			$values = array_map('trim', get_post_custom_values($key));
			$value = implode($values,'|~| ');
?>
			<script type="text/javascript">
	var meta_Key = <?php echo json_encode($key); ?>;  //this is to pass data from PHP to JS	
	var meta_Descr = <?php echo json_encode($value); ?>;
	var tempString,i;
	if(meta_Key == "New") {
		if(meta_Descr.indexOf("|~|") >= 0) {
			tempString = meta_Descr.split("|~|");
				for ( i = 0 ; i < tempString.length ; i++ ) {
					$('#new').append('<br><li><b id="status" class="tag tag-new">New</b>   '+tempString[i]+'</li>');
				}
			} else {
				$('#new').append('<br><li><b id="status" class="tag tag-new">New</b>   '+meta_Descr+'</li>');
			}
	} 
	
	if(meta_Key == "Changed") {
		if(meta_Descr.indexOf("|~|") >= 0) {
			tempString = meta_Descr.split("|~|");
				for ( i = 0 ; i < tempString.length ; i++ ) {
					$('#changed').append('<br><li><b id="status" class="tag tag-changed">Changed</b>   '+tempString[i]+'</li>');
				}
		} else {
			$('#changed').append('<br><li><b id="status" class="tag tag-changed">Changed</b>   '+meta_Descr+'</li>');
		}
	}
	if(meta_Key == "Fixed") {
		if(meta_Descr.indexOf("|~|") >= 0) {
			tempString = meta_Descr.split("|~|");
				for ( i = 0 ; i < tempString.length ; i++ ) {
					$('#fixed').append('<br><li><b id="status" class="tag tag-fixed">Fixed</b>   '+tempString[i]+'</li>');
				}
		} else {
			$('#changed').append('<br><li><b id="status" class="tag tag-fixed">Fixed</b>   '+meta_Descr+'</li>');
		}
	}
	
	</script>
	<?php
			
		}
	//	echo "</ul>\n";
	}
	


?>
<script type="text/javascript">
$(document).ready(function() {
$("#text-3").hide();
});
</script>
