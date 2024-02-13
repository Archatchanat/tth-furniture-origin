<?
	include "../connect/function.php";
	include "../connect/connect.php";
	
	if($_GET['action']=="send")
	{
	
		$tell_admin_email = "SELECT * FROM admin WHERE admin_email = '".$_POST['admin_email']."'";
		$get_admin_email  = mysql_query($tell_admin_email);
		$have = mysql_num_rows($get_admin_email);
		
		while($rs_admin_email = mysql_fetch_array($get_admin_email))
		{
				$admin_level  	= $rs_admin_email['admin_level'];
				$admin_gp_id  	= $rs_admin_email['admin_gp_id'];
				
				$admin_id	   	= $rs_admin_email['admin_id'];
				$admin_rank     = $rs_admin_email['admin_rank'];
				$admin_thumb    = $rs_admin_email['admin_thumb'];
				$admin_image    = $rs_admin_email['admin_image'];
				
				$admin_email    = $rs_admin_email['admin_email'];
				$admin_password = $rs_admin_email['admin_password'];
				
				$admin_name     = $rs_admin_email['admin_name'];
				$admin_tel     	= $rs_admin_email['admin_tel'];
				
				$admin_poster   = $rs_admin_email['admin_poster'];
				$admin_updater  = $rs_admin_email['admin_updater'];
				
				$admin_date     = $rs_admin_email['admin_date'];
				$admin_update   = $rs_admin_email['admin_update'];
				
				$admin_publish  = $rs_one['admin_publish'];
		}
		
		
		if($have == 0)
		{
			echo "<script language='JavaScript'>";
			echo "alert('Email incorrect no this email in system');";
			echo "window.location='index.php';";
			echo "</script>";
			exit();
		}
		else 
		{
	
	// send email
	if($_GET["action"]=="send")
	{
		//----------------------------------------------------------------------------------------------------------------
				$time       = date("Y-m-d H:i:s");;
				$strTo      = $admin_email;
				$strSubject = "$admin_name :: Admin Account ( New Admin ) $time";
				$strHeader  = "Content-type: text/html; charset=utf-8\n"; // or UTF-8 //
				$strHeader .= "From: wongsakorn@worldit.co.th";
				//$strHeader .= "From: minemom@hotmail.com";
				$strVar     = "My Message";
				$strMessage = "
					<fieldset style='width:500px;'>
					<table width='500' border='0' bordercolor='#999999' cellpadding='3' cellspacing='0'>
						<tr>
							<td colspan='2' bgcolor='#FE6A3C'><font color=white size='2'><b>$admin_name : Admin Account ( New Admin )</b></font></td>
						</tr>
						<tr>
							<td align='right' width='100'>Email ::</div></td>
							<td align='left' width='400'>".$admin_email."</div></td>
						</tr>
						<tr>
							<td align='right' width='100'>Password ::</div></td>
							<td align='left' width='400'>".$admin_password."</div></td>
						</tr>
						<tr>
							<td align='right' width='100'>Name ::</div></td>
							<td align='left' width='400'>".$admin_name."</div></td>
						</tr>
						<tr>
							<td align='right' width='100'>Tel ::</div></td>
							<td align='left' width='400'>".$admin_tel."</div></td>
						</tr>
						<tr>
    						<td colspan='2'><a href='$admin_wed/admin'>Admin Management System</a></td>
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
			echo "alert('Send Complete');";
			echo "window.location='index.php';";
			echo "</script>";
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: Login ::</title>
<script language="javascript">
	function formvalidate(form){
	
	filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
		if(sendpassword.admin_email.value == ""){
			alert("Please enter Email.");
			sendpassword.admin_email.focus();
			return false
		}
		
		if (!(filter.test(sendpassword.admin_email.value))){
			alert("Please enter valid Email address.");
			sendpassword.admin_email.focus();
			sendpassword.admin_email.value="";
			return false;
		}
		
		return true;
	}	
</script>
<style type="text/css">
<!--
.normal {
	font-family: Tahoma;
	font-size: 12px;
	color: #333333;
}
body {
	margin-top: 100px;
}
-->
</style>

</head>

<body onLoad="startFocus()">
<table width="700" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="50" colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td background="images/login_right_center.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="4%"><img src="images/login_left.jpg" width="16" height="233" /></td>
            <td width="92%" background="images/login_right_center.jpg"><div align="center"><img src="images/1.jpg" width="357"  height="183" /></div></td>
            <td width="4%">&nbsp;</td>
          </tr>
        </table></td>
        <td background="images/login_right_center.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
            <td width="100%"><form name="form1" method="post" action="?action=send" onSubmit="return checkvalue5()"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="normal">

                <tr>
                  <td nowrap="nowrap">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td nowrap="nowrap"><div align="right"><strong>Email :</strong></div></td>
                  <td><input name="admin_email" type="text" style="width:150px; color:#0000CC;" /></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><strong>Enter your Email , then click send</strong></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="Submit" value="Send" />
                    <input type="button" name="Submit"   value="Back" onclick="window.location='index.php';" /></td>
                </tr>
                <tr>
                  <td colspan="2" align="center">&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>

            </table>
            </form></td>
            <td><img src="images/login_right.jpg" alt="" width="16" height="233" /></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>