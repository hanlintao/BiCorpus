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

function comment_count_word($str){
    //$str =characet($str);
    //判断是否存在替换字符
    $is_tihuan_count=substr_count($str,"龘");
    try {
        //先将回车换行符做特殊处理
        $str = preg_replace('/(\r\n+|\s+|　+)/',"龘",$str);
        //处理英文字符数字，连续字母、数字、英文符号视为一个单词
        $str = preg_replace('/[a-z_A-Z0-9-\.!@#\$%\\\^&\*\)\(\+=\{\}\[\]\/",\'<>~`\?:;|]/',"m",$str);
        //合并字符m，连续字母、数字、英文符号视为一个单词
        $str = preg_replace('/m+/',"*",$str);
        //去掉回车换行符
        $str = preg_replace('/龘+/',"",$str);
        //返回字数
        return mb_strlen($str)+$is_tihuan_count;
    } catch (Exception $e) {
        return 0;
    }
}

function variance($arr) {
  $length = count($arr);
  if ($length == 0) {
    return array(0,0);
  }
  $average = array_sum($arr)/$length;
  $count = 0;
  foreach ($arr as $v) {
    $count += pow($average-$v, 2);
  }
  $variance = $count/$length;
	return array('variance' => $variance, 'square' => sqrt($variance), 'average' => $average);
}

//参考：https://www.shuxuele.com/data/standard-deviation.html

//参考：https://www.oudahe.com/p/33167/
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
		$destination = "uploadcheck/".$savename;
		move_uploaded_file($filename,$destination);
		//echo "<div class='alert alert-success'>您上传的文件已转移至： " . $destination."</div>";
		
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
			//$field = mysqli_real_escape_string($conn,$_POST["field"]);
			//$description = mysqli_real_escape_string($conn,$_POST["description"]);
		$uploadtime = date("ymdhis");
			//$uploaduser = "hanlintao";
		$uploaduser = $user_id;
			//
			//$insert_file_sql = "INSERT INTO `files` (`sourcefilename`, `savefilepath`,`savefilename`,`uploaduser`,`uploadtime`,`source_lang`,`target_lang`,`field`,`description`) VALUES ('{$sourcefilename}', '{$destination}','{$savename}','{$uploaduser}','{$uploadtime}','{$source}','{$target}','{$field}','{$description}')";
			//
			//$insert_file = mysqli_query($conn,$insert_file_sql);
			//
			//$file_id = mysqli_insert_id($conn);
			//
			//if(!$insert_file)
			//{
			//	echo "<div class='alert alert-warning'>文件信息存储失败！</div>";
			//}
	
		$i = 1;
		$error_message = "";	
		$sltl_group = array();
			
		foreach ($jsondata["body"]["tu"] as $tu)
		{
			$source_content = mysqli_real_escape_string($conn,$tu["tuv"][0]["seg"]);
			$target_content = mysqli_real_escape_string($conn,$tu["tuv"][1]["seg"]);
				
				//$source_content = $tu["tuv"][0]["seg"];
				//$target_content = $tu["tuv"][1]["seg"];
				
				//计算原文长度和译文长度
				
			$source_length = comment_count_word($source_content);
				
        	$target_length = comment_count_word($target_content);
				
			if($target_length != 0)
			{
				$sltl = sprintf("%.3f", $source_length/$target_length);
				$sltl_group[] = $sltl;
			}
				
				//检查原文和译文多余的句号
				
			preg_match_all ("/。/U", $source_content, $source_period); 
			preg_match_all ("/。/U", $target_content, $target_period);
				
				//print_r($source_period);
				//print_r($target_period);
			$source_period_num = count($source_period[0]);
			$target_period_num = count($target_period[0]);
				
				//检查是否有错误的单词
				
			preg_match_all ("/\sun\s/U", $source_content, $source_un); 
			preg_match_all ("/\sun\s/U", $target_content, $target_un);
				
			$source_un_num = count($source_un[0]);
			$target_un_num = count($target_un[0]);
				
			preg_match_all ("/Palestinian/U", $source_content, $Palestinian); 
			preg_match_all ("/巴勒斯坦/U", $target_content, $balesitan);
				
			$source_Palestinian_num = count($Palestinian[0]);
			$target_balesitan_num = count($balesitan[0]);
				
				
			if(empty($source_content) || empty ($target_content) )
				{
					$error_message = $error_message."第 {$i} 行数据存在空行，请前往TMX文件中检查错误原因。</br>";
					
					echo "<div class='alert alert-warning'>第 {$i} 行数据存在空行，请前往TMX文件中检查错误原因。</div>";
					
					echo "<div class='alert alert-info'>原文为：".$source_content."</div>";
					echo "<div class='alert alert-info'>译文：".$target_content."</div>";
				}
				elseif( $source_period_num > 2 || $target_period_num > 2)
				{
					$error_message = $error_message."第 {$i} 行数据中存在多个中文句子，请前往TMX文件中拆分。</br>";
					
					echo "<div class='alert alert-warning'>第 {$i} 行数据中存在多个中文句子，请前往TMX文件中拆分。</div>";
					echo "<div class='alert alert-info'>原文为：".$source_content."</div>";
					echo "<div class='alert alert-info'>译文：".$target_content."</div>";
				}
				elseif( $source_un_num > 0 || $target_un_num > 0)
				{
					$error_message = $error_message."第 {$i} 行数据中存在小写的un，请前往TMX文件中检查。</br>";
					
					echo "<div class='alert alert-warning'>第 {$i} 行数据中存在小写的un，请前往TMX文件中检查。</div>";
					
					$source_content=preg_replace("/(\sun\s)/u", "<font color=red><b>$1</b></font>",$source_content);
					
					$target_content=preg_replace("/(\sun\s)/u", "<font color=red><b>$1</b></font>",$target_content);
					
					echo "<div class='alert alert-info'>原文为：".$source_content."</div>";
					echo "<div class='alert alert-info'>译文：".$target_content."</div>";
				}
				elseif( $source_Palestinian_num != $target_balesitan_num)
				{
					$error_message = $error_message."第 {$i} 行数据中巴勒斯坦翻译错误，请前往TMX文件中检查。</br>";
					
					echo "<div class='alert alert-warning'>第 {$i} 行数据中巴勒斯坦翻译错误，请前往TMX文件中检查。</div>";
					
					$source_content=preg_replace("/(Palestinian)/u", "<font color=red><b>$1</b></font>",$source_content);
					
					$target_content=preg_replace("/(巴勒斯坦)/u", "<font color=red><b>$1</b></font>",$target_content);
					
					echo "<div class='alert alert-info'>原文为：".$source_content."</div>";
					echo "<div class='alert alert-info'>译文：".$target_content."</div>";
				}
				//else{
				//	
				//	$error_message = "";
				//
				//}
				
				

				//$insert_sql = "INSERT INTO `tmdata` (`source_content`, `target_content`,`source_lang`,`target_lang`,`file_id`) VALUES ('{$source_content}', '{$target_content}','{$source}','{$target}','{$file_id}')";
			    //
				//$status = mysqli_query($conn,$insert_sql);
			    //
				//if(!$status)
				//{
				//	echo "<div class='alert alert-warning'>第 {$i} 行数据导入失败，请前往TMX文件中检查错误原因。</div>";
				//	echo "<div class='alert alert-info'>原文为：".$source_content."</div>";
				//	echo "<div class='alert alert-info'>译文：".$target_content."</div>";
				//}
				//else
				//{
				//	echo "<div class='alert alert-success'>第 {$i} 行数据导入成功！</div>";
				//}
				
				$i++;
			}
			
			
			 
			$variance_cal = variance($sltl_group);
			 
			 echo "<table class='table table-bordered table-striped'>
				<tr>
				<th>方差</th>
				<th>标准差</th>
				<th>平均值</th>
				</tr>
				
				<tr>
				<td>".$variance_cal["variance"]."</td>
				<td>".$variance_cal["square"]."</td>
				<td>".$variance_cal["average"]."</td>
				</tr>
				</table>";
				
				
			echo "<table class='table table-bordered table-striped'>
            <tr>
            <th>原文</th>
            <th>译文</th>
			<th>SL</th>
            <th>TL</th>
            <th>SL/TL</th>
			<th>状态</th>
            </tr>";
				
			$j = 1;
			foreach ($jsondata["body"]["tu"] as $tu)
			{
				$source_content = mysqli_real_escape_string($conn,$tu["tuv"][0]["seg"]);
				$target_content = mysqli_real_escape_string($conn,$tu["tuv"][1]["seg"]);
				
				//$source_content = $tu["tuv"][0]["seg"];
				//$target_content = $tu["tuv"][1]["seg"];
				
				//计算原文长度和译文长度
				
				$source_length = comment_count_word($source_content);
				
                $target_length = comment_count_word($target_content);
				
				if($target_length != 0)
				{
					$sltl = sprintf("%.3f", $source_length/$target_length);
				}
				else{
				
					$sltl = "INF";
				}
				
				
				
				echo "<tr><td>".$source_content."</td>";
                echo "<td>".$target_content."</td>";
				echo "<td>".$source_length."</td>";
				echo "<td>".$target_length."</td>";
                echo "<td>".$sltl."</td>";
				echo "<td>";
				
				if ($sltl > ($variance_cal["average"] + 3* $variance_cal["square"]) )
				{
					echo '<span class="glyphicon glyphicon-remove text-danger"></span>';
					
					$error_message = $error_message."第 {$j} 行数据原文和译文长度比异常，请检查。</br>";
				}
				elseif($target_length == 0)
				{
					echo '<span class="glyphicon glyphicon-remove text-danger"></span>';
					
					$error_message = $error_message."第 {$j} 行数据译文为空，请检查。</br>";
				}
				
				
				echo "</td></tr>";
				
			$j++;
			}
				
			echo "</table>";
			
				if(!empty($error_message))
				{
					echo "<div class='alert alert-info'>以下是全部错误信息，请处理完成后再检查。</div>";
					echo "<div class='alert alert-warning'>".$error_message."</div>";
					
					//print_r($error_message);
				
					
				}
				else
				{
					echo "<div class='alert alert-success'>你的文件目前没有什么问题，请上传吧！</div>";
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