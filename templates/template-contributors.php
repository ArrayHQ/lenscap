<?php
/**
 * Template Name: Contributors
 *
 * @package Lenscap
 */

// Order the author list by display name in alphabetical order
$user_args = array(
	'orderby' => 'display_name',
	'order'   => 'ASC',
	'role__in' => array( 'contributor', 'author', 'editor', 'administrator' ),
	'number'   => 100
);
get_users( $user_args );

// Get a list of all authors
$all_users = get_users( $user_args );
$users     = array();

// Remove subscribers from the author list
foreach( $all_users as $currentUser ) {
	if( !in_array( 'subscriber', $currentUser->roles ) ) {
		$users[] = $currentUser;
	}
}

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header><!-- .entry-header -->

				<?php while ( have_posts() ) : the_post();
					if( get_the_content() ) {
						the_content();
				} endwhile; ?>

				<div class="author-columns">
				<?php foreach( $users as $user ) {

					// Only show the author if they have posts
					$user_post_count = count_user_posts( $user->ID );
					if ( $user_post_count > 0 ) {
					?>

					<div class="author-profile">

						<a class="author-profile-avatar" href="<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>" title=""><?php echo get_avatar( $user->user_email, '75' ); ?></a>

						<div class="author-profile-info">
							<h3 class="author-profile-title">
								<?php echo esc_html( sprintf( $user->display_name ) ); ?>
							</h3>

							<?php if ( $user->description ) { ?>
								<?php echo get_user_meta( $user->ID, 'description', true ); ?>
							<?php } ?>

							<div class="author-profile-links">
								<?php $user_post_count = count_user_posts( $user->ID );

									if( $user_post_count > 0 ) {
								?>
								<a href="<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>"><i class="fa fa-pencil-square-o"></i> <?php esc_html_e( 'All Posts', 'lenscap' ); ?></a>
								<?php } ?>

								<?php if ( $user->user_url ) { ?>
									<?php printf( '<a href="%1$s"><i class="fa fa-external-link"></i> %2$s</a>', esc_url( $user->user_url ), 'Website', 'lenscap' ); ?>
								<?php } ?>
							</div>
						</div><!-- .author-profile-info -->
					</div><!-- .author-profile -->

				<?php } } ?>
				</div><!-- .author-columns -->
			</article><!-- #post-## -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>