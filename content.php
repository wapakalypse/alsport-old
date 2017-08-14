<?php
/**
 * The default template for displaying content
 *
 * @package Catch Themes
 * @subpackage Catch Flames
 * @since Catch Flames 1.0
 */
?>
<?php
	// Get data value from theme options
	global $catchflames_options_settings;
    $options = $catchflames_options_settings;
	$current_content_layout = $options['content_layout'];
	$more_tag_text = $options[ 'more_tag_text' ];
	
	// Get the Excerpt
	$catchflames_excerpt = get_the_excerpt();
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    	                <div class="entry-meta">
                        <?php catchflames_posted_on(); ?>
                     
<?php edit_post_link( __( 'Edit', 'catch-flames' ), '<span class="edit-link">', '</span>' ); ?>

                    </div><!-- .entry-meta -->
    	
		<?php if ( function_exists( 'catchflames_post_featured_image' ) ) : catchflames_post_featured_image(); endif; ?>
        
        
        <div class="entry-container">
        
            <header class="entry-header">
                <?php if ( is_sticky() ) : ?>
                    <hgroup>
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'catch-flames' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <h3 class="entry-format"><?php _e( 'Featured', 'catch-flames' ); ?></h3>
                    </hgroup>
                <?php else : ?>
                <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'catch-flames' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                <?php endif; ?>
    
                <?php if ( 'post' == get_post_type() ) : ?>

                <?php endif; ?>
            </header><!-- .entry-header -->

            <?php 
            if ( is_search() ) : // Only display Excerpts for Search ?>
                <div class="entry-summary">
                    <?php the_excerpt(); ?>
                </div><!-- .entry-summary -->
            <?php elseif ( post_password_required() ) : // Password Protected Post ?>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-summary -->    
            <?php elseif ( $current_content_layout!='full' && !empty( $catchflames_excerpt ) ) : // Only display Featured Image and Excerpts if checked in Theme Option ?>
                <div class="entry-summary">
                    <?php the_excerpt(); ?>
                </div><!-- .entry-summary -->
            <?php else : ?>
            <div class="entry-content">
                <?php 
                the_content( sprintf( __( '%s', 'catch-flames' ), esc_attr( $more_tag_text ) ) ); ?>
                <?php wp_link_pages( array( 
                    'before'		=> '<div class="page-link"><span class="pages">' . __( 'Pages:', 'catch-flames' ) . '</span>',
                    'after'			=> '</div>',
                    'link_before' 	=> '<span>',
                    'link_after'   	=> '</span>',
                ) ); 
                ?>
            </div><!-- .entry-content -->
            <?php endif; ?>
    		
            <?php if ( $current_content_layout != 'excerpt-thumbnail' ) : ?>

            <?php endif; ?>
            
      	</div><!-- .entry-container -->    
        
	</article><!-- #post-<?php the_ID(); ?> -->