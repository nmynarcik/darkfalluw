<?php get_header();

$slug = basename(get_permalink($post->ID));
?>
<article id="content" class="<?php echo $slug; ?>">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <h2><?php the_title(); ?></h2>
<div id="single-spell-details">
  <div class="thumb">
    <?php
      if(has_post_thumbnail()){
        $default_attr = array(
             'alt' => trim(strip_tags(  $post->post_title )),
              'title' => trim(strip_tags( $post->post_title ))
        );
        echo get_the_post_thumbnail( $post->ID, array(100,100), $default_attr );
      }else{
        echo "<img src='" . get_template_directory_uri() . "/images/no-image.png' width='64' height='64' title='No Image' alt='No Image' />";
      }
      ?>
  </div>
  <p class="descr">
    <?php
      echo the_title() . ' is part of the ';
      $spellRole = strip_tags(get_post_meta($post->ID, '_spell_role',true));
      $spellSchool = strip_tags(get_post_meta($post->ID, '_spell_school',true));

      $roleArgs=array(
        'name' => $spellRole,
        'post_type' => 'role',
        'post_status' => 'publish',
        'numberposts' => 1
      );

      $rolePosts = get_posts($roleArgs);
      if( $rolePosts ) {
        echo '<a href=" ' . get_permalink( $rolePosts[0]->ID ) . ' ">' . get_the_post_thumbnail( $rolePosts[0]->ID, array(25,25)) . strtoupper($spellRole) . '</a> role in the ';
      }else{
        echo strtoupper($spellRole);
      }


      $schoolArgs=array(
        'name' => $spellSchool,
        'post_type' => 'school',
        'post_status' => 'publish',
        'numberposts' => 1
      );
      $schoolPosts = get_posts($schoolArgs);
      if( $schoolPosts ) {
        echo '<a href=" ' .  get_permalink( $schoolPosts[0]->ID )  . ' ">' . get_the_post_thumbnail( $schoolPosts[0]->ID, array(25,25)) . strtoupper($spellSchool) . '</a> school.';
      }else{
        echo strtoupper($spellSchool);
      }
    ?>
    <br><br>
    <?php echo strip_tags(get_post_meta($post->ID, '_spell_descr',true)); ?>
  </p>
</div>
<?php comments_template('', true); ?>
<?php endwhile; endif; ?>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
