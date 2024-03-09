<?php
if (!function_exists('add_action'))
{
  echo 'Hi there! I\'m just a plugin, not much I can do when called directly.';
  exit;
}
class Weather_Widget extends WP_Widget {
  public function __construct(){
    parent::__construct('weather-widget',__('Weather Widget','weather'),array('description'=> __('Simple Weather Widget','weather')));
    add_action('widget_init',function(){
      register_widget('Weather_Widget');
    });
    add_action('asdsd',array($this,''));
    add_action('wp_enqueue_scripts',function(){
      wp_register_style('tp_css', WEATHER_PLUGIN_URL . 'scripts/css/style.css');
      wp_enqueue_style('tp_css');
      wp_register_script('js',WEATHER_PLUGIN_URL . 'scripts/js/functions.js',['jquery']);
      wp_localize_script('js','tp',['url' => admin_url('admin-ajax.php')]);
      wp_enqueue_script('js');
    });
  }
  public function form($instance){
    $title =(isset($instance['title']) && !empty($instance['title'])) ? apply_filters('widget_title', $instance['title']) : __('Weather widget','weather');
    $unit = (isset($instance['unit']) && !empty($instance['unit'])) ? $instance['unit'] :'celsius';
    require(WEATHER_PLUGIN_DIR . 'views/weather-widget-form.php');
    return $instance;
  }
  public function update($new_instance, $old_instance){
    $instance = [];
    $instance['title'] = (isset($new_instance['title']) && !empty($new_instance['title'])) ? apply_filters('widget_title', $new_instance['title']) : __('Weather Widget','weather');
    $instance['unit'] = (isset($new_instance['unit']) && !empty($new_instance['unit'])) ? apply_filters('widget_unit', $new_instance['unit']) : 'celsius';
    return $instance;
  }
  public function widget($args, $instance){
    $title =(isset($instance['title']) && !empty($instance['title'])) ? apply_filters('widget_title', $instance['title']) : __('Weather widget','weather');
    if(get_option('tp_weather_setting')){
      $city_name = get_option('tp_weather_setting')['city_name'];
    } else {
      $city_name = 'Ha+Noi';
    }
    $widget_option = $instance;
    $data = Weather_API::get_weather($city_name);
    require(WEATHER_PLUGIN_DIR . 'views/weather-widget-view.php');
  }
}