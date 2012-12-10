<?php
/*
Template Name: Darkfall Home Page
*/
get_header();
wp_enqueue_script('dfuw_jquery','http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js',false,'2.0','all');
wp_enqueue_script('dfuw_ellipsis',get_template_directory_uri().'/js/jquery.autoellipsis.min.js',false,'2.0','all');
?>
  <!-- CONTENT -->
    <div id="content" class="full-width">
      <section class="main-content full-height darkfall" role="main">
        <div class="gad">
          <script type="text/javascript"><!--
          google_ad_client = "ca-pub-0373971494255887";
          /* DFUW Info Site */
          google_ad_slot = "4637838709";
          google_ad_width = 728;
          google_ad_height = 90;
          //-->
          </script>
          <script type="text/javascript"
          src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
          </script>
        </div>
        <article>
        <?php while ( have_posts() ) : the_post(); ?>
        <header>
          <!-- <h2><?php the_title(); ?></h2> -->
        </header>
        <div class="entry-content">
          <iframe id="df-vid" width="659" height="371" src="http://www.youtube.com/embed/_T8FuVGXEMw?rel=0&iv_load_policy=3&modestbranding=1" frameborder="0" allowfullscreen></iframe>
          <div id="featured-vids">
            <h3>Featured Videos</h3>
            <div id="vid-wrapper">
            <?php
                $args = array(
                                      'numberposts'     => 5,
                                      'orderby'         => 'post_date',
                                      'order'           => 'DESC',
                                      'post_type'       => 'video',
                                      'post_status'     => 'publish');

                $my_query = null;
                $my_query = get_posts($args);
                echo '<ul id="featured-list">';
                foreach( $my_query as $post ) :  setup_postdata($post);
                  if(has_tag('featured',$post)){
                ?>
                  <li><a href="javascript:void(0);" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" data-vid-id="<?php echo get_post_meta($post->ID, '_video_id',true); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/play-icon.png" class="icon-play"/>
                    <img src="http://img.youtube.com/vi/<?php echo get_post_meta($post->ID, '_video_id',true); ?>/2.jpg" class="thumb"/>
                  </a></li>
                   <?php }
                  endforeach;
                  echo '</ul>';
              ?>
            </div>
          </div>
          <div class="clear"></div>
          <div class="bottom">
            <div class="item blogfeed">
              <h3>The Feed</h3>
              <p>The latest from the Official Darkfall Blog</p>
              <?php
                $args = array(
                                      'numberposts'     => 5,
                                      'category'        => get_category_by_slug('blog')->term_id,
                                      'orderby'         => 'post_date',
                                      'order'           => 'DESC',
                                      'post_type'       => 'post',
                                      'post_status'     => 'publish');

                $my_query = null;
                $my_query = get_posts($args);
                echo '<ul>';
                foreach( $my_query as $post ) :  setup_postdata($post); ?>
                  <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                   <?php
                  endforeach;
                  echo '</ul>';
              ?>
            </div>
            <div class="item eventfeed">
              <h3>Current Events</h3>
              <p>The latest events going on in Agon</p>
              <?php
                $args = array(
                                      'numberposts'     => 5,
                                      'category'        => get_category_by_slug('tournaments')->term_id,
                                      'orderby'         => 'post_date',
                                      'order'           => 'DESC',
                                      'post_type'       => 'post',
                                      'post_status'     => 'publish');

                $my_query = null;
                $my_query = get_posts($args);
                $count = 0;
                foreach( $my_query as $post ) :  setup_postdata($post); ?>
                <?php $count++; ?>
                <div class="item <?php echo ($count == 1) ? 'first' : ''; ?>">
                  <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
                    <?php
                      if(has_post_thumbnail()){
                        the_post_thumbnail(array(35,35),array(
                                                            'title'=>$post->post_title,
                                                            'alt'=>$post->post_title,
                                                            'class' => "icon"
                                                            ));
                      }
                      echo get_the_title();
                    ?>
                  </a>
                </div>
                   <?php
                  endforeach;
              ?>
            </div>
            <div class="item last">
              <div class="df-social">
                <h3>Social Media</h3>
                <span>Stay up to date with Darkfall's social communities</span>
                <ul class="social-list">
                  <li class="main"><a href="http://darkfallonline.com/uw/" alt="Darkfall Unholy Wars Official Website" title="Darkfall Unholy Wars Official Website" target="_blank">Main Site</a></li>
                  <li class="reddit"><a href="http://www.reddit.com/r/darkfall" alt="Darkfall Reddit" title="Darkfall on Reddit" target="_blank">Reddit</a></li>
                  <li class="twitter"><a href="https://twitter.com/darkfallmmorpg" alt="Darkfall on Twitter" title="Darkfall on Twitter" target="_blank">Twitter</a></li>
                  <li class="fb"><a href="http://www.facebook.com/darkfalluw" alt="Darkfall on Facebook" title="Darkfall on Facebook" target="_blank">Facebook</a></li>
                  <li class="yt"><a href="http://www.youtube.com/user/DarkfallOnline" alt="Darkfall on YouTube" title="Darkfall on YouTube" target="_blank">YouTube</a></li>
                </ul>
              </div>
            </div>
            <div class="clear"></div>
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
