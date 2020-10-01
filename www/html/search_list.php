<?php
// 設定ファイル読み込み
require_once '../conf/const.php';
// 関数ファイル読み込み
require_once './model/common.php';
require_once './model/search_model.php';
$item_data          = array();
$err           = array();
$msg           = array();
$date          = date('Y-m-d H:i:s');
$img_dir       = './img/';
$item_id       = '';

session_start();
try {
    // db接続
    $dbh = get_db_connect();
    // ユーザーネームの表示
    $user_name = $_SESSION['user_name'];
    $user_id   = $_SESSION['user_id'];
     // postを確認する
var_dump(get_request_method());
    if (get_request_method() === 'POST') {
      // タイプの取得
      $type = get_post_type_data('type');
var_dump($type);     
      
      
      if ($type === '0') {
        type_data($dbh,$type);
      } else if ($type === 1) {
        type_data($dbh,$type);
      } else if ($type === 2) {
        type_data($dbh,$type);
      } else if ($type === 3) {
        type_data($dbh,$type);
      } else if ($type === 4) {
        type_data($dbh,$type);
      } else if ($type === 5) {
        type_data($dbh,$type);
      }
    }
   
    $typedata = type_data($dbh,$type);
var_dump($typedata);
    
} catch (Exception $e) {
  $err[] = $e->getMessage();
}

// 商品一覧ファイル読み込み
include_once './view/search_list_view.php';
