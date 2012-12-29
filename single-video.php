<?php get_header(); ?>
<article id="content">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <h2><?php the_title();?></h2>
  <iframe width="650" height="366" src="http://www.youtube.com/embed/<?php echo get_post_meta($post->ID, '_video_id',true); ?>?rel=0&iv_load_policy=3&modestbranding=1&wmode=opaque" frameborder="0" allowfullscreen></iframe>
  <p><?php echo get_post_meta($post->ID, '_video_descr',true); ?></p>
<?php endwhile; endif; ?>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
