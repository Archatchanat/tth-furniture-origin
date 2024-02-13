<?
session_start(); 
$http='http://www.siam3.com/billing/admin/';	
	//Connect Database
	/*$host = "localhost";
$user_name = "root";
	$pass_word = "root";
	$db = "billing";*/

		
$host = "localhost";
$user_name = "rich_db";
	$pass_word = "6c1F3DJAX";
	$db = "rich_db";
	mysql_connect( $host,$user_name,$pass_word) or die ("Can not connect database");
	mysql_select_db($db) or die("Can not select database");
	mysql_query("SET NAMES UTF8");
	
$conn = mysqli_connect($host,$user_name,$pass_word,$db);	

mysqli_set_charset($conn, "utf8");
 
?>
