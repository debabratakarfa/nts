<?php
/**
 * NTS CPT Registering
 *
 *  @package Rippling
 */

namespace NTS\Backend;

use \WP_Error as WP_Error;

/**
 * Registering Metabox.
 *
 * @since      0.0.1
 * @package    NTS
 * @subpackage NTS/app/classes/Backend
 * @author     Debabrata Karfa <im@deb.im>
 */
class Metabox {
	/**
	 * __construct function, running during init of Class.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'metabox_register_nts_articles' ) );
	}

	/**
	 * Registering Votes Details meta box.
	 *
	 * @return void Register Metabox.
	 */
	public function metabox_register_nts_articles() {
		add_meta_box(
			'votes-details',
			__( 'Votes Details', 'nts' ),
			array( $this, 'vote_details_meta_box_callback' ),
			'ntsvotes'
		);
	}

	/**
	 * Display Metabox.
	 *
	 * @return void Display Metabox.
	 */
	public function vote_details_meta_box_callback() {

		global $post;

		$pollDetails = apply_filters( 'get_nts_vote_info_for_the_post', $post->ID );

		echo 'Total Vote: <input type="text" name="input" value="' . $pollDetails['total'] . '" readonly>';
		echo 'Total Positive Vote: <input type="text" name="input" value="' . $pollDetails['positive'] . '" readonly>';
		echo 'Total Negative Vote: <input type="text" name="input" value="' . $pollDetails['negative'] . '" readonly>';

	}

}
