<?php
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 1;
if($order_id)
{
  $objWpOrder = new wp_orders();
  $order = $objWpOrder->find($order_id);
  $order_items = $objWpOrder->order_items($order_id);
}
if(isset($_POST['wp_save_orders']))
{
    check_admin_referer('wp_update_orders');
    //nguoi dung dang save
    $order_status = isset($_REQUEST['$order_status'])?$_REQUEST['$order_status'] : '';
    $note = isset($_REQUEST['$note'])?$_REQUEST['$note'] : '';
    $note = sanitize_text_field($note);

    $order_id = isset($_REQUEST['$order_id'])?$_REQUEST['$order_id'] : 0;
    $objWpOrder->update($order_id,[
        'status' => $order_status,
        'note' => $note,
    ]);
    wp_redirect('admin.php?page=wp-orders$order_id='.$order_id);
    exit();
}
?>
<style>
table.form-table.bordered th,table.form-table.bordered td {
    border: 1px solid #ccc;
    text-align: center;
}
</style>
<div class="wrap">
<h1 class="wp-heading-inline">Chi tiết đơn hàng: <?php $order->id; ?></h1>
<form id="posts-filter" method="post">
    <?php wp_nonce_field('wp_update_orders') ?>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <!-- Left columns -->
            <div id="post-body-content">
                <!-- Thông tin đơn hàng -->
                <div class="postbox ">
                    <div class="postbox-header">
                        <h2 class="hndle ui-sortable-handle">Thông tin đơn hàng</h2>
                    </div>
                    <div class="inside">
                        <table class="form-table  ">
                            <tr>
                                <td>Mã đơn</td>
                                <td> <?php $order->$id; ?></td>
                            </tr>
                            <tr>
                                <td>Ngày đặt hàng</td>
                                <td> <?php date('d-m-Y',strtotime($order->$created)); ?> </td>
                            </tr>
                            <tr>
                                <td>Tên khách hàng</td>
                                <td> <?php $order->$customer_name; ?> </td>
                            </tr>
                            <tr>
                                <td>Số điện thoại</td>
                                <td> <?php $order->$customer_phone; ?> </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td> <?php $order->$customer_email; ?> </td>
                            </tr>
                            <tr>
                                <td>Địa chỉ</td>
                                <td> <?php esc_html($order->$customer_address); ?> </td>
                            </tr>
                            <tr>
                                <td>Ghi chú</td>
                                <td>
                                    <p><?php esc_html($order_items->note); ?></p>
                                    <textarea rows="5" class="large-text" name="note">
                                        <?php $order->$note ?>
                                    </textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- Chi tiết đơn hàng -->
                <div class="postbox ">
                    <div class="postbox-header">
                        <h2 class="hndle">Chi tiết đơn hàng</h2>
                    </div>
                    <div class="inside">
                        <table class="form-table bordered">
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                            </tr>
                            <?php foreach($order_items as $items): ?>
                            <tr>
                                <td><?php $items->$product_id; ?></td>
                                <td><?php $items->$product_name; ?></td>
                                <td><?php $items->$quantity; ?></td>
                                <td><?php number_format($items->$price); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Right columns -->
            <div id="postbox-container-1">
                <div class="postbox">
                    <div class="postbox-header">
                        <h2 class="hndle">Hành động</h2>
                    </div>
                    <div class="inside">
                        <div class="submitbox">
                            <p>
                                <select name="order_status" class="large-text ">
                                <option <?php $order->$status == 'pending' ? 'selected' : ''; ?> selected="" value="pending">Đơn hàng mới</option>
                                <option <?php $order->$status == 'completed' ? 'selected' : ''; ?> value="completed">Đơn đã hoàn thành</option>
                                <option <?php $order->$status == 'canceled' ? 'selected' : ''; ?> value="canceled">Đơn đã hủy</option>
                                </select>
                            </p>
                            <p>
                                <input type="submit" name="wp_orders_save" id="submit" class="button button-primary"
                                    value="Lưu thay đổi">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>