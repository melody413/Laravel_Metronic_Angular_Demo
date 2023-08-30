<?php
/**
 * Welcome Page
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_WELCOME_PAGE' ) ) {

	class TIELABS_WELCOME_PAGE{


		public $menu_slug = 'tie-theme-welcome';


		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			add_filter( 'TieLabs/panel_submenus', array( $this, '_add_options_menu' ));
			add_filter( 'TieLabs/about_tabs',     array( $this, '_add_about_tabs' ), 9 );
		}


		/**
		 * _add_options_menu
		 *
		 * Add the system status page to the theme menu
		 */
		function _add_options_menu( $menus ){

			$menus[] = array(
				'page_title' => esc_html__( 'Getting Started', TIELABS_TEXTDOMAIN ),
				'menu_title' => esc_html__( 'Getting Started', TIELABS_TEXTDOMAIN ),
				'menu_slug'  => $this->menu_slug,
				'function'   => array( $this, '_page_content' ),
			);

			return $menus;
		}


		/**
		 * _add_about_tabs
		 *
		 * Add the Getting Started Page to the about page's tabs
		 */
		function _add_about_tabs( $tabs ){

			$tabs['getting_started'] = array(
				'text' => esc_html__( 'Getting Started', TIELABS_TEXTDOMAIN ),
				'url'  => menu_page_url( $this->menu_slug, false ),
			);

			return $tabs;
		}


		/**
		 * _page_content
		 *
		 */
		function _page_content() {

			echo '<div class="wrap about-wrap tie-about-wrap">';

			self::_head_section();

			do_action( 'TieLabs/welcome_splash_content' );

			echo '</div>';

		}



		/**
		 * _head_section
		 *
		 * Show the Welcome Page head
		 */
		public static function _head_section( $current_tab = 'getting_started' ){

			$welcome_args = array(
				'title'   => sprintf( esc_html__( 'Welcome to %s', TIELABS_TEXTDOMAIN ), apply_filters( 'TieLabs/theme_name', 'TieLabs' ) ),
				'about'   => '',
				'color'   => '#000000',
				'img'     => '',
				'version' => '',
			);

			$welcome_args = apply_filters( 'TieLabs/welcome_args', $welcome_args );

			$tabs = array();
			$tabs = apply_filters( 'TieLabs/about_tabs', $tabs );

			$item_url = tie_get_purchase_link( array( 'utm_source' => 'twitter', 'utm_medium' => 'installed-msg' ) );

			?>

			<h1><?php echo esc_html( $welcome_args['title'] ) ?></h1>


			<p class="about-text"><?php echo esc_html( $welcome_args['about'] ); ?>

				<a href="https://twitter.com/share" class="twitter-share-button"
				   data-url="<?php echo esc_url( $item_url ) ?>"
				   data-text="<?php printf( esc_html__( 'I just installed the amazing %s #WordPress theme #tielabs', TIELABS_TEXTDOMAIN ), apply_filters( 'TieLabs/theme_name', 'TieLabs' ) ); ?>"
				   data-via="tielabs" data-size="large">Tweet</a>
				<script>
					!function (d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (!d.getElementById(id)) {
							js = d.createElement(s);
							js.id = id;
							js.src = "//platform.twitter.com/widgets.js";
							fjs.parentNode.insertBefore(js, fjs);
						}
					}(document, "script", "twitter-wjs");
				</script>

			</p>
			<div class="tie-badge" style="background-color: <?php echo esc_attr( $welcome_args['color'] ); ?>;">
				<img src="<?php echo esc_attr( $welcome_args['img'] ); ?>" alt="" />
				<?php printf( esc_html__( 'Version %s', TIELABS_TEXTDOMAIN  ), TIELABS_DB_VERSION ); ?>
			</div>


			<h2 class="tie-nav-tab-wrapper nav-tab-wrapper wp-clearfix">
				<?php
				foreach ( $tabs as $key => $value ){
					if( ! empty( $value['url'] ) && ! empty( $value['text'] ) ){
						$class = ( $key == $current_tab ) ? 'nav-tab nav-tab-active' : 'nav-tab'; ?>
						<a href="<?php echo esc_url( $value['url'] ) ?>" class="<?php echo esc_attr( $class ) ?>"><?php echo esc_html( $value['text'] ); ?></a>
						<?php
					}
				}
				?>
			</h2>

			<?php
		}

	}


	// Instantiate the class
	new TIELABS_WELCOME_PAGE();

}
