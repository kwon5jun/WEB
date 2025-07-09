<!-- 검색처리 -->
<?php
require_once 'db_connect.php';
require_once 'get_jwt.php';
// 검색어 처리 넘어온 데이터를 board.php로 넘김
if(!empty($_GET['search'])){
    $search = $_GET['search'];
} else {
    header("Location: board.php");
    exit();
}

// 검색어 필터링
$search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
$search = trim($search); // 공백 제거
$search = preg_replace('/\s+/', '', $search); // 다중 공백을 단일 공백으로 변환
$search = mysqli_real_escape_string($conn, $search); // SQL 인젝션 방지
//$search = str_replace("'", "''", $search); // 작은 따옴표 이스케이프 처리
$search = preg_replace('/select/i', '', $search); // select 제거
header("Location: board.php?search=" . urlencode($search));
?>