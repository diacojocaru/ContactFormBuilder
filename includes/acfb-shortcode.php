<?php
add_shortcode('acf_contact_form', 'acfb_render_form');

function acfb_render_form() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'acfb_submissions';

    // Create table if not exists
    $wpdb->query("CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        data longtext NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (id)
    )");

    $fields = get_option('acfb_form_fields', []);
    $styles = get_option('acfb_form_styles', ['font' => 'Arial', 'text_color' => '#000000', 'bg_color' => '#ffffff', 'button_color' => '#0073aa', 'button_text' => 'Send']);

    $submitted = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acf_contact_form_submit'])) {
        $entry = [];
        foreach ($fields as $field) {
            if (empty($field['label'])) continue;
            $name = sanitize_title($field['label']);
            $entry[$name] = sanitize_text_field($_POST[$name] ?? '');
        }
        $wpdb->insert($table_name, ['data' => maybe_serialize($entry)]);
        $submitted = true;
    }

    $output = '<form method="post" style="font-family:'.$styles['font'].';color:'.$styles['text_color'].';background:'.$styles['bg_color'].';padding:20px;border-radius:10px;">';

    if ($submitted) {
        $output .= '<div style="background:#d4edda;color:#155724;padding:10px;border-radius:5px;margin-bottom:15px;">Message received. Thank you!</div>';
    }

    foreach ($fields as $field) {
        if (empty($field['label'])) continue;
        $required = !empty($field['required']) ? 'required' : '';
        $output .= '<p><label>'.$field['label'].'</label><br/>';
        if ($field['type'] == 'textarea') {
            $output .= '<textarea name="'.sanitize_title($field['label']).'" '.$required.'></textarea></p>';
        } else {
            $output .= '<input type="'.$field['type'].'" name="'.sanitize_title($field['label']).'" '.$required.'></p>';
        }
    }

    $output .= '<p><button type="submit" name="acf_contact_form_submit" style="background:'.$styles['button_color'].';color:#fff;padding:10px 20px;border:none;border-radius:5px;">'.$styles['button_text'].'</button></p>';
    $output .= '</form>';

    return $output;
}
?>