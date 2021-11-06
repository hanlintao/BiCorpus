<?php

session_start();

include "shared/lock.php";

if($user_type > 2)
{
	header("Location: login.php");
}
?>


<?php

include "shared/head.php";

?>
	
<?php

include "shared/navbar.php";

?>
<?php

   
   mysqli_select_db($conn,DB_DATABASE); //连接数据库
   
   mysqli_query($conn,"set names utf8"); //防止出现中文乱码的情况
   
   $id=$_GET["id"];
   $sql_delete="DELETE FROM tmdata WHERE id ={$id}";
   
   if(mysqli_query($conn,$sql_delete))   
	{  
		echo "<script>alert('删除成功！')</script>";
	}   
	else 
	{  
		echo "<script>alert('删除失败！')</script>";
	}
	
	echo "<script>location='edit.php'</script>"; 
   
   
?>