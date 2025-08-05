<!-- 마이페이지 수정처리 -->
<?php
    require_once 'db_connect.php';
    require_once 'get_jwt.php';
    if (!isset($userid) || empty($userid)) {
        echo "<script>alert('로그인 해주세요');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
        exit();
    }

    $id = $_POST['username'];
    $email = $_POST['email'];
    $score = $_POST['score'];

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

    // injection 방지: mysqli_prepare 사용 "UPDATE access SET useremail='$email', password='$encrypted_passwd', score='$score' WHERE name='$id'"
    $stmt = mysqli_prepare($conn, "UPDATE access SET useremail = ?, score = ? WHERE name = ?");
    if (!$stmt) {
        echo '<script>alert("SQL 준비에 실패했습니다. 다시 시도해주세요.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'sss', $email, $score, $userid);
    mysqli_stmt_execute($stmt);
    // 쿼리 실행 후 성공 여부 확인
    if ($stmt->affected_rows > 0) {
        echo '<script>alert("회원정보가 업데이트되었습니다.");</script>';
        echo '<script>window.location.href = "mypage.php";</script>'; // 마이페이지로 리다이렉트
    } else {
        echo '<script>alert("회원정보 업데이트에 실패했습니다. 다시 시도해주세요.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
    }

?>