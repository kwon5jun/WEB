<!-- 회원가입 페이지 -->
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="container">
        <section>
        <h2>회원가입</h2>
        <!-- <form id="signupForm" class="login-form" method="post" action="./signup_proc.php" onsubmit="return validateForm(event)"> -->
        <form id="signupForm" class="login-form" method="post" action="./signup_proc_hash.php" onsubmit="return validateForm(event)">
            <div class="form-group">
                <label for="username">아이디</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">비밀번호</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_check">비밀번호 확인</label>
                <input type="password" id="password_check" name="password_check" required>
                <br>
                <span id="passwordMatchError" style="color: red;"></span>
            </div>
            <br>
            <button type="submit" class="login-button" name="signup">가입하기</button>
        </form>
        <p>이미 계정이 있으신가요? <a href="login.php">로그인</a></p>
        </section>
        </div>
    </main>
    <script>
        function validateForm(event) {
            event.preventDefault(); // 기본 폼 제출 동작 방지

            let isValid = true;

            if (checkPasswordMatch()) {
                // 검증이 통과되면 폼을 제출합니다.
                //alert("제출");
                console.log("signupForm element:", document.getElementById('signupForm'));
                console.log("Type of signupForm:", typeof document.getElementById('signupForm'));
                document.getElementById('signupForm').submit();
            } else {
                // 검증 실패 시에는 오류 메시지가 표시되므로 폼을 제출하지 않습니다.
                alert("비밀번호가 일치하지 않습니다. 다시 확인해주세요.");
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