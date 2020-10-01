<!--検索ページ-->
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
  
} catch (Exception $e) {
  $err[] = $e->getMessage();
}

// 商品一覧ファイル読み込み
include_once './view/search_view.php';

