<?php
// 設定ファイル読み込み
require_once '../conf/const.php';
// 関数ファイル読み込み
require_once './model/common.php';
require_once './model/admin_model.php';

$err           = array();
$msg           = array();
$sql_kind      = '';
$new_name      = '';
$new_price     = '';
$new_stock     = '';
$new_type      = '';
$new_area      = '';
$new_img       = '';
$new_status    = '';
$update_stock  = '';
$change_status = '';
$item_id       = '';
$img_dir       = './img/';
$date          = date('Y-m-d H:i:s');

$regex         = '/^[0-9]/';

try {
    // db接続
    $dbh = get_db_connect();
    echo 'データベースに接続しました';


    // リクエストメソッド
    if (get_request_method()=== 'POST') {
        // ポスト値の取得
        $sql_kind   = get_post_data('sql_kind');
        if ($sql_kind === 'insert') {
            $new_name   = get_post_data('new_name');//$_POST['new_name']
            $new_name   = entity_str($new_name);

            $new_price  = get_post_data('new_price');
            
            $new_stock  = get_post_data('new_stock');
            
            $new_cc     = get_post_data('displacement');
            
            $new_type   = get_post_data('new_type');
            
            $new_area   = get_post_data('new_area');
        
            $new_status = get_post_data('new_status');
            
        
            // 入力値チェック
            // 商品名
            check_new_name($new_name);
            // 値段
            check_new_price($new_price);
            
            // 在庫
            check_new_stock($new_stock);
            
            // 排気量
            check_new_cc($new_cc,$regex);

            // 種類
            check_new_type($new_type,$regex);

            // メーカー
            check_new_area($new_area,$regex);

            // ステータス
            check_new_status($new_status,$regex);

            // 画像
            check_new_img($img_dir);
            // var_dump($new_img)

            if (count($err) === 0 ) {
                // トランザクション開始
                $dbh->beginTransaction();
                try {
                  // 商品情報
                  insert_item_master($dbh,$new_name,$new_price,$new_cc,$new_img,$new_type,$new_area,$new_status,$date);
                  insert_item_stock($dbh,$lastid,$new_stock,$date);

                  // コミット処理
                  $dbh->commit();
                } catch (PDOException $e) {
                  // ロールバック処理
                  $dbh->rollback();
                  throw $e;
                }
            }
        // 在庫アップデート
        } else if ($sql_kind === 'update') {
            $update_stock = get_post_data('update_stock');
            
            $item_id      = get_post_data('item_id');
            
            // 入力値チェック
            check_update_stock($update_stock,$regex);
            check_item_id($item_id);
            
            if (count($err) === 0 ) {
                // アップデート情報
                
                update_item_stock($dbh,$item_id,$update_stock,$date);
                
                
            }
            // var_dump($update_stock);
        // ステータス変更
        }  else if ($sql_kind === 'change') {
            $change_status = get_post_data('change_status');
            
            $item_id       = get_post_data('item_id');
            check_item_id($item_id);
            
            if (count($err) === 0 ) {
                // ステータス変更情報
            
                change_status($dbh,$change_status,$item_id,$date);
                
            }
        //デリート   
        } else if ($sql_kind === 'delete') {
            $item_id       = get_post_data('item_id');
            check_item_id($item_id);
            // 子を先に削除
             // トランザクション開始
            $dbh->beginTransaction();
            try {
               delete_item_master ($dbh,$item_id);
               delete_item_stock ($dbh,$item_id); 
               // コミット処理
              $dbh->commit();
            } catch (PDOException $e) {
              // ロールバック処理
              $dbh->rollback();
              throw $e;
            }
            
            
        } //デリートの終了
        
    }//postの終了
    
    
    var_dump ($err);


    $item_data = item_data($dbh);
    // var_dump($item_data);
} catch (Exception $e) {
  $err[] = $e->getMessage();
}

// 商品一覧ファイル読み込み
include_once './view/admin_view.php';

