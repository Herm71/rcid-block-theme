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
	 * @since RCID 1.0.0
	 *
	 * @return void
	 */
	function rcid_setup() {

		add_theme_support( 'wp-block-styles' );
		add_editor_style( 'build/index.css' );

/*
		* Load additional Core block styles.
		*/
		$styled_blocks = array( 'core/image', 'core/post-title', 'core/post-excerpt', 'core/navigation' );
		foreach ( $styled_blocks as $block ) {

			$name = explode('/', $block);
			$args = array(
				'handle' => "rcid-$name[1]",
				'src'    => get_theme_file_uri( "block-styles/$name[1].css" ),
				$args['path'] = get_theme_file_path( "wp-blocks/$name[1].css" ),
			);
			wp_enqueue_block_style( $block, $args );
		}
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
	wp_register_script( 'rcid-front', get_template_directory_uri() . '/build/theme.js', array(), wp_get_theme()->get( 'Version' ), true );
	wp_enqueue_script( 'rcid-front' );
	wp_enqueue_style( 'dashicons' );
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

