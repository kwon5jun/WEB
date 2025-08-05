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
                <br>
                <span id="passwordError" style="color: red;"></span>
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

            isValid = validatePassword() && isValid;
            isValid = checkPasswordMatch() && isValid;

            if (isValid) {
                // 검증이 통과되면 폼을 제출합니다.
                //alert("제출");
                //console.log("mypageForm element:", document.getElementById('mypageForm'));
                //console.log("Type of mypageForm:", typeof document.getElementById('mypageForm'));
                document.getElementById('signupForm').submit();
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