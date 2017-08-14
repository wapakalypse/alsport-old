<?php
/**
 * Catch Flames functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, catchflames_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'catchflames_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package Catch Themes
 * @subpackage Catch Flames
 * @since Catch Flames 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */	
 
if ( ! isset( $content_width ) ) {
	$content_width = 600; /* pixels */
}	
	

if ( ! function_exists( 'catchflames_content_width' ) ) :
/**
 * Change the content width based on the Theme Settings and Page/Post Settings
 */
function catchflames_content_width() {
	//Getting Ready to load data from Theme Options Panel
	global $post, $wp_query, $content_width, $catchflames_options_settings;
	$options = $catchflames_options_settings;
	$themeoption_layout = $options['sidebar_layout'];
	$themeoption_content_layout = $options['content_layout'];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 
	
	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	// Blog Page setting in Reading Settings
	if ( $page_id == $page_for_posts ) {
		$layout = get_post_meta( $page_for_posts,'catchflames-sidebarlayout', true );
	}	
	// Front Page setting in Reading Settings
	elseif ( $page_id == $page_on_front ) {
		$layout = get_post_meta( $page_on_front,'catchflames-sidebarlayout', true );
	}		
	// Settings for page/post/attachment
	elseif ( is_singular() ) {
		if ( is_attachment() ) { 
			$parent = $post->post_parent;
			$layout = get_post_meta( $parent,'catchflames-sidebarlayout', true );
		} else {
			$layout = get_post_meta( $post->ID,'catchflames-sidebarlayout', true ); 
		}
	}
	else {
		$layout = 'default';	
	}
	
	//check empty and load default
	if ( empty( $layout ) ) {
		$layout = 'default';	
	}
	
	// Two Colums: Left and Right Sidebar & One Column: No Sidbear, No Sidebar One Column
	elseif ( $layout == 'right-sidebar' || $layout == 'left-sidebar' || $layout == 'no-sidebar' || ( $layout=='default' && $themeoption_layout == 'right-sidebar' ) || ( $layout=='default' && $themeoption_layout == 'left-sidebar' ) || ( $layout=='default' && $themeoption_layout == 'no-sidebar' ) ) {
			$content_width = 710;
	}

	
}
endif;

add_action( 'template_redirect', 'catchflames_content_width' );

/**
 * Tell WordPress to run catchflames_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'catchflames_setup' );


if ( ! function_exists( 'catchflames_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override catchflames_setup() in a child theme, add your own catchflames_setup to your child theme's
 * functions.php file.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To style the visual editor.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,custom headers and backgrounds.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Catch Flames 1.0
 */
function catchflames_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Catch Flames, use a find and replace
	 * to change 'catch-flames' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'catch-flames', get_template_directory() . '/languages' );	

	/**
     * Add callback for custom TinyMCE editor stylesheets. (editor-style.css)
     * @see http://codex.wordpress.org/Function_Reference/add_editor_style
     */
	add_editor_style();
	
	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image', 'video', 'chat' ) );
	
	/*
	* Let WordPress manage the document title.
	* By adding theme support, we declare that this theme does not use a
	* hard-coded <title> tag in the document head, and expect WordPress to
	* provide it for us.
	*/
	add_theme_support( 'title-tag' );
		
	// Load up theme options defaults
	require( get_template_directory() . '/inc/panel/catchflames-themeoptions-defaults.php' );
	
	// Load up our theme options page and related code.
	require( get_template_directory() . '/inc/panel/theme-options.php' );
	
	// Load up our Catch Flames metabox
	require( get_template_directory() . '/inc/catchflames-metabox.php' );	
	
	// Load up our Catch Flames Functions
	require( get_template_directory() . '/inc/catchflames-functions.php' );
	
	// Load up our Catch Flames Slider Function
	require( get_template_directory() . '/inc/catchflames-slider.php' );	
	
	// Register Sidebar and Widget.
	require( get_template_directory() . '/inc/catchflames-widgets.php' );
	
	// Load up our Catch Flames Menus
	require( get_template_directory() . '/inc/catchflames-menus.php' );	


	/**
     * This feature enables Jetpack plugin Infinite Scroll
     */		
    add_theme_support( 'infinite-scroll', array(
		'type'           => 'click',										
        'container'      => 'content',
        'footer_widgets' => array( 'sidebar-2', 'sidebar-3', 'sidebar-4' ),
        'footer'         => 'page',
    ) );
	
	/**
     * This feature enables custom-menus support for a theme.
     * @see http://codex.wordpress.org/Function_Reference/register_nav_menus
     */		
	register_nav_menus(array(
		'top' 		=> __( 'Fixed Header Top Menu', 'catch-flames' ),
		'primary' 	=> __( 'Primary Menu', 'catch-flames' ),
	) );

	// Add support for custom backgrounds	
	add_theme_support( 'custom-background' );
	
	/**
     * This feature enables post-thumbnail support for a theme.
     * @see http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
	add_theme_support( 'post-thumbnails' );
	
	
	//Featured Posts for Full Width
	/* add_image_size( 'featured-slider-full', 1600, 533, true ); // 1:3 ratio Used for featured posts if a large-feature doesn't exist
	
	add_image_size( 'featured', 750, 470, true ); // 4:3 Used for featured posts if a large-feature doesn't exist
	
	add_image_size( 'featured-three', 640, 401, true ); // 1.6 Used for featured posts if a large-feature doesn't exist
	     */
	if ( function_exists('catchflames_woocommerce' ) ) { 
 		catchflames_woocommerce();
    }
}
endif; // catchflames_setup


/**
 * Adds support for a custom header image.
 */
require( get_template_directory() . '/inc/catchflames-custom-header.php' );


/**
 * Adds support for WooCommerce Plugin
 */
if ( class_exists( 'woocommerce' ) ) { 
	add_theme_support( 'woocommerce' );	
    require( get_template_directory() . '/inc/catchflames-woocommerce.php' );
}


/**
 * Adds support for mqtranslate and qTranslate Plugin
 */
if ( in_array( 'qtranslate/qtranslate.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ||
in_array( 'mqtranslate/mqtranslate.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 
    require( get_template_directory() . '/inc/catchflames-qtranslate.php' );
}

/**
 * Adds support for WPML Plugin and Polyland
 */	
if ( defined( 'ICL_SITEPRESS_VERSION' ) || class_exists( 'Polylang' ) ) {
	require( get_template_directory() . '/inc/catchflames-wpml.php' );
}
	
	
/**
  * Filters the_category() to output html 5 valid rel tag
  *
  * @param string $text
  * @return string
  */
function catchflames_html_validate( $text ) {
	$string = 'rel="tag"';
	$replace = 'rel="category"';
	$text = str_replace( $replace, $string, $text );

	return $text;
}
add_filter( 'the_category', 'catchflames_html_validate' );
add_filter( 'wp_list_categories', 'catchflames_html_validate' );

//Include customizer options
require get_template_directory() . '/inc/panel/customizer/customizer.php';

if( !function_exists('_add_my_quicktags') ){
function _add_my_quicktags()
{ ?>
<script type="text/javascript">
QTags.addButton( 'p', 'p', '<p>', '</p>' );
QTags.addButton( 'br', 'br', '<br>', '<br>' );
QTags.addButton( 'h2', 'H2', '<h2>', '</h2>' );
QTags.addButton( 'h3', 'H3', '<h3>', '</h3>' );
</script>
<?php }
add_action('admin_print_footer_scripts', '_add_my_quicktags');
}

function enable_more_buttons($buttons) {
  $buttons[] = 'hr';
  $buttons[] = 'sub';
  $buttons[] = 'sup';
  $buttons[] = 'fontselect';
  $buttons[] = 'fontsizeselect';
  $buttons[] = 'cleanup';
  $buttons[] = 'styleselect';
  return $buttons;
}
add_filter("mce_buttons_1", "enable_more_buttons");

//Russian date
function axel_russian_date($timedate = '') {
	if ( substr_count($timedate , '--') > 0 ) return str_replace('--', '', $timedate);
	$rus_date_array = array (
	"Январь" => "января",
	"Февраль" => "февраля",
	"Март" => "марта",
	"Апрель" => "апреля",
	"Май" => "мая",
	"Июнь" => "июня",
	"Июль" => "июля",
	"Август" => "августа",
	"Сентябрь" => "сентября",
	"Октябрь" => "октября",
	"Ноябрь" => "ноября",
	"Декабрь" => "декабря",
	);
   	return strtr($timedate, $rus_date_array);
}
add_filter('get_the_date', 'axel_russian_date');
add_filter('get_comment_date', 'axel_russian_date');

//Cyr to Lat
function ctl_sanitize_title($title) {
	global $wpdb;
	$iso9_table = array(
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Ѓ' => 'G`',
		'Ґ' => 'G`', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Є' => 'YE',
		'Ж' => 'ZH', 'З' => 'Z', 'Ѕ' => 'Z', 'И' => 'I', 'Й' => 'Y',
		'Ј' => 'J', 'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 'Ќ' => 'K',
		'Л' => 'L', 'Љ' => 'L', 'М' => 'M', 'Н' => 'N', 'Њ' => 'N',
		'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
		'У' => 'U', 'Ў' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'TS',
		'Ч' => 'CH', 'Џ' => 'DH', 'Ш' => 'SH', 'Щ' => 'SHH', 'Ъ' => '``',
		'Ы' => 'YI', 'Ь' => '`', 'Э' => 'E`', 'Ю' => 'YU', 'Я' => 'YA',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'ѓ' => 'g',
		'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'є' => 'ye',
		'ж' => 'zh', 'з' => 'z', 'ѕ' => 'z', 'и' => 'i', 'й' => 'y',
		'ј' => 'j', 'і' => 'i', 'ї' => 'yi', 'к' => 'k', 'ќ' => 'k',
		'л' => 'l', 'љ' => 'l', 'м' => 'm', 'н' => 'n', 'њ' => 'n',
		'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
		'у' => 'u', 'ў' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts',
		'ч' => 'ch', 'џ' => 'dh', 'ш' => 'sh', 'щ' => 'shh', 'ь' => '',
		'ы' => 'yi', 'ъ' => "'", 'э' => 'e`', 'ю' => 'yu', 'я' => 'ya'
	);	
	$term = $wpdb->get_var("SELECT slug FROM {$wpdb->terms} WHERE name = '$title'");
	if ( empty($term) ) {
		$title = strtr($title, apply_filters('ctl_table', $iso9_table));
		$title = preg_replace("/[^A-Za-z0-9`'_\-\.]/", '-', $title);
	} else {
		$title = $term;
	}
	return $title;
}
if ( !empty($_POST) || !empty($_GET['action']) && $_GET['action'] == 'edit' || defined('XMLRPC_REQUEST') && XMLRPC_REQUEST ) {
	add_filter('sanitize_title', 'ctl_sanitize_title', 9);
	add_filter('sanitize_file_name', 'ctl_sanitize_title');
}
function ctl_convert_existing_slugs() {
	global $wpdb;
	$posts = $wpdb->get_results("SELECT ID, post_name FROM {$wpdb->posts} WHERE post_name REGEXP('[^A-Za-z0-9\-]+') AND post_status = 'publish'");
	foreach ( (array) $posts as $post ) {
		$sanitized_name = ctl_sanitize_title(urldecode($post->post_name));
		if ( $post->post_name != $sanitized_name ) {
			add_post_meta($post->ID, '_wp_old_slug', $post->post_name);
			$wpdb->update($wpdb->posts, array( 'post_name' => $sanitized_name ), array( 'ID' => $post->ID ));
		}
	}
	$terms = $wpdb->get_results("SELECT term_id, slug FROM {$wpdb->terms} WHERE slug REGEXP('[^A-Za-z0-9\-]+') ");
	foreach ( (array) $terms as $term ) {
		$sanitized_slug = ctl_sanitize_title(urldecode($term->slug));
		if ( $term->slug != $sanitized_slug ) {
			$wpdb->update($wpdb->terms, array( 'slug' => $sanitized_slug ), array( 'term_id' => $term->term_id ));
		}
	}
}
function ctl_schedule_conversion() {
	add_action('shutdown', 'ctl_convert_existing_slugs');
}
register_activation_hook(__FILE__, 'ctl_schedule_conversion');

// Search in Menu

add_filter('wp_nav_menu_items','add_search_box', 10, 2);
function add_search_box($items, $args) {
ob_start();
get_search_form();
$searchform = ob_get_contents();
ob_end_clean();
$items .= '<li class = "my_search">' . $searchform . '</li>';
return $items;
}

function my_search_form( $form ) {

	$form = '
	<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
		<label class="screen-reader-text" for="s">Запрос для поиска:</label>
		<input type="text" value="' . get_search_query() . '" name="s" id="s" />
		<input type="submit" id="searchsubmit" value="Найти" />
	</form>';

	return $form;
}

add_filter( 'get_search_form', 'my_search_form' );

// Disabled Emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// News in Vidgets
function devise_photorep() {
$the_query = new WP_Query( array( 'category_name' => 'photo', 'posts_per_page' => 5 ) );
if ( $the_query->have_posts() ) {
	$string .= '<ul class="photorep widget_recent_entries">';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
			if ( has_post_thumbnail() ) {
			$string .= '<li>';
			$string .= '<a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_post_thumbnail($post_id) .' <span class="phototext">' . get_the_title() .'</span></a></li>';
			} else {
			// if no featured image is found
			$string .= '<li><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() .'</a></li>';
			}
			}
	} else {
}
$string .= '</ul>';
return $string;

wp_reset_postdata();
}
// Добавляем шорткод
add_shortcode('photorep', 'devise_photorep');

// Активируем выполнение шорткода в текстовом виджете
add_filter('widget_text', 'do_shortcode');

function devise_video() {

$the_query = new WP_Query( array( 'category_name' => 'video', 'posts_per_page' => 3 ) );

if ( $the_query->have_posts() ) {
	$string .= '<ul class="video widget_recent_entries">';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
			if ( has_post_thumbnail() ) {
			$string .= '<li>';
			$string .= get_the_content() .'</li>';
			} else {
			// if no featured image is found
			$string .= '<li><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() .'</a></li>';
			}
			}
	} else {
}
$string .= '</ul>';
return $string;
wp_reset_postdata();
}
add_shortcode('video', 'devise_video');
add_filter('widget_text', 'do_shortcode');

// custom fields in event-posts
function true_custom_fields() {
	add_post_type_support( 'am_event', 'custom-fields');
}
add_action('init', 'true_custom_fields');

?>