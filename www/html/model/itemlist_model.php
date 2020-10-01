<?php
// itemidのチェック
function check_item_id($item_id) {
    global $err;
    if ($item_id === '') {
        $err[] = 'メーカーを入力してください';
    } 
}

function get_ec_cart($dbh,$item_id,$user_id) {
    try {
      $sql = 'SELECT
                id
              FROM
                ec_cart
              WHERE
                item_id = '.$item_id.'
              AND
                user_id = '.$user_id;
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
function insert_ec_cart($dbh,$user_id,$item_id,$date) {
    global $err;
    try {
      // 商品情報
      $sql = 'INSERT INTO ec_cart(user_id, item_id,create_datetime) VALUES(?,?,?)';
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(1,$user_id, PDO::PARAM_STR);
      $stmt->bindValue(2,$item_id, PDO::PARAM_STR);
      $stmt->bindValue(3,$date, PDO::PARAM_STR);
      $stmt->execute();
    } catch (Exception $e) {
      $err[] = $e->getMessage();
    }
}

function update_ec_cart($dbh,$user_id,$item_id,$date) {
  global $err;
  try {
    $sql = 'UPDATE
            ec_cart
            SET
            amount = amount + 1,
            update_datetime = \''.$date.'\'
            WHERE
            item_id = '.$item_id.'
            AND
            user_id = '.$user_id;
            // SQL文を実行する準備
            $stmt = $dbh->prepare($sql);
            // SQLを実行
            $stmt->execute();
            
    // $msg[] = '在庫変更が完了しました。';
  } catch (PDOException $e) {
    $err[] = '在庫変更に失敗しました。';
    throw $e;
  }
}
