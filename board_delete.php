<!--게시글 삭제 페이지 -->
<!DOCTYPE html>
<html lang="ko">
<?php
require_once 'db_connect.php';
require_once 'get_jwt.php';
if (!isset($userid) || empty($userid)) {
    echo "<script>alert('로그인 해주세요');</script>";
    echo "<script>javascript:history.back();</script>";
    exit();
}
$_GET['idx']
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>
    <script>
        // 확인창을 띄우고 사용자가 확인을 누르면 삭제 진행
        // 취소를 누르면 삭제 취소
        if (confirm('정말 삭제하시겠습니까?')) {
            // 삭제 진행
            window.location.href = 'board_delete_proc.php?idx=<?=$_GET['idx']?>';
        } else {
            // 삭제 취소
            javascript:history.back();
            exit();
        }
    </script>

</head>
</html>