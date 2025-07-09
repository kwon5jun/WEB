<!-- 게시판 페이지 -->
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
                <h2>자유 게시판</h2>
                <!-- 게시글 검색 -->
                <form class="search-form" method="get" action="search.php">
                    <?php
                    if (isset($_GET['search'])) {
                        echo "<input type='text' name='search' value='" . htmlspecialchars($_GET['search']) . "' placeholder='검색어를 입력하세요. ' required>";
                    } else {
                        echo "<input type='text' name='search' placeholder='검색어를 입력하세요.' required>";
                    }
                    ?>
                    <button type="submit">검색</button>
                    <a class="button_del-container " href="board.php">초기화</a>
                </form>
                <!-- 게시글 목록 -->
                <table class="board-table">
                    <thead>
                        <tr>
                            <th class="center-align">번호</th>
                            <th class="post-title">제목</th>
                            <th class="center-align">작성자</th>
                            <th class="center-align">날짜</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // 페이지네이션 설정
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $search = !empty($_GET['search']) ? $_GET['search'] : null;
                        //echo "<script>console.log('search: $search');</script>";
                        if ($page < 1) {
                            $page = 1; // 페이지 번호가 1보다 작으면 1로 설정
                        }
                        $limit = 5; // 한 페이지에 표시할 게시글 수
                        $offset = ($page - 1) * $limit;
                        
                        if (isset($search)) {
                            $query = "SELECT COUNT(*) as total FROM board where title LIKE '%$search%' OR content LIKE '%$search%'";
                        } else {
                            $query = "SELECT COUNT(*) as total FROM board";
                        }
                        //echo "<script>console.log('query: $query');</script>";
                        $result = mysqli_query($conn, $query);
                        $total_posts = mysqli_fetch_assoc($result)['total'];
                        $total_pages = ceil($total_posts / $limit);
                        $offset = $total_pages < $page ? 0 : $offset; // 페이지가 총 페이지 수보다 크면 0으로 설정
                        #echo "<script>console.log('total_posts: $total_posts, total_pages: $total_pages');</script>";
                        if ($total_posts == 0) {
                            echo "<tr><td colspan='4' class='center-align'>게시글이 없습니다.</td></tr>";
                        }

                        if (isset($search)) {
                            $query = "SELECT * FROM board WHERE title LIKE '%$search%' OR content LIKE '%$search%' ORDER BY idx DESC LIMIT $limit OFFSET $offset";
                        } else {
                            $query = "SELECT * FROM board ORDER BY idx DESC LIMIT $limit OFFSET $offset";
                        }
                        if (strpos($query, 'OFFSET') === false) {
                            echo "<script>alert('block string');javascript:history.back();</script>";
                        }
                        $result = mysqli_query($conn, $query);
                        while($data= mysqli_fetch_array($result)){

                        ?>   
                        <tr> 
                            <td class="center-align"><?=$data['idx']?></td>
                            <td class="post-title"><a href="./board_read.php?idx=<?=$data['idx']?>"><?=$data['title']?></td>
                            <td class="center-align"><?=$data['author']?></td>
                            <td class="center-align"><?= $data['date']?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                <h2></h2>
                <div id="pagination" class="pagination">
                    <a href="board.php?page=1<?=$search_query?>" class="page-link">처음 </a>
                    <a href="board.php?page=<?=max(1, $page - 1) . $search_query?>" class="page-link">이전</a>
                    <span class="current-page"> <?php $page_view = $page > $total_pages ? 1 : $page ; echo $page_view ?></span>
                    <span class="total-pages">/ <?= $total_pages ?></span>
                    <a href="board.php?page=<?=min($total_pages, $page + 1) . $search_query?>" class="page-link">다음</a>
                    <a href="board.php?page=<?= $total_pages .$search_query ?>" class="page-link">마지막</a>
                </div>
                <script>
                    const tbody = document.querySelector('.board-table tbody');
                    if (
                        tbody.children.length === 1 &&
                        tbody.children[0].textContent.includes('게시글이 없습니다.')
                    ) {
                        document.getElementById('pagination').style.display = 'none';
                    }
                </script>
                <!-- 글쓰기 버튼 -->
                <div>
                    <a class="button-container" href="board_write.php">글쓰기</a>
                </div>
            </section>
        </div>
    </main>
</body>
</html>