<?php
/**
 * Plugin Name: fall hafez
 * Plugin URI: https://example.com/
 * Description: نمایش تضادفی فال حافظ
 * Version: 1.1
 * Author: Ali Lashkari
 * Author URI: https://alilashkari.ir/
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit; // دسترسی مستقیم ممنوع
}

// تابع نمایش پست تصادفی
function display_random_single_post($atts) {
    // استخراج دسته‌بندی از شورت‌کد
    $atts = shortcode_atts(
        array(
            'category' => 'فال', // شناسه یا نام دسته‌بندی
        ),
        $atts,
        'random_single_post'
    );

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 1, // فقط یک پست تصادفی
        'orderby' => 'rand', // ترتیب تصادفی
    );

    // اگر دسته‌بندی تنظیم شده باشد، به کوئری اضافه می‌شود
    if (!empty($atts['category'])) {
        $args['category_name'] = $atts['category']; // بر اساس نام دسته‌بندی
    }

    $query = new WP_Query($args);
    $output = '';
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<div class="random-post">';
            $output .= '<h2>' . get_the_title() . '</h2>'; // عنوان پست
            $output .= '<p>' . get_the_content() . '</p>'; // متن پست
            $output .= '</div>';
        }
    } else {
        $output .= '<p>پستی یافت نشد.</p>';
    }
    wp_reset_postdata();
    return $output;
}
add_shortcode('random_single_post', 'display_random_single_post');
