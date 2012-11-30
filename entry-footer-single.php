<div class="entry-footer">
<?php
if(has_tag()){
  echo '<div class="divider-dotted"></div>';
  $tags = get_the_tag_list('',', ');
  printf( __( '<i class="icon-tags"></i> TAGS: %1$s.', 'darkfalluw' ), $tags );
}
edit_post_link( __( 'Edit', 'darkfalluw' ), "\n\t\t\t\t\t<span class=\"edit-link\">", "</span>" );
?>
</div>
