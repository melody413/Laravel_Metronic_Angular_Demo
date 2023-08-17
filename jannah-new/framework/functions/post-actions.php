<?php
/**
 * Single Post page hooks
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


/**
 * Show the normal Pages head
 */
if( ! function_exists( 'tie_show_page_head' ) ) {

	add_action( 'TieLabs/before_single_post_title', 'tie_show_page_head', 10 );
	function tie_show_page_head(){

		$exclude_post_types = apply_filters( 'TieLabs/page_head/exc_post_types', TIELABS_HELPER::get_supported_post_types() );

		if( is_page() || ( TIELABS_BBPRESS_IS_ACTIVE && is_bbpress() ) || ( is_singular() && ! in_array( get_post_type(), $exclude_post_types ) ) ){

			TIELABS_HELPER::get_template_part( 'templates/page', 'head' );
		}
	}
}


/**
 * Show the Post Head and Featured Sections
 */
if( ! function_exists( 'tie_show_post_head_featured' ) ) {

	add_action( 'TieLabs/before_single_post_title', 'tie_show_post_head_featured', 10 );
	function tie_show_post_head_featured(){

		if( ! TIELABS_HELPER::is_supported_post_type() ){
			return;
		}

		$post_layout = tie_get_object_option( 'post_layout', 'cat_post_layout', 'tie_post_layout' );
		$post_layout = ! empty( $post_layout ) ? $post_layout : 1;

		if( $post_layout == 2 || $post_layout == 3 || $post_layout == 4 || $post_layout == 5 || $post_layout == 8 ){
			TIELABS_HELPER::get_template_part( 'templates/single-post/featured' );
		}

		if( $post_layout == 1 || $post_layout == 2 || $post_layout == 6 ){
			TIELABS_HELPER::get_template_part( 'templates/single-post/head' );
		}

		// Get the top share buttons
		if( tie_get_option( 'post_meta_style' ) != 'column' ){
			TIELABS_HELPER::get_template_part( 'templates/single-post/share', '', array( 'share_position' => 'top' ) );
		}

		if( $post_layout == 1 ){
			TIELABS_HELPER::get_template_part( 'templates/single-post/featured' );
		}
	}
}


/**
 * Show the Post Story Highlights section
 */
if( ! function_exists( 'tie_story_highlights' ) ) {

	add_action( 'TieLabs/before_post_content', 'tie_story_highlights', 10 );
	function tie_story_highlights(){

		if( ! is_single() ){
			return;
		}

		$story_highlights = tie_get_postdata( 'tie_highlights_text' );

		if( ! empty( $story_highlights ) && is_array( $story_highlights ) ){
			echo '
				<div id="story-highlights">
					<div '. tie_box_class( 'widget-title', false ) .'>
						<div class="the-subtitle">'. esc_html__( 'Story Highlights', TIELABS_TEXTDOMAIN ) .'</div>
					</div>
					<ul>';
						foreach( $story_highlights as $highlight ){
							echo '<li>'. $highlight .'</li>';
						}
						echo '
					</ul>
				</div>
			';
		}
	}
}


/**
 * Multi pages post
 */
if( ! function_exists( 'tie_post_multi_pages' ) ) {

	add_action( 'TieLabs/after_post_content', 'tie_post_multi_pages', 10 );
	function tie_post_multi_pages(){

		// Add current post ID to the do not duplicate array
		tie_single_post_do_not_dublicate();

		// Post content navigation
		$args = array(
			'before'         => '<div class="multiple-post-pages clearfix">',
			'after'          => '</div>',
			'link_before'    => '<span>',
			'link_after'     => '</span>',
			'next_or_number' => 'next_and_number',
		);

		wp_link_pages( $args );
	}
}


/**
 * Source and Via sections
 */
if( ! function_exists( 'tie_post_source_via' ) ) {

	add_action( 'TieLabs/after_post_content', 'tie_post_source_via', 20 );
	function tie_post_source_via(){

		if( ! TIELABS_HELPER::is_supported_post_type() ){
			return;
		}

		$source_via = array(
			'tie_via' => array(
				'title' => esc_html__( 'Via', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-external-link',
			),
			'tie_source' => array(
				'title' => esc_html__( 'Source', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-link',
			),
		);

		foreach ( $source_via as $item => $args ){

			$get_data = tie_get_postdata( $item );

			if( ! empty( $get_data ) && is_array( $get_data ) ){
				echo'
					<div class="post-bottom-meta '. str_replace( 'tie_', 'post-bottom-', $item ) .'">
						<div class="post-bottom-meta-title">
							<span class="'. $args['icon'] .'" aria-hidden="true"></span> '. $args['title'] .'
						</div>
						<span class="tagcloud">';
							foreach( $get_data as $data ){
								if( ! empty( $data['text'] ) ){

									$url = ! empty( $data['url'] ) ? ' href="'. esc_url( $data['url'] ) .'" target="_blank" rel="nofollow noopener"' : '';

									echo '<a'. $url .'>'. esc_attr( $data['text'] ) .'</a>';
								}
							}
							echo '
						</span>
					</div>
				';
			}
		}
	}
}


/**
 * Tags section below the post
 */
if( ! function_exists( 'tie_post_tags' ) ) {

	add_action( 'TieLabs/after_post_content', 'tie_post_tags', 30 );
	function tie_post_tags(){

		if( ! is_singular( 'post' ) ){
			return;
		}

		if(( tie_get_option( 'post_tags' ) && ! tie_get_postdata( 'tie_hide_tags' ) ) || tie_get_postdata( 'tie_hide_tags' ) == 'no' ){

			$style = tie_get_option( 'post_tags_layout', 'modern' );

			the_tags( '<div class="post-bottom-meta post-bottom-tags post-tags-'. $style .'"><div class="post-bottom-meta-title"><span class="tie-icon-tags" aria-hidden="true"></span> '. esc_html__( 'Tags', TIELABS_TEXTDOMAIN ) .'</div><span class="tagcloud">', ' ', '</span></div>' );
		}
	}
}


/**
 * Edit the post button
 */
if( ! function_exists( 'tie_edit_post_button' ) ) {

	add_action( 'TieLabs/after_post_content', 'tie_edit_post_button', 40 );
	function tie_edit_post_button(){

		if( ! TIELABS_HELPER::is_supported_post_type() ){
			return;
		}

		edit_post_link(
			'<span class="tie-icon-pencil" aria-hidden="true"></span> '. esc_html__( 'Edit Post', TIELABS_TEXTDOMAIN ),
			'<div class="post-bottom-meta post-bottom-edit"><div class="post-bottom-meta-title">',
			'</div></div>'
		);
	}
}


/**
 * Get the bottom share buttons
 */
if( ! function_exists( 'tie_post_share_bottom' ) ) {

	add_action( 'TieLabs/after_post_entry', 'tie_post_share_bottom', 20 );
	function tie_post_share_bottom(){

		TIELABS_HELPER::get_template_part( 'templates/single-post/share', '', array( 'share_position' => 'bottom' ) );
	}
}


/**
 * Get the bottom share buttons
 */
if( ! function_exists( 'tie_post_extra_info_column' ) ) {

	add_action( 'TieLabs/after_post_entry', 'tie_post_extra_info_column', 5 );
	function tie_post_extra_info_column(){

		if( ! TIELABS_HELPER::is_supported_post_type() ){
			return;
		}

		?>
		<div id="post-extra-info">
			<div class="theiaStickySidebar">
				<?php
					if( ( tie_get_option( 'post_meta' ) && ! tie_get_postdata( 'tie_hide_meta' ) ) || tie_get_postdata( 'tie_hide_meta' ) == 'no' ){

						$args = array(
							'author'   => tie_get_option( 'post_author' ),
							'avatar'   => tie_get_option( 'post_author_avatar' ),
							'twitter'  => tie_get_option( 'post_author_twitter' ),
							'email'    => tie_get_option( 'post_author_email' ),
							'date'     => tie_get_option( 'post_date' ),
							'modified' => tie_get_option( 'modified' ),
							'comments' => tie_get_option( 'post_comments' ),
							'views'    => tie_get_option( 'post_views' ),
							'reading'  => tie_get_option( 'reading_time' ),
							'is_main'  => true,
						);

						tie_the_post_meta( $args );
					}

					TIELABS_HELPER::get_template_part( 'templates/single-post/share', '', array( 'share_position' => 'top' ) );
				?>
			</div>
		</div>

		<div class="clearfix"></div>
		<?php
	}
}


/**
 * Show Read Next Posts section
 */
if( ! function_exists( 'tie_read_next_posts' ) ) {

	add_action( 'TieLabs/post_components', 'tie_read_next_posts', 30 );
	function tie_read_next_posts(){
		TIELABS_HELPER::get_template_part( 'templates/single-post/read-next' );
	}
}


/**
 * Show About the author box
*/
if( ! function_exists( 'tie_post_about_author' ) ) {

	add_action( 'TieLabs/post_components', 'tie_post_about_author', 20 );
	function tie_post_about_author(){

		if( ! TIELABS_HELPER::is_supported_post_type() ){
			return;
		}

		if( (( tie_get_option( 'post_authorbio' ) && ! tie_get_postdata( 'tie_hide_author' ) ) || tie_get_postdata( 'tie_hide_author' ) == 'no' ) && ! TIELABS_HELPER::is_mobile_and_hidden( 'post_authorbio' ) ){

			// Get the Authors IDs
			$post_authors = tie_get_post_authors();

			if ( is_array( $post_authors ) && ! empty( $post_authors ) ) {
				foreach ( $post_authors as $author ) {
					tie_author_box( $author );
				}
			}

		}
	}
}


/**
 * Show the Newsletter box
 */
if( ! function_exists( 'tie_post_newsletter' ) ) {

	add_action( 'TieLabs/post_components', 'tie_post_newsletter', 40 );
	function tie_post_newsletter(){

		if( ! TIELABS_HELPER::is_supported_post_type() ){
			return;
		}

		// Check if the newsletter is hidden on mobiles
		if( TIELABS_HELPER::is_mobile_and_hidden( 'post_newsletter' ) ){
			return;
		}

		if( ( ( tie_get_option( 'post_newsletter' ) && ! tie_get_postdata( 'tie_hide_newsletter' ) ) || tie_get_postdata( 'tie_hide_newsletter' ) == 'no' ) ){

			TIELABS_HELPER::get_template_part( 'templates/single-post/newsletter' );
		}
	}
}


/**
 * Show Next and Prev Posts box
 */
if( ! function_exists( 'tie_post_next_prev' ) ) {

	add_action( 'TieLabs/post_components', 'tie_post_next_prev', 50 );
	function tie_post_next_prev(){

		if( ! is_singular( 'post' ) ){
			return;
		}

		if( (( tie_get_option( 'post_nav' ) && ! tie_get_postdata( 'tie_hide_nav' ) ) || tie_get_postdata( 'tie_hide_nav' ) == 'no' ) && ! TIELABS_HELPER::is_mobile_and_hidden( 'post_nav' ) ){

			echo'<div class="prev-next-post-nav container-wrapper media-overlay">';
				tie_prev_post();
				tie_next_post();
			echo '</div><!-- .prev-next-post-nav /-->';
		}
	}
}


/**
 * Show Related Posts section
 */
if( tie_get_option( 'related_position') == 'post' ){
	add_action( 'TieLabs/post_components', 'tie_related_posts', 60 );
}
elseif( tie_get_option( 'related_position') == 'comments' ){
	add_action( 'TieLabs/post_components', 'tie_related_posts', 80 );
}
elseif( tie_get_option( 'related_position') == 'footer' ){
	add_action( 'TieLabs/after_main_content', 'tie_related_posts', 10 );
}


if( ! function_exists( 'tie_related_posts' ) ) {

	function tie_related_posts(){
		TIELABS_HELPER::get_template_part( 'templates/single-post/related' );
	}
}


/**
 * The Comments
 */
if( ! function_exists( 'tie_post_comments' ) ) {

	add_action( 'TieLabs/post_components', 'tie_post_comments', 70 );
	function tie_post_comments(){
		comments_template();
	}
}

/**
 * Compact Comments Button
 */
add_action( 'TieLabs/post_components', 'tie_add_show_comments_button', 69 );
function tie_add_show_comments_button(){

	// Should be quried before have_comments();
	$page = get_query_var( 'cpage' );

	// have_comments() will always return “false” until after comments_template() has been called.
	$have_comments = get_comments_number();

	if ( tie_get_option( 'compact_comments' ) && ( ! empty( $have_comments ) || comments_open() ) ){

		// Enable it on the first page only
		if ( empty( $page ) ) {

			if( tie_get_option( 'compact_comments_title' ) ){

				$text = tie_get_option( 'compact_comments_title' );
			}
			else{

				$comments_number = get_comments_number();

				if ( $comments_number > 1 ){
					$text = sprintf( esc_html__( 'Show %s comments', TIELABS_TEXTDOMAIN ), get_comments_number_text( '0', '1', '%' ) );
				}
				elseif( $comments_number == 1 ) {
					$text = esc_html__( 'Show one comment', TIELABS_TEXTDOMAIN );
				}
				else{
					$text = esc_html__( 'Leave a Reply', TIELABS_TEXTDOMAIN );
				}
			}

			echo '
				<div class="compact-comments">
					<a id="show-comments-section" href="#" class="button">'. $text .'</a>
				</div>
				<style>#comments{display: none;}</style>
			';
		}
	}
}


/**
 * Show the Fly Box
 */
if( ! function_exists( 'tie_post_fly_box' ) ) {

	add_action( 'TieLabs/after_post_column', 'tie_post_fly_box', 10 );
	function tie_post_fly_box(){

		if( ! is_singular( 'post' ) ){
			return;
		}

		if( (( tie_get_option( 'check_also' ) && ! tie_get_postdata( 'tie_hide_check_also' )) || ( tie_get_postdata( 'tie_hide_check_also' ) == 'no' )) && ! tie_is_mobile() ){

			TIELABS_HELPER::get_template_part( 'templates/single-post/fly-box' );
		}
	}
}


/*
 * Float Share Buttons
 */
if( ! function_exists( 'tie_sticky_share_buttons' ) ) {

	add_action( 'TieLabs/after_footer', 'tie_sticky_share_buttons' );
	function tie_sticky_share_buttons(){

		if( ! TIELABS_HELPER::is_supported_post_type() || TIELABS_HELPER::has_builder() ){
			return;
		}

		TIELABS_HELPER::get_template_part( 'templates/single-post/share', '', array( 'share_position' => 'sticky' ) );
	}
}


/*
 * Mobile Share Buttons
 */
if( ! function_exists( 'tie_mobile_share_buttons' ) ) {

	add_action( 'TieLabs/after_footer', 'tie_mobile_share_buttons' );
	function tie_mobile_share_buttons(){

		if( ! TIELABS_HELPER::is_supported_post_type() || TIELABS_HELPER::has_builder() ){
			return;
		}

		TIELABS_HELPER::get_template_part( 'templates/single-post/share', '', array( 'share_position' => 'mobile' ) );
	}
}


/*
 * Show More Content on Mobiles
 */
if( ! function_exists( 'tie_mobile_toggle_content_button' ) ) {

	add_action( 'TieLabs/after_post_entry', 'tie_mobile_toggle_content_button' );
	function tie_mobile_toggle_content_button(){

		if( ! TIELABS_HELPER::is_supported_post_type() || ! tie_get_option( 'mobile_post_show_more' ) ) {
			return;
		} ?>

		<div class="toggle-post-content clearfix">
			<a id="toggle-post-button" class="button" href="#">
				<?php esc_html_e( 'Show More', TIELABS_TEXTDOMAIN ); ?> <span class="tie-icon-angle-down"></span>
			</a>
		</div><!-- .toggle-post-content -->
		<script type="text/javascript">
			var $thisPost = document.getElementById('the-post');
			$thisPost = $thisPost.querySelector('.entry');

			var $thisButton = document.getElementById('toggle-post-button');
			$thisButton.addEventListener( 'click', function(e){
				$thisPost.classList.add('is-expanded');
				$thisButton.parentNode.removeChild($thisButton);
				e.preventDefault();
			});
		</script>
		<?php
	}
}



/*
 * Inline related posts
 */
if( ! function_exists( 'tie_inline_related_posts' ) ) {

	function tie_inline_related_posts( $content ){

		if ( is_singular( 'post' ) ) {

			// Check if the related posts is hidden on mobiles
			if( ! tie_get_option( 'inline_related_posts' ) || TIELABS_HELPER::is_mobile_and_hidden( 'inline_related_posts' ) ){
				return $content;
			}

			// Prepare the query
			$paragraph_number = tie_get_option( 'inline_related_posts_paragraphs' );

			$query_type   = tie_get_option( 'inline_related_posts_query' );
			$posts_number = tie_get_option( 'inline_related_posts_number', 2 );
			$order        = tie_get_option( 'inline_related_posts_order' );

			$args = tie_get_related_posts_args( $query_type, $order, $posts_number );

			$args = apply_filters( 'TieLabs/inline_related_posts/query', $args );

			// Get the posts
			$related_query = new wp_query( $args );

			if( $related_query->have_posts() ){

				$do_not_duplicate = array();

				$args = array(
					'thumbnail'       => TIELABS_THEME_SLUG.'-image-small',
					'thumbnail_first' => false,
					'review'          => false,
					'review_first'    => false,
					'count'           => 0,
					'show_score'      => false,
					'title_length'    => '',
					'exclude_current' => false,
					'media_icon'      => false,
				);

				ob_start();
				?>
				<div id="inline-related-post" class="mag-box mini-posts-box content-only">
					<div class="container-wrapper">

						<div <?php tie_box_class( 'widget-title' ) ?>>
							<div class="the-subtitle"><?php esc_html_e( 'Related Articles', TIELABS_TEXTDOMAIN ); ?></div>
						</div>

						<div class="mag-box-container clearfix">
							<ul class="posts-items posts-list-container">
								<?php
									while ( $related_query->have_posts() ){

										$related_query->the_post();

										$do_not_duplicate[] = get_the_ID();

										TIELABS_HELPER::get_template_part( 'templates/loops/loop', 'widgets', $args );

										// Add the do not duplicate array to the GLOBALS
										tie_single_post_do_not_dublicate( $do_not_duplicate );
									}
								?>
							</ul>
						</div>
					</div>
				</div>
				<?php

				$related_section = ob_get_clean();

				wp_reset_postdata();

				return tie_post_inline_content( $related_section, $paragraph_number, $content );
			}
		}

		return $content;
	}


	/**
		Some plugins load the the_content in some places such as the wp_head,
		we register this action immediately before loading the content in the single post page only
	 */
	add_filter( 'TieLabs/before_post_content', 'tie_add_inline_related_posts_filter', 100 );
	function tie_add_inline_related_posts_filter(){
		add_filter( 'the_content', 'tie_inline_related_posts', 100 );
	}

	/**
		Remove the action
	 */
	add_filter( 'TieLabs/after_post_content', 'tie_remove_inline_related_posts_filter', 10 );
	function tie_remove_inline_related_posts_filter(){
		remove_filter( 'the_content', 'tie_inline_related_posts', 100 );
	}
}
