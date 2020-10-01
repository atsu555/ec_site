<?php
// 設定ファイル読み込み
require_once '../conf/const.php';
// 関数ファイル読み込み
require_once './model/common.php';
require_once './model/cart_model.php';

$err           = array();
$msg           = array();
$cart_data     = array();
$get_item_cart = array();
$sql_kind      = '';
$id            = '';
$item_id       = '';
$img_dir       = './img/';
$date          = date('Y-m-d H:i:s');

$regex         = '/[0-9]/';

session_start();
$user_name = $_SESSION['user_name'];
$user_id   = $_SESSION['user_id'];
try {
    // db接続
    $dbh = get_db_connect();
    echo 'データベースに接続しました';

     // リクエストメソッド
    if (get_request_method()=== 'POST') {
      // ポスト値の取得
      $sql_kind   = get_post_data('sql_kind');

      if ($sql_kind === 'delete_cart') {
        // postの取得
        $item_id = get_post_data('item_id');
// var_dump($item_id);
        check_item_id($item_id);
        if (count($err) === 0 ) {
          delete_ec_cart($dbh,$item_id,$user_id);
        }
      } else if ($sql_kind === 'change_cart') {
        // ポスト値の取得
        $amount = get_post_data('select_amount');
// var_dump($amount);
        $item_id     = get_post_data('item_id');
var_dump($item_id);
      }
        // 入力値チェック
        check_amount($amount);
        check_item_id($item_id);

        if (count($err) === 0) {
echo 'ok';
          update_amount($dbh,$item_id,$user_id,$amount,$date);


var_dump(update_amount($dbh,$item_id,$user_id,$amount,$date));
      } else if ($sql_kind === 'buy_cart') {
  echo 'OK';
        $get_item_cart = get_item_cart($dbh,$user_id);
var_dump($get_item_cart);
        $amount = $get_item_cart[0]['amount'];
var_dump($amount);
        $item_id  = $get_item_cart[0]['item_id'];
        decrease_stock($dbh,$item_id,$amount,$date);
        delete_ec_cart($dbh,$item_id,$user_id);
        exit;
      }
    }

// 表示
    // セレクト文は最後
    $cart_data = get_ec_cart_table($dbh,$user_id);
    $sum = sum_data($dbh,$user_id);

} catch (Exception $e) {
    $err[] = $e->getMessage();
}

// 商品一覧ファイル読み込み
include_once './view/cart_view.php';

