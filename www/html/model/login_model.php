<?php
// 入力値チェック
// ユーザーid
function check_user_name($user_name,$regex) {
    global $err;
    if ($user_name === '') {
        $err[] = 'ユーザー名を入力してください';
    } else if (preg_match($regex, $user_name) !== 1) {
        $err[] = '6文字以上の半角英数字で入力してください';
    }
}
// パスワード
function check_password($password,$regex) {
    global $err;
    if ($password === '') {
        $err[] = 'パスワードを入力してください';
    } else if (preg_match($regex, $password) !== 1) {
        $err[] = '6文字以上の半角英数字で入力してください';
    }
}

// db追加
function insert_user_id($dbh,$user_name,$password,$date) {
      $sql = '
            INSERT INTO
              ec_user(
                user_name,
                password,
                create_datetime
                )
            VALUES (?,?,?)
            ';
      return execute_query($dbh, $sql, [$user_name, $password, $date]);
}

function select_user($dbh,$user_name,$password) {
      $sql = '
            SELECT
              user_id,
              user_name
            FROM
              ec_user
            WHERE
              user_name = ?
            AND
              password  = ?
            ';
      return fetch_all_query($dbh, $sql, [$user_name, $password]);
}

