<?php
/**
 * Functions used throughout the theme
 *
 * @package Lenscap
 */


/**
 * Display the author description on author archive
 */
function the_author_archive_description( $before = '', $after = '' ) {

	$author_description  = get_the_author_meta( 'description' );

	if ( ! empty( $author_description ) ) {
		/**
		 * Get the author bio
		 */
		echo $author_description;
	}
}


/**
 * Site title and logo
 */
if ( ! function_exists( 'lenscap_title_logo' ) ) :
function lenscap_title_logo() { ?>
	<div class="site-title-wrap">
		<!-- Use the Site Logo feature, if supported -->
		<?php if ( function_exists( 'the_custom_logo' ) && the_custom_logo() ) {

			the_custom_logo();
		} ?>

		<div class="titles-wrap">
			<?php if ( is_front_page() && is_home() ) { ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
 			<?php } else { ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
 			<?php } ?>

			<?php if ( get_bloginfo( 'description' ) ) { ?>
				<p class="site-description"><?php bloginfo( 'description' ); ?></p>
			<?php } ?>
		</div>
	</div><!-- .site-title-wrap -->
<?php } endif;


/**
 * Custom comment output
 */
function lenscap_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class( 'clearfix' ); ?> id="li-comment-<?php comment_ID() ?>">

	<div class="comment-block" id="comment-<?php comment_ID(); ?>">

		<div class="comment-wrap">
			<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>

			<div class="comment-info">
				<cite class="comment-cite">
				    <?php comment_author_link() ?>
				</cite>

				<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf( esc_html__( '%1$s at %2$s', 'lenscap' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( esc_html__( '(Edit)', 'lenscap' ), '&nbsp;', '' ); ?>
			</div>

			<div class="comment-content">
				<?php comment_text() ?>
				<p class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
				</p>
			</div>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'lenscap' ) ?></em>
			<?php endif; ?>
		</div>
	</div>
<?php
}


/**
 * Output categories for the hero header
 *
 * * @since lenscap 1.2.1
 */
if ( ! function_exists( 'lenscap_list_cats' ) ) :
function lenscap_list_cats( $type ='grid' ) {
	global $post;

	$categories = get_the_category( $post->ID );

	if ( $categories ) {
		// Limit the number of categories output to 3 to keep things tidy
		$i = 0;

		echo '<div class=" '. $type . '-cats">';
			foreach( ( get_the_category( $post->ID ) ) as $cat ) {
				echo '<a href="' . esc_url( get_category_link( $cat->cat_ID ) ) . '">' . esc_html( $cat->cat_name ) . '</a>';
				if ( ++$i == 2 ) {
					break;
				}
			}
		echo '</div>';
	}
} endif;


/**
 * Output categories for the grid items
 *
 * * @since lenscap 1.2.1
 */
if ( ! function_exists( 'lenscap_grid_cats' ) ) :
function lenscap_grid_cats() {
	global $post;

	$categories = get_the_category( $post->ID );

	if ( $categories ) {
		// Limit the number of categories output to 3 to keep things tidy
		$i = 0;

		echo '<div class="grid-cats">';
			foreach( ( get_the_category( $post->ID ) ) as $cat ) {
				echo '<a href="' . esc_url( get_category_link( $cat->cat_ID ) ) . '">' . esc_html( $cat->cat_name ) . '</a>';
				if ( ++$i == 3 ) {
					break;
				}
			}
		echo '</div>';
	}
} endif;


/**
 * Displays post pagination links
 *
 * @since lenscap 1.0
 */
if ( ! function_exists( 'lenscap_page_navs' ) ) :
function lenscap_page_navs( $query = false ) {

	global $wp_query;
	if( $query ) {
		$temp_query = $wp_query;
		$wp_query = $query;
	}

	// Return early if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	} ?>
	<div class="page-navigation">
		<?php
			$big = 999999999; // need an unlikely integer

			echo paginate_links( array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, get_query_var('paged') ),
				'total'     => $wp_query->max_num_pages,
				'next_text' => esc_html__( '&rarr;', 'lenscap' ),
				'prev_text' => esc_html__( '&larr;', 'lenscap' )
			) );
		?>
	</div>
	<?php
	if( isset( $temp_query ) ) {
		$wp_query = $temp_query;
	}
} endif;


/**
 * Displays post next/previous navigations
 *
 * @since lenscap 1.0
 */
if ( ! function_exists( 'lenscap_post_navs' ) ) :
function lenscap_post_navs( $query = false ) {
	// Previous/next post navigation.
	$next_post = get_next_post();
	$previous_post = get_previous_post();

	the_post_navigation( array(
		'next_text' => '<span class="meta-nav-text meta-title">' . esc_html__( 'Next:', 'lenscap' ) . '</span> ' .
		'<span class="screen-reader-text">' . esc_html__( 'Next post:', 'lenscap' ) . '</span> ' .
		'<span class="post-title">%title</span>',
		'prev_text' => '<span class="meta-nav-text meta-title">' . esc_html__( 'Previous:', 'lenscap' ) . '</span> ' .
		'<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'lenscap' ) . '</span> ' .
		'<span class="post-title">%title</span>',
	) );
} endif;


/**
 * Author post widget
 *
 * @since 1.0
 */
if ( ! function_exists( 'lenscap_author_box' ) ) :
function lenscap_author_box() {
	global $post, $current_user;
	$author = get_userdata( $post->post_author );
	if ( $author ) {
	?>
	<div class="author-profile">

		<a class="author-profile-avatar" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( sprintf( esc_html__( 'Posts by %s', 'lenscap' ), get_the_author() ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'lenscap_author_bio_avatar_size', 65 ) ); ?></a>

		<div class="author-profile-info">
			<h3 class="author-profile-title">
				<?php if ( is_archive() ) { ?>
					<?php echo esc_html( sprintf( esc_html__( 'All posts by %s', 'lenscap' ), get_the_author() ) ); ?>
				<?php } else { ?>
					<?php echo esc_html( sprintf( esc_html__( 'Posted by %s', 'lenscap' ), get_the_author() ) ); ?>
				<?php } ?>
			</h3>

			<?php if ( empty( $author->description ) && $post->post_author == $current_user->ID ) { ?>
				<div class="author-description">
					<p>
					<?php
						$profile_string = sprintf( wp_kses( __( 'Complete your author profile info to be shown here. <a href="%1$s">Edit your profile &rarr;</a>', 'lenscap' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'profile.php' ) ) );
						echo $profile_string;
					?>
					</p>
				</div>
			<?php } else if ( $author->description ) { ?>
				<div class="author-description">
					<p><?php the_author_meta( 'description' ); ?></p>
				</div>
			<?php } ?>

			<div class="author-profile-links">
				<a href="<?php echo esc_url( get_author_posts_url( $author->ID ) ); ?>"><i class="fa fa-pencil-square-o"></i> <?php esc_html_e( 'All Posts', 'lenscap' ); ?></a>

				<?php if ( $author->user_url ) { ?>
					<?php printf( '<a href="%1$s"><i class="fa fa-external-link"></i> %2$s</a>', esc_url( $author->user_url ), 'Website', 'lenscap' ); ?>
				<?php } ?>
			</div>
		</div><!-- .author-drawer-text -->
	</div><!-- .author-profile -->

<?php } } endif;