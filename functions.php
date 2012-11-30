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
          add_meta_box('spells_school', 'School', 'spell_school', 'spell', 'normal', 'default');
          add_meta_box('spells_ulti', 'Ultimate', 'spell_ulti', 'spell', 'normal', 'default');
          break;
        case "role":
          add_meta_box('role_description', 'Description', 'add_descr_box', 'role', 'normal', 'default');
          add_meta_box('role_schools', 'Schools', 'add_schools_box', 'role', 'normal', 'default');
          add_meta_box('role_stats', 'Base Stats', 'add_stats_box', 'role', 'normal', 'default');
          break;
        case "school":
          add_meta_box('school_description', 'Description', 'add_descr_box', 'school', 'normal', 'default');
          break;
      }
    }

}

function add_stats_box() {
  echo '<label><span>Health</span>&nbsp;&nbsp;&nbsp;<select name="health_perc" value=""/><option value="">Select Value</option><option value="low">Low</option><option value="avg">Average</option><option value="high">High</option></select>';
  echo '<label><span>Stamina</span>&nbsp;&nbsp;&nbsp;<select name="stamina_val" value=""/><option value="">Select Value</option><option value="low">Low</option><option value="avg">Average</option><option value="high">High</option></select>';
  echo '<label><span>Mana</span>&nbsp;&nbsp;&nbsp;<select name="mana_val" value=""/><option value="">Select Value</option><option value="low">Low</option><option value="avg">Average</option><option value="high">High</option></select>';
  echo '<label><span>Attack-Power</span>&nbsp;&nbsp;&nbsp;<select name="attackpower_val" value=""/><option value="">Select Value</option><option value="low">Low</option><option value="avg">Average</option><option value="high">High</option></select>';
  echo '<label><span>Support</span>&nbsp;&nbsp;&nbsp;<select name="support_val" value=""/><option value="">Select Value</option><option value="low">Low</option><option value="avg">Average</option><option value="high">High</option></select>';
  echo '<label><span>Defense</span>&nbsp;&nbsp;&nbsp;<select name="defense_val" value=""/><option value="">Select Value</option><option value="low">Low</option><option value="avg">Average</option><option value="high">High</option></select>';
}

function add_schools_box(){
  global $post;
    $type = 'school';
    $args = array(
        'post_type' => $type,
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'caller_get_posts' => 1
      );
    $school_query = null;
    $school_query = new WP_Query($args);

    if($school_query->have_posts()){
      echo "<p>The Schools that are in this role.</p>";
      echo '<input type="hidden" name="_school_noncename" value="' . wp_create_nonce('school-nonce') . '"/>';
      while($school_query->have_posts()) : $school_query->the_post();
        $schools_sel = explode(',', get_post_meta($post->ID, '_spell_school', true));
        $selected = (in_array($school_query, $schools_sel)) ? ' checked="checked"' : '';

      ?>
        <label><input type="checkbox" name="_spell_school[]" value="<?php basename(get_permalink()); ?>" <?php echo $selected; ?>/>&nbsp;&nbsp;&nbsp;<?php the_title(); ?></label><br>
      <?php
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

      switch($post_type){
        case "role":
        case "school":
        case "spell":
          $descr = get_post_meta($post->ID, '_' . $post_type . '_descr', true);
          echo "<p>Enter a description describing the " . $post_type . "</p>";
          echo '<textarea name="_' . $post_type . '_descr" value="' . $descr . '" class="widefat" rows="5"></textarea>';
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
      echo '<input type="hidden" name="_spell_noncename" value="' . wp_create_nonce('spell_nonce') . '"/>';
      while($role_query->have_posts()) : $role_query->the_post();
        $roles_sel = explode(',', get_post_meta($post->ID, '_spell_role', true));
        $selected = (in_array($role_query, $roles_sel)) ? ' checked="checked"' : '';

      ?>
        <label><input type="radio" name="_spell_role[]" value="<?php basename(get_permalink()); ?>" <?php echo $selected; ?>/>&nbsp;&nbsp;&nbsp;<?php the_title(); ?></label><br>
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
  echo "<p>Is this spell the School's Ultimate?</p>";
  $ulti_sel = (boolean) get_post_meta($post->ID, 'school-ulti', true);
  if($ulti_sel){
    echo "<label><input type='radio' name='school-ulti' value='1' checked='checked' />&nbsp;&nbsp;&nbsp;Yes</label><br/>";
    echo "<label><input type='radio' name='school-ulti' value='0'/>&nbsp;&nbsp;&nbsp;No</label><br/>";
  }else{
    echo "<label><input type='radio' name='school-ulti' value='1' />&nbsp;&nbsp;&nbsp;Yes</label><br/>";
    echo "<label><input type='radio' name='school-ulti' value='0' checked='checked'/>&nbsp;&nbsp;&nbsp;No</label><br/>";
  }
  echo "<p><em>Note: only one per school should be used<em></p>";
}
// Save Spell
function save_spell($post_id, $post)
{
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if (!wp_verify_nonce($_POST['_spell_noncename'], plugin_basename(__FILE__))) {
        return $post->ID;
    }
    // Is the user allowed to edit the post or page?
    if (!current_user_can('edit_post', $post->ID))
        return $post->ID;
    // OK, we're authenticated: we need to find and save the data
    // We'll put it into an array to make it easier to loop though.
    $spell_meta['_spell_role'] = $_POST['_spell_role'];
    $spell_meta['_spell_descr']     = $_POST['_spell_descr'];
    $spell_meta['school-ulti']     = $_POST['school-ulti'];
    // Add values of $events_meta as custom fields
    foreach ($spell_meta as $key => $value) { // Cycle through the $events_meta array!
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
add_action('save_post', 'save_spell', 1, 3); // save the custom fields

/*-----------------------------------------------------------------------------------*/
/* Add Columns

/*-----------------------------------------------------------------------------------*/
add_image_size('spell_thumb', 50, 50, false);
add_filter('manage_edit-spells_columns', 'add_spell_columns', 5);
// Add Column
function add_spell_columns($cols)
{
  unset($cols['date']);
    $colsstart = array_slice($cols, 1, 1, true);
    $colsend   = array_slice($cols, 1, null, true);
    $cols      = array_merge(
        array('cb' => '<input type="checkbox" />'),
        $colsstart,
        array(
          'school-ulti' => __('Ultimate'),
          'spell_descr' => __('Description'),
          'spell_role' => __('Role'),
          'spell_school' => __('School'),
          'spell_thumb' => __('Spell Icon')
        ),
        $colsend
    );
    return $cols;
}

// Register the column as sortable
add_filter( 'manage_edit-spells_sortable_columns', 'mmo_column_register_sortable' );
function mmo_column_register_sortable( $columns ) {
  $columns['spell_role'] = 'spell_role';
  $columns['spell_school'] = 'spell_school';

  return $columns;
}

// Spell Class Sort
add_filter( 'request', 'mmo_spell_role_column_orderby' );
function mmo_spell_role_column_orderby( $vars ) {
  if ( isset( $vars['orderby'] ) && 'spell_role' == $vars['orderby'] ) {
    $vars = array_merge( $vars, array(
      'meta_key' => '_spell_role',
      'orderby' => 'meta_value'
    ) );
  }

  return $vars;
}

// Make Tax Sort
add_filter( 'posts_clauses', 'make_school_sort', 10, 2 );
function make_school_sort( $clauses, $wp_query ) {
  global $wpdb;

  if ( isset( $wp_query->query['orderby'] ) && 'roles' == $wp_query->query['orderby'] ) {

    $clauses['join'] .= <<<SQL
LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
SQL;

    $clauses['where'] .= " AND (taxonomy = 'spell_school' OR taxonomy IS NULL)";
    $clauses['groupby'] = "object_id";
    $clauses['orderby']  = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC) ";
    $clauses['orderby'] .= ( 'ASC' == strtoupper( $wp_query->get('order') ) ) ? 'ASC' : 'DESC';
  }

  return $clauses;
}

//Hook unto the posts column managin
add_action('manage_spells_posts_custom_column', 'display_spell_content');

function display_spell_content($cols)
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
            // $descr = get_post_meta($post_id, '_spellID', true);
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
            $taxonomy = $cols;
            $post_type = get_post_type($post->ID);
            $terms = get_the_terms($post->ID, 'schools');
            if ( !empty($terms) ) {
                foreach ( $terms as $term )
                    $post_terms[] = esc_html(sanitize_term_field('name', $term->name, $term->term_id, $taxonomy, 'edit'));
                echo join( ', ', $post_terms );
            }
            else echo '<i>None.</i>';
            break;
          case 'school-ulti':
            $ulti = (boolean) get_post_meta($post->ID, 'school-ulti', true);
            echo ($ulti) ? "Yes" : "No";
            break;
    }
}

/*-----------------------------------------------------------------------------------*/
/* Add Taxonomies

/*-----------------------------------------------------------------------------------*/
add_action('init', 'build_mmo_taxonomies', 0);

function build_mmo_taxonomies(){
  register_taxonomy(
      'schools',
      'spells',
      array(
          'hierarchical' => true,
          'label' => 'Schools',
          'labels' => array(
              'name' => _x( 'Schools', 'taxonomy general name' ),
              'singular_name' => _x( 'Schools', 'taxonomy singular name' ),
              'search_items' => __('Search Schools'),
              'popular_items' => __('Popular Schools'),
              'all_items' => __('All Schools'),
              'edit_item' => __('Edit School'),
              'update_item' => __('Update School'),
              'add_new_item' => __('Add New School'),
              'new_item_name' => __('New School Name'),
              'separate_items_with_commas' => __('Separate schools with commas'),
              'add_or_remove_items' => __('Add or remove schools'),
              'choose_from_most_used' => __('Choose from the most used schools')
            ),
          'has_archive' => true,
          'query_var' => true,
          'rewrite' => array( 'slug' => 'games/darkfall/school','hierarchical' =>true),
          'sort' => true
        )
    );
  flush_rewrite_rules();
}

/*-----------------------------------------------------------------------------------*/
/* Edit Admin Quick Edit

/*-----------------------------------------------------------------------------------*/

function remove_quick_edit( $actions ) {
  if(get_post_type() == 'spells')
    unset($actions['inline hide-if-no-js']);

  return $actions;
}
add_filter('post_row_actions','remove_quick_edit',10,1);

/*-----------------------------------------------------------------------------------*/
/* Add Custom Icons

/*-----------------------------------------------------------------------------------*/
add_action( 'admin_head', 'dfuw_admin_styles' );
function dfuw_admin_styles() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-spell .wp-menu-image {
            background: url(<?php echo get_template_directory_uri(); ?>/images/spell16.png) no-repeat 6px 7px !important;
        }
  #menu-posts-spell:hover .wp-menu-image, #menu-posts-spell.wp-has-current-submenu .wp-menu-image {
            background-position:6px 7px !important;
        }
        #icon-edit.icon32-posts-spell {
          background: url(<?php echo get_template_directory_uri(); ?>/images/spell32.png) no-repeat;
        }

        #menu-posts-role .wp-menu-image {
            background: url(<?php echo get_template_directory_uri(); ?>/images/role16.png) no-repeat 6px 7px !important;
        }
  #menu-posts-role:hover .wp-menu-image, #menu-posts-role.wp-has-current-submenu .wp-menu-image {
            background-position:6px 7px !important;
        }
        #icon-edit.icon32-posts-role {
          background: url(<?php echo get_template_directory_uri(); ?>/images/role32.png) no-repeat;
        }

        #menu-posts-school .wp-menu-image {
            background: url(<?php echo get_template_directory_uri(); ?>/images/school16.png) no-repeat 6px 7px !important;
        }
  #menu-posts-school:hover .wp-menu-image, #menu-posts-school.wp-has-current-submenu .wp-menu-image {
            background-position:6px 7px !important;
        }
        #icon-edit.icon32-posts-school {
          background: url(<?php echo get_template_directory_uri(); ?>/images/school32.png) no-repeat;
        }

        /* META BOXES */
        #spells_role, #spells_school, #spells_ulti {
          width: 30%;
          float: left;
          margin-right: 4%;
        }
         #spells_ulti {
          margin-right: 0;
          float: right;
         }
         #role_schools, #role_stats {
          width: 100px;
          float:left;
          margin-right: 20px;
         }
         #role_stats {
          text-align: right;
         }
         #role_stats h3 {
          text-align: center;
         }
         #role_stats label {
          display: block;
          clear:both;
         }
         #role_stats label span {
          padding-top: 4px;
          display: block;
          float: left;
          vertical-align: middle;
          height: 25px;
          margin-left: 14px;
         }
         #role_stats select {
          float: right;
          margin-right: 40px;
         }
    </style>
<?php
}

/*-----------------------------------------------------------------------------------*/
/* Custome Page Template

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

?>
