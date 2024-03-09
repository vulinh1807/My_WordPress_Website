<?php 
//tao bang
require_once(ABSPATH.'wp-admin/includes/upgrade.php');
//dbdelta
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$wp_orders = $wpdb->prefix.'wp_orders';
$wp_orders_detail=$wpdb->prefix.'wp_orders_detail';

$sql = "
CREATE TABLE '$wp_orders' (
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'created' date DEFAULT NULL,
  'total' double DEFAULT NULL,
  'status' varchar(255) DEFAULT 'pending',
  'payment_method' varchar(255) DEFAULT NULL,
  'customer_name' varchar(255) DEFAULT NULL,
  'customer_phone' varchar(255) DEFAULT NULL,
  'customer_email' varchar(255) DEFAULT NULL,
  'customer_address' varchar(255) DEFAULT NULL,
  'note' text DEFAULT NULL,
  'deleted' tinyint(4) DEFAULT '0',
  PRIMARY KEY (id)
) " . $charset_collate . ";" ;
dbDelta($sql);

$sql = "CREATE TABLE '$wp_orders_detail' (
  'id' int(11) NOT NULL,
  'product_id' int(11) NOT NULL,
  'order_id' int(11) NOT NULL,
  'quantity' int(11) NOT NULL,
  'price' double NOT NULL,
   PRIMARY KEY (id)
)" . $charset_collate . ";" ;
dbDelta($sql);