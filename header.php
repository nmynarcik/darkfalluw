<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(' | ', true, 'right'); ?> Info Site</title>
<meta name ="description" content="A collection of information about everything Darkfall Unholy Wars. Your go to spot to find out the latest events, posts, and videos."/>
<meta name="keywords" content="darkfall, aventurine, unholy, wars, information, agon, blog, game, mmo, multiplayer, videos, spells, schools, roles"/>
<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/share-image.png">
<meta property="og:title" content="<?php wp_title(' | ', true, 'right'); ?> Info Site"/>
<meta property="og:site_name" content="<?php wp_title(' | ', true, 'right'); ?> Info Site"/>
<meta property="og:type" content="website"/>
<meta property="og:description"
          content="Your go to information database about everything Darkfall Unholy Wars."/>
<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@DFUWInfo">
<meta name="twitter:creator" content="@DFUWInfo">
<meta name="twitter:description" content="Your go to information database about everything Darkfall Unholy Wars.">
<?php if(is_home()) { ?>
<meta name="twitter:title" content="Darkfall: Unholy Wars">
<?php } else { ?>
<meta name="twitter:title" content="<?php echo strip_tags($wp_query->post->post_title); ?>">
<?php } ?>
<meta name="twitter:image:src" content="http://www.darkfallunholywars.info/wp-content/themes/darkfalluw/images/share-image.png">
<meta name="twitter:domain" content="darkfallunholywars.info">
<!-- End Twitter Card -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" />
<link href='http://fonts.googleapis.com/css?family=Smythe|Oswald:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
<?php wp_enqueue_script("jquery"); ?>
<?php
  $GLOBALS['ver'] = '4.42';
  $ver =  '4.42';
?>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>?ver=<?php echo $ver; ?>" />
<?php wp_head(); ?>
<script type="text/javascript">
  var templateDir = "<?php bloginfo('template_directory') ?>";
</script>
<meta name="google-translate-customization" content="b8c2eefcc5a845dd-390b510496c46f40-gd41aa60898e3037c-1b"></meta>
</head>
<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
<!-- AddThis Button BEGIN -->
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50c7c23c30c44565"></script>
<!-- AddThis Button END -->
<header>
  <div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, gaTrack: true, gaId: 'UA-19670756-11'}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<div id="branding">
<div id="site-title"><?php if ( is_singular() ) {} else {echo '<h1>';} ?><a href="<?php echo home_url() ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a><?php if ( is_singular() ) {} else {echo '</h1>';} ?></div>
<div id="box-art"><a href="https://ams.darkfallonline.com/AMS/" target="_blank" title="BUY NOW!" alt="BUY NOW!"><img src="<?php echo get_template_directory_uri(); ?>/images/game.png" alt="Darkfall: Unholy Wars Game"/></a></div>
<a href="https://ams.darkfallonline.com/AMS/?ref=<?php echo home_url() ?>" target="_blank" class="df-btn" title="BUY NOW!" alt="BUY NOW!">BUY NOW</a>
<p id="site-description"><?php bloginfo( 'description' ) ?></p>
<a href="https://twitter.com/dfuwinfo" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @DFUWInfo</a>
<div id="server-status">
  <h2>Server Status:</h2>
  <span class="us1">NA<i class="icon"></i></span>
  <span class="eu1">EU<i class="icon"></i></span>
</div>
</div>
<nav>
<div id="search">
<?php get_search_form(); ?>
</div>
<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
</nav>
</header>
<div id="container">
