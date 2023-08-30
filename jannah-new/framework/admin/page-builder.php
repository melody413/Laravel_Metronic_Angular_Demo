<?php
/**
 * TieLabs Page Builder
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



/*-----------------------------------------------------------------------------------*/
# Build The builder Options
/*-----------------------------------------------------------------------------------*/
function tie_page_builder_option( $block_id, $section_id, $data, $option ){
	$id = $option['id'];

	$option['prefix'] = 'block-'. $section_id .'-'. $block_id;

	tie_build_option( $option, 'tie_home_cats['.$section_id.'][blocks]['.$block_id.']['.$id.']', $data );
}



/*-----------------------------------------------------------------------------------*/
# Build The builder Options
/*-----------------------------------------------------------------------------------*/
add_filter( 'display_post_states', 'tie_page_builder_display_post_states', 10, 2 );
function tie_page_builder_display_post_states( $post_states, $post ){

	if ( tie_get_postdata( 'tie_builder_active', false, $post->ID ) ) {
		$post_states['tie_builder'] = esc_html__( 'TieLabs Builder', TIELABS_TEXTDOMAIN );
	}

	return $post_states;
}



/*-----------------------------------------------------------------------------------*/
# Build The Section Options
/*-----------------------------------------------------------------------------------*/
function tie_page_builder_section_option( $section_id, $data, $option ){
	$id = $option['id'];
	$option['prefix'] = 'section-'. $section_id;

	tie_build_option( $option, 'tie_home_cats['.$section_id.'][settings]['.$id.']', $data );
}



/*-----------------------------------------------------------------------------------*/
# Clean options before store it in DB
/*-----------------------------------------------------------------------------------*/
add_action( 'save_post', 'tie_save_page_builder' );
function tie_save_page_builder( $post_id ){

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}

	if ( isset( $_POST['tie_hidden_flag'] ) ){

		# Save the builder settings ---------
		if ( ! empty( $_POST['tie_builder_active'] ) && $_POST['tie_builder_active'] == 'yes' ){
			update_post_meta( $post_id, 'tie_builder_active', 'yes' );
		}
		else{
			delete_post_meta( $post_id, 'tie_builder_active' );
		}

		if( ! empty( $_POST['tie_home_cats'] ) ){
			$builder_data = apply_filters( 'TieLabs/save_block', $_POST['tie_home_cats'] );
			$builder_data = TIELABS_ADMIN_HELPER::clean_settings( $builder_data );
			$builder_data = TIELABS_ADMIN_HELPER::array_filter( $builder_data );

			update_post_meta( $post_id, 'tie_page_builder', $builder_data );

			do_action( 'TieLabs/builder/after_save', $post_id, $builder_data );
		}
		else{
			delete_post_meta( $post_id, 'tie_page_builder' );

			do_action( 'TieLabs/builder/after_delete', $post_id );
		}

	}
}




/*-----------------------------------------------------------------------------------*/
# Page Builder Blocks
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_tie_get_builder_section', 'tie_get_builder_section' );
function tie_get_builder_section( $section_number = false, $section = array() ){

	$section_settings = ! empty( $section['settings'] ) ? $section['settings'] : array();
	$is_ajax = false;

	if( empty( $section_number ) && ! empty( $_REQUEST['section_id'] ) ){
		$section_number = $_REQUEST['section_id'];
		$is_ajax = true;
		$post_id = $_REQUEST['post_id'];
		$section_settings = array(
			'section_id' => 'tiepost-' . $post_id . '-' . 'tiexyz20',
		);
	}
	else{
		$post_id = get_the_id();
	}

	$section_settings = wp_parse_args( $section_settings, array(
		'section_title'      => '',
		'title'              => '',
		'url'                => '',
		'title_style'        => '',
		'title_color'        => '',
		'title_icon'         => '',
		'sidebar_position'   => 'full',
		'stretch_section'    => '',
		'section_width'      => '',
		'parallax'           => '',
		'parallax_effect'    => '',
		'background_img'     => '',
		'background_video'   => '',
		'background_color'   => '',
		'background_color_inverted' => '',
		'dark_skin'          => '',
		'custom_class'       => '',
		'sticky_sidebar'     => '',
		'margin_top'         => '',
		'margin_bottom'      => '',
		'padding_top'        => '',
		'padding_bottom'     => '',
		'predefined_sidebar' => '',
		'sidebar_id'         => '',
		'section_id'         => 'tiepost-' . $post_id . '-' . 'section-'.rand(200, 3500),
	));

	?>

	<li id="tie-section-<?php echo esc_attr( $section_number ) ?>" class="tie-builder-container parent-item sidebar-<?php echo esc_attr($section_settings['sidebar_position']) ?>">

		<div class="tie-builder-section-title">
			<h4><?php esc_html_e( 'Section', TIELABS_TEXTDOMAIN ) ?></h4>

			<ul class='tie-block-options'>
				<li><a class="toggle-section dashicons" href="#"></a></li>
				<li><a class="edit-block-icon dashicons-edit dashicons" href="#"></a></li>
				<li><a class="del-item del-section dashicons dashicons-trash" href="#"></a></li>
			</ul>
		</div>

		<div class="tie-builder-content-area tie-popup-block tie-popup-window">

			<div class="tie-builder-item-top-container">
				<h2><?php esc_html_e( 'Edit Section', TIELABS_TEXTDOMAIN ) ?></h2>

				<a class="tie-primary-button button button-primary button-hero tie-edit-block-done" href="#"><?php esc_html_e( 'Done', TIELABS_TEXTDOMAIN ) ?></a>

				<div class="tie-section-title tie-section-tabs blocks-settings-tabs">
					<a href="#" data-target="basic-block-settings" class="active"><?php esc_html_e( 'General', TIELABS_TEXTDOMAIN ) ?></a>
					<a href="#" data-target="background-block-settings"><?php esc_html_e( 'Background', TIELABS_TEXTDOMAIN ) ?></a>
					<a href="#" data-target="design-block-settings"><?php esc_html_e( 'Styling',  TIELABS_TEXTDOMAIN ) ?></a>
				</div>
			</div>

			<div class="tie-block-options-group">

				<?php
				echo '<div class="basic-block-settings block-settings">';

					tie_build_theme_option(
						array(
							'title' => esc_html__( 'Section Title', TIELABS_TEXTDOMAIN ),
							'type'  => 'header',
						));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['section_title'],
						array(
							'name'   => esc_html__( 'Section Title', TIELABS_TEXTDOMAIN ),
							'id'     => 'section_title',
							'type'   => 'checkbox',
							'toggle' => "#section-$section_number-title-item, #section-$section_number-url-item, #section-$section_number-title_style-item, #section-$section_number-title_color-item, #section-$section_number-title_icon-item",
						));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['title'],
						array(
							'name' => esc_html__( 'Title', TIELABS_TEXTDOMAIN ),
							'id'   => 'title',
							'type' => 'text',
						));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['url'],
						array(
							'name'        => esc_html__( 'URL', TIELABS_TEXTDOMAIN ) .' '. esc_html__( '(optional)', TIELABS_TEXTDOMAIN ),
							'id'          => 'url',
							'placeholder' => 'https://',
							'type'        => 'text',
						));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['title_style'],
						array(
							'name'    => esc_html__( 'Title Style', TIELABS_TEXTDOMAIN ),
							'id'      => 'title_style',
							'type'    => 'radio',
							'options' => array(
								''         => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
								'centered' => esc_html__( 'Centered', TIELABS_TEXTDOMAIN ),
								'big'      => esc_html__( 'Big', TIELABS_TEXTDOMAIN ),
							)));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['title_color'],
						array(
							'name' => esc_html__( 'Title Color', TIELABS_TEXTDOMAIN ),
							'id'   => 'title_color',
							'type' => 'color',
						));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['title_icon'],
						array(
							'name'   => esc_html__( 'Icon', TIELABS_TEXTDOMAIN ),
							'id'     => 'title_icon',
							'type'   => 'icon',
						));

					tie_build_theme_option(
						array(
							'title' => esc_html__( 'Section Layout', TIELABS_TEXTDOMAIN ),
							'type'  => 'header',
						));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['stretch_section'],
						array(
							'name' => esc_html__( 'Stretch Section', TIELABS_TEXTDOMAIN ),
							'id'   => 'stretch_section',
							'type' => 'checkbox',
							'hint' => esc_html__( 'Stretch the section to the full width of the page, supported if the site layout is Full-Width.', TIELABS_TEXTDOMAIN ),
						));

					tie_build_theme_option(
						array(
							'title' => esc_html__( 'Sidebar Settings', TIELABS_TEXTDOMAIN ),
							'type'  => 'header',
						));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['sidebar_position'],
						array(
							'name'    => esc_html__( 'Sidebar Position', TIELABS_TEXTDOMAIN ),
							'id'      => 'sidebar_position',
							'prefix'  => 'section-' . $section_number,
							'type'    => 'visual',
							'class'   => 'tie-section-sidebar',
							'toggle' => array(
								'full'  => '',
								'right' => "#section-$section_number-sticky_sidebar-item",
								'left'  => "#section-$section_number-sticky_sidebar-item",
							),
							'options' => array(
								'full'  => array( esc_html__( 'Without Sidebar', TIELABS_TEXTDOMAIN ) => 'sidebars/sidebar-full-width.png' ),
								'right' => array( esc_html__( 'Sidebar Right', TIELABS_TEXTDOMAIN ) => 'sidebars/sidebar-right.png' ),
								'left'  => array( esc_html__( 'Sidebar Left', TIELABS_TEXTDOMAIN ) => 'sidebars/sidebar-left.png' ),
						)));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['sticky_sidebar'],
						array(
							'name'  => esc_html__( 'Sticky Sidebar', TIELABS_TEXTDOMAIN ),
							'id'    => 'sticky_sidebar',
							'type'  => 'checkbox',
							'class' => "section-$section_number-sidebar_position",
					));

				echo '</div>';

				echo '<div class="background-block-settings block-settings">';

					tie_build_theme_option(
						array(
							'title' => esc_html__( 'Background Settings', TIELABS_TEXTDOMAIN ),
							'type'  => 'header',
						));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['section_width'],
						array(
							'name'   => esc_html__( 'Full Width Background Section', TIELABS_TEXTDOMAIN ),
							'id'     => 'section_width',
							'type'   => 'checkbox',
						));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['background_color'],
						array(
							'name' => esc_html__( 'Background Color', TIELABS_TEXTDOMAIN ),
							'id'   => 'background_color',
							'type' => 'color',
						));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['background_color_inverted'],
						array(
							'name' => esc_html__( 'Inverted Background Color', TIELABS_TEXTDOMAIN ),
							'id'   => 'background_color_inverted',
							'type' => 'color',
						));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['background_img'],
						array(
							'name' => esc_html__( 'Background Image', TIELABS_TEXTDOMAIN ),
							'id'   => 'background_img',
							'type' => 'upload',
					));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['background_video'],
						array(
							'name' => esc_html__( 'Background Video', TIELABS_TEXTDOMAIN ),
							'id'   => 'background_video',
							'type' => 'text',
					));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['parallax'],
						array(
							'name'   => esc_html__( 'Parallax', TIELABS_TEXTDOMAIN ),
							'id'     => 'parallax',
							'type'   => 'checkbox',
							'toggle' => '#section-'. $section_number .'-parallax_effect-item',
					));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['parallax_effect'],
						array(
							'name' => esc_html__( 'Parallax Effect', TIELABS_TEXTDOMAIN ),
							'id'   => 'parallax_effect',
							'type' => 'select',
							'options' => array(
								'scroll'         => esc_html__( 'Scroll', TIELABS_TEXTDOMAIN ),
								'scale'          => esc_html__( 'Scale', TIELABS_TEXTDOMAIN ),
								'opacity'        => esc_html__( 'Opacity', TIELABS_TEXTDOMAIN ),
								'scroll-opacity' => esc_html__( 'Scroll + Opacity', TIELABS_TEXTDOMAIN ),
								'scale-opacity'  => esc_html__( 'Scale + Opacity', TIELABS_TEXTDOMAIN ),
					)));

				echo '</div>';

				echo '<div class="design-block-settings block-settings">';

					tie_build_theme_option(
						array(
							'title' => esc_html__( 'Styling Settings', TIELABS_TEXTDOMAIN ),
							'type'  => 'header',
						));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['dark_skin'],
						array(
							'name'   => esc_html__( 'Dark Skin', TIELABS_TEXTDOMAIN ),
							'id'     => 'dark_skin',
							'type'   => 'checkbox',
					));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['custom_class'],
						array(
							'name'   => esc_html__( 'Custom Classes', TIELABS_TEXTDOMAIN ),
							'id'     => 'custom_class',
							'type'   => 'text',
					));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['margin_top'],
						array(
							'name'   => esc_html__( 'Margin Top', TIELABS_TEXTDOMAIN ),
							'id'     => 'margin_top',
							'type'   => 'number',
					));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['margin_bottom'],
						array(
							'name'   => esc_html__( 'Margin Bottom', TIELABS_TEXTDOMAIN ),
							'id'     => 'margin_bottom',
							'type'   => 'number',
					));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['padding_top'],
						array(
							'name'   => esc_html__( 'Padding Top', TIELABS_TEXTDOMAIN ),
							'id'     => 'padding_top',
							'type'   => 'number',
					));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['padding_bottom'],
						array(
							'name'   => esc_html__( 'Padding Bottom', TIELABS_TEXTDOMAIN ),
							'id'     => 'padding_bottom',
							'type'   => 'number',
					));

					tie_page_builder_section_option(
						$number = $section_number,
						$value  = $section_settings['section_id'],
						array(
							'id'      => 'section_id',
							'type'    => 'hidden'
						));

				echo '</div>';
				?>

			</div><!-- .tie-block-options-group -->
		</div><!-- tie-builder-content-area -->


		<div class="tie-builder-section-inner">

			<div class="tie-section-sidebar">
				<h4><?php esc_html_e( 'Sidebar', TIELABS_TEXTDOMAIN ) ?></h4>
				<a href="#" data-widgets="<?php echo esc_attr( $section_settings['section_id'] ) ?>" class="tie-manage-widgets">
					<span class="dashicons dashicons-admin-generic"></span><?php esc_html_e( 'Manage Widgets', TIELABS_TEXTDOMAIN ) ?>
				</a>
			</div>

			<div class="tie-builder-blocks-wrapper-outer">
				<ul class="tie-builder-blocks-wrapper" id="cat_sortable_<?php echo esc_attr( $section_number ) ?>" data-section-id="<?php echo esc_attr( $section_number ) ?>">
					<?php
					$block_id = ! empty( $GLOBALS['tie_block_id'] ) ? $GLOBALS['tie_block_id'] : 1;

					if(! empty( $section['blocks'] ) && is_array( $section['blocks'] ) ) {
						foreach( $section['blocks'] as $block ){
							tie_get_builder_blocks( $block_id, $section_number, $block );
							$block_id++;
						}
					}

					$GLOBALS['tie_block_id'] = $block_id;
					?>
				</ul><!-- #cat_sortable  /-->

				<div class="clear"></div>

				<div class="tie-loading-container">
					<div class="tie-saving-settings">
						<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
							<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
							<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
							<path class="checkmark__error_1" d="M38 38 L16 16 Z"/>
							<path class="checkmark__error_2" d="M16 38 38 16 Z" />
						</svg>
					</div>
				</div>

				<div class="tie-add-new-block-wrapper">
					<a href="#" data-section="<?php echo esc_attr( $section_number ) ?>" class="tie-add-new-block tie-primary-button button button-primary button-large"><span><?php esc_html_e( 'Add Block', TIELABS_TEXTDOMAIN ) ?></span></a>
				</div>

			</div><!-- .tie-builder-blocks-wrapper-outer -->

			<div class="clear"></div>

		</div><!-- .tie-builder-section-inner -->

		<?php
		if( $is_ajax ){
			# Visual Block Style Options ?>
			<script>
				jQuery(document).ready(function(){
					$AddedSection	= jQuery('#tie-section-<?php echo esc_js( $section_number ) ?>');
					$AddedSection.find('input:checked').closest('li').addClass( 'selected' );
					$AddedSection.find('.checkbox-select').click( function(event){
						//event.preventDefault();
						$AddedSection.find('li').removeClass('selected');
						//$AddedSection.find(':radio').removeAttr('checked');
						jQuery(this).parent().addClass('selected');
						//jQuery(this).parent().find(':radio').attr('checked','checked');
					});
				});
			</script>
			<?php

			// This elements will be filtered from the Ajax request and add it to the widgets UI
			tie_get_section_sidebar_options( $section_settings['section_id'], $section_number, $section_settings );
		}
		?>
	</li><!-- .tie-builder-container /-->
	<?php
}




/*-----------------------------------------------------------------------------------*/
# Page Builder Blocks
/*-----------------------------------------------------------------------------------*/
function tie_get_section_sidebar_options( $section_id, $section_number, $section_settings ){

	echo '<div id="'. $section_id .'-sidebar-options" class="sections-sidebars-options">';

		tie_page_builder_section_option(
			$number = $section_number,
			$value  = $section_settings['predefined_sidebar'],
			array(
				'name'   => esc_html__( 'Predefined Sidebar', TIELABS_TEXTDOMAIN ),
				'id'     => 'predefined_sidebar',
				'prefix' => 'section-' . $section_number,
				'toggle' => '#section-' . $section_number . '-sidebar_id-item',
				'type'   => 'checkbox',
			));

		tie_page_builder_section_option(
			$number = $section_number,
			$value  = $section_settings['sidebar_id'],
			array(
				'name'    => esc_html__( 'Choose Sidebar', TIELABS_TEXTDOMAIN ),
				'id'      => 'sidebar_id',
				'prefix'  => 'section-' . $section_number,
				'type'    => 'select',
				'options' => TIELABS_ADMIN_HELPER::get_sidebars(),
			));

	echo '</div>';
}




/*-----------------------------------------------------------------------------------*/
# Page Builder Blocks
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_tie_get_builder_blocks', 'tie_get_builder_blocks' );
function tie_get_builder_blocks( $block_id = false, $section_id = false , $block = array() ){

	$block_class_name = '';

	$categories = TIELABS_ADMIN_HELPER::get_categories();

	$post_source_list = array(
		'id'   => esc_html__( 'Categories', TIELABS_TEXTDOMAIN ), // Wonder why ID? this comes from Sahifa v 1.0 :)
		'tags' => esc_html__( 'Tags',       TIELABS_TEXTDOMAIN ),
	);

	// Custom Post Type support
	/*
	$custom_taxonomies = TIELABS_ADMIN_HELPER::get_taxonomies();

	$post_source_list = array_merge( array(
			'id'   => esc_html__( 'Categories', TIELABS_TEXTDOMAIN ), // Wonder why ID? this comes from Sahifa v 1.0 :)
			'tags' => esc_html__( 'Tags',       TIELABS_TEXTDOMAIN ),
		),
		$custom_taxonomies
	);
	*/

	if( empty( $section_id ) && ! empty( $_REQUEST['section_id'] ) ){
		$section_id = $_REQUEST['section_id'];
	}

	if( empty( $block_id ) && ! empty( $_REQUEST['block_id'] ) ){
		$block_id = $_REQUEST['block_id'];
	}

	if( empty( $block ) ){
		$block = array(
			'style'           => 'default',
			'title'           => esc_html__( 'Block Title', TIELABS_TEXTDOMAIN ),
			'number'          => 5,
			'excerpt'         => 'true',
			'read_more'       => 'true',
			'post_meta'       => 'true',
			'breaking_effect' => 'reveal',
		);
	}

	$block = wp_parse_args( $block, array(
		'style'  => 'default',
		'url'	   => '',
		'videos' => '',
	));


	$builder_blocks_styles = tie_builder_blocks_styles();
	$block_style           = $block['style'];

	if( ! empty( $builder_blocks_styles[ $block_style ] ) && is_array( $builder_blocks_styles[ $block_style ] ) ){
		foreach ( $builder_blocks_styles[ $block_style ] as $style_block ){
			foreach ( $style_block as $style_class_name => $style_image ){
				$block_class_name .= $style_class_name.'-container';
				$block_class_name .= ' '; // Avoid class names error
			}
		}
	}

	# Block head BG Color
	$block_head_bg = $block_head_class = '';

	if( ! empty( $block['color'] ) ){
		$block_head_class = 'block-head-'.TIELABS_STYLES::light_or_dark( $block['color'], false, 'dark', 'light' );
		$block_head_bg    = 'style="background-color:'.$block['color'].'"';
	}
	?>

	<li id="listItem_<?php echo esc_attr( $section_id .'-'. $block_id ) ?>" class="block-item parent-item <?php echo esc_attr( $block_class_name ) ?>">

		<div class="tie-block-head <?php echo esc_attr( $block_head_class ) ?>" <?php echo ( $block_head_bg ) ?>>

			<?php
				$block_img = esc_attr( TIELABS_TEMPLATE_URL .'/framework/admin/assets/images/blocks/block-'. $block['style'] .'.png' );
				echo "<img class=\"block-small-img\" src=\" $block_img\">";
			?>

			<span class="block-preview-title"><?php if( ! empty( $block['title'] ) ) echo force_balance_tags( $block['title'] ); ?></span>
			<span class="block-e3lan-title"><?php esc_html_e( 'Ad', TIELABS_TEXTDOMAIN ) ?></span>
			<span class="block-tabs-title"><?php esc_html_e( 'Tabs block', TIELABS_TEXTDOMAIN ) ?></span>

			<ul class='tie-block-options'>
				<li><a class="edit-block-icon dashicons-edit dashicons" href="#"></a></li>
				<li><a class="del-item dashicons dashicons-trash" href="#"></a></li>
			</ul>

		</div>

		<div class="tie-builder-content-area tie-popup-block tie-popup-window">

			<div class="tie-builder-item-top-container">
				<h2><?php esc_html_e( 'Edit Block', TIELABS_TEXTDOMAIN ) ?></h2>

				<a class="tie-primary-button button button-primary button-hero tie-edit-block-done" href="#"><?php esc_html_e( 'Done', TIELABS_TEXTDOMAIN ) ?></a>

			</div>

			<div class="tie-block-options-group">

			<?php

			$block = wp_parse_args( $block, array(
				'style'               => 'default',
				'cat'                 => '',
				'title'               => '',
				'icon'                => '',
				'order'               => 'latest',
				'woo_cats'            => '',
				'source'              => '',
				'id'                  => '',
				'tags'                => '',
				'exclude_posts'       => '',
				'custom_slider'       => '',
				'number'              => 5 ,
				'offset'              => '',
				'pagi'                => '',
				'color'               => '',
				'bgcolor'             => '',
				'sec_color'           => '',
				'dark'                => '',
				'title_length'        => '',
				'excerpt'             => '',
				'excerpt_length'      => '',
				'read_more'           => '',
				'read_more_text'      => '',
				'thumb_first'         => '',
				'thumb_small'         => '',
				'thumb_all'           => '',
				'more'                => '',
				'post_meta'           => '',
				'media_overlay'       => '',
				'filters'             => '',
				'custom_content'      => '',
				'content_only'        => '',
				'ad_img'              => '',
				'ad_url'              => '',
				'ad_alt'              => '',
				'ad_target'           => '',
				'ad_nofollow'         => '',
				'ad_code'             => '',
				'colored_mask'        => '',
				'gradiant_overlay'    => '',
				'animate_auto'        => '',
				'slider_speed'        => '',
				'posts_category'      => '',
				'posts_review'        => '',
				'breaking_effect'     => '',
				'breaking_arrows'     => '',
				'lsslider'            => '',
				'revslider'           => '',
				'boxid'               => '',
				'background_position' => '',
			));

			tie_page_builder_option(
				$block_id = $block_id,
				$section  = $section_id,
				$value    = $block['style'],
				array(
					'id'      => 'style',
					'type'    => 'visual',
					'class'   => 'block-style',
					'options' => $builder_blocks_styles,
				));

			?>

			<div class="tie-section-title tie-section-tabs blocks-settings-tabs">
				<a href="#" data-target="basic-block-settings" class="active"><?php esc_html_e( 'General', TIELABS_TEXTDOMAIN ) ?></a>
				<a href="#" data-target="styling-block-settings" class="block-settings-styling"><?php esc_html_e( 'Styling Settings',  TIELABS_TEXTDOMAIN ) ?></a>
				<a href="#" data-target="advanced-block-settings" class="block-settings-advanced"><?php esc_html_e( 'Advanced Settings',  TIELABS_TEXTDOMAIN ) ?></a>
			</div>


			<div class="basic-block-settings block-settings">

			<?php

			# Tabs Block
			$tie_home_tabs = empty( $block['cat'] ) ? array() : $block['cat'] ;

			$tie_home_tabs_new = array();

			foreach ( $tie_home_tabs as $key1 => $option1 ){
				if ( array_key_exists( $option1, $categories ) ){
					$tie_home_tabs_new[$option1] = $categories[$option1];
				}
			}

			foreach ( $categories as $key2 => $option2 ){
				if ( !in_array( $key2, $tie_home_tabs ) ){
					$tie_home_tabs_new[$key2] = $option2;
				}
			}

			?>

			<div class="option-item block-cat-tabs-item-options">
				<span class="tie-label"><?php esc_html_e( 'Categories', TIELABS_TEXTDOMAIN ) ?></span>
				<div class="clear"></div>

				<ul class="tabs_cats">
				<?php
					foreach ( $tie_home_tabs_new as $key => $option){ ?>
						<li>
							<input name="tie_home_cats[<?php echo esc_attr( $section_id ) ?>][blocks][<?php echo esc_attr( $block_id ) ?>][cat][]" type="checkbox"<?php if ( in_array( $key, $tie_home_tabs ) ) echo ' checked'; ?> value="<?php echo esc_attr( $key ) ?>">
							<span><?php echo esc_attr( $option ) ?></span>
						</li>
					<?php
					}
				?>
				</ul>
				<div class="clear"></div>
			</div><!-- .block-cat-tabs-item-options -->

			<?php

				# Block Title
				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['title'],
					array(
						'name'   => esc_html__( 'Custom Title', TIELABS_TEXTDOMAIN ) .' '. esc_html__( '(optional)', TIELABS_TEXTDOMAIN ),
						'id'     => 'title',
						'class'  => 'block-title-item',
						'type'   => 'text',
					));

				# Block Icon
				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['icon'],
					array(
						'name'   => esc_html__( 'Icon', TIELABS_TEXTDOMAIN ) .' '. esc_html__( '(optional)', TIELABS_TEXTDOMAIN ),
						'id'     => 'icon',
						'class'  => 'block-title-icon',
						'type'   => 'icon',
					));

				# Block URL
				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['url'],
					array(
						'name'        => esc_html__( 'Title URL', TIELABS_TEXTDOMAIN ) .' '. esc_html__( '(optional)', TIELABS_TEXTDOMAIN ),
						'id'          => 'url',
						'class'       => 'block-url-item',
						'placeholder' => 'https://',
						'type'        => 'text',
					));

				if( TIELABS_WOOCOMMERCE_IS_ACTIVE ){

					tie_page_builder_option(
						$block_id =	$block_id,
						$section  = $section_id,
						$value    =	$block['woo_cats'],
						array(
							'name'    => esc_html__( 'Products Categories', TIELABS_TEXTDOMAIN ),
							'id'      => 'woo_cats',
							'type'    => 'select-multiple',
							'class'   => 'block-default-options block-products-item',
							'options' => TIELABS_WOOCOMMERCE::categories(),
						));
				}

				// Version 4 Compatability
				if( empty( $block['source'] ) ) {
					$block['source'] = ! empty( $block['tags'] ) ? 'tags' : 'id';
				}

				$block_id_prefix = 'block-'. $section_id .'-'. $block_id;
				$source_main_class = $block_id_prefix .'-source-options';

				$post_source_list_toggle = array();
				foreach ( $post_source_list as $slug => $name ) {
					$post_source_list_toggle[ $slug ] = '#'. $block_id_prefix .'-'. $slug .'-item';
				}

				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['source'],
					array(
						'name'    => esc_html__( 'Posts Source', TIELABS_TEXTDOMAIN ),
						'id'      => 'source',
						'type'    => 'select',
						'class'   => 'block-default-options block-source-item',
						'options' => $post_source_list,
						'toggle'  => $post_source_list_toggle,
					));

				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['id'],
					array(
						'name'    => esc_html__( 'Categories', TIELABS_TEXTDOMAIN ),
						'id'      => 'id',
						'type'    => 'select-multiple',
						'class'   => 'block-default-options '. $source_main_class .' block-categories-item',
						'options' => $categories,
					));

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['tags'],
					array(
						'name'  => esc_html__( 'Tags', TIELABS_TEXTDOMAIN ),
						'id'    => 'tags',
						'type'  => 'text',
						'class' => 'block-default-options '. $source_main_class .' block-tags-item',
					));

				// Custom Post Type support
				/*
				foreach( $custom_taxonomies as $slug => $name ){

					if( empty( $block[ $slug ] ) ) {
						$block[ $slug ] = array();
					}

					$custom_terms = TIELABS_ADMIN_HELPER::get_terms_by_taxonomy( $slug );

					echo '<div id="'. $block_id_prefix .'-'. $slug .'-item" class="block-default-options '. $source_main_class .' block-'. $slug.'-item-options ">';

					if( ! is_array( $custom_terms ) || empty( $custom_terms ) ){

						tie_page_builder_option(
							$block_id = $block_id,
							$section  = $section_id,
							$value    = false,
							array(
								'id'   => $slug .'-item-no-terms',
								'text' => sprintf( esc_html__( 'No terms found for the %s taxonomy.', TIELABS_TEXTDOMAIN ), '<strong>'. $name .'</strong>' ),
								'type' => 'message',
							));
					}
					else{
						tie_page_builder_option(
							$block_id = $block_id,
							$section  = $section_id,
							$value    = $block[ $slug ],
							array(
								'name'    => $name,
								'id'      => $slug,
								'type'    => 'select-multiple',
								'options' => $custom_terms,
							));
					}

					echo '</div>';
				}
				*/

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['exclude_posts'],
					array(
						'name'   => esc_html__( 'Exclude Posts', TIELABS_TEXTDOMAIN ),
						'id'     => 'exclude_posts',
						'hint'   => esc_html__( 'Enter a post ID, or IDs separated by comma.', TIELABS_TEXTDOMAIN ),
						'type'   => 'text',
						'class'  => 'block-default-options block-exclude_posts-item',
					));


				# Post Order
				$block_post_order = array(
					'latest'   => esc_html__( 'Recent Posts',         TIELABS_TEXTDOMAIN ),
					'rand'     => esc_html__( 'Random Posts',         TIELABS_TEXTDOMAIN ),
					'modified' => esc_html__( 'Last Modified Posts',  TIELABS_TEXTDOMAIN ),
					'popular'  => esc_html__( 'Most Commented posts', TIELABS_TEXTDOMAIN ),
					'title'    => esc_html__( 'Alphabetically',       TIELABS_TEXTDOMAIN ),
				);

				if( tie_get_option( 'tie_post_views' ) ){
					$block_post_order['views'] = esc_html__( 'Most Viewed posts', TIELABS_TEXTDOMAIN );
				}


				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['order'],
					array(
						'name'     => esc_html__( 'Sort Order', TIELABS_TEXTDOMAIN ),
						'id'       => 'order',
						'type'     => 'select',
						'class'    => 'block-default-options block-order-item',
						'options'  => apply_filters( 'TieLabs/Builder/Block/post_order_args', $block_post_order ),
					));


				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['number'],
					array(
						'name'   => esc_html__( 'Number of posts to show', TIELABS_TEXTDOMAIN ),
						'id'     => 'number',
						'type'   => 'number',
						'class'  => 'block-default-options block-number-item',
					));

				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['offset'],
					array(
						'name'   => esc_html__( 'Offset - number of posts to pass over', TIELABS_TEXTDOMAIN ),
						'id'     => 'offset',
						'type'   => 'number',
						'class'  => 'block-default-options block-offset-item',
					));

				tie_page_builder_option(
					$block_id	= $block_id,
					$section  = $section_id,
					$value    = $block['pagi'],
					array(
						'name'    => esc_html__( 'Pagination', TIELABS_TEXTDOMAIN ),
						'id'      => 'pagi',
						'type'    => 'select',
						'class'   => 'block-default-options block-pagination-item',
						'options' => array(
								''          => esc_html__( 'Disable', TIELABS_TEXTDOMAIN ),
								'numeric'   => esc_html__( 'Numeric', TIELABS_TEXTDOMAIN ),
								'show-more' => esc_html__( 'AJAX', TIELABS_TEXTDOMAIN ) .' - '. esc_html__( 'Show More', TIELABS_TEXTDOMAIN ),
								'load-more' => esc_html__( 'AJAX', TIELABS_TEXTDOMAIN ) .' - '. esc_html__( 'Load More', TIELABS_TEXTDOMAIN ),
								'next-prev-buttons' => esc_html__( 'AJAX', TIELABS_TEXTDOMAIN ) .' - '. esc_html__( 'Next/Previous Buttons', TIELABS_TEXTDOMAIN ),
								'next-prev' => esc_html__( 'AJAX', TIELABS_TEXTDOMAIN ) .' - '. esc_html__( 'Next/Previous Arrows Beside Title', TIELABS_TEXTDOMAIN ),
					)));

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['custom_slider'],
					array(
						'name'     => esc_html__( 'Custom Slider', TIELABS_TEXTDOMAIN ),
						'id'       => 'custom_slider',
						'type'     => 'select',
						'pre_text' => esc_html__( '- OR -', TIELABS_TEXTDOMAIN ),
						'class'    => 'block-slider-options block-custom-slider',
						'options'  => TIELABS_ADMIN_HELPER::get_sliders( true ),
					));

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['custom_content'],
					array(
						'id'     => 'custom_content',
						'type'   => 'editor',
						'class'  => 'block-custom-code-item',
						'editor' => array(
							'media_buttons' => true,
							'quicktags'     => true,
							'textarea_rows' => '15',
							'editor_height' => '500px'
						),
					));

				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['ad_img'],
					array(
						'name'   => esc_html__( 'Ad Image', TIELABS_TEXTDOMAIN ),
						'id'     => 'ad_img',
						'type'   => 'upload',
						'class'  => 'block-e3lan-group block-e3lan-image-item',
					));

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['ad_url'],
					array(
						'name'        => esc_html__( 'Ad URL', TIELABS_TEXTDOMAIN ),
						'id'          => 'ad_url',
						'type'        => 'text',
						'placeholder' => 'https://',
						'class'       => 'block-e3lan-group block-e3lan-url-item',
					));

				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['ad_alt'],
					array(
						'name'   => esc_html__( 'Alternative Text For The image', TIELABS_TEXTDOMAIN ),
						'id'     => 'ad_alt',
						'type'   => 'text',
						'class'  => 'block-e3lan-group block-e3lan-alt-item',
					));

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['ad_target'],
					array(
						'name'   => esc_html__( 'Open The Link In a new Tab', TIELABS_TEXTDOMAIN ),
						'id'     => 'ad_target',
						'type'   => 'checkbox',
						'class'  => 'block-e3lan-group block-e3lan-target-item',
					));

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['ad_nofollow'],
					array(
						'name'	 => esc_html__( 'Nofollow?', TIELABS_TEXTDOMAIN ),
						'id'     => 'ad_nofollow',
						'type'   => 'checkbox',
						'class'  => 'block-e3lan-group block-e3lan-nofollow-item',
					));

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['ad_code'],
					array(
						'name'  => esc_html__( 'Custom Ad Code', TIELABS_TEXTDOMAIN ),
						'id'    => 'ad_code',
						'hint'  => esc_html__( 'Supports: Text, HTML and Shortcodes.', TIELABS_TEXTDOMAIN ),
						'type'  => 'textarea',
						'class' => 'block-e3lan-group block-e3lan-code-item',
					));


				if( ! tie_get_option( 'api_youtube' ) ){

					tie_page_builder_option(
						$block_id = $block_id,
						$section  = $section_id,
						$value    = false,
						array(
							'id'     => 'videos_youtube_notice',
							'text'   => esc_html__( 'You need to set the YouTube API Key in the theme options page > Integrations.', TIELABS_TEXTDOMAIN ),
							'type'   => 'error',
							'class'  => 'block-video-list-group',
						));
				}

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['videos'],
					array(
						'name'   => esc_html__( 'Videos List', TIELABS_TEXTDOMAIN ),
						'id'     => 'videos',
						'hint'   => esc_html__( 'Enter each video url in a seprated line.', TIELABS_TEXTDOMAIN ) . ' <strong>' . esc_html__( 'Supports: YouTube and Vimeo videos only.', TIELABS_TEXTDOMAIN ).'</strong>',
						'type'   => 'textarea',
						'class'  => 'block-video-list-group',
					));




				# Slider Revolution
				if( TIELABS_REVSLIDER_IS_ACTIVE ){
					echo '<div class="block-revslider-settings">';

						$rev_slider = new RevSlider();
						$rev_slider = $rev_slider->getArrSlidersShort();

						if( ! empty( $rev_slider ) && is_array( $rev_slider ) ) {

							$arrSliders = array( '' => esc_html__( 'Choose Slider', TIELABS_TEXTDOMAIN ) );

							foreach( $rev_slider as $id => $item ){
								$name = empty( $item ) ? esc_html__( 'Unnamed', TIELABS_TEXTDOMAIN ) : $item;
								$arrSliders[ $id ] = $name . ' | #' .$id;
							}

							tie_page_builder_option(
								$block_id = $block_id,
								$section  = $section_id,
								$value    = $block['revslider'],
								array(
									'name'    => esc_html__( 'Slider Revolution', TIELABS_TEXTDOMAIN ),
									'id'      => 'revslider',
									'type'    => 'select',
									'options' => $arrSliders,
								));
						}
						else{
							tie_build_theme_option(
								array(
									'text' => esc_html__( 'No sliders found, add a slider first!', TIELABS_TEXTDOMAIN ),
									'type' => 'error',
								));
						}

					echo '</div><!-- .block-revslider-settings -->';
				}


				# LayerSlider
				if( TIELABS_LS_Sliders_IS_ACTIVE ){
					echo '<div class="block-lsslider-settings">';

						$ls_sliders = LS_Sliders::find(array('limit' => 100));

						if( ! empty( $ls_sliders ) && is_array( $ls_sliders ) ){

							$arrSliders = array( '' => esc_html__( 'Choose Slider', TIELABS_TEXTDOMAIN ) );

							foreach( $ls_sliders as $item ){
								$name = empty( $item['name'] ) ? esc_html__( 'Unnamed', TIELABS_TEXTDOMAIN ) : $item['name'];
								$arrSliders[ $item['id'] ] = $name . ' | #' .$item['id'];
							}

							tie_page_builder_option(
								$block_id = $block_id,
								$section  = $section_id,
								$value    = $block['lsslider'],
								array(
									'name'    => esc_html__( 'LayerSlider', TIELABS_TEXTDOMAIN ),
									'id'      => 'lsslider',
									'type'    => 'select',
									'options' => $arrSliders,
								));

						}
						else{
							tie_build_theme_option(
								array(
									'text' => esc_html__( 'No sliders found, add a slider first!', TIELABS_TEXTDOMAIN ),
									'type' => 'error',
								));
						}

					echo '</div><!-- .block-lsslider-settings -->';
				}


			echo '</div><!-- basic-block-settings -->';


			echo '<div class="styling-block-settings block-settings">';

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['content_only'],
					array(
						'name'   => esc_html__( 'Show the content only?', TIELABS_TEXTDOMAIN ),
						'id'     => 'content_only',
						'type'   => 'checkbox',
						'hint'   => esc_html__( 'Without background, padding nor borders.', TIELABS_TEXTDOMAIN ),
						'class'  => 'block-content-only-item',
					));


				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['dark'],
					array(
						'name'   => esc_html__( 'Dark Skin', TIELABS_TEXTDOMAIN ),
						'id'     => 'dark',
						'type'   => 'checkbox',
						'class'  => 'block-dark-item',
					));

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['color'],
					array(
						'name'        => esc_html__( 'Primary Color', TIELABS_TEXTDOMAIN ),
						'id'          => 'color',
						'type'        => 'color',
						'color_class' => 'tieBlocksColor',
						'class'       => 'block-color-item',
					));

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['bgcolor'],
					array(
						'name'        => esc_html__( 'Background Color', TIELABS_TEXTDOMAIN ),
						'id'          => 'bgcolor',
						'type'        => 'color',
						'color_class' => 'tieBlocksColor',
						'class'       => 'block-bgcolor-item',
					));

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['sec_color'],
					array(
						'name'        => esc_html__( 'Secondary Color', TIELABS_TEXTDOMAIN ),
						'id'          => 'sec_color',
						'type'        => 'color',
						'color_class' => 'tieBlocksColor',
						'class'       => 'block-sec-color-item',
					));

				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['colored_mask'],
					array(
						'name'  => esc_html__( 'Colored Mask', TIELABS_TEXTDOMAIN ),
						'id'    => 'colored_mask',
						'class' => 'block-slider-options block-slider-colored-mask',
						'type'  => 'checkbox',
					));

				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['gradiant_overlay'],
					array(
						'name'  => esc_html__( 'Disable Gradient Overlay', TIELABS_TEXTDOMAIN ),
						'id'    => 'gradiant_overlay',
						'class' => 'block-slider-options block-slider-gradiant-overlay',
						'type'  => 'checkbox',
					));

			echo '</div><!-- styling-block-settings -->';


			echo '<div class="advanced-block-settings block-settings">';

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['filters'],
					array(
						'name'   => esc_html__( 'Ajax Filters', TIELABS_TEXTDOMAIN ),
						'id'     => 'filters',
						'type'   => 'checkbox',
						'hint'   => esc_html__( 'Will not appear if the numeric pagination is active.', TIELABS_TEXTDOMAIN ),
						'class'  => 'block-default-options block-filters-item',
					));

				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['more'],
					array(
						'name'   => esc_html__( 'More Button', TIELABS_TEXTDOMAIN ),
						'id'     => 'more',
						'type'   => 'checkbox',
						'hint'   => esc_html__( 'Will not appear if the Block URL is empty.', TIELABS_TEXTDOMAIN ),
						'class'  => 'block-default-options block-more-item',
					));

				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['title_length'],
					array(
						'name'   => esc_html__( 'Posts Title Length', TIELABS_TEXTDOMAIN ),
						'id'     => 'title_length',
						'type'   => 'number',
						'class'  => 'block-default-options block-title_length-item',
					));

				echo '<div class="excerpt-options">';

					tie_page_builder_option(
						$block_id = $block_id,
						$section  = $section_id,
						$value    = $block['excerpt'],
						array(
							'name'   => esc_html__( 'Posts Excerpt', TIELABS_TEXTDOMAIN ),
							'id'     => 'excerpt',
							'type'   => 'checkbox',
							'toggle' => '#block-'. $section_id .'-'. $block_id .'-excerpt_length-item',
							'class'  => 'block-default-options block-excerpt-item',
						));

					tie_page_builder_option(
						$block_id = $block_id,
						$section  = $section_id,
						$value    = $block['excerpt_length'],
						array(
							'name'   => esc_html__( 'Posts Excerpt Length', TIELABS_TEXTDOMAIN ),
							'id'     => 'excerpt_length',
							'type'   => 'number',
							'class'  => 'block-default-options block-excerpt_length-item',
						));
				echo '</div>';

				echo '<div class="read-more-options">';

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['read_more'],
					array(
						'name'   => esc_html__( 'Read More Button', TIELABS_TEXTDOMAIN ),
						'id'     => 'read_more',
						'type'   => 'checkbox',
						'toggle' => '#block-'. $section_id .'-'. $block_id .'-read_more_text-item',
						'class'  => 'block-default-options block-read_more-item',
					));

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['read_more_text'],
					array(
						'name'  => esc_html__( 'Custom Read More Button text', TIELABS_TEXTDOMAIN ),
						'id'    => 'read_more_text',
						'type'  => 'text',
						'class' => 'block-default-options block-read_more_text-item',
						'hint'  => esc_html__( 'Leave it empty to use the default text.', TIELABS_TEXTDOMAIN ),
					));

				echo '</div>';

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['thumb_first'],
					array(
						'name'   => esc_html__( 'Hide thumbnail for the First post', TIELABS_TEXTDOMAIN ),
						'id'     => 'thumb_first',
						'type'   => 'checkbox',
						'class'  => 'block-default-options block-thumb_first-item',
					));

				tie_page_builder_option(
					$block_id	= $block_id,
					$section  = $section_id,
					$value    = $block['thumb_small'],
					array(
						'name'   => esc_html__( 'Hide small thumbnails', TIELABS_TEXTDOMAIN ),
						'id'     => 'thumb_small',
						'type'   => 'checkbox',
						'class'  => 'block-default-options block-thumb_small-item',
					));

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['thumb_all'],
					array(
						'name'   => esc_html__( 'Hide thumbnails', TIELABS_TEXTDOMAIN ),
						'id'     => 'thumb_all',
						'type'   => 'checkbox',
						'class'  => 'block-thumb_all-item',
					));

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['post_meta'],
					array(
						'name'   => esc_html__( 'Post Meta', TIELABS_TEXTDOMAIN ),
						'id'     => 'post_meta',
						'type'   => 'checkbox',
						'class'  => 'block-default-options block-post_meta-item',
					));

				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['background_position'],
					array(
						'name'    =>  esc_html__( 'Featured Image Position', TIELABS_TEXTDOMAIN ),
						'id'      => 'background_position',
						'class'   => 'block-slider-options block-slider-background_position',
						'type'    => 'select',
						'options' => array(
							''            => esc_html__( 'Default',     TIELABS_TEXTDOMAIN ),
							'left top'    => esc_html__( 'Left Top',    TIELABS_TEXTDOMAIN ),
							'left center' => esc_html__( 'Left Center', TIELABS_TEXTDOMAIN ),
							'left bottom' => esc_html__( 'Left Bottom', TIELABS_TEXTDOMAIN ),

							'right top'    => esc_html__( 'Right Top',    TIELABS_TEXTDOMAIN ),
							'right center' => esc_html__( 'Right Center', TIELABS_TEXTDOMAIN ),
							'right bottom' => esc_html__( 'Right Bottom', TIELABS_TEXTDOMAIN ),

							'center top'    => esc_html__( 'Center Top',    TIELABS_TEXTDOMAIN ),
							'center center' => esc_html__( 'Center Center', TIELABS_TEXTDOMAIN ),
							'center bottom' => esc_html__( 'Center Bottom', TIELABS_TEXTDOMAIN ),
						),
					));

				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['posts_category'],
					array(
						'name'  => esc_html__( 'Post Primary Category', TIELABS_TEXTDOMAIN ),
						'id'    => 'posts_category',
						'class' => 'block-slider-options block-slider-categories-meta',
						'type'  => 'checkbox',
					));

				if( TIELABS_TAQYEEM_IS_ACTIVE ){

					tie_page_builder_option(
						$block_id =	$block_id,
						$section  = $section_id,
						$value    =	$block['posts_review'],
						array(
							'name'  => esc_html__( 'Review Rating', TIELABS_TEXTDOMAIN ),
							'id'    => 'posts_review',
							'class' => 'block-slider-options block-slider-review-meta',
							'type'  => 'checkbox',
						));
				}

				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['animate_auto'],
					array(
						'name'  =>  esc_html__( 'Animate Automatically', TIELABS_TEXTDOMAIN ),
						'id'    => 'animate_auto',
						'class' => 'block-slider-options block-slider-animate_auto',
						'type'  => 'checkbox',
					));

				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['slider_speed'],
					array(
						'name'  =>  esc_html__( 'Slider Speed in ms', TIELABS_TEXTDOMAIN ),
						'id'    => 'slider_speed',
						'class' => 'block-slider-options block-slider-slider_speed',
						'type'  => 'number',
						'hint'  => sprintf( esc_html__( 'Default is: %s', TIELABS_TEXTDOMAIN ), 3000 ),
					));

				tie_page_builder_option(
					$block_id =	$block_id,
					$section  = $section_id,
					$value    =	$block['media_overlay'],
					array(
						'name'   => esc_html__( 'Media Icon', TIELABS_TEXTDOMAIN ),
						'id'     => 'media_overlay',
						'type'   => 'checkbox',
						'class'  => 'block-default-options block-media-overlay-item',
					));


				echo '<div class="block-breaking-news-options">';

					tie_page_builder_option(
						$block_id =	$block_id,
						$section  = $section_id,
						$value    =	$block['breaking_effect'],
						array(
							'name'    => esc_html__( 'Animation Effect', TIELABS_TEXTDOMAIN ),
							'id'      => 'breaking_effect',
							'type'    => "select",
							'options' => array(
								'reveal'     => esc_html__( 'Typing',        TIELABS_TEXTDOMAIN ),
								'flipY'      => esc_html__( 'Fading',        TIELABS_TEXTDOMAIN ),
								'slideLeft'  => esc_html__( 'Sliding Left',  TIELABS_TEXTDOMAIN ),
								'slideRight' => esc_html__( 'Sliding Right', TIELABS_TEXTDOMAIN ),
								'slideUp'    => esc_html__( 'Sliding Up',    TIELABS_TEXTDOMAIN ),
								'slideDown'  => esc_html__( 'Sliding Down',  TIELABS_TEXTDOMAIN ),
						)));

					tie_page_builder_option(
						$block_id =	$block_id,
						$section  = $section_id,
						$value    =	$block['breaking_arrows'],
						array(
							'name' => esc_html__( 'Show the scrolling arrows?', TIELABS_TEXTDOMAIN ),
							'id'   => 'breaking_arrows',
							'type' => 'checkbox',
					));

				echo '</div>';

			echo '</div><!-- advanced-block-settings -->';

				tie_page_builder_option(
					$block_id = $block_id,
					$section  = $section_id,
					$value    = $block['boxid'],
					array(
						'id'      => 'boxid',
						'default' => 'block_'.rand(200, 3500),
						'type'    => 'hidden'
					));


				# Visual Block Style Options
				if( ! empty( $_REQUEST['block_id'] ) ){ ?>
					<script>
						jQuery(document).ready(function(){
							$AddedBlock	= jQuery('#listItem_<?php echo esc_js( $section_id .'-'. $block_id ) ?>');
							$AddedBlock.find('input:checked').closest('li').addClass( 'selected' );
							$AddedBlock.find('.checkbox-select').click( function(event){
								//event.preventDefault();
								$AddedBlock.find('li').removeClass('selected');
								//$AddedBlock.find(':radio').removeAttr('checked');
								jQuery(this).parent().addClass('selected');
								//jQuery(this).parent().find(':radio').attr('checked','checked');
							});
						});
					</script>
					<?php
				}
				?>
			</div> <!-- tie-block-options-group -->
		</div>
	</li>

	<?php
}


/*-----------------------------------------------------------------------------------*/
# Page Builder Blocks Styles Array
/*-----------------------------------------------------------------------------------*/
function tie_builder_blocks_styles(){

	$blocks_path = 'blocks/';

	// Main Blocks
	$builder_blocks_styles =
		array(
			'default'              => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '1' )  => array( 'block-blog'            => $blocks_path .'block-default.png',              'number' => 5 )),
			'li'                   => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '2' )  => array( 'block-li'              => $blocks_path .'block-li.png',                   'number' => 5 )),
			'1c'                   => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '3' )  => array( 'block-1c'              => $blocks_path .'block-1c.png',                   'number' => 5 )),
			'2c'                   => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '4' )  => array( 'block-2c block-2c-cat' => $blocks_path .'block-2c.png',                   'number' => 4 )),
			'big_thumb'            => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '5' )  => array( 'block-big-thumb'       => $blocks_path .'block-big_thumb.png',            'number' => 6 )),
			'grid'                 => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '6' )  => array( 'block-grid'            => $blocks_path .'block-grid.png',                 'number' => 5 )),
			'row'                  => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '7' )  => array( 'block-row'             => $blocks_path .'block-row.png',                  'number' => 12 )),
			'tabs'                 => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '8' )  => array( 'block-tabs'            => $blocks_path .'block-tabs.png',                 'number' => 5 )),
			'mini'                 => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '9' )  => array( 'block-mini'            => $blocks_path .'block-mini.png',                 'number' => 6 )),
			'big'                  => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '10' ) => array( 'block-big'             => $blocks_path .'block-big.png',                  'number' => 4 )),
			'full_thumb'           => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '11' ) => array( 'block-full-thumb'      => $blocks_path .'block-full_thumb.png',           'number' => 3 )),
			'overlay-title'        => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '12' ) => array( 'block-overlay-title'   => $blocks_path .'block-overlay-title.png',        'number' => 3 )),
			'content'              => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '13' ) => array( 'block-content'         => $blocks_path .'block-content.png',              'number' => 3 )),
			'timeline'             => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '14' ) => array( 'block-timeline'        => $blocks_path .'block-timeline.png',             'number' => 5 )),
			'first_big'            => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '15' ) => array( 'block-first-big'       => $blocks_path .'block-first_big.png',            'number' => 4 )),
			'overlay-title-center' => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '16' ) => array( 'block-overlay-title'   => $blocks_path .'block-overlay-title-center.png', 'number' => 3 )),
			'classic-small'        => array( sprintf( esc_html__( 'Block #%s', TIELABS_TEXTDOMAIN ), '17' ) => array( 'block-blog block-classic-small' => $blocks_path .'block-classic-small.png',     'number' => 5 )),

			'scroll'     => array( sprintf( esc_html__( 'Scrolling #%s', TIELABS_TEXTDOMAIN ), '1' ) => array( 'block-scroll'   => $blocks_path .'block-scroll.png',   'number' => 6 )),
			'scroll_2'   => array( sprintf( esc_html__( 'Scrolling #%s', TIELABS_TEXTDOMAIN ), '2' ) => array( 'block-scroll2'  => $blocks_path .'block-scroll_2.png', 'number' => 6 )),
		);

	$builder_blocks_styles = apply_filters( 'TieLabs/page_builder_blocks_args', $builder_blocks_styles );


	// Sliders
	for( $slider = 1; $slider <= 17; $slider++ ){

		$slide_class 	= 'block-slider-container slider_'.$slider;
		$slide_img 		= $blocks_path .'block-slider_'. $slider.'.png';

		switch ($slider) {
			case 2:
			case 5:
			case 9:
			case 10:
				$number = 6;
				break;

			case 7:
			case 11:
			case 16:
				$number = 8;
				break;

			case 15:
				$number = 12;
				break;

			default:
				$number = 10;
				break;
		}

		$builder_blocks_styles[ 'slider_' . $slider ] = array( sprintf( esc_html__( 'Slider #%s', TIELABS_TEXTDOMAIN ), $slider ) => array( $slide_class => $slide_img, 'number' => $number ) );
	}

	$builder_blocks_styles[ 'slider_50' ] = array( sprintf( esc_html__( 'Slider #%s', TIELABS_TEXTDOMAIN ), 18 ) => array( 'block-slider-container slider_50 slider_4' => $blocks_path .'block-slider_50.png', 'number' => 10 ) );

	// Slider Revolution
	if( TIELABS_REVSLIDER_IS_ACTIVE ){
		$builder_blocks_styles['revslider'] = array( esc_html__( 'Slider Revolution', TIELABS_TEXTDOMAIN ) => array( 'block-sliders-plugins block-revslider' => $blocks_path .'block-revslider.png' ) );
	}

	// LayerSlider
	if( TIELABS_LS_Sliders_IS_ACTIVE ){
		$builder_blocks_styles['lsslider'] = array( esc_html__( 'LayerSlider', TIELABS_TEXTDOMAIN ) => array( 'block-sliders-plugins block-lsslider' => $blocks_path .'block-lsslider.png' ) );
	}

	// Misc Blocks
	$builder_blocks_styles +=
		array(
			'videos_list'   => array( esc_html__( 'Videos Playlist', TIELABS_TEXTDOMAIN ) => array( 'block-video-list'                              => $blocks_path .'block-videos_list.png' ) ),
			'breaking'      => array( esc_html__( 'News Ticker', TIELABS_TEXTDOMAIN )     => array( 'block-breaking'                                => $blocks_path .'block-breaking.png' ) ),
			'ad'            => array( esc_html__( 'Ad Block', TIELABS_TEXTDOMAIN )        => array( 'block-e3lan-1c-container block-e3lan'          => $blocks_path .'block-ad.png' ) ),
			'ad_50'         => array( esc_html__( 'Ad Block', TIELABS_TEXTDOMAIN )        => array( 'block-2c block-e3lan-2c-container block-e3lan' => $blocks_path .'block-ad_50.png' ) ),
			'code'          => array( esc_html__( 'Custom Content', TIELABS_TEXTDOMAIN )  => array( 'block-code-1c-container block-code'            => $blocks_path .'block-code.png' ) ),
			'code_50'       => array( esc_html__( 'Custom Content', TIELABS_TEXTDOMAIN )  => array( 'block-code-2c-container block-2c block-code'   => $blocks_path .'block-code_50.png' ) ),
		);


	// WooCommerce Block
	if( TIELABS_WOOCOMMERCE_IS_ACTIVE ){
		$builder_blocks_styles['woocommerce']        = array( sprintf( esc_html__( 'WooCommerce #%s', TIELABS_TEXTDOMAIN ), '1' ) => array( 'block-woocommerce-normal block-woocommerce' => $blocks_path .'block-woocommerce.png' ) );
		$builder_blocks_styles['woocommerce-slider'] = array( sprintf( esc_html__( 'WooCommerce #%s', TIELABS_TEXTDOMAIN ), '2' ) => array( 'block-woocommerce-slider block-woocommerce' => $blocks_path .'block-woocommerce-slider.png' ) );
	}

	return $builder_blocks_styles;
}




/*-----------------------------------------------------------------------------------*/
# Page Builder
/*-----------------------------------------------------------------------------------*/

add_action( 'add_meta_boxes', 'tie_builder_editor_handler', 1  );

/**
 * tie_builder_editor_handler
 *
 * Handle the position of the page builder depending on the Editor
 */
function tie_builder_editor_handler(){

	if( TIELABS_ADMIN_HELPER::is_edit_gutenberg() ){

		// Add Button in the Gutenburg page to the TieLabs Builder
		add_meta_box(
			'tie_gutenburg_use_builder',
			esc_html__( 'TieLabs Builder', TIELABS_TEXTDOMAIN ) . ' <small>' . esc_html__( 'The content in the editor above will be ignored.', TIELABS_TEXTDOMAIN ) .'</small>',
			'tie_add_page_builder',
			'page',
			'normal',
			'high'
		);
	}
	else{
		add_action( 'edit_form_after_title', 'tie_add_page_builder' );
	}
}


/**
 * tie_add_page_builder
 */
function tie_add_page_builder(){

	$post_id = get_the_id();

	$builder_active = false;
	$sections       = false;
	$builder_style  = '';
	$inactive_text  = $button_text = esc_html__( 'Enable the TieLabs Builder', TIELABS_TEXTDOMAIN );
	$active_text    =  esc_html__( 'Disable the TieLabs Builder', TIELABS_TEXTDOMAIN );

	if( get_post_type( $post_id ) != 'page' || get_current_screen()->post_type != 'page' ){
		return;
	}

	# Get the stored Blocks
	if( $sections = tie_get_postdata( 'tie_page_builder') ){
		$sections = maybe_unserialize( $sections );
	}

	$button_class = 'button-primary';

	if( tie_get_postdata( 'tie_builder_active' ) || isset( $_GET['tie-builder'] ) ){
		$builder_active = 'yes';
		$button_class   = "builder_active button-secondary";
		$builder_style  = 'display:block;';
		$button_text    = $active_text;
	}

	?>

	<a class="tie-primary-button button button-hero <?php echo esc_attr( $button_class ) ?>" data-builder="<?php echo esc_attr( $active_text ) ?>" data-editor="<?php echo esc_attr( $inactive_text ) ?>" href="" id="tie-page-builder-button"><?php echo esc_html( $button_text ); ?></a>

	<input type="hidden" id="tie_builder_active" name="tie_builder_active" value="<?php echo esc_attr( $builder_active ) ?>">

	<div id="tie-page-builder" style="<?php echo esc_attr( $builder_style ) ?>">

		<div class="tie-page-builder postbox">

			<div id="tie-page-overlay"></div>

			<ul id="tie-builder-wrapper">
				<?php

					$section_id = $block_id = 1;
					if( ! empty( $sections ) && is_array( $sections ) ){
						foreach( $sections as $section ){
							tie_get_builder_section( $section_id, $section );
							$section_id++;
						}
					}
				?>

			</ul><!-- #tie-builder-wrapper -->

			<?php
				TIELABS_BUILDER_WIDGETS::get_widgets( $sections );
			?>


			<div class="tie-add-new-section-wrapper">
				<div class="tie-loading-container">
					<div class="tie-saving-settings">
						<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
							<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
							<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
							<path class="checkmark__error_1" d="M38 38 L16 16 Z"/>
							<path class="checkmark__error_2" d="M16 38 38 16 Z" />
						</svg>
					</div>
				</div>

				<a href="#" data-sections="<?php echo esc_attr( $section_id ) ?>" data-post="<?php echo get_the_id(); ?>" class="tie-add-new-section"><span class="dashicons dashicons-plus"></span> <?php esc_html_e( 'Add Section', TIELABS_TEXTDOMAIN ) ?></a>
			</div>

			<?php
				if( TIELABS_ADMIN_HELPER::is_edit_gutenberg() ){
					wp_editor( '', 'tie_dummy_editor' );
				}
			?>

			<script>
				var tie_block_id = <?php echo ! empty( $GLOBALS['tie_block_id'] ) ? esc_js( $GLOBALS['tie_block_id'] ) : 1; ?>;
			</script>
		</div><!-- .tie-page-builder /-->
	</div><!-- #tie-page-builder /-->
	<?php
}



/*-----------------------------------------------------------------------------------*/
# Disable the Gutenburg warning message
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_init', 'tie_gutenberg_disable_notice' );
function tie_gutenberg_disable_notice(){

	if( wp_doing_ajax() ){
		return;
	}

	if( ! empty( $_GET['post'] ) && tie_get_postdata( 'tie_builder_active', false, $_GET['post'] ) ){
		remove_action( 'admin_enqueue_scripts', 'gutenberg_check_if_classic_needs_warning_about_blocks' );
	}
}

/*-----------------------------------------------------------------------------------*/
# Dequeue Widgets Script if the Builder is Active
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_enqueue_scripts', 'tie_gutenberg_dequeue_widgts', 11 );
function tie_gutenberg_dequeue_widgts(){

	if( TIELABS_ADMIN_HELPER::is_edit_gutenberg() ){
		if( ! empty( $_GET['post'] ) && tie_get_postdata( 'tie_builder_active', false, $_GET['post'] ) ){
			wp_dequeue_script( 'admin-widgets' );
		}
	}
}



