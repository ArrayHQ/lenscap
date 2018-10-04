<?php
/**
 * This template displays the search form.
 *
 * @package Lenscap
 */
?>

<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<label class="screen-reader-text"><?php esc_html_e( 'Search for:', 'lenscap' ); ?></label>

		<input type="text" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" class="search-input" placeholder="<?php esc_attr_e( 'Search here...', 'lenscap' ); ?>" />

		<button class="searchsubmit" type="submit">
			<i class="fa fa-search"></i> <span><?php echo esc_html_e( 'Search', 'lenscap' ); ?></span>
		</button>
	</div>
</form>