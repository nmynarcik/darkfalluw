<div class="clear"></div>
</div>
<footer>
<div id="copyright">
<?php
  echo sprintf( __( '%1$s %2$s %3$s. All Rights Reserved. <br>All other trademarks or registered trademarks are property of their respective owners.', 'darkfalluw' ), '&copy;', date('Y'), esc_html(get_bloginfo('name').' '. get_bloginfo('description')) );
  // echo sprintf( __( '<br>Theme By: %1$s', 'darkfalluw' ), '<a href="http://www.mynarcik.com/">Nathan Mynarcik</a>' );
?>
</div>
<div class="df-social">
  <p>Stay Connected:</p>
  <ul class="social-list">
    <li class="main"><a href="http://darkfallonline.com/uw/" alt="Darkfall Unholy Wars Official Website" title="Darkfall Unholy Wars Official Website" target="_blank">Main Site</a></li>
    <li class="reddit"><a href="http://www.reddit.com/r/darkfall" alt="Darkfall Reddit" title="Darkfall on Reddit" target="_blank">Reddit</a></li>
    <li class="twitter"><a href="https://twitter.com/darkfallmmorpg" alt="Darkfall on Twitter" title="Darkfall on Twitter" target="_blank">Twitter</a></li>
    <li class="fb"><a href="http://www.facebook.com/darkfalluw" alt="Darkfall on Facebook" title="Darkfall on Facebook" target="_blank">Facebook</a></li>
    <li class="yt"><a href="http://www.youtube.com/user/DarkfallOnline" alt="Darkfall on YouTube" title="Darkfall on YouTube" target="_blank">YouTube</a></li>
  </ul>
</div>
<div class="clear"></div>
</footer>
</div>
<?php wp_footer();?>
</body>
<?php if(!is_user_logged_in()){ ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/ga.tracking.js"></script>
<?php } ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.autoellipsis.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/dfuw.js"></script>
<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50c58e77607d7916"></script>
</html>
