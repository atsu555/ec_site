<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ログインページ</title>
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
    <div class="login">
      <form method="post">
        <div><input type="text" name="user_name" placeholder="ユーザー名"></div>
        <div><input type="password" name="password" placeholder="パスワード">
        <div><input type="submit" value="ログイン">
<?php foreach($err as $value) { ?>
<p><?php print $value; ?></p>
<?php } ?>
      </form>
      <div class="account-create">
        <a href="register.php">ユーザーの新規作成</a>
      </div>
    </div>
  </div>
</body>
</html>
