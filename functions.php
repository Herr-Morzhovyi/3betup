<?php
/* **************************************************************************************************** */
// Setup Theme
/* **************************************************************************************************** */

// Hide Wordpress version
remove_action('wp_head', 'wp_generator');

// No emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

// Put in wp-config.php
// define( 'DISALLOW_FILE_EDIT', true );

// Enable custom background settings in Appeareance -> Background
// add_custom_background();

add_theme_support('post-thumbnails');
add_theme_support('nav-menus');
// add_theme_support( 'post-formats', array( 'post', 'contact' ) );

// Register Menus
register_nav_menu('primary', 'Primary Menu');

// Image sizes
add_image_size('fullhd', 1920, 1080, FALSE);

/*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
*/
add_theme_support('html5', array(
    'gallery',
    'caption',
));

/**
 * Checks to see if we're on the homepage or not.
 */
function is_real_front_page()
{
    return (is_front_page() && !is_home());
}

/**
 * Proper way to enqueue scripts and styles.
 */
function page_scripts()
{

    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', [], wp_get_theme()->get('Version') . '.' . filemtime(get_stylesheet_directory() . '/style.css'));

    wp_enqueue_style('index-style', get_stylesheet_uri(), null, wp_get_theme()->get('Version') . '.' . filemtime(get_stylesheet_directory() . '/style.css'));

    wp_enqueue_script('jquery');

    wp_enqueue_script('index-script', get_template_directory_uri() . '/js/index.js', ['jquery'], wp_get_theme()->get('Version') . '.' . filemtime(get_stylesheet_directory() . '/js/index.js'));

    wp_localize_script( 'ajax-script', 'my_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

   

}
add_action('wp_enqueue_scripts', 'page_scripts');

/**
 * Redirect user after successful login.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */
function after_login_redirect($redirect_to, $request, $user)
{
    return home_url();
}
add_filter('login_redirect', 'after_login_redirect', 10, 3);

// Check recursively if array exists is not empty and doesn't contain empty elements
function array_filter_recursive(&$array) {
    if (is_array($array)) {
        foreach ($array as $key => $item) {
            is_array($item) && $array[$key] = array_filter_recursive($item);
            if (empty($array[$key]))
                unset($array[$key]);
        }
    }
    return $array;
}

function not_empty_array($array) {
    
    // Remove empty values
    $array = array_filter_recursive($array);

    // Check if still not empty
    if ($array && is_array($array) && count($array)) {
        return true;
    }

    return false;
}


// Login screen logo
function login_logo()
{

    /* ACF installed - get_field()? */
    if (get_field('login_logo', 'option')) {

        $logo_width = get_field('login_logo', 'option')['width'];
        $logo_height = get_field('login_logo', 'option')['height'];
        $logo_aspect_ratio = $logo_width / $logo_height;

        // If normal image is less than 320 then use original width
        // Or if SVG image is less than 320 then use 320 anyway
        if ($logo_width < 320 and get_field('login_logo', 'option')['subtype'] != 'svg+xml') {
            $width = $logo_width;
        } else {
            $width = 320;
        }
        $height = ceil($width / $logo_aspect_ratio);

        ?>
        <style type="text/css">
            body.interim-login #login h1 a,
            body.login h1 a {
                background-image: none, url('<?php echo get_field('login_logo', 'option')['sizes']['large']; ?>');
                width: <?php echo $width; ?>px;
                height: <?php echo $height ?>px;
                background-size: 100%;
            }
        </style><?php
    }
}
add_action('login_head', 'login_logo');

// First, create a function that includes the path to your favicon
function add_favicon() {
    if (not_empty_array(get_field('favicon', 'options'))) {
        $favicon_url = get_field('favicon', 'options')['sizes']['medium'];
        echo '<link rel="shortcut icon" href="' . $favicon_url . '" type="image/x-icon">' . PHP_EOL;
    }

    if (not_empty_array(get_field('apple_touch_icon', 'options'))) {
        $apple_touch_icon_url = get_field('apple_touch_icon', 'options')['sizes']['medium'];
        echo '<link rel="apple-touch-icon" sizes="180x180" href="' . $apple_touch_icon_url . '">' . PHP_EOL;
    }
}

// Now, just make sure that function runs when you're on the login page and admin pages  
add_action('wp_head', 'add_favicon');
add_action('login_head', 'add_favicon');
add_action('admin_head', 'add_favicon');

// Load all files from /inc
$files = array();
$dirPath = get_template_directory() . '/inc';
if (file_exists($dirPath)) {
    $dir = opendir($dirPath);
    while (($currentFile = readdir($dir)) !== false) {
        if (strpos($currentFile, '.php') !== false) {
            require_once($dirPath . '/' . $currentFile);
        }
    }
    closedir($dir);
}

/* Output svg file content inline */
function inline_svg($urlOrId) {
    if ( ! $urlOrId) {
        return;
    }

    if ( is_numeric($urlOrId) ) {
        $url = get_attached_file($urlOrId);
    } else {
        $url = $urlOrId;
    }

    if (stripos($url, '.svg') === false) {
        return;
    }

    readfile($url);
}

// Fix width and height values for SVG images
function fix_wp_get_attachment_image_svg($image, $attachment_id, $size, $icon) {
	if (is_array($image) && preg_match('/\.svg$/i', $image[0]) && $image[1] <= 1) {
		if(is_array($size)) {
			$image[1] = $size[0];
			$image[2] = $size[1];
		} else {

			// If local file
			if ($attachment_id) {
				$xml_content = file_get_contents(get_attached_file($attachment_id));

			// If remote file
			} else {
				// simplexml_load_file() might not work (probably due to CORS)
				// Using CURL
				$ch = curl_init($image[0]);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				// Identify the rquest User Agent as Chrome - any real browser, or perhaps any value may work
				// depending on the resource you are trying to hit
				curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2049.0 Safari/537.36');
				$xml_content = curl_exec($ch);
				curl_close($ch);
			}

			if(($xml = simplexml_load_string($xml_content)) !== false) {
				$attr = $xml->attributes();
				$viewbox = explode(' ', $attr->viewBox);
				$image[1] = isset($attr->width) && preg_match('/\d+/', $attr->width, $value) ? (int) $value[0] : (count($viewbox) == 4 ? (int) $viewbox[2] : null);
				$image[2] = isset($attr->height) && preg_match('/\d+/', $attr->height, $value) ? (int) $value[0] : (count($viewbox) == 4 ? (int) $viewbox[3] : null);
			} else {
				$image[1] = $image[2] = null;
			}
		}
	}
	return $image;
}

add_filter( 'wp_get_attachment_image_src', 'fix_wp_get_attachment_image_svg', 10, 4 );

// Disable PDF preview generation as it anyway gives HTTP error
function wpb_disable_pdf_previews() {
    $fallbacksizes = array();
    return $fallbacksizes;
}
add_filter('fallback_intermediate_image_sizes', 'wpb_disable_pdf_previews');

// Login screen logo url
function login_logo_url() {
	return home_url();
}
add_filter('login_headerurl', 'login_logo_url');

/*
 * Output UTF-8 string instead of xn--mldammen--...
 * 
 * Usage:
 * punycode_email_to_utf('xn--mldammen--...');
 */
function punycode_email_to_utf($email) {

    if ( ! strripos('xn--', $email) === FALSE) {
        return $email;
    }

    // Showing e-mail with punycode decoded domain
    list($email_user, $email_domain) = explode('@', $email);

    if (function_exists('idn_to_utf8')) {
        return $email_user . '@' . idn_to_utf8($email_domain);
    } else {
        // https://github.com/true/php-punycode
        include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Punycode.php');

        $pc = new \TrueBV\Punycode();
        return $email_user . '@' . $pc->decode($email_domain);
    }
}
    
// No <p> around [tags]
add_filter( 'wpcf7_autop_or_not', '__return_false' );

function get_inline_svg($pathOrId) {
    ob_start();
    inline_svg($pathOrId);
    return ob_get_clean();
}


// * Registering a custome REST endpoint to get image arrays
function add_custom_image_array_to_rest_api() {
    register_rest_field(
        'casino',
        'featured_image_array',
        array(
            'get_callback'    => 'get_custom_image_array',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

// Callback function to retrieve the full image array
function get_custom_image_array($object, $field_name, $request) {
    $post_id = $object['id'];
    
    $featured_image_id = get_post_thumbnail_id($post_id);

    $image_array = wp_get_attachment_image_src($featured_image_id, 'full');

    return $image_array;
}

add_action('rest_api_init', 'add_custom_image_array_to_rest_api');


function add_acf_image_array_to_rest_api() {
    register_rest_field(
        'bonus',
        'acfLogo_image_array',
        array(
            'get_callback'    => 'get_acf_image_array',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

// Callback function to retrieve the full image array
function get_acf_image_array($object, $field_name, $request) {
    $post_id = $object['id'];
    
    $image_url = wp_get_attachment_image_src(get_field('associated_casino', $post_id)['ID'], 'post-thumnail', false );
    
    return $image_url;

}

add_action('rest_api_init', 'add_acf_image_array_to_rest_api');



function add_acf_image_array_to_tournament_rest_api() {
    register_rest_field(
        'tournament',
        'acfLogo_tournaments_image_array',
        array(
            'get_callback'    => 'get_acf_tournaments_image_array',
            'update_callback' => null,
            'schema'          => null,
        )
    );
    register_rest_field(
        'tournament',
        'featured_image_array',
        array(
            'get_callback'    => 'get_custom_image_array',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

// Callback function to retrieve the full image array
function get_acf_tournaments_image_array($object, $field_name, $request) {
    $post_id = $object['id'];
    
    $image_url = wp_get_attachment_image_src(get_field('logo', $post_id)['ID'], 'post-thumnail', false );
    
    return $image_url;

}

add_action('rest_api_init', 'add_acf_image_array_to_tournament_rest_api');


// * Adding submitted through subscription form emails to a new options page in WP dashboard
// Intercept form submission
function process_custom_form() {

    if (isset($_POST['topic']) && isset($_POST['message']) && isset($_POST['email'])) {
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {

        // Intercept only default form submit, not AJAX request
        if (!isset($_POST['action']) || ($_POST['action'] !== 'delete_saved_email' && $_POST['action'] !== 'clear_all_emails')) {
            $email = sanitize_email($_POST['email']);
            save_email($email);
            global $wp;
            wp_redirect(home_url(add_query_arg(array(), $wp->request)));
            exit;
        }

    }
}
add_action( 'init', 'process_custom_form' );

function save_email($new_email) {
    // Retrieve the existing list of emails from the options table
    $email_list = get_option('saved_emails', array());

    // Sanitize and add the new email to the list
    $new_email = sanitize_email($new_email);
    $email_list[] = $new_email;

    // Update the options table with the new email list
    update_option('saved_emails', $email_list);
}

// A template of options page
function display_saved_emails_page() {
    // Retrieve the list of saved emails from the options table
    $email_list = get_option('saved_emails', array());

    // Display the saved emails
    echo '<div class="wrap">';
    echo '<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; width: 100%;">';
    echo '<h1>Saved Emails Information</h1>';
    echo '<button class="button clear-emails">Clear All Emails</button>';
    echo '</div>';

    if (empty($email_list)) {
        echo '<p>No emails have been saved yet.</p>';
    } else {
        echo '<table class="widefat">';
        echo '<thead><tr><th>Email</th><th>Action</th></tr></thead>';
        echo '<tbody>';
        foreach ($email_list as $email) {
            echo '<tr>';
            echo '<td style="border-bottom: 1px solid #383838;">' . esc_html($email) . '</td>';
            echo '<td style="border-bottom: 1px solid #383838;"><button class="delete-email button" data-email="' . esc_attr($email) . '">Delete</button></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';

        // JavaScript to handle AJAX deletion
        echo '<script>
            jQuery(document).ready(function($) {
                $(".delete-email").on("click", function() {
                    event.preventDefault();
                    var emailToDelete = $(this).data("email");
                    var button = $(this);
                    var ajaxurl = "' . admin_url('admin-ajax.php') . '";
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        dataType: "json",
                        data: {
                            action: "delete_saved_email",
                            email: emailToDelete,
                            security: "' . wp_create_nonce("delete-email-nonce") . '"
                        },
                        success: function(response) {
                            if (response.success) {
                                button.closest("tr").remove();
                            } else {
                                console.log(response);
                                alert("Error deleting email.");
                            }
                        }
                    });
                });
                $(".clear-emails").on("click", function() {
                    var ajaxurl = "' . admin_url('admin-ajax.php') . '";

                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        dataType: "json",
                        data: {
                            action: "clear_all_emails",
                            security: "' . wp_create_nonce("clear-emails-nonce") . '"
                        },
                        success: function(response) {
                            if (response.success) {
                                $("table.widefat tbody").empty();
                            } else {
                                console.log(response);
                                alert("Error clearing emails.");
                            }
                        }
                    });
                });
            });
        </script>';
    }

    echo '</div>';
}

function clear_all_emails() {
    check_ajax_referer('clear-emails-nonce', 'security');

    // Clear all emails by updating the option
    update_option('saved_emails', array());

    wp_send_json_success();
}
add_action('wp_ajax_clear_all_emails', 'clear_all_emails');
add_action('wp_ajax_nopriv_clear_all_emails', 'clear_all_emails');

function delete_saved_email() {
    error_log('delete_saved_email function called');
    check_ajax_referer('delete-email-nonce', 'security');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
        $emailToDelete = sanitize_email($_POST['email']);

        // Retrieve the existing list of emails from the options table
        $email_list = get_option('saved_emails', array());

        // Find and remove the email from the list
        $index = array_search($emailToDelete, $email_list);
        if ($index !== false) {
            unset($email_list[$index]);

            // Update the options table with the modified email list
            update_option('saved_emails', $email_list);

            wp_send_json_success();
        } else {
            wp_send_json_error();
        }
    } else {
        wp_send_json_error();
    }

    wp_die();
}
add_action('wp_ajax_delete_saved_email', 'delete_saved_email');
add_action('wp_ajax_nopriv_delete_saved_email', 'delete_saved_email');
// Initialize new options page
function add_custom_menu_entry() {
    add_menu_page(
        'Saved Email Page',   // Page title
        'Saved Email',        // Menu title
        'manage_options',     // Capability required to access
        'saved_email_page',   // Menu slug (unique identifier)
        'display_saved_emails_page', // Callback function to display content
        'dashicons-email',    // Icon URL or a Dashicon class
        10                    // Position in the menu
    );
}
add_action('admin_menu', 'add_custom_menu_entry');