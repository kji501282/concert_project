<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script>
</script>
</head>
<body>
	<h2>▶ 회원가입</h2>
	<form name="mem_form" method="post" action="./join.php">
		<input type="hidden" name="title" value="회원가입 양식">
		<table border="1" width="640" cellspacing="1" cellpadding="4">
			<tr>
				<td align="right">* 아이디 :</td>
				<td><input type="text" size="15" maxlength="12" name="id" value=""></td>
			</tr>
			<tr>
				<td align="right">* 이름 :</td>
				<td><input type="text" size="15" maxlength="12" name="name"></td>
			</tr>
			<tr>
				<td align="right">* 비밀번호 :</td>
				<td><input type="password" size="15" maxlength="10" name="passwd"
					value=""></td>
			</tr>
			<tr>
				<td align="right">* 비밀번호 확인 :</td>
				<td><input type="password" size="15" maxlength="12"
					name="passwd_confirm"></td>
			</tr>
			<tr>
				<td align="right">성별 :</td>
				<td><input type="radio" name="gender" value="M" checked>남 <input
					type="radio" name="gender" value="F">여</td>
			</tr>
			<tr>
				<td align="right">휴대전화 :</td>
				<td><select name="phone1">
						<option>선택</option>
						<option value="010">010</option>
						<option value="011">011</option>
						<option value="017">017</option>
				</select>- <input type="text" size="4" name="phone2" maxlength="4">-
					<input type="text" size="4" name="phone3" maxlength="4"></td>
			</tr>
			<tr>
				<td align="right">주 소 :</td>
				<td><input type="text" size="50" name="address"></td>
			</tr>
			<tr>
				<td align="right">취 미 :</td>
				<td><input type="checkbox" name="hobby" value="영화감상" checked>영화감상 <input
					type="checkbox" name="hobby" value="독서">독서 <input type="checkbox"
					name="hobby" value="쇼핑">쇼핑 <input type="checkbox" name="hobby"
					value="운동">운동</td>
			</tr>
			<tr>
				<td align="right">자기소개 :</td>
				<td><textarea name="intro" rows="5" cols="60"></textarea></td>
			</tr>
		</table>
		<br>
		<table border="0" width="640">
			<tr>
				<td align="center"><input type="submit" value="확인"
					onclick="check_input()"> <input type="reset" value="다시작성"></td>
			</tr>
		</table>
	</form>
	<?php
$id = 0;
$name = 0;
$passwd = 0;
$gender = 0;
$phone = 0;
$addr = 0;
$hobby = 0;
$intro = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["id"])) {
    } else {
        $id = $_POST["id"];
    }
    if (empty($_POST["name"])) {
        
    } else {
        $name = $_POST["name"];
    }
    if (empty($_POST["passwd"])) {
        
    } else {
        $passwd = $_POST["passwd"];
    }
    if (empty($_POST["gender"])) {
        
    } else {
        $gender = $_POST["gender"];
    }
    if (empty($_POST["phone1"])) {
        
    } else {
        $phone = $_POST["phone1"] . "-" . $_POST["phone2"] . "-" . $_POST["phone3"];
    }
    if (empty($_POST["address"])) {
        
    } else {
        $addr = $_POST["address"];
    }
    if (empty($_POST["hobby"])) {
        
    } else {
        $hobby = $_POST["hobby"];
    }
    if (empty($_POST["intro"])) {
        
    } else {
        $intro = $_POST["intro"];
    }
}
$db = mysqli_connect("localhost", "root", "1q2w3e4r5t", "kdhong_db");
$sql = "INSERt INTO memberjoin(no,id,name,pw,gender,cellphone,addr,hobby,introduce)
             values (null, '{$id}', '{$name}', '{$passwd}', '{$gender}', '{$phone}','{$addr}', '{$hobby}', '{$intro}')";
$result = mysqli_query($db, $sql);
?>
</body>
</html>
