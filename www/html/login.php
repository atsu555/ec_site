<?php
// 設定ファイル読み込み
require_once '../conf/const.php';
// 関数ファイル読み込み
require_once './model/common.php';
require_once './model/login_model.php';

$err           = array();
$msg           = array();
$select_user   = array();
$sql_kind      = '';
$user_name     = '';
$password      = '';
$date          = date('Y-m-d H:i:s');

$regex         = "/^[a-zA-Z0-9]{6,}$/";
session_start();
try {
    // db接続
    $dbh = get_db_connect();

    // リクエストメソッド
    if (get_request_method()=== 'POST') {
      // 入力データの取得
      $user_name   = get_post_data('user_name');
      $user_name   = entity_str($user_name);
      $password    = get_post_data('password');
      $password    = entity_str($password);

      if ($user_name === 'admin' && $password === 'admin') {
        $_SESSION['user_id'] = 'admin';
        header ('Location: admin.php');
        exit;
      }
      // 入力データのチェック
      // 入力値チェック
      check_user_name($user_name,$regex);
      check_password($password,$regex);
      // エラーが０のときにデータベースの確認をする
      if (count($err) === 0) {
        // エラーがあった場合は戻す
        // データがあれば.itemlist.phpにジャンプする
        // useridリスト
        $select_user = select_user($dbh,$user_name,$password);
        // セッション変数からログイン済みか確認
        // 登録データを取得できたか確認
        if (isset($select_user[0]['user_id'])) {
          // セッション変数にuser_idを保存
          $_SESSION['user_id']   = $select_user[0]['user_id'];
          $_SESSION['user_name'] = $select_user[0]['user_name'];
          // var_dump($_SESSION['user_id']);
          // ログイン済みユーザのホームページへリダイレクト
          header('Location: itemlist.php');
          exit;
        } else {
          // ログインページへリダイレクト
          $err[] = '該当ユーザーがいません';
        }
      }

      // var_dump($_SESSION['user_id']);

      // なければエラーを用意する
    var_dump($select_user);


    }

print_r($err);

} catch (Exception $e) {
  $err[] = $e->getMessage();
}

// 商品一覧ファイル読み込み
include_once './view/login_view.php';

