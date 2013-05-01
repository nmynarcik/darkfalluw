<?php
/*
Template Name: DF Map
*/
global $ver;
get_header();
wp_enqueue_script('dfuw_jquery','http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false',false,'1.6','all');
wp_enqueue_script('dfuw_map',get_template_directory_uri().'/js/agon.map.min.js',false,$ver,'all');
?>
<script type="text/javascript">
  // var userPOI = "<?php echo $_GET['loc'] ?>";
  var userPOI = window.location.hash.substr(1);
</script>
<article id="content" class='full-width map'>
<?php the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="entry-content">
  <?php the_content(); ?>
  <div id="map-container">
    <div class="gad">
     <script type="text/javascript"><!--
      google_ad_client = "ca-pub-0373971494255887";
      /* SlimJim */
      google_ad_slot = "3579150709";
      google_ad_width = 728;
      google_ad_height = 15;
      //-->
      </script>
      <script type="text/javascript"
      src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
      </script>
    </div>
    <div id="map-search">
      <input type="text" id="mapsearch-text" placeholder="SEARCH"/>
      <button class="btn" id="searchmap"><i class="icon-search icon-white"></i></button>
    </div>
    <div id="map-legend">
      <a href="javascript:void(0);" id="fs-btn" title="Toggle Fullscreen"><i>Toggle Fullscreen</i></a>
      <a href="javascript:void(0);" id="mob-btn" title="Toggle Mobs"><i>Toggle Mobs</i></a>
      <a href="javascript:void(0);" id="bank-btn" title="Toggle Banks"><i>Toggle Banks</i></a>
      <a href="javascript:void(0);" id="holding-btn" title="Toggle Holdings"><i>Toggle Holdings</i></a>
      <a href="javascript:void(0);" id="village-btn" title="Toggle Villages"><i>Toggle Villages</i></a>
      <a href="javascript:void(0);" id="craft-btn" title="Toggle Crafting Stations"><i>Toggle Crafting Stations</i></a>
      <a href="javascript:void(0);" id="bind-btn" title="Toggle Bindstones"><i>Toggle Bindstones</i></a>
      <a href="javascript:void(0);" id="portal-btn" title="Toggle Portals"><i>Toggle Portals</i></a>
    </div>
    <div class="dfuw_logo"></div>
    <div id="map_canvas"></div>
  </div>
</div>
</div>
</article>
<?php get_footer(); ?>
