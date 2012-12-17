<?php
/*
* Template Name: School Archive
*
*
*/
get_header();
?>
<div id="container">
<div id="content">
<a href="javascript:void(0);" id="expand-all" class="btn btn-inverse"><i class="icon-plus-sign icon-white"></i> <span>Expand All</span></a>
<div class="clear"></div>
<?php
$type = 'school';
$args=array(
  'post_type' => $type,
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'orderby' => 'title',
  'order' => 'ASC',
  'caller_get_posts'=> 1);

$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
  echo '<div class="accordion">'; //start accordion
  while ($my_query->have_posts()) : $my_query->the_post(); ?>
    <h4 class="accordion-header current"><a href="javascript:void(0);"><?php the_title(); ?></a></h4>
    <div class="pane" style="display: block;">
    <div class="thumb">
      <?php
          $default_attr = array(
             'alt' => trim(strip_tags(  $post->post_title )),
              'title' => trim(strip_tags( $post->post_title ))
            );
          if(has_post_thumbnail())
            echo get_the_post_thumbnail( $post->ID, 'post-thumbnail', $default_attr );
            // the_post_thumbnail('thumbnail',$default_attr);
          else
            echo "<img src='" . get_template_directory_uri() . "/images/no-image.png' width='64' height='64' title='No Image' alt='No Image' />";
        ?>
    </div>
    <div class="descr">
      <p><?php echo strip_tags(get_post_meta($post->ID, '_school_descr', true)); ?></p>
      <!-- <p>This school is found in the <?php echo $schoolRole ?> role</p> -->
      <a href="<?php echo get_permalink(); ?>" class="btn btn-inverse learn">Learn More &raquo;</a>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <?php
    echo '</div>'; // end accordion
  endwhile;
}
wp_reset_query();  // Restore global post data stomped by the_post().
?>

            </div><!-- #content -->
        </div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
