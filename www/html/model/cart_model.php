<?php
function delete_ec_cart($dbh,$item_id,$user_id) {
      $sql = '
            DELETE FROM
              ec_cart
            WHERE
              item_id = ?
            AND
              user_id = ?
            ';
      return execute_query($dbh, $sql, [$item_id, $user_id]);
}

// id
function check_item_id($item_id) {
    global $err;
    if ($item_id === '') {
        $err[] = 'IDを入力してください';
    }
}

//数量入力チェック
function check_amount($amount){
    global $err;
    if ($amount === '') {
        $err[] = '数量を入力してください';
    } else if (preg_match('/^[0-9]+$/', $amount) !== 1) {
        $err[] = '整数で入力してください';
    }
    // print_r($err);
}

// 数量追加
function  update_amount($dbh,$item_id,$user_id,$amount,$date){
    $sql = '
          UPDATE
            ec_cart
          SET
            amount = ?
            update_datetime = ?
          WHERE
            item_id = ?
          AND
            user_id = ?
          ';
    return execute_query($dbh, $sql, [$amount, $date, $item_id, $user_id]);
}
// $cart_data
function get_ec_cart_table($dbh,$user_id) {
      $sql = '
            SELECT
              ec_cart.item_id,
              ec_cart.id,
              amount,
              name,
              img,
              price
            FROM
              ec_cart
            INNER JOIN
              ec_item_master
            ON
              ec_cart.item_id = ec_item_master.item_id
            WHERE
              user_id = ?
            ';
      return fetch_all_query($dbh, $sql, [$user_id]);
}



// 在庫の減少
function decrease_stock($dbh,$item_id,$amount,$date) {
    $sql = '
          UPDATE
            ec_item_stock
          SET
            stock = stock - ?,
            update_datetime = ?
          WHERE
            item_id = ?
          ';
    return execute_query($dbh, $sql, [$amount, $date, $item_id]);
}

function get_item_cart($dbh,$user_id) {
    $sql = '
          SELECT
            amount,
            item_id
          FROM
            ec_cart
          WHERE
            user_id = ?
          ';
    return fetch_all_query($dbh, $sql, [$user_id]);
}
