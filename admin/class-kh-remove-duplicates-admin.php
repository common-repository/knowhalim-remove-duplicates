<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://knowhalim.com/plugins
 * @since      1.0.0
 *
 * @package    Kh_Remove_Duplicates
 * @subpackage Kh_Remove_Duplicates/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kh_Remove_Duplicates
 * @subpackage Kh_Remove_Duplicates/admin
 * @author     Halim <contact@knowhalim.com>
 */
class Kh_Remove_Duplicates_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
		 * defined in Kh_Remove_Duplicates_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kh_Remove_Duplicates_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kh-remove-duplicates-admin.css', array(), $this->version, 'all' );

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
		 * defined in Kh_Remove_Duplicates_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kh_Remove_Duplicates_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kh-remove-duplicates-admin.js', array( 'jquery' ), $this->version, false );

	}

}






function kh_get_recommends_remove_duplicates(){


	$args_post = array(
       'method' => 'POST',
    'timeout' => 45,
    'redirection' => 5,
    'httpversion' => '1.1',
    'blocking' => true,
	'body'        => '{"about": "Remove duplicates"}',
	'sslverify' => false,
	'headers'     => array(
		'Content-type' => 'application/json',
		'Authorization'=> 'Bearer 22jd948hhfrg'
	  ),
      'cookies' => array() 
	);


	$response = wp_remote_post( 'https://knowhalim.com/wp-json/kh_plugin/v1/recommend', $args_post );
	
	 $res = $response['body'];
	
	$returnvalue = json_decode($res,true);

	$display='<div class="recommends">'.$returnvalue['instruction'].'<h3>Other recommendations</h3>';
	foreach ($returnvalue['news'] as $item){
		$display .='<div class="kh_news">'.$item.'</div>';
	}
	$display .='</div>';
	return $display;
}
class KnowHalim_RemoveDuplicatePosts {
	private $remove_duplicate_posts_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'remove_duplicate_posts_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'remove_duplicate_posts_page_init' ) );
	}

	public function remove_duplicate_posts_add_plugin_page() {
		add_options_page(
			'Remove Duplicate Posts', // page_title
			'Remove Duplicate Posts', // menu_title
			'manage_options', // capability
			'remove-duplicate-posts', // menu_slug
			array( $this, 'remove_duplicate_posts_create_admin_page' ) // function
		);
	}

	public function remove_duplicate_posts_create_admin_page() {
		$this->remove_duplicate_posts_options = get_option( 'remove_duplicate_posts_option_name' ); ?>

		<div class="wrap">
			<h2>Remove Duplicate Posts</h2>
			<div class="kh_option">
			
				<div class="kh_admin_left">
			<p>Configure these options before removing duplicate posts</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'remove_duplicate_posts_option_group' );
					do_settings_sections( 'remove-duplicate-posts-admin' );
					submit_button();
				?>
				
				<h2>Step 2: Initiate Delete Process</h2>
				<p>After you save, click the following button below to initiate the deletion process.<span id="saysomething"></span></p>
		<input type="submit" id="remove_duplicate_posts" name="submit[generate_pages_now]" onclick="return false;" class="button button-primary remove_duplicate_posts" value="Initiate Deletion Now" />
			</form>
				</div>
				<div class="kh_admin_right">
					<?php echo kh_get_recommends_remove_duplicates(); ?>
				</div>
				
			</div>
		</div>
	<?php }

	public function remove_duplicate_posts_page_init() {
		register_setting(
			'remove_duplicate_posts_option_group', // option_group
			'remove_duplicate_posts_option_name', // option_name
			array( $this, 'remove_duplicate_posts_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'remove_duplicate_posts_setting_section', // id
			'Step 1: Settings', // title
			array( $this, 'remove_duplicate_posts_section_info' ), // callback
			'remove-duplicate-posts-admin' // page
		);

		add_settings_field(
			'keep_posts_0', // id
			'Keep Posts', // title
			array( $this, 'keep_posts_0_callback' ), // callback
			'remove-duplicate-posts-admin', // page
			'remove_duplicate_posts_setting_section' // section
		);

		add_settings_field(
			'select_which_post_type_to_check_1', // id
			'Select which post type to check', // title
			array( $this, 'select_which_post_type_to_check_1_callback' ), // callback
			'remove-duplicate-posts-admin', // page
			'remove_duplicate_posts_setting_section' // section
		);

		add_settings_field(
			'send_email_once_complete_to_2', // id
			'Send Email Once Complete To', // title
			array( $this, 'send_email_once_complete_to_2_callback' ), // callback
			'remove-duplicate-posts-admin', // page
			'remove_duplicate_posts_setting_section' // section
		);
	}

	public function remove_duplicate_posts_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['keep_posts_0'] ) ) {
			$sanitary_values['keep_posts_0'] = $input['keep_posts_0'];
		}

		if ( isset( $input['select_which_post_type_to_check_1'] ) ) {
			$sanitary_values['select_which_post_type_to_check_1'] = $input['select_which_post_type_to_check_1'];
		}

		if ( isset( $input['send_email_once_complete_to_2'] ) ) {
			$sanitary_values['send_email_once_complete_to_2'] = sanitize_text_field( $input['send_email_once_complete_to_2'] );
		}

		return $sanitary_values;
	}

	public function remove_duplicate_posts_section_info() {
		
	}

	public function keep_posts_0_callback() {
		?> <select name="remove_duplicate_posts_option_name[keep_posts_0]" id="keep_posts_0">
			<?php $selected = (isset( $this->remove_duplicate_posts_options['keep_posts_0'] ) && $this->remove_duplicate_posts_options['keep_posts_0'] === 'Recent') ? 'selected' : '' ; ?>
			<option <?php echo $selected; ?>>Recent</option>
			<?php $selected = (isset( $this->remove_duplicate_posts_options['keep_posts_0'] ) && $this->remove_duplicate_posts_options['keep_posts_0'] === 'Oldest') ? 'selected' : '' ; ?>
			<option <?php echo $selected; ?>>Oldest</option>
		</select> <?php
	}

	public function select_which_post_type_to_check_1_callback() {
		?> <fieldset><?php $checked = ( isset( $this->remove_duplicate_posts_options['select_which_post_type_to_check_1'] ) && $this->remove_duplicate_posts_options['select_which_post_type_to_check_1'] === 'post' ) ? 'checked' : '' ; ?>
		<label for="select_which_post_type_to_check_1-0"><input type="radio" name="remove_duplicate_posts_option_name[select_which_post_type_to_check_1]" id="select_which_post_type_to_check_1-0" value="post" <?php echo esc_attr($checked); ?>> post</label><br>
		<?php $checked = ( isset( $this->remove_duplicate_posts_options['select_which_post_type_to_check_1'] ) && $this->remove_duplicate_posts_options['select_which_post_type_to_check_1'] === 'page' ) ? 'checked' : '' ; ?>
		<label for="select_which_post_type_to_check_1-1"><input type="radio" name="remove_duplicate_posts_option_name[select_which_post_type_to_check_1]" id="select_which_post_type_to_check_1-1" value="page" <?php echo esc_attr($checked); ?>> page</label><br>
		<?php 
		$args = array(
   'public'   => true,
   '_builtin' => false
);
 
$output = 'names'; // 'names' or 'objects' (default: 'names')
$operator = 'and'; // 'and' or 'or' (default: 'and')
 
$post_types = get_post_types( $args, $output, $operator );
 
if ( $post_types ) { 
 
 
    foreach ( $post_types  as $post_type ) {
		$checked = ( isset( $this->remove_duplicate_posts_options['select_which_post_type_to_check_1'] ) && $this->remove_duplicate_posts_options['select_which_post_type_to_check_1'] ===  $post_type ) ? 'checked' : '' ;
		?>
			<label for="select_which_post_type_to_check_1-2"><input type="radio" name="remove_duplicate_posts_option_name[select_which_post_type_to_check_1]" id="select_which_post_type_to_check_1-2" value="<?php echo esc_attr($post_type); ?>" <?php echo esc_attr($checked); ?>> <?php echo esc_html($post_type); ?></label><br>
<?php
		
    }
 
   echo "</fieldset>";
 
}
		
	}

	public function send_email_once_complete_to_2_callback() {
		printf(
			'<input class="regular-text" type="text" name="remove_duplicate_posts_option_name[send_email_once_complete_to_2]" id="send_email_once_complete_to_2" value="%s">',
			isset( $this->remove_duplicate_posts_options['send_email_once_complete_to_2'] ) ? esc_attr( $this->remove_duplicate_posts_options['send_email_once_complete_to_2']) : ''
		);
	}

}
if ( is_admin() )
	$remove_duplicate_posts = new KnowHalim_RemoveDuplicatePosts();


function kh_remove_duplicates_start() {



      	$remove_duplicate_posts_options = get_option( 'remove_duplicate_posts_option_name' );
		$selected_post_type = $remove_duplicate_posts_options['select_which_post_type_to_check_1'];
		$email = $remove_duplicate_posts_options['send_email_once_complete_to_2'];
		$keep_posts = $remove_duplicate_posts_options['keep_posts_0'];
		$orderby = "ASC";
		if ($keep_posts=="Recent"){
			$orderby = "DESC";
		}
		$posts = get_posts(array(
		  'post_type' => $selected_post_type,
		  'post_status' => 'publish',
		  'numberposts' => 8000,
			'orderby'           => 'date',
		  'order'    => $orderby
		));
		wp_mail($email,'The deletion process has started','You have '.count($posts).' from '.$selected_post_type.' post type. We will check for duplicates and remove them while keeping the '.$keep_posts.' ones.');
		$uniquearray= array();
		$uniqueid= array();
		$deleteid=array();
		foreach ($posts as $post){
			if (in_array($post->post_title,$uniquearray)){
				$deleteid[]=$post->ID;
			}else{
				$uniquearray[]=$post->post_title;
				$uniqueid[]=$post->ID;
			}
		}
		foreach ($deleteid as $did){
			wp_delete_post( $did);
		}
		wp_mail($email,'WP Duplicate Post Delete Completion','Dear User
		
We have deleted the duplicates. 

Thank you for using my plugin.

Regards
Knowhalim');
    

    // Always die in functions echoing ajax content
   die();
}

add_action( 'wp_ajax_do_remove_duplicate_posts', 'kh_remove_duplicates_start' );

