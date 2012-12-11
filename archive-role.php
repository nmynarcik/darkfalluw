<?php
/*
* Template Name: Role Archive
*
*
*/
get_header();
$ver = '1.6';
$dir = get_template_directory_uri();
wp_enqueue_style('jquery_styles', 'http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css',false,$ver,'all');
wp_enqueue_script('dfuw_jquery','http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js',false,$ver,'all');
wp_enqueue_script('dfuw_jquery_ui','http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js',false,$ver,'all');
?>
<div id="container">
<div id="content">
<a id="expand-all" class="btn btn-inverse"><i class="icon-plus-sign icon-white"></i> <span>Expand All</span></a>
<div class="clear"></div>
<?php
$type = 'role';
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
    <h4 class="accordion-header current"><a href="#"><?php the_title(); ?></a></h4>
    <div class="pane" style="display: block;">
    <div class="thumb">
      <?php
          $default_attr = array(
             'alt' => trim(strip_tags(  $post->post_title )),
              'title' => trim(strip_tags( $post->post_title ))
            );
          if(has_post_thumbnail())
            the_post_thumbnail('post-thumbnail',$default_attr);
          else
            echo "<img src='" . get_template_directory_uri() . "/images/no-image.png' width='150' height='150' title='No Image' alt='No Image' />";
        ?>
    </div>
    <div class="descr">
      <p><?php echo strip_tags(get_post_meta($post->ID, '_role_descr', true)); ?></p>
      <div class="detail-list">
        <h2>Schools:</h2>
        <ul class="school-list">
          <?php
            $schools = explode(',',get_post_meta($post->ID, '_role_schools', true));
            if($schools[0] == ''){
              echo '<li class="none">Not Available</li>';
            }else{
              foreach($schools as $school){
                $school_post = get_page_by_path($school, OBJECT, 'school');
                $url = '../schools/'.$school;
                $title = get_the_title($school_post->ID);
                $default_attr = array(
                  'alt' => trim(strip_tags( $attachment->$title )),
                  'title' => trim(strip_tags( $attachment->$title ))
                );
                $thumb = (has_post_thumbnail($school_post->ID)) ? get_the_post_thumbnail($school_post->ID,array(32,32),$default_attr) : '<img src="' . get_template_directory_uri() . '/images/no-image.png" width="32" height="32"/>';
                echo '<li><a href="'. $url . '" class="icon" title="'.$title.'" alt="'.$title.'">'.$thumb.'</a></li>';
              }
            }
          ?>
        </ul>
      </div>
      <div class="detail-list last">
        <h2>Base Stats:</h2>
        <ul class="bars">
          <li class="health <?php echo get_post_meta($post->ID, 'health_val',true); ?>"><span class='label'>Health</span> <span class="bar"><span class="fill"></span></span></li>
          <li class="stamina <?php echo get_post_meta($post->ID, 'stamina_val',true); ?>"><span class='label'>Stamina</span> <span class="bar"><span class="fill"></span></span></li>
          <li class="mana <?php echo get_post_meta($post->ID, 'mana_val',true); ?>"><span class='label'>Mana</span> <span class="bar"><span class="fill"></span></span></li>
          <li class="attack-power <?php echo get_post_meta($post->ID, 'attackpower_val',true); ?>"><span class='label'>Attack-Power</span> <span class="bar"><span class="fill"></span></span></li>
          <li class="support <?php echo get_post_meta($post->ID, 'support_val',true); ?>"><span class='label'>Support</span> <span class="bar"><span class="fill"></span></span></li>
          <li class="defense <?php echo get_post_meta($post->ID, 'defense_val',true); ?>"><span class='label'>Defense</span> <span class="bar"><span class="fill"></span></span></li>
        </ul>
      </div>
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
