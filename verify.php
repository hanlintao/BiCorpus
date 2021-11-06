<?php

session_start();

include "shared/lock.php";

if($user_type != 1)
{
	header("Location: index.php");
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
   $status = $_GET["status"];
   $query = $_GET["query"];
   $page = $_GET["page"];
   
   if($status == 0)
   {
		//先修改文件的状态
		$sql_update_filestatus = "UPDATE `files` SET `status` = '1' WHERE `id` = {$id}";
		mysqli_query($conn,$sql_update_filestatus);
		
		//然后修改tmxdata中每一个翻译单元的状态
		
	
		$sql_update_tmtatus = "UPDATE `tmdata` SET `status` = '1' WHERE `file_id` = {$id}";
		mysqli_query($conn,$sql_update_tmtatus);
	   
		if(mysqli_query($conn,$sql_update_filestatus) || mysqli_query($conn,$sql_update_tmtatus))   
		{  
			echo "<script>alert('审核发布成功！')</script>";
		}   
		else 
		{  
			echo "<script>alert('审核发布失败！')</script>";
		}
		
		echo "<script>location='listfiles.php?query={$query}&page={$page}'</script>";
	}
	else
	{
	   //先修改文件的状态
		$sql_update_filestatus = "UPDATE `files` SET `status` = '0' WHERE `id` = {$id}";
		mysqli_query($conn,$sql_update_filestatus);
	   
	   //然后修改tmxdata中每一个翻译单元的状态

		$sql_update_tmtatus = "UPDATE `tmdata` SET `status` = '0' WHERE `file_id` = {$id}";
		mysqli_query($conn,$sql_update_tmtatus);
		
	   	if(mysqli_query($conn,$sql_update_filestatus) || mysqli_query($conn,$sql_update_tmtatus))   
		{  
			echo "<script>alert('撤回成功！')</script>";
		}   
		else 
		{  
			echo "<script>alert('撤回失败！')</script>";
		}
		
		echo "<script>location='listfiles.php?query={$query}&page={$page}'</script>";
	}
	   
   
 
	
	
   
   
?>