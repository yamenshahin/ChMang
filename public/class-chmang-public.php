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
		} elseif ( is_page( 'edit-campaign' ) ) {
			$page_template = plugin_dir_path( __FILE__ ) . 'partials/employee-edit-public-display.php';
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

/**
* Edit/Update new campaign post.
*
* @since    1.0.0
*/
add_action( 'wp_ajax_chmang_edit_campaign_post', 'chmang_edit_campaign_post' );
add_action( 'wp_ajax_nopriv_chmang_edit_campaign_post', 'chmang_edit_campaign_post' );
function chmang_edit_campaign_post() 
{
	
	$post = array(
		'ID' => $_POST['post_id'],
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
	$my_post = array(
		'ID'           => 260,
		'post_title'   => 'This is the post title.',
		'post_content' => 'This is the updated content.',
	);
	wp_update_post($post);
	wp_set_object_terms( $_POST['post_id'], $_POST['category'], 'campaign_category' );
	wp_die();
}

/**
 * Result content HTML layout.
 *
 * @since      1.0.0
 */
function result_content($project_number_search = NULL, $title_search = NULL, $category_search = NULL, $order_search = NULL, $completion_rate_search = NULL, $project_supervisor_search = NULL) {
	$args = array(
		'posts_per_page'   => -1,
		'title' => $title_search,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'post_type'        => 'campaign',
		'post_status'      => 'publish',	
	);
	$posts_array = get_posts( $args );

	$content = '';
	if($posts_array) {
		foreach($posts_array as $post) : setup_postdata( $post );
			$terms = wp_get_post_terms( $post->ID, 'campaign_category' );
			$single_term = $terms[0]->name;
			/**
			 * Filter results.
			 *
			 * @since      1.0.0
			 */
			
			if ( ($post->project_number === $project_number_search || !$project_number_search) 
			&&  ($single_term === $category_search || !$category_search) 
			&&  ($post->order === $order_search || !$order_search)
			&&  ($post->completion_rate === $completion_rate_search || !$completion_rate_search)
			&&  ($post->project_supervisor === $project_supervisor_search || !$project_supervisor_search) ) {
				$content .= 
					"<tr>
						<td><a href='${_SERVER['REQUEST_URI']}edit-campaign/?postID=$post->ID'>تعديل</a></td>
						<td>$post->project_number</td>
						<td>$post->post_title</td>
						<td>$single_term</td>
						<td>$post->order</td>
						<td>$post->price_in_dirhams</td>
						<td>$post->price_in_francs</td>
						<td>$post->completion_rate</td>
						<td>$post->project_supervisor</td>
						<td>$post->contract_price</td>
						<td>$post->first_installment</td>
						<td>$post->first_installment</td>
						<td>$post->third_installment</td>
						<td>$post->total_installment</td>
					</tr>"
				;
			}

		endforeach;
	}
	//return $content;
	return $content ;
    
}

/**
 * Fetch result by ajax.
 *
 * @since      1.0.0
 */
add_action( 'wp_ajax_fetch_result', 'fetch_result' );
add_action( 'wp_ajax_nopriv_fetch_result', 'fetch_result' );
function fetch_result() {
    echo  result_content($_POST['project_number_search'], $_POST['title_search'], $_POST['category_search'], $_POST['order_search'], $_POST['completion_rate_search'], $_POST['project_supervisor_search']);
    /**
	 * This is required to terminate immediately and return a proper response.
	 *
	 * @since    1.0.0
	 */
    wp_die();
}

/**
 * File upload.
 *
 * @since      1.0.0
 */
use League\Csv\Reader;
use League\Csv\Writer;
function chmang_add_campaign_post_via_file( $file ) {
	$reader = Reader::createFromStream(fopen($file, 'r+'));
	$records = $reader->getRecords();
	$i=0;
	foreach ($records as $offset => $record) {
		if ($i!=0) {
			$post = array(
				'post_title'	=> $record['1'],
				'post_content'	=> $record['3'],
				'tax_input' => $custom_tax,
				'post_status'	=> 'publish',
				'post_type'	=> 'campaign',
				'meta_input' => array(
					'_campaign_description' => $record['3'],
					'project_number' => $record['0'],
					'order' => $record['4'],
					'price_in_dirhams' => $record['5'],
					'price_in_francs' => $record['6'],
					'completion_rate' => $record['7'],
					'project_supervisor' => $record['8'],
					'contract_price' => $record['9'],
					'first_installment' => $record['10'],
					'second_installment' => $record['11'],
					'third_installment' => $record['12'],
					'total_installment' => $record['13']
				)
			);
			$post_id = wp_insert_post($post);
			wp_set_object_terms( $post_id, $record['2'], 'campaign_category' );
		}
		$i++;
	}    
    
}
/**
 * upload_csv by ajax.
 *
 * @since      1.0.0
 */
add_action( 'wp_ajax_upload_csv', 'upload_csv' );
add_action( 'wp_ajax_nopriv_upload_csv', 'upload_csv' );
function upload_csv() {
	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	
	$uploadedfile = $_FILES['file'];
	
	$upload_overrides = array( 'test_form' => false );
	
	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
	
	if ( $movefile && ! isset( $movefile['error'] ) ) {
		echo "<div class='p-3 mb-2 bg-success text-white'>تم الرفع.</div>";
		chmang_add_campaign_post_via_file( $movefile['file'] );
	} else {
		/**
		 * Error generated by _wp_handle_upload()
		 * @see _wp_handle_upload() in wp-admin/includes/file.php
		 * 
		 * @since      1.0.0
		 */
		echo "<div class='p-3 mb-2 bg-danger text-white'>${movefile['error']}</div>";
	}	
	
    /**
	 * This is required to terminate immediately and return a proper response.
	 *
	 * @since    1.0.0
	 */
    wp_die();
}