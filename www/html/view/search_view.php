<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>検索ページ</title>
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
  <div class="search">
    <h2>キーワードから探す</h2>
    <form method="post">
      <div><label>キーワード<input type="text" name="keyword"></label></div>
      <div><label></label><input type="submit" value="検索"></label></div>
    </form>
      <div class="genre">
        <form method="post" action="./search_list.php">
          <div>
            <h3>タイプから探す</h3>
              <div>
                <input type="submit" value="ネイキッド">
                <input type="hidden" name="type" value=0>
              </div>
              <div>
                <input type="submit" value="アメリカン">
                <input type="hidden" name="type" value=1>
              </div>
              <div>
                <input type="submit" value="クラシック">
                <input type="hidden" name="type" value=2>
              </div>
              <div>
                <input type="submit" value="オフロード">
                <input type="hidden" name="type" value=3>
              </div>
              <div>
                <input type="submit" value="スポーツレプリカ">
                <input type="hidden" name="type" value=4>
              </div>
              <div>
                <input type="submit" value="スクーター">
                <input type="hidden" name="type" value=5>
              </div>
           
          </div>
          <div>
            <h3>メーカーから探す</h3>
            <div>
                <input type="button" value="ホンダ">
                <input type="hidden" name="meaker" value="0">
              </div>
              <div>
                <input type="button" value="ヤマハ">
                <input type="hidden" name="meaker" value="1">
              </div>
              <div>
                <input type="button" value="スズキ">
                <input type="hidden" name="meaker" value="2">
              </div>
              <div>
                <input type="button" value="カワサキ">
                <input type="hidden" name="meaker" value="3">
              </div>
              <div>
                <input type="button" value="ハーレーダビッドソン">
                <input type="hidden" name="meaker" value="4">
              </div>
              <div>
                <input type="button" value="BMW">
                <input type="hidden" name="meaker" value="5">
              </div>
              <div>
                <input type="button" value="その他輸入車">
                <input type="hidden" name="meaker" value="6">
              </div>
          </div>
        </form>
      </div>
  </div>
</body>
</html>
