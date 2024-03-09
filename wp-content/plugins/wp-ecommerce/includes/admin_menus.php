<?php
add_action('admin_menu','wp_admin_menu');
function wp_admin_menu(){
  //them menu cha
  add_menu_page(
    'My plugin for e-com ',
    'Plugin for e-com',
    'manage_options',
    'my-plugin-wp-orders',//menu slug
    'wp_admin_page_dashboard',
    'dashicons-format-audio',
    25
  );
    add_submenu_page(
      'my-plugin-wp-orders',
      'Đơn hàng',
      'Đơn hàng',
      'manage_options',
      'wp-orders',
      'wp_admin_page_orders',
      26
    );
    add_submenu_page(
      'my-plugin-wp-orders',
      'Cấu hình',
      'Cấu hình',
      'manage_options',
      'wp-settings',
      'wp_admin_page_settings',
      26
    );
}

function wp_admin_page_dashboard(){
  include_once wp_ecom_PATH.'includes/admin_pages/dashboard.php';
}
function wp_admin_page_orders(){
  include_once wp_ecom_PATH.'includes/admin_pages/orders.php';
}
function wp_admin_page_settings(){
  include_once wp_ecom_PATH.'includes/admin_pages/settings.php';
}