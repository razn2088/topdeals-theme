<?php
$footer = get_post_meta(get_the_ID(), '_topdeals_footer', true) ?: [];
$logo_text = !empty($footer['logo_text']) ? $footer['logo_text'] : get_bloginfo('name');
$site_name = !empty($footer['site_name']) ? $footer['site_name'] : get_bloginfo('name');
$disclaimer_1 = !empty($footer['disclaimer_1']) ? $footer['disclaimer_1'] : 'This website has been designed for users to make informed decisions online about products and services.';
$disclaimer_2 = !empty($footer['disclaimer_2']) ? $footer['disclaimer_2'] : 'Our partners provide us with information on prices and offers and these are subject to change without prior notice.';
$disclaimer_3 = !empty($footer['disclaimer_3']) ? $footer['disclaimer_3'] : 'The information we provide is for general information purposes only, and does not constitute legal or any other type of professional advice.';
?>
    <footer>
        <div class="container">
            <p class="footer-logo-txt"><?php echo esc_html($logo_text); ?></p>
            <p class="ftrtxt">COPYRIGHT &copy; <?php echo (date('Y') - 1) . '-' . date('Y'); ?> <?php echo esc_html(strtoupper($site_name)); ?>. ALL RIGHTS RESERVED.<br>
                By using our content, products &amp; services you agree to our Terms of Service and Privacy Policy.
            </p>
            <ul class="nav_footer">
                <li><a class="open-popup-link" href="#terms">Terms of Service</a></li>
                <li><a class="open-popup-link" href="#policy">Privacy Policy</a></li>
                <li><a class="open-popup-link" href="#returns">Contact us</a></li>
            </ul>
            <p class="ftrtxt"><?php echo esc_html($disclaimer_1); ?></p>
            <p class="ftrtxt"><?php echo esc_html($disclaimer_2); ?></p>
            <p class="ftrtxt"><?php echo esc_html($disclaimer_3); ?></p>
        </div>
    </footer>

    <!-- Modal Popup Windows -->
    <div id="terms" class="popup-links-footer mfp-hide">
        <div class="popup-content">
            <h1>Terms &amp; Conditions</h1>
            <?php if (!empty($footer['terms'])) : ?>
                <?php echo wp_kses_post($footer['terms']); ?>
            <?php else : ?>
                <p>Terms and conditions content goes here. Edit this in the page's Footer Settings.</p>
            <?php endif; ?>
        </div>
    </div>
    <div id="policy" class="popup-links-footer mfp-hide">
        <div class="popup-content">
            <h1>Privacy Policy</h1>
            <?php if (!empty($footer['privacy'])) : ?>
                <?php echo wp_kses_post($footer['privacy']); ?>
            <?php else : ?>
                <p>Privacy policy content goes here. Edit this in the page's Footer Settings.</p>
            <?php endif; ?>
        </div>
    </div>
    <div id="returns" class="popup-links-footer mfp-hide">
        <div class="popup-content">
            <h1>Contact Us</h1>
            <?php if (!empty($footer['contact_info'])) : ?>
                <p><?php echo nl2br(esc_html($footer['contact_info'])); ?></p>
            <?php else : ?>
                <p>Contact information goes here. Edit this in the page's Footer Settings.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php wp_footer(); ?>
</body>
</html>
