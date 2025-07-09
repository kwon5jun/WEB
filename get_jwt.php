<!-- jwt 검증처리 -->
<?php
require_once './vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
$secret_key = "this-is-the-secret";

// 쿠키에서 jwt 가져오기
$jwt = isset($_COOKIE['jwt']) ? $_COOKIE['jwt'] : null;
if (isset($jwt)) {

    // validate jwt 로그인된 상태 
    try {
        $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
        $decoded_array = (array)$decoded;
        $result = array(
            'code' => 200,
            'status' => 'success',
            'jwt_payload' => $decoded_array
        );
        $userid = $decoded_array['id'];
        //echo $userid;
        //로그인이 되어있다면 토큰갱신
        $data = array(
            'id' => $userid,
            'exp' => time() + (600), // 토큰 만료 시간 (10분)
        );
        $jwt = JWT::encode($data, $secret_key,'HS256');
        setcookie('jwt', $jwt, time() + (3600), "/"); // 쿠키에 JWT 저장 (유효기간 : 30분)
        
    } catch (\Exception $e) {
        $result = array(
            'code' => 0,
            'status' => 'error',
            'message' => $e->getMessage().' Invalid JWT - Authentication failed!'
        );
        // 만료된 토큰일 때만 메시지 출력
        if (strpos($e->getMessage(), 'Expired') !== false) {
            echo '<script>alert("로그아웃 되었습니다.");location.reload();</script>';
        } else {
            echo '<script>alert("로그아웃 되었습니다."); location.href="index.php";</script>';
        }
        setcookie('jwt', '', time() - 3600, '/'); // 쿠키 삭제
        exit();
    }

} else {
    $result = array(
        'code' => 0,
        'status' => 'error',
        'message' => 'JWT parameter missing!'
    );
}
//echo json_encode($result);
?>