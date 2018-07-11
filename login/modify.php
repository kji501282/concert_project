<?php
session_start();
$userid=$_SESSION['userid'];
?>

<meta charset="utf-8">
<?php
$pass=$_POST['pass'];
$name=$_POST['name'];
$nick=$_POST['nick'];
$hp1=$_POST['hp1'];
$hp2=$_POST['hp2'];
$hp3=$_POST['hp3'];
$email1=$_POST['email1'];
$email2=$_POST['email2'];

$hp = $hp1."-".$hp2."-".$hp3;
$email = $email1."@".$email2;
$regist_day = date("Y-m-d (H:i)");

include "../lib/dbconn.php";

$sql = "update member set pass='{$pass}',name='{$name}',";
$sql .= "nick='{$nick}',hp='{$hp}',email='{$email}',regist_day='{$regist_day}'
            where id='{$userid}'";

mysqli_query($con, $sql);

mysqli_close($con);

echo ("<script>
location.href='../index.php';
</script>
");
?>