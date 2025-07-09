<!-- 로그인 페이지 -->
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="container">
        <section>
        <h2>로그인</h2>
            <!-- <form class="login-form" method="post" action="./login_proc.php"> -->
            <form class="login-form" method="post" action="./login_proc_hash.php">
                <div class="form-group">
                    <label for="username">아이디</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">비밀번호</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <a href="signup.php" class="signup-button">회원가입</a>
                <p>
                <button type="submit" class="login-button" name="submit">로그인</button>
                <?php
                if (isset($_POST['returned_value'])){
                    echo "<p>" . $_POST['returned_value'] . "</p>";
                }
                ?>
            
            </form>
            </section>
        </div>
    </main> 
</body>
</html>