<form action="eddit.php" method="post">
<p>id：<br>
<textarea name="id" rows="1" cols="10"></textarea><br><br>
編集メッセージ：<br>
<textarea name="msg" rows="5" cols="60"></textarea><br>
<input type="submit" value="修正">
<input type="reset" value="クリア"></p>
<a href=test.php>カード一覧に戻る</a>
</form>
<form action="eddit.php" method="post">
    <p>追加メッセージ：<br>
    <textarea name="nmsg" rows="5" cols="60"></textarea><br>
    <input type="submit" value="送る">
    <input type="reset" value="クリア"></p>
</form>

<?php
$pdo = new PDO('sqlite:sample.sqlite3');
    if (@$_POST['msg'] != '' && @$_POST['id'] != '') {
        date_default_timezone_set('Asia/Tokyo');
        $id = $_POST['id'];
        $t = date("Y-m-d H:i:s");
        $msg = $_POST['msg'];
        $stmt = $pdo->prepare("UPDATE okumurabbs SET msg = '$msg', t = '$t' WHERE id = $id");
        $res = $stmt->execute();
    } 
    elseif (@$_POST['nmsg'] != '') {
        date_default_timezone_set('Asia/Tokyo');
        $w = $pdo->prepare("insert into okumurabbs values(NULL, ?, ?)");
        $p = date("Y-m-d H:i:s");
        $w->bindParam(1, $p);
        $w->bindParam(2, $_POST['nmsg']);
        $w->execute()
        or die("<p>書き込みに失敗しました</p>");
    }
    $sql = "select * from okumurabbs order by id desc limit 20";
    echo "<table border=\"1\">\n";
    echo "<tr><th>番号</th><th>日時</th><th>メッセージ</th></tr>\n";
    foreach ($pdo->query($sql) as $a) {
      echo "<tr><td>", $a['id'], "</td><td>", $a['t'], "</td><td>", htmlspecialchars($a['msg']), "</td></tr>\n";
    }
    echo "</table>\n";
    $pdo = null;



?>