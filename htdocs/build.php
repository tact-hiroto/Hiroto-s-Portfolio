// 掲示板の追加処理
<?php
if (isset($_POST["newbbs"])) {
  $newdbname = htmlspecialchars($_POST["newdbname"], ENT_QUOTES);
  $newdbnamekana = htmlspecialchars($_POST["newdbnamekana"], ENT_QUOTES);
  $db = new PDO("sqlite:db/list.db");
  $db->exec("INSERT INTO list (dbname, dbnamekana) VALUES ('$newdbname', '$newdbnamekana')");
  $name = "db/".$newdbname.".db";
  $db = new SQLite3($name);
  $db->exec("CREATE TABLE bbs (id INTEGER PRIMARY KEY, hiduke TEXT, comment TEXT)");
  $db = null;
  echo "新しい掲示板「".$newdbnamekana."」を作りました。<br><br>";
  echo "<a href='list.php'>掲示板へ戻る</a>";
}
?>