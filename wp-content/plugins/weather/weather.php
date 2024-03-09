<?php
if(!function_exists('add_action')){
  echo 'Hi there! I\'m just a plugin, not much I can do when called directly.';
  exit;
}
define('WEATHER_VERSION','1.0.0');
define('WEATHER_MINIMUM_WP_VERSION','4.1.1');
define('WEATHER_PLUGIN_URL',plugin_dir_url(__FILE__));
define('WEATHER_PLUGIN_DIR',plugin_dir_path(__FILE__));

require_once(WEATHER_PLUGIN_DIR.'includes/class.weather-setting.php');
require_once(WEATHER_PLUGIN_DIR.'includes/class.weather-api.php');
require_once(WEATHER_PLUGIN_DIR.'includes/class.weather-widget.php');
require_once(WEATHER_PLUGIN_DIR.'includes/class.weather.php');
$weather = new Weather(); 
// echo '<prep>' .print_r(Weather_API::get_weather(['Ha+Noi','TP+Ho+Chi+Minh']),true). '</prep>';die();