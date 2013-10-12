<?php
/*
Template Name: Darkfall Home Page
*/
get_header();
?>
  <!-- CONTENT -->
    <div id="content" class="full-width">
      <section class="main-content full-height darkfall" role="main">
        <article>
        <?php while ( have_posts() ) : the_post(); ?>
          <pre>Want to know if the servers are up while on the go? Get the <a href="https://play.google.com/store/apps/details?id=com.dfuwinfo.dfstatus" target="_blank">DFUW Status App</a> on Android NOW!</pre>
        <header>
          <!-- <h2><?php the_title(); ?></h2> -->
        </header>
        <div class="entry-content">
          <iframe id="df-vid" width="659" height="371" src="http://www.youtube.com/embed/_T8FuVGXEMw?rel=0&iv_load_policy=3&modestbranding=1&wmode=opaque" frameborder="0" allowfullscreen></iframe>
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
                  <li><a href="javascript:void(0);" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" style="background: url(http://img.youtube.com/vi/<?php echo get_post_meta($post->ID, '_video_id',true); ?>/1.jpg) no-repeat center;" data-vid-id="<?php echo get_post_meta($post->ID, '_video_id',true); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/play-icon.png" class="icon-play" alt="Play"/>
                    <!-- <img src="http://img.youtube.com/vi/<?php echo get_post_meta($post->ID, '_video_id',true); ?>/1.jpg" class="thumb"/> -->
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
              <h3>The Feed <a href="<?php echo get_bloginfo('url'); ?>/category/blog/feed/" target="_blank" class="icon-rss" rel="nofollow"></a></h3>
              <p>Accumulation of all things Darkfall</p>
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
                foreach( $my_query as $post ) :  setup_postdata($post); ?>
                <?php
                  $posttags = get_the_tags();
                  ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" class="post <?php if ($posttags) {
                    foreach($posttags as $tag) {
                      echo $tag->name . ' ';
                    }
                  } ?>"><i class="icon"></i> <?php the_title(); ?></a>
                      <p><?php echo get_the_excerpt(); ?></p>
                   <?php
                  endforeach;
              ?>
            </div>
            <div class="item eventfeed">
              <h3>Current Events <a href="<?php echo get_bloginfo('url'); ?>/category/tournaments/feed/" target="_blank" class="icon-rss" rel="nofollow"></a></h3>
              <p>The latest events going on in Agon</p>
              <?php
                $args = array(
                                      'numberposts'     => 5,
                                      'category'        => '"'.get_category_by_slug('tournaments')->term_id.','.get_category_by_slug('events')->term_id,
                                      'orderby'         => 'post_date',
                                      'order'           => 'DESC',
                                      'post_type'       => 'post',
                                      'post_status'     => 'publish');

                $my_query = null;
                $my_query = get_posts($args);
                $count = 0;
                if(!count($my_query)){
                  echo '<p style="font-weight:700;">None, yet...</p>';
                }else{
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
                      }else{
                        echo '<img src="'.get_template_directory_uri().'/images/no-image.png" class="icon" />';
                      }
                      echo get_the_title();
                    ?>
                  </a>
                </div>
                   <?php
                  endforeach;
                }
              ?>
            </div>
            <div class="item forumfeed last">
              <div class="load-wrapper">
                <img class="loader" src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" alt="loading..."/>
                <div class="loading"></div>
              </div>
              <h3>Latest ForumFall <a href="http://forums.darkfallonline.com/external.php?type=RSS2" target="_blank" class="icon-rss" rel="nofollow"></a></h3>
              <p>The latest posts on Darkfall's Forums</p>
            </div>
            <!-- <?php get_sidebar(); ?> -->
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
