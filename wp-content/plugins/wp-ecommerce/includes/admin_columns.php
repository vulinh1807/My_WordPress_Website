<?php
//hien thi cac cot cua posttype san pham
add_filter('manage_product_posts_columns','wp_admin_columns_product_filter_columns');
function wp_admin_columns_product_filter_columns($columns){
  $columns['product_price'] = 'Gia ban';
  $columns['product_price_sale'] = 'Gia khuyen mai';
  $columns['product_stock'] = 'So luong';
  return $columns;
}
//hien thi gia tri tren cac cot
add_action('manage_product_posts_custom_column','wp_admin_columns_product_render_columns',10,2);
function wp_admin_columns_product_render_columns($column, $post_id){
  switch ($column){
    case 'product_price':
      $product_price=get_post_meta($post_id->ID,'product_price',true);
      echo number_format($product_price);
      break;
    case 'product_price_sale':
      $product_price_sale = get_post_meta($post_id->ID,'product_price_sale',true);
      echo number_format($product_price_sale);
      break;
    case 'product_stock':
      $product_stock = get_post_meta($post_id->ID,'product_stock',true);
      echo number_format($product_stock);
      break;
  }
}

//hien thi cac cot cua taxonomy product_cat
add_filter('manage_edit-product_cat_columns','wp_admin_columns_taxonomy_filter_columns');
function wp_admin_columns_taxonomy_filter_columns($columns){
  $columns['image'] = 'Image';
  return $columns;
}

//hien thi gia tri cot 
add_action('manage_product_cat_custom_column','wp_admin_columns_taxonomy_render_columns',10,3);
function wp_admin_columns_taxonomy_render_columns($out,$column,$term_id){
  if($column=='image'){
    $image = get_term_meta($term_id,'image',true);
    echo $image;
  }
}