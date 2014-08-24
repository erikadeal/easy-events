<?php
/* Instantiate custom post type for events */

class Easy_Events_Post_Type {

	const POST_TYPE	= "easy-events";
	
	public function __construct() {
		add_action('init', array(&$this, 'init'));
		add_action('admin_init', array(&$this, 'init'));
		add_action('admin_menu', array(&$this, 'admin_menu'));
	}

	public function init() {
		$this->register_events_type();
		add_action('save_post', array(&$this, 'save_post'));
	}

	public function register_events_type() {
		$labels = array(
			'name'                => _x( 'Events', 'Post Type General Name', 'text_domain' ),
			'singular_name'       => _x( 'Event', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'           => __( 'Events', 'text_domain' ),
			'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
			'all_items'           => __( 'All Events', 'text_domain' ),
			'view_item'           => __( 'View Event', 'text_domain' ),
			'add_new_item'        => __( 'Add New Event', 'text_domain' ),
			'add_new'             => __( 'Add New', 'text_domain' ),
			'edit_item'           => __( 'Edit Event', 'text_domain' ),
			'update_item'         => __( 'Update Event', 'text_domain' ),
			'search_items'        => __( 'Search Events', 'text_domain' ),
			'not_found'           => __( 'Not found', 'text_domain' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
		);

		$rewrite = array(
			'slug'                => 'events',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		);

		$args = array(
			'label'               => __( 'easy-events' ),
			'description'         => __( 'Simple, no-nonsense events' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', ),
			'taxonomies'          => array( 'category', 'post_tag' ),
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
			'rewrite'             => $rewrite,
			'capability_type'     => 'page',
		);

		register_post_type( 
			self::POST_TYPE,
			$args 
		);

	}


	public function save_post($post_id) {

		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		
		if($_POST['easy-events'] == self::POST_TYPE && current_user_can('edit_post', $post_id)) {
			foreach($this->_meta as $field_name) {
				update_post_meta($post_id, $field_name, $_POST[$field_name]);
			}
		}
		
		else {
			return;
		}
	}
}

?>