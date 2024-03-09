<?php
//product screem: man hinh chinh them/sua san pham
add_action('add_meta_boxes','wp_meta_box_product');

//can thiep vao hanh dong luu bai viet
add_action('save_post','wp_save_post_product');
function wp_save_post_product($post_id) {
  if($_REQUEST['post_type']=='product'){
    //var_dump($post_id);die();
    if(isset($_REQUEST['product_price'])){
      //luu vao csdl:post-meta
      $product_price = $_REQUEST['product_price'];
      update_post_meta($post_id,'product_price',$product_price);
    }
    if(isset($_REQUEST['product_price_sale'])){
      $product_price_sale = $_REQUEST['product_price_sale'];
      update_post_meta($post_id,'product_price_sale',$product_price_sale);
    }
    if(isset($_REQUEST['product_stock'])){
      $product_stock = $_REQUEST['product_stock'];
      update_post_meta($post_id,'product_stock',$product_stock);
    }
  }
}
function wp_meta_box_product() {
  add_meta_box(
    'wpecomm_product_info',
    'thong tin san pham',
    'wpecomm_meta_box_product_html',
    'product'
  );
}
function wpecomm_meta_box_product_html() {
  //echo '<h1>Thong tin san pham</h1>';
  include_once wp_ecom_PATH.'includes/templates/meta_box_product.php';
}
//category screen
//dang ky them truong cho taxonomy

//them o input vao form add
add_action('product_cat_add_form_fields','wp_form_fields_add');
function wp_form_fields_add(){
  include_once wp_ecom_PATH.'includes/templates/meta_box_product_cat_add.php';
}

//them o input vao form edit
add_action('product_cat_edit_form_fields','wp_form_fields_edit',10,2);
function wp_form_fields_edit($tag,$taxonomy){
    include_once wp_ecom_PATH.'includes/templates/meta_box_product_cat_edit.php';
  }
  
  //xu ly luu term: save, insert, delete, get
  add_action('saved_term','wp_product_cat_saved_term',10,1); 
  function wp_product_cat_saved_term($term_id){
    $image = $_REQUEST['image'];
    update_term_meta($term_id,'image',$image);   
}
