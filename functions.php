<?php
/**
 * TopDeals Review Theme - functions.php
 */

// Theme Setup
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
});

// Enqueue Scripts & Styles
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900', [], null);
    wp_enqueue_style('proxima-nova', get_template_directory_uri() . '/assets/fonts/proxima-nova/style.css', [], '1.0');
    wp_enqueue_style('expansiva', get_template_directory_uri() . '/assets/fonts/expansiva/style.css', [], '1.0');
    wp_enqueue_style('bebas-neue', get_template_directory_uri() . '/assets/fonts/bebas-neue-pro/style.css', [], '1.0');
    wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css', [], '1.1.0');
    wp_enqueue_style('topdeals-style', get_stylesheet_uri(), [], '1.0');

    wp_enqueue_script('jquery');
    wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/assets/js/scripts.min.js', ['jquery'], '1.1.0', true);
    wp_enqueue_script('topdeals-custom', get_template_directory_uri() . '/assets/js/custom.js', ['jquery', 'magnific-popup'], '1.0', true);
});

// Register Meta Boxes
add_action('add_meta_boxes', 'topdeals_add_meta_boxes');
function topdeals_add_meta_boxes() {
    add_meta_box('topdeals_hero', 'Hero Section', 'topdeals_hero_metabox', 'page', 'normal', 'high');
    add_meta_box('topdeals_products', 'Products (up to 10)', 'topdeals_products_metabox', 'page', 'normal', 'high');
    add_meta_box('topdeals_featured', 'Featured Product Section', 'topdeals_featured_metabox', 'page', 'normal', 'high');
    add_meta_box('topdeals_footer', 'Footer Settings', 'topdeals_footer_metabox', 'page', 'normal', 'default');
}

// Hero Metabox
function topdeals_hero_metabox($post) {
    wp_nonce_field('topdeals_save', 'topdeals_nonce');
    $hero = get_post_meta($post->ID, '_topdeals_hero', true) ?: [];
    $defaults = [
        'bg_image' => '',
        'heading' => '',
        'subheading' => '',
        'logo_text_1' => '',
        'logo_text_2' => '',
        'logo_text_3' => '',
        'feature_1' => 'Latest Reviews',
        'feature_2' => 'Unique Features',
        'feature_3' => 'Comparisons',
        'feature_4' => 'Costs & More',
    ];
    $hero = wp_parse_args($hero, $defaults);
    ?>
    <table class="form-table">
        <tr><th>Logo Text Part 1</th><td><input type="text" name="hero[logo_text_1]" value="<?php echo esc_attr($hero['logo_text_1']); ?>" class="regular-text" placeholder="BEST"></td></tr>
        <tr><th>Logo Text Part 2 (colored)</th><td><input type="text" name="hero[logo_text_2]" value="<?php echo esc_attr($hero['logo_text_2']); ?>" class="regular-text" placeholder="SWIMMERS"></td></tr>
        <tr><th>Logo Text Part 3</th><td><input type="text" name="hero[logo_text_3]" value="<?php echo esc_attr($hero['logo_text_3']); ?>" class="regular-text" placeholder="CARE"></td></tr>
        <tr><th>Background Image URL</th><td><input type="url" name="hero[bg_image]" value="<?php echo esc_url($hero['bg_image']); ?>" class="large-text" placeholder="https://..."></td></tr>
        <tr><th>Main Heading</th><td><input type="text" name="hero[heading]" value="<?php echo esc_attr($hero['heading']); ?>" class="large-text"></td></tr>
        <tr><th>Subheading</th><td><textarea name="hero[subheading]" class="large-text" rows="3"><?php echo esc_textarea($hero['subheading']); ?></textarea></td></tr>
        <tr><th>Feature 1</th><td><input type="text" name="hero[feature_1]" value="<?php echo esc_attr($hero['feature_1']); ?>" class="regular-text"></td></tr>
        <tr><th>Feature 2</th><td><input type="text" name="hero[feature_2]" value="<?php echo esc_attr($hero['feature_2']); ?>" class="regular-text"></td></tr>
        <tr><th>Feature 3</th><td><input type="text" name="hero[feature_3]" value="<?php echo esc_attr($hero['feature_3']); ?>" class="regular-text"></td></tr>
        <tr><th>Feature 4</th><td><input type="text" name="hero[feature_4]" value="<?php echo esc_attr($hero['feature_4']); ?>" class="regular-text"></td></tr>
    </table>
    <?php
}

// Products Metabox
function topdeals_products_metabox($post) {
    $products = get_post_meta($post->ID, '_topdeals_products', true) ?: [];
    $count = max(count($products), 1);
    ?>
    <div id="topdeals-products-wrapper">
    <?php for ($i = 0; $i < 10; $i++) :
        $p = isset($products[$i]) ? $products[$i] : [];
        $defaults = [
            'name' => '', 'url' => '', 'image' => '', 'rating_num' => '',
            'rating_stars' => '', 'rating_text' => '', 'description' => '',
            'reviews_count' => '', 'badge_text' => '',
            'pros' => '', 'cons' => '',
        ];
        $p = wp_parse_args($p, $defaults);
        $display = ($i < $count) ? '' : 'display:none;';
    ?>
        <div class="topdeals-product-block" style="border:1px solid #ccc; padding:15px; margin:10px 0; background:#f9f9f9; <?php echo $display; ?>">
            <h3>Product #<?php echo $i + 1; ?></h3>
            <table class="form-table">
                <tr><th>Product Name</th><td><input type="text" name="products[<?php echo $i; ?>][name]" value="<?php echo esc_attr($p['name']); ?>" class="large-text"></td></tr>
                <tr><th>Product URL</th><td><input type="url" name="products[<?php echo $i; ?>][url]" value="<?php echo esc_url($p['url']); ?>" class="large-text"></td></tr>
                <tr><th>Product Image URL</th><td><input type="url" name="products[<?php echo $i; ?>][image]" value="<?php echo esc_url($p['image']); ?>" class="large-text"></td></tr>
                <tr><th>Rating Number (e.g. 9.6)</th><td><input type="text" name="products[<?php echo $i; ?>][rating_num]" value="<?php echo esc_attr($p['rating_num']); ?>" class="small-text"></td></tr>
                <tr><th>Star Rating (1-5, e.g. 4.47)</th><td><input type="text" name="products[<?php echo $i; ?>][rating_stars]" value="<?php echo esc_attr($p['rating_stars']); ?>" class="small-text"></td></tr>
                <tr><th>Rating Text (e.g. Outstanding)</th><td><input type="text" name="products[<?php echo $i; ?>][rating_text]" value="<?php echo esc_attr($p['rating_text']); ?>" class="regular-text"></td></tr>
                <tr><th>Reviews Count (e.g. 600)</th><td><input type="text" name="products[<?php echo $i; ?>][reviews_count]" value="<?php echo esc_attr($p['reviews_count']); ?>" class="small-text"></td></tr>
                <tr><th>Badge Text</th><td><input type="text" name="products[<?php echo $i; ?>][badge_text]" value="<?php echo esc_attr($p['badge_text']); ?>" class="regular-text" placeholder="Our Pick for 2024"></td></tr>
                <tr><th>Description</th><td><textarea name="products[<?php echo $i; ?>][description]" class="large-text" rows="4"><?php echo esc_textarea($p['description']); ?></textarea></td></tr>
                <tr><th>Pros (one per line)</th><td><textarea name="products[<?php echo $i; ?>][pros]" class="large-text" rows="4"><?php echo esc_textarea($p['pros']); ?></textarea></td></tr>
                <tr><th>Cons (one per line)</th><td><textarea name="products[<?php echo $i; ?>][cons]" class="large-text" rows="4"><?php echo esc_textarea($p['cons']); ?></textarea></td></tr>
            </table>
        </div>
    <?php endfor; ?>
    </div>
    <button type="button" class="button" onclick="
        var blocks = document.querySelectorAll('.topdeals-product-block');
        for(var i=0; i<blocks.length; i++){
            if(blocks[i].style.display==='none'){blocks[i].style.display=''; break;}
        }
    ">+ Add Product</button>
    <?php
}

// Featured Product Metabox
function topdeals_featured_metabox($post) {
    $feat = get_post_meta($post->ID, '_topdeals_featured', true) ?: [];
    $defaults = [
        'heading' => '',
        'avatar_url' => '',
        'intro_text' => '',
        'product_heading' => '',
        'product_image' => '',
        'product_description' => '',
        'product_url' => '',
    ];
    $feat = wp_parse_args($feat, $defaults);
    ?>
    <table class="form-table">
        <tr><th>Section Heading</th><td><input type="text" name="featured[heading]" value="<?php echo esc_attr($feat['heading']); ?>" class="large-text"></td></tr>
        <tr><th>Avatar Image URL</th><td><input type="url" name="featured[avatar_url]" value="<?php echo esc_url($feat['avatar_url']); ?>" class="large-text"></td></tr>
        <tr><th>Intro Text</th><td><textarea name="featured[intro_text]" class="large-text" rows="4"><?php echo esc_textarea($feat['intro_text']); ?></textarea></td></tr>
        <tr><th>Product Heading</th><td><input type="text" name="featured[product_heading]" value="<?php echo esc_attr($feat['product_heading']); ?>" class="large-text"></td></tr>
        <tr><th>Product Image URL</th><td><input type="url" name="featured[product_image]" value="<?php echo esc_url($feat['product_image']); ?>" class="large-text"></td></tr>
        <tr><th>Product Description</th><td><textarea name="featured[product_description]" class="large-text" rows="6"><?php echo esc_textarea($feat['product_description']); ?></textarea></td></tr>
        <tr><th>Product URL</th><td><input type="url" name="featured[product_url]" value="<?php echo esc_url($feat['product_url']); ?>" class="large-text"></td></tr>
    </table>
    <?php
}

// Footer Metabox
function topdeals_footer_metabox($post) {
    $footer = get_post_meta($post->ID, '_topdeals_footer', true) ?: [];
    $defaults = [
        'logo_text' => '',
        'site_name' => '',
        'terms' => '',
        'privacy' => '',
        'contact_info' => '',
        'disclaimer_1' => '',
        'disclaimer_2' => '',
        'disclaimer_3' => '',
    ];
    $footer = wp_parse_args($footer, $defaults);
    ?>
    <table class="form-table">
        <tr><th>Footer Logo Text</th><td><input type="text" name="footer_data[logo_text]" value="<?php echo esc_attr($footer['logo_text']); ?>" class="regular-text"></td></tr>
        <tr><th>Site Name (copyright)</th><td><input type="text" name="footer_data[site_name]" value="<?php echo esc_attr($footer['site_name']); ?>" class="regular-text"></td></tr>
        <tr><th>Terms & Conditions</th><td><textarea name="footer_data[terms]" class="large-text" rows="8"><?php echo esc_textarea($footer['terms']); ?></textarea></td></tr>
        <tr><th>Privacy Policy</th><td><textarea name="footer_data[privacy]" class="large-text" rows="8"><?php echo esc_textarea($footer['privacy']); ?></textarea></td></tr>
        <tr><th>Contact Info</th><td><textarea name="footer_data[contact_info]" class="large-text" rows="4"><?php echo esc_textarea($footer['contact_info']); ?></textarea></td></tr>
        <tr><th>Disclaimer Line 1</th><td><input type="text" name="footer_data[disclaimer_1]" value="<?php echo esc_attr($footer['disclaimer_1']); ?>" class="large-text"></td></tr>
        <tr><th>Disclaimer Line 2</th><td><input type="text" name="footer_data[disclaimer_2]" value="<?php echo esc_attr($footer['disclaimer_2']); ?>" class="large-text"></td></tr>
        <tr><th>Disclaimer Line 3</th><td><input type="text" name="footer_data[disclaimer_3]" value="<?php echo esc_attr($footer['disclaimer_3']); ?>" class="large-text"></td></tr>
    </table>
    <?php
}

// Save Meta Boxes
add_action('save_post', function ($post_id) {
    if (!isset($_POST['topdeals_nonce']) || !wp_verify_nonce($_POST['topdeals_nonce'], 'topdeals_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['hero'])) {
        update_post_meta($post_id, '_topdeals_hero', array_map('sanitize_text_field', $_POST['hero']));
    }
    if (isset($_POST['products'])) {
        $products = [];
        foreach ($_POST['products'] as $p) {
            if (!empty($p['name'])) {
                $products[] = [
                    'name' => sanitize_text_field($p['name']),
                    'url' => esc_url_raw($p['url']),
                    'image' => esc_url_raw($p['image']),
                    'rating_num' => sanitize_text_field($p['rating_num']),
                    'rating_stars' => sanitize_text_field($p['rating_stars']),
                    'rating_text' => sanitize_text_field($p['rating_text']),
                    'reviews_count' => sanitize_text_field($p['reviews_count']),
                    'badge_text' => sanitize_text_field($p['badge_text']),
                    'description' => sanitize_textarea_field($p['description']),
                    'pros' => sanitize_textarea_field($p['pros']),
                    'cons' => sanitize_textarea_field($p['cons']),
                ];
            }
        }
        update_post_meta($post_id, '_topdeals_products', $products);
    }
    if (isset($_POST['featured'])) {
        $feat = $_POST['featured'];
        update_post_meta($post_id, '_topdeals_featured', [
            'heading' => sanitize_text_field($feat['heading']),
            'avatar_url' => esc_url_raw($feat['avatar_url']),
            'intro_text' => sanitize_textarea_field($feat['intro_text']),
            'product_heading' => sanitize_text_field($feat['product_heading']),
            'product_image' => esc_url_raw($feat['product_image']),
            'product_description' => sanitize_textarea_field($feat['product_description']),
            'product_url' => esc_url_raw($feat['product_url']),
        ]);
    }
    if (isset($_POST['footer_data'])) {
        $f = $_POST['footer_data'];
        update_post_meta($post_id, '_topdeals_footer', [
            'logo_text' => sanitize_text_field($f['logo_text']),
            'site_name' => sanitize_text_field($f['site_name']),
            'terms' => wp_kses_post($f['terms']),
            'privacy' => wp_kses_post($f['privacy']),
            'contact_info' => sanitize_textarea_field($f['contact_info']),
            'disclaimer_1' => sanitize_text_field($f['disclaimer_1']),
            'disclaimer_2' => sanitize_text_field($f['disclaimer_2']),
            'disclaimer_3' => sanitize_text_field($f['disclaimer_3']),
        ]);
    }
});

// Output inline CSS fixes to match original HTML exactly (wp_footer to load AFTER stylesheets)
add_action('wp_footer', function() {
    $tdir = get_template_directory_uri();
    ?>
    <style>
    /* Hero icons */
    ul.s1list li img{width:24px!important;height:25px!important;vertical-align:middle!important;margin-right:5px!important}
    .s1txt2>img{width:24px!important;height:28px!important;vertical-align:middle!important}
    ul.s1list li{float:left!important;display:inline-block!important;padding:0 0 0 14px!important;margin:0 14px 0 0!important;font-size:20px!important;color:#fff!important;list-style:none!important;background:none!important}
    ul.s1list li:first-child{padding-left:0!important}
    ul.s1list li:nth-child(2),ul.s1list li:nth-child(3),ul.s1list li:nth-child(4){border-left:1px solid rgba(255,255,255,.4)!important}
    /* Disclosure bar - grey rectangle background */
    .s1txt2{color:#fff!important;background:rgba(180,190,195,.55)!important;padding:12px 15px 12px 50px!important;margin:30px 0 0 0!important;position:relative!important;display:inline-block!important}
    .s1txt2 .span1{color:#fff!important;font-weight:400!important}
    .s1txt2 .span2{color:rgba(255,255,255,.7)!important;font-size:16px!important;text-decoration:underline!important}
    .s1txt2 .s1txt2__right{color:#fff!important}
    /* Product box buttons */
    .s2bx1-inbx1 .btn1{height:50px!important;width:190px!important;max-width:190px!important;background:rgb(110,151,155)!important;border-radius:10px!important;font-size:16px!important;color:#fff!important;text-align:center!important;line-height:50px!important;display:flex!important;align-items:center!important;justify-content:center!important;gap:8px!important;text-decoration:none!important;padding:0 15px!important;margin:0!important}
    .s2bx1-inbx1 .btn1 .btn-text{font-weight:700!important;font-size:16px!important;line-height:1!important}
    .s2bx1-inbx1 .btn1 .amazon-logo{height:20px!important;filter:brightness(0) invert(1)!important;vertical-align:baseline!important;margin-top:2px!important}
    .s2bx1-inbx1 .btn1:hover{background:rgb(90,131,135)!important;color:#fff!important}
    .s2bx1-inbx1 .btn1 img[alt="chevron icon"]{width:10px!important;height:16px!important;vertical-align:middle!important}
    /* Featured button */
    .s-productsUp .btn1.btn1mod{width:210px!important;max-width:210px!important;height:50px!important;background:rgb(110,151,155)!important;border-radius:10px!important;font-size:16px!important;line-height:50px!important;padding:0 15px!important;margin:39px 0 0 14px!important;color:#fff!important;text-decoration:none!important;display:flex!important;align-items:center!important;justify-content:center!important;gap:8px!important}
    .s-productsUp .btn1.btn1mod .btn-text{font-weight:700!important;font-size:16px!important;line-height:1!important}
    .s-productsUp .btn1.btn1mod .amazon-logo{height:20px!important;filter:brightness(0) invert(1)!important;vertical-align:baseline!important;margin-top:2px!important}
    /* Rating */
    .intRate{color:rgb(85,155,214)!important;font-size:60px!important;font-weight:300!important;display:block!important;text-align:center!important;line-height:1.1!important}
    .textRate{color:rgb(85,155,214)!important;font-size:20px!important;display:block!important;text-align:center!important}
    .inbx-ratshop{display:flex!important;flex-direction:column!important;justify-content:center!important;align-items:center!important;position:relative!important;top:60px!important}
    .inbx-midRight{margin:0 0 30px 0!important;display:flex!important;flex-direction:column!important;align-items:center!important;width:100%!important}
    /* Product title */
    .inbx-midhding{border:none!important;padding:0 0 0 67px!important;margin-bottom:20px!important;font-size:20px!important}
    .inbx-midhding a{color:#02172c!important;text-decoration:none!important}
    .indx-midsbhding p{color:#02172c!important;padding:0 0 0 15px!important}
    /* Ribbon #1 */
    .ribbon{background:rgb(85,155,214)!important;height:40px!important;width:230px!important}
    .ribbon a{color:#fff!important;text-decoration:none!important;font-weight:400!important;font-size:16px!important}
    .ribbon span{font-weight:700!important}
    .ribbon:after{border:20px solid rgb(85,155,214)!important;border-right-color:white!important;border-right-width:12px!important}
    /* Number badges #2-5 grey flag */
    .box-nr-2{background:#6b6b6b!important;color:#fff!important;width:62px!important;height:34px!important;font-size:17px!important;font-weight:700!important;line-height:34px!important;text-align:center!important;display:inline-block!important;position:relative!important}
    .box-nr-2:after{content:''!important;border:17px solid #6b6b6b!important;border-right-color:transparent!important;border-right-width:10px!important;position:absolute!important;top:0!important;right:-10px!important}
    .box-nr-2 a{color:#fff!important;text-decoration:none!important;font-weight:700!important}
    /* Left column - centered */
    .inbx-lft{text-align:center!important}
    .inbx-logo1{max-width:200px!important;max-height:250px!important;margin:30px auto 10px auto!important;display:block!important}
    /* Stars bigger, centered */
    .inbx-lft .rating{display:block!important;text-align:center!important;margin:10px 0 5px 0!important}
    .inbx-lft .stars{font-size:30px!important}
    .inbx-lft .rating>span{font-size:30px!important}
    .inbx-lfttxt{text-align:center!important;font-size:16px!important;line-height:22px!important;color:#4b4b4b!important;padding:5px 0 0 0!important}
    .inbx-lfttxt span{font-weight:500!important;font-size:18px!important}
    .inbx-lfttxt a{color:rgb(85,155,214)!important;text-decoration:none!important}
    /* Header */
    .headbox .logo-title{color:rgb(93,93,93)!important;text-decoration:none!important}
    .hdrtxt{font-size:14px!important;text-transform:uppercase!important}
    .hdrtxt a{color:#414141!important;text-decoration:none!important}
    /* Hero heading */
    .section1 .s1hding{font-size:37px!important;border:none!important;margin:0!important;padding:0!important;color:#fff!important}
    /* Pros/Cons */
    .inbx-proscons{display:flex!important;justify-content:space-around!important;margin-top:55px!important}
    .inbx-proscons .inbx-midlist{padding:12px 0 0 67px!important}
    .inbx-proscons .inbx-midlist p{color:#4b4b4b!important;font-weight:700!important}
    .inbx-proscons .inbx-midlist li{font-size:16px!important;color:#4b4b4b!important;padding:0 0 0 24px!important;margin:4px 0 0 0!important;list-style:none!important;background:none!important}
    /* Featured */
    .s-productsUp .ourTop h2{border-top:0!important;text-align:center!important;color:#02172c!important}
    .s-productsUp .ourTop .ourTop__desc{display:flex!important;align-items:flex-start!important;gap:20px!important}
    .s-productsUp .ourTop .ourTop__desc img{border-radius:50%!important;width:130px!important;height:130px!important;object-fit:cover!important;flex-shrink:0!important}
    .s-productsUp .ourTop p{font-size:19px!important;line-height:1.4!important;color:#02172c!important}
    .s-productsUp .product-1 h2{color:#fff!important;background-color:#5d5d5d!important;padding:24px 0 24px 21px!important;border:none!important;letter-spacing:1px!important;margin:22px 0!important}
    .s-productsUp .product-1 .right-col p{color:#02172c!important;font-size:16px!important;line-height:1.6!important}
    /* Stars */
    .rating>span{color:#ffd203!important}
    .rating>span.no-rate{color:#fbea9e!important}
    /* Footer */
    .footer-logo-txt{color:rgb(220,220,220)!important;text-align:center!important}
    .ftrtxt{color:#575757!important}
    /* Remove WP defaults */
    ul.s1list,ul.inbx-midlist,ul.nav_footer{list-style:none!important;padding-left:0!important}
    ul.s1list li,ul.inbx-midlist li,ul.nav_footer li{background-image:none!important;list-style:none!important}
    .inbx-midRight-mb{display:none!important}
    @media(max-width:767px){
        .inbx-midRight-mb{display:flex!important;flex-direction:column!important;align-items:center!important;margin-top:25px!important}
        .inbx-midRight{display:none!important}
        .inbx-ratshop{top:0!important}
        .s2bx1-inbx1 .btn1{width:150px!important;max-width:150px!important;margin-top:40px!important}
    }
    </style>
    <?php
}, 999);
