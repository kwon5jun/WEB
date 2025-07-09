<!-- 게시글 쓰기 처리 -->
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

        // SQL Injection 방지
        $title = mysqli_real_escape_string($conn, $title);
        $author = mysqli_real_escape_string($conn, $author);
        $content = mysqli_real_escape_string($conn, $content);

        // 데이터베이스에 게시글 저장
        $query = "INSERT INTO board (title, author, content, date) VALUES ('$title', '$author', '$content', NOW())";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('게시글이 작성되었습니다.');</script>";
            echo "<script>window.location.href = 'board.php';</script>";
        } else {
            echo "<script>alert('게시글 작성에 실패했습니다.');</script>";
            echo "<script>javascript:history.back();</script>";
        }
    }
    // 데이터베이스 연결 종료
    mysqli_close($conn);

?>