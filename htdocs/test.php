<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">

    <title>Document</title>
    <link rel="stylesheet" href="portfolio/page_one/one.css">
</head>
<body>
    <div class="menu" onclick="ToMenu()"></div>
    <div class="nav">
        <div class="navarea">
            <ul>
                <li><a href="portfolio/index.html" onmouseenter="changeImage('portfolio/img_home/wood3.png')">home</a></li>
                <li><a href="portfolio/page_three/threep1.html" onmouseenter="changeImage('portfolio/img_home/wood1.png')">about</a></li>
                <li><a href="test.php" onmouseenter="changeImage('portfolio/img_home/wood2.png')">portfolio</a></li>
                <li><a href="portfolio/page_two/two.html" onmouseenter="changeImage('portfolio/img_home/wood5.png')">contact</a></li>
            </ul>
        </div>
        <div class="imgarea">
            <img src="portfolio/img_home/wood3.png" id="slider">
        </div>
    </div>
    <div class="cont">
        <div class="card">
            <div class="content">
                <h2>E</h2>
                <h3>Eddit</h3>
                <p>カードの追加<br>and<br>追加したカードの編集<br>ができます</p>
                <a href="eddit.php">Card Eddit</a>
            </div>
        </div>
        <div class="card">
            <div class="content">
                <h2>O</h2>
                <h3>Old</h3>
                <p>掲示板サイト<br>このサイトの前に<br>試しに作りました</p>
                <a href="list.php">Old ver</a>
            </div>
        </div>
        <div class="card">
            <div class="content">
                <h2>0</h2>
                <h3>Card</h3>
                <p>紹介例最後のカード<br>例<br>例</p>
                <a href="#">Read More</a>
            </div>
        </div>
    
                  <!-- ./sqlite3 sample.sqlite3
                  create table okumurabbs(id integer primary key, t text, msg text); -->
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
        //   ここを変える　desc
          foreach ($db->query($sql) as $a) {
            echo "<div class=\"card\">\n";
            echo "    <div class=\"content\">\n";
            echo "        <h2>", $a['id'],"</h2>\n";
            echo "        <h3>Card</h3>\n";
            echo "        <p>",htmlspecialchars($a['msg']),"</p>\n";
            echo "    </div>\n";
            echo "</div>\n";
          }
          $db = null;
        } catch (PDOException $e) {
          echo "<p>エラー：", $e->getMessage(), "</p>";
        }
      ?>
    </div>
<script type="text/javascript" src="portfolio/page_one/vanilla-tilt.js"></script>
    <script>
        VanillaTilt.init(document.querySelectorAll(".card"), {
          max: 25,
          speed: 400,
          glare: true,
          "max-glare": 0.5
	      });
    </script>
    <script>
        function changeImage(anyhing){
            document.getElementById('slider').src = anyhing;
        }

        function ToMenu(){
            const menu = document.querySelector('.menu');
            const nav = document.querySelector('.nav');
            menu.classList.toggle('active')
            nav.classList.toggle('active')
        }
    </script>
</body>
</html>
