<!-- 게시글 삭제 처리 -->
<?php
require_once 'db_connect.php';
require_once 'get_jwt.php';
if (!isset($userid) || empty($userid)) {
    echo "<script>alert('로그인 해주세요');</script>";
    echo "<script>javascript:history.back();</script>";
    exit();
}
if (isset($_GET['idx'])) {
    $idx = $_GET['idx'];

    // 게시글 정보 가져오기
    $query = "SELECT * FROM board WHERE idx='$idx'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_array($result);
    if (!$data) {
        echo "<script>alert('게시글을 찾을 수 없습니다.');</script>";
        echo "<script>javascript:history.back();</script>";
        exit();
    }
    // 게시글 작성자와 현재 사용자 비교
    if ($data['author'] !== $userid) {
        echo "<script>alert('삭제 권한이 없습니다.');</script>";
        echo "<script>javascript:history.back();</script>";
        exit();
    }
    unlink("./files/{$data['author']}/{$data['file']}");
    // 데이터베이스에 게시글 삭제
    $query = "DELETE FROM board WHERE idx='$idx'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('게시글이 삭제되었습니다.');</script>";
        echo "<script>window.location.href = 'board.php';</script>";
    } else {
        echo "<script>alert('게시글 삭제에 실패했습니다.');</script>";
        echo "<script>javascript:history.back();</script>";
    }
}
// 데이터베이스 연결 종료
mysqli_close($conn);
?>