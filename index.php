<!-- 메인 페이지 -->
<!DOCTYPE html>
<?php
require_once 'db_connect.php';
?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>과제 홈페이지</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php';?>
    <main>
        <div class="container">
        <section>
            <?php
            if (!isset($userid) || empty($userid)) {
                echo "<h2>로그인 해주세요</h2>";
                echo "<p>로그인 하시면 점수가 나옵니다.</p>";
            } else {
                echo "<h2>환영합니다, " . $userid . "님!</h2>";
                $sql = "SELECT score FROM access WHERE name='" . $userid . "'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                if ($row['score'] == null) {
                    echo "<p>아직 점수가 없습니다.</p>";
                    echo "<p>마이페이지에서 추가해주세요.</p>";
                } else {
                    echo "<p>당신의 점수는 " . $row['score'] ."점 입니다.</p>";
                    //if ($row['score'] == 100 & $userid == 'admin') {echo "<p> FLAG : test{test}</p>";}
                }
            }
            mysqli_close($conn);
            ?>
        </section>
        </div>
    </main>
</body>
</html>