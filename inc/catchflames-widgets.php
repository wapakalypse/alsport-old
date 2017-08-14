<?php
/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since Catch Flames 1.0
 */
function catchflames_widgets_init() {
	//Primary Sidebar
	register_sidebar( array(
		'name'			=> __( 'Primary Sidebar', 'catch-flames' ),
		'id'			=> 'sidebar-1',
		'description'	=> __( 'This is the primary sidebar if you are using a two or three column site layout option.', 'catch-flames' ),
		'before_widget'	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	=> "</aside>",
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
	) );	

	//Secondary Sidebar
	register_sidebar( array(
		'name'			=> __( 'Secondary Sidebar', 'catch-flames' ),
		'id'			=> 'catchflames_third',
		'description'	=> __( 'This is the secondary sidebar if you are using a three column site layout option.', 'catch-flames' ),
		'before_widget'	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	=> "</aside>",
		'before_title'	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
	) );
	
	// WooCommerce Sidebar
	if ( class_exists( 'Woocommerce' ) ) {
		register_sidebar( array(
			'name' => __( 'WooCommerce Sidebar', 'catch-flames' ),
			'id' => 'catchflames_woocommerce_sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}
	
	//Footer One Sidebar
	register_sidebar( array(
		'name' => __( 'Footer Area One', 'catch-flames' ),
		'id' => 'sidebar-2',
		'description' => __( 'An optional widget area for your site footer', 'catch-flames' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	//Footer Two Sidebar
	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'catch-flames' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional widget area for your site footer', 'catch-flames' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	//Footer Three Sidebar
	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'catch-flames' ),
		'id' => 'sidebar-4',
		'description' => __( 'An optional widget area for your site footer', 'catch-flames' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
}
add_action( 'widgets_init', 'catchflames_widgets_init' );