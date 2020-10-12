<?php

function get_item_data($dbh,$item_id) {
    $sql = '
          SELECT
            price,
            name,
            img,
            item_id
          FROM
            ec_item_master
          WHERE
            item_id = ?
            ';
    return fetch_all_query($dbh, $sql, [$item_id]);
}

// itemidのチェック
function check_item_id($item_id) {
    global $err;
    if ($item_id === '') {
        $err[] = 'メーカーを入力してください';
    }
}

function get_ec_cart($dbh,$item_id,$user_id) {
      $sql = '
            SELECT
                id
            FROM
                ec_cart
            WHERE
                item_id = ?
            AND
                user_id = ?
            ';
      return fetch_all_query($dbh, $sql, [$item_id, $user_id]);
}
function insert_ec_cart($dbh,$user_id,$item_id,$date) {
      // 商品情報
      $sql = '
            INSERT INTO
              ec_cart(
                user_id,
                item_id,
                create_datetime
                )
            VALUES (?,?,?)
            ';
      return execute_query($dbh, $sql, [$user_id, $item_id, $date]);
}

function update_ec_cart($dbh,$user_id,$item_id,$date) {
    $sql = '
          UPDATE
            ec_cart
          SET
            amount = amount + 1,
            update_datetime = ?
          WHERE
            item_id = ?
          AND
            user_id = ?
          ';
    return execute_query($dbh, $sql, [$date, $item_id, $user_id]);
}
