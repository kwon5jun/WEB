<!-- 로그인 처리 -->
<?php
    require_once 'db_connect.php';
    require_once './vendor/autoload.php';
    use Firebase\JWT\JWT;
    $secret_key = "this-is-the-secret";

    $id = $_POST['username'];
    $password = $_POST['password'];
    //echo $id . " / " . $password . "<br>";

// /***** 아이디와 비밀번호를 동시에 확인 직접 해시값 제작으로 로그인 *****
    $encrypted_passwd  = hash('sha256',$password); // sha256 해시화
    $sql = "SELECT * FROM access WHERE name='$id' and password='$encrypted_passwd'";
    $result = mysqli_query($conn, $sql);
    //var_dump($result); // 디버깅용 코드

    if (mysqli_num_rows($result) > 0) {
        //echo "성공";
        $data = array(
            'id' => $id,
            'exp' => time() + (600), // 토큰 만료 시간 (10분)
        );
        $jwt = JWT::encode($data, $secret_key,'HS256');
        setcookie('jwt', $jwt, time() + (3600), "/"); // 쿠키에 JWT 저장 (30일 유효기간 : 86400 * 30) 
        header('Location: index.php'); // 로그인 성공 시 index.php로 리다이렉트
        exit();
    } else {
        //echo "실패";
        echo '<form id="returnForm" method="POST" action="login.php">';
        echo '<input type="hidden" name="returned_value" value="아이디 또는 비밀번호가 잘못되었습니다.">';
        echo '</form>';
        echo '<script>document.getElementById("returnForm").submit();</script>';
        exit();
    }
// ***** 아이디와 비밀번호를 동시에 확인 *****/


 /*****아이디와 비밀번호 각각확인 *****
    $sql = "SELECT password FROM access WHERE name='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    //var_dump($row); // 디버깅용 코드

    if (mysqli_num_rows($result) > 0) {
        // 비밀번호 확인
        if (password_verify($password, $row['password'])) {
            //echo "성공";
            $_SESSION['loggedin'] = true; // 로그인 상태를 나타내는 변수
            $_SESSION['username'] = $id; // 사용자 아이디 저장 (선택 사항)
            header('Location: index.php'); // 로그인 성공 시 index.php로 리다이렉트
            exit();
        } else {
            //echo "실패";
            echo '<form id="returnForm" method="POST" action="login.php">';
            echo '<input type="hidden" name="returned_value" value="비밀번호가 잘못되었습니다.">';
            echo '</form>';
            echo '<script>document.getElementById("returnForm").submit();</script>';
            exit();
        }
    } else {
        //echo "실패";
        echo '<form id="returnForm" method="POST" action="login.php">';
        echo '<input type="hidden" name="returned_value" value="아이디가 잘못되었습니다.">';
        echo '</form>';
        echo '<script>document.getElementById("returnForm").submit();</script>';
        exit();
    }
 *****아이디와 비밀번호 각각확인 *****/


    mysqli_close($conn);

  
?>