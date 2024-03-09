<div class="wrap app">
  <h2>Settings</h2>
  <form name="post" action="option.php" method="post" id="post" autocomplete="off">
    <input type="hidden" name="action" value="<?php echo $option_group; ?>">
    <?php wp_nonce_field($option_group . '-options');?>
    <div class="tp-city-list"></div>
    <table class="form-table">
      <tbody>
        <tr>
          <th scope="row"><label for="city">City</label></th>
          <td>
            <input type="text" id="city" placeholder="Enter Your City" class="regular-text">
          </td>
        </tr>
        <tr>
          <th scope="row">Search</th>
          <td id="search-results">
            Please input your city above
          </td>
        </tr>
        <tr>
          <th scope="row">Selected</th>
          <td id="search-selected">N/A</td>
        </tr>
      </tbody>
    </table>
    <div class="alignleft">
      <button class="button button-primary button-large" id="btnSave" type="submit">Save changes</button>
    </div>
  </form>
</div>