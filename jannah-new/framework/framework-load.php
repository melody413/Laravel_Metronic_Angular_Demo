<?php
/**
 * Framework
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*
 * Main Helper Class
 */
require TIELABS_TEMPLATE_PATH . '/framework/classes/class-tielabs-helper.php';

/*
 * Logging Class
 */
require TIELABS_TEMPLATE_PATH . '/framework/classes/class-tielabs-logging.php';

/**
 * Framework Functions
 */

require TIELABS_TEMPLATE_PATH . '/framework/functions/general-functions.php';
require TIELABS_TEMPLATE_PATH . '/framework/functions/media-functions.php';
require TIELABS_TEMPLATE_PATH . '/framework/functions/post-functions.php';
require TIELABS_TEMPLATE_PATH . '/framework/functions/mobile-functions.php';
require TIELABS_TEMPLATE_PATH . '/framework/functions/breadcrumbs.php';
require TIELABS_TEMPLATE_PATH . '/framework/functions/formatting.php';
require TIELABS_TEMPLATE_PATH . '/framework/functions/post-actions.php';
require TIELABS_TEMPLATE_PATH . '/framework/functions/page-templates.php';

/**
 * Framework Classes
 */
require TIELABS_TEMPLATE_PATH . '/framework/classes/class-tielabs-filters.php';
require TIELABS_TEMPLATE_PATH . '/framework/classes/class-tielabs-advertisment.php';
require TIELABS_TEMPLATE_PATH . '/framework/classes/class-tielabs-ajax.php';
require TIELABS_TEMPLATE_PATH . '/framework/classes/class-tielabs-foxpush.php';
require TIELABS_TEMPLATE_PATH . '/framework/classes/class-tielabs-postviews.php';
require TIELABS_TEMPLATE_PATH . '/framework/classes/class-tielabs-mega-menu.php';
require TIELABS_TEMPLATE_PATH . '/framework/classes/class-tielabs-videos.php';
require TIELABS_TEMPLATE_PATH . '/framework/classes/class-tielabs-pagination.php';
require TIELABS_TEMPLATE_PATH . '/framework/classes/class-tielabs-opengraph.php';
require TIELABS_TEMPLATE_PATH . '/framework/classes/class-tielabs-wp-helper.php';
require TIELABS_TEMPLATE_PATH . '/framework/classes/class-tielabs-styles.php';
require TIELABS_TEMPLATE_PATH . '/framework/classes/class-tielabs-weather.php';

/**
 * Mobile Detector
 */
require TIELABS_TEMPLATE_PATH . '/framework/vendor/Mobile_Detect/devices.php';

/**
 * Backend Loader
 */
require TIELABS_TEMPLATE_PATH . '/framework/admin/classes/class-tielabs-admin-helper.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/framework-admin.php';


/**
 * Extensions
 *
 * By: TieLabs
 */
require TIELABS_TEMPLATE_PATH . '/framework/plugins/class-tielabs-extensions.php';

/**
 * AMP
 *
 * By: Automattic
 * https://wordpress.org/plugins/amp/
 */
require TIELABS_TEMPLATE_PATH . '/framework/plugins/class-tielabs-amp.php';

/**
 * WooCommerce
 *
 * By: Automattic
 * https://wordpress.org/plugins/woocommerce/
 */
require TIELABS_TEMPLATE_PATH . '/framework/plugins/class-tielabs-woocommerce.php';

/**
 * Sensei
 *
 * By: Automattic
 * https://woocommerce.com/products/sensei/
 */
require TIELABS_TEMPLATE_PATH . '/framework/plugins/class-tielabs-sensei.php';

/**
 * BuddyPress
 *
 * By: Multiple Authors
 * https://wordpress.org/plugins/buddypress/
 */
require TIELABS_TEMPLATE_PATH . '/framework/plugins/class-tielabs-buddypress.php';

/**
 * bbPress
 *
 * By: Multiple Authors
 * https://wordpress.org/plugins/buddypress/
 */
require TIELABS_TEMPLATE_PATH . '/framework/plugins/class-tielabs-bbpress.php';

/**
 * Jetpack
 *
 * By: Automattic
 * https://wordpress.org/plugins/jetpack/
 */
require TIELABS_TEMPLATE_PATH . '/framework/plugins/class-tielabs-jetpack.php';

/**
 * Taqyeem
 *
 * By: TieLabs
 */
require TIELABS_TEMPLATE_PATH . '/framework/plugins/class-tielabs-taqyeem.php';

/**
 * TieLabs Instagram
 *
 * By: TieLabs
 */
require TIELABS_TEMPLATE_PATH . '/framework/plugins/class-tielabs-instagram.php';

 /**
  * Instant Articles for WP
  *
  * By: Automattic, Dekode, Facebook
  * https://wordpress.org/plugins/fb-instant-articles/
  */
require TIELABS_TEMPLATE_PATH . '/framework/plugins/class-tielabs-fbinstant-articles.php';

 /**
  * AppBear
  *
  */
//require TIELABS_TEMPLATE_PATH . '/framework/plugins/class-appbear-endpoints.php';

 /**
  * Cryptocurrency All-in-One
  * WP Ultimate Crypto
  *
  */
require TIELABS_TEMPLATE_PATH . '/framework/plugins/crypto.php';
