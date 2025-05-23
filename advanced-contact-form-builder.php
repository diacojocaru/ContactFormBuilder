<?php
/**
 * Plugin Name: Advanced Contact Form Builder
 * Description: Fully configurable contact form plugin with custom fields and design options.
 * Version: 1.0
 * Author: Diana Cojocaru / developful.ro
 */

if (!defined('ABSPATH')) exit;

// Include admin panel
require_once plugin_dir_path(__FILE__) . 'includes/acfb-admin.php';
// Shortcode rendering
require_once plugin_dir_path(__FILE__) . 'includes/acfb-shortcode.php';
?>
