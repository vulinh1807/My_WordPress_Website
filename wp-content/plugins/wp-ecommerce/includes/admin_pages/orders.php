<?php
$objWpOrder = new mywp_orders();
$result = $objWpOrder->paginate(2);
//$items = $result['items'];
// $total_items = $result['total_items'];
// $total_pages = $result['total_pages'];
extract($result);
/*
items
total-pages
total-items
*/
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
if ($action == 'trash') {
    $orderIds = $_REQUEST['post'];
    if (count($orderIds)) {
        foreach ($orderIds as $orderId) {
            $objWpOrder->trash($orderId);
        }
    }
    mywp_redirect('admin.php?page=wp-orders');
    exit();
}
if (isset($_GET['order_id']) && $_GET['order_id'] != '') {
    include mywp_ecom_PATH . 'includes/admin_pages/orders/edit.php';
} else {
    include mywp_ecom_PATH . 'includes/admin_pages/orders/list.php';
}


