<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ユーザ登録ページ</title>
  <link type="text/css" rel="stylesheet" href="./css/common.css">
</head>
<body>
  <header>
    <div class="header-box">
      <a class="title" href="itemlist.php">
        バイクショップ
      </a>
    </div>
  </header>
  <div class="content">
    <div class="register">
      <form method="post">
        <div>ユーザー名：<input type="text" name="user_name" placeholder="ユーザー名"></div>
        <div>パスワード：<input type="password" name="password" placeholder="パスワード">
        <div><input type="submit" value="ユーザーを新規作成する">
      </form>
<?php foreach ($err as $msg) { ?>
<p><?php print $msg; ?></p>
<?php } ?>
    </div>
  </div>
</body>
</html>