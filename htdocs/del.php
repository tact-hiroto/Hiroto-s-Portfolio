// 掲示板の削除処理
<?php
if (isset($_GET["dbname"])) {
  $dbname = htmlspecialchars($_GET["dbname"], ENT_QUOTES);
  $db = new PDO("sqlite:db/list.db");
  $db->exec("DELETE FROM list WHERE dbname='$dbname'");
  $name = "db/".$dbname.".db";
  // ファイルごとにスレがあるのでファイルごと消せばいい
  unlink($name);
  echo "削除しました。<br><br>";
  echo "<a href='list.php'>掲示板へ戻る</a>";
}
?>