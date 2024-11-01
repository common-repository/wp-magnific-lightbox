<?php
/*
  Plugin Name: WP Magnific Lightbox
  Plugin URI: http://thinkstud.io/wp-magnific-lightbox
  Description: WP Magnific Lightbox is a responsive popup plugin for wordpress.
  Version: 1.0.0
  Author: ThinkStudio
  Author URI: http://thinkstud.io/
  Text Domain: wp_magnific_lightbox
  License: http://www.gnu.org/licenses/gpl-2.0.html
 */
if (!defined('WPINC'))
    die();
if (!class_exists('wp_magnific_lightbox')) {
    class wp_magnific_lightbox {
        public function __construct() {
            add_shortcode('wp_mfc_lightbox', array($this, 'wp_mfc_lightbox_func'));
            add_action('admin_init', array($this, 'mfc_buttons'));
            add_action('wp_enqueue_scripts', array($this, 'wml_scripts'));
            add_action('admin_enqueue_scripts', array($this, 'wml_admin_scripts'));
        }

        public function wp_mfc_lightbox_func($atts) {
            $atts = shortcode_atts(
                    array(
                'type' => 'image',
                'url' => 'http://placehold.it/150x150',
                'google_map' => esc_url('https://maps.google.com/maps?q=think studio bangladesh'),
                'clickable_text' => 'Open Popup',
                    ), $atts, 'wp_mfc_lightbox');
            if ($atts['type'] == 'image') {
                if (!empty($atts['clickable_text'])) {
                    $clickable = $atts['clickable_text'];
                } else {
                    $clickable = '<img style="width:150px;" src="' . $atts['url'] . '" alt="MFC">';
                }
                echo '<a class="mfc_image" href="' . $atts['url'] . '">' . $clickable . '</a>';
            } elseif ($atts['type'] == 'video') {
                if (!empty($atts['clickable_text'])) {
                    $clickable = $atts['clickable_text'];
                } else {
                    $clickable = 'Popup Video';
                }
                echo '<a class="mfc_video" href="' . $atts['url'] . '">' . $clickable . '</a>';
            } elseif ($atts['type'] == 'map') {
                if (!empty($atts['clickable_text'])) {
                    $clickable = $atts['clickable_text'];
                } else {
                    $clickable = 'Popup Google Map';
                }
                if (!empty($atts['google_map'])) {
                    $google_map_url = esc_url('https://maps.google.com/maps?q=' . $atts['google_map']);
                } else {
                    $google_map_url = esc_url('https://maps.google.com/maps?q=think studio bangladesh');
                }
                echo '<a class="mfc_map" href="' . $google_map_url . '">' . $clickable . '</a>';
            }
        }

        public function mfc_buttons() {
            if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
                add_filter('mce_buttons', array($this, 'mfc_buttons_register'));
                add_filter('mce_external_plugins', array($this, 'mfc_mc_scripts'));
            }
        }

        public function mfc_buttons_register($buttons) {
            array_push($buttons, "grid");
            return $buttons;
        }

        public function mfc_mc_scripts($plugin_array) {
            $plugin_array['mfc_scripts'] = plugins_url('js/scripts.js', __FILE__);

            return $plugin_array;
        }

        public function wml_scripts() {                  
            wp_enqueue_script('mfc', plugin_dir_url(__FILE__) . 'js/mfc.js', array('jquery'));            
            wp_enqueue_style('mfc', plugin_dir_url(__FILE__) . 'css/style.css');
        }

        public function wml_admin_scripts() {           
            wp_enqueue_script('mfc_admin', plugin_dir_url(__FILE__) . 'js/admin_script.js', array('jquery'));
        }

    }

}
new wp_magnific_lightbox();