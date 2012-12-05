<?php get_header(); ?>
<div id="content">
<?php the_post(); ?>
<!--<h1 class="page-title"><?php _e( 'Category Archives:', 'darkfalluw' ) ?> <span><?php single_cat_title() ?></span></h1>-->
<h1 class="page-title"><span><?php single_cat_title() ?></span></h1>
<?php $categorydesc = category_description(); if ( !empty($categorydesc) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>
<?php rewind_posts(); ?>
<?php get_template_part( 'nav', 'above' ); ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php if(has_post_thumbnail()){
  echo '<a href="'.get_permalink().'">';
  the_post_thumbnail(array(50,50),array(
                                                            'title'=>$post->post_title,
                                                            'alt'=>$post->post_title
                                                            ));
  echo '</a>';
} ?>
<?php get_template_part( 'entry' ); ?>
<?php endwhile; ?>
<?php get_template_part( 'nav', 'below' ); ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
