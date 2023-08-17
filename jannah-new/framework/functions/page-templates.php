<?php
/**
 * Post Template Functions.
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


/**
 * set Custom class for body for masonry page
 */
if( ! function_exists( 'tie_template_masonry_custom_body_class' ) ) {

	function tie_template_masonry_custom_body_class( $classes ){

		$post = get_post();

		if( empty( $post->post_content ) ){
			$classes[] = 'has-not-post-content';
		}

		if( tie_get_postdata( 'tie_hide_title' ) ){
			$classes[] = 'has-not-post-title';
		}

		return $classes;
	}
}


/**
 * Get Masonry for the Masonry page template
 */
if( ! function_exists( 'tie_template_get_masonry' ) ) {

	function tie_template_get_masonry(){

		$after = '';

		if( TIELABS_HELPER::has_builder() ){

			echo '
				<div class="section-item container full-width">
					<div class="main-content-row">
						<div class="main-content tie-col-md-12">';

			$after = '
						</div>
					</div>
				</div>';
		}


		echo '<div class="masonry-page-content clearfix">';

		// Masonry Page query
		$excerpt         = tie_get_postdata( 'tie_blog_excerpt' )         ? 'true' : '';
		$post_meta       = tie_get_postdata( 'tie_blog_meta' )            ? 'true' : '';
		$category_meta   = tie_get_postdata( 'tie_blog_category_meta' )   ? 'true' : '';
		$uncropped_image = tie_get_postdata( 'tie_blog_uncropped_image' ) ? 'full' : TIELABS_THEME_SLUG.'-image-post';
		$excerpt_length  = tie_get_postdata( 'tie_blog_length' )          ? tie_get_postdata( 'tie_blog_length' ) : '';
		$layout          = tie_get_postdata( 'tie_blog_layout' )          ? tie_get_postdata( 'tie_blog_layout' ) : 'masonry';
		$pagination      = tie_get_object_option( 'blog_pagination', false, 'tie_blog_pagination' );

		// Pagination
		$paged   = intval( get_query_var('paged') );
		$paged_2 = intval( get_query_var('page')  );

		if( empty( $paged ) && ! empty( $paged_2 ) ) {
			global $paged; // Used by the get_previous_posts_link() and get_next_posts_link
			$paged = $paged_2;
		}

		if( empty( $paged ) || $paged == 0 ){
			$paged = 1;
		}

		$args = array();

		$args['paged'] = $paged;

		// Categories
		$blog_cats = maybe_unserialize( tie_get_postdata( 'tie_blog_cats' ) );

		$args['category__in'] = ! empty( $blog_cats ) ? $blog_cats : get_terms( array( 'taxonomy' => 'category', 'fields' => 'ids' ) );

		// Number of Posts
		if( tie_get_postdata( 'tie_posts_num' ) ){
			$args['posts_per_page'] = tie_get_postdata( 'tie_posts_num' );
		}

		// Do not duplicate posts
		if( ! empty( $GLOBALS['tie_do_not_duplicate'] ) && is_array( $GLOBALS['tie_do_not_duplicate'] ) ) {
			$args['post__not_in'] = $GLOBALS['tie_do_not_duplicate'];
		}

		// Run The Query
		query_posts( apply_filters( 'TieLabs/Page_Template/Masonry/query_args', $args ) );

		// Get the layout template part
		TIELABS_HELPER::get_template_part( 'templates/archives', '', array(
			'layout'          => $layout,
			'excerpt'         => $excerpt,
			'excerpt_length'  => $excerpt_length,
			'post_meta'       => $post_meta,
			'category_meta'   => $category_meta,
			'uncropped_image' => $uncropped_image,
		));

		// Page navigation
		TIELABS_PAGINATION::show( array( 'type' => $pagination ) );

		// Reset the query
		wp_reset_query();

		echo '</div>';

		echo ( $after );
	}
}


/**
 * Get authors for the authors page template
 */
if( ! function_exists( 'tie_template_get_authors' ) ) {

	function tie_template_get_authors(){

		$users_args = array();
		$users_role = maybe_unserialize( tie_get_postdata( 'tie_authors') );

		if( ! empty( $users_role ) && is_array( $users_role ) ){
			$users_args['role__in'] = $users_role;
		}

		$get_users = get_users( apply_filters( 'TieLabs/Page_Template/Authors/args', $users_args ) );

		if ( empty( $get_users ) ){
			return;
		}

		echo'<ul class="authors-wrap">';
			foreach ( $get_users as $user ){
				echo '<li>';
					tie_author_box( $user );
				echo '</li>';
			}
		echo'</ul>';
	}
}


/**
 * Sitemap for the sitemap page template
 */
if( ! function_exists( 'tie_template_sitemap' ) ) {

	function tie_template_sitemap(){

		$column_class = 'tie-col-md-3';

		?>

		<div id="sitemap" class="tie-row">

			<div id="sitemap-pages" class="<?php echo esc_attr( $column_class ) ?>">
				<h3><?php esc_html_e( 'Pages', TIELABS_TEXTDOMAIN ) ?></h3>

				<ul>
					<?php wp_list_pages( apply_filters( 'TieLabs/Page_Template/Sitemap/pages', array( 'title_li' => '' ) ) ) ?>
				</ul>
			</div><!-- #sitemap-pages /-->


			<div id="sitemap-categories" class="<?php echo esc_attr( $column_class ) ?>">
				<h3><?php esc_html_e( 'Categories', TIELABS_TEXTDOMAIN ) ?></h3>

				<ul>
					<?php wp_list_categories( apply_filters( 'TieLabs/Page_Template/Sitemap/categories', array( 'title_li' => '' ) ) ); ?>
				</ul>
			</div><!-- #sitemap-categories /-->


			<div id="sitemap-tags" class="<?php echo esc_attr( $column_class ) ?>">
				<h3><?php esc_html_e( 'Tags', TIELABS_TEXTDOMAIN ) ?></h3>

				<ul>
					<?php
						$get_tags  = get_tags( apply_filters( 'TieLabs/Page_Template/Sitemap/tags', '' ) );
						$tags_list = '';

						if ( ! empty( $get_tags ) ) {
							foreach ( $get_tags as $tag ){
								?>
									<li><a href="<?php echo TIELABS_WP_HELPER::get_term_link( $tag->term_id, 'post_tag' ) ?>"><?php echo $tag->name ?></a></li>
								<?php
							}
						}
					?>
				</ul>
			</div><!-- #sitemap-tags /-->


			<div id="sitemap-authors" class="<?php echo esc_attr( $column_class ) ?>">
				<h3><?php esc_html_e( 'Authors', TIELABS_TEXTDOMAIN ) ?></h3>

				<ul>
					<?php wp_list_authors( apply_filters( 'TieLabs/Page_Template/Sitemap/authors', array( 'optioncount' => true, 'exclude_admin' => false ) ) ) ?>
				</ul>
			</div><!-- #sitemap-authors /-->


			<div class="clearfix">

		</div><!-- end #sitemap -->

		<?php
	}
}
