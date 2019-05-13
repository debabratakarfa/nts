<?php
/**
 * NTS CPT Registering
 *
 *  @package Rippling
 */

namespace NTS\Backend;

use \WP_Error as WP_Error;

/**
 * Registering CPT.
 *
 * @since      0.0.1
 * @package    NTS
 * @subpackage NTS/app/classes/Backend
 * @author     Debabrata Karfa <im@deb.im>
 */
class CPT {
	/**
	 * __construct function, running during init of Class.
	 */
	public function __construct() {
		add_action( 'nts_init', array( $this, 'cpt_register_nts_articles' ), 11 );
	}

	/**
	 * Registering NTS Articles CPT.
	 *
	 * @return void Register CPT.
	 */
	public function cpt_register_nts_articles() {

		// Set UI labels for Custom Post Type.
		$labels = array(
			'name'               => _x( 'NTS Votes', 'Post Type General Name', 'nts' ),
			'singular_name'      => _x( 'NTS Vote', 'Post Type Singular Name', 'nts' ),
			'menu_name'          => __( 'NTS Votes', 'nts' ),
			'parent_item_colon'  => __( 'Parent NTS Vote', 'nts' ),
			'all_items'          => __( 'All NTS Votes', 'nts' ),
			'view_item'          => __( 'View NTS Vote', 'nts' ),
			'add_new_item'       => __( 'Add New NTS Vote', 'nts' ),
			'add_new'            => __( 'Add New', 'nts' ),
			'edit_item'          => __( 'Edit NTS Vote', 'nts' ),
			'update_item'        => __( 'Update NTS Vote', 'nts' ),
			'search_items'       => __( 'Search NTS Vote', 'nts' ),
			'not_found'          => __( 'Not Found', 'nts' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'nts' ),
		);

		// Set other options for Custom Post Type.
		$args = array(
			'label'               => __( 'NTS Votes', 'nts' ),
			'description'         => __( 'NTS vote for content', 'nts' ),
			'labels'              => $labels,
			// Features this CPT supports in Post Editor.
			'supports'            => array( 'title', 'author', 'thumbnail', 'revisions' ),
			'taxonomies'          => array( '' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);

		// Registering your Custom Post Type.
		register_post_type( 'NTS Votes', $args );

	}

}
