<?php
 
class Easy_Events {
 
    protected $loader;
 
    protected $plugin_slug;
 
    protected $version;

    protected $easy_events_post_type;
 
    public function __construct() {
 
        $this->plugin_slug = 'easy-events';
        $this->version = '0.2.0';
 
        $this->load_dependencies();
        $this->define_admin_hooks();
 
    }
 
    private function load_dependencies() {

        require_once plugin_dir_path( __FILE__ ) . 'class-easy-events-post-type.php';
        $this->easy_events_post_type = new Easy_Events_Post_Type();
 
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-easy-events-admin.php';
 
        require_once plugin_dir_path( __FILE__ ) . 'class-easy-events-loader.php';
        $this->loader = new Easy_Events_Loader();
 
    }
 
    private function define_admin_hooks() {
 
        $admin = new Easy_Events_Admin( $this->get_version() );
        $this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles' );
        //$this->loader->add_action( 'add_meta_boxes', $admin, 'add_meta_box' );
 
    }
 
    public function run() {
        $this->loader->run();
    }
 
    public function get_version() {
        return $this->version;
    }
 
}

?>