<?php
/**
 * The template part for displaying the post meta information
 *
 * @package Lenscap
 */
?>
	<div class="entry-meta meta-height">
		<ul class="meta-list">

			<!-- Categories -->
			<?php if ( has_category() ) { ?>

				<li class="meta-cat">
					<span class="meta-title"><?php echo esc_html_e( 'Category:', 'lenscap' ); ?></span>

					<?php the_category( ', ' ); ?>
				</li>

			<?php } ?>

			<!-- Tags -->
			<?php
			$tags = get_the_tags();
			if ( ! empty( $tags ) ) { ?>

				<li class="meta-tag">
					<span class="meta-title"><?php echo esc_html_e( 'Tag:', 'lenscap' ); ?></span>

					<?php the_tags( '' ); ?>
				</li>

			<?php } ?>

		</ul><!-- .meta-list -->

		<!-- Sticky sidebar -->
		<ul class="meta-list sticky-widget">
			<?php if( is_single() ) {
				if( get_next_post() || get_previous_post() ) {
				?>

			<li class="meta-nav">
				<?php lenscap_post_navs(); ?>
			</li>
			<?php } } ?>

			<?php
				// Get the Jetpack sharing icons
				if ( function_exists( 'sharing_display' ) ) {
				echo "<li class='meta-share'><div class='share-icons'>";

					// Sharing Buttons
					if ( function_exists( 'sharing_display' ) ) {
						echo sharing_display();
					}

				echo "</div></li>";
			}
			?>

			<li class="sticky-spacer"><!-- empty spacer --></li>
		</ul><!-- .meta-list -->

	</div><!-- .entry-meta -->

