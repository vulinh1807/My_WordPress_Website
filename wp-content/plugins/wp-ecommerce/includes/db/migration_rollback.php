<?php
global $wpdb;
$tbl_orders = $wpdb->prefix.'wp_orders';
$tbl_orders_detail=$wpdb->prefix.'wp_order_detail';

$sql = "DROP TABLE IF EXISTS $tbl_orders_detail";
$wpdb -> query($sql);

$sql = "DROP TABLE IF EXIST $tbl_orders";
$wpdb ->query($sql);
