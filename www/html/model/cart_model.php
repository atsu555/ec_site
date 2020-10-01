<?php 
function delete_ec_cart($dbh,$item_id,$user_id) {
  // var_dump($item_id,$user_id);
    global $err,$msg;
    try {
        $sql = 'DELETE FROM ec_cart WHERE item_id = ? AND user_id = ?';
        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1,$item_id,PDO::PARAM_INT);
        $stmt->bindValue(2,$user_id,PDO::PARAM_INT);
        // SQLを実行
        $stmt->execute();
        
    } catch (PDOException $e) {
      $err[] = '商品の削除に失敗しました。';
      throw $e;
    }
}

// id
function check_item_id($item_id) {
    global $err;
    if ($item_id === '') {
        $err[] = 'IDを入力してください';
    }   
}

//数量入力チェック
function check_amount($amount) {
    global $err;
    if ($amount === '') {
        $err[] = '数量を入力してください';
    } else if (preg_match('/^[0-9]+$/', $amount) !== 1) {
        $err[] = '整数で入力してください';
    } 
    // print_r($err);
}

// 数量追加
function update_amount($dbh,$item_id,$user_id,$amount,$date) {
var_dump($item_id);
var_dump($amount);
  global $err,$msg;
  try {
    $sql = 'UPDATE
            ec_cart
            SET
            amount = '.$amount.',   
            update_datetime = \''.$date.'\'
            WHERE
            item_id = '.$item_id.'
            AND 
            user_id = '.$user_id;
// var_dump($sql);
            // SQL文を実行する準備
            $stmt = $dbh->prepare($sql);
            // SQLを実行
            $stmt->execute();
            
    $msg[] = '数量変更が完了しました。';
  } catch (PDOException $e) {
    $err[] = '数量変更に失敗しました。';
    throw $e;
  }
}
// $cart_data
function get_ec_cart_table($dbh,$user_id) {
    try {
      $sql = 'SELECT
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



// 在庫の減少
function decrease_stock($dbh,$item_id,$amount,$date) {
var_dump($item_id);
var_dump($amount);
  global $err;
  try {
    $sql = 'UPDATE
            ec_item_stock
            SET
            stock = stock - '.$amount.',   
            update_datetime = \''.$date.'\'
            WHERE
            item_id = '.$item_id;
            // SQL文を実行する準備
            $stmt = $dbh->prepare($sql);
            // SQLを実行
            $stmt->execute();
  } catch (PDOException $e) {
    $err[] = '在庫変更に失敗しました。';
    throw $e;
  }
}

function get_item_cart($dbh,$user_id) {
  global $err;
  try {
    $sql = 'SELECT
            amount,
            item_id
            FROM
            ec_cart
            WHERE
            user_id = '.$user_id;
// var_dump($sql);
            // SQL文を実行する準備
            $stmt = $dbh->prepare($sql);
            // SQLを実行
            $stmt->execute();
            // レコードの取得
            $rows = $stmt->fetchAll();
            return $rows;  
  } catch (PDOException $e) {
     $err[] = $e->getMessage();
    throw $e;
  }
}
