<?php

session_start();

include "shared/lock.php";

if($user_type != 1)
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
   $query = $_GET["query"];
   $page = $_GET["page"];
   
	// 根据id先获取待删除的文件，确认文件没有发布，已经发布的文件不能删除
	
	$sql_check_file_status="SELECT status FROM files WHERE id ={$id}";
	
	$check_file_status_result = mysqli_query($conn,$sql_check_file_status);
	
	$row = mysqli_fetch_array($check_file_status_result,MYSQLI_ASSOC);
	
	if($row["status"] == 1)
	{
		echo "<script>alert('已发布！请勿删除！')</script>";
		
		echo "<script>location='listfiles.php?query={$query}&page={$page}'</script>";
	}
	elseif($row["status"] == 0){
		//echo "<script>alert('未发布！')</script>";
		
		
		$sql_update = "UPDATE `files` SET `status` = '3'WHERE `id` = {$id}";
		
		$update = mysqli_query($conn,$sql_update);  
  
		if(!$update)  
		{  
			echo "<script>alert('无法删除，请检查原因！')</script>";
			
			echo "<script>location='listfiles.php?query={$query}&page={$page}'</script>";
		}  
		else  
		{  
			//文件的状态设置为3之后，就是将tmdata中的数据设置为3
			
			
			//然后修改tmxdata中每一个翻译单元的状态

			$sql_update_tmtatus = "UPDATE `tmdata` SET `status` = '3' WHERE `file_id` = {$id}";
			mysqli_query($conn,$sql_update_tmtatus);
		
			if(mysqli_query($conn,$sql_update_tmtatus))   
			{  
				echo "<script>alert('删除成功！')</script>";
				
				echo "<script>location='listfiles.php?query={$query}&page={$page}'</script>";
			}   
			else 
			{  
				echo "<script>alert('删除失败！')</script>";
				echo "<script>location='listfiles.php?query={$query}&page={$page}'</script>";
			}
			
		
			
		}  
	}
	 
	
//  $sql_delete="DELETE FROM tmdata WHERE id ={$id}";
//  
//  if(mysqli_query($conn,$sql_delete))   
//	{  
//		echo "<script>alert('删除成功！')</script>";
//	}   
//	else 
//	{  
//		echo "<script>alert('删除失败！')</script>";
//	}
//	
//	echo "<script>location='edit.php'</script>"; 
   
   
?>