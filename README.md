# WordPress Weather Widget Plugin Challenge

## Overview

In this challenge, you'll implement core functionality for a WordPress weather widget plugin. The plugin structure has been set up for you, but several key components need to be implemented.

## Your Task

Complete the implementation of the Weather API class and related plugin functionality:

1. **Complete the Weather API Implementation**

   - Implement the `get_weather()` method in the `Weather_API` class
   - Implement caching functionality to store weather data
   - Format temperature based on unit settings

2. **Implement the Weather Widget**

   - Complete the `Weather_Widget` class implementation
   - Create the front-end display of the widget
   - Implement widget settings form

3. **Implement the Shortcode**
   - Create the shortcode handler in the main plugin class
   - Allow configurable location via shortcode attributes

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

### 4. Additional Features (optional, for bonus points)

- Implement refresh functionality using AJAX
- Add weather icons based on conditions
- Add forecast data (if available from the API)
- Implement responsive design for the widget

## Testing Your Code

The testing environment includes a WordPress simulation that allows you to test your plugin without a full WordPress installation. You can use the following:

1. `test.php` - A script that tests your plugin functionality
2. `wp-simulation.php` - Simulates WordPress core functions

To run your test:

```
php test.php
```

## Evaluation Criteria

Your submission will be evaluated on:

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

Good luck!
