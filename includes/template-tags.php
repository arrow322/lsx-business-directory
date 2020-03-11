<?php
/**
 * LSX Business Directory template functions.
 *
 * @package lsx-business-directory
 */

/**
 * Retrieves post thumbnail and averts werid unexpected behaviour.
 * Could re-wrap here if needed.
 *
 * @package     lsx-business-directory
 * @subpackage  template-tags
 * @category    single
 *
 * @param       $id int
 * @param       $width int
 * @param       $height int
 */
function get_thumbnail_wrapped( $id, $width, $height ) {
	$image_src = 'https://placehold.it/' . (string) $width . 'x' . (string) $height;

	if ( has_post_thumbnail( $id ) ) {
		$image     = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
		$image_src = ( strpos( $image[0], 'cover-logo.png' ) === false ) ? $image[0] : $image_src;
	}

	return $image_src;
}

/**
 * Generates a comma seperated string from specified taxonomy.
 *
 * @package     lsx-business-directory
 * @subpackage  template-tags
 * @category    single
 *
 * @param       $id int
 * @param       $tax String
 */
function get_formatted_taxonomy_str( $id, $tax, $link = false ) {
	$terms     = wp_get_post_terms( $id, $tax );
	$terms_str = $link ? array() : '';

	if ( ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			if ( $link ) {
				$terms_str[] = array(
					'slug' => trim( $term->slug ),
					'name' => trim( $term->name ),
				);
			} else {
				$terms_str .= $term->name . ', ';
			}
		}

		if ( ! $link ) {
			$terms_str = substr( $terms_str, 0, strlen( $terms_str ) - 2 );
		}
	}

	if ( 'post_format' == $tax && '' == $terms_str ) {
		$terms_str = 'Standard';
	}

	return $terms_str;
}

/**
 * Helper function that loads a particular template.
 *
 * @param   String $filename_base  Name of a template to load.
 *
 * @return  void
 */
function lsx_business_template( $filename_base ) {
	if ( file_exists( get_stylesheet_directory() . '/templates/' . $filename_base . '.php' ) ) {
		include get_stylesheet_directory() . '/templates/' . $filename_base . '.php';
	} elseif ( file_exists( LSX_BD_PATH . 'templates/' . $filename_base . '.php' ) ) {
		include LSX_BD_PATH . 'templates/' . $filename_base . '.php';
	}
}

/**
 * Loads Related Business block teamplte.
 *
 * @return  void
 */
function lsx_related_business() {
	lsx_business_template( 'single-business-related-business' );
}

/**
 * Loads Business Template for Archive page for list layout.
 *
 * @return  void
 */
function lsx_business_row() {
	lsx_business_template( 'single-row-business' );
}

/**
 * Loads Business Template for Archive page for grid layout.
 *
 * @return  void
 */
function lsx_business_col() {
	lsx_business_template( 'single-col-business' );
}
