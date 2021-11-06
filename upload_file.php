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

echo '
   <div class="row">
      <div class="col-md-12">
		<div class="col-md-2">
		</div>

		<div class="col-md-8">';
		
if ($_FILES["file"]["error"] > 0)
  {
	echo "<div class='alert alert-success'>文件上传出现错误！错误码为： " . $_FILES["file"]["error"] . "</div>";
  }
else
  {
	
	echo "<div class='alert alert-success'>";
	echo "您上传的文件是: " . $_FILES["file"]["name"] . "<br />";
	echo "您上传的文件类型是: " . $_FILES["file"]["type"] . "<br />";
	echo "您上传的文件大小为：" . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
	echo "您上传的文件临时存储在: " . $_FILES["file"]["tmp_name"];
	echo "</div>";
  
  
	if($_FILES["file"]["type"] != "application/xml")
	{
		//echo "<div class='alert alert-warning'>该文件不是XML文件，请检查文件格式</div>";
	}
	
	if (file_exists("upload/" . $_FILES["file"]["name"]))
	{
		echo "<div class='alert alert-warning'>".$_FILES["file"]["name"] . " 已经存在，请勿重复上传。";
	}
	else
	{
		$file = $_FILES["file"];
		$filename=$file["tmp_name"];
		$pinfo=pathinfo($file["name"]);
		$ftype=$pinfo['extension'];  
		$qianzhui= date("ymdhis").rand();
		$savename = $qianzhui.".".$ftype;
		$destination = "upload/".$savename;
		move_uploaded_file($filename,$destination);
		echo "<div class='alert alert-success'>您上传的文件已转移至： " . $destination."</div>";
		
		$languagepair = $_POST["language"];
		
		switch($languagepair){
			case "1":
				$source = "zh-CN";
				$target = "en-US";
				break;       
				             
			case "2":        
				$source = "en-US";
				$target = "zh-CN";
				break;	     
				             
			case "3":        
				$source = "zh-CN";
				$target = "fr-FR";
				break;       
				             
			case "4":        
				$source = "fr-FR";
				$target = "zh-CN";
				break;	
				
			case "5":        
				$source = "zh-CN";
				$target = "ja-JP";
				break;
				
			case "6":        
				$source = "ja-JP";
				$target = "zh-CN";
				break;
				
			case "7":        
				$source = "zh-CN";
				$target = "ko";
				break;
				
			case "8":        
				$source = "ko";
				$target = "zh-CN";
				break;
				
			case "9":        
				$source = "zh-CN";
				$target = "es";
				break;
				
			case "10":        
				$source = "es";
				$target = "zh-CN";
				break;
				
			case "11":        
				$source = "zh-CN";
				$target = "ru";
				break;
				
			case "12":        
				$source = "ru";
				$target = "zh-CN";
				break;
				
			case "13":        
				$source = "zh-CN";
				$target = "it-IT";
				break;
				
			case "14":        
				$source = "it-IT";
				$target = "zh-CN";
				break;
				
			case "15":        
				$source = "zh-CN";
				$target = "de-DE";
				break;
				
			case "16":        
				$source = "de-DE";
				$target = "zh-CN";
				break;
				
			case "17":        
				$source = "zh-CN";
				$target = "th-TH";
				break;
				
			case "18":        
				$source = "th-TH";
				$target = "zh-CN";
				break;
		}
		
		
		$xml = simplexml_load_file($destination);
		$json = json_encode($xml);
		$jsondata = json_decode($json,true);
		
		$xml_source = $xml->body->tu[0]->tuv[0]->attributes("xml",TRUE);
		$xml_target = $xml->body->tu[0]->tuv[1]->attributes("xml",TRUE);
	
		if($source != $xml_source && $target != $xml_target)
		{
			echo "<div class='alert alert-warning'>语言对错误，请重试。</div>";
		}
		else
		{
			$sourcefilename = mysqli_real_escape_string($conn,$_FILES["file"]["name"]);
			$field = mysqli_real_escape_string($conn,$_POST["field"]);
			$description = mysqli_real_escape_string($conn,$_POST["description"]);
			$uploadtime = date("ymdhis");
			//$uploaduser = "hanlintao";
			$uploaduser = $user_id;
			
			//echo $_FILES["file"]["name"];
			$check_repitition_sql = "SELECT COUNT(*) 'total_rows' FROM files WHERE sourcefilename = ' {$_FILES["file"]["name"]}'";
			
			$repitition_sql = mysqli_query($conn,$check_repitition_sql);
			
			$repitition_result = mysqli_fetch_array($repitition_sql,MYSQLI_ASSOC);
			
			$repitition_number = $repitition_result["total_rows"];

			
			if($repitition_number > 1)
			{
				echo "<div class='alert alert-warning'>存在文件名重复内容，请检查后再试。</div>";
			}
			else
			{
			$insert_file_sql = "INSERT INTO `files` (`sourcefilename`, `savefilepath`,`savefilename`,`uploaduser`,`uploadtime`,`source_lang`,`target_lang`,`field`,`description`,`comments`) VALUES ('{$sourcefilename}', '{$destination}','{$savename}','{$uploaduser}','{$uploadtime}','{$source}','{$target}','{$field}','{$description}','')";
			
			
			$insert_file = mysqli_query($conn,$insert_file_sql);
			
			$file_id = mysqli_insert_id($conn);
			
			
			if(!$insert_file)
			{
				echo "<div class='alert alert-warning'>文件信息存储失败！</div>";
			}
			else{
			
			//$listfilesaddress = "localhost/listfiles.php";
			//发邮件提醒管理员审核
			
			//$url = "https://api.sendcloud.net/apiv2/mail/send";

			//echo $userfullname;
			
			//$data = array(
			//	"apiUser" => "",
			//	"apiKey" =>"",
			//	"from" =>"",
			//	"to" => "",
			//	"subject" => "用户".$userfullname."已上传新文件，请前往审核",
			//	"html" => "用户 ".$userfullname." 已上传文件[".$sourcefilename."]，请前往 ".$listfilesaddress." 开始审核文件。",
			//	"fromName" => "您的网站名称"
			//);
			
			//print_r($data);
			//$curl = curl_init();
			
			//curl_setopt($curl, CURLOPT_URL, $url);
			
			//curl_setopt($curl, CURLOPT_POST, 1);
			
			//curl_setopt($curl, CURLOPT_HEADER, 0); 
			
			//curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			
			//curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			
			//$output = curl_exec($curl);
			
			//curl_close($curl);	
			
			//print_r($output);

			//if($output)
			//{
			//	//echo "发送成功";
			//}
			
			
			}
			
			
			
	
			$i = 1;
			
			foreach ($jsondata["body"]["tu"] as $tu)
			{
				$source_content = mysqli_real_escape_string($conn,$tu["tuv"][0]["seg"]);
				$target_content = mysqli_real_escape_string($conn,$tu["tuv"][1]["seg"]);
			
				$insert_sql = "INSERT INTO `tmdata` (`source_content`, `target_content`,`source_lang`,`target_lang`,`file_id`) VALUES ('{$source_content}', '{$target_content}','{$source}','{$target}','{$file_id}')";
			
				$status = mysqli_query($conn,$insert_sql);
				
	
				if(!$status)
				{
					echo "<div class='alert alert-warning'>第 {$i} 行数据导入失败，请前往TMX文件中检查错误原因。</div>";
					echo "<div class='alert alert-info'>原文为：".$source_content."</div>";
					echo "<div class='alert alert-info'>译文：".$target_content."</div>";
				}
				else
				{
					echo "<div class='alert alert-success'>第 {$i} 行数据导入成功！</div>";
				}
				
				$i++;
			}
			}
		}

   
	}
  }
  
echo '		
		</div>
		<div class="col-md-2">
		</div>
	</div>
	</div>';
?>