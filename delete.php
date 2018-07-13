<?php
   session_start();
   $table = $_GET['table'];
   $num = $_GET['num'];
   include "../lib/dbconn.php";

   $sql = "select * from $table where num = $num";
   $result = mysqli_query($con, $sql);

   $row = mysqli_fetch_array($result);

   $copied_name[0] = $row[file_copied_0];
   $copied_name[1] = $row[file_copied_1];
   $copied_name[2] = $row[file_copied_2];

   for ($i=0; $i<3; $i++)
   {
		if ($copied_name[$i])
	   {
			$image_name = "./data/".$copied_name[$i];
			unlink($image_name);
	   }
   }

   $sql = "delete from $table where num = $num";
   mysqli_query($con, $sql);

   mysqli_close($con);

   echo "
	   <script>
        alert('삭제완료')
	    location.href = 'list.php?table=$table';
	   </script>
	";
?>

