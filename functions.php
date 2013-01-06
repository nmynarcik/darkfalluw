<?php
add_action('after_setup_theme', 'darkfalluw_setup');
function darkfalluw_setup(){
load_theme_textdomain('darkfalluw', get_template_directory() . '/languages');
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
global $content_width;
if ( ! isset( $content_width ) ) $content_width = 640;
register_nav_menus(
array( 'main-menu' => __( 'Main Menu', 'darkfalluw' ) )
);
}
add_action('comment_form_before', 'darkfalluw_enqueue_comment_reply_script');
function darkfalluw_enqueue_comment_reply_script()
{
if(get_option('thread_comments')) { wp_enqueue_script('comment-reply'); }
}
add_filter('the_title', 'darkfalluw_title');
function darkfalluw_title($title) {
if ($title == '') {
return 'Untitled';
} else {
return $title;
}
}
add_filter('wp_title', 'darkfalluw_filter_wp_title');
function darkfalluw_filter_wp_title($title)
{
return $title . esc_attr(get_bloginfo('name'));
}
add_filter('comment_form_defaults', 'darkfalluw_comment_form_defaults');
function darkfalluw_comment_form_defaults( $args )
{
$req = get_option( 'require_name_email' );
$required_text = sprintf( ' ' . __('Required fields are marked %s', 'darkfalluw'), '<span class="required">*</span>' );
$args['comment_notes_before'] = '<p class="comment-notes">' . __('Your email is kept private.', 'darkfalluw') . ( $req ? $required_text : '' ) . '</p>';
$args['title_reply'] = __('Post a Comment', 'darkfalluw');
$args['title_reply_to'] = __('Post a Reply to %s', 'darkfalluw');
return $args;
}
add_action( 'init', 'darkfalluw_set_default_widgets' );
function darkfalluw_set_default_widgets() {
if ( is_admin() && isset( $_GET['activated'] ) ) {
update_option( 'sidebars_widgets', $preset_widgets );
}
}
add_action( 'init', 'darkfalluw_add_shortcodes' );
function darkfalluw_add_shortcodes() {
add_filter('widget_text', 'do_shortcode');
add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');
add_shortcode('ytvid','yt_vid');
add_shortcode('bracket','challonge_bracket');
add_filter('the_content','do_shortcode');
}
function challonge_bracket($attr){
  extract(shortcode_atts(array(
      'id' => 'NO_ID'
    ), $attr));
  $output = '<iframe src="http://challonge.com/'.$id.'/module?width=695&height=600" width="695" height="600" frameborder="0" scrolling="no" allowtransparency="true"></iframe>';
  return $output;
}
function fixed_img_caption_shortcode($attr, $content = null) {
$output = apply_filters('img_caption_shortcode', '', $attr, $content);
if ( $output != '' ) return $output;
extract(shortcode_atts(array(
'id'=> '',
'align'	=> 'alignnone',
'width'	=> '',
'caption' => ''), $attr));
if ( 1 > (int) $width || empty($caption) )
return $content;
if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
return '<div ' . $id . 'class="wp-caption ' . esc_attr($align)
. '">'
. do_shortcode( $content ) . '<p class="wp-caption-text">'
. $caption . '</p></div>';
}
add_action( 'widgets_init', 'darkfalluw_widgets_init' );
function darkfalluw_widgets_init() {
register_sidebar( array (
'name' => __('Sidebar Widget Area', 'darkfalluw'),
'id' => 'primary-widget-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
$preset_widgets = array (
'primary-aside'  => array( 'search', 'pages', 'categories', 'archives' ),
);
function darkfalluw_get_page_number() {
if (get_query_var('paged')) {
print ' | ' . __( 'Page ' , 'darkfalluw') . get_query_var('paged');
}
}
function darkfalluw_catz($glue) {
$current_cat = single_cat_title( '', false );
$separator = "\n";
$cats = explode( $separator, get_the_category_list($separator) );
foreach ( $cats as $i => $str ) {
if ( strstr( $str, ">$current_cat<" ) ) {
unset($cats[$i]);
break;
}
}
if ( empty($cats) )
return false;
return trim(join( $glue, $cats ));
}
function darkfalluw_tag_it($glue) {
$current_tag = single_tag_title( '', '',  false );
$separator = "\n";
$tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
foreach ( $tags as $i => $str ) {
if ( strstr( $str, ">$current_tag<" ) ) {
unset($tags[$i]);
break;
}
}
if ( empty($tags) )
return false;
return trim(join( $glue, $tags ));
}
function darkfalluw_commenter_link() {
$commenter = get_comment_author_link();
if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
$commenter = preg_replace( '/(<a[^>]* class=[\'"]?)/', '\\1url ' , $commenter );
} else {
$commenter = preg_replace( '/(<a )/', '\\1class="url "' , $commenter );
}
$avatar_email = get_comment_author_email();
$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, 80 ) );
echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
}
function darkfalluw_custom_comments($comment, $args, $depth) {
$GLOBALS['comment'] = $comment;
$GLOBALS['comment_depth'] = $depth;
?>
<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
<div class="comment-author vcard"><?php darkfalluw_commenter_link() ?></div>
<div class="comment-meta"><?php printf(__('Posted %1$s at %2$s', 'darkfalluw' ), get_comment_date(), get_comment_time() ); ?><span class="meta-sep"> | </span> <a href="#comment-<?php echo get_comment_ID(); ?>" title="<?php _e('Permalink to this comment', 'darkfalluw' ); ?>"><?php _e('Permalink', 'darkfalluw' ); ?></a>
<?php edit_comment_link(__('Edit', 'darkfalluw'), ' <span class="meta-sep"> | </span> <span class="edit-link">', '</span>'); ?></div>
<?php if ($comment->comment_approved == '0') { echo '\t\t\t\t\t<span class="unapproved">'; _e('Your comment is awaiting moderation.', 'darkfalluw'); echo '</span>\n'; } ?>
<div class="comment-content">
<?php comment_text() ?>
</div>
<?php
if($args['type'] == 'all' || get_comment_type() == 'comment') :
comment_reply_link(array_merge($args, array(
'reply_text' => __('Reply','darkfalluw'),
'login_text' => __('Login to reply.', 'darkfalluw'),
'depth' => $depth,
'before' => '<div class="comment-reply-link">',
'after' => '</div>'
)));
endif;
?>
<?php }
function darkfalluw_custom_pings($comment, $args, $depth) {
$GLOBALS['comment'] = $comment;
?>
<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
<div class="comment-author"><?php printf(__('By %1$s on %2$s at %3$s', 'darkfalluw'),
get_comment_author_link(),
get_comment_date(),
get_comment_time() );
edit_comment_link(__('Edit', 'darkfalluw'), ' <span class="meta-sep"> | </span> <span class="edit-link">', '</span>'); ?></div>
<?php if ($comment->comment_approved == '0') { echo '\t\t\t\t\t<span class="unapproved">'; _e('Your trackback is awaiting moderation.', 'darkfalluw'); echo '</span>\n'; } ?>
<div class="comment-content">
<?php comment_text() ?>
</div>
<?php }

/* ----------------------------------------------------------------------------- */
/*
/* Spells, Classes, Roles - HELL YEAH
/* ----------------------------------------------------------------------------- */


add_action('init', 'register_post_types');
function register_post_types()
{
    // Spells
    register_post_type('spell', array(
        'labels' => array(
            'name' => __('Spells'),
            'singular_name' => __('Spell'),
            'add_new' => __('Add Spell'),
            'add_new_item' => __('Add New Spell'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Spell'),
            'new_item' => __('New Spell'),
            'view' => __('View Spell'),
            'view_item' => __('View Spell'),
            'search_items' => __('Search Spells'),
            'not_found' => __('No spells found'),
            'not_found_in_trash' => __('No spells found in Trash'),
            'parent' => __('Parent Spell')
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'exclude_from_search' => false,
        'hierarchical' => false,
        'menu_position' => 24,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'spells'
        ),
        'supports' => array(
            'title',
            'thumbnail'
        ),
        'register_meta_box_cb' => 'add_custom_meta_boxes'
    ));

    // Roles
    register_post_type('role', array(
        'labels' => array(
            'name' => __('Roles'),
            'singular_name' => __('Role'),
            'add_new' => __('Add Role'),
            'add_new_item' => __('Add New Role'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Role'),
            'new_item' => __('New Role'),
            'view' => __('View Role'),
            'view_item' => __('View Role'),
            'search_items' => __('Search Roles'),
            'not_found' => __('No roles found'),
            'not_found_in_trash' => __('No roles found in Trash'),
            'parent' => __('Parent Role')
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'exclude_from_search' => false,
        'hierarchical' => false,
        'menu_position' => 22,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'roles'
        ),
        'supports' => array(
            'title',
            'thumbnail'
        ),
        'register_meta_box_cb' => 'add_custom_meta_boxes'
    ));

    // Schools
    register_post_type('school', array(
        'labels' => array(
            'name' => __('Schools'),
            'singular_name' => __('School'),
            'add_new' => __('Add School'),
            'add_new_item' => __('Add New School'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit School'),
            'new_item' => __('New School'),
            'view' => __('View School'),
            'view_item' => __('View School'),
            'search_items' => __('Search Schools'),
            'not_found' => __('No schools found'),
            'not_found_in_trash' => __('No schools found in Trash'),
            'parent' => __('Parent School')
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'exclude_from_search' => false,
        'hierarchical' => false,
        'menu_position' => 23,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'schools'
        ),
        'supports' => array(
            'title',
            'thumbnail'
        ),
        'register_meta_box_cb' => 'add_custom_meta_boxes'
    ));

    // Videos
    register_post_type('video', array(
        'labels' => array(
            'name' => __('Videos'),
            'singular_name' => __('Video'),
            'add_new' => __('Add Video'),
            'add_new_item' => __('Add New Video'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Video'),
            'new_item' => __('New Video'),
            'view' => __('View Video'),
            'view_item' => __('View Video'),
            'search_items' => __('Search Videos'),
            'not_found' => __('No videos found'),
            'not_found_in_trash' => __('No videos found in Trash'),
            'parent' => __('Parent Video')
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'exclude_from_search' => false,
        'hierarchical' => false,
        'menu_position' => 21,
        'has_archive' => false,
        'rewrite' => array(
            'slug' => 'videos'
        ),
        'supports' => array(
            'title'
        ),
        'taxonomies' => array('post_tag'),
        'register_meta_box_cb' => 'add_custom_meta_boxes'
    ));

    // Clans
    register_post_type('clan', array(
        'labels' => array(
            'name' => __('Clans'),
            'singular_name' => __('Clan'),
            'add_new' => __('Add Clan'),
            'add_new_item' => __('Add New Clan'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Clan'),
            'new_item' => __('New Clan'),
            'view' => __('View Clan'),
            'view_item' => __('View Clan'),
            'search_items' => __('Search Clans'),
            'not_found' => __('No clans found'),
            'not_found_in_trash' => __('No clans found in Trash'),
            'parent' => __('Parent Clan')
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'exclude_from_search' => false,
        'hierarchical' => false,
        'menu_position' => 27,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'clans'
        ),
        'supports' => array(
            'title',
            'thumbnail'
        ),
        'register_meta_box_cb' => 'add_custom_meta_boxes'
    ));

    // Common SKills
    register_post_type('skill', array(
        'labels' => array(
            'name' => __('Skills'),
            'singular_name' => __('Skill'),
            'add_new' => __('Add Skill'),
            'add_new_item' => __('Add New Skill'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Skill'),
            'new_item' => __('New Skill'),
            'view' => __('View Skill'),
            'view_item' => __('View Skill'),
            'search_items' => __('Search Skills'),
            'not_found' => __('No skills found'),
            'not_found_in_trash' => __('No skills found in Trash'),
            'parent' => __('Parent Skill')
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'exclude_from_search' => false,
        'hierarchical' => false,
        'menu_position' => 27,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'skills'
        ),
        'supports' => array(
            'title',
            'thumbnail'
        ),
        'register_meta_box_cb' => 'add_custom_meta_boxes'
    ));

    // Common SKills
    register_post_type('poi', array(
        'labels' => array(
            'name' => __('POIs'),
            'singular_name' => __('POI'),
            'add_new' => __('Add POI'),
            'add_new_item' => __('Add New POI'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit POI'),
            'new_item' => __('New POI'),
            'view' => __('View POI'),
            'view_item' => __('View POI'),
            'search_items' => __('Search POIs'),
            'not_found' => __('No skills found'),
            'not_found_in_trash' => __('No POIs found in Trash'),
            'parent' => __('Parent POI')
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'exclude_from_search' => true,
        'hierarchical' => false,
        'menu_position' => 28,
        'has_archive' => true,
        'rewrite' => array(
            'slug' => 'pois'
        ),
        'supports' => array(
            'title'
        ),
        'register_meta_box_cb' => 'add_custom_meta_boxes'
    ));

    flush_rewrite_rules();
}

/*-----------------------------------------------------------------------------------*/
/* Spells

/*-----------------------------------------------------------------------------------*/
function add_custom_meta_boxes()
{
    $post_types = get_post_types();
    foreach($post_types as $post_type){
      switch($post_type){
        case "spell":
          add_meta_box('spells_description', 'Description', 'add_descr_box', 'spell', 'normal', 'default');
          add_meta_box('spells_role', 'Role', 'spell_role', 'spell', 'normal', 'default');
          add_meta_box('spells_school', 'School', 'add_schools_box', 'spell', 'normal', 'default', array('df_type' => $post_type));
          add_meta_box('spells_ulti', 'Ultimate', 'spell_ulti', 'spell', 'normal', 'default');
          break;
        case "role":
          add_meta_box('role_description', 'Description', 'add_descr_box', 'role', 'normal', 'default');
          add_meta_box('role_schools', 'Schools', 'add_schools_box', 'role', 'normal', 'default', array('df_type' => $post_type));
          add_meta_box('role_stats', 'Base Stats', 'add_stats_box', 'role', 'normal', 'default');
          break;
        case "school":
          add_meta_box('school_description', 'Description', 'add_descr_box', 'school', 'normal', 'default');
          break;
        case "video":
          add_meta_box('video_description', 'Description', 'add_descr_box', 'video', 'normal', 'default');
          add_meta_box('video_id', 'Video ID', 'add_video_id_box', 'video', 'normal', 'default');
          break;
        case "clan":
          add_meta_box('clan_descr', 'Description', 'add_descr_box', 'clan', 'normal', 'default');
          add_meta_box('clan_url', 'Website Url', 'add_url_box', 'clan', 'normal', 'default');
          add_meta_box('leader_ign', 'Leader IGN', 'add_leader_ign_box', 'clan', 'normal', 'default');
          add_meta_box('leader_forum', 'Leader Forums', 'add_leader_forum_box', 'clan', 'normal', 'default');
           add_meta_box('clan_server', 'Server', 'add_server_box', 'clan', 'normal', 'default');
          break;
        case "skill":
          add_meta_box('skill_descr', 'Description', 'add_descr_box', 'skill', 'normal', 'default');
          break;
        case "poi":
            add_meta_box('poi_type', 'Type', 'add_poi_type', 'poi', 'normal', 'default');
            add_meta_box('poi_level', 'Level', 'add_poi_level', 'poi', 'normal', 'default');
            add_meta_box('poi_loc', 'Location', 'add_poi_loc', 'poi', 'normal', 'default');
            break;
      }
    }

}

function add_poi_type(){
    global $post;
    global $post_id;
    $post_type = $post->post_type;
    echo '<input type="hidden" name="_df_' . $post_type . 'noncename" value="' . wp_create_nonce('df_' . $post_type . 'nonce') . '"/>';
    $poi_type = get_post_meta($post_id, '_poi_type',true);
    echo '<select name="_poi_type">';
    echo '<option val="">Select Type</option>';
    echo '<option value="bank" ' . (($poi_type == 'bank') ? 'selected="selected" ' : ' ') . '>Bank</option>';
    echo '<option value="bind"' . (($poi_type == 'bind') ? 'selected="selected"' : '') . '>Bindstone</option>';
    echo '<option value="city"' . (($poi_type == 'city') ? 'selected="selected"' : '') . '>City</option>';
    echo '<option value="craft"' . (($poi_type == 'craft') ? 'selected="selected"' : '') . '>Craft Station</option>';
    echo '<option value="hamlet"' . (($poi_type == 'hamlet') ? 'selected="selected"' : '') . '>Hamlet</option>';
    echo '<option value="mob"' . (($poi_type == 'mob') ? 'selected="selected"' : '') . '>Mob</option>';
    echo '<option value="portal"' . (($poi_type == 'portal') ? 'selected="selected"' : '') . '>Portal</option>';
    echo '<option value="pchamber"' . (($poi_type == 'pchamber') ? 'selected="selected"' : '') . '>Portal Chamber</option>';
    echo '</select>';
}

function add_poi_level(){
    global $post;
    global $post_id;
    $poi_level = get_post_meta($post_id, '_poi_level',true);
    echo '<select name="_poi_level">';
    echo '<option val="">Select Level</option>';
    echo '<option value="easy" ' . (($poi_level == 'easy') ? 'selected="selected" ' : ' ') . '>Easy</option>';
    echo '<option value="med"' . (($poi_level == 'med') ? 'selected="selected"' : '') . '>Medium</option>';
    echo '<option value="hard"' . (($poi_level == 'hard') ? 'selected="selected"' : '') . '>Hard</option>';
    echo '</select><br/><br/>';
    echo '<em>Only needed for mobs</em>';
}

function add_poi_loc(){
    global $post;
    global $post_id;
    $poi_loc = get_post_meta($post_id, '_poi_loc',true);
    $poi_loc = explode('|', $poi_loc);
    echo 'lat: <input type="text" name="_poi_lat" value="'.$poi_loc[0].'"/><br/>';
    echo 'lng: <input type="text" name="_poi_lng"  value="'.$poi_loc[1].'" />';
}

function add_server_box(){
  global $post;
  global $post_id;
  $server = get_post_meta($post_id, '_clan_server',true);
  echo '<p>Clan Server</p>';
  echo '<select name="_clan_server">';
  echo '<option val="">Select Server</option>';
  if($server == 'na'){
    echo '<option value="na" selected="selected">NA</option>';
    echo '<option value="eu">EU</option>';
  }else if($server == 'eu'){
    echo '<option value="na">NA</option>';
    echo '<option value="eu" selected="selected">EU</option>';
  }else{
     echo '<option value="na">NA</option>';
    echo '<option value="eu">EU</option>';
  }
  echo '</select>';
}

function add_url_box(){
  global $post;
  global $post_id;
  $url = get_post_meta($post_id, '_clan_url',true);
  echo "<p>Clan Website</p>";
  echo "<input type='text' name='_clan_url' value='" . $url . "'/>";
}

function add_leader_ign_box(){
  global $post;
  global $post_id;
  $ign = get_post_meta($post_id, '_clan_leader_ign',true);
  echo "<p>Clan Leader - IGN</p>";
  echo "<input type='text' name='_clan_leader_ign' value='" . $ign . "'/>";
}

function add_leader_forum_box(){
  global $post;
  global $post_id;
  $ign = get_post_meta($post_id, '_clan_leader_forum',true);
  echo "<p>Clan Leader - ForumFall</p>";
  echo "<input type='text' name='_clan_leader_forum' value='" . $ign . "'/>";
}

function add_video_id_box(){
  global $post;
  global $post_id;
  $id = get_post_meta($post_id, '_video_id',true);
  echo "<p>Add the video ID from Youtube.</p>";
  echo "<input type='text' name='_video_id' value='" . $id . "'/>";
  echo "<p><em>Example: http://www.youtube.com/watch?v=<span style='color:red;'><b>_T8FuVGXEMw</b></span></em></p>";
}

function add_stats_box() {
  global $post;
  global $post_id;
  $health = get_post_meta($post_id, 'health_val',true);
  $stam = get_post_meta($post_id, 'stamina_val',true);
  $mana = get_post_meta($post_id, 'mana_val',true);
  $ap = get_post_meta($post_id, 'attackpower_val',true);
  $support = get_post_meta($post_id, 'support_val',true);
  $def = get_post_meta($post_id, 'defense_val',true);

  echo '<p><label><span>Health</span>&nbsp;&nbsp;&nbsp;<input type="number" max="309" min="1" name="health_val" value="'.$health.'" /></label></p>';
  echo '<p><label><span>Stamina</span>&nbsp;&nbsp;&nbsp;<input type="number" max="309" min="1" name="stamina_val" value="'.$stam.'"/></label></p>';
  echo '<p><label><span>Mana</span>&nbsp;&nbsp;&nbsp;<input type="number" max="309" min="1" name="mana_val" value="'.$mana.'"/></label></p>';
}

function get_stat_opts($theVal){
  // echo '<option value="">Select Value</option>';
  echo '<option value="low" ';
  echo ($theVal == "low") ? ' selected="selected" ' : '  ';
  echo ' > '.' Low '.' </option>';
  echo '<option value="avg" ';
  echo ($theVal == "avg") ? ' selected="selected" ' : '  ';
  echo '>Average</option>';
  echo '<option value="high"';
  echo ($theVal == "high") ? ' selected="selected" ' : '  ';
  echo '>High</option>';
}

function add_schools_box(){
  global $post;
  global $post_type;
  global $post_id;
    // $post_type = $post->post_type;
    $type = 'school';
    $args = array(
        'post_type' => $type,
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'caller_get_posts' => 1
      );
    $school_query = null;
    $school_query = new WP_Query($args);

    // echo '<input type="hidden" name="_df_' . $post_type . 'noncename" value="' . wp_create_nonce('df_' . $post_type . 'nonce') . '"/>';

    switch($post_type){
      case 'spell':
        echo "<p>The School that this spell is in.</p>";
        break;
      case 'role':
        echo "<p>The Schools that are in this role.</p>";
        break;
    }


    if($school_query->have_posts()){

      switch($post_type){
        case 'spell':
            $school_sel = get_post_meta($post_id, '_spell_school',true);
          break;
        case 'role':
            $school_sel = explode(',', get_post_meta($post_id, '_role_schools',true));
          break;
      }

      while($school_query->have_posts()) : $school_query->the_post();
        $slug = basename(get_permalink());

        switch($post_type){
          case 'spell':
            $selected = ($slug == $school_sel) ? ' checked="checked"' : '';
            echo '<label><input type="radio" name="_spell_school" value="' . basename(get_permalink()) . '"' . $selected . ' />&nbsp;&nbsp;&nbsp;' . get_the_title() . '</label><br>';
            break;
          case 'role':
            $selected = (in_array($slug,$school_sel)) ? ' checked="checked"' : '';
            echo '<label><input type="checkbox" name="_role_schools[]" value="' . basename(get_permalink()) . '"' . $selected . ' />&nbsp;&nbsp;&nbsp;' . get_the_title() . '</label><br>';
            break;
        }

      endwhile;
    }else{
      echo '<p><em>No Schools have been created.</em></p>';
    }
    wp_reset_query();
}

function add_descr_box()
{
    global $post;
    $post_type = $post->post_type;
    echo '<input type="hidden" name="_df_' . $post_type . 'noncename" value="' . wp_create_nonce('df_' . $post_type . 'nonce') . '"/>';
      switch($post_type){
        case "role":
        case "school":
        case "spell":
        case "video":
        case "clan":
        case "skill":
          $descr = get_post_meta($post->ID, '_' . $post_type . '_descr', true);
          echo "<p>Enter a description for the " . $post_type . "</p>";
          echo '<textarea name="_' . $post_type . '_descr" class="widefat" rows="5">' . $descr . '</textarea>';
          echo "<p><em>Note: All HTML is stripped</em></p>";
          break;
      }
}

function spell_role()
{
    global $post;
    $type = 'role';
    $args = array(
        'post_type' => $type,
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'caller_get_posts' => 1
      );
    $role_query = null;
    $role_query = new WP_Query($args);


    if($role_query->have_posts()){
      echo "<p>The Role that this spell is associated with.</p>";
      echo '<input type="hidden" name="_df_noncename" value="' . wp_create_nonce('df_nonce') . '"/>';
      $role_array = get_post_meta($post->ID, '_spell_role',true);
      while($role_query->have_posts()) : $role_query->the_post();
        $slug = basename(get_permalink());
        $selected = ($slug == $role_array) ? ' checked="checked"' : '';
      ?>
        <label><input type="radio" name="_spell_role" value="<?php echo $slug ?>" <?php echo $selected; ?> />&nbsp;&nbsp;&nbsp;<?php the_title(); ?></label><br>
      <?php
      endwhile;
    }else{
      echo '<p><em>No Roles have been created.</em></p>';
    }
    wp_reset_query();
}
function spell_ulti()
{
  global $post;
  global $post_id;
  echo "<p>Is this spell the School's Ultimate?</p>";
  $ulti_sel = get_post_meta($post_id, '_school_ulti', true);
  if($ulti_sel){
    echo "<label><input type='radio' name='_school_ulti' value='1' checked='checked' />&nbsp;&nbsp;&nbsp;Yes</label><br/>";
    echo "<label><input type='radio' name='_school_ulti' value='0'/>&nbsp;&nbsp;&nbsp;No</label><br/>";
  }else{
    echo "<label><input type='radio' name='_school_ulti' value='1' />&nbsp;&nbsp;&nbsp;Yes</label><br/>";
    echo "<label><input type='radio' name='_school_ulti' value='0' checked='checked'/>&nbsp;&nbsp;&nbsp;No</label><br/>";
  }
  echo "<p><em>Note: only one per school should be used<em></p>";
}
// Save Spell
function save_df_stuff($post_id, $post)
{
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    $post_type = $post->post_type;

    if (!wp_verify_nonce($_POST['_df_' . $post_type . 'noncename'], 'df_' . $post_type . 'nonce')) {
        return $post->ID;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post->ID;
    }
    // Is the user allowed to edit the post or page?
    if (!current_user_can('edit_post', $post->ID)){
        return $post->ID;
    }
    // OK, we're authenticated: we need to find and save the data

    // We'll put it into an array to make it easier to loop though. Only to our new post types
      switch($post->post_type){
        case 'role':
          $the_meta['_role_descr'] = $_POST['_role_descr'];
          $the_meta['_role_schools'] = $_POST['_role_schools'];
          $the_meta['health_val'] = $_POST['health_val'];
          $the_meta['stamina_val'] = $_POST['stamina_val'];
          $the_meta['mana_val'] = $_POST['mana_val'];
          $the_meta['attackpower_val'] = $_POST['attackpower_val'];
          $the_meta['support_val'] = $_POST['support_val'];
          $the_meta['defense_val'] = $_POST['defense_val'];
          break;
        case 'school':
          $the_meta['_school_descr'] = $_POST['_school_descr'];
          break;
        case 'spell':
          $the_meta['_spell_descr'] = $_POST['_spell_descr'];
          $the_meta['_school_ulti'] = $_POST['_school_ulti'];
          $the_meta['_spell_role'] = $_POST['_spell_role'];
          $the_meta['_spell_school'] = $_POST['_spell_school'];
          break;
        case 'video':
          $the_meta['_video_descr'] = $_POST['_video_descr'];
          $the_meta['_video_id'] = $_POST['_video_id'];
          break;
        case 'clan':
          $the_meta['_clan_descr'] = $_POST['_clan_descr'];
          $the_meta['_clan_url'] = $_POST['_clan_url'];
          $the_meta['_clan_leader_ign'] = $_POST['_clan_leader_ign'];
          $the_meta['_clan_leader_forum'] = $_POST['_clan_leader_forum'];
          $the_meta['_clan_server'] = $_POST['_clan_server'];
          break;
         case 'skill':
          $the_meta['_skill_descr'] = $_POST['_skill_descr'];
          break;
        case 'poi':
            $the_meta['_poi_type'] = $_POST['_poi_type'];
            $the_meta['_poi_level'] = $_POST['_poi_level'];
            $the_meta['_poi_loc'] = $_POST['_poi_lat'].'|'.$_POST['_poi_lng'];
            break;
      }

    // Add values of $events_meta as custom fields
    foreach ($the_meta as $key => $value) { // Cycle through the $events_meta array!
        if ($post->post_type == 'revision')
            return; // Don't store custom data twice
        $value = implode(',', (array) $value); // If $value is an array, make it a CSV (unlikely)
        if (get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
            update_post_meta($post->ID, $key, $value);
        } else { // If the custom field doesn't have a value
            add_post_meta($post->ID, $key, $value);
        }
        if (!$value)
            delete_post_meta($post->ID, $key); // Delete if blank
    }
}
add_action('save_post', 'save_df_stuff', 10, 2); // save the custom fields

/*-----------------------------------------------------------------------------------*/
/* Add Columns

/*-----------------------------------------------------------------------------------*/
add_image_size('spell_thumb', 50, 50, false);
add_image_size('role_thumb', 50, 50, false);
add_image_size('school_thumb', 50, 50, false);
add_filter('manage_edit-spell_columns', 'add_custom_dfuw_columns', 5);
add_filter('manage_edit-role_columns', 'add_custom_dfuw_columns', 5);
add_filter('manage_edit-school_columns', 'add_custom_dfuw_columns', 5);
add_filter('manage_edit-poi_columns', 'add_custom_dfuw_columns', 5);
// Add Column
function add_custom_dfuw_columns($cols)
{
    global $post_type;
    unset($cols['date']);
    switch($post_type){
        case 'role':
           $customArray = array(
            'role_descr' => __('Description'),
            'role_schools' => __('Schools'),
            'role_thumb' => __('Role Icon')
          );
          break;
        case 'school':
          $customArray = array(
             'school_descr' => __('Description'),
             'school_thumb' => __('School Icon')
          );
          break;
        case 'spell':
          $customArray = array(
            'school_ulti' => __('Ultimate'),
            'spell_descr' => __('Description'),
            'spell_role' => __('Role'),
            'spell_school' => __('School'),
            'spell_thumb' => __('Spell Icon')
          );
          break;
        case 'poi':
            $customArray = array(
                'adm_poi_type' => __('Type'),
                'adm_poi_lat' => __('Lat'),
                'adm_poi_lng' => __('Lng')
            );
            break;
      }
    $colsstart = array_slice($cols, 1, 1, true);
    $colsend   = array_slice($cols, 1, null, true);
    $cols      = array_merge(
        array('cb' => '<input type="checkbox" />'),
        $colsstart,
        $customArray,
        $colsend
    );
    return $cols;
}

// Register the column as sortable
add_filter( 'manage_edit-poi_sortable_columns', 'dfuw_column_register_sortable' );
function dfuw_column_register_sortable( $columns ) {
  $columns['adm_poi_type'] = 'adm_poi_type';
  $columns['adm_poi_lat'] = 'adm_poi_lat';

  return $columns;
}

// Custom Column Sort
add_filter( 'request', 'dfuw_poi_column_orderby' );
function dfuw_poi_column_orderby( $vars ) {
  if ( isset( $vars['orderby'] ) && 'adm_poi_type' == $vars['orderby'] ) {
    $vars = array_merge( $vars, array(
      'meta_key' => '_poi_type',
      'orderby' => 'meta_value'
    ) );
  }
  if ( isset( $vars['orderby'] ) && 'adm_poi_lat' == $vars['orderby'] ) {
    $vars = array_merge( $vars, array(
      'meta_key' => '_poi_loc',
      'orderby' => 'meta_value'
    ) );
  }
  return $vars;
}

add_action('manage_spell_posts_custom_column', 'display_custom_content');
add_action('manage_role_posts_custom_column', 'display_custom_content');
add_action('manage_school_posts_custom_column', 'display_custom_content');
add_action('manage_poi_posts_custom_column', 'display_custom_content');

//insert the content from db per custom column
function display_custom_content($cols)
{
    global $post;
    switch ($cols) {
        case 'spell_thumb':
            if (function_exists('the_post_thumbnail'))
                echo the_post_thumbnail('spell_thumb');
            else
                echo 'Not supported in theme';
            break;
        case 'spell_descr':
            $descr = get_post_meta($post->ID, '_spell_descr', true);
            if (empty($descr))
                echo __('Not Entered');
            else
                printf(__('%s'), $descr);
            break;
        case 'spell_role':
            $class = get_post_meta($post->ID, '_spell_role', true);
            if (empty($class))
                echo __('None');
            else
                $class = ucfirst($class);
                printf(__('%s'), $class);
            break;
         case 'spell_school':
            $schools = get_post_meta($post->ID, '_spell_school', true);
            if ( !empty($schools) ) {
                echo $schools;
            }
            else echo '<i>None.</i>';
            break;
          case 'school_ulti':
            $ulti = (boolean) get_post_meta($post->ID, '_school_ulti', true);
            echo ($ulti) ? "Yes" : "No";
            break;
          case 'role_descr':
            $descr = get_post_meta($post->ID, '_role_descr', true);
            if (empty($descr))
                echo __('Not Entered');
            else
                printf(__('%s'), $descr);
            break;
          case "school_descr":
            $descr = get_post_meta($post->ID, '_school_descr', true);
            if (empty($descr))
                echo __('Not Entered');
            else
                printf(__('%s'), $descr);
            break;
          case 'role_schools':
            $schools = get_post_meta($post->ID, '_role_schools', true);
            if ( !empty($schools) ) {
                echo $schools;
            }
            else echo '<i>None.</i>';
            break;
            case 'role_thumb':
            case 'spell_thumb':
            case 'school_thumb':
              if (function_exists('the_post_thumbnail'))
                echo the_post_thumbnail(array(50,50));
              break;
            case "adm_poi_type":
             $poi_type = get_post_meta($post->ID,'_poi_type',true);
             if ( !empty($poi_type) ) {
                echo $poi_type;
            }
            else echo '<i>Not Set</i>';
            break;
            case "adm_poi_lat":
             $poi_loc = get_post_meta($post->ID,'_poi_loc',true);
             if ( !empty($poi_loc) ) {
                $poi_loc = explode('|',$poi_loc);
                echo $poi_loc[0];
            }
            break;
            case "adm_poi_lng":
             $poi_loc = get_post_meta($post->ID,'_poi_loc',true);
             if ( !empty($poi_loc) ) {
                $poi_loc = explode('|',$poi_loc);
                echo $poi_loc[1];
            }
            break;
    }
}

// /*-----------------------------------------------------------------------------------*/
// /* Add Taxonomies

// /*-----------------------------------------------------------------------------------*/
// add_action('init', 'build_role_taxonomies', 0);

// function build_role_taxonomies(){
//   register_taxonomy(
//       'main-stats',
//       'role',
//       array(
//           'hierarchical' => true,
//           'label' => 'Main Stats',
//           'labels' => array(
//               'name' => _x( 'Main Stats', 'taxonomy general name' ),
//               'singular_name' => _x( 'Main Stat', 'taxonomy singular name' ),
//               'search_items' => __('Search Main Stats'),
//               'popular_items' => __('Popular Main Stats'),
//               'all_items' => __('All Main Stats'),
//               'edit_item' => __('Edit Stat'),
//               'update_item' => __('Update Stat'),
//               'add_new_item' => __('Add New Stat'),
//               'new_item_name' => __('New Stat Name'),
//               'separate_items_with_commas' => __('Separate stats with commas'),
//               'add_or_remove_items' => __('Add or remove stats'),
//               'choose_from_most_used' => __('Choose from the most used stats')
//             ),
//           'has_archive' => true,
//           'query_var' => true,
//           'rewrite' => array( 'slug' => 'main-stats','hierarchical' =>true),
//           'sort' => true
//         )
//     );
//   flush_rewrite_rules();
// }

/*-----------------------------------------------------------------------------------*/
/* Edit Admin Quick Edit

/*-----------------------------------------------------------------------------------*/

function remove_quick_edit( $actions ) {
  switch(get_post_type()){
    case 'spell':
    case 'role':
    case 'school':
      unset($actions['inline hide-if-no-js']);
    break;
  }

  return $actions;
}
add_filter('post_row_actions','remove_quick_edit',10,1);

/*-----------------------------------------------------------------------------------*/
/* Admin Styles

/*-----------------------------------------------------------------------------------*/
add_action( 'admin_head', 'dfuw_admin_styles' );
function dfuw_admin_styles() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() .  '/css/admin.css"/>';
}

/*-----------------------------------------------------------------------------------*/
/* Custom Page Template

/*-----------------------------------------------------------------------------------*/
add_filter('single_template', 'mmo_spell_template');
function mmo_spell_template($single_template){
  global $post;

  if($post->post_type == 'spells'){
    return dirname(__FILE__) . '/single-spells.php';
  }
  return $single_template;
}

add_filter('taxonomy_template', 'mmo_spell_school_template');
function mmo_spell_school_template($archive_template){
  global $post;
  if(is_tax('schools')){
    $archive_template = dirname(__FILE__).'/taxonomy-schools.php';
  }
  return $archive_template;
}


/*-----------------------------------------------------------------------------------*/
/* Custom Page for Darkfall

/*-----------------------------------------------------------------------------------*/
add_filter('template_redirect', 'df_template_redirect', 10, 2);

function df_template_redirect($requested_url=null, $do_redirect=true) {
  global $wp;
  global $wp_query;
  global $post;
  if($post->ID == 317){
    include(dirname(__FILE__). "/page-darkfall.php");
    die();
  }
  return;
}

// Defining the function used for displaying the Custom Project Post.
function yt_vid( $atts ) {
  // Extracting the arguments for the shortcode.
  extract( shortcode_atts( array(
    'vid' => '_T8FuVGXEMw'
  ), $atts ) );
  /* This is were we will write the code for fetching data
   * and build the HTML structure to be returned in the $output variable
   */
  $output = 'video id = {'.$vid.'}';
  return $output;
}

/* Login Page Stuff */
function dfuw_url_login(){
  return get_bloginfo('url');
}
add_filter('login_headerurl','dfuw_url_login');

// Custom WordPress Login Logo
function login_css() {
  wp_enqueue_style( 'login_css', get_template_directory_uri() . '/css/login.css' );
}
add_action('login_head', 'login_css');

// Custom WordPress Footer
function remove_footer_admin () {
  echo sprintf( __( '%1$s %2$s %3$s. All Rights Reserved. <br>All other trademarks or registered trademarks are property of their respective owners.', 'darkfalluw' ), '&copy;', date('Y'), esc_html(get_bloginfo('name').' '. get_bloginfo('description')) );
}
add_filter('admin_footer_text', 'remove_footer_admin');

/* Clan Shit */
add_rewrite_rule('^clans/([^/]*)/?','index.php?post_type=clan&server=$matches[1]','top');
add_rewrite_tag('%server%','([^&]+)');

/* remove comments menu item */
function remove_menus () {
global $menu;
  $restricted = array(__('Comments'));
  end ($menu);
  while (prev($menu)){
    $value = explode(' ',$menu[key($menu)][0]);
    if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
  }
}
add_action('admin_menu', 'remove_menus');

?>
