# WordPress Weather Widget Plugin Challenge (One-Hour Version)

## Overview

In this one-hour challenge, you'll implement **one core component** of a WordPress weather widget plugin. The plugin structure and WordPress simulation environment have been set up for you, allowing you to test your implementation without a full WordPress installation.

## Important Note About Weather Data

**This challenge uses mock weather data** - there is no actual API connection required. The mock data is provided in the `get_mock_weather_data()` method in the Weather_API class. Your implementation should work with this mock data as if it were coming from a real API.

## Available Files

You'll be working with these files:

- `weather-widget.php` - The main plugin file (needs your implementation)
- `includes/class-weather-api.php` - The API handler class (needs implementation)
- `includes/class-weather-widget.php` - The widget class (needs implementation)
- `wp-simulation.php` - WordPress core functions simulation (don't modify)
- `index.php` - Test script that runs automatically (don't modify)
- `wp-simulation-documentation.md` - Documentation for available WordPress functions

## Your Task

You have **one hour** to complete this challenge. Rather than trying to implement everything, **choose ONE of the following components** to implement fully:

### Option 1: Weather API Implementation

- Implement the `get_weather()` method in the `Weather_API` class
- Implement caching functionality to store weather data
- Format temperature based on unit settings

### Option 2: Weather Widget Implementation

- Complete the `Weather_Widget` class implementation
- Create the front-end display of the widget
- Implement widget settings form

### Option 3: Shortcode Implementation

- Create the shortcode handler in the main plugin class
- Allow configurable location via shortcode attributes
- Generate formatted HTML output for the weather display

## Testing Your Implementation

- The `index.php` script automatically tests your implementation
- **To view test results:** Simply refresh the preview pane after making changes
- The test results will show progress on whichever component you choose to focus on

## Component Requirements

### Option 1: Weather API Implementation

- Complete the `get_weather()` method to fetch weather data for a location
- Implement proper caching using the file system
- Handle errors gracefully and return appropriate `WP_Error` objects
- Format temperature according to the configured units (metric/imperial)

### Option 2: Widget Implementation

- Complete the `widget()` method to display weather data on the front-end
- Create a configurable widget with settings for location and display options
- Implement the widget admin form
- Sanitize and validate all user inputs

### Option 3: Shortcode Implementation

- Create a `[weather]` shortcode that accepts location attributes
- Handle default locations when none is specified
- Return formatted HTML displaying the weather information
- Allow customization through shortcode attributes

## Evaluation Criteria

- **Focus on quality over quantity** - A well-implemented single feature is better than partial implementation of multiple features
- Code organization and structure
- WordPress best practices
- Error handling and edge cases
- Security (proper data validation and sanitization)

## Notes

- The API uses mock data for simplicity (you don't need a real API key)
- The `wp-simulation-documentation.md` file contains documentation for all available WordPress functions
- Add comments to explain your implementation decisions
- Remember, you only have one hour - scope your work accordingly!
