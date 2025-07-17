<?php
	$target_dir = "./files";
	$filePath = $_REQUEST['filePath'];

    //$filePath = str_repeat("../", "", $filePath);
	$filePath = preg_replace('/\.\.[\\\\\/]+/', '', $filePath);

	$fullPath = $target_dir . $filePath;

	if(file_exists($fullPath)){
		header("Content-Type:application/octet-stream");
    		header("Content-Disposition:attachment;filename=$file");
    		header("Content-Transfer-Encoding:binary");
    		header("Content-Length:".filesize($fullPath));
    		header("Cache-Control:cache,must-revalidate");
    		header("Pragma:no-cache");
    		header("Expires:0");
		
		if(is_file($fullPath)){
        		$fp = fopen($fullPath,"r");
        		while(!feof($fp)){
          			$buf = fread($fp,8096);
          			$read = strlen($buf);
          			print($buf);
          			flush();
        		}
        		fclose($fp);
    		}
	}else{
?>
		<script>alert('파일이 없습니다.');history.back();</script>
<?php
	}

?>