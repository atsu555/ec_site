<?php
// 設定ファイル読み込み
require_once '../conf/const.php';
// 関数ファイル読み込み
require_once './model/common.php';
require_once './model/cart_model.php';

$err           = array();
$msg           = array();
$sql_kind      = '';
$new_name      = '';
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

    $cart_data = get_ec_cart_table($dbh,$user_id);
    $sum = sum_data($dbh,$user_id);
    var_dump($cart_data);



    if (get_request_method()=== 'POST') {

      // ポスト値の取得
      $sql_kind   = get_post_data('sql_kind');

      if ($sql_kind === 'buy_cart') {

              $amount = $cart_data[0]['amount'];

              $item_id  = $cart_data[0]['item_id'];
              decrease_stock($dbh,$item_id,$amount,$date);
              delete_ec_cart($dbh,$item_id,$user_id);

      }

    }

    // 購入履歴を作りデータを取得し、finish.phpにデータを反映させる


} catch (Exception $e) {
  $err[] = $e->getMessage();
}

// 商品一覧ファイル読み込み
include_once './view/finish_view.php';

