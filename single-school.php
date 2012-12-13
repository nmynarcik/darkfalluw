<?php get_header();

$slug = basename(get_permalink($post->ID));
?>
<article id="content">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <h2><?php the_title(); ?></h2>
<div id="school-details">
  <div class="thumb">
    <?php
      if(has_post_thumbnail()){
        $default_attr = array(
             'alt' => trim(strip_tags(  $post->post_title )),
              'title' => trim(strip_tags( $post->post_title ))
        );
        echo get_the_post_thumbnail( $post->ID, array(150,150), $default_attr );
      }else{
        echo "<img src='" . get_template_directory_uri() . "/images/no-image.png' width='150' height='150' title='No Image' alt='No Image' />";
      }
      ?>
  </div>
  <p class="descr">
    <?php echo strip_tags(get_post_meta($post->ID, '_school_descr',true)); ?>
  </p>
</div>
<?php
      $type = 'school';
      $args=array(
        'post_type' => $type,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
        'posts_per_page' => -1,
        'caller_get_posts'=> 1);

        $my_query = null;
        $my_query = new WP_Query($args);
        if( $my_query->have_posts() ) {
          echo '<select id="school_selector">';
          echo '<option value="">Other Schools</options>';
          while ($my_query->have_posts()) : $my_query->the_post();
          if($slug != basename(get_permalink())){
            echo '<option value="'.get_permalink().'">'. get_the_title() .'</option>';
          }
          endwhile;
          echo '</select>';
          wp_reset_query();
        }
    ?>
    <label class="ulti-legend"><i class="icon-certificate icon-white"></i> = School Ulimate</label>
<?php
$type = 'spell';
$args=array(
  'post_type' => $type,
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1,
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_key' => '_spell_school',
  'meta_value' => $slug);

$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
  echo '<a id="expand-all" class="btn btn-inverse"><i class="icon-plus-sign icon-white"></i> <span>Expand All</span></a>';
  echo '<div class="clear"></div>';
  echo '<div class="accordion">'; //start accordion
  while ($my_query->have_posts()) : $my_query->the_post(); ?>
    <h4 class="accordion-header current"><a href="#"><?php the_title(); ?> <?php echo (get_post_meta($post->ID, '_school_ulti')) ? '<i class="icon-certificate icon-white"></i>' : ''; ?></a></h4>
    <div class="pane" style="display: block;">
    <div class="thumb">
      <?php
          $default_attr = array(
             'alt' => trim(strip_tags(  $post->post_title )),
              'title' => trim(strip_tags( $post->post_title ))
            );
          if(has_post_thumbnail())
            echo get_the_post_thumbnail( $post->ID, array(80,80), $default_attr );
          else
            echo "<img src='" . get_template_directory_uri() . "/images/no-image.png' width='80' height='80' title='No Image' alt='No Image' />";
        ?>
    </div>
    <div class="descr">
      <p><?php echo strip_tags(get_post_meta($post->ID, '_spell_descr', true)); ?></p>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <?php
    echo '</div>';
  endwhile;
  echo '</div>'; // end accordion
}
wp_reset_query();  // Restore global post data stomped by the_post().
?>
<?php comments_template('', true); ?>
<?php endwhile; endif; ?>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
