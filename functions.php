<?php
/**
 * RCID functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package RCID
 * @since RCID 1.0.0
 */

if ( ! function_exists( 'rcid_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since UCSC 1.0.0
	 *
	 * @return void
	 */
	function rcid_setup() {

		add_theme_support( 'wp-block-styles' );
		add_editor_style( 'build/style-index.css' );

		/**
		 * Include ThemeHybrid/HyridBreadcrumbs Class
		 * see: https://github.com/themehybrid/hybrid-breadcrumbs
		 * and https://themehybrid.com/weblog/integrating-hybrid-breadcrumbs-into-wordpress-themes
		 */
		if ( file_exists( get_parent_theme_file_path( 'vendor/autoload.php' ) ) ) {
			include_once get_parent_theme_file_path( 'vendor/autoload.php' );
		}
	}
endif;
add_action( 'after_setup_theme', 'rcid_setup' );

/**
 * Enqueue theme scripts and styles.
 */
function rcid_scripts() {

	wp_enqueue_style( 'rcid-styles', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_style( 'rcid-styles-scss', get_template_directory_uri() . '/build/index.css', array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_style( 'rcid-google-lato-font', 'https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap', false );

}
add_action( 'wp_enqueue_scripts', 'rcid_scripts' );



/**
 * Enqueue additional Google Font Scripts
 */
function rcid_googleapi_scripts() {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action( 'wp_head', 'rcid_googleapi_scripts' );

/**
 * Breadcrumbs constructor callback helper
 *
 * @return string
 */
function rcid_breadcrumbs_constructor() {
	$labels = array(
		'title' => '',
	);
	$args   = array(
		'labels'         => $labels,
		'show_on_front'  => true,
		'show_trail_end' => false,
	);
	return Hybrid\Breadcrumbs\Trail::render( $args );
}

/**
 * Add Breadcrumbs above Post Title.
 *
 * @param  string $block_content Block content to be rendered.
 * @param  array  $block         Block attributes.
 * @return string
 */
function rcid_add_breadcrumbs( $block_content = '', $block = array() ) {
	if ( rcid_breadcrumbs_constructor() ) {
		$breadcrumbs = rcid_breadcrumbs_constructor();
	}
	if ( is_singular() && isset( $breadcrumbs ) ) {
		if ( isset( $block['blockName'] ) && 'core/post-title' === $block['blockName'] ) {
			if ( isset( $block['attrs']['level'] ) && isset( $block['attrs']['className'] ) && $block['attrs']['className'] === 'primary-post-title' ) {
				$html = str_replace( $block_content, $breadcrumbs . $block_content, $block_content );
				return $html;
			}
		}
	}
	return $block_content;
}
add_filter( 'render_block', 'rcid_add_breadcrumbs', 10, 2 );
