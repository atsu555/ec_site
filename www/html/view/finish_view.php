<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>購入完了ページ</title>
  <link type="text/css" rel="stylesheet" href="./css/common.css">
</head>
<body>
  <header>
    <div class="header-box">
      <a href="21-top.php">
        <img class="logo" src="./lib/logo.png" alt="CodeCamp SHOP">
      </a>
      <a class="nemu" href="login.php">ログアウト</a>
      <a href="22-cart.php" class="cart"></a>
      <p class="nemu">ユーザー名：<?php print $user_name; ?></p>
    </div>
  </header>
  <div class="content">
    <div class="finish-msg">ご購入ありがとうございました。</div>
    <div class="cart-list-title">
      <span class="cart-list-price">価格</span>
      <span class="cart-list-num">数量</span>
    </div>
      <ul class="cart-list">
        <li>
  <?php foreach ($cart_data as $value) { ?>
          <div class="cart-item">
            <img class="cart-item-img" src="<?php print $img_dir . $value['img']; ?>">
            <span class="cart-item-name"><?php print $value['name'] ?></span></span>
            <span class="cart-item-price">¥<?php print $value['price']; ?></span>
            <span class="finish-item-price"><?php print $value['amount']; ?></span>
          </div>
  <?php } ?>
        </li>
      </ul>
    <div class="buy-sum-box">
      <span class="buy-sum-title">合計</span>
      <!-- ★D-2-2 ●商品の合計を表示する。 -->
      <!-- ここから入力 -->
      <span class="buy-sum-price">¥<?php print $sum[0]['sum(price * amount)']; ?></span>
      <!-- ここまで入力 -->
    </div>
  </div>

</body>
</html>