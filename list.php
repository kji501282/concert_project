<?php
session_start();
$table = "free";
$mode = $_GET['mode'];
$search = $_POST['search'];
$find = $_POST['find'];
$userid = $_SESSION['userid'];
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link href="../css/common.css" rel="stylesheet" type="text/css"
	media="all">
<link href="../css/concert.css" rel="stylesheet" type="text/css"
	media="all">
</head>
<?php
include "../lib/dbconn.php";

$flag = "NO";
$sql = "show tables from classDB";
$result = mysqli_query($con, $sql) or die("실패원인:" . mysqli_error($con));
while ($row = mysqli_fetch_row($result)) {
    if ($row[0] === "free") {
        $flag = "OK";
        break;
    }
}
if ($flag !== "OK") {
    $sql = "create table free (
                   num int not null auto_increment,
                   id char(15) not null,
                   name  char(10) not null,
                   nick  char(10) not null,
                   subject char(100) not null,
                   content text not null,
                   regist_day char(20),
                   hit int,
                   is_html char(1),
                   file_name_0 char(40),
                   file_name_1 char(40),
                   file_name_2 char(40),
                   file_name_3 char(40),
                   file_name_4 char(40),
                   file_copied_0 char(30),
                   file_copied_1 char(30),
                   file_copied_2 char(30),
                   file_copied_3 char(30),
                   file_copied_4 char(30),
                   primary key(num)
                )char set utf8";
    
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('free 테이블이 생성되었습니다.')</script>";
    } else {
        echo "실패원인:" . mysqli_query($con);
    }
}

$flag = "NO";
$sql = "show tables from classDB";
$result = mysqli_query($con, $sql) or die("실패원인:" . mysqli_error($con));
while ($row = mysqli_fetch_row($result)) {
    if ($row[0] === "free_ripple") {
        $flag = "OK";
        break;
    }
}
if ($flag !== "OK") {
    $sql = "create table free_ripple (
                   num int not null auto_increment,
                   parent int not null,
                   id char(15) not null,
                   name  char(10) not null,
                   nick  char(10) not null,
                   subject char(100) not null,
                   content text not null,
                   regist_day char(20),
                   primary key(num)
                )char set utf8";
    
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('free_ripple 테이블이 생성되었습니다.')</script>";
    } else {
        echo "실패원인:" . mysqli_query($con);
    }
}

$scale = 10; // 한 화면에 표시되는 글 수

if ($mode == "search") {
    if (! $search) {
        echo ("
				<script>
				 window.alert('검색할 단어를 입력해 주세요!');
			     history.go(-1);
				</script>
			");
        exit();
    }
    
    $sql = "select * from $table where $find like '%$search%' order by num desc";
} else {
    $sql = "select * from $table order by num desc";
}

$result = mysqli_query($con, $sql) or die("실패원인:".mysqli_error($con));

$total_record = mysqli_num_rows($result); // 전체 글 수
                                          
// 전체 페이지 수($total_page) 계산
if ($total_record % $scale == 0)
    $total_page = floor($total_record / $scale);
else
    $total_page = floor($total_record / $scale) + 1;

// 처음시작할때 page값이 안찍히기때문에 1로 초기화
if (empty($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

// 표시할 페이지($page)에 따라 $start 계산
$start = ($page - 1) * $scale;
$number = $total_record - $start;
?>
<body>
	<div id="wrap">
		<div id="header">
    <?php include "../lib/top_login2.php"; ?>
  </div>
		<!-- end of header -->

		<div id="menu">
	<?php include "../lib/top_menu2.php"; ?>
  </div>
		<!-- end of menu -->

		<div id="content">
			<div id="col1">
				<div id="left_menu">
<?php include "../lib/left_menu.php"; ?>
		</div>
			</div>
			<div id="col2">
				<div id="title">
					<img src="../img/title_free.gif">
				</div>

				<form name="board_form" method="post"
					action="list.php?table=<?=$table?>&mode=search">
					<div id="list_search">
						<div id="list_search1">▷ 총 <?= $total_record ?> 개의 게시물이 있습니다.  </div>
						<div id="list_search2">
							<img src="../img/select_search.gif">
						</div>
						<div id="list_search3">
							<select name="find">
								<option value='subject'>제목</option>
								<option value='content'>내용</option>
								<option value='nick'>별명</option>
								<option value='name'>이름</option>
							</select>
						</div>
						<div id="list_search4">
							<input type="text" name="search">
						</div>
						<div id="list_search5">
							<input type="image" src="../img/list_search_button.gif">
						</div>
					</div>
				</form>
				<div class="clear"></div>

				<div id="list_top_title">
					<ul>
						<li id="list_title1"><img src="../img/list_title1.gif"></li>
						<li id="list_title2"><img src="../img/list_title2.gif"></li>
						<li id="list_title3"><img src="../img/list_title3.gif"></li>
						<li id="list_title4"><img src="../img/list_title4.gif"></li>
						<li id="list_title5"><img src="../img/list_title5.gif"></li>
					</ul>
				</div>

				<div id="list_content">
<?php
for ($i = $start; $i < $start + $scale && $i < $total_record; $i ++) {
    mysqli_data_seek($result, $i);
    // 가져올 레코드로 위치(포인터) 이동
    $row = mysqli_fetch_array($result);
    // 하나의 레코드 가져오기
    
    $item_num = $row[num];
    $item_id = $row[id];
    $item_name = $row[name];
    $item_nick = $row[nick];
    $item_hit = $row[hit];
    $item_date = $row[regist_day];
    $item_date = substr($item_date, 0, 10);
    $item_subject = str_replace(" ", "&nbsp;", $row[subject]);
    ?>
			<div id="list_item">
						<div id="list_item1"><?= $number ?></div>
						<div id="list_item2">
							<a
								href="view.php?table=<?=$table?>&num=<?=$item_num?>&page=<?=$page?>"><?= $item_subject ?></a>
						</div>
						<div id="list_item3"><?= $item_nick ?></div>
						<div id="list_item4"><?= $item_date ?></div>
						<div id="list_item5"><?= $item_hit ?></div>
					</div>
<?php
    $number --;
}
?>
			<div id="page_button">
						<div id="page_num">
<?php

if ($page != 1) {
    $page_front = $page - 1;
    echo "<a href='list.php?page=$page_front'>◀ 이전 &nbsp;&nbsp;&nbsp;&nbsp</a>";
} else {
    echo "◀ 이전 &nbsp;&nbsp;&nbsp;&nbsp";
}

for ($i = 1; $i <= $total_page; $i++) {
    if ($page == $i) {
        echo "<b> $i </b>";
    } else {
        echo "<a href='list.php?page=$i'> $i </a>";
    }
}

if ($page != $total_page) {
    $page_next = $page + 1;
    echo "<a href='list.php?page=$page_next'>&nbsp;&nbsp;&nbsp;&nbsp;다음 ▶</a>";
} else {
    echo "&nbsp;&nbsp;&nbsp;&nbsp;다음 ▶";
}
?>
				</div>
						<div id="button">
							<a href="list.php?table=<?=$table?>&page=<?=$page?>"><img
								src="../img/list.png"></a>&nbsp;
<?php
if (! empty($userid)) {
    ?>
		<a href="write_form.php?table=<?=$table?>"><img src="../img/write.png"></a>
<?php
}
?>
				</div>
					</div>
					<!-- end of page_button -->
				</div>
				<!-- end of list content -->
				<div class="clear"></div>

			</div>
			<!-- end of col2 -->
		</div>
		<!-- end of content -->
	</div>
	<!-- end of wrap -->

</body>
</html>
