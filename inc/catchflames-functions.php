<?php
/**
 * Register jquery scripts
 *
 * @register jquery cycle and custom-script
 * hooks action wp_enqueue_scripts
 */
function catchflames_scripts_method() {
	global $post, $wp_query, $catchflames_options_settings;
    	
	// Get value from Theme Options panel
	$options = $catchflames_options_settings;
	$enableslider = $options[ 'enable_slider' ];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');
	
	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	// Enqueue catchflames Sytlesheet
	wp_enqueue_style( 'catch-flames', get_stylesheet_uri() );
		
	
	
	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Register JQuery cycle all and JQuery set up as dependent on Jquery-cycle
	wp_register_script( 'jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array( 'jquery' ), '2.9999.5', true );
	
	// Slider JS load loop
	if ( ( $enableslider == 'enable-slider-allpage' ) || ( ( is_front_page() || ( is_home() && $page_id != $page_for_posts ) ) && $enableslider == 'enable-slider-homepage' ) ) {
		wp_enqueue_script( 'catchflames-slider', get_template_directory_uri() . '/js/catchflames.slider.js', array( 'jquery-cycle' ), '1.0', true );	
	}
	
	//Responsive
	wp_enqueue_script( 'sidr', get_template_directory_uri() . '/js/jquery.sidr.min.js', array('jquery'), '1.2.1', false );
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/fitvids.min.js', array( 'jquery' ), '20130324', true );
	
	/**
	 * Loads up Waypoint script
	 */
	wp_register_script( 'jquery-waypoint', get_template_directory_uri() . '/js/jquery.waypoints.min.js', array( 'jquery' ), '3.1.1', true );
	if ( '1' == $options['enable_header_top'] || '1' != $options['disable_scrollup'] ) :
		wp_enqueue_script( 'jquery-waypoint' );
	endif;

	/**
	 * Loads up Custom script
	 */
	wp_enqueue_script( 'catchflames-custom', get_template_directory_uri() . '/js/catchflames-custom.min.js', array( 'jquery' ), '20140823', true );	
	
	//Browser Specific Enqueue Script i.e. for IE 1-6
	$catchflames_ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(preg_match('/(?i)msie [1-6]/',$catchflames_ua)) {
		wp_enqueue_script( 'catchflames-pngfix', get_template_directory_uri() . '/js/pngfix.min.js' );	  
	}
	//browser specific queuing i.e. for IE 1-8
	if(preg_match('/(?i)msie [1-8]/',$catchflames_ua)) {
	 	wp_enqueue_script( 'catchflames-ieltc8', get_template_directory_uri() . '/js/catchflames-ielte8.min.js', array( 'jquery' ), '20130114', false );	
		wp_enqueue_style( 'catchflames-iecss', get_template_directory_uri() . '/css/ie.css' );
	}
	
} // catchflames_scripts_method
add_action( 'wp_enqueue_scripts', 'catchflames_scripts_method' );


/**
 * Register script for admin section
 *
 * No scripts should be enqueued within this function.
 * jquery cookie used for remembering admin tabs, and potential future features... so let's register it early
 * @uses wp_register_script
 * @action admin_enqueue_scripts
 */
function catchflames_register_js() {
	//jQuery Cookie
	wp_register_script( 'jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.min.js', array( 'jquery' ), '1.0', true );
}
add_action( 'admin_enqueue_scripts', 'catchflames_register_js' );

/**
 * Responsive Layout
 *
 * @display responsive meta tag 
 * @action wp_head
 */
function catchflames_responsive() {
	
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
	
} // catchflames_responsive
add_filter( 'wp_head', 'catchflames_responsive', 1 );


/**
 * Get the favicon Image from theme options
 *
 * @uses favicon 
 * @get the data value of image from theme options
 * @display favicon
 *
 * @uses default favicon if favicon field on theme options is empty
 *
 * @uses set_transient and delete_transient 
 */
function catchflames_favicon() {
	//delete_transient( 'catchflames_favicon' );	
	
	if( ( !$catchflames_favicon = get_transient( 'catchflames_favicon' ) ) ) {
		
		global $catchflames_options_settings;
        $options = $catchflames_options_settings;	
		
		echo '<!-- refreshing cache -->';
		if ( $options[ 'remove_favicon' ] == "0" ) :
			// if not empty fav_icon on theme options
			if ( !empty( $options[ 'fav_icon' ] ) ) :
				$catchflames_favicon = '<link rel="shortcut icon" href="'.esc_url( $options[ 'fav_icon' ] ).'" type="image/x-icon" />'; 	
			else:
				// if empty fav_icon on theme options, display default fav icon
				$catchflames_favicon = '<link rel="shortcut icon" href="'. get_template_directory_uri() .'/images/favicon.ico" type="image/x-icon" />';
			endif;
		endif;
		
		set_transient( 'catchflames_favicon', $catchflames_favicon, 86940 );	
	}	
	echo $catchflames_favicon ;	
} // catchflames_favicon

//Load Favicon in Header Section
add_action('wp_head', 'catchflames_favicon');

//Load Favicon in Admin Section
add_action( 'admin_head', 'catchflames_favicon' );


/**
 * Enqueue the styles for the current color scheme.
 *
 * @since Catch Flames 1.0
 */
function catchflames_enqueue_color_scheme() {
	global $catchflames_options_settings;
    $options = $catchflames_options_settings;	
	$color_scheme = $options['color_scheme'];

	if ( 'dark' == $color_scheme )
		wp_enqueue_style( 'dark', get_template_directory_uri() . '/colors/dark.css', array(), null );	

	do_action( 'catchflames_enqueue_color_scheme', $color_scheme );
}
add_action( 'wp_enqueue_scripts', 'catchflames_enqueue_color_scheme' );


/**
 * Hooks the Custom Inline CSS to head section
 *
 * @since Catch Flames 1.0
 */
function catchflames_inline_css() {
	delete_transient( 'catchflames_inline_css' );	
	
	global $catchflames_options_settings, $catchflames_options_defaults;
	$options = $catchflames_options_settings;	
	$defaults = $catchflames_options_defaults;
	
	$fonts = catchflames_available_fonts();
		
	if ( ( !$catchflames_inline_css = get_transient( 'catchflames_inline_css' ) ) && !empty( $options[ 'custom_css' ] ) ) {		
		echo '<!-- refreshing cache -->' . "\n";
			
		$catchflames_inline_css = '<!-- '.get_bloginfo('name').' inline CSS Styles -->' . "\n";
		$catchflames_inline_css	.= '<style type="text/css" media="screen">' . "\n";
			
		//Custom CSS Option
		if( !empty( $options[ 'custom_css' ] ) ) {
			$catchflames_inline_css	.=  $options['custom_css'] . "\n";
		}				
		
		$catchflames_inline_css	.= '</style>' . "\n";
			
		set_transient( 'catchflames_inline_css', $catchflames_inline_css, 86940 );
	}
	echo $catchflames_inline_css;
}
add_action('wp_head', 'catchflames_inline_css');


/**
 * Sets the post excerpt length.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function catchflames_excerpt_length( $length ) {
	global $catchflames_options_settings;
    $options = $catchflames_options_settings;
	
	if( empty( $options['excerpt_length'] ) )
		$options = catchflames_get_default_theme_options();
		
	$length = $options['excerpt_length'];
	return $length;
}
add_filter( 'excerpt_length', 'catchflames_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function catchflames_continue_reading_link() {
	global $catchflames_options_settings;
    $options = $catchflames_options_settings;
	$more_tag_text = $options[ 'more_tag_text' ];
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and catchflames_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function catchflames_auto_excerpt_more( $more ) {
	return catchflames_continue_reading_link();
}
add_filter( 'excerpt_more', 'catchflames_auto_excerpt_more' );


/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function catchflames_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= catchflames_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'catchflames_custom_excerpt_more' );


if ( ! function_exists( 'catchflames_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function catchflames_content_nav( $nav_id ) {
	global $wp_query;
	
	/**
	 * Check Jetpack Infinite Scroll
	 * if it's active then disable pagination
	 */
	if ( class_exists( 'Jetpack', false ) ) {
		$jetpack_active_modules = get_option('jetpack_active_modules');
		if ( $jetpack_active_modules && in_array( 'infinite-scroll', $jetpack_active_modules ) ) {
			return false;
		}
	}

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';
	
	if ( $wp_query->max_num_pages > 1 ) { ?>
        <nav role="navigation" id="<?php echo $nav_id; ?>">
        	<h3 class="assistive-text"><?php _e( 'Post navigation', 'catch-flames' ); ?></h3>
			<?php if ( function_exists('wp_pagenavi' ) )  { 
                wp_pagenavi();
            }
            elseif ( function_exists('wp_page_numbers' ) ) { 
                wp_page_numbers();
            }
            else { ?>	

            <?php 
            } ?>
        </nav><!-- #nav -->	
	<?php 
	}
}
endif; // catchflames_content_nav


/**
 * Return the URL for the first link found in the post content.
 *
 * @since Catch Flames 1.0
 * @return string|bool URL or false when no link is present.
 */
function catchflames_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}


if ( ! function_exists( 'catchflames_footer_sidebar_class' ) ) :
/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function catchflames_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;	

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;		
	}

	if ( $class )
		echo 'class="' . $class . '"';
}
endif; // catchflames_footer_sidebar_class


if ( ! function_exists( 'catchflames_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own catchflames_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Catch Flames 1.0
 */
function catchflames_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.	
	?>
   	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'catch-flames' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'catch-flames' ), '<span class="edit-link">', '</span>' ); ?></p> 
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>        
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'catch-flames' ) . '</span>' : ''
					);
					printf( '<time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s в %2$s', 'catch-flames' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'catch-flames' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'catch-flames' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Ответить пользователю', 'catch-flames' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif; //catchflames_comment

if ( ! function_exists( 'catchflames_posted_on' ) ) : 
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own catchflames_posted_on to override in a child theme
 *
 * @since Catch Flames 1.0
 */
function catchflames_posted_on() {
	/* Check Author URL to Support Google Authorship
	* 
	* By deault the author will link to author archieve page
	* But if the author have added their Website in Profile page then it will link to author website
	*/	
	if ( get_the_author_meta( 'user_url' ) != '' ) {
		$catchflames_author_url = 	esc_url( get_the_author_meta( 'user_url' ) );						  
	}
	else {
		$catchflames_author_url = esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) );
	}
	printf( __( '<span class="sep"><i class="fa fa-calendar" aria-hidden="true"></i>   </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date updated" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep">  <i class="fa fa-user" aria-hidden="true"></i> </span>  <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'catch-flames' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		$catchflames_author_url,
		esc_attr( sprintf( __( 'View all posts by %s', 'catch-flames' ), get_the_author() ) ),
		get_the_author()
	);	
}
endif; //catchflames_posted_on


if ( ! function_exists( 'catchflames_body_classes' ) ) :
/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 *
 * @since Catch Flames 1.0
 */
function catchflames_body_classes( $classes ) {
	//Getting Ready to load data from Theme Options Panel
	global $post, $wp_query, $catchflames_options_settings;
   	$options = $catchflames_options_settings;
	$themeoption_layout = $options['sidebar_layout'];
	$header_menu = $options['disable_header_menu'];	
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	
	// Check WooCommerce Sidebar
	if ( !is_active_sidebar( 'catchflames_woocommerce_sidebar' ) && ( class_exists( 'Woocommerce' ) && is_woocommerce() ) ) :
		$classes[] = 'woocommerce-nosidebar';
	endif;	
	
	// Check Fixed Header Top and Header Logo
	if ( !empty( $options['enable_header_top'] ) ) :
		if ( empty ( $options['disable_top_menu_logo'] ) ) : 
			$classes[] = 'has-header-top menu-logo';
		else :
			$classes[] = 'has-header-top';
		endif;
	endif; 


	if ( !empty( $options['enable_header_top'] ) ) :
		$classes[] = 'has-header-top';
		if ( empty( $options['disable_top_menu_logo'] ) ) {
			$classes[] = 'menu-logo';
		}
		if ( !has_nav_menu( 'top' ) ) {
			$classes[] = 'no-top-menu';
		}
	endif;

	// Check Mobile Header Menu
	$classes[] = 'has-header-left-menu';

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
			$layout = get_post_meta( $parent, 'catchflames-sidebarlayout', true );
		} else {
			$layout = get_post_meta( $post->ID, 'catchflames-sidebarlayout', true ); 
		}
	}
	else {
		$layout = 'default';	
	}

	//check empty and load default
	if ( empty( $layout ) ) {
		$layout = 'default';	
	}	

	if ( $layout == 'three-columns' || ( $layout=='default' && $themeoption_layout == 'three-columns' ) ) {
		$classes[] = 'three-columns';
	}
	elseif ( $layout == 'no-sidebar' || ( $layout=='default' && $themeoption_layout == 'no-sidebar' ) ) {
		$classes[] = 'no-sidebar';
	}
	elseif ( $layout == 'left-sidebar' || ( $layout=='default' && $themeoption_layout == 'left-sidebar' ) ) {
		$classes[] = 'left-sidebar two-columns';
	}
	elseif ( $layout == 'right-sidebar' || ( $layout=='default' && $themeoption_layout == 'right-sidebar' ) ) {
		$classes[] = 'right-sidebar two-columns';
	}		
	
	return $classes;
}
endif; //catchflames_body_classes

add_filter( 'body_class', 'catchflames_body_classes' );


/**
 * Adds in post and Page ID when viewing lists of posts and pages
 * This will help the admin to add the post ID in featured slider
 * 
 * @param mixed $post_columns
 * @return post columns
 */
function catchflames_post_id_column( $post_columns ) {
	$beginning = array_slice( $post_columns, 0 ,1 );
	$beginning[ 'postid' ] = __( 'ID', 'catch-flames'  );
	$ending = array_slice( $post_columns, 1 );
	$post_columns = array_merge( $beginning, $ending );
	return $post_columns;
}
add_filter( 'manage_posts_columns', 'catchflames_post_id_column' );
add_filter( 'manage_pages_columns', 'catchflames_post_id_column' );

function catchflames_posts_id_column( $col, $val ) {
	if( $col == 'postid' ) echo $val;
}
add_action( 'manage_posts_custom_column', 'catchflames_posts_id_column', 10, 2 );
add_action( 'manage_pages_custom_column', 'catchflames_posts_id_column', 10, 2 );

function catchflames_posts_id_column_css() {
	echo '<style type="text/css">#postid { width: 40px; }</style>';
}
add_action( 'admin_head-edit.php', 'catchflames_posts_id_column_css' );


/**
 * Alter the query for the main loop in home page
 * @uses pre_get_posts hook
 */
function catchflames_alter_home( $query ){
	global $post, $catchflames_options_settings;
    $options = $catchflames_options_settings;
	$cats = $options[ 'front_page_category' ];
	
	if ( !in_array( '0', $cats ) ) {
		if( $query->is_main_query() && $query->is_home() ) {
			$query->query_vars['category__in'] = $options[ 'front_page_category' ];
		}
	}	
	
}
add_action( 'pre_get_posts','catchflames_alter_home' );


/**
 * Remove div from wp_page_menu() and replace with ul.
 * @uses wp_page_menu filter
 */
function catchflames_wp_page_menu( $page_markup ) {
    preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches);
        $divclass = $matches[1];
        $replace = array('<div class="'.$divclass.'">', '</div>');
        $new_markup = str_replace($replace, '', $page_markup);
        $new_markup = preg_replace('/^<ul>/i', '<ul class="'.$divclass.'">', $new_markup);
        return $new_markup; }

add_filter( 'wp_page_menu', 'catchflames_wp_page_menu' );


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function catchflames_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'catchflames_page_menu_args' );


/**
 * Replacing classed in default wp_page_menu
 *
 * REPLACE "current_page_item" WITH CLASS "current-menu-item"
 * REPLACE "current_page_ancestor" WITH CLASS "current-menu-ancestor"
 */
function catchflames_current_to_active($text){
	$replace = array(
		// List of classes to replace with "active"
		'current_page_item' => 'current-menu-item',
		'current_page_ancestor' => 'current-menu-ancestor',
	);
	$text = str_replace(array_keys($replace), $replace, $text);
		return $text;
	}
add_filter( 'wp_page_menu', 'catchflames_current_to_active' );

if ( ! function_exists( 'catchflames_social_networks' ) ) :
/**
 * This function for social links display
 *
 * @fetch links through Theme Options
 * @use in widget
 * @social links, Facebook, Twitter and RSS
  */
function catchflames_social_networks() {
	//delete_transient( 'catchflames_social_networks' );
	
	// get the data value from theme options
	global $catchflames_options_settings;
	$options = $catchflames_options_settings;	

    $elements = array();

	$elements = array( 	$options[ 'social_facebook' ],
						$options[ 'social_twitter' ],
						$options[ 'social_googleplus' ],
						$options[ 'social_linkedin' ],
						$options[ 'social_pinterest' ],
						$options[ 'social_youtube' ],
						$options[ 'social_vimeo' ],
						$options[ 'social_aim' ],
						$options[ 'social_myspace' ],
						$options[ 'social_flickr' ],
						$options[ 'social_tumblr' ],
						$options[ 'social_deviantart' ],
						$options[ 'social_dribbble' ],
						$options[ 'social_myspace' ],
						$options[ 'social_wordpress' ],
						$options[ 'social_rss' ],
						$options[ 'social_slideshare' ],
						$options[ 'social_instagram' ],
						$options[ 'social_skype' ],
						$options[ 'social_soundcloud' ],
						$options[ 'social_email' ],
						$options[ 'social_contact' ],
						$options[ 'social_xing' ],
						$options[ 'enable_specificfeeds' ]
					);
	$flag = 0;
	if( !empty( $elements ) ) {
		foreach( $elements as $option) {
			if( !empty( $option ) ) {
				$flag = 1;
			}
			else {
				$flag = 0;
			}
			if( $flag == 1 ) {
				break;
			}
		}
	}	
	
	if ( ( !$catchflames_social_networks = get_transient( 'catchflames_social_networks' ) ) && ( $flag == 1 ) )  {
		echo '<!-- refreshing cache -->';
		
		$catchflames_social_networks .='
		<div class="social-profile"><ul>';
			//facebook
			if ( !empty( $options[ 'social_facebook' ] ) ) {
				$catchflames_social_networks .=
					'<li class="facebook"><a href="'.esc_url( $options[ 'social_facebook' ] ).'" title="'. esc_attr__( 'Facebook', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'Facebook', 'catch-flames' ).'</a></li>';
			}
			//Twitter
			if ( !empty( $options[ 'social_twitter' ] ) ) {
				$catchflames_social_networks .=
					'<li class="twitter"><a href="'.esc_url( $options[ 'social_twitter' ] ).'" title="'. esc_attr__( 'Twitter', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'Twitter', 'catch-flames' ).'</a></li>';
			}
			//Google+
			if ( !empty( $options[ 'social_googleplus' ] ) ) {
				$catchflames_social_networks .=
					'<li class="google-plus"><a href="'.esc_url( $options[ 'social_googleplus' ] ).'" title="'. esc_attr__( 'Google+', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'Google+', 'catch-flames' ).'</a></li>';
			}
			//Linkedin
			if ( !empty( $options[ 'social_linkedin' ] ) ) {
				$catchflames_social_networks .=
					'<li class="linkedin"><a href="'.esc_url( $options[ 'social_linkedin' ] ).'" title="'. esc_attr__( 'Linkedin', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'Linkedin', 'catch-flames' ).'</a></li>';
			}
			//Pinterest
			if ( !empty( $options[ 'social_pinterest' ] ) ) {
				$catchflames_social_networks .=
					'<li class="pinterest"><a href="'.esc_url( $options[ 'social_pinterest' ] ).'" title="'. esc_attr__( 'Pinterest', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'Pinterest', 'catch-flames' ).'</a></li>';
			}				
			//Youtube
			if ( !empty( $options[ 'social_youtube' ] ) ) {
				$catchflames_social_networks .=
					'<li class="you-tube"><a href="'.esc_url( $options[ 'social_youtube' ] ).'" title="'. esc_attr__( 'YouTube', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'YouTube', 'catch-flames' ).'</a></li>';
			}
			//Vimeo
			if ( !empty( $options[ 'social_vimeo' ] ) ) {
				$catchflames_social_networks .=
					'<li class="viemo"><a href="'.esc_url( $options[ 'social_vimeo' ] ).'" title="'. esc_attr__( 'Vimeo', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'Vimeo', 'catch-flames' ).'</a></li>';
			}				
			//Slideshare
			if ( !empty( $options[ 'social_aim' ] ) ) {
				$catchflames_social_networks .=
					'<li class="aim"><a href="'.esc_url( $options[ 'social_aim' ] ).'" title="'. esc_attr__( 'AIM', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'AIM', 'catch-flames' ).'</a></li>';
			}				
			//MySpace
			if ( !empty( $options[ 'social_myspace' ] ) ) {
				$catchflames_social_networks .=
					'<li class="myspace"><a href="'.esc_url( $options[ 'social_myspace' ] ).'" title="'. esc_attr__( 'MySpace', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'MySpace', 'catch-flames' ).'</a></li>';
			}
			//Flickr
			if ( !empty( $options[ 'social_flickr' ] ) ) {
				$catchflames_social_networks .=
					'<li class="flickr"><a href="'.esc_url( $options[ 'social_flickr' ] ).'" title="'. esc_attr__( 'Flickr', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'Flickr', 'catch-flames' ).'</a></li>';
			}
			//Tumblr
			if ( !empty( $options[ 'social_tumblr' ] ) ) {
				$catchflames_social_networks .=
					'<li class="tumblr"><a href="'.esc_url( $options[ 'social_tumblr' ] ).'" title="'. esc_attr__( 'Tumblr', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'Tumblr', 'catch-flames' ).'</a></li>';
			}
			//deviantART
			if ( !empty( $options[ 'social_deviantart' ] ) ) {
				$catchflames_social_networks .=
					'<li class="deviantart"><a href="'.esc_url( $options[ 'social_deviantart' ] ).'" title="'. esc_attr__( 'deviantART', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'deviantART', 'catch-flames' ).'</a></li>';
			}
			//Dribbble
			if ( !empty( $options[ 'social_dribbble' ] ) ) {
				$catchflames_social_networks .=
					'<li class="dribbble"><a href="'.esc_url( $options[ 'social_dribbble' ] ).'" title="'. esc_attr__( 'Dribbble', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'Dribbble', 'catch-flames' ).'</a></li>';
			}
			//WordPress
			if ( !empty( $options[ 'social_wordpress' ] ) ) {
				$catchflames_social_networks .=
					'<li class="wordpress"><a href="'.esc_url( $options[ 'social_wordpress' ] ).'" title="'. esc_attr__( 'WordPress', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'WordPress', 'catch-flames' ).'</a></li>';
			}				
			//RSS
			if ( !empty( $options[ 'social_rss' ] ) ) {
				$catchflames_social_networks .=
					'<li class="rss"><a href="'.esc_url( $options[ 'social_rss' ] ).'" title="'. esc_attr__( 'RSS', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'RSS', 'catch-flames' ).'</a></li>';
			}	
			//Slideshare
			if ( !empty( $options[ 'social_slideshare' ] ) ) {
				$catchflames_social_networks .=
					'<li class="slideshare"><a href="'.esc_url( $options[ 'social_slideshare' ] ).'" title="'. esc_attr__( 'Slideshare', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'Slideshare', 'catch-flames' ).'</a></li>';
			}
			//Instagram
			if ( !empty( $options[ 'social_instagram' ] ) ) {
				$catchflames_social_networks .=
					'<li class="instagram"><a href="'.esc_url( $options[ 'social_instagram' ] ).'" title="'. esc_attr__( 'Instagram', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'Instagram', 'catch-flames' ).'</a></li>';
			}				
			//Skype
			if ( !empty( $options[ 'social_skype' ] ) ) {
				$catchflames_social_networks .=
					'<li class="skype"><a href="'.esc_url( $options[ 'social_skype' ] ).'" title="'. esc_attr__( 'Skype', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'Skype', 'catch-flames' ).'</a></li>';
			}
			//Soundcloud
			if ( !empty( $options[ 'social_soundcloud' ] ) ) {
				$catchflames_social_networks .=
					'<li class="soundcloud"><a href="'.esc_url( $options[ 'social_soundcloud' ] ).'" title="'. esc_attr__( 'Soundcloud', 'catch-flames' ) .'" target="_blank">'. esc_attr__( 'Soundcloud', 'catch-flames' ) .'</a></li>';
			}	
			//Email
			if ( !empty( $options[ 'social_email' ] )  && is_email( $options[ 'social_email' ] ) ) {
				$catchflames_social_networks .=
					'<li class="email"><a href="mailto:'.sanitize_email( $options[ 'social_email' ] ).'" title="'. esc_attr__( 'Email', 'catch-flames' ) .'" target="_blank">'. esc_attr__( 'Email', 'catch-flames' ) .'</a></li>';
			}
			//Contact
			if ( !empty( $options[ 'social_contact' ] ) ) {
				$catchflames_social_networks .=
					'<li class="contactus"><a href="'.esc_url( $options[ 'social_contact' ] ).'" title="'. esc_attr__( 'Contact', 'catch-flames' ) .'">'.esc_attr__( 'Contact', 'catch-flames' ).'</a></li>';
			}	
			//Xing
			if ( !empty( $options[ 'social_xing' ] ) ) {
				$catchflames_social_networks .=
					'<li class="xing"><a href="'.esc_url( $options[ 'social_xing' ] ).'" title="'. esc_attr__( 'Xing', 'catch-flames' ) .'" target="_blank">'.esc_attr__( 'Xing', 'catch-flames' ).'</a></li>';
			}			
			//SpecificFeeds
			if ( !empty( $options[ 'enable_specificfeeds' ] ) ) {
				$catchflames_social_networks .=
					'<li class="specificfeeds"><a href="'.esc_url( 'http://www.specificfeeds.com/follow' ).'" title="'. esc_attr__( 'SpecificFeeds', 'catch-flames' ) .'" target="_blank">'. esc_attr__( 'SpecificFeeds', 'catch-flames' ) .'</a></li>';
			}				
			$catchflames_social_networks .='
		</ul></div>';
		
		set_transient( 'catchflames_social_networks', $catchflames_social_networks, 86940 );	 
	}
	echo $catchflames_social_networks;
}
endif; //catchflames_social_networks


if ( ! function_exists( 'catchflames_post_featured_image' ) ) :
/**
 * Template for Featured Image in Content
 *
 * To override this in a child theme
 * simply create your own catchflames_post_featured_image(), and that function will be used instead.
 *
 * @since Catch Flames 1.0
 */
function catchflames_post_featured_image() {
	// Getting data from Theme Options
	global $post, $wp_query, $catchflames_options_settings;
	$options = $catchflames_options_settings;
	$contentlayout = $options['content_layout'];
	$sidebarlayout = $options['sidebar_layout'];
	
	$imagesize = '';
	
	if ( $contentlayout == 'full' ) :
		return false;
	elseif ( $contentlayout == 'excerpt' ) :
		if ( $sidebarlayout == 'three-columns' ) :
			$imagesize = 'featured-three';
		else :
			$imagesize = 'featured';
		endif;
	endif; 
	
    if ( has_post_thumbnail() ) : ?>	
       <figure class="featured-image">
	<figcaption><h2><?php
$category = get_the_category(); 
echo $category[0]->cat_name;
?></h2></figcaption>	
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'catch-flames' ), the_title_attribute( 'echo=0' ) ) ); ?>">
                <?php the_post_thumbnail( $imagesize ); ?>
            </a>
        </figure>
   	<?php endif;
   	
}
endif; //catchflames_post_featured_image 


/**
 * Adds classes to the array of post classes.
 *
 * @since Catch Flames 1.0
 */
function catchflames_post_classes( $classes ) {
	//Getting Ready to load data from Theme Options Panel
	global $post, $wp_query, $catchflames_options_settings;
   	$options = $catchflames_options_settings;
	$contentlayout = $options['content_layout'];

	if ( is_archive() || is_home() ) {
		if ( $contentlayout == 'excerpt-small' ) :
			$classes[] = 'image-left image-featured';
		elseif ( $contentlayout == 'excerpt-square' ) :
			$classes[] = 'image-square';
		elseif ( $contentlayout == 'excerpt-tall' ) :
			$classes[] = 'image-tall';		
		elseif ( $contentlayout == 'excerpt-full' ) :
			$classes[] = 'image-full-width image-full';	
		elseif ( $contentlayout == 'excerpt' ) :
			$classes[] = 'image-full-width image-featured';	
		endif;
	}
		
	return $classes;
}
add_filter( 'post_class', 'catchflames_post_classes' );


/**
 * Get the Web Clip Icon Image from theme options
 *
 * @uses web_clip and remove_web_clip 
 * @get the data value of image from theme options
 * @display favicon
 *
 * @uses default Web Click Icon if web_clip field on theme options is empty
 *
 * @uses set_transient and delete_transient 
 */
function catchflames_web_clip() {
	//delete_transient( 'catchflames_web_clip' );	
	
	if( ( !$catchflames_web_clip = get_transient( 'catchflames_web_clip' ) ) ) {
		
		global $catchflames_options_settings;
        $options = $catchflames_options_settings;	
		
		echo '<!-- refreshing cache -->';
		if ( $options[ 'remove_web_clip' ] == "0" ) :
			// if not empty fav_icon on theme options
			if ( !empty( $options[ 'web_clip' ] ) ) :
				$catchflames_web_clip = '<link rel="apple-touch-icon-precomposed" href="'.esc_url( $options[ 'web_clip' ] ).'" />'; 	
			else:
				// if empty fav_icon on theme options, display default fav icon
				$catchflames_web_clip = '<link rel="apple-touch-icon-precomposed" href="'. get_template_directory_uri() .'/images/apple-touch-icon.png" />';
			endif;
		endif;
		
		set_transient( 'catchflames_web_clip', $catchflames_web_clip, 86940 );	
	}	
	echo $catchflames_web_clip ;	
} // catchflames_web_clip

//Load WebClip Icon in Header Section
add_action('wp_head', 'catchflames_web_clip');

/**
 * Third Sidebar
 *
 * @Hooked in catchflames_before_primary
 * @since Catch Flames 1.1
 */

function catchflames_third_sidebar() {
	get_sidebar( 'third' ); 
}  
add_action( 'catchflames_after_contentsidebarwrap', 'catchflames_third_sidebar', 10 );   


/**
 * Footer Sidebar
 *
 * @Hooked in catchflames_footer
 * @since Catch Flames 1.0
 */
function catchflames_footer_sidebar() {
	get_sidebar( 'footer' ); 
}  
add_action( 'catchflames_footer', 'catchflames_footer_sidebar', 10 ); 


/**
 * Footer Site Generator Open
 *
 * @Hooked in catchflames_site_generator
 * @since Catch Flames 1.0
 */
function catchflames_site_generator_open() {
	echo '<div id="site-generator">

<div class="wrapper">

<!-- ZERO.kz -->


<script type="text/javascript"><!--
var _zero_kz_ = _zero_kz_ || [];
_zero_kz_.push(["id", 66116]);
_zero_kz_.push(["type", 1]);

(function () {
    var a = document.getElementsByTagName("script")[0],
    s = document.createElement("script");
    s.type = "text/javascript";
    s.async = true;
    s.src = (document.location.protocol == "https:" ? "https:" : "http:")
    + "//c.zero.kz/z.js";
    a.parentNode.insertBefore(s, a);
})(); //-->
</script>
<!-- End ZERO.kz -->';
}  
add_action( 'catchflames_site_generator', 'catchflames_site_generator_open', 10 ); 

/**
 * Footer Social Icons
 *
 * @Hooked in catchflames_site_generator
 * @since Catch Flames 1.0 
 */
function catchflames_footer_social() {		
	global $catchflames_options_settings;
	$options = $catchflames_options_settings;	
	
	echo '<!-- refreshing cache -->';
	if ( !empty( $options[ 'disable_footer_social' ] ) ) :
		return catchflames_social_networks(); 
	endif;	
}
add_action( 'catchflames_site_generator', 'catchflames_footer_social', 20 );


/**
 * Footer Content
 *
 * @Hooked in catchflames_site_generator
 * @since Catch Flames 1.0  
 */
function catchflames_footer_content() { 
	//delete_transient( 'catchflames_footer_content' );	
	
	if ( ( !$catchflames_footer_content = get_transient( 'catchflames_footer_content' ) ) ) {
		echo '<!-- refreshing cache -->';
			
        $catchflames_footer_content = catchflames_assets();
		
    	set_transient( 'catchflames_footer_content', $catchflames_footer_content, 86940 );
    }
	echo $catchflames_footer_content;
}
add_action( 'catchflames_site_generator', 'catchflames_footer_content', 30 );


/**
 * Footer Site Generator Close
 *
 * @Hooked in catchflames_site_generator
 * @since Catch Flames 1.0
 */
function catchflames_site_generator_close() {
	echo '</div><!-- .wrapper --></div><!-- #site-generator -->';
}  
add_action( 'catchflames_site_generator', 'catchflames_site_generator_close', 100 ); 

/**
 * This function loads Scroll Up Navigation
 *
 * @uses catchflames_after action
 */
function catchflames_scrollup() {
       // get the data value from theme options
       global $catchflames_options_settings;
       $options = $catchflames_options_settings;

       if ( empty( $options['disable_scrollup'] ) ) {        
               echo '<a href="#page" id="scrollup"></a>';
       }
       
}
add_action( 'catchflames_after', 'catchflames_scrollup', 10 );

add_filter( 'widget_title', 'hide_widget_title' );
function hide_widget_title( $title ) {
    if ( empty( $title ) ) return '';
    if ( $title[0] == '!' ) return '';
    return $title;
}

function nav() {
global $wp_query, $wp_rewrite;
$pages = '';
$max = $wp_query->max_num_pages;
if (!$current = get_query_var('paged')) $current = 1;
$a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
$a['total'] = $max;
$a['current'] = $current;
$total = 1; //1 - вывод текста "Страница N из N", 0 - не выводить
$a['mid_size'] = 3; //количество ссылок на страницы слева и справа от текущей
$a['end_size'] = 5; //Количество ссылок вначале и в конце
$a['prev_text'] = '&laquo; Предыдущая '; //отображение ссылки для предыдущей страницы
$a['next_text'] = 'Следующая &raquo;'; //отображение ссылки для следующей страницы
if ($max > 1) echo '<div class="nav">';
if ($total = 1 && $max > 1) $pages = '<span>Страница ' . $current . ' из ' . $max . '</span>'."\r\n";
echo $pages . paginate_links($a);
if ($max > 1) echo '</div>';
}

// dashboard prosmotr
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('Просмотры');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
    if($column_name === 'post_views'){
        echo getPostViews(get_the_ID());
    }
}

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count.' ';
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


function remove_more_link() { return ''; }
add_filter('the_content_more_link', 'remove_more_link');

// добавляем шорткод cat_desc, который будет заменен результатом выполнения функции cat_desc()
add_shortcode( 'cat_desc', 'cat_desc' );
// разрешаем выполнение шорткода в описаниях
add_filter( 'term_description', 'do_shortcode' );
function cat_desc($attr, $text=''){
	echo '<div class="cat-desc">';
	echo "<img class='wp-post-image' src='{$attr['src']}' alt=''>";
	echo $text;
	echo '</div>';
}

// Закрываем блог на ремонт
function wp_maintenance_mode(){
if(!current_user_can('edit_themes') || !is_user_logged_in()){
wp_die('<img width="50px" align="left" src="http://s019.radikal.ru/i627/1707/f8/00df24303cc2.jpg"><p style="font-size: 21pt; padding-top: 5px; text-align: center;"> AlSport.kz скоро вернётся обновлённым</p><br />
<p style="font-size: 14pt; text-align: center;">Следите за нашими новостями в социальных сетях:</p>

<p style="text-align: center;">
<a href="//vk.com/alsportkz" target="_blank"><img style="margin: 0 10px;" src="http://s014.radikal.ru/i326/1707/7f/d9d59b452afb.png"></a> 
<a href="//instagram.com/alsport.kz/" target="_blank"><img style="margin: 0 10px;" src="http://s019.radikal.ru/i635/1707/00/435fd98c33b1.png"></a> 
<a href="//facebook.com/alsport.kz/" target="_blank"><img style="margin: 0 10px;" src="http://s019.radikal.ru/i620/1707/c3/940df953373a.png"></a> 
<a href="//twitter.com/alsportkz" target="_blank"><img style="http://radikal.ru"><img src="http://s013.radikal.ru/i323/1707/f9/bce656be017a.png"></a> </p>');
}
}
//add_action('get_header', 'wp_maintenance_mode');