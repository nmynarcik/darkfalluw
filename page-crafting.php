<?php
/*
Template Name: Crafting
*/
get_header();
// wp_enqueue_script('dfuw_jdrag', get_template_directory_uri().'/js/lib/jquery.event.drag-2.0.min.js',false,$er,'all');
// wp_enqueue_script('dfuw_j2csv', get_template_directory_uri().'/js/lib/jquery.csv-0.71.min.js',false,$er,'all');
// wp_enqueue_script('dfuw_slickcore', get_template_directory_uri().'/js/lib/slick.core.js',false,$er,'all');
// wp_enqueue_script('dfuw_slickautotips', get_template_directory_uri().'/js/plugins/slick.autotooltips.js',false,$er,'all');
// wp_enqueue_script('dfuw_slickcellranger', get_template_directory_uri().'/js/plugins/slick.cellrangeselector.js',false,$er,'all');
// wp_enqueue_script('dfuw_slickcelldecor', get_template_directory_uri().'/js/plugins/slick.cellrangedecorator.js',false,$er,'all');
// wp_enqueue_script('dfuw_slickcellext', get_template_directory_uri().'/js/plugins/slick.cellexternalcopymanager.js',false,$er,'all');
// wp_enqueue_script('dfuw_slickcellselect', get_template_directory_uri().'/js/plugins/slick.cellselectionmodel.js',false,$er,'all');
// wp_enqueue_script('dfuw_slickdata', get_template_directory_uri().'/js/lib/slick.dataview.js',false,$er,'all');
// wp_enqueue_script('dfuw_slickeditor', get_template_directory_uri().'/js/lib/slick.editors.js',false,$er,'all');
// wp_enqueue_script('dfuw_slickformat', get_template_directory_uri().'/js/lib/slick.formatters.js',false,$er,'all');
// wp_enqueue_script('dfuw_slickgrid', get_template_directory_uri().'/js/slick.grid.js',false,$er,'all');
// wp_enqueue_style( 'dfuw_slick_styles', get_template_directory_uri().'/css/slick.grid.css', false, $ver, 'all' );
wp_enqueue_style( 'jquery_ui_css', get_template_directory_uri().'/css/jquery-ui.theme.min.css', false, $ver, 'all' );
wp_enqueue_script('jquery_ui_js', '//code.jquery.com/ui/1.11.0/jquery-ui.js',false,$ver,'all');
wp_enqueue_script('dfuw_crafting', get_template_directory_uri().'/js/crafting.js',false,$ver,'all'); //min
?>
<article id="content" class="full-width">
<?php the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="entry-content">
  <?php the_content(); ?>
  <div id="selections">
      <label class="checkbox">
        <input type="checkbox" id="mastery"> Mastery
      </label>
        <select id="trade_select">
          <option value="">Select Trade</option>
          <option value="alchemy">Alchemy</option>
          <option value="armorsmithing">Armor</option>
          <option value="bowyer">Bowyer</option>
          <option value="construction">Construction</option>
          <option value="cooking">Cooking</option>
          <option value="engineering">Engineering</option>
          <option value="leatherworking">Leather</option>
          <option value="mountsummoning">Mounts</option>
          <option value="shieldcrafting">Shields</option>
          <option value="shipbuilding">Ship Building</option>
          <option value="smelting">Smelting</option>
          <option value="staffcrafting">Staffs</option>
          <option value="tailoring">Tailoring</option>
          <option value="tanning">Tanning</option>
          <option value="weaponsmithing">Weapons</option>
          <option value="weaving">Weaving</option>
          <option value="woodcutting">Wood Cutting</option>
        </select>
        <div class="selection-box">
          <select id="select-two"></select>
        </div>
        <div class="selection-box">
          <select id="select-three"></select>
        </div>
    </div>
    <div id="item-details">
      <!-- Item Details -->
    </div>
</div>
</div>
</article>
<!-- Item Template -->
<div id="item-template" class="template" style="display: none;">
  <div class="left">
    <div class="well well-large ingredients">
      <div class="thumb-cont">
        <div id="thumb"></div>
        <div class="btn-group">
          <button class="btn styleSwitch" data-style="stoic" title="Stoic">S</button>
          <button class="btn styleSwitch active" data-style="militant" title="Militant">M</button>
          <button class="btn styleSwitch" data-style="barbaric" title="Barbaric">B</button>
        </div>
      </div>
      <div class="details">
      </div>
    </div>
  </div>
  <div class="right">
    <div class="quantity">
      <label for="quantity">How Many?</label>
      <input type="number" value="1" name="quantity" min="1" max="100" id="item-count" pattern="[0-9]{3}"/>
    </div>
    <div class="recipe">
      <label for="recipe">Recipe</label>
      <div class="well well-small" onclick="this.select();">Recipe Here</div>
    </div>
  </div>
</div>
<!-- End Item Template -->
<?php get_footer(); ?>
