<?php
/**
 * Migrate Icons from Font Awesome v4 to v5
 */

/**
 * Replace the old icon classes with the new classes
 */
function tie_fa4_to_fa5_value_migration( $icon ){

	// Already migrated
	if( empty( $icon ) || strpos( $icon, 'fab ' ) !== false || strpos( $icon, 'far ' ) !== false || strpos( $icon, 'fas ' ) !== false ){
		return $icon;
	}

	$new = array(
		'500px' => 'fab fa-500px',
		'address-book-o' => 'far fa-address-book',
		'address-card-o' => 'far fa-address-card',
		'adn' => 'fab fa-adn',
		'amazon' => 'fab fa-amazon',
		'android' => 'fab fa-android',
		'angellist' => 'fab fa-angellist',
		'apple' => 'fab fa-apple',
		'area-chart' => 'fas fa-chart-area',
		'arrow-circle-o-down' => 'far fa-arrow-alt-circle-down',
		'arrow-circle-o-left' => 'far fa-arrow-alt-circle-left',
		'arrow-circle-o-right' => 'far fa-arrow-alt-circle-right',
		'arrow-circle-o-up' => 'far fa-arrow-alt-circle-up',
		'arrows' => 'fas fa-arrows-alt',
		'arrows-alt' => 'fas fa-expand-arrows-alt',
		'arrows-h' => 'fas fa-arrows-alt-h',
		'arrows-v' => 'fas fa-arrows-alt-v',
		'asl-interpreting' => 'fas fa-american-sign-language-interpreting',
		'automobile' => 'fas fa-car',
		'bandcamp' => 'fab fa-bandcamp',
		'bank' => 'fas fa-university',
		'bar-chart' => 'far fa-chart-bar',
		'bar-chart-o' => 'far fa-chart-bar',
		'bathtub' => 'fas fa-bath',
		'battery' => 'fas fa-battery-full',
		'battery-0' => 'fas fa-battery-empty',
		'battery-1' => 'fas fa-battery-quarter',
		'battery-2' => 'fas fa-battery-half',
		'battery-3' => 'fas fa-battery-three-quarters',
		'battery-4' => 'fas fa-battery-full',
		'behance' => 'fab fa-behance',
		'behance-square' => 'fab fa-behance-square',
		'bell-o' => 'far fa-bell',
		'bell-slash-o' => 'far fa-bell-slash',
		'bitbucket' => 'fab fa-bitbucket',
		'bitbucket-square' => 'fab fa-bitbucket',
		'bitcoin' => 'fab fa-btc',
		'black-tie' => 'fab fa-black-tie',
		'bluetooth' => 'fab fa-bluetooth',
		'bluetooth-b' => 'fab fa-bluetooth-b',
		'bookmark-o' => 'far fa-bookmark',
		'btc' => 'fab fa-btc',
		'building-o' => 'far fa-building',
		'buysellads' => 'fab fa-buysellads',
		'cab' => 'fas fa-taxi',
		'calendar' => 'fas fa-calendar-alt',
		'calendar-check-o' => 'far fa-calendar-check',
		'calendar-minus-o' => 'far fa-calendar-minus',
		'calendar-o' => 'far fa-calendar',
		'calendar-plus-o' => 'far fa-calendar-plus',
		'calendar-times-o' => 'far fa-calendar-times',
		'caret-square-o-down' => 'far fa-caret-square-down',
		'caret-square-o-left' => 'far fa-caret-square-left',
		'caret-square-o-right' => 'far fa-caret-square-right',
		'caret-square-o-up' => 'far fa-caret-square-up',
		'cc' => 'far fa-closed-captioning',
		'cc-amex' => 'fab fa-cc-amex',
		'cc-diners-club' => 'fab fa-cc-diners-club',
		'cc-discover' => 'fab fa-cc-discover',
		'cc-jcb' => 'fab fa-cc-jcb',
		'cc-mastercard' => 'fab fa-cc-mastercard',
		'cc-paypal' => 'fab fa-cc-paypal',
		'cc-stripe' => 'fab fa-cc-stripe',
		'cc-visa' => 'fab fa-cc-visa',
		'chain' => 'fas fa-link',
		'chain-broken' => 'fas fa-unlink',
		'check-circle-o' => 'far fa-check-circle',
		'check-square-o' => 'far fa-check-square',
		'chrome' => 'fab fa-chrome',
		'circle-o' => 'far fa-circle',
		'circle-o-notch' => 'fas fa-circle-notch',
		'circle-thin' => 'far fa-circle',
		'clipboard' => 'far fa-clipboard',
		'clock-o' => 'far fa-clock',
		'clone' => 'far fa-clone',
		'close' => 'fas fa-times',
		'cloud-download' => 'fas fa-cloud-download-alt',
		'cloud-upload' => 'fas fa-cloud-upload-alt',
		'cny' => 'fas fa-yen-sign',
		'code-fork' => 'fas fa-code-branch',
		'codepen' => 'fab fa-codepen',
		'codiepie' => 'fab fa-codiepie',
		'comment-o' => 'far fa-comment',
		'commenting' => 'fas fa-comment-dots',
		'commenting-o' => 'far fa-comment-dots',
		'comments-o' => 'far fa-comments',
		'compass' => 'far fa-compass',
		'connectdevelop' => 'fab fa-connectdevelop',
		'contao' => 'fab fa-contao',
		'copyright' => 'far fa-copyright',
		'creative-commons' => 'fab fa-creative-commons',
		'credit-card' => 'far fa-credit-card',
		'credit-card-alt' => 'fas fa-credit-card',
		'css3' => 'fab fa-css3',
		'cutlery' => 'fas fa-utensils',
		'dashboard' => 'fas fa-tachometer-alt',
		'dashcube' => 'fab fa-dashcube',
		'deafness' => 'fas fa-deaf',
		'dedent' => 'fas fa-outdent',
		'delicious' => 'fab fa-delicious',
		'deviantart' => 'fab fa-deviantart',
		'diamond' => 'far fa-gem',
		'digg' => 'fab fa-digg',
		'dollar' => 'fas fa-dollar-sign',
		'dot-circle-o' => 'far fa-dot-circle',
		'dribbble' => 'fab fa-dribbble',
		'drivers-license' => 'fas fa-id-card',
		'drivers-license-o' => 'far fa-id-card',
		'dropbox' => 'fab fa-dropbox',
		'drupal' => 'fab fa-drupal',
		'edge' => 'fab fa-edge',
		'eercast' => 'fab fa-sellcast',
		'empire' => 'fab fa-empire',
		'envelope-o' => 'far fa-envelope',
		'envelope-open-o' => 'far fa-envelope-open',
		'envira' => 'fab fa-envira',
		'etsy' => 'fab fa-etsy',
		'eur' => 'fas fa-euro-sign',
		'euro' => 'fas fa-euro-sign',
		'exchange' => 'fas fa-exchange-alt',
		'expeditedssl' => 'fab fa-expeditedssl',
		'external-link' => 'fas fa-external-link-alt',
		'external-link-square' => 'fas fa-external-link-square-alt',
		'eye' => 'far fa-eye',
		'eye-slash' => 'far fa-eye-slash',
		'eyedropper' => 'fas fa-eye-dropper',
		'fa' => 'fab fa-font-awesome',
		'facebook' => 'fab fa-facebook-f',
		'facebook-f' => 'fab fa-facebook-f',
		'facebook-official' => 'fab fa-facebook',
		'facebook-square' => 'fab fa-facebook-square',
		'feed' => 'fas fa-rss',
		'file-archive-o' => 'far fa-file-archive',
		'file-audio-o' => 'far fa-file-audio',
		'file-code-o' => 'far fa-file-code',
		'file-excel-o' => 'far fa-file-excel',
		'file-image-o' => 'far fa-file-image',
		'file-movie-o' => 'far fa-file-video',
		'file-o' => 'far fa-file',
		'file-pdf-o' => 'far fa-file-pdf',
		'file-photo-o' => 'far fa-file-image',
		'file-picture-o' => 'far fa-file-image',
		'file-powerpoint-o' => 'far fa-file-powerpoint',
		'file-sound-o' => 'far fa-file-audio',
		'file-text' => 'fas fa-file-alt',
		'file-text-o' => 'far fa-file-alt',
		'file-video-o' => 'far fa-file-video',
		'file-word-o' => 'far fa-file-word',
		'file-zip-o' => 'far fa-file-archive',
		'files-o' => 'far fa-copy',
		'firefox' => 'fab fa-firefox',
		'first-order' => 'fab fa-first-order',
		'flag-o' => 'far fa-flag',
		'flash' => 'fas fa-bolt',
		'flickr' => 'fab fa-flickr',
		'floppy-o' => 'far fa-save',
		'folder-o' => 'far fa-folder',
		'folder-open-o' => 'far fa-folder-open',
		'font-awesome' => 'fab fa-font-awesome',
		'fonticons' => 'fab fa-fonticons',
		'fort-awesome' => 'fab fa-fort-awesome',
		'forumbee' => 'fab fa-forumbee',
		'foursquare' => 'fab fa-foursquare',
		'free-code-camp' => 'fab fa-free-code-camp',
		'frown-o' => 'far fa-frown',
		'futbol-o' => 'far fa-futbol',
		'gbp' => 'fas fa-pound-sign',
		'ge' => 'fab fa-empire',
		'gear' => 'fas fa-cog',
		'gears' => 'fas fa-cogs',
		'get-pocket' => 'fab fa-get-pocket',
		'gg' => 'fab fa-gg',
		'gg-circle' => 'fab fa-gg-circle',
		'git' => 'fab fa-git',
		'git-square' => 'fab fa-git-square',
		'github' => 'fab fa-github',
		'github-alt' => 'fab fa-github-alt',
		'github-square' => 'fab fa-github-square',
		'gitlab' => 'fab fa-gitlab',
		'gittip' => 'fab fa-gratipay',
		'glass' => 'fas fa-glass-martini',
		'glide' => 'fab fa-glide',
		'glide-g' => 'fab fa-glide-g',
		'google' => 'fab fa-google',
		'google-plus' => 'fab fa-google-plus-g',
		'google-plus-circle' => 'fab fa-google-plus',
		'google-plus-official' => 'fab fa-google-plus',
		'google-plus-square' => 'fab fa-google-plus-square',
		'google-wallet' => 'fab fa-google-wallet',
		'gratipay' => 'fab fa-gratipay',
		'grav' => 'fab fa-grav',
		'group' => 'fas fa-users',
		'hacker-news' => 'fab fa-hacker-news',
		'hand-grab-o' => 'far fa-hand-rock',
		'hand-lizard-o' => 'far fa-hand-lizard',
		'hand-o-down' => 'far fa-hand-point-down',
		'hand-o-left' => 'far fa-hand-point-left',
		'hand-o-right' => 'far fa-hand-point-right',
		'hand-o-up' => 'far fa-hand-point-up',
		'hand-paper-o' => 'far fa-hand-paper',
		'hand-peace-o' => 'far fa-hand-peace',
		'hand-pointer-o' => 'far fa-hand-pointer',
		'hand-rock-o' => 'far fa-hand-rock',
		'hand-scissors-o' => 'far fa-hand-scissors',
		'hand-spock-o' => 'far fa-hand-spock',
		'hand-stop-o' => 'far fa-hand-paper',
		'handshake-o' => 'far fa-handshake',
		'hard-of-hearing' => 'fas fa-deaf',
		'hdd-o' => 'far fa-hdd',
		'header' => 'fas fa-heading',
		'heart-o' => 'far fa-heart',
		'hospital-o' => 'far fa-hospital',
		'hotel' => 'fas fa-bed',
		'hourglass-1' => 'fas fa-hourglass-start',
		'hourglass-2' => 'fas fa-hourglass-half',
		'hourglass-3' => 'fas fa-hourglass-end',
		'hourglass-o' => 'far fa-hourglass',
		'houzz' => 'fab fa-houzz',
		'html5' => 'fab fa-html5',
		'id-badge' => 'far fa-id-badge',
		'id-card-o' => 'far fa-id-card',
		'ils' => 'fas fa-shekel-sign',
		'image' => 'far fa-image',
		'imdb' => 'fab fa-imdb',
		'inr' => 'fas fa-rupee-sign',
		'instagram' => 'fab fa-instagram',
		'institution' => 'fas fa-university',
		'internet-explorer' => 'fab fa-internet-explorer',
		'intersex' => 'fas fa-transgender',
		'ioxhost' => 'fab fa-ioxhost',
		'joomla' => 'fab fa-joomla',
		'jpy' => 'fas fa-yen-sign',
		'jsfiddle' => 'fab fa-jsfiddle',
		'keyboard-o' => 'far fa-keyboard',
		'krw' => 'fas fa-won-sign',
		'lastfm' => 'fab fa-lastfm',
		'lastfm-square' => 'fab fa-lastfm-square',
		'leanpub' => 'fab fa-leanpub',
		'legal' => 'fas fa-gavel',
		'lemon-o' => 'far fa-lemon',
		'level-down' => 'fas fa-level-down-alt',
		'level-up' => 'fas fa-level-up-alt',
		'life-bouy' => 'far fa-life-ring',
		'life-buoy' => 'far fa-life-ring',
		'life-ring' => 'far fa-life-ring',
		'life-saver' => 'far fa-life-ring',
		'lightbulb-o' => 'far fa-lightbulb',
		'line-chart' => 'fas fa-chart-line',
		'linkedin' => 'fab fa-linkedin-in',
		'linkedin-square' => 'fab fa-linkedin',
		'linode' => 'fab fa-linode',
		'linux' => 'fab fa-linux',
		'list-alt' => 'far fa-list-alt',
		'long-arrow-down' => 'fas fa-long-arrow-alt-down',
		'long-arrow-left' => 'fas fa-long-arrow-alt-left',
		'long-arrow-right' => 'fas fa-long-arrow-alt-right',
		'long-arrow-up' => 'fas fa-long-arrow-alt-up',
		'mail-forward' => 'fas fa-share',
		'mail-reply' => 'fas fa-reply',
		'mail-reply-all' => 'fas fa-reply-all',
		'map-marker' => 'fas fa-map-marker-alt',
		'map-o' => 'far fa-map',
		'maxcdn' => 'fab fa-maxcdn',
		'meanpath' => 'fab fa-font-awesome',
		'medium' => 'fab fa-medium',
		'meetup' => 'fab fa-meetup',
		'meh-o' => 'far fa-meh',
		'minus-square-o' => 'far fa-minus-square',
		'mixcloud' => 'fab fa-mixcloud',
		'mobile' => 'fas fa-mobile-alt',
		'mobile-phone' => 'fas fa-mobile-alt',
		'modx' => 'fab fa-modx',
		'money' => 'far fa-money-bill-alt',
		'moon-o' => 'far fa-moon',
		'mortar-board' => 'fas fa-graduation-cap',
		'navicon' => 'fas fa-bars',
		'newspaper-o' => 'far fa-newspaper',
		'object-group' => 'far fa-object-group',
		'object-ungroup' => 'far fa-object-ungroup',
		'odnoklassniki' => 'fab fa-odnoklassniki',
		'odnoklassniki-square' => 'fab fa-odnoklassniki-square',
		'opencart' => 'fab fa-opencart',
		'openid' => 'fab fa-openid',
		'opera' => 'fab fa-opera',
		'optin-monster' => 'fab fa-optin-monster',
		'pagelines' => 'fab fa-pagelines',
		'paper-plane-o' => 'far fa-paper-plane',
		'paste' => 'far fa-clipboard',
		'pause-circle-o' => 'far fa-pause-circle',
		'paypal' => 'fab fa-paypal',
		'pencil' => 'fas fa-pencil-alt',
		'pencil-square' => 'fas fa-pen-square',
		'pencil-square-o' => 'far fa-edit',
		'photo' => 'far fa-image',
		'picture-o' => 'far fa-image',
		'pie-chart' => 'fas fa-chart-pie',
		'pied-piper' => 'fab fa-pied-piper',
		'pied-piper-alt' => 'fab fa-pied-piper-alt',
		'pied-piper-pp' => 'fab fa-pied-piper-pp',
		'pinterest' => 'fab fa-pinterest',
		'pinterest-p' => 'fab fa-pinterest-p',
		'pinterest-square' => 'fab fa-pinterest-square',
		'play-circle-o' => 'far fa-play-circle',
		'plus-square-o' => 'far fa-plus-square',
		'product-hunt' => 'fab fa-product-hunt',
		'qq' => 'fab fa-qq',
		'question-circle-o' => 'far fa-question-circle',
		'quora' => 'fab fa-quora',
		'ra' => 'fab fa-rebel',
		'ravelry' => 'fab fa-ravelry',
		'rebel' => 'fab fa-rebel',
		'reddit' => 'fab fa-reddit',
		'reddit-alien' => 'fab fa-reddit-alien',
		'reddit-square' => 'fab fa-reddit-square',
		'refresh' => 'fas fa-sync',
		'registered' => 'far fa-registered',
		'remove' => 'fas fa-times',
		'renren' => 'fab fa-renren',
		'reorder' => 'fas fa-bars',
		'repeat' => 'fas fa-redo',
		'resistance' => 'fab fa-rebel',
		'rmb' => 'fas fa-yen-sign',
		'rotate-left' => 'fas fa-undo',
		'rotate-right' => 'fas fa-redo',
		'rouble' => 'fas fa-ruble-sign',
		'rub' => 'fas fa-ruble-sign',
		'ruble' => 'fas fa-ruble-sign',
		'rupee' => 'fas fa-rupee-sign',
		's15' => 'fas fa-bath',
		'safari' => 'fab fa-safari',
		'scissors' => 'fas fa-cut',
		'scribd' => 'fab fa-scribd',
		'sellsy' => 'fab fa-sellsy',
		'send' => 'fas fa-paper-plane',
		'send-o' => 'far fa-paper-plane',
		'share-square-o' => 'far fa-share-square',
		'shekel' => 'fas fa-shekel-sign',
		'sheqel' => 'fas fa-shekel-sign',
		'shield' => 'fas fa-shield-alt',
		'shirtsinbulk' => 'fab fa-shirtsinbulk',
		'sign-in' => 'fas fa-sign-in-alt',
		'sign-out' => 'fas fa-sign-out-alt',
		'signing' => 'fas fa-sign-language',
		'simplybuilt' => 'fab fa-simplybuilt',
		'skyatlas' => 'fab fa-skyatlas',
		'skype' => 'fab fa-skype',
		'slack' => 'fab fa-slack',
		'sliders' => 'fas fa-sliders-h',
		'slideshare' => 'fab fa-slideshare',
		'smile-o' => 'far fa-smile',
		'snapchat' => 'fab fa-snapchat',
		'snapchat-ghost' => 'fab fa-snapchat-ghost',
		'snapchat-square' => 'fab fa-snapchat-square',
		'snowflake-o' => 'far fa-snowflake',
		'soccer-ball-o' => 'far fa-futbol',
		'sort-alpha-asc' => 'fas fa-sort-alpha-down',
		'sort-alpha-desc' => 'fas fa-sort-alpha-up',
		'sort-amount-asc' => 'fas fa-sort-amount-down',
		'sort-amount-desc' => 'fas fa-sort-amount-up',
		'sort-asc' => 'fas fa-sort-up',
		'sort-desc' => 'fas fa-sort-down',
		'sort-numeric-asc' => 'fas fa-sort-numeric-down',
		'sort-numeric-desc' => 'fas fa-sort-numeric-up',
		'soundcloud' => 'fab fa-soundcloud',
		'spoon' => 'fas fa-utensil-spoon',
		'spotify' => 'fab fa-spotify',
		'square-o' => 'far fa-square',
		'stack-exchange' => 'fab fa-stack-exchange',
		'stack-overflow' => 'fab fa-stack-overflow',
		'star-half-empty' => 'far fa-star-half',
		'star-half-full' => 'far fa-star-half',
		'star-half-o' => 'far fa-star-half',
		'star-o' => 'far fa-star',
		'steam' => 'fab fa-steam',
		'steam-square' => 'fab fa-steam-square',
		'sticky-note-o' => 'far fa-sticky-note',
		'stop-circle-o' => 'far fa-stop-circle',
		'stumbleupon' => 'fab fa-stumbleupon',
		'stumbleupon-circle' => 'fab fa-stumbleupon-circle',
		'sun-o' => 'far fa-sun',
		'superpowers' => 'fab fa-superpowers',
		'support' => 'far fa-life-ring',
		'tablet' => 'fas fa-tablet-alt',
		'tachometer' => 'fas fa-tachometer-alt',
		'telegram' => 'fab fa-telegram',
		'television' => 'fas fa-tv',
		'tencent-weibo' => 'fab fa-tencent-weibo',
		'themeisle' => 'fab fa-themeisle',
		'thermometer' => 'fas fa-thermometer-full',
		'thermometer-0' => 'fas fa-thermometer-empty',
		'thermometer-1' => 'fas fa-thermometer-quarter',
		'thermometer-2' => 'fas fa-thermometer-half',
		'thermometer-3' => 'fas fa-thermometer-three-quarters',
		'thermometer-4' => 'fas fa-thermometer-full',
		'thumb-tack' => 'fas fa-thumbtack',
		'thumbs-o-down' => 'far fa-thumbs-down',
		'thumbs-o-up' => 'far fa-thumbs-up',
		'ticket' => 'fas fa-ticket-alt',
		'times-circle-o' => 'far fa-times-circle',
		'times-rectangle' => 'fas fa-window-close',
		'times-rectangle-o' => 'far fa-window-close',
		'toggle-down' => 'far fa-caret-square-down',
		'toggle-left' => 'far fa-caret-square-left',
		'toggle-right' => 'far fa-caret-square-right',
		'toggle-up' => 'far fa-caret-square-up',
		'trash' => 'fas fa-trash-alt',
		'trash-o' => 'far fa-trash-alt',
		'trello' => 'fab fa-trello',
		'tripadvisor' => 'fab fa-tripadvisor',
		'try' => 'fas fa-lira-sign',
		'tumblr' => 'fab fa-tumblr',
		'tumblr-square' => 'fab fa-tumblr-square',
		'turkish-lira' => 'fas fa-lira-sign',
		'twitch' => 'fab fa-twitch',
		'twitter' => 'fab fa-twitter',
		'twitter-square' => 'fab fa-twitter-square',
		'unsorted' => 'fas fa-sort',
		'usb' => 'fab fa-usb',
		'usd' => 'fas fa-dollar-sign',
		'user-circle-o' => 'far fa-user-circle',
		'user-o' => 'far fa-user',
		'vcard' => 'fas fa-address-card',
		'vcard-o' => 'far fa-address-card',
		'viacoin' => 'fab fa-viacoin',
		'viadeo' => 'fab fa-viadeo',
		'viadeo-square' => 'fab fa-viadeo-square',
		'video-camera' => 'fas fa-video',
		'vimeo' => 'fab fa-vimeo-v',
		'vimeo-square' => 'fab fa-vimeo-square',
		'vine' => 'fab fa-vine',
		'vk' => 'fab fa-vk',
		'volume-control-phone' => 'fas fa-phone-volume',
		'warning' => 'fas fa-exclamation-triangle',
		'wechat' => 'fab fa-weixin',
		'weibo' => 'fab fa-weibo',
		'weixin' => 'fab fa-weixin',
		'whatsapp' => 'fab fa-whatsapp',
		'wheelchair-alt' => 'fab fa-accessible-icon',
		'wikipedia-w' => 'fab fa-wikipedia-w',
		'window-close-o' => 'far fa-window-close',
		'window-maximize' => 'far fa-window-maximize',
		'window-restore' => 'far fa-window-restore',
		'windows' => 'fab fa-windows',
		'won' => 'fas fa-won-sign',
		'wordpress' => 'fab fa-wordpress',
		'wpbeginner' => 'fab fa-wpbeginner',
		'wpexplorer' => 'fab fa-wpexplorer',
		'wpforms' => 'fab fa-wpforms',
		'xing' => 'fab fa-xing',
		'xing-square' => 'fab fa-xing-square',
		'y-combinator' => 'fab fa-y-combinator',
		'y-combinator-square' => 'fab fa-hacker-news',
		'yahoo' => 'fab fa-yahoo',
		'yc' => 'fab fa-y-combinator',
		'yc-square' => 'fab fa-hacker-news',
		'yelp' => 'fab fa-yelp',
		'yen' => 'fas fa-yen-sign',
		'yoast' => 'fab fa-yoast',
		'youtube' => 'fab fa-youtube',
		'youtube-play' => 'fab fa-youtube',
		'youtube-square' => 'fab fa-youtube-square',
	);

	$icon = str_replace( 'fa ', '', $icon );
	$icon = str_replace( 'fa-', '', $icon );

	return $icon = ! empty( $new[ $icon ] ) ? $new[ $icon ] : 'fas fa-'. $icon;
}



/**
 * Migrate menu icons, used in < Jannah 5.0
 * Called in the updates.php file
 */
function tie_fa4_to_fa5_menus(){

	$the_query = get_posts( array(
		'post_type'   => 'nav_menu_item',
		'meta_key'    => 'tie_megamenu_icon',
		'fields'      => 'ids',
		'numberposts' => -1
	));

	if( ! empty( $the_query ) ) {
		foreach ( $the_query as $menu_id ) {
			$old_icon = get_post_meta( $menu_id, 'tie_megamenu_icon', true );
			$new_icon = tie_fa4_to_fa5_value_migration( $old_icon );
			if( $old_icon != $new_icon ){
				update_post_meta( $menu_id, 'tie_megamenu_icon', $new_icon );
			}
		}
	}
}


/**
 * Migrate icons used in the builder, used in < Jannah 5.0
 * Called in the updates.php file
 */
function tie_fa4_to_fa5_builder(){

	$the_query = get_posts( array(
		'post_type'   => 'page',
		'meta_key'    => 'tie_page_builder',
		'fields'      => 'ids',
		'numberposts' => -1
	));

	if( ! empty( $the_query ) ) {

		foreach ( $the_query as $page_id ) {

			$update = false;
			$builder_contents = get_post_meta( $page_id, 'tie_page_builder', true );

			if( ! empty( $builder_contents ) && is_array( $builder_contents ) ){

				foreach ( $builder_contents as $section_id => $section ) {

					if( ! empty( $section['settings']['title_icon'] ) ){
						$old_icon = $section['settings']['title_icon'];
						$new_icon = tie_fa4_to_fa5_value_migration( $old_icon );

						if( $old_icon != $new_icon ){
							$builder_contents[ $section_id ]['settings']['title_icon'] = $new_icon;
							$update = true;
						}
					}

					if( ! empty( $section['blocks'] ) && is_array( $section['blocks'] ) ){
						foreach ( $section['blocks'] as $block_id => $block ) {

							if( ! empty( $block['icon'] ) ){
								$old_icon = $block['icon'];
								$new_icon = tie_fa4_to_fa5_value_migration( $old_icon );

								if( $old_icon != $new_icon ){
									$builder_contents[ $section_id ]['blocks'][ $block_id ]['icon'] = $new_icon;
									$update = true;
								}
							}
						}
					}
				}

				if( $update ){
					update_post_meta( $page_id, 'tie_page_builder', $builder_contents );
				}
			}
		}
	}
}


/**
 * Migrate icons used in the theme options page, used in < Jannah 5.0
 * Called in the updates.php file
 */
function tie_fa4_to_fa5_options(){
	$update     = false;
	$options_id = apply_filters( 'TieLabs/theme_options', '' );
	$options    = get_option( $options_id );

	if( empty( $options ) ){
		return;
	}

	for( $i = 1; $i <= 5; $i++ ){
		if( ! empty( $options[ 'custom_social_icon_'.$i ] ) ){
			$new_icon = tie_fa4_to_fa5_value_migration( $options[ 'custom_social_icon_'.$i ] );
			if( $options[ 'custom_social_icon_'.$i ] != $new_icon ){
				$options[ 'custom_social_icon_'.$i ] = $new_icon;
				$update = true;
			}
		}
	}

	if( $update ){
		update_option( $options_id, $options );
	}
}
