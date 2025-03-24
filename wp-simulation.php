<?php
/**
 * WordPress Simulation Environment
 * 
 * This file simulates WordPress functions and classes so we can test
 * a WordPress plugin without a full WordPress installation.
 */

// Define ABSPATH to simulate WordPress environment
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

// WordPress error class simulation
class WP_Error {
    public $errors = array();
    public $error_data = array();
    
    public function __construct($code = '', $message = '', $data = '') {
        if (empty($code)) {
            return;
        }
        
        $this->errors[$code][] = $message;
        
        if (!empty($data)) {
            $this->error_data[$code] = $data;
        }
    }
    
    public function get_error_message($code = '') {
        if (empty($code)) {
            $code = $this->get_error_code();
        }
        
        if (isset($this->errors[$code]) && is_array($this->errors[$code])) {
            return $this->errors[$code][0];
        }
        
        return '';
    }
    
    public function get_error_code() {
        $codes = array_keys($this->errors);
        if (empty($codes)) {
            return '';
        }
        
        return $codes[0];
    }
}

// WordPress options API simulation
$wp_options = array();

function add_option($option, $value = '', $deprecated = '', $autoload = 'yes') {
    global $wp_options;
    
    if (isset($wp_options[$option])) {
        return false;
    }
    
    $wp_options[$option] = $value;
    return true;
}

function update_option($option, $value, $autoload = null) {
    global $wp_options;
    
    $wp_options[$option] = $value;
    return true;
}

function get_option($option, $default = false) {
    global $wp_options;
    
    if (isset($wp_options[$option])) {
        return $wp_options[$option];
    }
    
    return $default;
}

// WordPress plugin path functions simulation
function plugin_dir_path($file) {
    return dirname($file) . '/';
}

function plugin_dir_url($file) {
    return 'http://example.com/wp-content/plugins/' . basename(dirname($file)) . '/';
}

function plugin_basename($file) {
    return basename(dirname($file)) . '/' . basename($file);
}

// WordPress internationalization functions simulation
function __($text, $domain = 'default') {
    return $text;
}

function load_plugin_textdomain($domain, $deprecated = false, $plugin_rel_path = false) {
    // Simulation, does nothing
    return true;
}

// WordPress hooks system simulation
$wp_filters = array();
$wp_actions = array();
$wp_current_filter = array();

function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
    return add_filter($tag, $function_to_add, $priority, $accepted_args);
}

function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
    global $wp_filters;
    
    if (!isset($wp_filters[$tag])) {
        $wp_filters[$tag] = array();
    }
    
    if (!isset($wp_filters[$tag][$priority])) {
        $wp_filters[$tag][$priority] = array();
    }
    
    $wp_filters[$tag][$priority][] = array(
        'function' => $function_to_add,
        'accepted_args' => $accepted_args
    );
    
    return true;
}

function apply_filters($tag, $value) {
    global $wp_filters, $wp_current_filter;
    
    $args = func_get_args();
    
    $wp_current_filter[] = $tag;
    
    if (!isset($wp_filters[$tag])) {
        return $value;
    }
    
    foreach ($wp_filters[$tag] as $priority => $functions) {
        if (!is_array($functions)) {
            continue;
        }
        
        foreach ($functions as $function) {
            if (!is_callable($function['function'])) {
                continue;
            }
            
            $args_to_pass = array_slice($args, 1, $function['accepted_args']);
            $value = call_user_func_array($function['function'], $args_to_pass);
        }
    }
    
    array_pop($wp_current_filter);
    
    return $value;
}

function do_action($tag, $arg = '') {
    global $wp_filters, $wp_actions, $wp_current_filter;
    
    if (!isset($wp_actions[$tag])) {
        $wp_actions[$tag] = 1;
    } else {
        ++$wp_actions[$tag];
    }
    
    $wp_current_filter[] = $tag;
    
    $args = array();
    if (is_array($arg) && 1 === count($arg) && isset($arg[0]) && is_object($arg[0])) {
        $args[] = $arg[0];
    } else {
        $args[] = $arg;
    }
    
    for ($a = 2; $a < func_num_args(); $a++) {
        $args[] = func_get_arg($a);
    }
    
    if (!isset($wp_filters[$tag])) {
        array_pop($wp_current_filter);
        return;
    }
    
    foreach ($wp_filters[$tag] as $priority => $functions) {
        if (!is_array($functions)) {
            continue;
        }
        
        foreach ($functions as $function) {
            if (!is_callable($function['function'])) {
                continue;
            }
            
            call_user_func_array($function['function'], array_slice($args, 0, $function['accepted_args']));
        }
    }
    
    array_pop($wp_current_filter);
}

// WordPress widget class simulation
class WP_Widget {
    public $id_base;
    public $name;
    public $widget_options;
    public $control_options;
    
    public function __construct($id_base, $name, $widget_options = array(), $control_options = array()) {
        $this->id_base = $id_base;
        $this->name = $name;
        $this->widget_options = $widget_options;
        $this->control_options = $control_options;
    }
    
    public function widget($args, $instance) {
        // To be overridden
    }
    
    public function form($instance) {
        // To be overridden
    }
    
    public function update($new_instance, $old_instance) {
        // To be overridden
        return $new_instance;
    }
}

// WordPress shortcode API simulation
$wp_shortcodes = array();

function add_shortcode($tag, $func) {
    global $wp_shortcodes;
    
    if ('' === trim($tag)) {
        return;
    }
    
    $wp_shortcodes[$tag] = $func;
}

function do_shortcode($content) {
    global $wp_shortcodes;
    
    // If no shortcodes registered, just return the content
    if (empty($wp_shortcodes)) {
        return $content;
    }
    
    // Basic regex pattern to find shortcodes
    $pattern = get_shortcode_regex();
    
    // Return content unchanged if pattern is empty or no shortcode pattern found
    if ($pattern === '(?:)' || !preg_match_all('/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER)) {
        return $content;
    }
    
    // Process each shortcode match
    foreach ($matches as $match) {
        // Match components:
        // 0 - entire shortcode string: [tag attr="value"]content[/tag] or [tag attr="value" /]
        // 1 - tag name (may be missing)
        // 2 - attributes string (may be missing)
        // 3 - closing bracket for self-closing tags (may be missing)
        // 4 - content between opening/closing tags (for enclosing shortcodes, may be missing)
        // 5 - closing tag (for enclosing shortcodes, may be missing)
        
        if (!isset($match[1], $match[2])) {
            continue; // Skip if tag or attributes are missing
        }
        
        $tag = $match[1];
        $attr_string = $match[2];
        $content_inside = isset($match[4]) ? $match[4] : null;
        
        // Skip if shortcode tag isn't registered
        if (!isset($wp_shortcodes[$tag])) {
            continue;
        }
        
        // Parse attributes into an array
        $attrs = shortcode_parse_atts($attr_string);
        
        // Call the shortcode handler
        $replacement = call_user_func($wp_shortcodes[$tag], $attrs, $content_inside, $tag);
        
        // Replace the shortcode with its processed content
        $content = str_replace($match[0], $replacement, $content);
    }
    
    return $content;
}

function shortcode_parse_atts($text) {
    $attributes = array();
    
    // Pattern for parsing attributes
    $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|\'([^\']*)\'(?:\s|$)|(\S+)(?:\s|$)/';
    
    if (preg_match_all($pattern, $text, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            if (!empty($match[1])) {
                $attributes[$match[1]] = $match[2];
            } else if (!empty($match[3])) {
                $attributes[$match[3]] = $match[4];
            } else if (!empty($match[5])) {
                $attributes[$match[5]] = $match[6];
            }
        }
    }
    
    return $attributes;
}

function get_shortcode_regex() {
    global $wp_shortcodes;
    
    // If no shortcodes, return empty regex that won't match anything
    if (empty($wp_shortcodes)) {
        return '(?:)';
    }
    
    // Join shortcode tags to create alternation pattern
    $tagnames = array_keys($wp_shortcodes);
    $tagregexp = implode('|', array_map('preg_quote', $tagnames));
    
    // For our simulation purposes, we'll use a simple pattern that's less prone to errors
    // This covers most basic shortcode use cases without the complexity
    $tag_regexp = '\\[('. $tagregexp . ')\\s*([^\\]]*?)(?:\\s*\\/)?\\]';
    
    return $tag_regexp;
}

// WordPress activation/deactivation hooks simulation
function register_activation_hook($file, $function) {
    add_action('activate_' . plugin_basename($file), $function);
}

function register_deactivation_hook($file, $function) {
    add_action('deactivate_' . plugin_basename($file), $function);
}

// WordPress error check function
function is_wp_error($thing) {
    return ($thing instanceof WP_Error);
}

// WordPress HTTP API simulation
function wp_remote_get($url, $args = array()) {
    // In a real situation, this would make an HTTP request
    // For our simulation, we'll return a mock response
    
    return array(
        'body' => json_encode(array(
            'weather' => array(
                array(
                    'id' => 800,
                    'main' => 'Clear',
                    'description' => 'clear sky',
                    'icon' => '01d'
                )
            ),
            'main' => array(
                'temp' => 22.5,
                'humidity' => 65
            ),
            'wind' => array(
                'speed' => 8.2
            ),
            'name' => 'New York',
            'sys' => array(
                'country' => 'US'
            )
        )),
        'response' => array(
            'code' => 200
        )
    );
}

function wp_remote_retrieve_body($response) {
    if (is_array($response) && isset($response['body'])) {
        return $response['body'];
    }
    
    return '';
}

function wp_remote_retrieve_response_code($response) {
    if (is_array($response) && isset($response['response']['code'])) {
        return $response['response']['code'];
    }
    
    return 0;
}

// WordPress script and style registration simulation
function wp_enqueue_script($handle, $src = '', $deps = array(), $ver = false, $in_footer = false) {
    // Simulation, does nothing
    return true;
}

function wp_enqueue_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all') {
    // Simulation, does nothing
    return true;
}

// WordPress nonce simulation
function wp_create_nonce($action = -1) {
    return md5($action . time());
}

function wp_verify_nonce($nonce, $action = -1) {
    // In a simulation, always return true
    return true;
}

// WordPress AJAX simulation
function wp_ajax_add_action($action, $function) {
    add_action('wp_ajax_' . $action, $function);
}

function wp_ajax_nopriv_add_action($action, $function) {
    add_action('wp_ajax_nopriv_' . $action, $function);
}

function wp_die($message = '', $title = '', $args = array()) {
    echo $message;
    exit;
}

// WordPress admin menu simulation
function add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null) {
    // Simulation, does nothing
    return $menu_slug;
}

function add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '') {
    // Simulation, does nothing
    return $menu_slug;
}

// WordPress settings API simulation
function register_setting($option_group, $option_name, $args = array()) {
    // Simulation, does nothing
    return;
}

function add_settings_section($id, $title, $callback, $page) {
    // Simulation, does nothing
    return;
}

function add_settings_field($id, $title, $callback, $page, $section = 'default', $args = array()) {
    // Simulation, does nothing
    return;
}

// Execute the plugin to test it
// This is where you'd include your main plugin file and test it
// require_once 'weather-widget.php';

// Example of simulating plugin activation
// do_action('activate_weather-widget/weather-widget.php');

// Example of simulating a widget instance
// $instance = array('title' => 'Weather', 'location' => 'New York');
// $args = array('before_widget' => '<div class="widget">', 'after_widget' => '</div>', 'before_title' => '<h2>', 'after_title' => '</h2>');
// $widget = new Weather_Widget();
// $widget->widget($args, $instance);

// Example of simulating a shortcode
// $content = do_shortcode('[weather location="Tokyo"]');
// echo $content;