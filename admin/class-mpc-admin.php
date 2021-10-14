<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://seowp.pl
 * @since      1.0.0
 *
 * @package    mpc
 * @subpackage mpc/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    mpc
 * @subpackage mpc/admin
 * @author     AKC <akaszubacybulska@gmail.com>
 */
class mpc_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	
	/* CPT */
	private $cpt;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->cpt = 'task';
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('admin_menu', array( $this, 'addPluginAdminMenu' ), 9);   
		add_action('admin_init', array( $this, 'registerAndBuildFields' ));
		 
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in mpc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The mpc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'custom-font', "//fonts.googleapis.com/css?family=Open+Sans");

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mpc-admin.css', array(), $this->version, 'all' ); 
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in mpc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The mpc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */ 

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mpc-admin.js', array( 'jquery' ), $this->version, false ); 
	}  

	/* localize script */
	/*
	function localize_ajax_script() {
		wp_register_script( 'ajax_script', plugin_dir_url( __FILE__ ) . 'js/mpc-admin.js', array('jquery') );
		wp_enqueue_script( 'ajax_script');
		wp_localize_script( 'ajax_script', 'my_ajax_object', array('ajaxUrl' => admin_url('admin-ajax.php'))); 
	} 
	*/
	
	/**
	 * Adding Admin Menu 
	 * */
	public function addPluginAdminMenu() {
		// top menu 
		add_menu_page( 'Tasks', 'Tasks', 'administrator', $this->plugin_name, array( $this, 'displayPluginAdminDashboard' ), 'dashicons-chart-area', 26 ); 
	}

	/**
	 * Adding Admin Page 
	 * */
	public function displayPluginAdminDashboard() { 
		require_once 'partials/'.$this->plugin_name.'-admin-display.php';
	}

	public function displayPluginAdminSettings() {
		// set this var to be used in the settings-display view
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
		if(isset($_GET['error_message'])){
			add_action('admin_notices', array($this,'pluginNameSettingsMessages'));
			do_action( 'admin_notices', $_GET['error_message'] );
		}
		require_once 'partials/'.$this->plugin_name.'-admin-settings-display.php';
	}

	public function pluginNameSettingsMessages($error_message){
		switch ($error_message) {
			case '1':
				$message = __( 'There was an error adding this setting. Please try again.  If this persists, shoot us an email.', 'my-text-domain' );                 
				$err_code = esc_attr( 'plugin_name_example_setting' );                 
				$setting_field = 'plugin_name_example_setting';                 
				break;
		}
		$type = 'error';
		add_settings_error(
			   $setting_field,
			   $err_code,
			   $message,
			   $type
		   );
	}

	public function registerAndBuildFields() {
		/**
	   * First, we add_settings_section. This is necessary since all future settings must belong to one.
	   * Second, add_settings_field
	   * Third, register_setting
	   */     
		add_settings_section(
		 // ID used to identify this section and with which to register options
		 'plugin_name_general_section', 
		 // Title to be displayed on the administration page
		 '',  
		 // Callback used to render the description of the section
		  array( $this, 'plugin_name_display_general_account' ),    
		 // Page on which to add this section of options
		 'plugin_name_general_settings'                   
	   );
	   unset($args);
	   $args = array (
				 'type'      => 'input',
				 'subtype'   => 'text',
				 'id'    => 'plugin_name_example_setting',
				 'name'      => 'plugin_name_example_setting',
				 'required' => 'true',
				 'get_options_list' => '',
				 'value_type'=>'normal',
				 'wp_data' => 'option'
			 );
	   add_settings_field(
		 'plugin_name_example_setting',
		 'Example Setting',
		 array( $this, 'plugin_name_render_settings_field' ),
		 'plugin_name_general_settings',
		 'plugin_name_general_section',
		 $args
	   ); 

	   register_setting(
			   'plugin_name_general_settings',
			   'plugin_name_example_setting'
			   ); 
	}


	public function plugin_name_display_general_account() {
		echo '<p>These settings apply to all Plugin Name functionality.</p>';
	} 

	public function plugin_name_render_settings_field($args) {
	    
		if($args['wp_data'] == 'option'){
		   $wp_data_value = get_option($args['name']);
		} elseif($args['wp_data'] == 'post_meta'){
		   $wp_data_value = get_post_meta($args['post_id'], $args['name'], true );
		}

		switch ($args['type']) {

		   case 'input':
			   $value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;
			   if($args['subtype'] != 'checkbox'){
				   $prependStart = (isset($args['prepend_value'])) ? '<div class="input-prepend"> <span class="add-on">'.$args['prepend_value'].'</span>' : '';
				   $prependEnd = (isset($args['prepend_value'])) ? '</div>' : '';
				   $step = (isset($args['step'])) ? 'step="'.$args['step'].'"' : '';
				   $min = (isset($args['min'])) ? 'min="'.$args['min'].'"' : '';
				   $max = (isset($args['max'])) ? 'max="'.$args['max'].'"' : '';
				   if(isset($args['disabled'])){
					   // hide the actual input bc if it was just a disabled input the informaiton saved in the database would be wrong - bc it would pass empty values and wipe the actual information
					   echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'_disabled" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'_disabled" size="40" disabled value="' . esc_attr($value) . '" /><input type="hidden" id="'.$args['id'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
				   } else {
					   echo $prependStart.'<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
				   }
				   

			   } else {
				   $checked = ($value) ? 'checked' : '';
				   echo '<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" name="'.$args['name'].'" size="40" value="1" '.$checked.' />';
			   }
			   break;
		   default:
			   # code...
			   break;
		}
	}  

	// Create custom post type $cpt_name
	public function create_posttype() {
	 
	 $labels = array(
			'name'                  => _x( 'Tasks', 'Post Type General Name', 'text_domain' ),
			'singular_name'         => _x( 'Task', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( 'Tasks', 'text_domain' ),
			'name_admin_bar'        => __( 'Tasks', 'text_domain' ),
			);
		$args = array(
			'label'                 => __( 'Task', 'text_domain' ),
			'description'           => __( 'Task desc', 'text_domain' ),
			'labels'                => $labels,
			'supports'              => array( 'title'), // 'editor', 'post-formats','page-attributes', 'custom-fields' ), 
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => false,
			'menu_position'         => 5,
			'show_in_admin_bar'     => false, //
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			//'capabilities'        => array(  'publish_posts'       => 'publish_partners'),
			'capability_type'       => 'page',
			'publicly_queryable' => true,
			'query_var' => false,
			'rewrite' => true,
			'register_meta_box_cb' => array($this, 'mpc_register_meta_boxes')
		);
		
		register_post_type( $this->cpt,  $args ); 
	}
	

	public function mpc_register_meta_boxes( $post ){
		add_meta_box( 'gchecked', __( 'Task completed?', 'textdomain' ), array($this, 'mpc_custom_meta_box_html_output'), $this->cpt, 'normal', 'low' );
	}

	/* Displayed when adding new task/CPT */
	public function mpc_custom_meta_box_html_output( $post ) {
		global $post;
		
		 wp_nonce_field( basename( __FILE__ ), 'mpc_custom_meta_box_nonce' );
		 
		 $d= get_post_meta($post->ID);
		 if ( !empty($d['is_checked'][0] ) ) $ch = 'checked'; else $ch = '';
		 
		 echo '<p><input type="checkbox" name="is_checked" value="checked" '.$ch.'/></p>';
	}
 
 
	/* update task box checked/unchecked */
	public function mpc_save_meta_boxes_data( )
	{  
		$post_id = $_POST['id'];
		$field = $_POST['field']; 

		if ( ! current_user_can( 'edit_post', $post_id ) ){
			return;
		}  
		
		$permission = check_ajax_referer( 'mpc_custom_meta_box_nonce', 'nonce', false );
		if( $permission == false ) {
			echo 'error';
		}
		else { 
 
			if (  isset($field) && $field!='' ) {
				delete_post_meta($post_id, 'is_checked');
				
			} else
				add_post_meta( $post_id, 'is_checked', 'checked' );
				//update_post_meta( $post_id, 'is_checked', 'checked');  
		}
		
		die();
		 
	}
	
	/* add new task */
	public function mpc_save_new_post(  )
	{
		$user_id = get_current_user_id();
		$args = array( 
		 'post_title'    =>  sanitize_text_field($_POST['title']),  
		 'post_status'   => 'publish',
		 'post_type' => $this->cpt, 
		);  

		$permission = check_ajax_referer( 'mpc_new_post_nonce', 'nonce', false );
		if( $permission == false ) {
			echo 'error';
		}
		else {

			$post_id = wp_insert_post( $args, $errors );  
			
			if ( $_POST['is_checked']!='' )
				add_post_meta( $post_id, 'is_checked', $_POST['is_checked'], true);

		} 
	
		die();    
	}

	
	/* update post title */ 
	public function mpc_update_post( )  
	{
		//$user_id = get_current_user_id(); 
		$args = array(
		 'ID' => $_POST['id'],
		 'post_title'    => sanitize_text_field($_POST['title']),
		// 'post_status'   => 'publish',
		// 'post_type'	=> $this->cpt
		);  

		$permission = check_ajax_referer( 'my_edit_post_nonce', 'nonce', false );
		if( $permission == false ) {
			echo 'error';
		}
		else {

			$post_ID = wp_update_post( $args, true ); 
		}
		 
		//  update_post_meta( $post_id, $meta_key, $meta_value, $prev_value );  
		 
		die();  
	}


	/* Delete task  */
	public function mpc_delete_post(){

		$post_id = $_REQUEST['id'];
	 
		$permission = check_ajax_referer( 'mpc_delete_post_nonce', 'nonce', false );
		if( $permission == false ) {
			//echo 'error';
		}
		else {
			// delete post
			wp_delete_post( $post_id, false ); 

			// delete post meta
			delete_post_meta($post_id, 'is_checked');
		}
	 
		die();
 
	}
	
	
}
