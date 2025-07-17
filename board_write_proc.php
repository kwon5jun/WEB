<!-- 게시글 쓰기 처리 -->
<?php
    require_once 'db_connect.php';
    require_once 'get_jwt.php';

    function fileCheck($fileName, $mime){

	$ext = pathinfo($fileName, PATHINFO_EXTENSION);

	$black_list = array('php','jsp','asp','phtml','php3','php5','php7');

	if(strstr($ext, "php")!=false){
		return false;
	}

	if(in_array($ext, $black_list)){
		return false;
	}else{
/*
		$allow_types = ['image/png','image/jpeg','application/pdf'];

		echo "<debug>" . $mime . "</debug>";
		if(!in_array($mime, $allow_types)){
			return false;
		}
 */
		return true;
	}
}

    if (!isset($userid) || empty($userid)) {
        echo "<script>alert('로그인 해주세요');</script>";
        echo "<script>javascript:history.back();</script>";
        exit();
    } 

    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $content = $_POST['content'];
        
        // 파일 업로드 처리
        //echo $_FILES['upload_file']['name'];
        if($_FILES['upload_file'] != NULL){
            $tmp_name = $_FILES['upload_file']['tmp_name'];
            $name = $_FILES['upload_file']['name'];
            $path = "./files/$author";
            $mime_res = mime_content_type($tmp_name);
            if(fileCheck($name, $mime_res) === false){
                echo "<script>alert('업로드 될 수 없는 파일이 탐지되었습니다. " . $name ."');</script>";
                $name = "NULL";
            } else {
                if(!file_exists($path)){
                    mkdir($path, 0777, true);
                    chmod($path, 0777);
                }
                $up = move_uploaded_file($tmp_name, "$path/$name");
            }
            
        } else {
            $name = "NULL";
        }

        // SQL Injection 방지
        $title = mysqli_real_escape_string($conn, $title);
        $author = mysqli_real_escape_string($conn, $author);
        $content = mysqli_real_escape_string($conn, $content);

        // 데이터베이스에 게시글 저장
        $query = "INSERT INTO board (title, author, content, file, date) VALUES ('$title', '$author', '$content', '$name', NOW())";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('게시글이 작성되었습니다.');</script>";
            echo "<script>window.location.href = 'board.php';</script>";
        } else {
            echo "<script>alert('게시글 작성에 실패했습니다.');</script>";
            echo "<script>javascript:history.back();</script>";
	}
} else {
        echo "<script>alert('잘못된 접근입니다.');</script>";
        echo "<script>javascript:history.back();</script>";
}
    // 데이터베이스 연결 종료
    mysqli_close($conn);

?>