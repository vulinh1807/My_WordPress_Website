<?php
// define(DB_HOST,"localhost");
// define(DB_NAME,"vulinh");
// define(DB_PASSWORD,"1234");
// if (!define(DB_NAME,"wp_orders")){
//   define(DB_NAME,"wp_orders");
// }
// $conn=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
// if(!$conn){
//   die("No connection");
// }
// echo "Connected!";
if(!define( 'DB_NAME', 'vulinh' )){
  define( 'DB_NAME', 'vulinh' );
}
if(!define( 'DB_USER', 'root' )){
  /** Database username */
  define( 'DB_USER', 'root' );
}
if(!define( 'DB_PASSWORD', '' )){
  /** Database password */
  define( 'DB_PASSWORD', '' );
}
if(!define( 'DB_HOST', 'localhost' )){
  /** Database hostname */
  define( 'DB_HOST', 'localhost' );
}
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if(!$conn){
  die("No connection!");
}else{
  echo "Connected!";
}
class mywp_orders{
  public $_orders = 'SELECT * FROM wp_orders';
  public $_orders_detail = 'SELECT * FROM  wp_orders_detail';
  public function __construct(){
    global $wpdb;
    $this -> _orders = $wpdb -> prefix.'wp_orders';//wp_orders
    $this -> _orders_detail = $wpdb -> prefix.'wp_orders_detail';//wp_orders_detail
  }
  public function all(){
    global $wpdb;
    //$sql = "SELECT * FROM $this->_orders";
    $sql = "SELECT * FROM wp_orders";
    $items = $wpdb->get_results($sql);
    return $items;
  }
  public function paginate($limit=20){
    global $wpdb;
    //print_r($_REQUEST);
    $s = isset($_REQUEST['s'])? $_REQUEST['s']:'';
    $status=isset($_REQUEST['status'])? $_REQUEST['status']:'';
    $paged=isset($_REQUEST['paged'])? $_REQUEST['paged']:1;

    //lay tong so records
    $sql = "SELECT count(id) FROM $this->_orders WHERE deleted = 0";
    //tim kiem
    if($s){
      $sql .= " AND (customer_name LIKE '%$s%' OR customer_phone LIKE '%$s%')";
    }
    if($status){
      $sql.= " AND status = '$status'";
    }
    $total_items = $wpdb->get_var($sql);
    //thuat toan phan trang
    /*
    limit: limit
    tong so trang: total_pages
    tinh offset
    */
    $total_pages = ceil($total_items / $limit);
    $offset = (int)$paged * (int)$limit - (int)$limit;

    //$sql = "SELECT * FROM $this->_orders WHERE deleted = 0";
    $sql = "SELECT * FROM wp_orders WHERE deleted=0";
    //tim kiem
     if($s){
      $sql .= " AND (customer_name LIKE '%$s%' OR customer_phone LIKE '%$s%')";
    }
    if($status)
    {
      $sql .= "AND status = '$status'";
    }
    $sql .="ORDER BY id DESC";
    $sql .="LIMIT $limit OFFSET $offset";

    $items = $wpdb->get_results($sql);
    return [
      'total_pages'=> $total_pages,
      'total_items'=>$total_items,
      'items' => $items
    ];
  }
  public function find($id){
    global $wpdb;
    //$sql = "SELECT * FROM $this->_orders WHERE id = $id";
    $sql = "SELECT * FROM wp_orders WHERE id.wp_orders = $id";
    $item = $wpdb -> get_row($sql);
    return $item;
  }
  public function save($data){
    global $wpdb;
    $wpdb->insert($this->_orders,$data);
    $lastId = $wpdb -> insert_id;
    $item = $this->find($lastId);
    return $item;
  }
  public function update($id,$data){
    global $wpdb;
    $wpdb->update($this->_orders,$data,['id' => $id]);
    $item = $this -> find($id);
    return $item;
  }
  public function trash($id){
    global $wpdb;
    $wpdb->update(
      $this->_orders,
      ['delete'=> 1],
      ['id'=>$id]
    );
    return true;
  }
  public function destroy($id){
    global $wpdb;
    $wpdb->delete($this->_orders,['id'=>$id]);
    return true;
  }
  public function change_status($order_id,$status){
    global $wpdb;
    $wpdb->update(
      $this->_orders,
      [
        'status'=> $status
      ],
      ['id'=>$order_id]);
    return true;
  }
  public function order_items($order_id)
  {
    global $wpdb;
    $sql = "SELECT product.post_title as product_name,order_detail.* FROM $this->_orders_detail as order_detail
    JOIN $wpdb->posts as products ON products.ID = order_detail.product_id
    WHERE order_detail.order_id = $order_id
    ORDER BY order_detail.id DESC";
    $items = $wpdb -> get_results($sql);
    return $items;
  }
}