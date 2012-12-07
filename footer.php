<div class="clear"></div>
</div>
<footer>
<div id="copyright">
<?php
  echo sprintf( __( '%1$s %2$s %3$s. All Rights Reserved. <br>All other trademarks or registered trademarks are property of their respective owners.', 'darkfalluw' ), '&copy;', date('Y'), esc_html(get_bloginfo('name')) );
  // echo sprintf( __( '<br>Theme By: %1$s', 'darkfalluw' ), '<a href="http://www.mynarcik.com/">Nathan Mynarcik</a>' );
?>
</div>
<div class="clear"></div>
</footer>
</div>
<?php wp_footer();?>
</body>
<?php if(!is_user_logged_in()){ ?>
<!--<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/ga.tracking.js"></script>-->
<?php } ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/dfuw.js"></script>
</html>
