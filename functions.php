<?php
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
		$breadcrumbs = ucsc_breadcrumbs_constructor();
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
// add_filter( 'render_block', 'rcid_add_breadcrumbs', 10, 2 );