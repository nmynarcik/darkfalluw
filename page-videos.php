<?php
/*
Template Name: Video Page
*/
get_header();
// wp_enqueue_script('dfuw_jquery','http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js',false,'1.6','all');
// wp_enqueue_script('dfuw_autoellipsis', get_template_directory_uri() . '/js/jquery.autoellipsis.min.js',false,'1.6','all');
?>
<article id="content">
<?php the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<!-- <h1 class="entry-title"><?php the_title(); ?></h1> -->
<h1 class="entry-title">Videos</h1>
<p><?php the_content();?></p>
<div class="entry-content">
<?php
$type = 'video';
$args=array(
  'post_type' => $type,
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1);

$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
  $count = 0;
  $extra_class = 'right';
  while ($my_query->have_posts()) : $my_query->the_post();
  $count++;
  if($count % 2 != 0){
    $extra_class = '';
  }else{
    $extra_class = 'right';
  }
  ?>
  <div class="video <?php echo $extra_class; ?>">
    <a href="<?php echo the_permalink();?>" class="thumb" style="background: url(http://img.youtube.com/vi/<?php echo get_post_meta($post->ID, '_video_id',true); ?>/0.jpg) no-repeat center;">
      <img src="<?php echo get_template_directory_uri(); ?>/images/play-icon.png" class="icon-play" alt="Play"/>
    </a>
    <h2><a href="<?php echo the_permalink();?>"><?php echo get_the_title();?></a></h2>
    <p> <?php echo strip_tags(get_post_meta($post->ID, '_video_descr',true)); ?></p>
  </div>
<?php
  endwhile;
}
wp_reset_query();  // Restore global post data stomped by the_post().
?>
</div>
</div>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
