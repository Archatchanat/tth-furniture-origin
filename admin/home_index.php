<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="cloth">
	
	<!----------------------------------------------------------------------------------------------------------------------------- -->
	<? include "include_top.php";?>
	<div class="top_bar"></div>
	<!----------------------------------------------------------------------------------------------------------------------------- -->
	
	<!----------------------------------------------------------------------------------------------------------------------------- -->
	<div class="shirt">
		<div class="shirt_left">
			<? include "include_menu_index.php";?>
		</div>
		<div class="shirt_right">
			ยินดีต้อนรับสู่ ระบบแอดมิน<hr/>
			<div style="height:485px; background-color:#FFFFFF; margin-top:10px;">
			<center>
				<img src="images/admin_intro.png" width="720"/>
			    <table width="200" border="0" cellspacing="0">
                  <tr>
                    <td height="34"><form id="form1" name="form1" method="post" action="home_index.php">
                        <input type="submit" name="button" id="button" value="จัดการ Index" />
                    </form></td>
                    <td><form id="form2" name="form2" method="post" action="home.php">
                        <input type="submit" name="button2" id="button2" value="จัดการ Home" />
                    </form></td>
                  </tr>
                </table>
			</center>
			</div>
		</div>
	</div>
	<!----------------------------------------------------------------------------------------------------------------------------- -->
	
	<div class="down_bar"></div>
	<? include "include_down.php";?>
</div>
</body>

</html>
