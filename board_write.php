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
    <script type="text/javascript">

		function checkFileExtension(fileName) {
			
  			var reg = /(.*?)\.(jpg|jpeg|png|gif|bmp|txt)$/;
			var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

			if(fileName==""){return true;}
			if(!allowedExtensions.exec(fileName)) {
  				alert('업로드할 수 없는 확장자의 파일입니다.');
  				writeFrm.upload_file.value = '';
  				return false;
			}else{
				return true;
		}
			 
			return true;
		}
    </script>
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
    <div class="container">
            <section class="board-section">
                <h2>자유 게시판 (쓰기)</h2> 
                <!-- 글쓰기 폼 -->
                <form class="board-form" method="post" action="board_write_proc.php" enctype="multipart/form-data" onsubmit="return checkFileExtension(writeFrm.upload_file.value)">
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
                <input class = "upload" name = "upload_file" type = "file" accept = "image/png, image/jpeg"/>
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