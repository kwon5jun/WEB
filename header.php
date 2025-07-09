<!--헤더 페이지 -->
<header>
<?php include 'get_jwt.php';?>
    <h1>과제 홈페이지</h1>
    <nav>
        <ul>
            <li><a href="index.php">홈</a></li>
            <li><a href="board.php">게시판</a></li>
            <li><a href="mypage.php">마이페이지</a></li>
            <?php
            if (!isset($userid) || empty($userid)) {
                echo "<li><a href='login.php' class='login-button'> 로그인 </a></li>";
            } else {
                echo "<li><a href='logout.php' class='login-button'> 로그아웃 </a></li>";
            }
            ?>
        </ul>
    </nav>
</header>