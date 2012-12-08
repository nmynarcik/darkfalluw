<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
<div id="nav-below" class="navigation">
<?php next_posts_link(sprintf(__( '<div class="btn btn-inverse">%s older</div>', 'darkfalluw' ),' <i class="icon-circle-arrow-left icon-white"></i>')) ?>
<?php previous_posts_link(sprintf(__( '<div class="btn btn-inverse">newer %s</div>', 'darkfalluw' ),'<i class="icon-circle-arrow-right icon-white"></i>')) ?>
</div>
<?php } ?>
