<?php
// 設定ファイル読み込み
require_once '../conf/const.php';
// 関数ファイル読み込み
require_once './model/common.php';
require_once './model/register_model.php';

$err           = array();
$msg           = array();
$user_name     = '';
$password      = '';
$sql_kind      = '';
$date          = date('Y-m-d H:i:s');
// バリデーション
$regex         = "/^[a-zA-Z0-9]{6,}$/";

try {
    // db接続
    $dbh = get_db_connect();
    // echo 'データベースに接続しました';

    // リクエストメソッド
    if (get_request_method()=== 'POST') {
        // 入力データの取得
        $user_name   = get_post_data('user_name');
        $user_name   = entity_str($user_name);
        $password    = get_post_data('password');
        $password    = entity_str($password);

        // 入力値チェック
        check_user_name($user_name,$regex);

        check_password($password,$regex);

        if (count($err) === 0) {
            // ユーザー情報追加
            insert_user_id($dbh,$user_name,$password,$date);
            // .login.phpへジャンプ
            header("Location:login.php");
            exit;
        }
    }


   var_dump($err);



} catch (Exception $e) {
  $err[] = $e->getMessage();
}

// 商品一覧ファイル読み込み
include_once './view/register_view.php';

