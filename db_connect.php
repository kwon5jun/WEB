<?php
$servername = ""; // MySQL 서버 주소
$username = ""; // MySQL 사용자 이름
$password = ""; // MySQL 비밀번호
$dbname = ""; // 데이터베이스 이름
$port = 3306; // MySQL 포트 번호 (기본값)

// db_information.php 파일을 포함하여 데이터베이스 연결 설정
// 위 변수에서 설정시 주석처리하여 제거
require_once '../db_information.php';


// MySQL 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname, $port);
$conn->set_charset("utf8");
// 연결 확인
if ($conn->connect_error) {
    // 연결 실패 시 에러 메시지 출력
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully"; // 연결 성공 시 메시지 출력

//DB 구조
// CREATE TABLE `access` (
//   `idx` int(8) NOT NULL AUTO_INCREMENT,
//   `name` varchar(50) COLLATE utf8_general_ci NOT NULL,
//   `password` varchar(500) COLLATE utf8_general_ci NOT NULL,
//   `score` int(4) DEFAULT NULL,
//   `useremail` varchar(100) COLLATE utf8_general_ci DEFAULT NULL,
//   PRIMARY KEY (`idx`)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

// CREATE TABLE `board` (
//   `idx` int(100) NOT NULL AUTO_INCREMENT,
//   `title` varchar(500) COLLATE utf8_general_ci NOT NULL,
//   `content` varchar(5000) COLLATE utf8_general_ci NOT NULL,
//   `author` varchar(500) COLLATE utf8_general_ci NOT NULL,
//   `date` datetime DEFAULT NULL,
//   PRIMARY KEY (`idx`)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


?>
