<?php global $post; if ( 'post' == $post->post_type ) : ?>
<div class="entry-footer">
<!--<?php
if ( is_category() && $catz = darkfalluw_catz(', ') ) : // ?>
<span class="cat-links"><?php printf( __( 'Also posted in %s', 'darkfalluw' ), $catz ); ?></span>
<span class="meta-sep"> | </span>
<?php else : ?>
<span class="cat-links"><span class="entry-footer-prep entry-footer-prep-cat-links">
<?php _e( 'Posted in ', 'darkfalluw' ); ?></span><?php echo get_the_category_list(', '); ?></span>
<span class="meta-sep"> | </span>
<?php endif; ?> -->
<?php if ( is_tag() && $tag_it = darkfalluw_tag_it(', ') ) : // ?>
<div class="divider-dotted"></div>
<span class="tag-links"><?php printf( __( 'Also tagged %s', 'darkfalluw' ), $tag_it ); ?></span>
<?php else : ?>
<?php the_tags( '<span class="tag-links"><i class="icon-tags"></i><span class="entry-footer-prep entry-footer-prep-tag-links">' . __('Tags: ', 'darkfalluw' ) . '</span>', ", ", "</span>\n" ); ?>
<?php endif; ?>
<!--
<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'darkfalluw' ), __( '1 Comment', 'darkfalluw' ), __( '% Comments', 'darkfalluw' ) ); ?></span>
<?php edit_post_link( __( 'Edit', 'darkfalluw' ), "<span class=\"meta-sep\"> | </span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t\n" ); ?>-->
</div>
<?php endif; ?>
