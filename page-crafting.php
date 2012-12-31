<?php
/*
Template Name: Crafting
*/
get_header();
?>
<article id="content" class="full-width">
<?php the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="entry-content">
  <?php the_content(); ?>
  <iframe class="gdoc" width="100%" height="750" src="https://docs.google.com/spreadsheet/lv?key=0Aj1bEOdIK16ldGYxeGZETldaRGdxWGZsVnBtS25IRnc&output=html"></iframe>
  <div class="disclaimer">** Content provided by Kelet</div>
</div>
</div>
</article>
<?php get_footer(); ?>
