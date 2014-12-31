<?php
if ( 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
die ( 'Please do not load this page directly.' );
if ( post_password_required() ) :
?>
<div id="comments">
<div class="nopassword"><?php _e('This post is password protected. Enter the password to view comments.', 'darkfalluw') ?></div>
</div>
<?php
return;
endif;
?>
<div id="comments">
<?php if ( have_comments() ) : ?>
<?php
$ping_count = $comment_count = 0;
foreach ( $comments as $comment )
get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
?>
<?php if ( ! empty($comments_by_type['comment']) ) : ?>
<div id="comments-list" class="comments">
<h3><?php echo ($comment_count > 1 ? '<span>'.$comment_count.'</span> '. __('Comments', 'darkfalluw') : '<span>'. __( 'One', 'darkfalluw' ) .'</span> '. __('Comment', 'darkfalluw') ); ?></h3>
<?php $total_pages = get_comment_pages_count(); if ( $total_pages > 1 ) : ?>
<div id="comments-nav-above" class="comments-navigation">
<div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
</div>
<?php endif; ?>
<ul>
<?php wp_list_comments('type=comment&callback=darkfalluw_custom_comments'); ?>
</ul>
<?php $total_pages = get_comment_pages_count(); if ( $total_pages > 1 ) : ?>
<div id="comments-nav-below" class="comments-navigation">
<div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
</div>
<?php endif; ?>
</div>
<?php
endif;
global $comments_by_type;
$comments_by_type = &separate_comments( $comments );
if ( ! empty($comments_by_type['pings'])  && comments_open() ) : ?>
<div id="trackbacks-list" class="comments">
<h3><?php echo($ping_count > 1 ? '<span>'.$ping_count.'</span> '.__('Trackbacks', 'darkfalluw') : '<span>'. __('One', 'darkfalluw' ) .'</span> '. __('Trackback', 'darkfalluw') ); ?></h3>
<ul>
<?php wp_list_comments('type=pings&callback=darkfalluw_custom_pings'); ?>
</ul>
</div>
<?php endif; ?>
<?php endif; ?>
<?php if ( comments_open() ) : ?>
<div id="respond">
<?php comment_form(array('comment_notes_after' => '')); ?>
</div>
<?php endif; ?>
</div>
