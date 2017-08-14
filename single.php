<?php
global $post; // < -- globalize, just in case
$field = get_post_meta($post->ID, 'redirect', true);
if($field) wp_redirect(clean_url($field), 301);
get_header();
?>

				<?php while ( have_posts() ) : the_post(); ?>



					<?php get_template_part( 'content', 'single' ); ?>

					<?php 
                    // If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) {
						comments_template( '', true );
					} ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->
        
<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php setPostViews(get_the_ID()); ?>