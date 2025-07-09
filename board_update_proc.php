<!--게시판 수정 처리 -->
<?php
    require_once 'db_connect.php';
    require_once 'get_jwt.php';
    

    if (!isset($userid) || empty($userid)) {
        echo "<script>alert('로그인 해주세요');</script>";
        echo "<script>javascript:history.back();</script>";
        exit();
    } 

    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $content = $_POST['content'];
        $idx = $_POST['idx'];

        if(empty($title) || empty($author) || empty($content)) {
            echo "<script>alert('모든 필드를 입력해주세요.');</script>";
            echo "<script>javascript:history.back();</script>";
            exit();
        }
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
            echo "<script>alert('수정 권한이 없습니다.$test');</script>";
            echo "<script>javascript:history.back();</script>";
            exit();
        }

        // SQL Injection 방지
        // $title = mysqli_real_escape_string($conn, $title);
        // $author = mysqli_real_escape_string($conn, $author);
        $content = mysqli_real_escape_string($conn, $content);
        // $idx = mysqli_real_escape_string($conn, $idx);

        // 데이터베이스에 게시글 수정
        $query = "UPDATE board SET title='$title', author='$author', content='$content' WHERE idx='$idx'";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('게시글이 수정되었습니다.');</script>";
            echo "<script>window.location.href = 'board.php';</script>";
        } else {
            echo "<script>alert('게시글 수정에 실패했습니다.');</script>";
            echo "<script>javascript:history.back();</script>";
        }
    }
