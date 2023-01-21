<?php
// 投稿日時等を取得する
$w = date("w");
$week_name = ["日", "月", "火", "水", "木", "金", "土"];
$hiduke = date("Y-m-d H:i:s")."(".$week_name[$w].")";

$html = "";

// データ受取、変換処理
if (isset($_POST["ins"])) {
  $dbname = htmlspecialchars($_POST["dbname"], ENT_QUOTES);
  $comment = nl2br(htmlspecialchars($_POST["comment"], ENT_QUOTES));
  $comment = anchor($comment);
    // 軽く制限かけてみた
    if (check_br($comment) > 10) {
        $html .= "改行が多過ぎます。10行以内でお願いします。<br><br>";
    }
    else if (check_strcount($comment) > 100) {
        $html .= "文字数が多過ぎます。100文字以内でお願いします。<br><br>";
    } else {
        // 投稿処理
        $name = "sqlite:db/".$dbname.".db";
        $db = new PDO($name);
        $db->exec("INSERT INTO bbs (hiduke, comment) VALUES ('$hiduke', '$comment')");
        // 件数を取得し直す
        $stmt = $db->query("SELECT COUNT(*) FROM bbs");
        $kensu = $stmt->fetchColumn();
        // list.dbの件数、更新日時を更新しておく（これで掲示板リスト画面で一番上に表示されるようになる）
        $db = new PDO("sqlite:db/list.db");
        $db->exec("UPDATE list SET kensu=$kensu, updtime=(SELECT datetime('now', '+09:00:00')) WHERE dbn
        ame='$dbname'");
        $db = null;
        $html .= "投稿しました。<br><br>";
    }
} else {
  header("Location: list.php");
}

// アンカーをリンク付きに変換する
function anchor($comment) {
  $pattern = "/>>([0-9])+/";
  $replace = '<a href="link.php?num=$0">$0</a>';
  $comment = preg_replace($pattern, $replace, $comment);
  return $comment;
}

// 改行数をカウントする
function check_br($comment) {
  $brcount = mb_substr_count($comment, "<br />");
  return $brcount;
}

// 文字数をカウントする
function check_strcount($comment) {
  $strcount = strlen($comment);
  return $strcount;
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
<a href=list.php>掲示板に戻る</a>
</body>
</html>