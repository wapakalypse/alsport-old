<?php
/**
 * The template for displaying posts in the Link Post Format on index and archive pages
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

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<hgroup>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'catch-flames' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<h3 class="entry-format"><?php _e( 'Link', 'catch-flames' ); ?></h3>
			</hgroup>

			<?php if ( comments_open() && ! post_password_required() ) : ?>
                <div class="comments-link">
                    <?php comments_popup_link(__('Leave a reply', 'catch-flames'), __('1 Comment &darr;', 'catch-flames'), __('% Comments &darr;', 'catch-flames')); ?>
                </div>
			<?php endif; ?>
		</header><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'catch-flames' ) ); ?>
			<?php wp_link_pages( array( 
                'before'		=> '<div class="page-link"><span class="pages">' . __( 'Pages:', 'catch-flames' ) . '</span>',
                'after'			=> '</div>',
                'link_before' 	=> '<span>',
                'link_after'   	=> '</span>',
            ) ); 
            ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">
			<?php catchflames_posted_on(); ?>
			<?php if ( comments_open() && ! post_password_required() ) : ?>
                <span class="sep"> | </span>
                <span class="comments-link"><?php comments_popup_link(__('Leave a reply', 'catch-flames'), __('1 Comment &darr;', 'catch-flames'), __('% Comments &darr;', 'catch-flames')); ?></span>
			<?php endif; ?>
			<?php edit_post_link( __( 'Edit', 'catch-flames' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- #entry-meta -->
	</article><!-- #post-<?php the_ID(); ?> -->
