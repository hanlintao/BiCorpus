<?php
include('config.php');
//session_start();

$user_check=$_SESSION['login_user'];
$user_type = $_SESSION['type'];
$user_id = $_SESSION['userid'];

mysqli_select_db($conn,"tmxs"); //连接数据库
mysqli_query($conn,"set names utf8"); 

$ses_sql=mysqli_query($conn,"SELECT * FROM users WHERE username='{$user_check}' ");

$row=mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

$login_session = $row['username'];
$userfullname = $row['fullname'];


if(!isset($login_session))
{
	header("Location: login.php");
}
?>