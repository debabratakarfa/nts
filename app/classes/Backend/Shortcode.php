<?php
/**
 * NTS Shortcode Rendering
 *
 *  @package NTS
 */

namespace NTS\Backend;

use \WP_Error as WP_Error;

/**
 * Adding Shortcode support to render vote up/down count in frontend.
 *
 * @since      0.0.1
 * @package    NTS
 * @subpackage NTS/app/classes/Backend
 * @author     Debabrata Karfa <im@deb.im>
 */
class Shortcode {
	/**
	 * __construct function, running during init of Class.
	 */
	public function __construct() {
		add_shortcode( 'nts_vote_display', array( $this, 'shortcode_register_nts_articles' ) );
	}

	/**
	 * Shortcode CB.
	 *
	 * @param array $atts Attribute Value.
	 *
	 * @return string HTML Output.
	 */
	public function shortcode_register_nts_articles( $atts ) {
		$renderHtml = apply_filters( 'display_vote_up_down', $atts['id'] );
		ob_start();
		echo $renderHtml;
		return ob_get_clean();
	}
}
