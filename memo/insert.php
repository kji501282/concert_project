<?php session_start(); ?>

<meta charset="utf-8">
<?php
$content = $_POST['content'];
$userid = $_SESSION['userid'];

if (empty($_SESSION['userid'])) {
    echo ("<script>
            window.alert('로그인 후 이용해 주세요')
            history.go(-1)
            </script>
            ");
    exit();
}

if (! $content) {
    echo ("
        <script>
        window.alert('내용을 입력하세요.')
        history.go(-1)
        </script>
        ");
    exit();
}
$regist_day = date("Y-m-d (H:i)"); // 현재의 '년-월-일-시-분' 을 저장

include "../lib/dbconn.php";

$sql = "select * from member whre id='{$userid}'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
var_dump($row);

$name = $_SESSION['username'];
$nick = $_SESSION['usernick'];

$sql = "insert into memo (id, name, nick, content, regist_day)";
$sql .= "values('{$userid}','{$name}','{$nick}','{$content}','{$regist_day}')";

mysqli_query($con, $sql);
mysqli_close($con);

echo ("
         <script>
         location.href='memo.php';
         </script>
     ");
?>