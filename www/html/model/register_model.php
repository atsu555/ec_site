<?php
// 入力値チェック
// ユーザーid
function check_user_name($user_name,$regex) {
    global $err;
    if ($user_name === '') {
        $err[''] = 'ユーザー名を入力してください';
    } else if (preg_match($regex, $user_name) !== 1) {
        $err[''] = '6文字以上の半角英数字で入力してください';
    } 
}
// パスワード
function check_password($password,$regex) {
    global $err;
    if ($password === '') {
        $err[''] = 'パスワードを入力してください';
    } else if (preg_match($regex, $password) !== 1) {
        $err[''] = '6文字以上の半角英数字で入力してください';
    } 
}

// db追加
function insert_user_id($dbh,$user_name,$password,$date) {
    global $err;
    try {
      // ユーザー情報
      $sql = 'INSERT INTO ec_user(user_name, password, create_datetime) VALUES(?,?,?)';
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(1,$user_name, PDO::PARAM_STR);
      $stmt->bindValue(2,$password, PDO::PARAM_STR);
      $stmt->bindValue(3,$date, PDO::PARAM_STR);
     
      $stmt->execute();
    } catch (Exception $e) {
      $err[] = $e->getMessage();
    }
}

function select_user($dbh,$user_name,$password) {
    global $err;
    try {
      // ユーザー情報
      $sql = 'SELECT 
                user_name,password 
              FROM 
                ec_user
              WHERE 
                user_name = '.$user_name.',
                password  = '.$password;
      $stmt = $dbh->prepare($sql); 
      $stmt->execute();
      // レコードの取得
      $rows = $stmt->fetchAll();
      return $rows;
    } catch (Exception $e) {
      $err[] = $e->getMessage();
    }
}