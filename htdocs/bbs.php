<?php
if (isset($_GET["dbname"]) && isset($_GET["dbnamekana"])) {
  $dbname = htmlspecialchars($_GET["dbname"], ENT_QUOTES);
  $dbnamekana = htmlspecialchars($_GET["dbnamekana"], ENT_QUOTES);
  if (isset($_GET["page"])) {
    $page = htmlspecialchars($_GET["page"], ENT_QUOTES);
  } else {
    $page = "";
  }
} else {
  header("Location: list.php");
}
// ページングするための情報取得、設定
$name = "sqlite:db/".$dbname.".db";
$db = new PDO($name);
$stmt = $db->query("SELECT COUNT(*) FROM bbs");
$kensu = $stmt->fetchColumn(); // 総件数
$hyouji = 3; // 1ページあたり表示件数
$pcount = ceil($kensu/$hyouji); // 総ページ数
$plast = $kensu % $hyouji; // 最終ページの件数
if ($page == "") {
  $page = $pcount;
}

// ページ移動リンク
$link = "";
for ($i=1; $i<=$pcount; $i++) {
  $link .= "<a href=bbs.php?dbname=".$dbname."&dbnamekana=".$dbnamekana."&page=".$i.">".$i."</a>&nbsp;&nbsp;";
}

// ページ表示
$stmt = $db->query("SELECT * FROM bbs LIMIT ($page-1)*$hyouji, $hyouji");
$html = "<div class='bigbox'><h2>".$dbnamekana."</h2>";
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($list as $row) {
  $html .= $row["id"]." : ".$row["hiduke"]."<br>";
  $html .= "<div class='box' id='commnet'><p>".$row["comment"]."</p></div><br><br>";
}

// コメントにアンカーがあればアンカーに変換する
$html = anchor($dbname, $html);
$db = null;

// 総件数が10件未満であれば投稿画面を表示する
if ($kensu < 10) {
  $form = <<< EOM
  <form action="ins.php" method="post">
  <input type="hidden" name="dbname" value="{$dbname}">
  投稿内容:<br>
  <textarea name="comment" cols=100 rows=10></textarea><br>
  <input type="submit" name="ins" value="送信">
  </form>
  <br>
EOM;
} else {
  $form = "10件以上は書き込めません。<br><br>";
}

// コメント中にアンカーがあればアンカーリンクを付与する
function anchor($dbname, $comment) {
  $pattern = "/&gt;&gt;([0-9])+/";
  $replace = '<a href="link.php?dbname='.$dbname.'&num=$0">$0</a>';
  $comment = preg_replace($pattern, $replace, $comment);
  return $comment;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<title><?php echo $dbnamekana; ?></title>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0">
<link rel="stylesheet" href="style.css" media="all">
</haed>
<body>
<main>

<?php echo $html; ?>
<?php echo $form; ?>
<?php echo $link; ?>
<br><br>
<a href="list.php">掲示板に戻る</a>
</main>
</body>
</html>