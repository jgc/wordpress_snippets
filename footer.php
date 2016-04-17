<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

	</div><!-- .site-content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php
				/**
				 * Fires before the Twenty Fifteen footer text for footer customization.
				 *
				 * @since Twenty Fifteen 1.0
				 */
				do_action( 'twentyfifteen_credits' );
			?>
			<?php
			  $yDateStart = '2016';
			  $yDateNow = date("Y");
			  $dateText = $yDateStart;  
			  if ($yDateNow > $yDateStart) $dateText = $yDateStart . '-' . $yDateNow
			?>
			<a href="http://ribblevalleygundogs.com">Copyright &#169; <?php echo $dateText; ?> Ribble Valley Gundogs</a>
		</div><!-- .site-info -->
	</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
