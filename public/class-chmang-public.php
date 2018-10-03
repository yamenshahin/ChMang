<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/yamenshahin/
 * @since      1.0.0
 *
 * @package    Chmang
 * @subpackage Chmang/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Chmang
 * @subpackage Chmang/public
 * @author     Yamen Shahin <yamenshahin@gmail.com>
 */
require_once( ABSPATH . "wp-includes/pluggable.php" );
class Chmang_Public {

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
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $user     The current user    
	 */
	private $user;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $user_id     The current user id    
	 */
	private $user_id;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $user_roles     The current user role    
	 */
	private $user_roles;

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
		if( is_user_logged_in() ) {
			$this->user = wp_get_current_user();
			$this->user_id = get_current_user_id();
			$this->user_roles = $this->user->roles;
		}
		
		add_filter( 'page_template', array( $this, 'chmang_page_template' ) );
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
		 * defined in Chmang_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chmang_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/chmang-public.css', array(), $this->version, 'all' );

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
		 * defined in Chmang_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chmang_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/chmang-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'chmang_bootstrap-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
		/**
		* Add ajax_url to front-end.
		*
		* @since    1.0.0
		*/
		wp_localize_script( $this->plugin_name, 'frontend_ajax_url', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	}

	/**
	* Add page templates for "donor dashboard" and "employee dashboard".
	*
	* @since    1.0.0
	*/
	public function chmang_page_template( $page_template )
	{
		if ( is_page( 'donor-dashboard' ) ) {
			$page_template = plugin_dir_path( __FILE__ ) . 'partials/donor-public-display.php';
		} elseif ( is_page( 'employee-dashboard' ) ) {
			$page_template = plugin_dir_path( __FILE__ ) . 'partials/employee-public-display.php';
		}
		return $page_template;
	}

	/**
	* Get donor history.
	*
	* @since    1.0.0
	*/
	public function chmang_get_donor_history()
	{
		global $wpdb;
		$table_charitable_donors = $wpdb->prefix . 'charitable_donors';
		$table_charitable_campaign_donations = $wpdb->prefix . 'charitable_campaign_donations';
		$table_posts =  $wpdb->prefix . 'posts';
		$donations = $wpdb->get_results("SELECT 
		`donation_id`, `campaign_name`, `amount`, $table_posts.`post_modified` 
		FROM $table_charitable_campaign_donations 
		INNER JOIN $table_charitable_donors
		ON $table_charitable_donors.`donor_id` =  $table_charitable_campaign_donations.`donor_id`
		INNER JOIN $table_posts
		ON $table_posts.`ID` =  $table_charitable_campaign_donations.`donation_id`
		WHERE `post_status` LIKE 'charitable-completed'", ARRAY_A);
		
		$html = '';
		foreach ($donations as $donation) {
			$html .= 
			"<tr>
				<td>${donation['campaign_name']}</td>
				<td>${donation['amount']}</td>
				<td>${donation['post_modified']}</td>
			</tr>";
		}
		return $html  ;
	}

	
}
/**
* Add new campaign post.
*
* @since    1.0.0
*/
add_action( 'wp_ajax_chmang_add_campaign_post', 'chmang_add_campaign_post' );
add_action( 'wp_ajax_nopriv_chmang_add_campaign_post', 'chmang_add_campaign_post' );
function chmang_add_campaign_post() 
{
	
	$post = array(
		'post_title'	=> $_POST['title'],
		'post_content'	=> $_POST['content'],
		'tax_input' => $custom_tax,
		'post_status'	=> 'publish',
		'post_type'	=> 'campaign',
		'meta_input' => array(
			'_campaign_description' => $_POST['content'],
			'project_number' => $_POST['project_number'],
			'order' => $_POST['order'],
			'price_in_dirhams' => $_POST['price_in_dirhams'],
			'price_in_francs' => $_POST['price_in_francs'],
			'completion_rate' => $_POST['completion_rate'],
			'project_supervisor' => $_POST['project_supervisor'],
			'contract_price' => $_POST['contract_price'],
			'first_installment' => $_POST['first_installment'],
			'second_installment' => $_POST['second_installment'],
			'third_installment' => $_POST['third_installment'],
			'total_installment' => $_POST['total_installment']
		)
	);
	$post_id = wp_insert_post($post);
	wp_set_object_terms( $post_id, $_POST['category'], 'campaign_category' );
	echo $post_id ;
	wp_die();
}