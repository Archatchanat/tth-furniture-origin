<? @session_start();
	
	// access to admin system with out login
	if($_SESSION["str_admin_id"]=="")
	{
		echo"<script language='JavaScript'>";
		echo"alert('Please Login');";
		echo"window.location='index.php';";
		echo"</script>";
		exit();
	}
?>
<p><img src="images/logo.png" width="238" height="62"/></p>
<table width="100%">
		<tr>
			<td width="35%" align="left">
				
				<font color="#FFFFFF">
					ระบบจัดการข้อมูล : <?=$_SESSION["str_admin_email"]?> ออนไลน์
				</font>
			</td>
			<td width="6%" align="left">
				<input name="logout" type="button" value="แก้ไขประวัติ" onClick="window.location='admin_profile.php';"/>
	  	  </td>
			<td width="39%" align="left">
				<input name="logout" type="button" value="เปลี่ยนรหัสผ่าน" onClick="window.location='admin_password.php';"/>
	  	  </td>
			<td width="20%" align="right"> 
				<input name="logout" type="button" value="ออกจากระบบ" onClick="window.location='logout.php';"/>
			</td>
		</tr>
	</table>