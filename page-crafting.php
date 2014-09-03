<?php
/*
Template Name: Crafting
*/
get_header();
wp_enqueue_style( 'jquery_ui_css', get_template_directory_uri().'/css/jquery-ui.theme.min.css', false, $ver, 'all' );
wp_enqueue_script('dfuw_crafting', get_template_directory_uri().'/js/crafting.min.js', array('jquery','jquery-ui-js'),$ver,true);
wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
?>
<article id="content" class="full-width">
<?php the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="entry-content">
  <div class="gad" data-ad-type="square">
    <script type="text/javascript"><!--
    google_ad_client = "ca-pub-0373971494255887";
    /* DFUW Sidebar */
    google_ad_slot = "6114571902";
    google_ad_width = 180;
    google_ad_height = 150;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
  </div>
  <?php the_content(); ?>
  <div id="selections">
      <div id="settings" class="clearfix">
        <label class="checkbox">
          <input type="checkbox" id="mastery"> Mastery
        </label>
        <label class="checkbox">
          <input type="checkbox" id="discount"> Clan City Bonus
        </label>
      </div>
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
    <div class="well well-large ingredients" data-html="true" data-placement="right" data-trigger="hover" data-title="Item Protection Ranges:">
      <div class="thumb-cont">
        <div id="thumb"></div>
        <div class="btn-group">
          <button class="btn btn-inverse styleSwitch" data-style="stoic" title="Stoic">S</button>
          <button class="btn btn-inverse styleSwitch active" data-style="militant" title="Militant">M</button>
          <button class="btn btn-inverse styleSwitch" data-style="barbaric" title="Barbaric">B</button>
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
      <div class="well well-small">Recipe Here</div>
    </div>
  </div>
</div>
<div id="recipeModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="recipeModalLabel" aria-hidden="true">
  <div class="modal-header">
    <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
    <h2 id="recipeModalLabel">Modal header</h2>
  </div>
  <div class="modal-body">
    <textarea id="modalRecipeDetails">Modal Content</textarea>
  </div>
  <div class="modal-footer">
    <p>Just copy and close...</p>
    <button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
<!-- End Item Template -->
<?php get_footer(); ?>
