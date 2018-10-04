<?php
/**
 * The template used for displaying testimonials.
 *
 * @package Lenscap
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'testimonial-entry testimonial-entry-column-1' ); ?>>

	<div class="testimonial-entry-content">
		<?php the_content(); ?>
	</div>

	<h2 class="testimonial-entry-title">
		<?php the_title(); ?>
	</h2>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="testimonial-featured-image">
			<?php the_post_thumbnail( 'lenscap-testimonial-avatar' ); ?>
		</div>
	<?php endif; ?>

	<?php edit_post_link( esc_html__( 'Edit', 'lenscap' ), '<span class="edit-link">', '</span>' ); ?>
</article>
