<!-- 마이페이지 -->
<!DOCTYPE html>
<html lang="ko">
<?php
require_once 'db_connect.php';
require_once 'get_jwt.php';
if (!isset($userid) || empty($userid)) {
    echo "<script>alert('로그인 해주세요');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
} else {
    $username = $userid;
    $sql = "SELECT * FROM access WHERE name='$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if ($row) {
        $email = $row['useremail'];
        $score = $row['score'];
    } else {
        echo "<script>alert('사용자 정보를 찾을 수 없습니다.');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
        exit();
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>비밀번호 변경</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="container">
            <section>
                <h2>마이페이지 - 비밀번호 변경</h2>
                <form id="mypageForm" class="login-form" method="post" action="./passwd_proc.php" onsubmit="return validateForm(event)">
                    <div class="form-group">
                        <label for="password_old">현재 비밀번호</label>
                        <input type="password" id="password_old" name="password_old" required>
                        <br>
                        <span id="passwordError" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="password">비밀번호</label>
                        <input type="password" id="password" name="password" required>
                        <br>
                        <span id="passwordError" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="password_check">비밀번호 확인</label>
                        <input type="password" id="password_check" name="password_check" required>
                        <br>
                        <span id="passwordMatchError" style="color: red;"></span>
                    </div>
                    <button type="submit" class="login-button" name="mypage">수정하기</button>
                </form>
                <h2></h2>
            </section>
        </dic>
    </main>
    <script>
        function validateForm(event) {
            event.preventDefault(); // 기본 폼 제출 동작 방지

            let isValid = true;

            isValid = validatePassword() && isValid;
            isValid = checkPasswordMatch() && isValid;

            if (isValid) {
                // 검증이 통과되면 폼을 제출합니다.
                //alert("제출");
                //console.log("mypageForm element:", document.getElementById('mypageForm'));
                //console.log("Type of mypageForm:", typeof document.getElementById('mypageForm'));
                document.getElementById('mypageForm').submit();
            } else {
                // 검증 실패 시에는 오류 메시지가 표시되므로 폼을 제출하지 않습니다.
                alert("입력정보를 다시 확인해주세요.");
            }
        }

        function validatePassword() {
            const passwordInput = document.getElementById('password');
            const errorSpan = document.getElementById('passwordError');
            const password = passwordInput.value;

            if (password.length < 8) {
                errorSpan.textContent = '비밀번호는 8글자 이상이어야 합니다.';
                return false;
            } else {
                errorSpan.textContent = '';
                return true;
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const passwordCheck = document.getElementById('password_check').value;
            const errorSpan = document.getElementById('passwordMatchError');

            if (password !== passwordCheck) {
                errorSpan.textContent = '비밀번호가 일치하지 않습니다.';
                return false;
            } else {
                errorSpan.textContent = '';
                return true;
            }
        }
    </script>
</body>
</html>