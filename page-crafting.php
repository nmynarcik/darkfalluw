<?php
/*
Template Name: Crafting
*/
get_header();
wp_enqueue_script('dfuw_jdrag', get_template_directory_uri().'/js/lib/jquery.event.drag-2.0.min.js',false,$er,'all');
wp_enqueue_script('dfuw_j2csv', get_template_directory_uri().'/js/lib/jquery.csv-0.71.min.js',false,$er,'all');
wp_enqueue_script('dfuw_slickcore', get_template_directory_uri().'/js/lib/slick.core.js',false,$er,'all');
wp_enqueue_script('dfuw_slickautotips', get_template_directory_uri().'/js/plugins/slick.autotooltips.js',false,$er,'all');
wp_enqueue_script('dfuw_slickcellranger', get_template_directory_uri().'/js/plugins/slick.cellrangeselector.js',false,$er,'all');
wp_enqueue_script('dfuw_slickcelldecor', get_template_directory_uri().'/js/plugins/slick.cellrangedecorator.js',false,$er,'all');
wp_enqueue_script('dfuw_slickcellext', get_template_directory_uri().'/js/plugins/slick.cellexternalcopymanager.js',false,$er,'all');
wp_enqueue_script('dfuw_slickcellselect', get_template_directory_uri().'/js/plugins/slick.cellselectionmodel.js',false,$er,'all');
wp_enqueue_script('dfuw_slickdata', get_template_directory_uri().'/js/lib/slick.dataview.js',false,$er,'all');
wp_enqueue_script('dfuw_slickeditor', get_template_directory_uri().'/js/lib/slick.editors.js',false,$er,'all');
wp_enqueue_script('dfuw_slickformat', get_template_directory_uri().'/js/lib/slick.formatters.js',false,$er,'all');
wp_enqueue_script('dfuw_slickgrid', get_template_directory_uri().'/js/slick.grid.js',false,$er,'all');
wp_enqueue_style( 'dfuw_slick_styles', get_template_directory_uri().'/css/slick.grid.css', false, $ver, 'all' );
wp_enqueue_script('dfuw_crafting', get_template_directory_uri().'/js/crafting.min.js',false,$ver,'all');
?>
<article id="content" class="full-width">
<?php the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="entry-content">
  <?php the_content(); ?>
  <!-- <iframe class="gdoc" width="100%" height="750" src="https://docs.google.com/spreadsheet/lv?key=0Aj1bEOdIK16ldGYxeGZETldaRGdxWGZsVnBtS25IRnc&output=html"></iframe> -->
  <div class="data-wrapper" style="position:relative;">
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
        <option value="shipbuilding">Ships</option>
        <option value="smelting">Smelting</option>
        <option value="staffcrafting">Staffs</option>
        <option value="tailoring">Tailoring</option>
        <option value="tanning">Tanning</option>
        <option value="weaponsmithing">Weapons</option>
        <option value="weaving">Weaving</option>
        <option value="woodcutting">Wood Cutting</option>
      </select>
      <div id="craftingGrid" style="width:920px;height:800px; position: relative; top:0; bottom:0"></div>
    </div>
  <div class="disclaimer">** Content provided by Kelet</div>
</div>
</div>
</article>
<?php get_footer(); ?>
