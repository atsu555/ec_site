<?php
function get_ec_cart_table($dbh,$user_id) {
    try {
      $sql = 'SELECT
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

