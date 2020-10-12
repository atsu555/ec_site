<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>商品管理ページ</title>
  <link type="text/css" rel="stylesheet" href="./css/admin.css">
</head>
<body>
  <h1>BIKESHOP 管理ページ</h1>

  <div>
    <a href="itemlist.php" target="_blank">ユーザ管理ページ</a>
  </div>
  <div>
    <a href="logout.php" target="_blank">ログアウト</a>
  </div>
  <section>

<?php foreach($errs as $value){ ?>
        <p><?php print $value; ?></p>
<?php } ?>
    <h2>商品の登録</h2>
    <form method="post" enctype="multipart/form-data">
      <div><label>商品名: <input type="text" name="new_name" value=""></label></div>
      <div><label>値　段: <input type="text" name="new_price" value=""></label></div>
      <div><label>個　数: <input type="text" name="new_stock" value=""></label></div>
      <div>排気量:
        <select name="displacement">
            <option value="0">50cc以下</0></option>
            <option value="1">51cc~125cc</option>
            <option value="2">126cc~250cc</option>
            <option value="3">251cc~400cc</option>
            <option value="4">401cc~750cc</option>
            <option value="5">751cc以上</option>
        </select>
      </div>
      <div>種類:
        <select name="new_type">
            <option value="0">ネイキッド</option>
            <option value="1">アメリカン</option>
            <option value="2">クラシック</option>
            <option value="3">オフロード</option>
            <option value="4">スポーツレプリカ</option>
            <option value="5">スクーター</option>
        </select>
      </div>
      <div>メーカー:
        <select name="new_area">
            <option value="0">ホンダ</option></option>
            <option value="1">ヤマハ</option>
            <option value="2">スズキ</option>
            <option value="3">カワサキ</option>
            <option value="4">ハーレーダビッドソン</option>
            <option value="5">BMW</option>
            <option value="6">その他輸入車</option>
        </select>
      </div>
      <div><label>商品画像:<input type="file" name="new_img"></label></div>
      <div><label>ステータス:
        <select name="new_status">
          <option value="0">非公開</option>
          <option value="1" selected>公開</option>
        </select>
        </label>
      </div>
      <div>
        <input type="hidden" name="sql_kind" value="insert">
        <input type="submit" value="商品を登録する">
      </div>
    </form>
  </section>
  <section>
    <h2>商品情報の一覧・変更</h2>
    <table>
      <tr>
        <th>商品画像</th>
        <th class="name_width">商品名</th>
        <th>価　格</th>
        <th>在庫数</th>
        <th>排気量</th>
        <th>種類</th>
        <th>メーカー</th>
        <th>ステータス</th>
        <th>操作</th>
      </tr>
<?php foreach ($item_data as $value) { ?>
      <tr>
        <form method="post">
          <td><img class="img_size" src="<?php print $img_dir . $value['img'] ?>"></td>
          <td class="name_width"><?php print $value['name']; ?></td>
          <td class="text_align_right"><?php print $value['price']; ?></td>
          <td>
            <input type="text"  class="input_text_width text_align_right" name="update_stock" value="<?php print $value['stock'];?>">
            個
            <input type="submit" value="変更する">
            <input type="hidden" name="item_id" value="<?php print $value['item_id']; ?>">
            <input type="hidden" name="sql_kind" value="update">
          </td>
          <td class="name_width">
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
          </td>
          <td class="name_width">
  <?php if ($value['type'] === 0) { ?>
          ネイキッド
  <?php } else if ($value['type'] === 1) { ?>
          アメリカン
  <?php } else if ($value['type'] === 2) { ?>
          クラシック
  <?php } else if ($value['type'] === 3) { ?>
          オフロード
  <?php } else if ($value['type'] === 4) { ?>
          スポーツレプリカ
  <?php } else if ($value['type'] === 5) { ?>
          スクーター
  <?php } ?>
          </td>
          <td class="name_width">
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
          </td>
        </form>
        <form method="post">
          <td>
  <?php if ($value['status'] === 0) { ?>
            <input type="hidden" name="change_status" value="1">
            <input type="hidden" name="item_id" value="<?php print $value['item_id']; ?>">
            <input type="hidden" name="sql_kind" value="change">
            <input type="submit" value="非公開 → 公開にする">
  <?php } else { ?>
            <input type="hidden" name="change_status" value="0">
            <input type="hidden" name="item_id" value="<?php print $value['item_id']; ?>">
            <input type="hidden" name="sql_kind" value="change">
            <input type="submit" value="公開 → 非公開にする">
  <?php }?>
          </td>
        </form>
        <form method="post">
          <td><input type="submit" value="削除する"></td>
          <input type="hidden" name="item_id" value="<?php print $value['item_id']; ?>">
          <input type="hidden" name="sql_kind" value="delete">
        </form>
      <tr>
<?php } ?>
    </table>
  </section>
</body>
</html>