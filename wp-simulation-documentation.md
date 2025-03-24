# WordPress Simulation Functions Documentation

- [View on Github](https://github.com/rmilejcz/workspace/blob/main/wp-simulation-documentation.md)

This document provides a reference for all functions available in the `wp-simulation.php` file, which simulates the WordPress environment for testing purposes.

## Table of Contents

- [Error Handling](#error-handling)
- [Options API](#options-api)
- [Plugin Path Functions](#plugin-path-functions)
- [Internationalization Functions](#internationalization-functions)
- [Hooks System](#hooks-system)
- [Widget API](#widget-api)
- [Shortcode API](#shortcode-api)
- [Activation/Deactivation Hooks](#activationdeactivation-hooks)
- [HTTP API](#http-api)
- [Script and Style Registration](#script-and-style-registration)
- [Security Functions](#security-functions)
- [AJAX Functions](#ajax-functions)
- [Admin Menu Functions](#admin-menu-functions)
- [Settings API](#settings-api)

---

## Error Handling

### `WP_Error` Class

A class for handling and storing error messages.

```php
$error = new WP_Error($code, $message, $data);
```

**Parameters:**

- `$code` (string): Error code
- `$message` (string): Error message
- `$data` (mixed): Additional error data

**Methods:**

- `get_error_message($code = '')`: Returns the error message
- `get_error_code()`: Returns the first error code

### `is_wp_error($thing)`

Checks if a variable is a `WP_Error` object.

**Parameters:**

- `$thing` (mixed): Variable to check

**Returns:**

- Boolean: `true` if `$thing` is a `WP_Error` object, `false` otherwise

---

## Options API

### `add_option($option, $value = '', $deprecated = '', $autoload = 'yes')`

Adds an option to the options array if it doesn't already exist.

**Parameters:**

- `$option` (string): Option name
- `$value` (mixed): Option value
- `$deprecated` (string): Deprecated parameter
- `$autoload` (string): Whether to autoload the option (ignored in simulation)

**Returns:**

- Boolean: `true` if the option was added, `false` if it already exists

### `update_option($option, $value, $autoload = null)`

Updates an existing option or adds it if it doesn't exist.

**Parameters:**

- `$option` (string): Option name
- `$value` (mixed): New option value
- `$autoload` (string|null): Whether to autoload the option (ignored in simulation)

**Returns:**

- Boolean: Always returns `true` in this simulation

### `get_option($option, $default = false)`

Retrieves an option value.

**Parameters:**

- `$option` (string): Option name
- `$default` (mixed): Default value to return if option doesn't exist

**Returns:**

- mixed: Option value or default value if option doesn't exist

---

## Plugin Path Functions

### `plugin_dir_path($file)`

Returns the filesystem path of the directory that contains the plugin.

**Parameters:**

- `$file` (string): Path to the plugin file

**Returns:**

- string: Plugin directory path with trailing slash

### `plugin_dir_url($file)`

Returns the URL of the directory that contains the plugin.

**Parameters:**

- `$file` (string): Path to the plugin file

**Returns:**

- string: Plugin directory URL with trailing slash

### `plugin_basename($file)`

Returns the relative path from the plugins directory to the plugin file.

**Parameters:**

- `$file` (string): Path to the plugin file

**Returns:**

- string: Relative path from plugins directory to plugin file

---

## Internationalization Functions

### `__($text, $domain = 'default')`

Translates a string (simulation just returns the original text).

**Parameters:**

- `$text` (string): Text to translate
- `$domain` (string): Text domain

**Returns:**

- string: Translated text (original text in simulation)

### `load_plugin_textdomain($domain, $deprecated = false, $plugin_rel_path = false)`

Loads a plugin's translated strings (simulation does nothing).

**Parameters:**

- `$domain` (string): Text domain
- `$deprecated` (boolean): Deprecated parameter
- `$plugin_rel_path` (string): Relative path to the plugin directory

**Returns:**

- boolean: Always returns `true` in this simulation

---

## Hooks System

### `add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1)`

Hooks a function to a specific action.

**Parameters:**

- `$tag` (string): Action name
- `$function_to_add` (callable): Function to be called
- `$priority` (integer): Priority of execution
- `$accepted_args` (integer): Number of arguments the function accepts

**Returns:**

- boolean: Always returns `true` in this simulation

### `add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1)`

Hooks a function to a specific filter.

**Parameters:**

- `$tag` (string): Filter name
- `$function_to_add` (callable): Function to be called
- `$priority` (integer): Priority of execution
- `$accepted_args` (integer): Number of arguments the function accepts

**Returns:**

- boolean: Always returns `true` in this simulation

### `apply_filters($tag, $value)`

Calls the functions added to a filter hook.

**Parameters:**

- `$tag` (string): Filter name
- `$value` (mixed): Value to filter
- `...` (mixed): Additional parameters to pass to the filter

**Returns:**

- mixed: The filtered value

### `do_action($tag, $arg = '')`

Calls the functions added to an action hook.

**Parameters:**

- `$tag` (string): Action name
- `$arg` (mixed): Additional argument
- `...` (mixed): Additional arguments to pass to the action

**Returns:**

- void

---

## Widget API

### `WP_Widget` Class

Base class for creating widgets.

```php
class My_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'my_widget',
            __('My Widget', 'text-domain'),
            array('description' => __('A widget that does something', 'text-domain'))
        );
    }

    // Override these methods
    public function widget($args, $instance) { }
    public function form($instance) { }
    public function update($new_instance, $old_instance) { }
}
```

**Constructor Parameters:**

- `$id_base` (string): Base ID for the widget
- `$name` (string): Widget name
- `$widget_options` (array): Widget options
- `$control_options` (array): Widget control options

**Methods to Override:**

- `widget($args, $instance)`: Outputs the widget content
- `form($instance)`: Outputs the widget settings form
- `update($new_instance, $old_instance)`: Processes widget options on save

---

## Shortcode API

### `add_shortcode($tag, $func)`

Registers a shortcode handler.

**Parameters:**

- `$tag` (string): Shortcode name
- `$func` (callable): Function to handle the shortcode

**Returns:**

- void

### `do_shortcode($content)`

Processes content for shortcodes.

**Parameters:**

- `$content` (string): Content to process

**Returns:**

- string: Content with shortcodes processed

### `shortcode_parse_atts($text)`

Parses shortcode attributes.

**Parameters:**

- `$text` (string): Shortcode attributes string

**Returns:**

- array: Parsed attributes

### `get_shortcode_regex()`

Generates the regex for parsing shortcodes.

**Returns:**

- string: Regex pattern for matching shortcodes

---

## Activation/Deactivation Hooks

### `register_activation_hook($file, $function)`

Registers a function to be called when the plugin is activated.

**Parameters:**

- `$file` (string): Plugin file path
- `$function` (callable): Function to call on activation

**Returns:**

- void

### `register_deactivation_hook($file, $function)`

Registers a function to be called when the plugin is deactivated.

**Parameters:**

- `$file` (string): Plugin file path
- `$function` (callable): Function to call on deactivation

**Returns:**

- void

---

## HTTP API

### `wp_remote_get($url, $args = array())`

Retrieves a URL using the GET method (simulated, returns mock data).

**Parameters:**

- `$url` (string): URL to retrieve
- `$args` (array): Request arguments

**Returns:**

- array: Response array with 'body' and 'response' keys

### `wp_remote_retrieve_body($response)`

Retrieves just the body from a response.

**Parameters:**

- `$response` (array): Response array

**Returns:**

- string: Response body

### `wp_remote_retrieve_response_code($response)`

Retrieves the response code from a response.

**Parameters:**

- `$response` (array): Response array

**Returns:**

- integer: Response code

---

## Script and Style Registration

### `wp_enqueue_script($handle, $src = '', $deps = array(), $ver = false, $in_footer = false)`

Enqueues a script (simulation does nothing).

**Parameters:**

- `$handle` (string): Script name
- `$src` (string): Script URL
- `$deps` (array): Dependencies
- `$ver` (string|boolean|null): Version
- `$in_footer` (boolean): Whether to enqueue in footer

**Returns:**

- boolean: Always returns `true` in this simulation

### `wp_enqueue_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all')`

Enqueues a stylesheet (simulation does nothing).

**Parameters:**

- `$handle` (string): Style name
- `$src` (string): Style URL
- `$deps` (array): Dependencies
- `$ver` (string|boolean|null): Version
- `$media` (string): Media type

**Returns:**

- boolean: Always returns `true` in this simulation

---

## Security Functions

### `wp_create_nonce($action = -1)`

Creates a cryptographic token (simplified in simulation).

**Parameters:**

- `$action` (string|integer): Action name

**Returns:**

- string: Nonce value

### `wp_verify_nonce($nonce, $action = -1)`

Verifies a nonce (always returns true in simulation).

**Parameters:**

- `$nonce` (string): Nonce value
- `$action` (string|integer): Action name

**Returns:**

- boolean: Always returns `true` in this simulation

---

## AJAX Functions

### `wp_ajax_add_action($action, $function)`

Adds an action for logged-in users' AJAX requests.

**Parameters:**

- `$action` (string): Action name
- `$function` (callable): Function to handle the action

**Returns:**

- void

### `wp_ajax_nopriv_add_action($action, $function)`

Adds an action for non-logged-in users' AJAX requests.

**Parameters:**

- `$action` (string): Action name
- `$function` (callable): Function to handle the action

**Returns:**

- void

### `wp_die($message = '', $title = '', $args = array())`

Kills the execution and displays an error message.

**Parameters:**

- `$message` (string): Error message
- `$title` (string): Error title
- `$args` (array): Additional arguments

**Returns:**

- void (exits script)

---

## Admin Menu Functions

### `add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null)`

Adds a top-level menu page (simulation does nothing).

**Parameters:**

- `$page_title` (string): Page title
- `$menu_title` (string): Menu title
- `$capability` (string): Capability required
- `$menu_slug` (string): Menu slug
- `$function` (callable): Function to display the page
- `$icon_url` (string): Icon URL
- `$position` (integer|null): Position

**Returns:**

- string: Menu slug

### `add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '')`

Adds a submenu page (simulation does nothing).

**Parameters:**

- `$parent_slug` (string): Parent menu slug
- `$page_title` (string): Page title
- `$menu_title` (string): Menu title
- `$capability` (string): Capability required
- `$menu_slug` (string): Menu slug
- `$function` (callable): Function to display the page

**Returns:**

- string: Menu slug

---

## Settings API

### `register_setting($option_group, $option_name, $args = array())`

Registers a setting (simulation does nothing).

**Parameters:**

- `$option_group` (string): Option group
- `$option_name` (string): Option name
- `$args` (array): Additional arguments

**Returns:**

- void

### `add_settings_section($id, $title, $callback, $page)`

Adds a section to a settings page (simulation does nothing).

**Parameters:**

- `$id` (string): Section ID
- `$title` (string): Section title
- `$callback` (callable): Function to display the section
- `$page` (string): Page slug

**Returns:**

- void

### `add_settings_field($id, $title, $callback, $page, $section = 'default', $args = array())`

Adds a field to a settings section (simulation does nothing).

**Parameters:**

- `$id` (string): Field ID
- `$title` (string): Field title
- `$callback` (callable): Function to display the field
- `$page` (string): Page slug
- `$section` (string): Section ID
- `$args` (array): Additional arguments

**Returns:**

- void
