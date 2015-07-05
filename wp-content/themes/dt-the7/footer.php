<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the <div class="wf-container wf-clearfix"> and all content after
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$config = Presscore_Config::get_instance();

if ( presscore_is_content_visible() ): ?>

			</div><!-- .wf-container -->
		</div><!-- .wf-wrap -->
	</div><!-- #main -->

	<?php
	if ( $config->get( 'template.footer.background.slideout_mode' ) ) {
		echo '</div>';
	}

	/*do_action( 'presscore_after_main_container' );*/
	?>

<?php endif; // presscore_is_content_visible ?>

	<a href="#" class="scroll-top"></a>
</div><!-- #page -->
<?php wp_footer(); ?>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?c9b9ef27638f59d1095a60bcce381a54";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

</body>
</html>