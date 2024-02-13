<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 
	if($_GET['all']=="true"){
		$_SESSION["str_admin_gp_id"] = "";
	}
	
	if($_GET['admin_gp_id']!=""){
		$_SESSION["str_admin_gp_id"] = $_GET['admin_gp_id'];
	}
?>

<?
	// start insert ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="insert")
	{
		$_POST['admin_email'] = trim($_POST['admin_email']);
		
		// check email duplicate ------------------------------------------------------------------------------------------------
		$tel_check 	= "select * from admin where admin_email = '".$_POST['admin_email']."'";
		$get_check  = mysql_query($tel_check);
		$num_check  = mysql_num_rows($get_check);
		
		if($num_check>0){
			echo "<script language=\"JavaScript\">";
			echo "window.location='admin.php?say=duplicate';";
			echo "</script>";
			exit();
		}
		// check email duplicate ------------------------------------------------------------------------------------------------
		
		
		// start resize picture		
		if(trim($_FILES["fileUpload"]["tmp_name"]) != "")
		{
			// start detect eror on picture
				$picture_name	= $_FILES["fileUpload"]["name"];
				$picture_size   = $_FILES["fileUpload"]["size"];
				$picture_type	= $_FILES["fileUpload"]["type"];
				$picture        = strtoupper(substr($picture_name, -4));
			
				if($picture_size > 5000000){
					echo"<script language='JavaScript'>";
					echo"alert('Picture is too large');";
					echo"</script>";
					echo "<script>history.back()</script>";
					exit();
				} else if($picture != ".JPG" && $picture != ".GIF"){
					echo"<script language='JavaScript'>";
					echo"alert('Picture is only JPG , GIF');";
					echo"</script>";
					echo "<script>history.back()</script>";
					exit();
				}
			// end__ detect eror on picture 
			
			// start process resize picture 
			$time = date("YmdHis");
			$_FILES["fileUpload"]["name"] = $time.$_FILES["fileUpload"]["name"];
			
			$images     = $_FILES["fileUpload"]["tmp_name"];
			$new_images = $time."Thumbnails_".$_FILES["fileUpload"]["name"];
			
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
		}
		// end__ resize picture
		
		$password = random_char(8);	
			
		$tellway  = "INSERT INTO admin VALUES(";
		$tellway .= "0
					,'Top'
					,'1'
					,'2'
					,'".$new_images."'
					,'".$_FILES["fileUpload"]["name"]."'
					,'$_POST[admin_email]'
					,'$password'
					,'$_POST[admin_name]'
					,'$_POST[admin_tel]'
					,'".$_SESSION["str_admin_email"]."'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,NOW()
					,'$_POST[admin_publish]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		
	// send email
	if($_GET["action"]=="insert")
	{
		//----------------------------------------------------------------------------------------------------------------
				$time       = date("Y-m-d H:i:s");;
				$strTo      = $_POST['admin_email'];
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
							<td align='left' width='400'>".$_POST['admin_email']."</div></td>
						</tr>
						<tr>
							<td align='right' width='100'>Password ::</div></td>
							<td align='left' width='400'>".$password."</div></td>
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
		 
		echo "<script language=\"JavaScript\">";
		echo "window.location='admin.php';";
		echo "</script>";
    }
	// end__ insert ----------------------------------------------------------------------------------------------------------------------
	
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
				} else if($picture != ".JPG" && $picture != ".GIF"){
					echo"<script language='JavaScript'>";
					echo"alert('Picture is only JPG , GIF');";
					echo"</script>";
					echo "<script>history.back()</script>";
					exit();
				}
			// end__ detect eror on picture 
			
			// start process resize picture
			
			$time = date("YmdHis");
			$_FILES["fileUpload"]["name"] = $time.$_FILES["fileUpload"]["name"];
			
			$images     = $_FILES["fileUpload"]["tmp_name"];
			$new_images = $time."Thumbnails_".$_FILES["fileUpload"]["name"];
			
			
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
					 admin_level    = 'Top' 
					,admin_gp_id   	= '1' 
					,admin_email     = '$_POST[admin_email]'
					,admin_rank     = '$_POST[admin_rank]'
					,admin_tel     = '$_POST[admin_tel]'
				    ,admin_thumb    = '".$new_images."'
				   	,admin_image    = '".$_FILES["fileUpload"]["name"]."'
					,admin_name     = '$_POST[admin_name]'
					,admin_updater  = '".$_SESSION["str_admin_email"]."'
					,admin_update   = NOW()
					,admin_publish  = '$_POST[admin_publish]'
					where admin_id  = '".$_POST['admin_id']."'";
		$dbquery = mysql_query($sql_up);
		
		echo "<script language='JavaScript'>";
		echo "window.location='admin.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	
	// start delete ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="del")
	{
		$folder  = "../picture/picture_admin_thumb";
		$destroy = delete_one_image($folder,$_GET['thumb']);
		
		$folder  = "../picture/picture_admin_image";
		$destroy = delete_one_image($folder,$_GET['image']);
		
		$sql_del= "delete from admin where admin_id='".$_GET["admin_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		
		echo "<script language='JavaScript'>";
		echo "window.location='admin.php';";
		echo "</script>";
    }
	
	// delete_selected
	if($_GET["action"]=="del_sel")
	{
		$j=0;
		while($j<=$_POST['num_rows']){
			$j++;
			
			if($_POST["delete_id"][$j]!=""){
			
				// start process delete old picture
				$folder1  = "../picture/picture_admin_thumb";
				$destroy = delete_one_image($folder1,$_POST['thumb'][$j]);
				
				$folder2  = "../picture/picture_admin_image";
				$destroy = delete_one_image($folder2,$_POST['image'][$j]);
				// end__ process delete old picture
				
				$sql_del= "delete from admin where admin_id='".$_POST["delete_id"][$j]."'";
				$dbquery_del = mysql_query($sql_del);
			}		
		}
		
		echo "<script language='JavaScript'>";
		echo "window.location='admin.php';";
		echo "</script>";
	}
	// end__ delete ----------------------------------------------------------------------------------------------------------------------
	
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
		filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		if(form1.admin_rank.value == "") {
			alert("กรุณากรอก ลำดับ");
			form1.admin_rank.focus();
			return false
		}
		/*<!--<!--if(form1.admin_level.value == "") {
			alert("กรุณาเลือก ระดับของผู้ดูแลระบบ");
			form1.admin_level.focus();
			return false
		}
		if(form1.admin_gp_id.value == "") {
			alert("กรุณาเลือก กลุ่มของผู้ดูแลระบบ");
			form1.admin_gp_id.focus();
			return false
		} --> -->*/
		if(form1.admin_email.value == ""){
			alert("กรุณากรอก อีเมลล์");
			form1.admin_email.focus();
			return false
		}
		if (!(filter.test(form1.admin_email.value))) {
			alert("กรุณากรอก รูปแบบอีเมลล์ให้ถูกต้อง");
			form1.admin_email.value = ""
			form1.admin_email.focus();
			return false;
		}
		if(form1.admin_name.value == ""){
			alert("กรุณากรอก ชื่อ");
			form1.admin_name.focus();
			return false
		}
		if(form1.admin_tel.value == ""){
			alert("กรุณากรอก เบอร์โทรศัพท์");
			form1.admin_tel.focus();
			return false
		}
		if(action==""){
			if(form1.fileUpload.value == "" ) {
				alert("กรุณาเลือก รูปภาพ");
				form1.fileUpload.focus();
				return false
			}
		}
		return true;
	}
	
	function Conf(text) {
		if (confirm("กรุณายืนยัน การลบ [ "+ text+" ]") ==true) {
			return true;
		}
		return false;
	}
	
	function ConfAll() {
		if (confirm("กรุณายืนยัน การลบ") ==true) {
			return true;
		}
		return false;
	}
	
	function checkvalue2(action){
		if(form2.admin_gp_id.value == "") {
			alert("กรูณาเลือก กลุ่ม");
			form2.admin_gp_id.focus();
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
		
			
			<form method="get" action="admin.php" name="form2" onSubmit="return checkvalue2()">
			<table width="100%">
				<tr>
					
					<td width="52%">
						รายชื่อ-ผู้ดูแลระบบ : 
						<input name="button" type="button" value="+ เพิ่มข้อมูล" onclick="window.location='admin.php?action=add';"/>
			  	  </td>
				

					<td width="18%" align="right">
						
			    </td>
					<td width="4%">
						<input type="submit" name="Submit3" value="ตกลง" /> 
				  </td>
						<td width="6%">
						| 
						<input type="button" name="Submit"   value="ทั้งหมด" onClick="window.location='admin.php?all=true';"/>
				  </td>
				</tr>
			</table>
			</form>
			<hr/>
			
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : add data -->
	<?
		if($_GET['action']=="add"){
		
		if($_SESSION["str_admin_gp_id"]!=""){
			// auto rank
			$tel_auto_rank = "select * from admin order by admin_id DESC LIMIT 0,1";
			$get_auto_rank = mysql_query($tel_auto_rank);
		
			$rank_rows = mysql_num_rows($get_auto_rank);
		
			if($rank_rows == 0){
					$auto_rank = 1;
				} else {
					while($rs_auto_rank = mysql_fetch_array($get_auto_rank)){
					$auto_rank = $rs_auto_rank['admin_rank']+1;
				}
			}
		}	
	?>
	<form name="form1" action="?action=insert" method="post" onSubmit="return checkvalue('')" enctype="multipart/form-data">
		<table width="100%">
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			
			<tr>
				<td align="right">ลำดับ ::</td>
				<td><input type="text" name="admin_rank" size="5" maxlength="5" value="<?=$auto_rank?>"/></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
    			
	    </tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
    			<td align="right">อีเมลล์ ::</td>
    			<td align="left"><input name="admin_email" type="text" id="admin_email" value="" size="40"/></td>
  			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
  			<tr>
    			<td align="right">ชื่อ ::</td>
    			<td align="left"><input name="admin_name" type="text" id="admin_name" value="" size="40"/></td>
  			</tr>
			<tr>
    			<td align="right">โทร ::</td>
    			<td align="left"><input name="admin_tel" type="text" id="admin_tel" value="" size="40"/></td>
  			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td align="right">รูปภาพ ::</td>
				<td><input type="file" name="fileUpload"></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td align="right">สถานะ ::</td>
				<td>
					<input type="radio" name="admin_publish" value="Yes" checked="checked">อนุญาต
					&nbsp;
					<input type="radio" name="admin_publish" value="No" >ไม่อนุญาต				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="Submit" value="ยืนยันข้อมูล" >
					<input type="button" name="Submit" value="ยกเลิก" onClick="window.location='admin.php';"/>				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2"><hr/></td>
			</tr>
	</table>
	</form>
	<?
		}
	?>
	<!--end__ : add data -->
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : edit data -->
	<?
		if($_GET['fix'] == "true"){
			$tel_one = "select  * 
						from    admin
						where 
						   	   admin.admin_id = '".$_GET['admin_id']."'";
				
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
	<div class="text_detail">
		รายละเอียด : สร้างวันที่ : <?=dateform($admin_date)?> [ <?=$admin_poster?> ] , แก้ไขล่าสุดวันที่ <?=dateform($admin_update)?> , [ <?=$admin_updater?> ]
	</div>
	<table id="myTable" bgcolor="#E6E6E6" width="100%">
		<tr>
			<td></td>
			<td>
				<input type="hidden" name="admin_id" 		value="<?=$admin_id?>">
				<input type="hidden" name="admin_thumb"  	value="<?=$admin_thumb?>">
				<input type="hidden" name="admin_image"  	value="<?=$admin_image?>">
				<input type="submit" name="Submit"   		value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   		value="ยกเลิก" onClick="window.location='admin.php';"/>			
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  		<tr>
			<td width="15%" align="right">ลำดับ ::</td>
			<td><input type="text" name="admin_rank" size="5" maxlength="5" value="<?=$admin_rank?>"/></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
    		
			</td> 
  		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  		<tr>
    			<td align="right">อีเมลล์ ::</td>
    			<td align="left"><input name="admin_email" type="text" id="admin_email" value="<?=$admin_email?>" size="40"/></td>
  			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
  			<tr>
    			<td align="right">ชื่อ ::</td>
    			<td align="left"><input name="admin_name" type="text" id="admin_name" value="<?=$admin_name?>" size="40"/></td>
  			</tr>
			<tr>
    			<td align="right">โทร ::</td>
    			<td align="left"><input name="admin_tel" type="text" id="admin_tel" value="<?=$admin_tel?>" size="40"/></td>
  			</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	
		<tr>
			<td align="right">รูปภาพ ::</td>
	  	  	<td valign="top">
				<? list($width, $height, $type, $attr) = getimagesize("../picture/picture_admin_thumb/".$admin_thumb.""); ?>
				<p>กว้าง = <?=$width;?> , สูง = <?=$height;?></p>
				<p><img src="../picture/picture_admin_thumb/<?=$admin_thumb?>"/></p>
				<p><input type="file" name="fileUpload"></p>			
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="right">สถานะ ::</td>
			<td>
				<input type="radio" name="admin_publish" value="Yes" <? if($admin_publish=="Yes"){?>checked="checked"<? } ?>>อนุญาต
				&nbsp;
				<input type="radio" name="admin_publish" value="No" <? if($admin_publish=="No"){?>checked="checked"<? } ?>>ไม่อนุญาต			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   value="ยกเลิก" onClick="window.location='admin.php';"/>			</td>
		</tr>
		<tr>
			<td colspan="2"><hr/></td>
		</tr>
	</table>
	</form>
	<br/>
	<?
		}
	?>
	<!--end__ : edit data-->	
	<!---------------------------------------------------------------------------------------------------------------------------- -->
	
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : list data -->		
	<form name="list" method="post" action="?action=del_sel" onsubmit="return ConfAll()">
	<table width="100%" border="0" cellspacing="0">
	<?
		// query area
		$i=0;
		
		if( $_SESSION["str_admin_gp_id"] ==""){
			$tel = "select * 
					from    admin
					 ";
		} else {
			$tel = "select * 
					from    admin
					where  
						   admin.admin_gp_id = '".$_SESSION["str_admin_gp_id"]."'";
		}
					   
				$objQuery = mysql_query($tel) or die ("Error Query [".$tel."]");
				$Num_Rows = mysql_num_rows($objQuery);
		
				$Per_Page = 20;   // Per Page

				$Page = $_GET["Page"];
				if(!$_GET["Page"])
				{
					$Page=1;
				}

				$Prev_Page = $Page-1;
				$Next_Page = $Page+1;

				$Page_Start = (($Per_Page*$Page)-$Per_Page);
				if($Num_Rows<=$Per_Page)
				{
					$Num_Pages =1;
				}
			
				else if(($Num_Rows % $Per_Page)==0)
				{
					$Num_Pages =($Num_Rows/$Per_Page) ;
				}
				else
				{
					$Num_Pages =($Num_Rows/$Per_Page)+1;
					$Num_Pages = (int)$Num_Pages;
				}
			
				if($_GET['type_stack']=="")
				{ 
					if( $_SESSION["str_admin_gp_id"] == ""){
						$_GET['type_stack'] = "DESC";
					} else {
						$_GET['type_stack'] = "DESC";
					}
				}
			
				if($_GET['stack']=="")
				{ 
					if( $_SESSION["str_admin_gp_id"] ==""){
						$_GET['stack'] = "admin_id";
					} else {
						$_GET['stack'] = "admin_rank";
					}
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>	
  	<thead>
		<tr>
			<td width="6%"><input type=checkbox id="checkAll" onClick="selectAll(<?=$Num_Rows?>)"></td>
			
			
			<td width="10%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=admin_rank&type_stack=ASC" style="text-decoration:none; color:#000000;">ลำดับ</a>
				<? }else { ?>
   					<a href="?stack=admin_rank&type_stack=DESC" style="text-decoration:none; color:#000000;">ลำดับ</a>
				<? } ?>			
                </td>

			<td width="16%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=admin_rank&type_stack=ASC" style="text-decoration:none; color:#000000;">รูปภาพ</a>
				<? }else { ?>
   					<a href="?stack=admin_rank&type_stack=DESC" style="text-decoration:none; color:#000000;">รูปภาพ</a>
				<? } ?>			</td>
			<td width="24%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=admin_name&type_stack=ASC" style="text-decoration:none; color:#000000;">ชื่อ-นามสกุล</a>
				<? }else { ?>
   					<a href="?stack=admin_name&type_stack=DESC" style="text-decoration:none; color:#000000;">ชื่อ-นามสกุล</a>
				<? } ?>			</td>
			<td width="14%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=admin_date&type_stack=ASC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
				<? }else { ?>
   					<a href="?stack=admin_date&type_stack=DESC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
				<? } ?>			</td>
			<td width="8%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=admin_publish&type_stack=ASC" style="text-decoration:none; color:#000000;">สถานะ</a>
				<? }else { ?>
   					<a href="?stack=admin_publish&type_stack=DESC" style="text-decoration:none; color:#000000;">สถานะ</a>
				<? } ?>			</td>
			<td width="4%">แก้ไข</td>
			<td width="3%">ลบ</td>
		</tr>
	</thead>
	<tbody>
	
	<?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
  	<tr id="tr<?=$i?>" onMouseOver='mOvr(this,"#E6E6E6");' onMouseOut='mOut(this,"#ffffff");'>
		<td><input type=checkbox id="check<?=$i?>" name="delete_id[<?=$i?>]" value="<?=$rs['admin_id']?>" onClick="if(this.checked==true){ selectRow('tr<?=$i?>'); }else{ deselectRow('tr<?=$i?>'); }">
		
			<input type="hidden" id="thumb<?=$i?>" name="thumb[<?=$i?>]" value="<?=$rs['admin_thumb']?>" >
			<input type="hidden" id="image<?=$i?>" name="image[<?=$i?>]" value="<?=$rs['admin_image']?>" >
			
		</td>
		
    	<td>
			<?=$rs['admin_rank']?>
		</td>
		
		<td><img src="../picture/picture_admin_thumb/<?=$rs['admin_thumb']?>" width="100"/></td> 
    	<td>
			Email : <?=$rs['admin_email']?> <br/>
			<?=$rs['admin_name']?>
			<br/>
			<font class="text_small_gray">ระดับ : <?=$rs['admin_level']?></font>
		</td>
		<td>
			<?=dateform($rs['admin_date'])?> 
			<br/>
			<font class="text_small_gray">By <?=$rs['admin_poster']?></font>
		</td>
		<td>
			<?=$rs['admin_publish'];?>
		</td>
    	<td>
			<a href="?fix=true&admin_id=<?=$rs["admin_id"];?>">
				<img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/>
			</a>
		</td>
		<td>
			<a href="?action=del&admin_id=<?=$rs["admin_id"];?>&thumb=<?=$rs['admin_thumb']?>&image=<?=$rs['admin_image']?>"onClick="return Conf(<?=$rs["admin_rank"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0"></a>	
		</td>
  	</tr>
	<?
			
		}
	?>
	</tbody>
  	</table>
	
	<hr/>
	
	<table width="100%">
		<tr>
			<td width="30%"><input type="submit" name="Submit2" value="ลบรายการที่เลือก" /></td>
			<td width="70%" align="right">
				<div class="general">รวม 
				  <?= $Num_Rows;?> รายการ : 
				<?
				if($Prev_Page)
				{
					echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&stack=".$_GET['stack']."&type_stack=".$_GET['type_stack']."'><< Back</a> ";
				}

				for($i=1; $i<=$Num_Pages; $i++){
					if($i != $Page)
					{
						echo "<a href='$_SERVER[SCRIPT_NAME]?Page=$i&stack=".$_GET['stack']."&type_stack=".$_GET['type_stack']."'> $i </a>";
					}
					else
					{
						echo " <font size=4 color=green><b> $i </b></font> ";
					}
				}
	
				if($Page!=$Num_Pages)
				{
					echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&stack=".$_GET['stack']."&type_stack=".$_GET['type_stack']."'>Next>></a> ";
				}
				?>
				</div>	
			</td>
		</tr>
	</table>
		<input type="hidden" name="num_rows" id="num_rows" value="<?=$Num_Rows?>">
	</form>
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
		</div>
	</div>
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<div class="down_bar"></div>
	<? include "include_down.php";?>
</div>
</body>

</html>
