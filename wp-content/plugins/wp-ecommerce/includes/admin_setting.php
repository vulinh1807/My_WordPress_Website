<?php
//dang ki cau hinh
/*
$option_group: wp_settings_page
$option_name: wp_settings_options
wp_settings_section_shop_info: thong tin cua hang
    wp_setting_filed_name: Ten cua hang,
    wp_setting_filed_phone: SDT cua hang,
    wp_setting_filed_email: Email cua hang,
wp_settings_section_payment: thong tin thanh toan
    wp_setting_filed_bank_name: Ten ngan hang,
    wp_setting_filed_bank_number: so tai khoan ngan hang,
    wp_setting_filed_bank_user: ten chu tai khoan,

*/
add_action('admin_init','wp_setting_init');
function wp_setting_init(){
  /*register_setting('wporg','wporg_options');
  add_settings_section(string $id, string $title, callable $callback, string $page)
  add_setting_field
  */
  register_setting('wp_settings_page','wp_setting_options');

  add_settings_section(
    'wp_setting_section_shop_info',
    'Cửa hàng',
    'wp_setting_section_shop_info_callback',
    'wp_setting_page',
  );
      add_settings_field(
        'wp_setting_field_name',
        'Tên của cửa hàng',
        'wp_setting_field_render',
        'wp_setting_page',
        'wp_setting_section_shop_info',
        [
          'label_for'=>'wp_setting_field_email',
          'type' => 'text',
          'class' => 'form-control'
        ]
      );
      add_settings_field(
        'wp_setting_field_phone',
        'Số điện thoại của cửa hàng',
        'wp_setting_field_render',
        'wp_setting_page',
        'wp_setting_section_shop_info',
        [
          'label_for'=>'wp_setting_field_phone',
          'type' => 'text',
          'class' => 'form-control'
        ]
      );
      add_settings_field(
        'wp_setting_field_email',
        'Email của cửa hàng',
        'wp_setting_field_render',
        'wp_setting_page',
        'wp_setting_section_shop_info',
        [
          'label_for'=>'wp_setting_field_email',
          'type' => 'text',
          'class' => 'form-control'
        ]
      );
  add_settings_section(
    'wp_setting_section_payment',
    'Thanh toán',
    'wp_setting_section_payment_callback',
    'wp_setting_page'
  );
      add_settings_field(
        'wp_setting_field_bank_name',
        'Tên ngân hàng',
        'wp_setting_field_render',
        'wp_setting_page',
        'wp_setting_section_payment',
        [
          'label_for'=>'wp_setting_field_bank_name',
          'type' => 'text',
          'class' => 'form-control'
        ]
      );
      add_settings_field(
        'wp_setting_field_bank_number',
        'Số tài khoản ngân hàng',
        'wp_setting_field_render',
        'wp_setting_page',
        'wp_setting_section_payment',
        [
          'label_for'=>'wp_setting_field_bank_number',
          'type' => 'text',
          'class' => 'form-control'
        ]
      );
      add_settings_field(
        'wp_setting_field_bank_user',
        'Chủ tài khoản ngân hàng',
        'wp_setting_field_render',
        'wp_setting_page',
        'wp_setting_section_payment',
        [
          'label_for'=>'wp_setting_field_bank_user',
          'type' => 'text',
          'class' => 'form-control'
        ]
      );
}
function wp_setting_section_shop_info_callback(){
  echo '<p>Thông tin cửa hàng</p>';
}
function wp_setting_section_payment_callback(){
  echo '<p>Thông tin thanh toán</p>';
}
function wp_setting_field_render($args){
  $type = isset($args['type'])?$args['type']:'text';
  $options = get_option('wp_settings_options');
  switch($type){
    case 'text':
      ?>
      <input type="text" 
      name="wp_settings_options[<?php $args['label_for'];?>]"
      value="<?php $options[$args['label_for']];?>"
      placeholder="Nhap vao day"
      >
      <?php
      break;
    case 'password':
      ?>
      <input type="password" 
      name="wp_settings_options[<?php $args['label_for'];?>]"
      value="<?php $options[$args['label_for']];?>"
      placeholder="Nhap vao day"
      >
      <?php
      break;  
    default:
      break;
  }
}