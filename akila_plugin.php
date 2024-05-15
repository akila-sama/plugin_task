<?php
/*
Plugin Name: My Plugin AJAX
Plugin URI: https://example.com/my-plugin-ajax
Description: This plugin allows users to submit their portfolio details through a form and inserts the data into a custom post type 'portfolio'. It also extends the functionality of a shortcode to display recent posts by category.
Version: 1.0
Author: akila
Author URI: https://example.com
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain: my-plugin-ajax
Domain Path: /languages
*/




/**Add details and description about your plugin on plugin page
plugin name
shortcode name
functionality of shortcode
etc
Design plugin page */

// Add a menu page
function custom_menu() {
	add_menu_page(
		'Plugin Details', // Page title
		'Plugin Details', // Menu title
		'manage_options', // Capability
		'custom-slug', // Menu slug
		'display_plugin_details', // Callback function to render the page content
		'dashicons-admin-plugins', // Icon URL or Dashicons class
		25 // Menu position
	);
}
add_action( 'admin_menu', 'custom_menu' );

// Function to render plugin details
function display_plugin_details() {
	?>
	<div class="wrap">
		<h2>My Plugin Details</h2>
		<div class="plugin-info">
			<p><strong>Plugin Name:</strong> My plugin ajax</p>
			<p><strong>Description:</strong> This is a testing plugin. This plugin is my first plugin.</p>
			<p><strong>Author:</strong> akila</p>
			<p><strong>Version:</strong> 1.0</p>
		</div>

		<h3>Shortcode Details</h3>
		<div class="shortcode-info">
			<p><strong>Shortcode Name:</strong> portfolio_submission_form</p>
			<p><strong>Functionality:</strong> This shortcode allows users to submit their portfolio details through a form, including name, company name, email, phone, and address. Upon submission, the data is inserted into the custom post type 'portfolio'.</p>
		</div>
	</div>
	<style>
		.wrap {
			padding: 20px;
		}

		.plugin-info, .shortcode-info {
			background-color: #f9f9f9;
			border: 1px solid #ddd;
			padding: 10px;
			margin-bottom: 20px;
		}

		.plugin-info strong, .shortcode-info strong {
			font-weight: bold;
		}
	</style>
	<?php
}


// Add a menu page
function custom_menu_page() {
	add_menu_page(
		'ajax Page', // Page title
		'ajax Page', // Menu title
		'manage_options', // Capability
		'custom-page-slug', // Menu slug
		'custom_page_content', // Callback function to render the page content
		'dashicons-admin-generic', // Icon URL or Dashicons class
		26 // Menu position
	);
}
add_action( 'admin_menu', 'custom_menu_page' );


// Function to render the page content
function custom_page_content() {

	?>
	<div class="wrap">
		<h2>Custom Page</h2>
		<form method="post" action="">
			<!-- Add nonce field to the form -->
			<?php wp_nonce_field( 'custom_data_nonce', 'custom_data_nonce' ); ?>
			<label for="custom_data">Enter Custom Data:</label>
			<input type="text" id="custom_data" name="custom_data" value="<?php echo esc_attr( get_option( 'custom_data' ) ); ?>" /><br>
			<input type="submit" id="submit_custom_data" name="submit_custom_data" class="button-primary" value="Save" />
		</form>
		<div id="message"></div>
		<!-- This div will display the message -->
	</div>

	<?php
}


// AJAX path
function enqueue_my_plugin_ajax_script() {
	wp_enqueue_script( 'my-plugin-ajax-script', plugin_dir_url( __FILE__ ) . 'js/akila_plugin.js', array( 'jquery' ), '1.0', true );
	// Localize the script with the AJAX URL and nonce
	wp_localize_script(
		'my-plugin-ajax-script',
		'my_ajax_object',
		array(
			'ajaxurl'  => admin_url( 'admin-ajax.php' ),
			'security' => wp_create_nonce( 'custom_data_nonce' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'enqueue_my_plugin_ajax_script' );


// Function to save data to wp-options table via AJAX
function save_custom_data_ajax() {
	// Verify nonce
	check_ajax_referer( 'custom_data_nonce', 'security' );

	if ( isset( $_POST['custom_data'] ) ) {
		update_option( 'custom_data', $_POST['custom_data'] );
		echo 'success';
	} else {
		echo 'error';
	}
	wp_die();
}
add_action( 'wp_ajax_save_custom_data_ajax', 'save_custom_data_ajax' );



/**Custom Post Type: Implement a plugin that registers a custom
post type, such as "Portfolio" or "Testimonials". Add some custom
fields to this post type, like "Client Name" and "Project URL".**/

// Register Custom Post Type
function custom_portfolio_post_type() {

	$labels = array(
		'name'                  => _x( 'Portfolio', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Portfolio Item', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Portfolio', 'text_domain' ),
		'name_admin_bar'        => __( 'Portfolio', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args   = array(
		'label'               => __( 'Portfolio Item', 'text_domain' ),
		'description'         => __( 'Portfolio items', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-portfolio',
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'portfolio', $args );
}
add_action( 'init', 'custom_portfolio_post_type', 0 );

// Add custom fields to the Portfolio post type
function add_custom_fields() {
	add_meta_box(
		'portfolio_fields',
		'Portfolio Item Details',
		'render_portfolio_fields',
		'portfolio',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'add_custom_fields' );

// Render custom fields
function render_portfolio_fields( $post ) {
	$client_name = get_post_meta( $post->ID, 'client_name', true );
	$project_url = get_post_meta( $post->ID, 'project_url', true );
	?>
	<label for="client_name">Client Name:</label>
	<input type="text" id="client_name" name="client_name" value="<?php echo esc_attr( $client_name ); ?>"><br><br>

	<label for="project_url">Project URL:</label>
	<input type="text" id="project_url" name="project_url" value="<?php echo esc_attr( $project_url ); ?>"><br><br>
	<?php
	// Generate nonce field
	wp_nonce_field( 'save_portfolio_fields', 'portfolio_fields_nonce' );
}
// Save custom fields data
function save_custom_fields( $post_id ) {
	// Verify nonce
	if ( ! isset( $_POST['portfolio_fields_nonce'] ) || ! wp_verify_nonce( $_POST['portfolio_fields_nonce'], 'save_portfolio_fields' ) ) {
		return;
	}

	if ( array_key_exists( 'client_name', $_POST ) ) {
		update_post_meta(
			$post_id,
			'client_name',
			sanitize_text_field( $_POST['client_name'] )
		);
	}

	if ( array_key_exists( 'project_url', $_POST ) ) {
		update_post_meta(
			$post_id,
			'project_url',
			sanitize_text_field( $_POST['project_url'] )
		);
	}
}
add_action( 'save_post', 'save_custom_fields' );


/**Shortcode Extension: Extend the functionality of a shortcode.
For example, create a shortcode that displays a list of recent
posts with a specific category.  **/

function recent_posts_by_category_shortcode( $atts ) {
	// Extract shortcode attributes
	$atts = shortcode_atts(
		array(
			'category' => '', // default category
			'count'    => 5,     // default number of posts to display
		),
		$atts,
		'recent_posts_by_category'
	);

	// Query recent posts with the specified category
	$query_args  = array(
		'posts_per_page' => $atts['count'],
		'category_name'  => $atts['category'],
	);
	$posts_query = new WP_Query( $query_args );

	// Output the list of recent posts
	$output = '<ul>';
	if ( $posts_query->have_posts() ) {
		while ( $posts_query->have_posts() ) {
			$posts_query->the_post();
			$output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
		}
	} else {
			$output .= '<li>No posts found</li>';
	}
	$output .= '</ul>';

	// Restore global post data
	wp_reset_postdata();

	return $output;
}
add_shortcode( 'recent_posts_by_category', 'recent_posts_by_category_shortcode' );


/**Create shortcode
Add form
get following data
name
company name
email
phone
address
insert these data in the custom post type 'portfolio' that you've created.
 **/


// Enqueue CSS file
function enqueue_portfolio_submission_css() {
	// Get the plugin directory URL
	$plugin_dir_url = plugin_dir_url( __FILE__ );

	// Enqueue the CSS file
	wp_enqueue_style( 'portfolio-submission-css', $plugin_dir_url . 'css/portfolio-submission-form.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_portfolio_submission_css' );
// Enqueue jQuery in WordPress
function enqueue_jquery() {
	wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_jquery' );

function portfolio_submission_form_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'title' => 'portfolio submision from', // Default title
		),
		$atts,
		'portfolio_submission_form'
	);

	ob_start();
	?>
	<h2><?php echo esc_html( $atts['title'] ); ?></h2> <!-- Title added here -->

	<form id="portfolio_submission_form">
		<input type="hidden" name="action" value="portfolio_submission">
		<?php wp_nonce_field( 'portfolio_submission_nonce', 'portfolio_submission_nonce_field' ); ?>

		<label for="name">Name:</label>
		<input type="text" id="name" name="name" required><br><br>

		<label for="company_name">Company Name:</label>
		<input type="text" id="company_name" name="company_name"><br><br>

		<label for="email">Email:</label>
		<input type="email" id="email" name="email" required><br><br>

		<label for="phone">Phone:</label>
		<input type="tel" id="phone" name="phone"><br><br>

		<label for="address">Address:</label>
		<textarea id="address" name="address"></textarea><br><br>

		<input type="button" id="submit_btn" value="Submit">
	</form>

	<div id="response_msg"></div>

	<script>
		jQuery(document).ready(function ($) {
			$('#submit_btn').on('click', function () {
				var name = $('#name').val();
				var company_name = $('#company_name').val();
				var email = $('#email').val();
				var phone = $('#phone').val();
				var address = $('#address').val();

				// Basic form validation
				if (name.trim() === '' || email.trim() === '' || phone.trim() === '' || address.trim() === '') {
					$('#response_msg').html('<div class="error">Please fill out all required fields.</div>');
					return;
				}
				var formData = $('#portfolio_submission_form').serialize();
				$.ajax({
					type: 'POST',
					url: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
					data: formData,
					success: function (response) {
						$('#response_msg').html(response);
						$('#portfolio_submission_form')[0].reset(); // Reset the form
					}
				});
			});
		});
	</script>

	<?php
	return ob_get_clean();
}
add_shortcode( 'portfolio_submission_form', 'portfolio_submission_form_shortcode' );

// Process form submission
function process_portfolio_submission() {
	if ( isset( $_POST['portfolio_submission_nonce_field'] ) && wp_verify_nonce( $_POST['portfolio_submission_nonce_field'], 'portfolio_submission_nonce' ) ) {
		if ( isset( $_POST['name'] ) && isset( $_POST['email'] ) ) {
			$name         = sanitize_text_field( $_POST['name'] );
			$company_name = sanitize_text_field( $_POST['company_name'] );
			$email        = sanitize_email( $_POST['email'] );
			$phone        = sanitize_text_field( $_POST['phone'] );
			$address      = sanitize_textarea_field( $_POST['address'] );

			// Create post object
			$portfolio_data = array(
				'post_title'  => $name,
				'post_type'   => 'portfolio',
				'post_status' => 'publish',
				'meta_input'  => array(
					'client_name'  => $name,
					'company_name' => $company_name,
					'email'        => $email,
					'phone'        => $phone,
					'address'      => $address,
				),
			);

			// Insert the post into the database
			$post_id = wp_insert_post( $portfolio_data );
			if ( is_wp_error( $post_id ) ) {
				echo 'Error: ' . esc_html( $post_id->get_error_message() );
			} else {
				echo 'Success! Your portfolio has been submitted.';
			}
		}
	}
	die();
}
add_action( 'wp_ajax_portfolio_submission', 'process_portfolio_submission' );
add_action( 'wp_ajax_nopriv_portfolio_submission', 'process_portfolio_submission' );
