<?php
/**
 * Template Name: Product Review Page
 * Description: Full product review landing page with hero, product list, and featured product.
 */
get_header();

$hero = get_post_meta(get_the_ID(), '_topdeals_hero', true) ?: [];
$products = get_post_meta(get_the_ID(), '_topdeals_products', true) ?: [];
$featured = get_post_meta(get_the_ID(), '_topdeals_featured', true) ?: [];

$bg_image = !empty($hero['bg_image']) ? $hero['bg_image'] : '';
$heading = !empty($hero['heading']) ? $hero['heading'] : 'BEST PRODUCTS';
$subheading = !empty($hero['subheading']) ? $hero['subheading'] : '';
$feature_1 = !empty($hero['feature_1']) ? $hero['feature_1'] : 'Latest Reviews';
$feature_2 = !empty($hero['feature_2']) ? $hero['feature_2'] : 'Unique Features';
$feature_3 = !empty($hero['feature_3']) ? $hero['feature_3'] : 'Comparisons';
$feature_4 = !empty($hero['feature_4']) ? $hero['feature_4'] : 'Costs & More';
$theme_uri = get_template_directory_uri();
?>

    <!-- Hero Section -->
    <div class="section1 dsplay" style="background-image:url(<?php echo esc_url($bg_image); ?>)">
        <div class="container position">
            <p class="s1hding"><?php echo esc_html($heading); ?></p>
            <p class="s1txt">
                <p class="ourTeam"><?php echo esc_html($subheading); ?></p>
            </p>
            <ul class="s1list" style="margin-top: 5px;">
                <li><span><img src="<?php echo $theme_uri; ?>/assets/img/thumbsup-icon.png"></span> <?php echo esc_html($feature_1); ?></li>
                <li><span><img src="<?php echo $theme_uri; ?>/assets/img/light-icon.png"></span> <?php echo esc_html($feature_2); ?></li>
                <li><span><img src="<?php echo $theme_uri; ?>/assets/img/graph-icon.png"></span> <?php echo esc_html($feature_3); ?></li>
                <li><span><img src="<?php echo $theme_uri; ?>/assets/img/percent-icon.png"></span><?php echo esc_html($feature_4); ?></li>
            </ul>
            <div class="clearall"></div>
            <p class="s1txt2">
                <img src="<?php echo $theme_uri; ?>/assets/img/clock-icon.png">
                <span class="s1txt2__right">
                    <span class="span1">Latest update:</span>
                    <script type="text/javascript">document.write(getDate(0));</script><br>
                    <span class="span2" id="disclosure">Advertiser Disclosure</span>
                </span>
            </p>
        </div>
    </div>

    <!-- Products Section -->
    <?php if (!empty($products)) : ?>
    <div class="section2 dsplay">
        <div class="container">
            <div class="sec2-box1 dsplay">
                <?php foreach ($products as $i => $product) :
                    $num = $i + 1;
                    $box_class = 'box-' . $num;
                    $is_first = ($i === 0);
                ?>
                <div class="s2bx1-inbx1 dsplay <?php echo $box_class; ?>">
                    <div class="box-top">
                        <div class="one-box">
                            <?php if ($is_first && !empty($product['badge_text'])) : ?>
                            <div class="one box-nr-1 ribbon">
                                <a href="<?php echo esc_url($product['url']); ?>" target="_blank" style="color:inherit;"><span>#<?php echo $num; ?></span> <?php echo esc_html($product['badge_text']); ?></a>
                            </div>
                            <?php else : ?>
                            <div class="one box-nr-2">
                                <a href="<?php echo esc_url($product['url']); ?>" target="_blank" style="color:inherit;">#<?php echo $num; ?></a>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="inbx-lft">
                            <a href="<?php echo esc_url($product['url']); ?>" target="_blank" style="color:inherit;">
                                <img src="<?php echo esc_url($product['image']); ?>" class="inbx-logo1">
                            </a>
                            <?php if (!empty($product['rating_stars'])) : ?>
                            <a href="<?php echo esc_url($product['url']); ?>" class="rating">
                                <div class="stars" style="--rating: <?php echo esc_attr($product['rating_stars']); ?>;" aria-label="Rating of this product is <?php echo esc_attr($product['rating_stars']); ?> out of 5."></div>
                            </a>
                            <?php endif; ?>
                            <p class="inbx-lfttxt">
                                <span><a href="<?php echo esc_url($product['url']); ?>" target="_blank" style="color:inherit;">Read Full Review</a></span><br>
                                <?php if (!empty($product['reviews_count'])) : ?>
                                <a href="<?php echo esc_url($product['url']); ?>" target="_blank" style="color:inherit;"><?php echo esc_html($product['reviews_count']); ?> Reviews</a>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="inbx-midRight-mb">
                            <span class="intRate"><?php echo esc_html($product['rating_num']); ?></span>
                            <span class="textRate"><?php echo esc_html($product['rating_text']); ?></span>
                        </div>
                        <div class="inbx-mid">
                            <p class="inbx-midhding"><a href="<?php echo esc_url($product['url']); ?>" target="_blank" style="color:inherit;"><?php echo esc_html($product['name']); ?></a></p>
                            <div class="indx-midsbhding">
                                <p><?php echo nl2br(esc_html($product['description'])); ?></p>
                            </div>
                            <?php
                            $pros = !empty($product['pros']) ? array_filter(explode("\n", $product['pros'])) : [];
                            $cons = !empty($product['cons']) ? array_filter(explode("\n", $product['cons'])) : [];
                            if (!empty($pros) || !empty($cons)) :
                            ?>
                            <div class="inbx-proscons">
                                <?php if (!empty($pros)) : ?>
                                <ul class="inbx-midlist">
                                    <p>PROS:</p>
                                    <?php foreach ($pros as $pro) : ?>
                                    <li><?php echo esc_html(trim($pro)); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
                                <?php if (!empty($cons)) : ?>
                                <ul class="inbx-midlist">
                                    <p>CONS:</p>
                                    <?php foreach ($cons as $con) : ?>
                                    <li><?php echo esc_html(trim($con)); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="inbx-ratshop">
                            <div class="inbx-midRight">
                                <span class="intRate"><?php echo esc_html($product['rating_num']); ?></span>
                                <span class="textRate"><?php echo esc_html($product['rating_text']); ?></span>
                            </div>
                            <div class="inbx-rgt">
                                <a href="<?php echo esc_url($product['url']); ?>" target="_blank" class="btn1"><b>Shop Now</b></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Featured Product Section -->
            <?php if (!empty($featured['heading'])) : ?>
            <section class="s-productsUp">
                <div class="ourTop">
                    <h2 align="center" style="border-top: 0!important;"><?php echo esc_html($featured['heading']); ?></h2>
                    <div class="ourTop__desc">
                        <?php if (!empty($featured['avatar_url'])) : ?>
                        <img src="<?php echo esc_url($featured['avatar_url']); ?>">
                        <?php endif; ?>
                        <?php if (!empty($featured['intro_text'])) : ?>
                        <p><?php echo nl2br(esc_html($featured['intro_text'])); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (!empty($featured['product_heading'])) : ?>
                <article class="product-1">
                    <h2><?php echo esc_html($featured['product_heading']); ?></h2>
                    <div class="row-block">
                        <?php if (!empty($featured['product_image'])) : ?>
                        <div class="left-col">
                            <img class="left-col__img" src="<?php echo esc_url($featured['product_image']); ?>">
                        </div>
                        <?php endif; ?>
                        <div class="right-col">
                            <p><?php echo nl2br(esc_html($featured['product_description'])); ?></p>
                            <?php if (!empty($featured['product_url'])) : ?>
                            <a href="<?php echo esc_url($featured['product_url']); ?>" class="btn1 btn1mod" target="_blank"><b>Shop Now</b></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endif; ?>
            </section>
            <?php endif; ?>

            <!-- Best Overall Section -->
            <?php
            $best_overall = get_post_meta(get_the_ID(), '_topdeals_best_overall', true) ?: [];
            $bo_heading = !empty($best_overall['heading']) ? $best_overall['heading'] : '';
            $bo_bullets = !empty($best_overall['bullets']) ? array_filter(explode("\n", $best_overall['bullets'])) : [];
            if (!empty($bo_heading) && !empty($products[0])) :
                $bp = $products[0]; // Use first product data
            ?>
            <h2 class="s2sub-hding"><?php echo esc_html($bo_heading); ?></h2>
            <div class="sec2-box1 dsplay">
                <div class="s2bx1-inbx1 dsplay box-1">
                    <div class="box-top">
                        <div class="one-box">
                            <div class="one box-nr-1 ribbon">
                                <a href="<?php echo esc_url($bp['url']); ?>" target="_blank" style="color:inherit;"><span>#1</span> <?php echo esc_html(!empty($bp['badge_text']) ? $bp['badge_text'] : 'Our Pick'); ?></a>
                            </div>
                        </div>
                        <div class="inbx-lft">
                            <a href="<?php echo esc_url($bp['url']); ?>" target="_blank" style="color:inherit;">
                                <img src="<?php echo esc_url($bp['image']); ?>" class="inbx-logo1">
                            </a>
                            <?php if (!empty($bp['rating_stars'])) : ?>
                            <a href="<?php echo esc_url($bp['url']); ?>" class="rating">
                                <div class="stars" style="--rating: <?php echo esc_attr($bp['rating_stars']); ?>;" aria-label="Rating of this product is <?php echo esc_attr($bp['rating_stars']); ?> out of 5."></div>
                            </a>
                            <?php endif; ?>
                            <p class="inbx-lfttxt">
                                <span><a href="<?php echo esc_url($bp['url']); ?>" target="_blank" style="color:inherit;">Read Full Review</a></span><br>
                                <?php if (!empty($bp['reviews_count'])) : ?>
                                <a href="<?php echo esc_url($bp['url']); ?>" target="_blank" style="color:inherit;"><?php echo esc_html($bp['reviews_count']); ?> Reviews</a>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="inbx-midRight-mb">
                            <span class="intRate"><?php echo esc_html($bp['rating_num']); ?></span>
                            <span class="textRate"><?php echo esc_html($bp['rating_text']); ?></span>
                        </div>
                        <div class="inbx-mid">
                            <p class="inbx-midhding"><a href="<?php echo esc_url($bp['url']); ?>" target="_blank" style="color:inherit;"><?php echo esc_html($bp['name']); ?></a></p>
                            <div class="indx-midsbhding">
                                <?php if (!empty($bo_bullets)) : ?>
                                <ul class="best-overall-list">
                                    <?php foreach ($bo_bullets as $bullet) : ?>
                                    <li><?php echo esc_html(trim($bullet)); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="inbx-ratshop">
                            <div class="inbx-midRight">
                                <span class="intRate"><?php echo esc_html($bp['rating_num']); ?></span>
                                <span class="textRate"><?php echo esc_html($bp['rating_text']); ?></span>
                            </div>
                            <div class="inbx-rgt">
                                <a href="<?php echo esc_url($bp['url']); ?>" target="_blank" class="btn1"><b>Shop Now</b></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <?php endif; ?>

<?php get_footer(); ?>
