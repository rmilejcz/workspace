<?php
/**
 * Weather Widget Plugin Test Script
 * 
 * This file simulates WordPress and tests the plugin with an HTML UI
 */

// Start output buffering to capture test results
ob_start();

// Load WordPress simulation
require_once 'wp-simulation.php';

// Load plugin files
require_once 'weather-widget.php';

// Initialize plugin (this should automatically happen in the plugin file)
$plugin = Weather_Widget_Plugin::get_instance();

// Simulate activation
do_action('activate_weather-widget/weather-widget.php');

// Get plugin settings
$settings = get_option('weather_widget_settings', array());

// Initialize test results array
$test_results = array(
    'cities' => array()
);

// Test API functionality if it exists
if (class_exists('Weather_API')) {
    $api_exists = true;
    
    $api = new Weather_API();
    
    $cities = array('London', 'New York', 'Tokyo', 'InvalidCity');
    
    foreach ($cities as $city) {
        $result = $api->get_weather($city);
        
        if (is_wp_error($result)) {
            $test_results['cities'][$city] = array(
                'success' => false,
                'message' => $result->get_error_message()
            );
        } else {
            $test_results['cities'][$city] = array(
                'success' => true,
                'temperature' => $api->format_temperature($result['temp']),
                'conditions' => $result['conditions'],
                'humidity' => $result['humidity'],
                'wind_speed' => $result['wind_speed']
            );
        }
    }
} else {
    $api_exists = false;
}

// Test shortcode if registered
$shortcode_result = '';
$shortcode_implemented = false;

// Only try to do shortcode if we have registered shortcodes
global $wp_shortcodes;
if (!empty($wp_shortcodes) && isset($wp_shortcodes['weather'])) {
    $shortcode_result = do_shortcode('[weather location="Sydney"]');
    $shortcode_implemented = ($shortcode_result !== '[weather location="Sydney"]');
}

// Buffer any output from the tests
$output_buffer = ob_get_clean();

// Now output the HTML UI
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WordPress Plugin Test Results</title>
    <style>
        /* WordPress admin style inspired CSS */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            color: #1d2327;
            background: #f0f0f1;
            margin: 0;
            padding: 20px;
        }
        .wrap {
            max-width: 1000px;
            margin: 0 auto;
        }
        .header {
            background: #2271b1;
            color: white;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            margin-bottom: 0;
        }
        .header h1 {
            margin: 0;
            font-weight: 400;
        }
        .content {
            background: white;
            padding: 20px;
            border: 1px solid #c3c4c7;
            border-top: none;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        .section {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .section h2 {
            margin-top: 0;
            font-weight: 400;
            color: #2271b1;
        }
        .success {
            color: #00a32a;
        }
        .error {
            color: #d63638;
        }
        .warning {
            color: #dba617;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1em 0;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid #eee;
        }
        th {
            background: #f6f7f7;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .dashicons {
            font-family: dashicons;
            display: inline-block;
            line-height: 1;
            font-weight: 400;
            font-style: normal;
            width: 20px;
            height: 20px;
            font-size: 20px;
            vertical-align: middle;
        }
        .dashicons-yes {
            color: #00a32a;
        }
        .dashicons-yes:before {
            content: "✓";
        }
        .dashicons-no {
            color: #d63638;
        }
        .dashicons-no:before {
            content: "✕";
        }
        .dashicons-warning {
            color: #dba617;
        }
        .dashicons-warning:before {
            content: "⚠";
        }
        .weather-icon {
            font-size: 24px;
            margin-right: 5px;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
        }
        .badge-success {
            background: #edfaef;
            color: #00a32a;
            border: 1px solid #00a32a;
        }
        .badge-error {
            background: #fcf0f1;
            color: #d63638;
            border: 1px solid #d63638;
        }
        .badge-warning {
            background: #fcf9e8;
            color: #dba617;
            border: 1px solid #dba617;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="header">
            <h1>WordPress Weather Plugin Test Results</h1>
        </div>
        <div class="content">
            <div class="section">
                <h2>Plugin Information</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <td>Weather Widget</td>
                    </tr>
                    <tr>
                        <th>Version</th>
                        <td><?php echo WEATHER_WIDGET_VERSION; ?></td>
                    </tr>
                    <tr>
                        <th>Path</th>
                        <td><?php echo WEATHER_WIDGET_PATH; ?></td>
                    </tr>
                </table>
            </div>
            
            <div class="section">
                <h2>Plugin Settings</h2>
                <table>
                    <tr>
                        <th>API Key</th>
                        <td><?php echo isset($settings['api_key']) ? $settings['api_key'] : '<span class="warning">Not set</span>'; ?></td>
                    </tr>
                    <tr>
                        <th>Default Location</th>
                        <td><?php echo isset($settings['default_location']) ? $settings['default_location'] : '<span class="warning">Not set</span>'; ?></td>
                    </tr>
                    <tr>
                        <th>Units</th>
                        <td><?php echo isset($settings['units']) ? $settings['units'] : '<span class="warning">Not set</span>'; ?></td>
                    </tr>
                    <tr>
                        <th>Cache Time</th>
                        <td><?php echo isset($settings['cache_time']) ? $settings['cache_time'] . ' seconds' : '<span class="warning">Not set</span>'; ?></td>
                    </tr>
                </table>
            </div>
            
            <div class="section">
                <h2>API Implementation Status</h2>
                <?php if ($api_exists): ?>
                    <p><span class="dashicons dashicons-yes"></span> <strong class="success">Weather_API class exists</strong></p>
                    
                    <h3>Weather Data Test Results</h3>
                    <table>
                        <tr>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                        <?php foreach ($test_results['cities'] as $city => $result): ?>
                            <tr>
                                <td><strong><?php echo $city; ?></strong></td>
                                <td>
                                    <?php if ($result['success']): ?>
                                        <span class="badge badge-success">Success</span>
                                    <?php else: ?>
                                        <span class="badge badge-error">Error</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($result['success']): ?>
                                        <div>
                                            <span class="weather-icon">🌡️</span> Temperature: <?php echo $result['temperature']; ?>
                                        </div>
                                        <div>
                                            <span class="weather-icon">
                                                <?php 
                                                    $icon = '☀️';
                                                    if (stripos($result['conditions'], 'rain') !== false) $icon = '🌧️';
                                                    elseif (stripos($result['conditions'], 'cloud') !== false) $icon = '☁️';
                                                    elseif (stripos($result['conditions'], 'snow') !== false) $icon = '❄️';
                                                    echo $icon;
                                                ?>
                                            </span> 
                                            Conditions: <?php echo $result['conditions']; ?>
                                        </div>
                                        <div>
                                            <span class="weather-icon">💧</span> Humidity: <?php echo $result['humidity']; ?>%
                                        </div>
                                        <div>
                                            <span class="weather-icon">💨</span> Wind Speed: <?php echo $result['wind_speed']; ?> m/s
                                        </div>
                                    <?php else: ?>
                                        <span class="error"><?php echo $result['message']; ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p><span class="dashicons dashicons-warning"></span> <strong class="warning">Weather_API class not properly implemented yet</strong></p>
                <?php endif; ?>
            </div>
            
            <div class="section">
                <h2>Shortcode Implementation Status</h2>
                <?php if ($shortcode_implemented): ?>
                    <p><span class="dashicons dashicons-yes"></span> <strong class="success">Shortcode successfully implemented</strong></p>
                    <div>
                        <h3>Shortcode Output:</h3>
                        <div style="padding: 10px; border: 1px solid #eee; background: #f9f9f9;">
                            <?php echo $shortcode_result; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <p><span class="dashicons dashicons-warning"></span> <strong class="warning">Shortcode not properly registered or implemented yet</strong></p>
                <?php endif; ?>
            </div>

            <?php if (!empty($output_buffer)): ?>
                <div class="section">
                    <h2>Debug Information</h2>
                    <div class="debug-container">
                        <h3>Function Calls</h3>
                        <pre><?php echo $debug_output['function_calls']; ?></pre>
                        
                        <h3>API Test Results</h3>
                        <pre><?php 
                            foreach($debug_output['api_tests'] as $test => $result) {
                                echo "$test: " . ($result ? 'PASS' : 'FAIL') . "\n";
                                if (isset($debug_output['api_errors'][$test])) {
                                    echo "  Error: " . $debug_output['api_errors'][$test] . "\n";
                                }
                            }
                        ?></pre>
                        
                        <h3>Cache Operations</h3>
                        <pre><?php echo $debug_output['cache_ops']; ?></pre>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>