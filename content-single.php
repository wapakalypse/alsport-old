<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package Catch Themes
 * @subpackage Catch Flames
 * @since Catch Flames 1.0
 */
//Getting data from Theme Options Panel
global $catchflames_options_settings;
$options = $catchflames_options_settings; ?>

<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>
 
	<br /><center><h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'catch-flames' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1></center>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    	                    <div class="entry-meta">
                        <?php catchflames_posted_on(); ?>
<script type="text/javascript">window.onload=(function() {
  if (window.pluso)if (typeof window.pluso.start == "function") return;
  if (window.ifpluso==undefined) { window.ifpluso = 1;
    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
  }})()
</script>
<div class="pluso" data-background="transparent" data-options="small,square,line,horizontal,noncounter,theme=01" data-services="vkontakte,facebook,twitter"></div>

                    </div><!-- .entry-meta -->

		<?php if ( function_exists( 'catchflames_post_featured_image' ) ) : catchflames_post_featured_image(); endif; ?>
  
        <div class="entry-container">
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 
			'before'		=> '<div class="page-link"><span class="pages">' . __( 'Pages:', 'catch-flames' ) . '</span>',
			'after'			=> '</div>',
			'link_before' 	=> '<span>',
			'link_after'   	=> '</span>',
		) ); 
		?>
	</div><!-- .entry-content -->

                <footer class="entry-meta">
                    <?php $show_sep = false; ?>
                    <?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
                    <?php
                        /* translators: used between list items, there is a space after the comma */
                        $categories_list = get_the_category_list( __( ', ', 'catch-flames' ) );
                        if ( $categories_list ):
                    ?>
                    <span class="cat-links">
                        <?php printf( __( '<span class="%1$s">Категория:</span> %2$s', 'catch-flames' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
                        $show_sep = true; ?>
                    </span>
                    <?php endif; // End if categories ?>
                    <?php
                        /* translators: used between list items, there is a space after the comma */
                        $tags_list = get_the_tag_list( '', __( ', ', 'catch-flames' ) );
                        if ( $tags_list ):
                        if ( $show_sep ) : ?>
                    <span class="sep"> | </span>
                        <?php endif; // End if $show_sep ?>
                    <span class="tag-links">
                        <?php printf( __( '<span class="%1$s">Теги:</span> %2$s', 'catch-flames' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
                        $show_sep = true; ?>
                    </span>
                    <?php endif; // End if $tags_list ?>
                    <?php endif; // End if 'post' == get_post_type() ?>
        
                    <?php edit_post_link( __( 'Edit', 'catch-flames' ), '<span class="edit-link">', '</span>' ); ?>
         </footer><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->

<div class="similar_records">
<h3>Похожие записи:</h3>
<?php $tags = wp_get_post_tags($post->ID);
if ($tags) {
 $tag_ids = array();
 foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
 $args=array(
 'tag__in' => $tag_ids, // Сортировка происходит по тегам (меткам)
 'orderby'=>rand, // Добавляем условие сортировки рандом (случайный подбор)
 'caller_get_posts'=>1, // Запрещаем повторение ссылок
 'post__not_in' => array($post->ID),
 'showposts'=>6 // Цифра означает количество выводимых записей
 );
 $my_query = new wp_query($args);
 if( $my_query->have_posts() ) {
 echo '<ul>';
        while ($my_query->have_posts()) {
            $my_query->the_post();
        ?>
<li><div class="cell"><a onclick="return !window.open(this.href)" href="<?php the_permalink() ?>"><?php the_post_thumbnail('thumbnail'); ?></a><br>
<a onclick="return !window.open(this.href)" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></div></li>
<?php
}
echo '</ul>';
}
wp_reset_query();} 
?></div>

<?php if ( get_the_author_meta( 'description' ) && ( ! function_exists( 'is_multi_author' ) || is_multi_author() ) ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries ?>
		<div id="author-info">
			<div id="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'catchflames_author_bio_avatar_size', 68 ) ); ?>
			</div><!-- #author-avatar -->
			<div id="author-description">
				<h2><?php printf( __( 'About %s', 'catch-flames' ), get_the_author() ); ?></h2>
				<?php the_author_meta( 'description' ); ?>
				<div id="author-link">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
						<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'catch-flames' ), get_the_author() ); ?>
					</a>
				</div><!-- #author-link	-->
			</div><!-- #author-description -->
		</div><!-- #entry-author-info -->
<?php endif; ?>        
