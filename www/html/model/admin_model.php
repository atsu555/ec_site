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
      $sql = '
            INSERT INTO
                ec_item_master(
                  name,
                  price,
                  displacement,
                  img,
                  type,
                  area,
                  status,
                  create_datetime
                  )
              VALUES (?,?,?,?,?,?,?,?)
              ';
      return execute_query($dbh, $sql, [$new_name,$new_price,$new_cc,$new_img,$new_type,$new_area,$new_status,$date]);
}

function insert_item_stock($dbh,$lastid,$new_stock,$date) {
    $lastid = $dbh->lastInsertId();
    $sql = '
          INSERT INTO
            ec_item_stock(
              item_id,
              stock,
              create_datetime
              )
          VALUES (?,?,?)
          ';
    return execute_query($dbh, $sql, [$lastid,$new_stock,$date]);
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
    $sql = '
          UPDATE
            ec_item_stock
          SET
            stock = ?,
            update_datetime = ?
          WHERE
            item_id = ?
          ';

    return execute_query($dbh, $sql, [$update_stock,$date,$item_id]);
}

// ステータスの変更
function change_status($dbh,$change_status,$item_id,$date) {
      $sql = '
            UPDATE
              ec_item_master
            SET
              status = ?,
              update_datetime = ?
            WHERE
              item_id = ?
            ';

      return execute_query($dbh, $sql, [$change_status,$date,$item_id]);
}

// 商品の削除
function delete_item_master ($dbh,$item_id) {
        $sql = '
              DELETE FROM
                ec_item_master
              WHERE
                item_id = ?
              ';

        return execute_query($dbh, $sql, [$item_id]);
}

function delete_item_stock ($dbh,$item_id) {
        $sql = '
              DELETE FROM
                ec_item_stock
              WHERE
              item_id = ?
              ';

        return execute_query($dbh, $sql, [$item_id]);
}