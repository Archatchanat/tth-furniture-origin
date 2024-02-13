<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
?>

<?
	// start update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="save")
	{	
		// start resize picture	
		if(trim($_FILES["fileUpload"]["tmp_name"]) != "")
		{
			// start detect eror on picture
				$picture_name	= $_FILES["fileUpload"]["name"];
				$picture_size   = $_FILES["fileUpload"]["size"];
				$picture_type	= $_FILES["fileUpload"]["type"];
				$picture        = strtoupper(substr($picture_name, -4));
			
				//size and type
				if($picture_size > 5000000){
					echo"<script language='JavaScript'>";
					echo"alert('Picture is too large');";
					echo"</script>";
					echo "<script>history.back()</script>";
					exit();
				} else if($picture != ".JPG" && $picture != ".PNG" && $picture != ".GIF"){
					echo"<script language='JavaScript'>";
					echo"alert('Picture is only JPG , PNG , GIF');";
					echo"</script>";
					echo "<script>history.back()</script>";
					exit();
				}
			// end__ detect eror on picture 
			
			// start process resize picture
			$images     = $_FILES["fileUpload"]["tmp_name"];
			$new_images = "Thumbnails_".$_FILES["fileUpload"]["name"];
			copy($_FILES["fileUpload"]["tmp_name"],"../picture/picture_admin_image/".$_FILES["fileUpload"]["name"]);
			$width=100; //*** Fix Width & Heigh (Autu caculate) ***//
			$size=GetimageSize($images);
			$height=round($width*$size[1]/$size[0]);
			
			if($picture == ".GIF"){
				$images_orig = imagecreatefromgif($images); //resize GIF
			}else if($picture == ".JPG"){
				$images_orig = imagecreatefromjpeg($images); //resize  JPEG
			}else if($picture == ".PNG"){
				$images_orig = imagecreatefrompng($images); //resize png
			}
			
			$photoX = ImagesX($images_orig);
			$photoY = ImagesY($images_orig);
			$images_fin = ImageCreateTrueColor($width, $height);
			ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
			ImageJPEG($images_fin,"../picture/picture_admin_thumb/".$new_images);
			ImageDestroy($images_orig);
			ImageDestroy($images_fin);
			// end__ process resize picture
			
			// start process delete old picture
			$folder1  = "../picture/picture_admin_thumb";
			$destroy = delete_one_image($folder1,$_POST['admin_thumb']);
			
			$folder2  = "../picture/picture_admin_image";
			$destroy = delete_one_image($folder2,$_POST['admin_image']);
			// end__ process delete old picture
		}
		else {
			$new_images                   = $_POST['admin_thumb'];
			$_FILES["fileUpload"]["name"] = $_POST['admin_image'];
		}
		// end__ resize picture
		
		$sql_up = "update admin set
				     admin_thumb    = '".$new_images."'
				   	,admin_image    = '".$_FILES["fileUpload"]["name"]."'
					,admin_name     = '$_POST[admin_name]'
					,admin_updater  = '$_POST[admin_name]'
					,admin_update   = NOW()
					where admin_id  = '".$_SESSION["str_admin_id"]."'";
		$dbquery = mysql_query($sql_up);
		
		echo "<script language='JavaScript'>";
		echo "window.location='admin_profile.php?edit=complete';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="partner.js"></script>

<script language="JavaScript">
	
	// check validation form1 when user create new admin
	function checkvalue(action){
		filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

		if(form1.admin_name.value == ""){
			alert("กรุณากรอก ชื่อ");
			form1.admin_name.focus();
			return false
		}
		if (!(filter.test(form1.admin_email.value))) {
			alert("กรุณากรอก รูปแบบอีเมลล์ให้ถูกต้อง");
			form1.admin_email.value = ""
			form1.admin_email.focus();
			return false;
		}
		if(form1.admin_tel.value == ""){
			alert("กรุณากรอก เบอร์โทรศัพท์");
			form1.admin_tel.focus();
			return false
		}
		if(action==""){
			if(form1.fileUpload.value == "" ){
				alert("กรุณาเลือก รูปภาพ");
				form1.fileUpload.focus();
				return false
			}
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
					$text = "แก้ไขประวัติ <font color=green>เรียบร้อย</font>";
				} else {
					$text = "แก้ไขประวัติ";
				}
			?>
			<?=$text?>
			<hr/>
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : edit data -->
	<?
		if(true){
			
			$tel_one = "select *
						from  admin
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
    		<td align="right">ชื่อ ::</td>
    		<td align="left"><input type="text" name="admin_name" id="Name" size="30" value="<?=$admin_name?>"/></td>
  		</tr>
		<tr>
    		<td align="right">เบอร์โทรศัพท์ ::</td>
    		<td align="left"><input type="text" name="admin_tel" id="Tel" size="30" value="<?=$admin_tel?>"/></td>
  		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="right">รูปภาพ ::</td>
			<td valign="top">
				<p><img src="../picture/picture_admin_thumb/<?=$admin_thumb?>"/></p>
				<p><input type="file" name="fileUpload"></p>			</td>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="hidden" name="admin_id" value="<?=$admin_id?>">
				<input type="hidden" name="admin_thumb"    value="<?=$admin_thumb?>">
				<input type="hidden" name="admin_image"    value="<?=$admin_image?>">
				<input type="submit" name="Submit"   value="Save Change" ></td>
		</tr>
		<tr>
			<td colspan="2"><hr/></td>
		</tr>
	</table>
	</form>
	<?
		}
	?>
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