<?php
/**
 * Weather API Handler Class
 * 
 * Handles retrieving weather data using mock data
 * NOTE: This challenge uses mock data - no real API connection is required
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Weather_API {
    /**
     * Units (metric or imperial)
     */
    private $units = 'metric';
    
    /**
     * Cache time in seconds
     */
    private $cache_time = 1800; // 30 minutes
    
    /**
     * Cache directory
     */
    private $cache_dir;
    
    /**
     * Constructor
     */
    public function __construct() {
        // Get settings from WordPress options
        $settings = get_option('weather_widget_settings', array());
        
        // Set properties from settings
        $this->units = isset($settings['units']) ? $settings['units'] : 'metric';
        $this->cache_time = isset($settings['cache_time']) ? $settings['cache_time'] : 1800;
        
        // Set cache directory
        $this->cache_dir = WEATHER_WIDGET_PATH . 'cache';
        
        // Create cache directory if it doesn't exist
        if (!file_exists($this->cache_dir)) {
            // In a real plugin, we would use WP_Filesystem here
            mkdir($this->cache_dir, 0755, true);
        }
    }
    
    /**
     * Get weather data for a location
     * 
     * @param string $location The location to get weather for
     * @param bool $force_refresh Whether to bypass cache
     * @return array|WP_Error Weather data or error
     */
    public function get_weather($location, $force_refresh = false) {
        // TODO: Implement this method
        // 1. Check if we have cached data for this location
        // 2. If cache is valid and we're not forcing refresh, return cached data
        // 3. Otherwise, fetch mock data for this location
        // 4. Cache the data for future use
        // 5. Return the data
        
        return new WP_Error('not_implemented', __('Weather API not implemented', 'weather-widget'));
    }
    
    /**
     * Format temperature based on units setting
     * 
     * @param float $temp Temperature value
     * @return string Formatted temperature
     */
    public function format_temperature($temp) {
        // TODO: Implement this method
        // Format temperature with the appropriate unit symbol
        
        return $temp;
    }
    
    /**
     * Get cache key for a location
     * 
     * @param string $location The location
     * @return string Cache key
     */
    private function get_cache_key($location) {
        // TODO: Implement this method
        // Create a unique cache key for the location
        
        return md5($location);
    }
    
    /**
     * Get cached data if available
     * 
     * @param string $cache_key The cache key
     * @return array|false Weather data or false if not available
     */
    private function get_cached_data($cache_key) {
        // TODO: Implement this method
        // 1. Check if cache file exists
        // 2. Check if cache is still valid (not expired)
        // 3. Return cached data or false
        
        return false;
    }
    
    /**
     * Save data to cache
     * 
     * @param string $cache_key The cache key
     * @param array $data The data to cache
     * @return bool Success status
     */
    private function save_to_cache($cache_key, $data) {
        // TODO: Implement this method
        // Save the data to a cache file
        
        return false;
    }
    
    /**
     * Get mock weather data for a location
     * This method provides mock data for the challenge - no real API call is made
     * 
     * @param string $location The location to get weather for
     * @return array Mock weather data
     */
    private function get_mock_weather_data($location) {
        $cities = array(
            'London' => array(
                'temp' => 15.2,
                'humidity' => 76,
                'conditions' => 'Cloudy',
                'wind_speed' => 12.5,
                'icon' => '04d'
            ),
            'New York' => array(
                'temp' => 22.5,
                'humidity' => 65,
                'conditions' => 'Clear',
                'wind_speed' => 8.2,
                'icon' => '01d'
            ),
            'Tokyo' => array(
                'temp' => 28.1,
                'humidity' => 80,
                'conditions' => 'Rainy',
                'wind_speed' => 5.8,
                'icon' => '10d'
            ),
            'Sydney' => array(
                'temp' => 26.3,
                'humidity' => 70,
                'conditions' => 'Sunny',
                'wind_speed' => 14.7,
                'icon' => '01d'
            )
        );
        
        // Get data for the requested location, or generate random data if location not found
        if (isset($cities[$location])) {
            $weather_data = $cities[$location];
        } else {
            $weather_data = array(
                'temp' => rand(5, 35) + (rand(0, 10) / 10),
                'humidity' => rand(40, 95),
                'conditions' => array('Sunny', 'Cloudy', 'Rainy', 'Windy', 'Snowy')[rand(0, 4)],
                'wind_speed' => rand(0, 30) + (rand(0, 10) / 10),
                'icon' => array('01d', '02d', '03d', '04d', '09d', '10d', '11d', '13d', '50d')[rand(0, 8)]
            );
        }
        
        // Add extra data to make it more realistic
        $weather_data['city'] = $location;
        $weather_data['country'] = 'Unknown';
        $weather_data['timestamp'] = time();
        
        return $weather_data;
    }
}