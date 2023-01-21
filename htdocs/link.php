// アンカーをクリックしたときにそのコメントを別ページに表示
<?php
if (isset($_GET["dbname"]) && isset($_GET["num"])) {
  $dbname = htmlspecialchars($_GET["dbname"]);
  $num = htmlspecialchars($_GET["num"]);
  $num = substr($num, 8);
  $name = "sqlite:db/".$dbname.".db";
  $db = new PDO($name);
  $stmt = $db->query("SELECT * FROM bbs WHERE id=$num");
  $html = "";
  while ($row = $stmt->fetch()) {
    $html .= $row["id"].":".$row["hiduke"]."<br>".$row["comment"];
  }
  $db = null;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>サンプル掲示板</title>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0">
<link rel="stylesheet" href="style.css" media="all">
</head>
<body>
<?php echo $html; ?>
</body>
</html>