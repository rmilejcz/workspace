<?php
/**
 * Weather API Handler Class
 * 
 * Handles communication with the weather API service
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Weather_API {
    /**
     * API key
     */
    private $api_key;
    
    /**
     * API base URL
     */
    private $api_url = 'https://api.openweathermap.org/data/2.5/weather';
    
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
        $this->api_key = isset($settings['api_key']) ? $settings['api_key'] : '';
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
        $mocks_array = []; 
        // TODO: Implement this method
        $filename = 'cach_location' . '.json';
        $filepath = $this->cache_dir . $filename;
        // 1. Check if we have cached data for this location
        if (file_exists($filepath)) {
            $cached = json_decode(file_get_contents($filepath), true);
        
            // Optional: check if it's still valid (e.g., not older than 1 hour)
            if (time() - $cached['timestamp'] < $this->cache_time && !$force_refresh) {
                return $cached;
            }
        } else {
            $mocks = $this->get_mock_weather_data($location);

            if (isset($mocks)) {
            // Make a json file 
            array_push($mocks_array, $mocks);    
            file_put_contents($filepath, json_encode($mocks_array));
            // create an object to store the data $mocks 
            
            return $mocks;
            } else {
                return new WP_Error('not_implemented', __('Weather API not implemented', 'weather-widget'));
            }
        }
        // 2. If cache is valid and we're not forcing refresh, return cached data
        // 3. Otherwise, fetch fresh data from API
        

        // 4. Cache the data for future use
        // 5. Return the data
        
        // ....
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
     * Make API request
     * 
     * @param array $params Request parameters
     * @return array|WP_Error Response data or error
     */
    private function make_api_request($params) {
        // TODO: Implement this method
        // For the challenge, we'll return mock data instead of making a real API call
        // In a real plugin, we would use wp_remote_get() here
        
        return $this->get_mock_weather_data($params['q']);
    }
    
    /**
     * Get mock weather data for a city
     * This is just for the challenge
     * 
     * @param string $city City name
     * @return array Mock weather data
     */
    private function get_mock_weather_data($city) {
        $cities = array(
            'London' => array(
                'temp' => 10,
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
        
        // Get data for the requested city, or generate random data if city not found
        if (isset($cities[$city])) {
            $weather_data = $cities[$city];
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
        $weather_data['city'] = $city;
        $weather_data['country'] = 'Unknown';
        $weather_data['timestamp'] = time();
        
        return $weather_data;
    }
}