<?php
/*
Template Name: Darkfall Home Page
*/
get_header();
$dir = get_bloginfo('url') . '/wp-content/plugins/df_content_info';
    wp_enqueue_style('df_styles', $dir . '/css/spell-styles.css',false,'1.6','all');
    wp_enqueue_script('df_js', $dir . '/js/df_content_info.js',false,'1.6','all');
?>
  <!-- CONTENT -->
    <div id="content" class="full-width">
      <section class="mian-content full-height darkfall" role="main">
        <article>
        <?php while ( have_posts() ) : the_post(); ?>
        <header>
          <h2><?php the_title(); ?></h2>
        </header>
        <div class="entry-content">

          <p class="bio">
          <?php
              $theContent = get_the_content();
              echo strip_tags($theContent);
            ?>
          </p>

          <div class="clear"></div>

          <div class="accordion">
            <h4 class="accordion-header current"><a href="#">Elementalist</a></h4>
            <div class="pane" style="display: block;">
              <img src="<?php echo $dir;?>/images/elementalist.jpg" class="icon" alt="" width="150" height="150">
              <div class="descr">
                <p>The elementalist is a magic user which focus on elemental magic. The elementalist is able to use 2 non-opposing schools. Elementalist spells have an AoE. Elementalists have the lowest HPs but have the highest base damage and the most magical points. </p>
                <div class="detail-list">
                  <h2>Schools:</h2>
                  <ul class="school-list">
                    <li><a href="./school/fire" class="icon fire" alt="Fire" title="Fire">Fire</a></li>
                  </ul>
                </div>
                <div class="detail-list">
                  <h2>Main Stat(s):</h2>
                  <ul>
                    <li>Intelligence</li>
                    <li>Mana</li>
                    <li>Stamina</li>
                  </ul>
                </div>
                <div class="detail-list last">
                  <h2>Base Stats:</h2>
                  <ul class="bars">
                    <li class="health low"><span class='label'>Health</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="stamina avg"><span class='label'>Stamina</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="mana high"><span class='label'>Mana</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="attack-power high"><span class='label'>Attack-Power</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="support low"><span class='label'>Support</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="defense low"><span class='label'>Defense</span> <span class="bar"><span class="fill"></span></span></li>
                  </ul>
                </div>
              </div>
            </div>
            <h4 class="accordion-header"><a href="#">Warrior</a></h4>
            <div class="pane" style="display: none;"><img src="<?php echo $dir;?>/images/warrior.jpg" class="icon" alt="" width="150" height="150">
              <div class="descr">
                <p>The warrior is the ultimate melee fighter. He relies heavily on defense and gap-closing abilities. They are not as versatile as elementalists or skirmishers. Their main gear are heavy armors and strong melee weapons. They are able to be both a heavy damage dealer or the tank.</p>
                <div class="detail-list">
                  <h2>Schools:</h2>
                  <ul class="school-list">
                    <li><a href="./school/baresark/" class="icon baresark" alt="Baresark" title="Baresark">Baresark</a></li>
                    <li><a href="./school/battle-brand/" class="icon battlebrand" alt="Battle Brand" title="Battle Brand">Battle Brand</a></li>
                  </ul>
                </div>
                <div class="detail-list">
                  <h2>Main Stat(s):</h2>
                  <ul>
                    <li>Strength</li>
                    <li>Health</li>
                    <li>Stamina</li>
                  </ul>
                </div>
                <div class="detail-list last">
                  <h2>Base Stats:</h2>
                  <ul class="bars">
                    <li class="health high"><span class='label'>Health</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="stamina avg"><span class='label'>Stamina</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="mana low"><span class='label'>Mana</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="attack-power avg"><span class='label'>Attack-Power</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="support avg"><span class='label'>Support</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="defense high"><span class='label'>Defense</span> <span class="bar"><span class="fill"></span></span></li>
                  </ul>
                </div>
              </div>
            </div>
            <h4 class="accordion-header"><a href="#">Skirmisher</a></h4>
            <div class="pane" style="display: none;"><img src="<?php echo $dir;?>/images/skirmisher.jpg" class="icon" alt="" width="150" height="150">
              <div class="descr">
                <p>Skirmishers are hybrids, they rely both on melee and archery making them extremely versatile. Skirmishers relies on "FPS" skill more then any other class as most of their attacks do not have AoEs. Their main gear are: melee weapons, Bows and medium armor.</p>
                <div class="detail-list">
                  <h2>Schools:</h2>
                  <ul class="school-list">
                    <li><a href="./school/brawler/" class="icon brawler" alt="Brawler" title="Brawler">Brawler</a></li>
                    <li><a href="./school/deadeye/" class="icon deadeye" alt="Deadeye" title="Deadeye">Deadeye</a></li>
                  </ul>
                </div>
                <div class="detail-list">
                  <h2>Main Stat(s):</h2>
                  <ul>
                    <li>Dexterity</li>
                    <li>Strength</li>
                    <li>Stamina</li>
                  </ul>
                </div>
                <div class="detail-list last">
                  <h2>Base Stats:</h2>
                  <ul class="bars">
                    <li class="health avg"><span class='label'>Health</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="stamina avg"><span class='label'>Stamina</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="mana avg"><span class='label'>Mana</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="attack-power high"><span class='label'>Attack-Power</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="support low"><span class='label'>Support</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="defense avg"><span class='label'>Defense</span> <span class="bar"><span class="fill"></span></span></li>
                  </ul>
                </div>
              </div>
            </div>
            <h4 class="accordion-header"><a href="#">Primalist</a></h4>
            <div class="pane" style="display: none;"><img src="<?php echo $dir;?>/images/no-spell.png" class="icon" alt="" width="150" height="150">
              <div class="descr">
                <p>Primalists are the support class in darkfall. They rely on "Buffs" and "Debuffs", healing and draining abilities. Primalists are one of the most important class when it comes to group fighting. Their main gears are robes and staves. The primalist is able to use 2 non-opposing schools.</p>
                <div class="detail-list">
                  <h2>Schools:</h2>
                  <ul class="school-list">
                    <li><!-- <a href="./school/deadeye/" class="icon deadeye" alt="Deadeye" title="Deadeye">Deadeye</a> -->Unknown</li>
                  </ul>
                </div>
                <div class="detail-list">
                  <h2>Main Stat(s):</h2>
                  <ul>
                    <li>Wisdom</li>
                    <li>Mana</li>
                    <li>Stamina</li>
                  </ul>
                </div>
                <div class="detail-list last">
                  <h2>Base Stats:</h2>
                  <ul class="bars">
                    <li class="health low"><span class='label'>Health</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="stamina avg"><span class='label'>Stamina</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="mana high"><span class='label'>Mana</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="attack-power low"><span class='label'>Attack-Power</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="support high"><span class='label'>Support</span> <span class="bar"><span class="fill"></span></span></li>
                    <li class="defense avg"><span class='label'>Defense</span> <span class="bar"><span class="fill"></span></span></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
        <div id="df_tooltip"></div>
        </article>
      </section>
    <div class="clear"></div>
    </div>
  <!-- END CONTENT -->

<?php get_footer(); ?>
