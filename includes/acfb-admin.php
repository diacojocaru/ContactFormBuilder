<?php
add_action('admin_menu', 'acfb_admin_menu');
function acfb_admin_menu() {
    add_menu_page('Form Builder', 'Form Builder', 'manage_options', 'acfb-builder', 'acfb_builder_page');
}

add_action('admin_init', 'acfb_register_settings');
function acfb_register_settings() {
    register_setting('acfb_form_group', 'acfb_form_fields');
    register_setting('acfb_form_group', 'acfb_form_styles');
}

function acfb_builder_page() {
    $fields = get_option('acfb_form_fields', []);
    $styles = get_option('acfb_form_styles', ['font' => 'Arial', 'text_color' => '#000000', 'bg_color' => '#ffffff', 'button_color' => '#0073aa', 'button_text' => 'Send']);

    echo '<div class="wrap"><h1>Form Builder Settings</h1><form method="post" action="options.php">';
    settings_fields('acfb_form_group');

    echo '<h2>Form Fields</h2><table><tr><th>Label</th><th>Type</th><th>Required</th></tr>';
    for ($i = 0; $i < 5; $i++) {
        $label = $fields[$i]['label'] ?? '';
        $type = $fields[$i]['type'] ?? 'text';
        $required = $fields[$i]['required'] ?? false;
        echo '<tr>';
        echo '<td><input name="acfb_form_fields['.$i.'][label]" value="'.esc_attr($label).'" /></td>';
        echo '<td><select name="acfb_form_fields['.$i.'][type]">
                <option value="text" '.selected($type, 'text', false).'>Text</option>
                <option value="email" '.selected($type, 'email', false).'>Email</option>
                <option value="textarea" '.selected($type, 'textarea', false).'>Textarea</option>
              </select></td>';
        echo '<td><input type="checkbox" name="acfb_form_fields['.$i.'][required]" value="1" '.checked($required, true, false).' /></td>';
        echo '</tr>';
    }
    echo '</table>';

    echo '<h2>Styles</h2>';
    echo '<p>Font: <input name="acfb_form_styles[font]" value="'.esc_attr($styles['font']).'" /></p>';
    echo '<p>Text Color: <input type="color" name="acfb_form_styles[text_color]" value="'.esc_attr($styles['text_color']).'" /></p>';
    echo '<p>Background Color: <input type="color" name="acfb_form_styles[bg_color]" value="'.esc_attr($styles['bg_color']).'" /></p>';
    echo '<p>Button Color: <input type="color" name="acfb_form_styles[button_color]" value="'.esc_attr($styles['button_color']).'" /></p>';
    echo '<p>Button Text: <input name="acfb_form_styles[button_text]" value="'.esc_attr($styles['button_text']).'" /></p>';

    submit_button();
    echo '</form></div>';
}
?>