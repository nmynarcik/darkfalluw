<?php
/*
Template Name: DF Map
*/
get_header();
wp_enqueue_script('dfuw_jquery','http://maps.googleapis.com/maps/api/js?sensor=false',false,'1.6','all');
wp_enqueue_script('dfuw_map',get_template_directory_uri().'/js/agon.map.js',false,'1.6','all');
?>
<article id="content">
<?php the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="entry-content">
  <?php the_content(); ?>
  <div id="map_canvas" style="background: #1B2D33;"></div>
</div>
</div>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
