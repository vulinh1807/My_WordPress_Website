<?php
if (!function_exists('add_action'))
{
  echo 'Hi there! I\'m just a plugin, not much I can do when called directly.';
  exit;
}

class Weather_API {
  //lay chuoi json
  public static function get_json($json){
    return json_decode($json, true);
  }
  //gui request toi website
  public static function request($city = 'Ha+Noi', $like = true, $mode = 'json'){
    $type = ($like) ? 'like' : 'accurate';
    $city = urlencode(trim($city));
    $url = "http://api.openweathermap.org/data/2.5/find?q={$city}&type=accurate&mode=xml&appid=be30530106afe038b94f96bdf13165b4";
    $fget = file_get_contents($url);
    if($fget){
      return self::get_json($fget);
    }else{
      return false;
    }
  }  
  //lay duoc du lieu Weather
    public static function get_weather($data = [], $mode ='json'){
      $old_data = get_transient('weather_data');
      if(!$old_data && $data){
        $return = [];
        foreach($data as $city_name){
          $url = "http://api.openweathermap.org/data/2.5/weather?q={$city_name}&units=metric&mode=xml&appid=be30530106afe038b94f96bdf13165b4";
          $fget = file_get_contents($url);
          if($fget){
            $return [] = self::get_json($fget);
          }
        }
        if($return){
          set_transient("weather_data", $return,10000);
          return $return;
        }
      } else {
        foreach($old_data as $key => $value){
          if(empty($value)){
            unset($old_data[$key]);
          }
      }
      if($old_data){
        $old_data = array_values($old_data);
        return $old_data;
      }
    }  
    return false;
  }
  public static function get_temperature($temp=0,$option='Celsius'){
    switch ($option){
      case 'celsius':
        return $temp . 'C';
        break;

      case 'Fahrenhelt':
        return ($temp * 9 / 5 + 32 ) . 'F';
        break;
    }
  }
  public static function get_weather_icon($code='01d'){
    return "http://openweathermap.org/img/w/{$code}.png";
  } 
}