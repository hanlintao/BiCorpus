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

		<div class="col-md-4">
			
		</div>		
	  </div>
   </div>
   
   <div class="row">
		<div class="col-md-3">
		 <div class="row">
			<div class="col-md-1">
			</div>
			<div class="col-md-10">
		<?php
		
		
		if($user_type ==1 )
		{
			
			
			echo '
			
			<form action="usercreate.php" method="post" class="form-horizontal" role="form">
			
			<div class="form-group">
				<label>
					用户名
				</label>
				<textarea class="form-control" rows="1" name="username"></textarea>
			</div>
			
			<div class="form-group">
				<label>
					姓名
				</label>
				<textarea class="form-control" rows="1" name="fullname"></textarea>
			</div>

			<div class="form-group">
				<label>
					单位
				</label>
				<textarea class="form-control" rows="1" name="university"></textarea>
			</div>
			
			<div class="form-group">
				<label>
					密码
				</label>
				<textarea class="form-control" rows="1" name="password"></textarea>
			</div>
			
			<div class="form-group">
				<label>
					用户类型
				</label>
				<textarea class="form-control" rows="1" name="type"></textarea>
			</div>
			
			<div class="form-group">
			
				<button type="submit" name="submit" value="Submit" class="btn btn-primary" >创建</button>
			</div>
		</form>
			
			
			
			
			';
			
			
			
			
			
			
		}
		
		
		?>
		</div>
		<div class="col-md-1">
			</div>
			
		</div>
		
		</div>
		<div class="col-md-6">

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
		
		$limit = 100;
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
			
		$sql_count_data = "SELECT COUNT(*) 'total_rows' FROM `users` WHERE type = 2 AND (fullname LIKE '%{$query}%' OR university LIKE '%{$query}%')";
		
		//$sql_count_data = "SELECT COUNT(*) 'total_rows' FROM `tmdata` ";
		mysqli_query($conn,"set names utf8"); 
		$count_data = mysqli_query($conn, $sql_count_data);
		$total_data = mysqli_fetch_array($count_data,MYSQLI_ASSOC);
		$total_rows = $total_data["total_rows"];
		
		$total_pages = ceil($total_rows / $limit);			
			

	
			
		$sql = "SELECT * FROM users WHERE type = 2 AND (fullname LIKE '%{$query}%' OR university LIKE '%{$query}%') ORDER BY id  limit $offset, $limit";
		
		mysqli_query($conn,"set names utf8"); 
		
		$result = mysqli_query($conn,$sql);
		
		if(mysqli_num_rows($result) > 0) {
		
		echo "<table class='table table-bordered table-striped'>
				<thead>
				
				<td width='30%'  style='vertical-align: middle;text-align: center;'>姓名</td>
				<td width='50%'  style='vertical-align: middle;text-align: center;'>单位</td>
				
				<td width='20%'  style='vertical-align: middle;text-align: center;'>成果主页</td>
				
			</thead>";
					
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
			{
				echo "<tr>
						
						<td  style='vertical-align: middle;text-align: center;'>";
						
						if($user_type == 1)
						{
							echo '<a href="volunteers.php?id='.$row['id'].'">
									<span class="glyphicon glyphicon-edit"></span>
							</a>';
						}
						
				echo " {$row["fullname"]}</td><td  style='vertical-align: middle;text-align: center;'>{$row["university"]}</td>
						<td  style='vertical-align: middle;text-align: center;'><a class='btn btn-success' href='contribution.php?id={$row["id"]}' target='_blank'>查看</a></td>

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
              <a class='page-link' href='volunteers.php?query=<?php echo $query;?>&page=1'><<</a>
            </li>
            <!-- Link of the previous page -->
            <li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
              <a class='page-link' href='volunteers.php?query=<?php echo $query;?>&page=<?php ($page>1 ? print($page-1) : print 1)?>'><</a>
            </li>
            <!-- Links of the pages with page number -->
            <?php for($i=$start; $i<=$end; $i++) { ?>
            <li class='page-item <?php ($i == $page ? print 'active' : '')?>'>
              <a class='page-link' href='volunteers.php?query=<?php echo $query;?>&page=<?php echo $i;?>'><?php echo $i;?></a>
            </li>
            <?php } ?>
            <!-- Link of the next page -->
            <li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
              <a class='page-link' href='volunteers.php?query=<?php echo $query;?>&page=<?php ($page < $total_pages ? print($page+1) : print $total_pages)?>'>></a>
            </li>
            <!-- Link of the last page -->
            <li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
              <a class='page-link' href='volunteers.php?query=<?php echo $query;?>&page=<?php echo $total_pages;?>'>>>                      
              </a>
            </li>
          </ul>
       <?php   } ?>
       
		</div>
		<div class="col-md-3">
		</div>
		 
	</div>
    
   </div>
		
<?php

include "shared/foot.php";

?>