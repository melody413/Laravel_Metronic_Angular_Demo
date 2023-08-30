<?php
/*
  Plugin Name: TieLabs Page Widgets
  Plugin URI:
  Description: Allow users to customize Widgets per page.
  Author:
  Version: 1.0.0
  Author URI:
 */


 if( ! class_exists( 'TIELABS_BUILDER_WIDGETS' ) ) {

 	class TIELABS_BUILDER_WIDGETS{

 		/**
 		 * __construct
 		 *
 		 * Class constructor where we will call our filter and action hooks.
 		 */
 		function __construct(){

		  // Actions
		  add_action( 'admin_print_scripts',      array( $this, 'print_scripts'           ));
		  add_action( 'widgets_admin_page',       array( $this, '_show_sections_sidebars' ));
			add_action( 'deleted_post',             array( $this, '_delete_widget_options'  ));
			add_action( 'save_post',                array( $this, '_save_widget_options'    ));
			add_action( 'wp_print_scripts',         array( $this, '_save_widgets_resources' ));
			add_action( 'admin_footer-post.php',    array( $this, 'page_footer' ), 99 );

		  // AJAX Hooks
		  add_action( 'wp_ajax_pw-widgets-order', array( $this, '_ajax_widgets_order' ));
		  add_action( 'wp_ajax_pw-save-widget',   array( $this, '_ajax_save_widget'   ));
 		}


 		/**
 		 * print_scripts
 		 *
 		 * Print the widgets JS for the page builder
 		 */
		function print_scripts(){

	 		$screen = get_current_screen();

	 		if( ! empty( $screen->base ) && $screen->base == 'post' && $screen->id == 'page' ){

	 			wp_enqueue_script(
          'tie-builder-widgets',
          TIELABS_TEMPLATE_URL .'/framework/admin/assets/page-widgets.js',
          array(
            'jquery',
            'jquery-ui-sortable',
            'jquery-ui-draggable',
            'jquery-ui-droppable'
          ),
          time(),
          false
        );

	 			// The Widgets resources
        $widgets_resources = get_option( 'tie_widgets_resources' );

				if( $widgets_resources && is_array( $widgets_resources ) ){

					// Scripts
					global $wp_scripts;

					if( ! empty( $widgets_resources['scripts'] ) && is_array( $widgets_resources['scripts'] ) ) {
						foreach ( $widgets_resources['scripts'] as $script ){
							if( ! in_array( $script['handle'], $wp_scripts->queue ) && $script['handle'] != 'admin-widgets' ){
								wp_enqueue_script( $script['handle'], $script['src'], $script['deps'], $script['ver'] );

								if( ! empty( $script['data'] ) ){
									echo '<!-- Hi Fou2sh :) /-->';
									echo "<script type='text/javascript'>\n"; // CDATA and type='text/javascript' is not needed for HTML 5
									echo "/* <![CDATA[ */\n";
									echo ( $script['data'] ). "\n";
									echo "/* ]]> */\n";
									echo "</script>\n";
								}

							}
						}
					}

					// Styles
					global $wp_styles;

					if( ! empty( $widgets_resources['styles'] ) && is_array( $widgets_resources['styles'] ) ) {
						foreach ( $widgets_resources['styles'] as $styles ){
							if( ! in_array( $styles['handle'] , $wp_styles->queue ) ){
								wp_enqueue_style( $styles['handle'], $styles['src'], $styles['deps'], $styles['ver'] );
							}
						}
					}
				}

				do_action( 'admin_print_scripts-widgets.php' );
	 		}
		}


 		/**
 		 * page_footer
 		 *
 		 * JS in the page Footer
 		 */
		function page_footer(){

			$screen = get_current_screen();

			if( ! empty( $screen->base ) && $screen->base == 'post' && $screen->id == 'page' ){
				do_action( 'admin_footer-widgets.php' );
			}
		}


		/**
 		 * _get_post_id
 		 *
 		 * Get the Post ID
 		 *
 		 */
		function _get_post_id(){

			$post = get_post();

			if( ! empty( $post->ID ) ){
				$post_id = $post->ID;
			}

			elseif( ! empty( $_GET['post'] ) ){
				$post_id = $_GET['post'];
			}

			return isset( $post_id ) ? $post_id : false;
		}


		/**
 		 * _ajax_widgets_order
 		 *
 		 * Save the order of the widgets
 		 */
		function _ajax_widgets_order() {
			check_ajax_referer( 'save-sidebar-widgets', 'savewidgets' );

			if( ! current_user_can('edit_posts') || ! $_POST['post_id'] ){
				die('-1');
			}

			$post_id = stripslashes($_POST['post_id']);

			unset($_POST['savewidgets'], $_POST['action']);

			// save widgets order for all sidebars
			if( is_array( $_POST['sidebars'] ) ) {
				$sidebars = array();

				foreach ( $_POST['sidebars'] as $key => $val ){
					$sb = array();

					if( ! empty( $val ) ){
						$val = explode(',', $val);

						foreach ($val as $k => $v) {

							if (strpos($v, 'widget-') === false){
								continue;
							}

							$sb[$k] = substr($v, strpos($v, '_') + 1);
						}
					}

					$sidebars[$key] = $sb;
				}

				if (! empty( $post_id ) ) {
					$this->_set_sidebars_widgets( $sidebars, $post_id );
				}

				die('1');
			}

			die('-1');
		}


		/**
		 * _ajax_save_widget
		 *
		 * Save the Widget settings
		 *
		 */
		function _ajax_save_widget(){

			global $wp_registered_widget_controls, $wp_registered_widgets, $wp_registered_widget_updates;

			check_ajax_referer('save-sidebar-widgets', 'savewidgets');

			if ( ! current_user_can( 'edit_posts' ) || ! isset( $_POST['id_base'] ) || empty( $_POST['post_id'] ) ){
				die('-1');
			}

			$post_id = stripslashes($_POST['post_id']);

			unset( $_POST['savewidgets'], $_POST['action'] );

			do_action('load-widgets.php');
			do_action('widgets.php');
			do_action('sidebar_admin_setup');
			do_action('w3tc_pgcache_flush');

			$id_base      = $_POST['id_base'];
			$widget_id    = $_POST['widget-id'];
			$sidebar_id   = $_POST['sidebar'];
			$multi_number = ! empty( $_POST['multi_number']) ? (int) $_POST['multi_number'] : 0;
			$settings     = isset( $_POST['widget-' . $id_base]) && is_array($_POST['widget-' . $id_base]) ? $_POST['widget-' . $id_base] : false;
			$error        = '<p>' . esc_html__( 'An error has occured. Please reload the page and try again.', TIELABS_TEXTDOMAIN ) . '</p>';

			$sidebars = wp_get_sidebars_widgets();
			$sidebar  = isset( $sidebars[ $sidebar_id ] ) ? $sidebars[ $sidebar_id ] : array();

			// delete
			if ( isset($_POST['delete_widget']) && $_POST['delete_widget'] ){

				if ( ! isset($wp_registered_widgets[$widget_id]) ){
					die($error);
				}

				$sidebar = array_diff( $sidebar, array($widget_id) );
				$_POST   = array('sidebar' => $sidebar_id, 'widget-' . $id_base => array(), 'the-widget-id' => $widget_id, 'delete_widget' => '1');
			}

			elseif ($settings && preg_match('/__i__|%i%/', key($settings))) {
				if (!$multi_number){
					die($error);
				}

				$_POST['widget-' . $id_base] = array($multi_number => array_shift($settings));
				$widget_id = $id_base . '-' . $multi_number;
				$sidebar[] = $widget_id;
			}


			$_POST['widget-id'] = $sidebar;

			if (!isset($_POST['delete_widget']) || !$_POST['delete_widget']) {

				foreach ((array) $wp_registered_widget_updates as $name => $control) {

					if ( $name == $id_base ){

						if ( ! is_callable( $control['callback'] ) ){
							continue;
						}

						// do some hack
						$number = $multi_number > 0 ? $multi_number : (int) $_POST['widget_number'];
						if (is_object($control['callback'][0])) {
							$all_instance = $control['callback'][0]->get_settings();
						}

						ob_start();
						call_user_func_array($control['callback'], $control['params']);
						ob_end_clean();

						break;
					}
				}
			}

			if (isset($_POST['delete_widget']) && $_POST['delete_widget']) {
				$sidebars[$sidebar_id] = $sidebar;
				if (!empty($post_id)) {
					$this->_set_sidebars_widgets($sidebars, $post_id);
				}

				die();
			}

			if ( ! empty( $_POST['add_new'] ) ) {
				die();
			}

			if ($form = $wp_registered_widget_controls[$widget_id]){
				call_user_func_array($form['callback'], $form['params']);
      }

			//	print 'Updated ajax save widget.';

			if ( function_exists( 'w3tc_pgcache_flush' ) ) {
				w3tc_pgcache_flush();
			}

			die();
		}


		/**
		 * _set_sidebars_widgets
		 *
		 * Update the Widget settings
		 */
		function _set_sidebars_widgets( $_sidebars_widgets = array(), $post_id = false ){

      if ( empty( $post_id ) ) {
        return;
      }

      $sidebars_widgets = get_option('sidebars_widgets');

      if( is_array( $sidebars_widgets ) && isset( $sidebars_widgets['array_version'] ) ) {
        unset($sidebars_widgets['array_version']);
      }

      $sidebars_widgets = array_merge( $sidebars_widgets, $_sidebars_widgets );

      // Update the global Widgets options
      wp_set_sidebars_widgets( $sidebars_widgets );

      // Save the sections ID to remove these sidebars when removing the post.
      // And register these custom sidebars.
      $custom_widgets = get_option( 'tie_sidebars_widgets', array() );
      $custom_widgets[ $post_id ] = $_sidebars_widgets;
      update_option( 'tie_sidebars_widgets', $custom_widgets, 'yes' );
		}


		/**
		 * _delete_widget_options
		 *
		 */
		function _delete_widget_options( $post_id ){

      $custom_widgets   = get_option( 'tie_sidebars_widgets', array() );
      $sidebars_widgets = get_option( 'sidebars_widgets' );

      if( ! empty( $custom_widgets[ $post_id ] ) && is_array( $custom_widgets[ $post_id ] ) ) {
        foreach ( $custom_widgets[ $post_id ] as $section => $widgets ){
          unset( $sidebars_widgets[ $section ] );
        }
      }

      unset( $custom_widgets[ $post_id ] );
      update_option( 'tie_sidebars_widgets', $custom_widgets );

      wp_set_sidebars_widgets( $sidebars_widgets );
		}


		/**
		 * _save_widget_options
		 */
		function _save_widget_options( $post_id ){

      // Get the exists sidebars
      $sidebars_array = array();

  		if( ! empty( $_POST['tie_home_cats'] ) && is_array( $_POST['tie_home_cats']  ) ){

        $builder_data = $_POST['tie_home_cats'];
        if( ! empty( $builder_data ) && is_array( $builder_data ) ){
          foreach( $builder_data as $section ){
            if( ! empty( $section['settings']['sidebar_position'] ) && $section['settings']['sidebar_position'] != 'full' ){
              $sidebars_array[] = $section['settings']['section_id'];
            }
          }
        }
      }

      // Post Sidebars
      $custom_widgets = get_option( 'tie_sidebars_widgets', array() );
      if( ! empty( $custom_widgets[ $post_id ] ) && is_array( $custom_widgets[ $post_id ] ) ) {
        foreach ( $custom_widgets[ $post_id ] as $section => $widgets ){
          if( ! in_array( $section, $sidebars_array ) ){
            unset( $custom_widgets[ $post_id ][ $section ] );
          }
        }
      }
      update_option( 'tie_sidebars_widgets', $custom_widgets );

      // Global Widgets
      $sidebars_widgets = get_option( 'sidebars_widgets', array() );

			if( empty( $sidebars_widgets ) || ! is_array( $sidebars_widgets ) ){
				$sidebars_widgets = array();
			}

			$sidebar_keys = array_keys( $sidebars_widgets );
      $sections_sidebars = preg_grep( "/^tiepost-$post_id-section-\w*$/", $sidebar_keys );

      foreach ( $sections_sidebars as $section ){
        if( ! in_array( $section, $sidebars_array ) ){
          unset( $sidebars_widgets[ $section ] );
        }
      }

      wp_set_sidebars_widgets( $sidebars_widgets );
		}


		/**
		 * _show_sections_sidebars
		 */
		function _show_sections_sidebars(){
      echo "
        <div id=\"tie-show-sections-sidebars-wrap\">
          <h2>". esc_html__( 'TieLabs Page Builder widgets areas', TIELABS_TEXTDOMAIN )."</h2>
          <div>
            <input id=\"tie-show-sections-sidebars\" class=\"tie-js-switch\" type=\"checkbox\" value=\"true\">
          </div>
        </div>
      ";
    }


		/**
		 * _save_widgets_resources
		 * We need to get the all Js files of the Widgets page and load them in the Pages
		 * Edit Page to prevent any Js issues may caused by the custom Plugin widgets.
     * We need a better Idea :)
		 */
		function _save_widgets_resources() {

			$current_screen = get_current_screen();

			$result = array();
			$result['scripts'] = array();
			$result['styles']  = array();

			if( ! empty( $current_screen ) && $current_screen->id == 'widgets' ){

				// Debug
				//echo ' ==========================| Yes you are here :) |==========================';

				global $wp_scripts;
				foreach( $wp_scripts->queue as $script ){

					$data = ! empty( $wp_scripts->registered[$script]->extra['data'] ) ? $wp_scripts->registered[$script]->extra['data'] : '';

					$result['scripts'][] =  array(
						'src'     => $wp_scripts->registered[$script]->src,
						'handle'  => $wp_scripts->registered[$script]->handle,
						'deps'    => $wp_scripts->registered[$script]->deps,
						'ver'     => $wp_scripts->registered[$script]->ver,
						'data'    => $data,
					);
				}

				global $wp_styles;
				foreach( $wp_styles->queue as $script ){
					$result['styles'][] =  array(
						'src'     => $wp_styles->registered[$script]->src,
						'handle'  => $wp_styles->registered[$script]->handle,
						'deps'    => $wp_styles->registered[$script]->deps,
						'ver'     => $wp_styles->registered[$script]->ver,
					);
				}

				update_option( 'tie_widgets_resources', $result );
			}
		}


		/**
		 * get_widgets
		 */
		public static function get_widgets( $sections = array() ) {
			global $wp_registered_widgets, $sidebars_widgets;

			$sidebars_widgets = wp_get_sidebars_widgets();
			if ( empty( $sidebars_widgets ) ){
				$sidebars_widgets = wp_get_widget_defaults();
			}

			// include widgets function
			if ( ! function_exists('wp_list_widgets') ){
				require_once(ABSPATH . '/wp-admin/includes/widgets.php');
			}
			?>

			<form style="display: none;" action="" method="post"></form>

			<div id="tie-sidebars-customize" class="tie-popup-block tie-popup-window">

				<div class="tie-builder-item-top-container">
					<h2><?php esc_html_e( 'Manage Widgets', TIELABS_TEXTDOMAIN ) ?></h2>
					<a class="tie-primary-button button button-primary button-hero tie-edit-block-done" href="#"><?php esc_html_e( 'Done', TIELABS_TEXTDOMAIN ) ?></a>
				</div>

		    <div class="customize-widgets-container">

		      <div id="section-sidebar-options">
		        <?php

		          if( ! empty( $sections ) && is_array( $sections ) ){

		            $section_number = 1;
		            foreach( $sections as $section ){

		              $section_settings = wp_parse_args( $section['settings'], array(
		                'predefined_sidebar' => '',
		                'sidebar_id'         => '',
		              ));

		              tie_get_section_sidebar_options( $section_settings['section_id'], $section_number, $section_settings );

		              $section_number++;
		            }
		          }
		        ?>
		      </div>

		  		<input type="hidden" name="pw-sidebar-customize" value="0" />

		      <div id="custom-widgtes-settings">
		    		<div class="widget-liquid-left">
		    			<div id="widgets-left">
		    				<div id="available-widgets" class="widgets-holder-wrap">
		    					<div class="sidebar-name">
		    						<div class="sidebar-name-arrow"><br /></div>
		    						<h3><?php esc_html__('Available Widgets', TIELABS_TEXTDOMAIN); ?> <span id="removing-widget"><?php esc_html__('Deactivate', TIELABS_TEXTDOMAIN); ?> <span></span></span></h3>
		    					</div>
		    					<div class="widget-holder">
		    						<p class="description"><?php esc_html__('Drag widgets from here to a sidebar on the right to activate them. Drag widgets back here to deactivate them and delete their settings.', TIELABS_TEXTDOMAIN); ?></p>
		    						<div id="widget-list">
		    							<?php wp_list_widgets(); ?>
		    						</div>
		    						<br class='clear' />
		    					</div>
		    					<br class="clear" />
		    				</div>
		    			</div>
		    		</div>

		    		<div class="widget-liquid-right">
		    			<div id="widgets-right">

		    				<?php
		              if( ! empty( $sections ) && is_array( $sections ) ){
		      					foreach ( $sections as $section ){
		                  $section_id = $section['settings']['section_id'];

		                  echo '<div id="wrap-'. $section_id .'" class="widgets-holder-wrap">';
		                    wp_list_widget_controls( $section_id, esc_html__('Section Widgets Area', TIELABS_TEXTDOMAIN ) );
		                  echo '</div>';
		      					}
		              }
		    				?>

		    			</div>
		    		</div>
		      </div>

		    </div> <!-- .customize-widgets-container /-->

				<form action="" method="post">
					<?php wp_nonce_field('save-sidebar-widgets', '_wpnonce_widgets', false); ?>
				</form>
				<br class="clear" />

			</div><!-- End #pw-sidebars-customize -->

			<div class="widgets-chooser">
				<ul class="widgets-chooser-sidebars"></ul>
				<div class="widgets-chooser-actions">
					<button class="button-secondary"><?php esc_html_e( 'Cancel', TIELABS_TEXTDOMAIN  ); ?></button>
					<button class="button-primary"><?php esc_html_e( 'Add Widget', TIELABS_TEXTDOMAIN  ); ?></button>
				</div>
			</div>
			<?php
		}
 	}


 	// Instantiate the class
 	new TIELABS_BUILDER_WIDGETS();
 }
