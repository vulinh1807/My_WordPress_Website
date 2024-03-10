<?php
add_action('rest_api_init','mywp_apis');
function mywp_apis(){
  $namespace = 'wp-ecommerce';
  $base = '/orders';
  //localhost:8888/?rest_route=/wp-ecommerce/orders
  register_rest_route($namespace,$base,[
    [
      'methods' => WP_REST_Server::READABLE, //Get
      'callback' => 'mywp_apis_order_all'
    ],
    [
      'methods' => WP_REST_Server::CREATABLE, //post
      'callback' => 'mywp_apis_order_store'
    ],
    ]);
    //localhost:8888/?rest_route=/wp-ecommerce/orders/5
    register_rest_route($namespace,$base.'/(?P<id>[\d]+)',[
      [
        'methods' => WP_REST_Server::READABLE, //get
        'callback' => 'mywp_apis_order_show'
      ],
      [
        'methods' => WP_REST_Server::EDITABLE, //put
        'callback' => 'mywp_apis_order_update'
      ],
      [
        'methods' => WP_REST_Server::DELETABLE, //put
        'callback' => 'mywp_apis_order_destroy'
      ],
    ]);
    register_rest_route($namespace,$base.'/(?P<id>[\d]+)/order_items',[
      'methods' => WP_REST_Server::READABLE, //get
      'callback' => 'mywp_apis_order_order_show'
    ]);
}
//GET - /orders - lay toan bo orders
function mywp_apis_order_all($request){
  $objWpOrder = new mywp_orders();
  $result = $objWpOrder -> paginate(5);
  //echo json_encode($result);
  $data = [
    'success' => true,
    'data' => $result 
  ];
  return new WP_REST_Response($data,200);
}
//POST - /orders - them moi order
function mywp_apis_order_store($request){
  $objWpOrder = new mywp_orders();
  $saved = $objWpOrder -> save($_POST);
  $data = [
    'success' => true,
    'data' => $saved,

  ];
  return new WP_REST_Response($data,200);
}
//GET - /orders/{id} - lay chi tiet order theo tham so id
function mywp_apis_order_show($request){
  $id = $request['id'];
  $objWpOrder = new mywp_orders();
  $item = $objWpOrder -> find($id);
  $data = [
    'success' => true,
    'data' => $item,
  ];
  return new WP_REST_Response($data,200);
}
function mywp_apis_order_update($request){
  $id = $request['id'];
  $objWpOrder = new mywp_orders();
  $saved = $objWpOrder->update($id,$_POST);
  $data=[
    'success' => true,
    'data' => $saved,
  ];
  return new WP_REST_Response($data,200);
}
function mywp_apis_order_destroy($request){
  $id = $request['id'];
  $objWpOrder = new mywp_orders();
  $saved = $objWpOrder->destroy($id);
  $data = [
    'success' => true
  ];
  return new WP_REST_Response($data,200);
}
function mywp_apis_order_order_show($request){
  $id = $request['id'];
  $data = [
    'success' => true,
    'message' => 'ban da lay ket qua cua order_id '.$id.' thanh cong'
  ];
  return new WP_REST_Response($data,200);
}