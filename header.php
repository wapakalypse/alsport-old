<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Catch Themes
 * @subpackage Catch Flames
 * @since Catch Flames 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="charset=UTF-8" />
<title><?php wp_title( '|', true, 'right' ); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />

<link href="https://alsport.kz/xmlrpc.php" rel="pingback"/>


<script src="https://use.fontawesome.com/1f3f980e35.js"></script>

<script type="text/javascript">
$(function(){
    $(window).scroll(function() {
        var top = $(document).scrollTop();
        if (top < 240) $("#header-menu").css({top: '0', position: 'relative'});
        else $("#header-menu").css({top: '0px', width: '100%', position: 'fixed', opacity: '0.93'});
    });
});
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-70097018-2', 'auto');
  ga('send', 'pageview');
</script>

<meta name="google-site-verification" content="2Z6iy5RGIs-hMgFjNhhZJt1XaUBbq4yZs-V83M76K60" />
<meta name="yandex-verification" content="d5879e6802191b7a" />
<link rel="canonical" href="https://alsport.kz/"/> 

</head>
<?php
	wp_head();
?>

<body <?php body_class(); ?>>

<?php 
/** 
 * catchflames_before hook
 */
do_action( 'catchflames_before' ); ?>

<div id="page" class="hfeed site">

	<?php 
    /** 
     * catchflames_before_header hook
     */
    do_action( 'catchflames_before_header' ); ?>
        
	<header id="branding" role="banner">
   	<?php 
                /** 
                 * catchflames_headercontent hook
                 *
                 * @hooked catchflames_headerdetails - 20
                 * @hooked catchflames_header_rightsidebar - 30
                 */
                do_action( 'catchflames_headercontent' ); ?>     

<div class="social">
<form role="search" method="get" id="searchform" class="searchform" action="/">
<input type="text" placeholder="Поиск" name="s" id="s">
</form><a href="https://vk.com/alsportkz" target="_blank"><i class="fa fa-vk" aria-hidden="true"></i></a>
<a href="https://www.instagram.com/alsport.kz/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
<a href="https://www.facebook.com/alsport.kz/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
<a href="https://twitter.com/alsportkz" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
</div>

            </div><!-- .wrapper -->

    	<?php 
		/** 
		 * catchflames_after_headercontent hook
		 *
         * @hooked catchflames_header_menu - 10
		 */
		do_action( 'catchflames_after_headercontent' ); ?>           
        
	</header><!-- #branding -->
    
	<?php 
    /** 
     * catchflames_after_header hook
     *
     * @hooked catchflames_featured_header - 10
     * @hooked catchflames_header_menu - 15
     */
     do_action( 'catchflames_after_header' ); ?>
    
    <div id="main-wrapper">
    
		<?php 
        /** 
         * catchflames_before_main hook
		 *
		 * @hooked catchflames_slider_display - 10 if full width image slide is selected		 
         */
        do_action( 'catchflames_before_main' ); ?>
    
		<div id="main">
    
			<?php 
            /** 
             * catchflames_before_main_wrapper hook
             */
            do_action( 'catchflames_before_main_wrapper' ); ?>
        
            <div class="wrapper">
                
                <?php 
                /** 
                 * catchflames_before_contentsidebarwrap hook
                 */
                do_action( 'catchflames_before_contentsidebarwrap' ); ?> 
                
                <div class="content-sidebar-wrap">

					<?php 
                    /** 
                     * catchflames_before_primary hook
                     */
                    do_action( 'catchflames_before_primary' ); ?>
                
                    <div id="primary">
            
						<?php 
                        /** 
                         * catchflames_before_content hook
                         */
                        do_action( 'catchflames_before_content' ); ?>
                    
						<div id="content" role="main">
                    
							<?php 
                            /** 
                             * catchflames_content hook
                             *
                             * @hooked catchflames_slider_display - 10 if full width image slide is not selected
                             */
                            do_action( 'catchflames_content' ); ?>