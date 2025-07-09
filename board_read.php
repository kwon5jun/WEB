<!--게시글 조회 페이지 -->
<!DOCTYPE html>
<html lang="ko">
<?php
require_once 'db_connect.php';
require_once 'get_jwt.php';
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
                <h2>자유 게시판 (읽기)</h2>
                <?php
                        $query = "select * from board where idx = ".$_GET['idx'];
                        $result = mysqli_query($conn, $query);

                        $data= mysqli_fetch_array($result);

                ?>  
                <form class="board-form" method="post" action="board_write_proc.php">
                    <div class="form-group">
                        <label for="author">작성자</label>
                        <input type="text" id="author" name="author" value="<?=$data['author']?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="title">제목</label>
                        <input type="text" id="title" name="title" value="<?=$data['title']?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="content">내용</label>
                        <div id="content" class="content-view">
                            <?= nl2br($data['content']) ?>
                            <!-- <?= nl2br(htmlspecialchars($data['content'])) ?> -->
                        </div>
                    </div>

                <h2></h2>
                <!-- 뒤로가기 버튼 -->
                <div>
                    <a class="button-container" href="javascript:history.back()" class="back-button">목록으로</a>
                <!-- 수정버튼 -->
                <?php
                    if($userid == $data['author']){
                ?>
                    <a class="button-container" href="board_update.php?idx=<?=$data['idx']?>">수정</a>
                <?php
                    }   
                ?>
                <!-- 삭제버튼 -->
                <?php
                    if($userid == $data['author']){ 
                ?>
                    <a class="button_del-container " href="board_delete.php?idx=<?=$data['idx']?>">삭제</a>
                <?php
                    }
                ?>
                </div>
                </form>

            </section>
        </div>
    </main>
</body>
</html>