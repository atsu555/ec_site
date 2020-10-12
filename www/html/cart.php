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
$user_id   = check_login_user_id();
$user_name = check_login_user_name();

try {
    // db接続
    $dbh = get_db_connect();

     // リクエストメソッド
    if (get_request_method()=== 'POST') {
      // ポスト値の取得
      $sql_kind   = get_post_data('sql_kind');

      if ($sql_kind === 'delete_cart') {
        // postの取得
        $item_id = get_post_data('item_id');
var_dump($item_id);
        check_item_id($item_id);
        if (count($err) === 0 ) {
          delete_ec_cart($dbh,$item_id,$user_id);
        }
      } else if ($sql_kind === 'change_cart') {
        // ポスト値の取得
        $amount = get_post_data('select_amount');

        $item_id     = get_post_data('item_id');
var_dump($item_id);
      }
        // 入力値チェック
        check_amount($amount);
        check_item_id($item_id);
        

        if (count($err) === 0) {

          update_amount($dbh,$item_id,$user_id,$amount,$date);

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

