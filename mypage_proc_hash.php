<!-- 마이페이지 수정처리 -->
<?php
    require_once 'db_connect.php';
    $id = $_POST['username'];
    $password = $_POST['password'];
    $password_check = $_POST['password_check'];
 
    $email = $_POST['email'];
    $score = $_POST['score'];

    if ($password !== $password_check) {
        // 비밀번호가 일치하지 않을 경우
        echo '<script>alert("비밀번호가 일치하지 않습니다. 다시 확인해주세요.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // 이메일 형식이 유효하지 않은 경우
        echo '<script>alert("유효한 이메일 주소를 입력해주세요.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    }

    if (!is_numeric($score) || $score < 0) {
        // 점수가 유효하지 않은 경우
        echo '<script>alert("유효한 점수를 입력해주세요.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    }

    //$encrypted_passwd  = password_hash($password, PASSWORD_DEFAULT); // password_hash를 사용한 비밀번호 해시화
    $encrypted_passwd  = hash('sha256',$password); // sha256 해시화

    $sql = "UPDATE access SET useremail='$email', password='$encrypted_passwd', score='$score' WHERE name='$id'";
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("회원정보가 업데이트되었습니다.");</script>';
        echo '<script>window.location.href = "mypage.php";</script>'; // 마이페이지로 리다이렉트
    } else {
        echo '<script>alert("회원정보 업데이트에 실패했습니다. 다시 시도해주세요.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
    }

?>