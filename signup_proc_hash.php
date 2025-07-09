<!-- 회원가입 처리 -->
<?php
    require_once 'db_connect.php';
    $id = $_POST['username'];
    $password = $_POST['password'];
    $password_check = $_POST['password_check'];

    if ($password !== $password_check) {
        // 비밀번호가 일치하지 않을 경우
        echo '<script>alert("비밀번호가 일치하지 않습니다. 다시 확인해주세요.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    }

    $sql = "SELECT name FROM access WHERE name='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if ($row) {
        // 아이디가 이미 존재하는 경우
        echo '<script>alert("이미 존재하는 아이디입니다.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    } else {
        // 아이디가 존재하지 않는 경우, 회원가입 진행
        //$encrypted_passwd  = password_hash($password, PASSWORD_DEFAULT); // password_hash를 사용한 비밀번호 해시화
        $encrypted_passwd  = hash('sha256',$password); // sha256 해시화
        $sql = "INSERT INTO access (name, password) VALUES ('$id', '$encrypted_passwd')";
        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("회원가입이 완료되었습니다.");</script>';
            echo '<script>window.location.href = "login.php";</script>'; // 로그인 페이지로 리다이렉트
        } else {
            echo '<script>alert("회원가입에 실패했습니다. 다시 시도해주세요.");</script>';
            echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        }
    }

?>