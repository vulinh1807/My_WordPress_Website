<!-- <aside id="tp-weather-widget-3" class="widget weather-widget">
  <h2 class="widget-title">Weather Widget</h2>
  <div class="tp-wrap">
    <select name="" id="" class="weather-selector"></select>
  </div>
</aside> -->
<aside id="<?php echo $args['widget_id']; ?>" class="widget -weather-widget">
    <h2 class="widget-title"><?php echo $title; ?></h2>

    <div class="wrap">
        <select class="weather-selector">
        <?php
            if ($data) { 
                foreach ($data as $city) {
                    printf('<option value="weather-%s" data-weather-icon="%s" data-weather-text="%s">%s</option>', $city['id'], $city['weather'][0]['icon'], $city['weather'][0]['main'], $city['name']);
                }
            }
        ?>
        </select>
        <?php
            if ($data):
                ?>
                <div class="weather-status">
                    <img class="weather-icon" src="http://openweathermap.org/img/w/01d.png" alt="Weather Icon">
                    <span class="weather-text">Clear</span>
                </div>
        <?php
                foreach ($data as $key => $city):
        ?>
                    <table class="weather-result table <?php echo ($key == 0) ? 'active' : ''; ?>" id="weather-<?php echo $city['id']; ?>">
                        <tbody>
                            <tr>
                                <td>City</td>
                                <td><?php echo $city['name']; ?></td>
                            </tr>
                            <tr>
                                <td>Sunrise</td>
                                <td><?php echo date('H:i', $city['sys']['sunrise']); ?></td>
                            </tr>
                            <tr>
                                <td>Sunset</td>
                                <td><?php echo date('H:i', $city['sys']['sunset']); ?></td>
                            </tr>
                            <tr>
                                <td>Pressure</td>
                                <td><?php echo $city['main']['pressure']; ?>hpa</td>
                            </tr>
                            <tr>
                                <td>Humidity</td>
                                <td><?php echo $city['main']['humidity']; ?>%</td>
                            </tr>
                            <tr>
                                <td>Temp Min</td>
                                <td><?php echo Weather_API::get_temperature($city['main']['temp_min'], $widget_option['unit']); ?></td>
                            </tr>
                            <tr>
                                <td>Temp Max</td>
                                <td><?php echo Weather_API::get_temperature($city['main']['temp_max'], $widget_option['unit']); ?></td>
                            </tr>
                            <tr>
                                <td>Wind</td>
                                <td><?php echo $city['wind']['speed']; ?>km/h</td>
                            </tr>
                            <tr>
                                <td>Cloud</td>
                                <td><?php echo $city['clouds']['all']; ?>%</td>
                            </tr>
                        </tbody>
                    </table>
        <?php
                    endforeach;
                else:
                    echo '<table>';
                    echo '<tr><td>No Result.</td></tr>';
                    echo '</table>';
                endif;
        ?>
    </div>
</aside>