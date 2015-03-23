<?php
    wp_enqueue_script('dfuw_jquery','http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false',false,'1.6','all');
    // wp_enqueue_script('dfuw_map',get_template_directory_uri().'/js/agon.map.min.js',false,$ver,'all');
    wp_enqueue_script('dfuw_map',get_template_directory_uri().'/js/agon.map.js',false,$ver,'all');
    get_header();

?>
<script type="text/javascript">
  var userPOI = "<?php echo strip_tags(get_post_meta($post->ID, '_poi_loc',true)); ?>";
  userPOI = userPOI.replace('|','%7C');
</script>
<article id="content">
<!-- <?php get_template_part( 'nav', 'above-single' ); ?> -->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div id="poi-container">
        <div id="poi-details">
            <h3><strong><?php the_title()?></strong></h3>
            <?php if(get_post_meta($post->ID, '_poi_level',true) != 'Select Level'){ ?>
            <p>Level: <span class="icon mob <?php echo strip_tags(get_post_meta($post->ID, '_poi_level',true)); ?>"><?php echo strip_tags(get_post_meta($post->ID, '_poi_level',true)); ?></span></p>
            <?php } ?>
        </div>
        <div id="map_canvas"></div>
    </div>
<?php comments_template('', true); ?>
<?php endwhile; endif; ?>
 <!-- <?php get_template_part( 'nav', 'below-single' ); ?> -->
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
