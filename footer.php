<div class="clear"></div>
</div>
<div class="gad">
  <script type="text/javascript"><!--
    google_ad_client = "ca-pub-0373971494255887";
    /* Narrow Header */
    google_ad_slot = "3521032300";
    google_ad_width = 728;
    google_ad_height = 15;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<footer>
<div id="copyright">
<?php
  echo sprintf( __( '%1$s %2$s %3$s. All Rights Reserved. <br>All other trademarks or registered trademarks are property of their respective owners.', 'darkfalluw' ), '&copy;', date('Y'), esc_html(get_bloginfo('name').' '. get_bloginfo('description')) );
  // echo sprintf( __( '<br>Theme By: %1$s', 'darkfalluw' ), '<a href="http://www.mynarcik.com/">Nathan Mynarcik</a>' );
?>
</div>
<div class="clear"></div>
</footer>
</div>
<?php wp_footer();?>
</body>
<?php if(!is_user_logged_in()){ ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/ga.tracking.js"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/dfuw.js"></script>
</html>
