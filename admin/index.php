<?
	session_start();
	include "../connect/connect.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Management System</title>

<!------------------------------------------------------------------------------------------------------------------------------ -->
<!--start :: css only index admin -->
<style type="text/css">
<!--
.style_Tid{
	color: #FF6600;
	font-size: 14px;
	background-color: #FFFFFF;
	border: 1px solid #CCCCCC;
}
.style2 {
	color: #003399;
	border: 1px solid #999999;
	font-family: MS Sans Serif,Verdana, Arial, Helvetica, sans-serif;
	background-color: #FFFFFF;
	background-image: url(pic_css/bts1.jpg);
	height: 25px;
	cursor: hand;
}
.style4 {
	color: #003399;
	font-family: MS Sans Serif,Verdana, Arial, Helvetica, sans-serif;
	font-size: 10pt;
}
.styletxt {
		color: #003399;
		font-family: MS Sans Serif,Verdana, Arial, Helvetica, sans-serif;
	   font-size: 10pt;
		height: 22px;
		font-weight:bold;
		border: 1px solid #000000;
}
.style5 {
	color: #D90000;
	font-family: MS Sans Serif,Verdana, Arial, Helvetica, sans-serif;
   font-size: 10pt;
}
.textMemuser{
	color: #4D4D4D;
	font-family: MS Sans Serif,Verdana, Arial, Helvetica, sans-serif;
   font-size: 10pt;

}
body {
	background-image: url();
	background-color: #000066;
}
-->
</style>
<!--end__ :: css only index admin -->
<!------------------------------------------------------------------------------------------------------------------------------ -->

</head>

<!------------------------------------------------------------------------------------------------------------------------------ -->
<!--start :: check validation -->

<script language="JavaScript">

function checkvalue5(){
	if(form1.admin_email.value == "") {
		alert("Please Enter Email.");
		form1.admin_email.focus();
		return false
	}
	if(form1.admin_password.value == "") {
		alert("Please Enter Password.");
		form1.admin_password.focus();
		return false
	}
	return true;
}
</script>

<!--start :: check validation -->
<!------------------------------------------------------------------------------------------------------------------------------ -->

<body>
	
	<!------------------------------------------------------------------------------------------------------------------------------ -->
	<!--start form login -->
	<form name="form1" method="post" action="" onSubmit="return checkvalue5()">
	<div align="center" style="margin-top:150px;">
	<table width="22%"  border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
	<tr>
    	<td bordercolor="#FFFFFF" bgcolor="#FFFFFF">
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#000066">
          	<tr bordercolor="#FFFFFF" bgcolor="#FFFFFF">
            	<td><img src="images/login.jpg" alt="" width="502" height="119" /></td>
          	</tr>
          	<tr bordercolor="#FFFFFF" bgcolor="#FFFFFF">
            	<td width="100%">
              		<table width="100%" border="0" cellpadding="1" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
					
                	<tr bordercolor="#FFFFFF" bgcolor="#E9E9E9">
                  		<td colspan="2" align="center">&nbsp;<span id="mySpan"></span></td>
            		</tr>
          			<tr bordercolor="#FFFFFF" bgcolor="#E9E9E9">
            			<td width="33%"><div align="right">
							<span class="style4">Email&nbsp;::</span></div></td>
                		<td width="67%" align="left">
							<input type="text" name="admin_email" id="admin_email" style="width:150px; color:#0000CC;">                  
						</td>
					</tr>
            		<tr bordercolor="#FFFFFF" bgcolor="#E9E9E9">
            			<td valign="top"><div align="right"><span class="style4">Password&nbsp;::</span></div></td>
                		<td align="left">
							<input type="password" name="admin_password" id="admin_password" style="width:150px; color:#0000CC;">	<br/>
			<a href="index_password.php" style="text-decoration:none;"><font style="font-size:12px" color="#0000CC">Forget Password</font></a>			
						</td>
        			</tr>
					<tr bordercolor="#FFFFFF" bgcolor="#E9E9E9">
						<td colspan="2">&nbsp;</td>
					</tr>
                	<tr bordercolor="#FFFFFF" bgcolor="#E9E9E9">
                  		<td>&nbsp;</td>
                  		<td align="left">
							<input type="hidden" name="login" value="true">
							
							<input type="submit" name="Submit"  value="Login" style="color:#0000CC">
							<input type="reset"  value="Clear"  style="color:#0000CC">
							
							
						</td>
                	</tr>
					<tr bordercolor="#FFFFFF" bgcolor="#E9E9E9">
						<td colspan="2">&nbsp;</td>
					</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
    	</tr>
	</table>
	</div>  
	</form>
	<!--end form login -->
	<!------------------------------------------------------------------------------------------------------------------------------ -->
	
</body>
</html>

<?
	if($_POST["login"]=="true")
	{
		// Verify username and password ------------------------------------
		$tell_admin = "SELECT * 
					   FROM   admin
					   WHERE  admin_email 	 = '".$_POST["admin_email"]."' AND
					          admin_password = '".$_POST["admin_password"]."' and admin_publish='Yes'";
							  
		$get_admin  = mysql_query($tell_admin);
		$admin_num  = mysql_num_rows($get_admin);
		
		// step 1 : have or not in database
		if($admin_num !=1){
			echo "<script language=\"JavaScript\">";
			echo "alert('Username and Password Incorrect');";
			echo "window.location='index.php';";
			echo "</script>";
			exit();
		}else{ // step 2 : have
		
			$objResult = mysql_fetch_array($get_admin);
			
			$_SESSION["str_admin_id"] 	 = $objResult['admin_id'];
			$_SESSION["str_admin_level"] = $objResult['admin_level'];
			$_SESSION["str_admin_email"] = $objResult['admin_email'];
	
			
			session_write_close();
			
			$admin_publish = $objResult['Admin_Status'];
			
			if($admin_publish == "No"){ // step 3 : status yes or no
				echo "<script language=\"JavaScript\">";
				echo "alert('Username and Password Incorrect');";
				echo "window.location='index.php';";
				echo "</script>";
				exit();
			} 
			
			echo "<script language=\"JavaScript\">";
			echo "window.location='home.php';";
			echo "</script>";
			exit();
		}
	}
?>