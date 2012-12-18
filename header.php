<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(' | ', true, 'right'); ?> Info Site</title>
<meta name ="description" content="A collection of information about everything Darkfall Unholy Wars. Your go to spot to find out the latest events, posts, and videos."/>
<meta name="keywords" content="darkfall, aventurine, unholy, wars, information, agon, blog, game, mmo, multiplayer, videos, spells, schools, roles"/>
<meta property="og:title" content="<?php wp_title(' | ', true, 'right'); ?> Info Site"/>
<meta property="og:site_name" content="<?php wp_title(' | ', true, 'right'); ?> Info Site"/>
<meta property="og:type" content="website"/>
<meta property="og:description"
          content="Your go to information database about everything Darkfall Unholy Wars."/>
<meta property="og:image" content="<?php echo get_template_directory_uri();  ?>/images/game.png"/>
<meta property="og:image" content="<?php echo get_template_directory_uri();  ?>/screenshot.png"/>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" />
<link href='http://fonts.googleapis.com/css?family=Smythe|Monda:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
<?php
  $GLOBALS['ver'] = '2.5';
  $ver =  '2.5';
?>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>?ver=<?php echo $ver; ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_floating_style addthis_counter_style" style="left:50px;top:50px;">
<a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
<a class="addthis_button_tweet" tw:count="vertical"></a>
<a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
<a class="addthis_counter"></a>
</div>
<!-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50c58e77607d7916"></script> -->
<!-- AddThis Button END -->
<header>
<div id="branding">
<div id="site-title"><?php if ( is_singular() ) {} else {echo '<h1>';} ?><a href="<?php echo home_url() ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a><?php if ( is_singular() ) {} else {echo '</h1>';} ?></div>
<div id="box-art"><a href="https://ams.darkfallonline.com/AMS/" target="_blank" title="Pre-Order NOW!" alt="Pre-Order NOW!"><img src="<?php echo get_template_directory_uri(); ?>/images/game.png" alt="Darkfall: Unholy Wars Game"/></a></div>
<a href="https://ams.darkfallonline.com/AMS/" target="_blank" class="df-btn" title="Pre-Order NOW!" alt="Pre-Order NOW!">PRE-ORDER NOW</a>
<p id="site-description"><?php bloginfo( 'description' ) ?></p>
</div>
<nav>
<div id="search">
<?php get_search_form(); ?>
</div>
<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
</nav>
</header>
<div id="container">
