<?php
/**
 * NTS Frontend Page
 *
 *  @package NTS
 */

namespace NTS\Frontend;

use \WP_Error as WP_Error;

/**
 * Adding Shortcode support to render vote up/down count in frontend.
 *
 * @since      0.0.1
 * @package    NTS
 * @subpackage NTS/app/classes/Frontend
 * @author     Debabrata Karfa <im@deb.im>
 */
class Page {
	/**
	 * __construct function, running during init of Class.
	 */
	public function __construct() {
		add_filter( 'single_template', array( $this, 'nts_vote_template' ) );
		add_filter( 'display_vote_up_down', array( $this, 'display_vote_up_down_cb' ) );
	}

	/**
	 * NTS CPT template picker.
	 *
	 * @param  str $single Single template.
	 *
	 * @return str         Path of template.
	 */
	public function nts_vote_template( $single ) {
		global $post;

		/* Checks for single template by post type */
		if ( 'ntsvotes' === $post->post_type ) {
			if ( file_exists( NTS_PATH . '/templates/nts-cpt.php' ) ) {
				return NTS_PATH . '/templates/nts-cpt.php';
			}
		}

		return $single;
	}

	/**
	 * Cb for Display HTML output.
	 *
	 * @param  int $postId  Post ID.
	 *
	 * @return void         HTML response.
	 */
	public function display_vote_up_down_cb( $postId ) {

		$pollDetails = apply_filters( 'get_nts_vote_info_for_the_post', $postId );

		$return = '
			<div class="nts__vote">
				Total : <span id="pollTotal" class="nts__vote--total">' . $pollDetails['total'] . '</span>
				<a href="#" data-vote="positive" data-id="' . $postId . '" class="nts__vote__click nts__vote--positive"></a><span id="pCount">' . $pollDetails['positive'] . '</span>
				<a href="#" data-vote="negative" data-id="' . $postId . '" class="nts__vote__click nts__vote--negative"></a><span id="nCount">' . $pollDetails['negative'] . '</span>
			</div>
		';

		return $return;
	}
}
