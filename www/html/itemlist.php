<?php
// 設定ファイル読み込み
require_once '../conf/const.php';
// 関数ファイル読み込み
require_once './model/common.php';
require_once './model/itemlist_model.php';
$item_data     = array();
$err           = array();
$msg           = array();
$date          = date('Y-m-d H:i:s');
$img_dir       = './img/';
$item_id       = '';

session_start();
$user_id   = check_login_user_id();
$user_name = check_login_user_name();

try {
    // db接続
    $dbh = get_db_connect();
    // postを確認する
    if (get_request_method() === 'POST') {
      $sql_kind   = get_post_data('sql_kind');
      if ($sql_kind === 'insert_cart') {
         // アイテムidの取得
         $item_id    = get_post_data('item_id');

         $get_item_data  = get_item_data($dbh,$item_id);
         // チェックする
         check_item_id($item_id);

         // エラーが０の時に
         if (count($err) === 0) {
            //  idの有無
             $get_ec_cart = get_ec_cart($dbh,$item_id,$user_id);

             if (count($get_ec_cart) > 0) {
              $update_cart = update_ec_cart($dbh,$user_id,$item_id,$date);
             } else {
              $insert_cart  = insert_ec_cart($dbh,$user_id,$item_id,$date);
             }

         }




        }
    }

    $item_data = item_data($dbh);
    // var_dump($item_data);
} catch (Exception $e) {
  $err[] = $e->getMessage();
}

// 商品一覧ファイル読み込み
include_once './view/itemlist_view.php';

