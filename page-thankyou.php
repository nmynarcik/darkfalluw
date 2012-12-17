<?php
/*
Template Name: Thank You
*/
get_header(); ?>
<article id="content" class="full-width">
<?php the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="entry-content">
<?php the_content(); ?>
</div>
<img src="<?php echo get_template_directory_uri(); ?>/images/brownie.png" />
</div>
</article>
<?php get_footer(); ?>
