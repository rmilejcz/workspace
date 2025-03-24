# WordPress Weather Widget Plugin Challenge

## Overview

In this challenge, you'll implement core functionality for a WordPress weather widget plugin. The plugin structure and WordPress simulation environment have been set up for you, allowing you to test your plugin without a full WordPress installation.

## Available Files

You'll be working with these files:

- `weather-widget.php` - The main plugin file (needs your implementation)
- `includes/class-weather-api.php` - The API handler class (needs implementation)
- `includes/class-weather-widget.php` - The widget class (needs implementation)
- `wp-simulation.php` - WordPress core functions simulation (don't modify)
- `index.php` - Test script that runs automatically (don't modify)
- `config.php` - Configuration settings (already set up)
- `utils.php` - Utility functions (already set up)

## Your Task

Complete the implementation of the following components:

1. **Weather API Implementation**

   - Implement the `get_weather()` method in the `Weather_API` class
   - Implement caching functionality to store weather data
   - Format temperature based on unit settings

2. **Weather Widget**

   - Complete the `Weather_Widget` class implementation
   - Create the front-end display of the widget
   - Implement widget settings form

3. **Shortcode**
   - Create the shortcode handler in the main plugin class
   - Allow configurable location via shortcode attributes

## Testing Your Implementation

- The `index.php` script automatically tests your implementation
- **To view test results:** Simply refresh the preview pane after making changes
- The test results will show which components are working and which need further implementation

## Requirements

### 1. Weather API Implementation

- Complete the `get_weather()` method to fetch weather data for a location
- Implement proper caching using the file system
- Handle errors gracefully and return appropriate `WP_Error` objects
- Format temperature according to the configured units (metric/imperial)

### 2. Widget Implementation

- Complete the `widget()` method to display weather data on the front-end
- Create a configurable widget with settings for location and display options
- Implement the widget admin form
- Sanitize and validate all user inputs

### 3. Shortcode Implementation

- Create a `[weather]` shortcode that accepts location attributes
- Handle default locations when none is specified
- Return formatted HTML displaying the weather information

### 4. Additional Features (optional)

- Implement refresh functionality using AJAX
- Add weather icons based on conditions
- Add forecast data (if available from the API)
- Implement responsive design for the widget

## Evaluation Criteria

- Correctness of implementation
- Code organization and structure
- WordPress best practices
- Error handling and edge cases
- Performance considerations (especially caching)
- Security (proper data validation and sanitization)

## Notes

- The API uses mock data for simplicity (you don't need a real API key)
- Focus on completing the core functionality before attempting bonus features
- Add comments to explain your implementation decisions
- Follow WordPress coding standards
