<?php
/**
 * Pagination Class
 *
 */


defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( ! class_exists( 'TIELABS_PAGINATION' ) ) {

	class TIELABS_PAGINATION {


		public static function show( $args = array() ){

			// Defaults
			$args = wp_parse_args( $args, array(
				'type'   => 'next-prev',
				'before' => '<div class="pages-nav">',
				'after'  => '</div>',
				'query'  => false,
			));

			extract( $args );

			// Numeric Navigation
			if( $type == 'numeric' ){

				self::numeric( $query, $before, $after );
			}

			else{

				global $wp_query;

				if( $wp_query->max_num_pages <= 1 ) return;

				$query = array_filter( $wp_query->query_vars );

				unset( $query['cache_results'] );
				unset( $query['update_post_term_cache'] );
				unset( $query['update_post_meta_cache'] );
				unset( $query['comments_per_page'] );
				unset( $query['search_terms_count'] );
				unset( $query['search_terms'] );
				unset( $query['search_orderby_title'] );

				if( ! empty( $query['category__in'] ) ){
					unset( $query['cat'] );
					unset( $query['category_name'] );
				}
				elseif( ! empty( $query['cat'] ) ){
					unset( $query['category_name'] );
				}

				$query = str_replace( '"', '\'', wp_json_encode( $query ));

				echo ( $before );

				// Load More or Infinite Scroll Navigation
				if( $type == 'load-more' || $type == 'infinite'  ){

					$paged       = intval( get_query_var('paged') );
					$paged_2     = intval( get_query_var('page' ) );
					$latest_post = ! empty( $GLOBALS['latest_post_count'] ) ? $GLOBALS['latest_post_count'] : 0;

					if( empty( $paged ) && ! empty( $paged_2 ) ) {
						$paged = $paged_2;
					}

					if( empty( $paged ) || $paged == 0 ){
						$paged = 1;
					}

					$class = ( $type == 'infinite' ) ? 'infinite-scroll-archives' : '';

					if( $wp_query->max_num_pages > $paged ){

						// Load the file contains the requrired js codes
						wp_enqueue_script( 'tie-js-viewport' );

						// --
						echo '<a data-url="'. get_pagenum_link( 99999 ) .'" data-text="'. esc_html__( 'Load More', TIELABS_TEXTDOMAIN ) .'" data-query="'. $query .'" data-max="'. $wp_query->max_num_pages .'" data-page="'. $paged .'" data-latest="'. $latest_post .'" id="load-more-archives" class="container-wrapper show-more-button load-more-button '. $class .'">'. esc_html__( 'Load More', TIELABS_TEXTDOMAIN ) .'</a>';
					}
				}

				// Next / Prev Navigation
				else{
					?>
					<div class="pages-numbers pages-standard">
						<span class="first-page first-last-pages">
							<?php previous_posts_link( '<span class="pagination-icon" aria-hidden="true"></span>'. esc_html__( 'Previous page', TIELABS_TEXTDOMAIN ) ); ?>
						</span>

						<span class="last-page first-last-pages">
							<?php next_posts_link( '<span class="pagination-icon" aria-hidden="true"></span>'. esc_html__( 'Next page', TIELABS_TEXTDOMAIN ) ); ?>
						</span>
					</div>
					<?php
				}

				echo ( $after );
			}
		}


		/*
		 * Numeric Navigation
		 * Based on WP-PageNavi plugin - by Lester 'GaMerZ' Chan - http://lesterchan.net
		 */
		private static function numeric( $query = false, $before = '', $after = '' ){

			if ( is_single() ) return;

			if( ! empty( $query ) ) {
				$request		    = $query->request;
				$numposts 		  = ! empty( $query->query_vars['new_found_posts'] )   ? $query->query_vars['new_found_posts']   : $query->found_posts;
				$max_page 		  = ! empty( $query->query_vars['new_max_num_pages'] ) ? $query->query_vars['new_max_num_pages'] : $query->max_num_pages;
				$posts_per_page = intval( $query->query_vars['posts_per_page'] );
			}
			else{
				global $wp_query;

				if( $wp_query->max_num_pages <= 1 ) return;

				$request 		    = $wp_query->request;
				$numposts 		  = $wp_query->found_posts;
				$max_page 		  = $wp_query->max_num_pages;
				$posts_per_page = intval(get_query_var('posts_per_page'));
			}

			$pagenavi_options = array(
				// 'pages_text' => esc_html__('Page %CURRENT_PAGE% of %TOTAL_PAGES%', TIELABS_TEXTDOMAIN ),
				'current_text'  => '%PAGE_NUMBER%',
				'page_text'		  => '%PAGE_NUMBER%',
				'first_text' 	  => esc_html__( 'First', TIELABS_TEXTDOMAIN ),
				'last_text'		  => esc_html__( 'Last', TIELABS_TEXTDOMAIN ),
				'next_text'		  => esc_html__( '&raquo;', TIELABS_TEXTDOMAIN ),
				'prev_text'		  => esc_html__( '&laquo;', TIELABS_TEXTDOMAIN ),
				'dotright_text' => '...',
				'dotleft_text'  => '...',
				'larger_page_numbers_multiple' => 10,
			);

			$pagenavi_options = apply_filters( 'TieLabs/numeric_pagination_args', $pagenavi_options );

			global $paged;

			$paged   = intval( get_query_var('paged') );
			$paged_2 = intval( get_query_var('page')  );

			if( empty( $paged ) && ! empty( $paged_2 ) ) {
				$paged = $paged_2;
			}

			if( empty( $paged ) || $paged == 0 ){
				$paged = 1;
			}

			$pages_to_show         = ($max_page > 20 ) ? 3 : 5;
			$larger_page_to_show   = 2;
			$larger_page_multiple  = 10;
			$pages_to_show_minus_1 = $pages_to_show - 1;
			$half_page_start       = floor($pages_to_show_minus_1/2);
			$half_page_end         = ceil($pages_to_show_minus_1/2);
			$start_page            = $paged - $half_page_start;

			if( $start_page <= 0 ){
				$start_page = 1;
			}

			$end_page = $paged + $half_page_end;
			if( ($end_page - $start_page) != $pages_to_show_minus_1){
				$end_page = $start_page + $pages_to_show_minus_1;
			}

			if( $end_page > $max_page ){
				$start_page = $max_page - $pages_to_show_minus_1;
				$end_page   = $max_page;
			}

			if( $start_page <= 0 ){
				$start_page = 1;
			}

			$larger_per_page         = $larger_page_to_show*$larger_page_multiple;
			$larger_start_page_start = ( self::n_round( $start_page, 10 ) + $larger_page_multiple ) - $larger_per_page;
			$larger_start_page_end   = self::n_round( $start_page, 10 ) + $larger_page_multiple;
			$larger_end_page_start   = self::n_round( $end_page, 10 ) + $larger_page_multiple;
			$larger_end_page_end     = self::n_round( $end_page, 10 ) + ( $larger_per_page );

			if($larger_start_page_end - $larger_page_multiple == $start_page){
				$larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
				$larger_start_page_end   = $larger_start_page_end - $larger_page_multiple;
			}

			if($larger_start_page_start <= 0){
				$larger_start_page_start = $larger_page_multiple;
			}

			if($larger_start_page_end > $max_page){
				$larger_start_page_end = $max_page;
			}

			if($larger_end_page_end > $max_page){
				$larger_end_page_end = $max_page;
			}

			if( $max_page > 1 ){

				//$pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
				//$pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);

				echo ( $before );
				echo '<ul class="pages-numbers">'."\n";

				/*
				if(! empty($pages_text) ) {
					echo '<span class="pages">'.$pages_text.'</span>';
				}
				*/

				if ( $start_page >= 2 && $pages_to_show < $max_page ){
					$first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
					echo '<li class="first-page first-last-pages"><a class="pages-nav-item" href="'.esc_url(get_pagenum_link()).'" title="'.$first_page_text.'"><span class="fa" aria-hidden="true"></span>'.$first_page_text.'</a></li>';

					if( ! empty( $pagenavi_options['dotleft_text'] ) ) {
						echo '<li class="extend"><span class="pages-nav-item">'.$pagenavi_options['dotleft_text'].'</span></li>';
					}
				}

				if( $larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page ){
					for( $i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple ){
						$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
						echo '<li><a class="pages-nav-item" href="'.esc_url(get_pagenum_link($i)).'" title="'.$page_text.'">'.$page_text.'</a></li>';
					}
				}

				if( get_previous_posts_link( '', $max_page) ){
					echo '<li class="the-prev-page">'. get_previous_posts_link($pagenavi_options['prev_text'], $max_page) .'</li>';
				}

				for($i = $start_page; $i  <= $end_page; $i++){
					if($i == $paged){
						$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
						echo '<li class="current"><span class="pages-nav-item">'.$current_page_text.'</span></li>';
					}
					else {
						$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
						echo '<li><a class="pages-nav-item" href="'.esc_url(get_pagenum_link($i)).'" title="'.$page_text.'">'.$page_text.'</a></li>';
					}
				}


				if( get_next_posts_link( '', $max_page) ){
					echo '<li class="the-next-page">'. get_next_posts_link($pagenavi_options['next_text'], $max_page) .'</li>';
				}

				if( $larger_page_to_show > 0 && $larger_end_page_start < $max_page ){
					for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple){
						$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
						echo '<li><a class="pages-nav-item" href="'.esc_url(get_pagenum_link($i)).'" title="'.$page_text.'">'.$page_text.'</a></li>';
					}
				}

				if ($end_page < $max_page){
					if( ! empty( $pagenavi_options['dotright_text'] ) ) {
						echo '<li class="extend"><span class="pages-nav-item">'.$pagenavi_options['dotright_text'].'</span></li>';
					}
					$last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
					echo '<li class="last-page first-last-pages"><a class="pages-nav-item" href="'.esc_url(get_pagenum_link($max_page)).'" title="'.$last_page_text.'">'.$last_page_text.'<span class="fa" aria-hidden="true"></span></a></li>';
				}

				echo '</ul>'.$after."\n";
			}
		}


		/*
		 * Round To The Nearest Value
		 */
		private static function n_round( $num, $tonearest ){
			return floor( $num/$tonearest ) * $tonearest;
		}

	}
}
