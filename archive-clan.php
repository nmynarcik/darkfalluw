<?php
get_header();
$server = $wp_query->query_vars['server'];
wp_enqueue_script('dfuw_table_sort', get_template_directory_uri().'/js/jquery.tablesorter.min.js',false,$ver,'all');

$selectBox = '<select id="server_select">';
if($server == "na"){
  $selectBox .= '<option value="na" selected="selected">NA</option>';
  $selectBox .= '<option value="eu">EU</option>';
}else{
  $selectBox .= '<option value="na">NA</option>';
  $selectBox .= '<option value="eu" selected="selected">EU</option>';
}
$selectBox .= '</select>';
?>
<div id="content" class="clans">
  <h2>Darkfall: Unholy Wars Clans -</h2><?php echo $selectBox; ?>
  <div class="clear"></div>
  <p  class='tip'><i class="icon-info-sign"></i> Columns are sortable</p>
<table id="clans-list" class="tablesorter" width="695" border="0" cellpadding="0" cellspacing="0">
  <thead>
  <tr>
    <th>Name <i class="icon-chevron-up icon-white"></i></th>
    <th>Leader IGN <i class="icon-chevron-down icon-white"></i></th>
    <th class="last">Leader ForumFall <i class="icon-chevron-up icon-white"></i></th>
    <!-- <th class="last">Server <i class="icon-chevron-up icon-white"></i></th> -->
  </tr>
  </thead>
  <tbody>
  <?php
    $count = 0;
    query_posts($query_string . '&meta_key=_clan_server&meta_value='.$server.'&orderby=title&order=ASC&posts_per_page=-1');
   while ( have_posts() ) : the_post();
   $count++;
   if($count % 2 != 0){
      $extra_class = '';
    }else{
      $extra_class = 'odd';
    }
   ?>
  <tr class="<?php echo $extra_class; ?>">
    <td class="clan_name">
    <?php
      if(get_post_meta($post->ID, '_clan_url', true) != ''){ ?>
        <a href="<?php echo get_post_meta($post->ID, '_clan_url', true) ?>" target="_blank"><?php echo get_the_title();?></a>
      <?php } else { ?>
        <?php echo get_the_title();?>
      <?php } ?>
    </td>
    <td><?php echo get_post_meta($post->ID, '_clan_leader_ign', true) ?></td>
    <td class="last"><?php echo get_post_meta($post->ID, '_clan_leader_forum', true) ?></td>
    <!-- <td class="server"><?php echo get_post_meta($post->ID, '_clan_server', true) ?></td> -->
  </tr>
  <?php endwhile; ?>
  </tbody>
</table>
<p class="totals">Total Clans: <?php echo $count; ?></p>
<?php get_template_part( 'nav', 'below' ); ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
