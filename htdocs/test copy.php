

<form action="test.php" method="post">
<p>メッセージ：<br>
<textarea name="msg" rows="5" cols="60"></textarea><br>
<input type="submit" value="送る">
<input type="reset" value="クリア"></p>
<a href=eddit.php>投稿済み内容を編集</a>
</form>


<?php
// phpinfo();
  try {
    $db = new PDO('sqlite:sample.sqlite3');
    if (@$_POST['msg'] != '') {
      date_default_timezone_set('Asia/Tokyo');
      $s = $db->prepare("insert into okumurabbs values(NULL, ?, ?)");
      $p = date("Y-m-d H:i:s");
      $s->bindParam(1, $p);
      $s->bindParam(2, $_POST['msg']);
      $s->execute()
        or die("<p>書き込みに失敗しました</p>");
    }
    $sql = "select * from okumurabbs order by id desc limit 9";
    echo "<table border=\"1\">\n";
    echo "<tr><th>番号</th><th>日時</th><th>メッセージ</th></tr>\n";
    foreach ($db->query($sql) as $a) {
      echo "<tr><td>", $a['id'], "</td><td>", $a['t'], "</td><td>",
           htmlspecialchars($a['msg']), "</td></tr>\n";
    }
    echo "</table>\n";
    $db = null;
  } catch (PDOException $e) {
    echo "<p>エラー：", $e->getMessage(), "</p>";
  }
?>