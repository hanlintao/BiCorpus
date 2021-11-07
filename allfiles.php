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

?>

<div class="container-fluid">
   <div class="row">
      <div class="col-md-12">
		<div class="col-md-4">
		</div>

		<div class="col-md-4">
			<form method="GET" action="" > 
				<div class="input-group">
                    <input type="text" class="form-control" name="query">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">检索</button>
                    </span>
				</div>	
			</form>		
		</div>

		<div class="col-md-4"></div>		
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
			$query = "";
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
			
		$sql_count_data = "SELECT COUNT(*) 'total_rows' FROM `files` WHERE status = 1 AND (sourcefilename LIKE '%{$query}%' OR field LIKE '%{$query}%' OR description LIKE '%{$query}%' OR uploaduser LIKE '%{$query}%')";
		
		//$sql_count_data = "SELECT COUNT(*) 'total_rows' FROM `tmdata` ";
		mysqli_query($conn,"set names utf8"); 
		$count_data = mysqli_query($conn, $sql_count_data);
		$total_data = mysqli_fetch_array($count_data,MYSQLI_ASSOC);
		$total_rows = $total_data["total_rows"];
		
		$total_pages = ceil($total_rows / $limit);			
			

	
			
		$sql = "SELECT * FROM files WHERE status = 1 AND (sourcefilename LIKE '%{$query}%' OR field LIKE '%{$query}%' OR description LIKE '%{$query}%' OR uploaduser LIKE '%{$query}%') ORDER BY uploadtime DESC limit $offset, $limit";
		
		mysqli_query($conn,"set names utf8"); 
		
		$result = mysqli_query($conn,$sql);
		
		if(mysqli_num_rows($result) > 0) {
		
		echo "<table class='table table-bordered table-striped'>
				<thead>
				<td width='5%'>ID</td>
				<td width='20%'>文件名</td>
				<td width='5%'>下载</td>
				
				<td width='5%'>语种</td>
				<td width='10%'>上传时间</td>
				<td width='10%'>所属领域</td>
				<td width='40%'>文件描述</td>
				<td width='5%'>状态</td>
				
			</thead>";
					
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
			{
				echo "<tr>
						<td>{$row["id"]}</td>
						<td>{$row["sourcefilename"]}</td>
						<td><a href='{$row["savefilepath"]}' target='_blank'>下载</a></td>
						";
						
				if ($row["source_lang"] == "zh-CN" && $row["target_lang"] == "en-US")
					{
						echo "<td>中英</td>";
					}
				elseif($row["source_lang"] == "en-US" && $row["target_lang"] == "zh-CN")
					{
						echo "<td>英中</td>";
					}
				elseif($row["source_lang"] == "zh-CN" && $row["target_lang"] == "ja-JP")
					{
						echo "<td>中日</td>";
					}
				elseif($row["source_lang"] == "ja-JP" && $row["target_lang"] == "zh-CN")
					{
						echo "<td>日中</td>";
					}
				elseif($row["source_lang"] == "zh-CN" && $row["target_lang"] == "fr-FR")
					{
						echo "<td>中法</td>";
					}
				elseif($row["source_lang"] == "fr-FR" && $row["target_lang"] == "zh-CN")
					{
						echo "<td>法中</td>";
					}
				elseif($row["source_lang"] == "zh-CN" && $row["target_lang"] == "ko")
					{
						echo "<td>中韩</td>";
					}
				elseif($row["source_lang"] == "ko" && $row["target_lang"] == "zh-CN")
					{
						echo "<td>韩中</td>";
					}
				elseif($row["source_lang"] == "zh-CN" && $row["target_lang"] == "es")
					{
						echo "<td>中西</td>";
					}
				elseif($row["source_lang"] == "es" && $row["target_lang"] == "zh-CN")
					{
						echo "<td>西中</td>";
					}
				elseif($row["source_lang"] == "zh-CN" && $row["target_lang"] == "ru")
					{
						echo "<td>中俄</td>";
					}
				elseif($row["source_lang"] == "ru" && $row["target_lang"] == "zh-CN")
					{
						echo "<td>俄中</td>";
					}
					else
					{
						echo "<td>待确认</td>";
					}
					
				echo "
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
              <a class='page-link' href='allfiles.php?query=<?php echo $query;?>&page=1'><<</a>
            </li>
            <!-- Link of the previous page -->
            <li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
              <a class='page-link' href='allfiles.php?query=<?php echo $query;?>&page=<?php ($page>1 ? print($page-1) : print 1)?>'><</a>
            </li>
            <!-- Links of the pages with page number -->
            <?php for($i=$start; $i<=$end; $i++) { ?>
            <li class='page-item <?php ($i == $page ? print 'active' : '')?>'>
              <a class='page-link' href='allfiles.php?query=<?php echo $query;?>&page=<?php echo $i;?>'><?php echo $i;?></a>
            </li>
            <?php } ?>
            <!-- Link of the next page -->
            <li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
              <a class='page-link' href='allfiles.php?query=<?php echo $query;?>&page=<?php ($page < $total_pages ? print($page+1) : print $total_pages)?>'>></a>
            </li>
            <!-- Link of the last page -->
            <li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
              <a class='page-link' href='allfiles.php?query=<?php echo $query;?>&page=<?php echo $total_pages;?>'>>>                      
              </a>
            </li>
          </ul>
       <?php   } ?>
       
		</div>
		<div class="col-md-1">
		</div>
		 
	</div>
    
   </div>
		
<?php

include "shared/foot.php";

?>