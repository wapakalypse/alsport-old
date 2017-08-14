<?php
/**
 * The template for displaying posts in the Image Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package Catch Themes
 * @subpackage Catch Flames
 * @since Catch Flames 1.0
 */
//Getting data from Theme Options Panel
global $catchflames_options_settings;
$options = $catchflames_options_settings; ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'indexed' ); ?>>

    	                <div class="entry-meta">
                        <?php catchflames_posted_on(); ?>
                     
<?php edit_post_link( __( 'Edit', 'catch-flames' ), '<span class="edit-link">', '</span>' ); ?>

                    </div><!-- .entry-meta -->

		<header class="entry-header">
			<hgroup>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'catch-flames' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<h3 class="entry-format"><?php _e( 'Image', 'catch-flames' ); ?></h3>
			</hgroup>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php 
			global $catchflames_options_settings;
			$options = $catchflames_options_settings;
			$more_tag_text = $options[ 'more_tag_text' ];
			the_content( sprintf( __( '%s', 'catch-flames' ), esc_attr( $more_tag_text ) ) ); ?>
			<?php wp_link_pages( array( 
                'before'		=> '<div class="page-link"><span class="pages">' . __( 'Pages:', 'catch-flames' ) . '</span>',
                'after'			=> '</div>',
                'link_before' 	=> '<span>',
                'link_after'   	=> '</span>',
            ) ); 
            ?>
		</div><!-- .entry-content -->



			<?php edit_post_link( __( 'Edit', 'catch-flames' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- #entry-meta -->
	</article><!-- #post-<?php the_ID(); ?> -->
