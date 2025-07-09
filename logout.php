<!-- 로그아웃 처리 -->
<?php
// 쿠키에 저장된 JWT를 삭제합니다.
// 쿠키의 경로를 '/'로 설정하여 모든 경로에서 쿠키를 삭제합니다.
// 쿠키의 만료 시간을 과거로 설정하여 삭제합니다.
$cookie_name = 'jwt';
$cookie_value = isset($_COOKIE[$cookie_name]) ? $_COOKIE[$cookie_name] : null;
if (isset($cookie_value)) {
    unset($_COOKIE[$cookie_name]); // 쿠키 삭제
    setcookie($cookie_name, '', time() - 3600, '/'); // 쿠키 만료 시간을 과거로 설정
}


// 로그아웃 후 리다이렉션할 페이지로 이동합니다.
header('Location: index.php');
exit;
?>