<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
?>

<?
	// update
	if($_GET["action"]=="save")
	{	
		$sql_up = "update admin set
				   admin_password	= '$_POST[admin_password]'
				   where admin_id 	= '".$_POST['admin_id']."'";
								
		$dbquery = mysql_query($sql_up);
		
		// send email
	if($_GET["action"]=="save")
	{
		//----------------------------------------------------------------------------------------------------------------
				$time       = date("Y-m-d H:i:s");;
				$strTo      = $_POST['admin_email'];
				$strSubject = "nitipon :: Admin Account ( Change Password )$time";
				$strHeader  = "Content-type: text/html; charset=utf-8\n"; // or UTF-8 //
				$strHeader .= "From: wongsakorn@worldit.co.th";
				//$strHeader .= "From: minemom@hotmail.com";
				$strVar     = "My Message";
				$strMessage = "
					<fieldset style='width:500px;'>
					<table width='500' border='0' bordercolor='#999999' cellpadding='3' cellspacing='0'>
						<tr>
							<td colspan='2' bgcolor='#FE6A3C'><font color=white size='2'><b>nitipon : Admin Account ( Change Password )</b></font></td>
						</tr>
						<tr>
							<td align='right' width='100'>Email ::</div></td>
							<td align='left' width='400'>".$_POST['admin_email']."</div></td>
						</tr>
						<tr>
							<td align='right' width='100'>Password ::</div></td>
							<td align='left' width='400'>".$_POST['admin_password']."</div></td>
						</tr>
						<tr>
							<td align='right' width='100'>Name ::</div></td>
							<td align='left' width='400'>".$_POST['admin_name']."</div></td>
						</tr>
						<tr>
							<td align='right' width='100'>Tel ::</div></td>
							<td align='left' width='400'>".$_POST['admin_tel']."</div></td>
						</tr>
						<tr>
    						<td colspan='2'><a href='www.sima3.com/admin'>Admin Management System</a></td>
  						</tr>
					</table>
					</fieldset>";

					$flgSend = @mail($strTo,$strSubject,$strMessage,$strHeader); // @ = No Show Error //
					if($flgSend){}
					else{echo "Email Can Not Send.";} 
		//----------------------------------------------------------------------------------------------------------------
	}
	// send_email
		
		echo "<script language='JavaScript'>";
		echo "window.location='admin_password.php?edit=complete';";
		echo "</script>";
    }
	// end update
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="partner.js"></script>

<script language="JavaScript">
	function checkvalue(action){		
			if(form1.admin_password.value == "") {
				alert("กรุณากรอก รหัสผ่าน");
				form1.admin_password.focus();
				return false
			}
			if(form1.admin_password2.value == "") {
				alert("กรุณายืนยัน รหัสผ่าน");
				form1.admin_password2.focus();
				return false
			}
		
			if(form1.admin_password.value != form1.admin_password2.value){
				alert("รหัสผ่าน และ ยืนยันรหัสผ่าน ไม่เหมือนกัน");
				form1.admin_password.value  = "";
				form1.admin_password2.value = "";
				form1.admin_password.focus();
				return false
			}
		return true;
	}
</script>
</head>

<body>
<div class="cloth">
	
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<? include "include_top.php";?>
	<div class="top_bar"></div>
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<div class="shirt">
		<div class="shirt_left">
			<? include "include_menu.php";?>
		</div>
		<div class="shirt_right">
			
			<?
				if($_GET['edit']=="complete"){
					$text = "เปลี่ยนรหัสผ่าน <font color=green>เรียบร้อย</font>";
				} else {
					$text = "เปลี่ยนรหัสผ่าน";
				}
			?>
			<?=$text?>
			<hr/>
			
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : edit data -->
	<?
			$tel_one = "select *
						from   admin
						where  admin_id = '".$_SESSION["str_admin_id"]."'";
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
				$admin_level  	= $rs_one['admin_level'];
				$admin_gp_id  	= $rs_one['admin_gp_id'];
				
				$admin_id	   	= $rs_one['admin_id'];
				$admin_rank     = $rs_one['admin_rank'];
				$admin_thumb    = $rs_one['admin_thumb'];
				$admin_image    = $rs_one['admin_image'];
				
				$admin_email    = $rs_one['admin_email'];
				$admin_password = $rs_one['admin_password'];
				
				$admin_name     = $rs_one['admin_name'];
				$admin_tel     	= $rs_one['admin_tel'];
				
				$admin_poster   = $rs_one['admin_poster'];
				$admin_updater  = $rs_one['admin_updater'];
				
				$admin_date     = $rs_one['admin_date'];
				$admin_update   = $rs_one['admin_update'];
				
				$admin_publish  = $rs_one['admin_publish'];
			}
	?>	
	<form name="form1" action="?action=save" method="post" onSubmit="return checkvalue('fix')" enctype="multipart/form-data">
	<table id="myTable" bgcolor="#E6E6E6" width="100%">
		<tr>
			<td width="15%"></td>
			<td width="85%">
				<input type="submit" name="Submit"   value="Save Change" ></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
    		<td align="right">อีเมลล์ ::</td>
    		<td align="left"><span class="text_green"><?=$admin_email?></span></td>
  		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
    		<td align="right">รหัสผ่าน ::</td>
    		<td align="left"><input type="password" name="admin_password" id="admin_password" size="30" value="<?=$admin_password?>"/> <span class="text_red">*</span> พิมพ์ รหัสผ่านใหม่</td>
  		</tr>
		<tr>
    		<td align="right">ยืนยัน รหัสผ่าน ::</td>
    		<td align="left"><input type="password" name="admin_password2" id="admin_password2" size="30" value="<?=$admin_password?>"/> <span class="text_red">*</span> ยืนยัน รหัสผ่านใหม่</td>
  		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="hidden" name="admin_id"    value="<?=$admin_id?>">
				<input type="hidden" name="admin_email" value="<?=$admin_email?>">
				<input type="hidden" name="admin_name" 	value="<?=$admin_name?>">
				<input type="hidden" name="admin_tel" 	value="<?=$admin_tel?>">
				<input type="submit" name="Submit"   	value="Save Change">
			</td>
		</tr>
		<tr>
			<td colspan="2"><hr/></td>
		</tr>
	</table>
	</form>
	<!--end__ : edit data-->	
	<!---------------------------------------------------------------------------------------------------------------------------- -->
		</div>
	</div>
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<div class="down_bar"></div>
	<? include "include_down.php";?>
</div>
</body>

</html>