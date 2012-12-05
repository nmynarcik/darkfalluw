<?php
/*
Template Name: Darkfall Home Page
*/
get_header();
$dir = get_bloginfo('url') . '/wp-content/plugins/df_content_info';
    wp_enqueue_style('df_styles', $dir . '/css/spell-styles.css',false,'1.6','all');
    wp_enqueue_script('df_js', $dir . '/js/df_content_info.js',false,'1.6','all');
?>
  <!-- CONTENT -->
    <div id="content" class="full-width">
      <section class="main-content full-height darkfall" role="main">
        <article>
        <?php while ( have_posts() ) : the_post(); ?>
        <header>
          <!-- <h2><?php the_title(); ?></h2> -->
        </header>
        <div class="entry-content">
          <center><iframe id="df-vid" width="853" height="480" src="http://www.youtube.com/embed/_T8FuVGXEMw?rel=0" frameborder="0" allowfullscreen></iframe></center>
          <!-- <p class="bio"> -->
          <?php
              $theContent = get_the_content();
              // echo strip_tags($theContent);
              echo $theContent;
            ?>
          <!-- </p> -->
          <div class="df-social">
          <h3>Social Media</h3>
          <p>Stay up to date with Darkfall's social communities</p>
          <ul class="social-list">
            <li class="main"><a href="http://darkfallonline.com/uw/" alt="Darkfall Unholy Wars Official Website" title="Darkfall Unholy Wars Official Website" target="_blank">Main Site</a></li>
            <li class="reddit"><a href="http://www.reddit.com/r/darkfall" alt="Darkfall Reddit" title="Darkfall on Reddit" target="_blank">Reddit</a></li>
            <li class="twitter"><a href="https://twitter.com/darkfallmmorpg" alt="Darkfall on Twitter" title="Darkfall on Twitter" target="_blank">Twitter</a></li>
            <li class="fb"><a href="http://www.facebook.com/darkfalluw" alt="Darkfall on Facebook" title="Darkfall on Facebook" target="_blank">Facebook</a></li>
          </ul>
        </div>
          <div class="clear"></div>
        </div>
        <?php endwhile; ?>
        </article>
      </section>
    <div class="clear"></div>
    </div>
  <!-- END CONTENT -->

<?php get_footer(); ?>
