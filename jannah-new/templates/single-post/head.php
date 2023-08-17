<?php
/**
 * Post Head Area
 *
 * This template can be overridden by copying it to your-child-theme/templates/single-post/head.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


/**
 * TieLabs/before_post_head hook.
 *
 */
do_action( 'TieLabs/before_post_head' ); ?>

<header class="entry-header-outer">

	<?php do_action( 'TieLabs/before_entry_head' ); ?>

	<div class="entry-header">

		<?php

			// Categories
			if( ( tie_get_option( 'post_cats' ) && ! tie_get_postdata( 'tie_hide_categories' ) ) || tie_get_postdata( 'tie_hide_categories' ) == 'no' ){
				tie_the_category( '<span class="post-cat-wrap">', '</span>', false );
			}

			// Trending
			tie_the_trending_icon( '', '<div class="post-is-trending">', ' '. esc_html__( 'Trending', TIELABS_TEXTDOMAIN ) .'</div>');

		?>

		<h1 class="post-title entry-title"><?php the_title(); ?></h1>

		<?php

		if( tie_get_postdata( 'tie_post_sub_title' ) ) { ?>

			<h2 class="entry-sub-title"><?php echo tie_get_postdata( 'tie_post_sub_title' ) ?></h2>
			<?php
		}


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

		?>
	</div><!-- .entry-header /-->

	<?php
		$post_layout = tie_get_object_option( 'post_layout', 'cat_post_layout', 'tie_post_layout' );

		if( ! empty( $post_layout ) && ( $post_layout == 4 || $post_layout == 5 || $post_layout == 8 ) ){ ?>

			<a id="go-to-content" href="#go-to-content"><span class="tie-icon-angle-down"></span></a>
			<?php
		}
	?>

	<?php do_action( 'TieLabs/after_entry_head' ); ?>

</header><!-- .entry-header-outer /-->

<?php
	/**
	 * TieLabs/after_post_head hook.
	 *
	 */
	do_action( 'TieLabs/after_post_head' );

