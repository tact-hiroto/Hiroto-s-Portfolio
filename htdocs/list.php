<?php
$db = new PDO("sqlite:db/list.db");

// 掲示板の数を取得しておく
$stmt = $db->query("SELECT COUNT(*) FROM list");
$listcount = $stmt->fetchColumn();
$stmt->closeCursor();

$i = 1;
$html = "";

// 掲示板が1つ以上存在すればリストをリンク付きで表示する
if ($listcount > 0) {
  // 新規投稿があった順に並べる
  $stmt = $db->query("SELECT * FROM list WHERE flg=0 ORDER BY updtime DESC");
  $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach ($list as $row) {
    $html .= "<a href='bbs.php?dbname={$row["dbname"]}&dbnamekana={$row["dbnamekana"]}'>".$i.":".$row["dbnamekana"]." (".$row['kensu'].") ".$row['updtime']."</a>"." <a href='del.php?dbname={$row["dbname"]}'>削除する</a><br><br>";
  $i++;
  }
}
$db = null;

// 掲示板の数が10未満であれば新スレ作成フォームを表示する。
if ($listcount < 10) {
  $listcount++;
  $newdbname = "bbs".$listcount;
  $build = <<< EOM
  <form action="build.php" method="post">
  <input type="hidden" name="newdbname" value="{$newdbname}">
  名称：<input type="text" name="newdbnamekana" value="">
  <input type="submit" name="newbbs" value="新しく掲示板を立てる（制限10個）">
  </form>
EOM;
} else {
  $build = "これ以上掲示板は立てられません。";
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>掲示板</title>
<meata charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0">
<link rel="stylesheet" href="style.css" media="all">
</head>
<body>
<main>
<div class='bigbox'>
<h2>掲示板</h1>
<?php echo $html; ?>
<?php echo $build; ?>
</div>
</main>
</body>
</html>