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
try {
    // db接続
    $dbh = get_db_connect();
    echo 'データベースに接続しました';
    // ユーザーネームの表示
    $user_id    = $_SESSION['user_id'];
    $user_name  = $_SESSION['user_name'];
    
    $cart_data = get_ec_cart_table($dbh,$user_id);
    
    // ￥合計金額
    $sum = sum_data($dbh,$user_id);
    
    
} catch (Exception $e) {
  $err[] = $e->getMessage();
}

// 商品一覧ファイル読み込み
include_once './view/finish_view.php';

