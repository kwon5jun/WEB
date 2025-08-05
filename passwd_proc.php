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
    $password_old = $_POST['password_old'];
    $password = $_POST['password'];
    $password_check = $_POST['password_check'];

    if (!isset($password) || empty($password) || !isset($password_check) || empty($password_check) || !isset($password_old) || empty($password_old)) {
        // 비밀번호가 비어있는 경우
        echo '<script>alert("입력칸이 비어있습니다.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    }

    if ($password !== $password_check) {
        // 비밀번호가 일치하지 않을 경우
        echo '<script>alert("비밀번호가 일치하지 않습니다. 다시 확인해주세요.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    }

    // 비밀번호 8글자 미만 자릿수 검증
    if (strlen($password) < 8) {
        echo '<script>alert("비밀번호는 8글자 이상이어야 합니다.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    }

    // 현재 비밀번호 검증
    $stmt = mysqli_prepare($conn, "SELECT password FROM access WHERE name = ?");
    if (!$stmt) {
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $userid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    if (mysqli_num_rows($result) > 0) {
        // 현재 비밀번호 확인
        if (!password_verify($password_old, $row['password'])) {
            echo '<script>alert("현재 비밀번호가 잘못되었습니다.");</script>';
            echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
            exit();
        }
    } else {
        echo '<script>alert("사용자 정보를 찾을 수 없습니다.");</script>';
        echo '<script>window.location.href = "index.php";</script>';
        exit();
    }


    $encrypted_passwd  = password_hash($password, PASSWORD_DEFAULT); // sha256 해시화

    // injection 방지: mysqli_prepare 사용 "UPDATE access SET useremail='$email', password='$encrypted_passwd', score='$score' WHERE name='$id'"
    $stmt = mysqli_prepare($conn, "UPDATE access SET password = ? WHERE name = ?");
    if (!$stmt) {
        echo '<script>alert("SQL 준비에 실패했습니다. 다시 시도해주세요.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'ss', $encrypted_passwd, $userid);
    mysqli_stmt_execute($stmt);
    // 쿼리 실행 후 성공 여부 확인
    if ($stmt->affected_rows > 0) {
        echo '<script>alert("회원정보가 업데이트되었습니다.\n로그아웃됩니다.");</script>';
        echo '<script>window.location.href = "logout.php";</script>'; // 마이페이지로 리다이렉트
    } else {
        echo '<script>alert("회원정보 업데이트에 실패했습니다. 다시 시도해주세요.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
    }

?>