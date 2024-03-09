<?php
if (!function_exists('add_action'))
{
  echo 'Hi there! I\'m just a plugin, not much I can do when called directly.';
  exit;
}
class Weather
{
  public function __construct(){
    $weather_widget = new Weather_Widget();
    $weather_setting = new Weather_Setting();
  }
  public function activation_hook(){
  }
  public function deactivate_hook(){
  }
}