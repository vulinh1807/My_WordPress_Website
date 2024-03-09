<?php
add_action('rest_api_init','wp_apis');
function wp_apis(){
  $namespace = 'wp-ecommerce/v1';
  $base = '/orders';
  //localhost:8888/?rest_route=/wp-ecommerce/orders
  register_rest_route($namespace,$base,[
    [
      'methods' => WP_REST_Server::READABLE, //Get
      'callback' => 'wp_apis_order_all'
    ],
    [
      'methods' => WP_REST_Server::CREATABLE, //post
      'callback' => 'wp_apis_order_store'
    ],
    ]);
    //localhost:8888/?rest_route=/wp-ecommerce/orders/5
    register_rest_route($namespace,$base.'/(?P<id>[\d]+)',[
      [
        'methods' => WP_REST_Server::READABLE, //get
        'callback' => 'wp_apis_order_show'
      ],
      [
        'methods' => WP_REST_Server::EDITABLE, //put
        'callback' => 'wp_apis_order_update'
      ],
      [
        'methods' => WP_REST_Server::DELETABLE, //put
        'callback' => 'wp_apis_order_destroy'
      ],
    ]);
    register_rest_route($namespace,$base.'/(?P<id>[\d]+)/order_items',[
      'methods' => WP_REST_Server::READABLE, //get
      'callback' => 'wp_apis_order_order_show'
    ]);
}
//GET - /orders - lay toan bo orders
function wp_apis_order_all($request){
  $objWpOrder = new Wp_Order();
  $result = $objWpOrder -> paginate(5);
  //echo json_encode($result);
  $data = [
    'success' => true,
    'data' => $result 
  ];
  return new WP_REST_Response($data,200);
}
//POST - /orders - them moi order
function wp_apis_order_store($request){
  $objWpOrder = new Wp_Order();
  $saved = $objWpOrder -> save($_POST);
  $data = [
    'success' => true,
    'data' => $saved,

  ];
  return new WP_REST_Response($data,200);
}
//GET - /orders/{id} - lay chi tiet order theo tham so id
function wp_apis_order_show($request){
  $id = $request['id'];
  $objWpOrder = new Wp_Order();
  $item = $objWpOrder -> find($id);
  $data = [
    'success' => true,
    'data' => $item,
  ];
  return new WP_REST_Response($data,200);
}
function wp_apis_order_update($request){
  $id = $request['id'];
  $objWpOrder = new Wp_Order();
  $saved = $objWpOrder->update($id,$_POST);
  $data=[
    'success' => true,
    'data' => $saved,
  ];
  return new WP_REST_Response($data,200);
}
function wp_apis_order_destroy($request){
  $id = $request['id'];
  $objWpOrder = new Wp_Order();
  $saved = $objWpOrder->destroy($id);
  $data = [
    'success' => true
  ];
  return new WP_REST_Response($data,200);
}
function wp_apis_order_order_show($request){
  $id = $request['id'];
  $data = [
    'success' => true,
    'message' => 'ban da lay ket qua cua order_id '.$id.' thanh cong'
  ];
  return new WP_REST_Response($data,200);
}