<?php
/*
Template Name: Misc Game Info
*/
get_header();
// wp_enqueue_script('dfuw_table_sort', get_template_directory_uri().'/js/jquery.tablesorter.min.js',false,$ver,'all');
?>
<article id="content" class="misc-game-info">
<?php the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div class="entry-content">
  <p  class='tip'><i class="icon-info-sign"></i> Table columns are sortable</p>
  <div class='misc-info left'>
    <h3>Weapon Reaches, Arcs, Crits</h3>
    <table cellspacing="0" cellpadding="2" border="1">
      <thead>
        <tr>
          <th>Type <i class="icon-chevron-up icon-white"></i></th>
          <th>Reach <i class="icon-chevron-up icon-white"></i></th>
          <th>Arc <i class="icon-chevron-up icon-white"></i></th>
          <th>Crit % <i class="icon-chevron-up icon-white"></i></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Axe</td>
          <td>1.95</td>
          <td>65&deg;</td>
          <td>7%</td>
        </tr>
        <tr>
          <td>Club</td>
          <td>1.95</td>
          <td>60&deg;</td>
          <td>3%</td>
        </tr>
        <tr>
          <td>Knives</td>
          <td>1.65</td>
          <td>70&deg;</td>
          <td>10%</td>
        </tr>
        <tr>
          <td>Greataxe</td>
          <td>2.45</td>
          <td>55&deg;</td>
          <td>20%</td>
        </tr>
        <tr>
          <td>Greatclub</td>
          <td>2.45</td>
          <td>50&deg;</td>
          <td>12%</td>
        </tr>
        <tr>
          <td>Greatsword</td>
          <td>2.5</td>
          <td>55&deg;</td>
          <td>16%</td>
        </tr>
        <tr>
          <td>Polearm</td>
          <td>2.7</td>
          <td>80&deg;</td>
          <td>4%</td>
        </tr>
        <tr>
          <td>Sword</td>
          <td>2.0</td>
          <td>65&deg;</td>
          <td>5%</td>
        </tr>
        <tr>
          <td>Bow</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>15%</td>
        </tr>
        <tr>
          <td>Staff</td>
          <td>N/A</td>
          <td>N/A</td>
          <td>10%</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="misc-info right">
    <h3>Role Exclusions</h3>
    <h4>Warrior</h4>
    <ul>
      <li>Battle Brand excludes Slayer and vice versa</li>
      <li>Baresark excludes Champion and vice versa</li>
    </ul>
    <h4>Skirmisher</h4>
    <ul>
      <li>Brawler excludes Blackguard and vice versa</li>
      <li>Deadeye excludes Duelist and vice versa</li>
    </ul>
    <h4>Elementist</h4>
    <ul>
      <li>Fire excludes Water and vice versa</li>
      <li>Air excludes Earth and vice versa</li>
    </ul>
    <h4>Primalist</h4>
    <ul>
      <li>Pain excludes Life and vice versa</li>
      <li>Law excludes Chaos and vice versa</li>
    </ul>
  </div>
  <div class="clear"></div>
  <div class="misc-info left">
    <h3>Player Movement Speeds</h3>
    <table cellpadding="0" cellspacing="0">
      <thead>
        <tr>
          <th>Type <i class="icon-chevron-up icon-white"></i></th>
          <th>Speed <i class="icon-chevron-up icon-white"></i></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Climbing</td>
          <td>2.0</td>
        </tr>
        <tr>
          <td>Crouchwalk</td>
          <td>1.5</td>
        </tr>
        <tr>
          <td>Walk</td>
          <td>1.75</td>
        </tr>
        <tr>
          <td>Run</td>
          <td>3.5</td>
        </tr>
        <tr>
          <td>Run Strafe</td>
          <td>2.6</td>
        </tr>
        <tr>
          <td>Sprint</td>
          <td>6.0</td>
        </tr>
        <tr>
          <td>Swim</td>
          <td>2.0</td>
        </tr>
        <tr>
          <td>Swim Fast</td>
          <td>4.0</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="misc-info right">
    <h3>Combat Ranks</h3>
    <p>Presumably these are kills during a siege. If so, it will take a mighty long time
    to achieve high ranks. Your kill count is reset to 0 if you leave a clan and rejoin
    it.</p>
    <table cellpadding="0" cellspacing="0">
      <thead>
        <tr>
          <th>Kills <i class="icon-chevron-up icon-white"></i></th>
          <th>Rank <i class="icon-chevron-up icon-white"></i></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>0</td>
          <td>Recruit</td>
        </tr>
        <tr>
          <td>10</td>
          <td>Private</td>
        </tr>
        <tr>
          <td>20</td>
          <td>Corporal</td>
        </tr>
        <tr>
          <td>50</td>
          <td>Sergeant</td>
        </tr>
        <tr>
          <td>100</td>
          <td>Lieutenant</td>
        </tr>
        <tr>
          <td>225</td>
          <td>Captain</td>
        </tr>
        <tr>
          <td>500</td>
          <td>Major</td>
        </tr>
        <tr>
          <td>1000</td>
          <td>Colonel</td>
        </tr>
        <tr>
          <td>2500</td>
          <td>General</td>
        </tr>
        <tr>
          <td>5000</td>
          <td>SupremeGeneral</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="misc-info left">
    <h3>Damage Formula</h3>
    [ (0.2 * <strong>MS</strong> + 0.05 * <strong>WS</strong> + 0.03 * <strong>WM</strong>) + <strong>WD</strong> - <strong>AR</strong> ]
    <br><br>
      <strong>MS</strong> = Main Stat<br>
      <strong>WS</strong> = Weapon Skill<br>
      <strong>WM</strong> = Weapon Mastery<br>
      <strong>WD</strong> = Weapon Damage<br>
      <strong>AR</strong> = Armor Resist<br>
  </div>
  <br>
  <div class="misc-info full">
      <h3>Diminishing Returns</h3>
      <!-- Embed Chart from Google -->
      <img src="https://docs.google.com/spreadsheets/d/1P47PRZ7Kb7iIJ1Rd6PM272XF0b_cs7TsMpLzc_AefE4/embed/oimg?id=1P47PRZ7Kb7iIJ1Rd6PM272XF0b_cs7TsMpLzc_AefE4&oid=1244908227&zx=yngpjd2t9poa" />
    </div>
    <br>
  <div class="misc-info full">
    <h3>Crosshair Wobble</h3>
    <p>Default units are in radians with a degree conversion next to them. Change time
    represents how long it takes to change from one state to the other, such as running
    wobble to sprinting wobble.</p>
    <table cellpadding="0" cellspacing="0">
      <thead>
        <tr>
          <th>Weapon Type <i class="icon-chevron-up icon-white"></i></th>
          <th>Standing Wobble <i class="icon-chevron-up icon-white"></i></th>
          <th>Running Wobble <i class="icon-chevron-up icon-white"></i></th>
          <th>Sprinting Wobble <i class="icon-chevron-up icon-white"></i></th>
          <th>Change Time <i class="icon-chevron-up icon-white"></i></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Bow</td>
          <td>0</td>
          <td>0.003r (0.172&deg;)</td>
          <td>0.006r (0.344&deg;)</td>
          <td>0.2s</td>
        </tr>
        <tr>
          <td>Magic Staff</td>
          <td>0</td>
          <td>0.002r (0.115&deg;)</td>
          <td>0.004r (0.229&deg;)</td>
          <td>0.3s</td>
        </tr>
        <tr>
          <td>Throwable Weapon</td>
          <td>0</td>
          <td>0.004r (0.229&deg;)</td>
          <td>0.008r (0.458&deg;)</td>
          <td>0.4s</td>
        </tr>
      </tbody>
    </table>
    <div class="clearfix"></div>
  </div>
  <div class="disclaimer">
    ** Content provided by Kelet
  </div>
</div>
</div>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>asda
