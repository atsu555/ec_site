<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>商品一覧ページ</title>
  <link type="text/css" rel="stylesheet" href="./css/common.css">
</head>
<body>
  <header>
    <div class="header-box">
      <a href="itemlist.php">
        <img class="logo" src="./logo/design-vector.jpg" alt="BIKESHOP">
      </a>
      <a class="nemu" href="login.php">ログアウト</a>
      <a href="cart.php" class="cart">cart</a>
      <p class="nemu">ユーザー名：<?php print $user_name; ?></p>
    </div>
  </header>
<?php if (count($item_data) > 0) { ?>
  <div class="content">
    <ul class="item-list">
<?php foreach ($item_data as $value) { ?>
      <li>
        <div class="item">
          <form method="post" action="itemlist.php">
            <img class="item-img" src="<?php print $img_dir . $value['img']; ?>" >
            <div class="item-info">
              <p class="item_meaker">メーカー:
　<?php if ($value['area'] === 0) { ?>
          ホンダ
  <?php } else if ($value['area'] === 1) { ?>
          ヤマハ
  <?php } else if ($value['area'] === 2) { ?>
          スズキ
  <?php } else if ($value['area'] === 3) { ?>
          カワサキ
  <?php } else if ($value['area'] === 4) { ?>
          ハーレーダビッドソン
  <?php } else if ($value['area'] === 5) { ?>
          BMW
  <?php } else if ($value['area'] === 6) { ?>
          その他
  <?php } ?>
              </p>
              <p class="item-name">商品名:<?php print $value['name']; ?></p>
              <p>排気量:
  <?php if ($value['displacement'] === 0) { ?>
          50cc以下
  <?php } else if ($value['displacement'] === 1) { ?>
          51cc~125cc
  <?php } else if ($value['displacement'] === 2) { ?>
          126cc~250cc
  <?php } else if ($value['displacement'] === 3) { ?>
          251cc~400cc
  <?php } else if ($value['displacement'] === 4) { ?>
          401cc~750cc
  <?php } else if ($value['displacement'] === 5) { ?>
          751cc以上
  <?php } ?>
              </p>
              <p class="item-price">価格:<?php print $value['price']; ?>円</p>
            </div>
<!-- ここから入力 -->
<!-- ★B-2 ●商品の在庫が0の場合、「カートに入れる」ボタンは表示せず、「売り切れ」を表示する -->
<?php if ($value['stock'] === 0) { ?>
            <p>売り切れました</p>
<?php } else { ?>
            <input class="cart-btn" type="submit" value="カートに入れる">
            <input type="hidden" name="item_id" value="<?php print $value['item_id']; ?>">
            <input type="hidden" name="sql_kind" value="insert_cart">
<?php } ?>
<!-- ここまで入力 -->
          </form>
        </div>
      </li>
<?php } ?>
    </ul>
    <a href="search.php">検索はこちらから</a>
  </div>
<?php } else { ?>
　<div class="content">
      <h1>商品はありません</h1>
      <a href="search.php">検索はこちらから</a>
  </div>
<?php } ?>

</body>
</html>
