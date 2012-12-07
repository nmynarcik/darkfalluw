<?php
/*
Template Name: DF Map
*/
get_header();
wp_enqueue_script('dfuw_jquery','http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js',false,'1.6','all');
?>
<script src="//ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
<script type="text/javascript">
  swfobject.registerObject("dfMap", "9.0.0");
</script>
<article id="content">
<?php the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="entry-content">
<?php the_content(); ?>
  <iframe src="http://www.geckzilla.com/dfstuff/dfmap.swf" width="695" height="695" ></iframe>
  <a href="http://www.geckzilla.com/dfstuff/dfmap.swf" class="btn btn-inverse pop-out" onclick="javascript:void window.open('../dfmap/dfmap.swf','1354867021522','width=1248,height=1024,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=1,left=0,top=0');return false;">Popout <i class="icon-fullscreen icon-white"></i></a>
</div>
</div>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
