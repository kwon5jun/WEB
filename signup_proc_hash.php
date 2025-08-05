<!-- 회원가입 처리 -->
<?php
    require_once 'db_connect.php';

    $id = $_POST['username'];
    $password = $_POST['password'];
    $password_check = $_POST['password_check'];

    if (!isset($password) || empty($password) || !isset($password_check) || empty($password_check)) {
        // 비밀번호가 비어있는 경우
        echo '<script>alert("비밀번호를 입력해주세요.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    }

    if ($password !== $password_check) {
        // 비밀번호가 일치하지 않을 경우
        echo '<script>alert("비밀번호가 일치하지 않습니다. 다시 확인해주세요.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    }

    // 비밀번호 자릿수 검증
    if (strlen($password) < 8) {
        // 비밀번호가 8글자 미만인 경우
        echo '<script>alert("비밀번호는 8글자 이상이어야 합니다.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    }

    //$sql = "SELECT name FROM access WHERE name='$id'";
    // injection 방지: mysqli_prepare 사용
    $stmt = mysqli_prepare($conn, "SELECT name FROM access WHERE name = ?");
    if (!$stmt) {
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $userid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    if ($row) {
        // 아이디가 이미 존재하는 경우
        echo '<script>alert("이미 존재하는 아이디입니다.");</script>';
        echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        exit();
    } else {
        // 아이디가 존재하지 않는 경우, 회원가입 진행
        $encrypted_passwd  = password_hash($password, PASSWORD_DEFAULT); // password_hash를 사용한 비밀번호 해시화
        //$encrypted_passwd  = hash('sha256',$password); // sha256 해시화
        //$sql = "INSERT INTO access (name, password) VALUES ('$id', '$encrypted_passwd')";
        // injection 방지: mysqli_prepare 사용
        $stmt = mysqli_prepare($conn, "INSERT INTO access (name, password) VALUES (?, ?)");
        if (!$stmt) {
            echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
            exit();
        }
        mysqli_stmt_bind_param($stmt, 'ss', $id, $encrypted_passwd);
        mysqli_stmt_execute($stmt);
        // 쿼리 실행 후 성공 여부 확인
        if ($stmt->affected_rows > 0) {
            // 회원가입 성공
            echo '<script>alert("회원가입이 완료되었습니다.");</script>';
            echo '<script>window.location.href = "login.php";</script>'; // 로그인 페이지로 리다이렉트
        } else {
            // 회원가입 실패
            echo '<script>alert("회원가입에 실패했습니다. 다시 시도해주세요.");</script>';
            echo '<script>window.history.back();</script>'; // 이전 페이지로 돌아가기
        }
        mysqli_stmt_close($stmt); // prepared statement 닫기
        mysqli_close($conn); // 데이터베이스 연결 종료
    }

?>