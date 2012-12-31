<?php
  global $ver;
?>
<div class="clear"></div>
</div>
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
<?php if($_SERVER['DEV_ENV'] != "BLUEMONSTER"){?>
<?php if(!is_user_logged_in()){ ?>
<script type="text/javascript">
  var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-19670756-11']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();


    (function (tos) {
      window.setInterval(function () {
        tos = (function (t) {
          return t[0] == 50 ? (parseInt(t[1]) + 1) + ':00' : (t[1] || '0') + ':' + (parseInt(t[0]) + 10);
        })(tos.split(':').reverse());
        window.pageTracker ? pageTracker._trackEvent('Time', 'Log', tos) : _gaq.push(['_trackEvent', 'Time', 'Log', tos]);
      }, 10000);
    })('00');
</script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/ga.tracking.min.js"></script>
<?php } ?>
<?php } ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.autoellipsis.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/dfuw.min.js?ver=<?php echo $ver; ?>"></script>
<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50c58e77607d7916"></script>
</html>
