<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ショッピングカートページ</title>
  <link type="text/css" rel="stylesheet" href="./css/common.css">
</head>
<body>

<?php include 'templates/header_view.php'; ?>

<?php if (count($cart_data) > 0) { ?>
  <div class="content">
    <h1 class="title">ショッピングカート</h1>

    <div class="cart-list-title">
      <span class="cart-list-price">価格</span>
      <span class="cart-list-num">数量</span>
    </div>
    <ul class="cart-list">
<?php foreach ($cart_data as $value) { ?>
      <li>
        <div class="cart-item">
          <img class="cart-item-img" src="<?php print $img_dir . $value['img']; ?>">
          <span class="cart-item-name"><?php print  $value['name']; ?></span>
          <form class="cart-item-del"  method="post">
            <input type="submit" value="削除">
            <input type="hidden" name="item_id" value="<?php print $value['item_id']; ?>">
            <input type="hidden" name="sql_kind" value="delete_cart">
          </form>
          <span class="cart-item-price"><?php print $value['price']; ?></span>
          <form class="form_select_amount" id="form_select_amount111"  method="post">
 
            <input type="text" class="cart-item-num2" min="0" name="select_amount" value="<?php print $value['amount']; ?>">個&nbsp;<input type="submit" value="変更する">
            <input type="hidden" name="item_id" value="<?php print $value['item_id']; ?>">
            <input type="hidden" name="sql_kind" value="change_cart">
          </form>

        </div>
      </li>
<?php } ?>
    </ul>
    <div class="buy-sum-box">
      <span class="buy-sum-title">合計</span>
      <!-- ★C-3-2 ●ショッピングカートにある商品の合計を表示する。-->
      <!-- ここから入力 -->
      <span class="buy-sum-price">¥<?php print number_format($sum[0]['sum(price * amount)']); ?></span>
      <!-- ここまで入力 -->
    </div>
    <div>
      <form action="finish.php" method="post">
        <input class="buy-btn" type="submit" value="購入する">
        <input type="hidden" name="sql_kind" value="buy_cart">
      </form>
    </div>
  </div>
<?php } else { ?>
      <h1>カートに商品がありません</h1>
      <a href="itemlist.php">商品一覧へ戻る</a>
<?php } ?>
</body>
</html>
