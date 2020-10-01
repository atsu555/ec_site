<?php
function type_data($dbh,$type) {
  try {
    $sql = 'SELECT
              name,
              price,
              displacement,
              area
            FROM
              ec_item_master
            WHERE  
              type = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1,$type, PDO::PARAM_STR);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    return $rows;  
  } catch (Exception $e) {
    $err[] = $e->getMessage();
  }
}

function get_post_type_data($key) {
    $int = '';
    if (isset($_POST[$key]) === TRUE) {
        $int = ($_POST[$key]);
    }
    return $int;
}