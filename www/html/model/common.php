<?php
// db接続
function get_db_connect(){
  // MySQL用のDSN文字列
  $dsn = 'mysql:dbname='. DB_NAME .';host='. DB_HOST .';charset='.DB_CHARSET;
  try {
    // データベースに接続
    $dbh = new PDO($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    exit('接続できませんでした。理由：'.$e->getMessage() );
  }
  return $dbh;
}

// post値取得
function get_post_data($key) {
    $str = ' ';
    if (isset($_POST[$key]) === TRUE) {
        $str = trim($_POST[$key]);
    }
    return $str;
}

// is_int(int型)
function get_post_data_int($key) {
    $str = get_post_data($key);
    if (isset($_POST[$key]) === TRUE) {
        $str = is_int($str);
    }
    return $str;
}


// リクエストメソッド
function get_request_method() {
    return $_SERVER['REQUEST_METHOD'];
}

//
function entity_str($str) {
  return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

// データ取り出し
function item_data($dbh) {
  global $err;
  try {
    // データベース取得
    $sql = 'SELECT
            *
            FROM ec_item_master
            INNER JOIN ec_item_stock
            ON ec_item_master.item_id = ec_item_stock.item_id';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    return $rows;
  } catch (Exception $e) {
      $err[] = $e->getMessage();
  }
}

function user_data($dbh) {
  global $err;
  try {
    // データベース取得
    $sql = 'SELECT
            *
            FROM ec_user';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    return $rows;
  } catch (Exception $e) {
      $err[] = $e->getMessage();
  }
}

// 合計金額
function sum_data($dbh,$user_id) {
  try {
    $sql = 'SELECT
              sum(price * amount)
            FROM
              ec_cart
            INNER JOIN
              ec_item_master
            ON
              ec_cart.item_id = ec_item_master.item_id
            WHERE
              user_id = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1,$user_id, PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    return $rows;
  } catch (Exception $e) {
    $err[] = $e->getMessage();
  }

}

function execute_query($dbh, $sql, $params = array()){
  try{
    $statement = $dbh->prepare($sql);
    return $statement->execute($params);
  }catch(PDOException $e){
    $err[] =  $e->getMessage();
  }
  return false;
}

function fetch_all_query($dbh, $sql, $params = array()){
  try{
    $statement = $dbh->prepare($sql);
    $statement->execute($params);
    return $statement->fetchAll();
  }catch(PDOException $e){
    $err[] = 'データ取得に失敗しました。';
  }
  return false;
}

// ログインチェック
function check_login_user_id() {
  if (isset($_SESSION['user_id']) === true){
      return $_SESSION['user_id'];
  } else {
      header('Location: login.php');
      exit;
  }
}

function check_login_user_name() {
  if (isset($_SESSION['user_name']) === true){
      return $_SESSION['user_name'];
  } else {
      header('Location: logout.php');
      exit;
  }
}

function check_admin() {
  if (isset($_SESSION['user_id']) === true){
      if($_SESSION['user_id'] !== 'admin') {
          header('Location: login.php');
          exit;
      }
  } else {
      header('Location: login.php');
      exit;
  }
}
