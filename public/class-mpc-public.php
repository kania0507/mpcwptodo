<?php
require_once( ABSPATH . '/wp-includes/shortcodes.php' );
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://seowp.pl
 * @since      1.0.0
 *
 * @package    mpc
 * @subpackage mpc/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    mpc
 * @subpackage mpc/public
 * @author     AKC <akaszubacybulska@gmail.com>
 */
class mpc_Public {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mpc-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mpc-public.js', array( 'jquery' ), $this->version, false );

	}
	
	
	
	/* shortcode - print tasks on front page */
	public function mpc_printtasks( $content  ) {
		
		$args = array( 
		  'numberposts'		=> -1, // -1 is for all
		  'post_type'		=> 'task',
		  'orderby' 		=> 'title', // or 'date', 'rand'
		  'order' 		=> 'ASC', // or 'DESC'
		  
		); 

		// Get my custom posts
		$myposts = get_posts($args); 

		$content='<h2>Task list</h2>';
		for($i=0; $i<count($myposts); $i++){
			$content.='<p class="task_list">'.$myposts[$i]->post_title.'</p>'; 
		}
		 
		return  $content;
	}
	
	
	
	
	

}
