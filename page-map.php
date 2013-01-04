<?php
/*
Template Name: DF Map
*/
global $ver;
get_header();
wp_enqueue_script('dfuw_jquery','http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false',false,'1.6','all');
wp_enqueue_script('dfuw_map',get_template_directory_uri().'/js/agon.map.js',false,$ver,'all');
?>
<article id="content" class='full-width'>
<?php the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="entry-content">
  <?php the_content(); ?>
  <div id="map-container">
    <div id="map-legend">
      <a href="javascript:void(0);" class="fs-btn" title="Toggle Fullscreen"><i>Toggle Fullscreen</i></a>
      <a href="javascript:void(0);" class="mob-btn" title="Toggle Mobs"><i>Toggle Mobs</i></a>
      <a href="javascript:void(0);" class="bank-btn" title="Toggle Banks"><i>Toggle Banks</i></a>
      <a href="javascript:void(0);" class="craft-btn" title="Toggle Crafting Stations"><i>Toggle Crafting Stations</i></a>
      <a href="javascript:void(0);" class="bind-btn" title="Toggle Bindstones"><i>Toggle Bindstones</i></a>
      <a href="javascript:void(0);" class="portal-btn" title="Toggle Portals"><i>Toggle Portals</i></a>
    </div>
    <div id="map_canvas"></div>
  </div>
</div>
</div>
</article>
<?php get_footer(); ?>
