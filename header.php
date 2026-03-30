<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <script>
    function getDate(days) {
        var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var now = new Date();
        now.setDate(now.getDate() + days);
        return monthNames[now.getMonth()] + " " + now.getDate() + ", " + now.getFullYear();
    }
    </script>
</head>
<body <?php body_class(); ?>>
<?php
$hero = get_post_meta(get_the_ID(), '_topdeals_hero', true) ?: [];
$logo1 = !empty($hero['logo_text_1']) ? $hero['logo_text_1'] : 'BEST';
$logo2 = !empty($hero['logo_text_2']) ? $hero['logo_text_2'] : 'DEAL';
$logo3 = !empty($hero['logo_text_3']) ? $hero['logo_text_3'] : 'SITE';
?>
    <div id="pop_overlay" style="display:none;">
        <div id="pop_content">
            <div class="pop-inner">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/cross-x-icon.png" alt="Close" class="close">
                <p class="pop_title">How We Rank</p>
                <p class="poptxt">We receive compensation from the companies promoted and ranked on our site; not all companies in the marketplace are represented. Product rankings are flexible and subject to change based on compensation, number of page visits, and other factors.</p>
            </div>
            <div class="clearall"></div>
        </div>
    </div>
    <div id="pop_overlay2" style="display:none;">
        <div id="pop_content2">
            <div class="pop-inner">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/cross-x-icon.png" alt="Close" class="close">
                <p class="pop_title">Advertising Disclaimer</p>
                <p class="poptxt">Disclaimer: We are independently owned and operated. All opinions and rankings on this site are our own. Our free online comparison tool is funded by referral fees from the companies we review.</p>
            </div>
            <div class="clearall"></div>
        </div>
    </div>
    <div class="header">
        <div class="container headwrapper">
            <div class="headbox">
                <a href="<?php echo home_url(); ?>" class="logo-title"><?php echo esc_html($logo1); ?><span class="logo-title__color"><?php echo esc_html($logo2); ?></span><?php echo esc_html($logo3); ?></a>
            </div>
            <div class="headbox">
                <p class="hdrtxt"><a href="#">Advertorial</a></p>
                <p class="hdrtxt"><a href="#" id="rank">How We Rank</a></p>
            </div>
        </div>
    </div>
