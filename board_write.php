<!--게시판 글쓰기 페이지-->
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
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
    <div class="container">
            <section class="board-section">
                <h2>자유 게시판 (쓰기)</h2> 
                <!-- 글쓰기 폼 -->
                <form class="board-form" method="post" action="board_write_proc.php">
                    <div class="form-group">
                        <label for="author">작성자</label>
                        <input type="text" id="author" name="author" value="<?=$userid?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="title">제목</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div class="form-group form-content">
                        <label for="content">내용</label>
                        <textarea id="content" name="content" rows="10" required></textarea>
                    </div>

                <h2></h2>
                <!-- 뒤로가기 버튼 -->
                <div>
                    <a class="button-container" href="javascript:history.back()" class="back-button">목록으로</a>
                <!-- 작성버튼 -->
                    <button type="submit" class="button-container" name="submit">작성</button>
                </div>
                </form>
                
            </section>
        </div>
    </main>
</body>
</html>