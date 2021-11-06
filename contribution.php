<?php

session_start();

if (isset($_SESSION['login_user']) && !empty($_SESSION['login_user'])) {
    include "shared/lock.php";
}else{
   include "shared/config.php";
}

?>

<?php

include "shared/head.php";

?>
	
<?php

if (isset($_SESSION['login_user']) && !empty($_SESSION['login_user'])) {
	include "shared/navbar.php";
}
else
{
	include "shared/public_navbar.php";
}

$id = $_GET["id"];
?>

<div class="container-fluid">

<?php



$sql = "
SELECT * FROM users WHERE id = '{$id}'
";

mysqli_select_db($conn,DB_DATABASE); 
mysqli_query($conn,"set names utf8"); 
			
$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);


//统计当前成员已发布内容的字数

//第一个函数在本地可以运行正确，但是在服务器端则会将汉字识别为四个字
function count_words($str){
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

function comment_count_word($text){
	$english_char_num="";
	foreach(str_word_count($text,1) as $english)
	{
		$english_char_num = $english_char_num + strlen($english);
	}
	$chinese_punct= "，。、！？：；﹑•＂…‘’“”〝〞∕¦‖—　〈〉﹞﹝「」‹›〖〗】【»«』『〕〔》《﹐¸﹕︰﹔！¡？¿﹖﹌﹏﹋＇´ˊˋ―﹫︳︴¯＿￣﹢﹦﹤‐­˜﹟﹩﹠﹪﹡﹨﹍﹉﹎﹊ˇ︵︶︷︸︹︿﹀︺︽︾ˉ﹁﹂﹃﹄︻︼（）";
	$pattern = array("/[[:punct:]]/i", "/['.$chinese_punct.']/u", "/[[:alnum:]]/", "/[[:space:]]/",);
	$chinese = preg_replace($pattern, '', $text);
	preg_match_all("/\d+/",$text,$matches);
	$number_char_num="";
	foreach($matches[0] as $number)
	{
		$number_char_num=$number_char_num+strlen($number);
	}
	preg_match_all("/[[:punct:]]/i",$text,$punct_matches);
	preg_match_all("/['.$chinese_punct.']/u",$text,$chinese_punct_matches);
	
	$ms_wordcount = mb_strlen($chinese, "utf8")+str_word_count($text)+count($matches[0])+count($punct_matches[0])+count($chinese_punct_matches[0]);
	//$ms_charcount = mb_strlen($chinese, "utf8")+$english_char_num+$number_char_num+count($punct_matches[0])+count($chinese_punct_matches[0]);
	//$ms_charcount_space = mb_strlen($chinese, "utf8")+$english_char_num+$number_char_num+count($punct_matches[0])+count($chinese_punct_matches[0])+substr_count($text," ");
	
	return $ms_wordcount;

	//"英文单词个数为：".str_word_count($text)."<br>".
	//"英文单词字符总数为：".$english_char_num."<br>".
	//"中文字数为：".mb_strlen($chinese, "utf8")."<br>".
	//"数字个数为：".count($matches[0])."<br>".
	//"数字字符总数为：".$number_char_num."<br>".
	//"按照Microsoft Word中字数统计的方法，这句话里的字数有： ".$ms_wordcount." 个"."<br>".
	//"按照Microsoft Word中字数统计的方法，这句话里的字符数（不计空格）有： ".$ms_charcount." 个"."<br>".
	//"按照Microsoft Word中字数统计的方法，这句话里的字符数（计空格）有： ".$ms_charcount_space." 个";
	}

		$sql_wordcount = "
		SELECT tmdata.source_content AS Source,tmdata.target_content AS Target, tmdata.status,files.status
		FROM tmdata
		INNER JOIN files
		ON tmdata.file_id = files.id
		WHERE files.status = 1 AND tmdata.status = 1 AND files.uploaduser = {$id}";
		
		mysqli_query($conn,"set names utf8"); 
		
		$result_wordcount = mysqli_query($conn,$sql_wordcount);
		
		$total_wordcount = 0;
		
		while($row_count = mysqli_fetch_array($result_wordcount, MYSQLI_ASSOC))
			{
				$total_wordcount =$total_wordcount + comment_count_word($row_count["Source"]);
				$total_wordcount =$total_wordcount + comment_count_word($row_count["Target"]);
				
			}
		
		//echo "已发布文本总字数：".$total;

		$test = comment_count_word("计算中");


?>
   <div class="row">
      <div class="col-md-12">
		<div class="col-md-4">
		</div>

		<div class="col-md-4">
			
		<table class='table table-bordered table-striped'>
			
			<tr>
				<td width='30%'>成员</td>
				<td width='70%'><?php echo $row["fullname"];?></td>
			</tr>
			<tr>
				<td width='30%'>单位</td>
				<td width='70%'><?php echo $row["university"];?></td>
			</tr>

			<tr>
				<td width='30%'>字数</td>
				<td width='70%'><?php echo $total_wordcount;?></td>
			</tr>

		</table>
			
		</div>

		<div class="col-md-4">
		</div>		
	  </div>
   </div>   
   <div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10">

		<?php
		mysqli_select_db($conn,DB_DATABASE); //连接数据库
		
		//用户第一次访问时没有输入任何查询词，所以当无法获取查询词时，默认的查询词是空
		if(!isset($_GET["query"]))
		{
			$query = " ";
		}
		else
		{
			$query = $_GET["query"];
			//echo $query;
		}
					
		// 分页代码解析参见：https://www.mitrajit.com/bootstrap-pagination-in-php-and-mysql/
		
		$limit = 10;
		$adjacents = 4;

      
		//用户第一次访问时没有点击任何页码，所以默认页码是1，从第0个记录开始检索（所以offset的值为0）；但如果能够得到页码，比如页码是5，而我们设置了每页显示10条结果（limit=10），所以第五页应该是从前40个结果开始，所以是10*(5-1)。
		if(isset($_GET['page']) && $_GET['page'] != "") {
			$page = $_GET['page'];
			$offset = $limit * ($page-1);
		} else {
			$page = 1;
			$offset = 0;
		}
		
		// 如果当前的页码是5，则当前的offset是40。但是，此时用户搜索了一个词，一旦用户开始搜索词，那么offset就要从0开始，重新计算所有数据的总数。
		
		// 有一个小知识点一定要注意：只要加了limit，那么count(*)就肯定是10
		

		// 如果是管理员则全部显示，如果是普通用户则只显示他们上传的内容
		

		$sql_count_data = "SELECT COUNT(*) 'total_rows' FROM `files` WHERE uploaduser = '{$id}' AND status = 1)";

		
		
		//$sql_count_data = "SELECT COUNT(*) 'total_rows' FROM `tmdata` ";
		mysqli_query($conn,"set names utf8"); 
		$count_data = mysqli_query($conn, $sql_count_data);
		$total_data = mysqli_fetch_array($count_data,MYSQLI_ASSOC);
		$total_rows = $total_data["total_rows"];
		
		$total_pages = ceil($total_rows / $limit);			
			


			$sql = "SELECT * FROM files WHERE uploaduser = '{$id}' AND status = 1  ORDER BY uploadtime DESC   ";

		mysqli_query($conn,"set names utf8"); 
		
		$result = mysqli_query($conn,$sql);
		
		if(mysqli_num_rows($result) > 0) {
		
		echo "<table class='table table-bordered table-striped'>
				<thead>
				<td width='5%'>ID</td>
				<td width='15%'>文件名</td>
				<td width='5%'>下载</td>
				
				<td width='10%'>上传时间</td>
				<td width='15%'>所属领域</td>
				<td width='40%'>文件描述</td>
				<td width='10%'>状态</td>
				
			</thead>";
					
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
			{
				echo "<tr>
						<td>{$row["id"]}</td>
						<td>{$row["sourcefilename"]}</td>
						<td><a href='{$row["savefilepath"]}' target='_blank'>下载</a></td>
						
						<td>{$row["uploadtime"]}</td>
						<td>{$row["field"]}</td>
						<td style='word-break:break-all'>{$row["description"]}</td>
						<td>";
						
						if($row["status"] == 0)
						{
							echo '<button type="button" class="btn btn-warning" >未发布</button>';
						}
						else
						{
							echo '<button type="button" class="btn btn-success" >已发布</button>';
						}
						
				echo		"</td>		
					</tr>";
			} 
		
		echo "</table>";
		}
		
		
		if($total_pages <= (1+($adjacents * 2))) 
		{
			$start = 1;
			$end   = $total_pages;
		} 
		else 
		{
			if(($page - $adjacents) > 1) 
			{ 
				if(($page + $adjacents) < $total_pages) 
				{ 
					$start = ($page - $adjacents);            
					$end   = ($page + $adjacents);         
				} 
				else 
				{             
					$start = ($total_pages - (1+($adjacents*2)));  
					$end   = $total_pages;               
				}
			} 
			else 
			{               
				$start = 1;                                
				$end   = (1+($adjacents * 2));             
			}
		}
		
		?>		
		
	<?php if($total_pages > 0) { ?>
          <ul class="pagination pagination-sm justify-content-center">
            <!-- Link of the first page -->
            <li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
              <a class='page-link' href='contribution.php?id=<?php echo $id;?>query=<?php echo $query;?>&page=1'><<</a>
            </li>
            <!-- Link of the previous page -->
            <li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
              <a class='page-link' href='contribution.php?id=<?php echo $id;?>query=<?php echo $query;?>&page=<?php ($page>1 ? print($page-1) : print 1)?>'><</a>
            </li>
            <!-- Links of the pages with page number -->
            <?php for($i=$start; $i<=$end; $i++) { ?>
            <li class='page-item <?php ($i == $page ? print 'active' : '')?>'>
              <a class='page-link' href='contribution.php?id=<?php echo $id;?>query=<?php echo $query;?>&page=<?php echo $i;?>'><?php echo $i;?></a>
            </li>
            <?php } ?>
            <!-- Link of the next page -->
            <li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
              <a class='page-link' href='contribution.php?id=<?php echo $id;?>query=<?php echo $query;?>&page=<?php ($page < $total_pages ? print($page+1) : print $total_pages)?>'>></a>
            </li>
            <!-- Link of the last page -->
            <li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
              <a class='page-link' href='contribution.php?id=<?php echo $id;?>query=<?php echo $query;?>&page=<?php echo $total_pages;?>'>>>                      
              </a>
            </li>
          </ul>
       <?php   } ?>
       
		</div>
		<div class="col-md-1">
		</div>
		 
	</div>
    
   </div>
		


</body>
</html>