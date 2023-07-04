<?php
/*
Plugin Name: FAQ
Description: A custom plugin to display FAQs using a shortcode.
Version: 1.0
Author: Michael McDonagh
*/

add_shortcode('faq', 'faq_shortcode');

// Shortcode callback function
function faq_shortcode($atts) {
    // Parse the attributes
    $atts = shortcode_atts(array(
        'question1' => '',
        'answer1' => '',
        'question2' => '',
        'answer2' => '',
        'question3' => '',
        'answer3' => '',
        'link' => '',
        'title' => '',
    ), $atts);
    
    // Construct the HTML output
    $output = '<style>' . get_option('faq_css', '') . '</style>';
    $output .= '<div class="faq-wrapper">';
    $output .= '<h3 class="faq-title">FAQ</h3>';
    if (!empty($atts['link']) && !empty($atts['title'])) {
        $output .= '<h4 class="faq-link"><a target="_blank" href="' . esc_url($atts['link']) . '" rel="noopener">' . $atts['title'] . '</a></h4>';
    }
    
    if (!empty($atts['question1']) && !empty($atts['answer1'])) {
        $output .= '<details><summary>' . esc_html($atts['question1']) . '</summary>';
        $output .= '<div class="faq__content">' . esc_html($atts['answer1']) . '</div></details>';
    }
    
    if (!empty($atts['question2']) && !empty($atts['answer2'])) {
        $output .= '<details><summary>' . esc_html($atts['question2']) . '</summary>';
        $output .= '<div class="faq__content">' . esc_html($atts['answer2']) . '</div></details>';
    }
    
    if (!empty($atts['question3']) && !empty($atts['answer3'])) {
        $output .= '<details><summary>' . esc_html($atts['question3']) . '</summary>';
        $output .= '<div class="faq__content">' . esc_html($atts['answer3']) . '</div></details>';
    }
    
    $output .= '</div>';
    
    return $output;
}

// Add submenu page to the Settings menu
add_action('admin_menu', 'faq_submenu_page');
function faq_submenu_page() {
    add_options_page('FAQ Settings', 'FAQ Settings', 'manage_options', 'faq-settings', 'faq_settings_page');
}

// Callback function for the submenu page
function faq_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Save CSS settings if the form is submitted
    if (isset($_POST['faq_css_settings'])) {
        $css = sanitize_textarea_field($_POST['faq_css']);
        update_option('faq_css', $css);
        echo '<div class="notice notice-success"><p>CSS settings saved successfully.</p></div>';
    }
    
    $css = get_option('faq_css', '');
    ?>
    <div class="wrap">
        <h1>FAQ Settings</h1>
        <form method="post" action="">
            <h2>CSS Settings</h2>
            <p>Add custom CSS to style the FAQ section.</p>
            <textarea name="faq_css" rows="8" cols="50"><?php echo esc_textarea($css); ?></textarea>
            <p><input type="submit" class="button button-primary" name="faq_css_settings" value="Save CSS Settings"></p>
        </form>
    </div>
    <?php
}
?>
