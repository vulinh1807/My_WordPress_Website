<?php
add_action('admin_menu','mywp_admin_menu');
function mywp_admin_menu(){
  //them menu cha
  add_menu_page(
    'My plugin for e-com ',
    'Plugin for e-com',
    'manage_options',
    'my-plugin-wp-orders',//menu slug
    'mywp_admin_page_dashboard',
    'dashicons-format-audio',
    25
  );
    add_submenu_page(
      'my-plugin-wp-orders',
      'Đơn hàng',
      'Đơn hàng',
      'manage_options',
      'mywp-orders',
      'mywp_admin_page_orders',
      26
    );
    add_submenu_page(
      'my-plugin-wp-orders',
      'Cấu hình',
      'Cấu hình',
      'manage_options',
      'mywp-settings',
      'mywp_admin_page_settings',
      26
    );
}

function mywp_admin_page_dashboard(){
  include_once mywp_ecom_PATH.'includes/admin_pages/dashboard.php';
}
function mywp_admin_page_orders(){
  include_once mywp_ecom_PATH.'includes/admin_pages/orders.php';
}
function mywp_admin_page_settings(){
  include_once mywp_ecom_PATH.'includes/admin_pages/settings.php';
}