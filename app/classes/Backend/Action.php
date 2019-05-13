<?php
/**
 * NTS CPT Registering
 *
 *  @package Rippling
 */

namespace NTS\Backend;

use \WP_Error as WP_Error;

/**
 * Ajax Action.
 *
 * @since      0.0.1
 * @package    NTS
 * @subpackage NTS/app/classes/Backend
 * @author     Debabrata Karfa <im@deb.im>
 */
class Action {
	/**
	 * __construct function, running during init of Class.
	 */
	public function __construct() {
		add_filter( 'get_nts_vote_info_for_the_post', array( $this, 'get_nts_vote_info_for_the_post_cb' ) );
		add_action( 'wp_ajax_nts_ajax_request', array( $this, 'nts_ajax_request_cb' ) );
		add_action( 'wp_ajax_nopriv_nts_ajax_request', array( $this, 'nts_ajax_request_cb' ) );
	}

	/**
	 * Action to get details of poll of this post id,
	 * i.e. postive, negative and total count.
	 *
	 * @param int $postId Post ID.
	 *
	 * @return array $response Return array of response with postive, negative and total count.
	 */
	public function get_nts_vote_info_for_the_post_cb( $postId ) {
		$totelVoteCount = 0;

		$pValue         = get_post_meta( $postId, '_nts_vote_postive', true ) ? get_post_meta( $postId, '_nts_vote_postive', true ) : 0;
		$nValue         = get_post_meta( $postId, '_nts_vote_negative', true ) ? get_post_meta( $postId, '_nts_vote_negative', true ) : 0;
		$totelVoteCount = $pValue + $nValue;

		$response = [
			'positive' => $pValue,
			'negative' => $nValue,
			'total'    => $totelVoteCount,
		];

		return $response;
	}

	/**
	 * Manage Ajax request and response.
	 *
	 * @return array Ajax response.
	 */
	public function nts_ajax_request_cb() {

		// The $_REQUEST contains all the data sent via ajax.
		if ( isset( $_REQUEST ) ) {

			$id          = wp_unslash( $_REQUEST['id'] );
			$type        = wp_unslash( $_REQUEST['type'] );
			$pollDetails = apply_filters( 'get_nts_vote_info_for_the_post', $id );
			$total       = $pollDetails['total'];

			if ( $type === 'positive' ) {
				$post_meta_name = '_nts_vote_postive';
				$metaValue      = $pollDetails['positive'];
			} elseif ( $type === 'negative' ) {
				$post_meta_name = '_nts_vote_negative';
				$metaValue      = $pollDetails['negative'];
			}

			$currentMetaValue = $metaValue + 1;
			update_post_meta( $id, $post_meta_name, $currentMetaValue );

			// Now we'll return it to the javascript function
			// Anything outputted will be returned in the response.
			$response = array(
				'type'  => $type,
				'count' => $currentMetaValue,
				'total' => $total + 1,
			);

			wp_send_json_success( $response );

		}

		// Always die in functions echoing ajax content.
		die();

	}

}
