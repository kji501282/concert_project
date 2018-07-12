<?php session_start(); ?>

<meta charset="utf-8">
<?php 
    $userid = $_SESSION['userid'];
    $ripple_content = $_POST['ripple_content'];
    
    if(!$userid){
        echo("<script>
        window.alert('로그인 후 이용하세요.')
        history.go(-1)
        </script>
        ");
        exit;
    }
    
    if(!$ripple_content){
        echo("
        <script>
        window.alert('내용을 입력하세요.')
        history.go(-1)
        </script>
        ");
        exit;
    }
    
    include "../lib/dbconn.php";
    
    $sql="select * from member where id='{$userid}'";
    $result=mysqli_query($con, $sql);
    $row=mysqli_fetch_array($result);
    
    $num = $_POST['num'];
    $name = $row['name'];
    $nick = $row['nick'];
    
    $regist_day=date("Y-m-d (H:i)");
    
    // 댓글 삽입 명령
    
    $sql="insert into memo_ripple (parent, id, name, nick, content, regist_day)";
    $sql.="values('{$num}','{$userid}','{$name}','{$nick}','{$ripple_content}','{$regist_day}')";
    
    mysqli_query($con, $sql);
    mysqli_close($con);

    echo ("<script>
    location.href='memo.php';
    </script>");
?>