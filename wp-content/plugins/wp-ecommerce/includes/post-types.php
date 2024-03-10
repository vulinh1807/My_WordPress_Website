<?php
//dang ky loai bai viet san pham
add_action('init','mywp_custom_post_type');
function mywp_custom_post_type() {
  register_post_type('product',
  array(
    'labels' => array(
          'name' => __('Cac san pham','wp-ecommerce'),
          'singular_name' => __('San pham','wp-ecommerce'),
    ),
    'public' => true,
    'has_archive' => true,
    'rewrite' => array('slug' => 'products'),
    'supports' => array('title','editor','thumbnail','excerpt'),
    )
  );
}

//dang ky loai taxonomy
add_action('init','mywp_register_taxonomy_product');
function mywp_register_taxonomy_product() {
  $labels = array (
    'name' => _x('Danh muc','taxonomy general name'),
    'singular_name' => _x('Danh muc','taxonomy singular name'),
    'search_items' => __('Search danh muc'),
    'all_items' => __('All danh muc'),
    'parent_item' => __('Parent danh muc'),
    'parent_item_colon' => __('Parent danh muc'),
    'edit_item' => __('Edit danh muc'),
    'update_item' => __('Update danh muc'),
    'add_new_item' => __('Add danh muc moi'),
    'new_item_name' => __('Ten danh muc moi'),
    'menu_item' => __('Danh muc'),
  );
  $args = array(
    'hierarchical' => true,// make it hierarchical (like categories)
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => ['slug'=>'course'],
  );
  register_taxonomy('product_cat',['product'],$args);
}