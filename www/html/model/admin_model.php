<?php
// 入力値チェック
// 商品名
function check_new_name($new_name) {
    global $err;
    if ($new_name === '') {
        $err[] = '名前を入力してください';
    } else if (mb_strlen($new_name) > 20) {
        $err[] = '名前を20文字以内で入力してください';
    }
}
// 価格
function check_new_price($new_price) {
    global $err;
    if ($new_price === '') {
        $err[] = '価格を入力してください';
    } else if (preg_match('/^[0-9]+$/', $new_price) !== 1) {
        $err[] = '整数で入力してください';
    } 
}
// 在庫
function check_new_stock($new_stock) {
    global $err;
    if ($new_stock === '') {
        $err[] = '在庫を入力してください';
    } else if (preg_match('/^[0-9]+$/', $new_stock) !== 1) {
        $err[] = '整数で入力してください';
    } 
}
// 排気量
function check_new_cc($new_cc,$regex) {
    global $err;
    if ($new_cc === '') {
        $err[] = 'ステータスを入力してください';
    } 
}
// ステータス
function check_new_status($new_status,$regex) {
    global $err;
    if ($new_status === '') {
        $err[] = 'ステータスを入力してください';
    } 
}
// 種類
function check_new_type($new_type,$regex) {
    global $err;
    if ($new_type === '') {
        $err[] = '種類を入力してください';
    }
}
// メーカー
function check_new_area($new_area,$regex) {
    global $err;
    if ($new_area === '') {
        $err[] = 'メーカーを入力してください';
    }
}


function check_new_img($img_dir) {
    global $err,$new_img;
    // HTTP POST でファイルがアップロードされたかどうかチェック
    if (is_uploaded_file($_FILES['new_img']['tmp_name']) === TRUE) {
      // 画像の拡張子を取得
      $extension = pathinfo($_FILES['new_img']['name'], PATHINFO_EXTENSION);
      // 指定の拡張子であるかどうかチェック
      if ($extension === 'png' || $extension === 'jpg' || $extension === 'jpeg') {
        // 保存する新しいファイル名の生成（ユニークな値を設定する）
        $new_img = sha1(uniqid(mt_rand(), true)). '.' . $extension;
        // 同名ファイルが存在するかどうかチェック
        if (is_file($img_dir . $new_img) !== TRUE) {
          // アップロードされたファイルを指定ディレクトリに移動して保存
          if (move_uploaded_file($_FILES['new_img']['tmp_name'], $img_dir . $new_img) !== TRUE) {
              $err[] = 'ファイルアップロードに失敗しました';
          }
        } else {
          $err[] = 'ファイルアップロードに失敗しました。再度お試しください。';
        }
      } else {
        $err[] = 'ファイル形式が異なります。画像ファイルはPNGまたはJPEGのみ利用可能です。';
      }
    } else {
      $err[] = 'ファイルを選択してください';
    }
}

// データベースインサート
function insert_item_master($dbh,$new_name,$new_price,$new_cc,$new_img,$new_type,$new_area,$new_status,$date) {
    global $err,$lastid;
    try {
      // 商品情報
      $sql = 'INSERT INTO ec_item_master(name, price, displacement, img, type, area, status, create_datetime) VALUES(?,?,?,?,?,?,?,?)';
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(1,$new_name, PDO::PARAM_STR);
      $stmt->bindValue(2,$new_price, PDO::PARAM_STR);
      $stmt->bindValue(3,$new_cc, PDO::PARAM_STR);
      $stmt->bindValue(4,$new_img, PDO::PARAM_STR);
      $stmt->bindValue(5,$new_type, PDO::PARAM_STR);
      $stmt->bindValue(6,$new_area, PDO::PARAM_STR);
      $stmt->bindValue(7,$new_status,PDO::PARAM_STR);
      $stmt->bindValue(8,$date,PDO::PARAM_STR);
      $stmt->execute();
      $lastid = $dbh->lastInsertId();
    } catch (Exception $e) {
      $err[] = $e->getMessage();
    }
}

function insert_item_stock($dbh,$lastid,$new_stock,$date) {
  try {
    $sql = 'INSERT INTO ec_item_stock(item_id, stock, create_datetime) VALUES(?,?,?)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1,$lastid, PDO::PARAM_STR);
    $stmt->bindValue(2,$new_stock, PDO::PARAM_STR);
    $stmt->bindValue(3,$date, PDO::PARAM_STR);
    $stmt->execute();
  } catch (Exception $e) {
      $err[] = $e->getMessage();
  }
}



// 在庫変更処理
// 入力値チェック
// 在庫
function check_update_stock($update_stock) {
    global $err;
    if ($update_stock === '') {
        $err[] = '在庫を入力してください';
    } else if (preg_match('/^[0-9]+$/', $update_stock) !== 1) {
        $err[] = '整数で入力してください';
    } 
    // print_r($err);
}
// id
function check_item_id($item_id) {
    global $err;
    if ($item_id === '') {
        $err[] = 'IDを入力してください';
    }   
}
// データアップデート
function update_item_stock($dbh,$item_id,$update_stock,$date) {
  global $err,$msg;
  try {
    $sql = 'UPDATE
            ec_item_stock
            SET
            stock = '.$update_stock.',   
            update_datetime = \''.$date.'\'
            WHERE
            item_id = '.$item_id;
            // SQL文を実行する準備
            $stmt = $dbh->prepare($sql);
            // SQLを実行
            $stmt->execute();
            
    $msg[] = '在庫変更が完了しました。';
  } catch (PDOException $e) {
    $err[] = '在庫変更に失敗しました。';
    throw $e;
  }
}

// ステータスの変更
function change_status($dbh,$change_status,$item_id,$date) {
    global $err,$msg;
    try {
      $sql = 'UPDATE
              ec_item_master
              SET
              status = '.$change_status.',   
              update_datetime = \''.$date.'\'
              WHERE
              item_id = '.$item_id;
              // SQL文を実行する準備
              $stmt = $dbh->prepare($sql);
              // SQLを実行
              $stmt->execute();
              
      $msg[] = 'ステータス変更が完了しました。';
    } catch (PDOException $e) {
      $err[] = 'ステータス変更に失敗しました。';
      throw $e;
    }
}

// 商品の削除
function delete_item_master ($dbh,$item_id) {
    global $err,$msg;
    try {
        $sql = 'DELETE FROM ec_item_master WHERE item_id = ?';
        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1,$item_id,PDO::PARAM_INT);
        // SQLを実行
        $stmt->execute();
        
    } catch (PDOException $e) {
      $err[] = '商品の削除に失敗しました。';
      throw $e;
    }
}

function delete_item_stock ($dbh,$item_id) {
    global $err,$msg;
    try {
        $sql = 'DELETE FROM ec_item_stock WHERE item_id = ?';
        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1,$item_id,PDO::PARAM_INT);
        // SQLを実行
        $stmt->execute();
        
    } catch (PDOException $e) {
      $err[] = '商品の削除に失敗しました。';
      throw $e;
    }
}