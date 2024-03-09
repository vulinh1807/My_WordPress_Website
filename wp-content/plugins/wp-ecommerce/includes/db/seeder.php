<?php
//chen dl mau
global $wpdb;
//$charset_collate = $wpdb->get_charset_collate();
$tbl_orders = $wpdb->prefix.'wp_orders';
$tbl_orders_detail=$wpdb->prefix.'wp_orders_detail';

//chen du lieu
$orders = [
  [
    'created' => '2023-04-02',
    'total' => '20000',
    'status' => 'pending',
    'payment_method' => 'cod',
    'customer_name' => 'NVA',
    'customer_phone' => '012345789',
    'customer_email' => 'NVA@gmail.com',
    'customer_address' => 'QT',
    'note' => 'Giao nhanh',
  ],
  [
    'created' => '2023-04-02',
    'total' => '20000',
    'status' => 'pending',
    'payment_method' => 'cod',
    'customer_name' => 'NVB',
    'customer_phone' => '012345789',
    'customer_email' => 'NVA@gmail.com',
    'customer_address' => 'QT',
    'note' => 'Giao nhanh',
  ],
  [
    'created' => '2023-04-02',
    'total' => '20000',
    'status' => 'pending',
    'payment_method' => 'cod',
    'customer_name' => 'NVC',
    'customer_phone' => '012345789',
    'customer_email' => 'NVA@gmail.com',
    'customer_address' => 'QT',
    'note' => 'Giao nhanh',
  ]
  ];
foreach($orders as $order);
{
  $wpdb -> insert($tbl_orders,$order);
}

$orders_detail = [
    [
      'order_id' => 1,
      'product_id' => 1,
      'quantity' => 1,
      'price' => 1000,
    ],
    [
      'order_id' => 2,
      'product_id' => 1,
      'quantity' => 1,
      'price' => 1000,
    ],
    [
      'order_id' => 3,
      'product_id' => 1,
      'quantity' => 1,
      'price' => 1000,
    ],
  ];
foreach ($orders_detail as $detail) {
  # code...
  $wpdb -> insert($tbl_orders_detail,$detail);
}