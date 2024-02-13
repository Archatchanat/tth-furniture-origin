<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
?>

<?
	// start insert ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="insert")
	{
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
			
			copy($_FILES["fileUpload"]["tmp_name"],"../picture/picture_admin_gp_image/".$_FILES["fileUpload"]["name"]);
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
			ImageJPEG($images_fin,"../picture/picture_admin_gp_thumb/".$new_images);
			ImageDestroy($images_orig);
			ImageDestroy($images_fin);
			// end__ process resize picture
		}
		// end__ resize picture
		
		$tellway  = "INSERT INTO admin_group VALUES(";
		$tellway .= "0
					,'$_POST[admin_gp_rank]'
					,'".$new_images."'
					,'".$_FILES["fileUpload"]["name"]."'
					,'$_POST[admin_gp_name]'
					,'$_POST[admin_gp_content]'
					,'".$_SESSION["str_admin_email"]."'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,NOW()
					,'$_POST[admin_gp_publish]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		 
		echo "<script language=\"JavaScript\">";
		echo "window.location='admin_group.php';";
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
			
			copy($_FILES["fileUpload"]["tmp_name"],"../picture/picture_admin_gp_image/".$_FILES["fileUpload"]["name"]);
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
			ImageJPEG($images_fin,"../picture/picture_admin_gp_thumb/".$new_images);
			ImageDestroy($images_orig);
			ImageDestroy($images_fin);
			// end__ process resize picture
			
			// start process delete old picture
			$folder1  = "../picture/picture_admin_gp_thumb";
			$destroy = delete_one_image($folder1,$_POST['admin_gp_thumb']);
			
			$folder2  = "../picture/picture_admin_gp_image";
			$destroy = delete_one_image($folder2,$_POST['admin_gp_image']);
			// end__ process delete old picture
		}
		else {
			$new_images                   = $_POST['admin_gp_thumb'];
			$_FILES["fileUpload"]["name"] = $_POST['admin_gp_image'];
		}
		// end__ resize picture
		
		$sql_up = "update admin_group set 
					 admin_gp_rank     = '$_POST[admin_gp_rank]'
				    ,admin_gp_thumb    = '".$new_images."'
				   	,admin_gp_image    = '".$_FILES["fileUpload"]["name"]."'
					,admin_gp_name     = '$_POST[admin_gp_name]'
					,admin_gp_content  = '$_POST[admin_gp_content]'
					,admin_gp_updater  = '".$_SESSION["str_admin_email"]."'
					,admin_gp_update       = NOW()
					,admin_gp_publish  = '$_POST[admin_gp_publish]'
					where admin_gp_id  = '".$_POST['admin_gp_id']."'";
		$dbquery = mysql_query($sql_up);
		
		echo "<script language='JavaScript'>";
		echo "window.location='admin_group.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	
	// start delete ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="del")
	{
		$have = num_record("admin","where admin_gp_id = '".$_GET["admin_gp_id"]."'");
		
		if($have == 0 ){
		
			$folder  = "../picture/picture_admin_gp_thumb";
			$destroy = delete_one_image($folder,$_GET['thumb']);
		
			$folder  = "../picture/picture_admin_gp_image";
			$destroy = delete_one_image($folder,$_GET['image']);
		
			$sql_del= "delete from admin_group where admin_gp_id='".$_GET["admin_gp_id"]."'";
			$dbquery_del = mysql_query($sql_del);
			
			$say="";
		} else {
			$say="no_del";
		}
		
			echo "<script language='JavaScript'>";
			echo "window.location='admin_group.php?say=$say';";
			echo "</script>";
		
		
    }
	
	// delete_selected
	if($_GET["action"]=="del_sel")
	{
		$j=0;
		while($j<=$_POST['num_rows']){
			$j++;
			
			if($_POST["delete_id"][$j]!=""){
			
				//check can delete
				$have = num_record("admin","where admin_gp_id = '".$_POST["delete_id"][$j]."'");
				
				if($have == 0 ){
					// start process delete old picture
					$folder1  = "../picture/picture_admin_gp_thumb";
					$destroy = delete_one_image($folder1,$_POST['thumb'][$j]);
				
					$folder2  = "../picture/picture_admin_gp_image";
					$destroy = delete_one_image($folder2,$_POST['image'][$j]);
					// end__ process delete old picture
				
					$sql_del= "delete from admin_group where admin_gp_id='".$_POST["delete_id"][$j]."'";
					$dbquery_del = mysql_query($sql_del);
				}
			}		
		}
		
		echo "<script language='JavaScript'>";
		echo "window.location='admin_group.php';";
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
		if(form1.admin_gp_name.value == "") {
			alert("กรุณากรอก ชื่อ");
			form1.admin_gp_name.focus();
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
			กลุ่ม-ผู้ดูแลระบบ : 
			   <input name="button" type="button" value="+ เพิ่มข้อมูล" onclick="window.location='admin_group.php?action=add';"/>
			   <? 
			   		if($_GET['say']=="no_del"){ 
						echo "<center><font color=red>Can not delete</font></center>"; 
					}
			   ?>
			<hr/>
			
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : add data -->
	<?
		if($_GET['action']=="add"){
			$result = select("admin_group","where 1=1 order by admin_gp_rank DESC limit 0,1");
			$auto_rank = $result['admin_gp_rank']+1;
	?>
	<form name="form1" action="?action=insert" method="post" onSubmit="return checkvalue('')" enctype="multipart/form-data">
		<table width="100%">
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td align="right">ลำดับ ::</td>
				<td><input type="text" name="admin_gp_rank" size="5" maxlength="5" value="<?=$auto_rank?>"/></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
  			<tr>
    			<td align="right">ชื่อ ::</td>
    			<td align="left"><input type="text" name="admin_gp_name" id="admin_gp_name" size="50"/></td>
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
				<td align="right">ข้อความ ::</td>
				<td>
					<?php 
 						include("FCKeditor/fckeditor.php");
						$oFCKeditor = new FCKeditor('admin_gp_content');
						$oFCKeditor->BasePath = 'FCKeditor/';
						$oFCKeditor->Width = '650' ;
						$oFCKeditor->Height = '200' ;
						$oFCKeditor->ToolbarSet = 'write3';
						$oFCKeditor->Create(); 
					?>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td align="right">แสดง ::</td>
				<td>
					<input type="radio" name="admin_gp_publish" value="Yes" checked="checked">ใช่
					&nbsp;
					<input type="radio" name="admin_gp_publish" value="No" >ไม่
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="Submit" value="ยืนยันข้อมูล" >
					<input type="button" name="Submit" value="ยกเลิก" onClick="window.location='admin_group.php';"/>
				</td>
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
			$tel_one = "select * from admin_group where admin_gp_id = '".$_GET['admin_gp_id']."'";
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
				$admin_gp_id	  = $rs_one['admin_gp_id'];
				$admin_gp_rank    = $rs_one['admin_gp_rank'];
				$admin_gp_thumb   = $rs_one['admin_gp_thumb'];
				$admin_gp_image   = $rs_one['admin_gp_image'];	
				$admin_gp_name    = $rs_one['admin_gp_name'];
				$admin_gp_content = $rs_one['admin_gp_content'];
				
				$admin_gp_poster   = $rs_one['admin_gp_poster'];
				$admin_gp_updater  = $rs_one['admin_gp_updater'];
				
				$admin_gp_date    = $rs_one['admin_gp_date'];
				$admin_gp_update  = $rs_one['admin_gp_update'];
				
				$admin_gp_publish = $rs_one['admin_gp_publish'];
			}
	?>	
	<form name="form1" action="?action=save" method="post" onSubmit="return checkvalue('fix')" enctype="multipart/form-data">
	<div class="text_detail">
		รายละเอียด : สร้างวันที่ : <?=dateform($admin_gp_date)?> [ <?=$admin_gp_poster?> ] , แก้ไขล่าสุดวันที่ <?=dateform($admin_gp_update)?> , [ <?=$admin_gp_updater?> ]
	</div>
	<table id="myTable" bgcolor="#E6E6E6" width="100%">
		<tr>
			<td></td>
			<td>
				<input type="hidden" name="admin_gp_id" value="<?=$admin_gp_id?>">
				<input type="hidden" name="admin_gp_thumb"  value="<?=$admin_gp_thumb?>">
				<input type="hidden" name="admin_gp_image"  value="<?=$admin_gp_image?>">
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   value="ยกเลิก" onClick="window.location='admin_group.php';"/>			
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  		<tr>
			<td width="15%" align="right">ลำดับ ::</td>
			<td><input type="text" name="admin_gp_rank" size="5" maxlength="5" value="<?=$admin_gp_rank?>"/></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  		<tr>
    		<td align="right">ชื่อ ::</td>
    		<td align="left"><input type="text" name="admin_gp_name" id="admin_gp_name" size="40" value="<?=$admin_gp_name?>"/></td>
  		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="right">รูปภาพ ::</td>
	  	  	<td valign="top">
				<? list($width, $height, $type, $attr) = getimagesize("../picture/picture_admin_gp_thumb/".$admin_gp_thumb.""); ?>
				<p>กว้าง = <?=$width;?> , สูง = <?=$height;?></p>
				<p><img src="../picture/picture_admin_gp_thumb/<?=$admin_gp_thumb?>"/></p>
				<p><input type="file" name="fileUpload"></p>		  
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
				<td align="right">ข้อความ ::</td>
				<td>
					<?php 
 						include("FCKeditor/fckeditor.php");
						$oFCKeditor = new FCKeditor('admin_gp_content');
						$oFCKeditor->BasePath = 'FCKeditor/';
						$oFCKeditor->Width = '650' ;
						$oFCKeditor->Height = '200' ;
						$oFCKeditor->ToolbarSet = 'write3';
						$oFCKeditor->Value = $admin_gp_content ;
						$oFCKeditor->Create(); 
					?>
				</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="right">Publish ::</td>
			<td>
				<input type="radio" name="admin_gp_publish" value="Yes" <? if($admin_gp_publish=="Yes"){?>checked="checked"<? } ?>>Yes
				&nbsp;
				<input type="radio" name="admin_gp_publish" value="No" <? if($admin_gp_publish=="No"){?>checked="checked"<? } ?>>No			
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   value="ยกเลิก" onClick="window.location='admin_group.php';"/>			
			</td>
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
		
		$tel = "select * from admin_group";
					   
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
					$_GET['type_stack'] = "ASC"; 
				}
			
				if($_GET['stack']=="")
				{ 
					$_GET['stack'] = "admin_gp_rank"; 
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>	
  	<thead>
		<tr>
			<td><input type=checkbox id="checkAll" onClick="selectAll(<?=$Num_Rows?>)"></td>
			<td>
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=admin_gp_rank&type_stack=ASC" style="text-decoration:none; color:#000000;">ลำดับ</a>
				<? }else { ?>
   					<a href="?stack=admin_gp_rank&type_stack=DESC" style="text-decoration:none; color:#000000;">ลำดับ</a>
				<? } ?>		
			</td>
			<td>
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=admin_gp_rank&type_stack=ASC" style="text-decoration:none; color:#000000;">รูปภาพ</a>
				<? }else { ?>
   					<a href="?stack=admin_gp_rank&type_stack=DESC" style="text-decoration:none; color:#000000;">รูปภาพ</a>
				<? } ?>		
			</td>
			<td>
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=admin_gp_name&type_stack=ASC" style="text-decoration:none; color:#000000;">ชื่อ</a>
				<? }else { ?>
   					<a href="?stack=admin_gp_name&type_stack=DESC" style="text-decoration:none; color:#000000;">ชื่อ</a>
				<? } ?>		
			</td>
			<td>
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=admin_gp_date&type_stack=ASC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
				<? }else { ?>
   					<a href="?stack=admin_gp_date&type_stack=DESC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
				<? } ?>		
			</td>
			<td>
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=admin_gp_publish&type_stack=ASC" style="text-decoration:none; color:#000000;">แสดง</a>
				<? }else { ?>
   					<a href="?stack=admin_gp_publish&type_stack=DESC" style="text-decoration:none; color:#000000;">แสดง</a>
				<? } ?>		
			</td>
			<td>แก้ไข</td>
			<td>ลบ</td>
		</tr>
	</thead>
	<tbody>
	
	<?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
  	<tr id="tr<?=$i?>" onMouseOver='mOvr(this,"#E6E6E6");' onMouseOut='mOut(this,"#ffffff");'>
		<td><input type=checkbox id="check<?=$i?>" name="delete_id[<?=$i?>]" value="<?=$rs['admin_gp_id']?>" onClick="if(this.checked==true){ selectRow('tr<?=$i?>'); }else{ deselectRow('tr<?=$i?>'); }">
		
			<input type="hidden" id="thumb<?=$i?>" name="thumb[<?=$i?>]" value="<?=$rs['admin_gp_thumb']?>" >
			<input type="hidden" id="image<?=$i?>" name="image[<?=$i?>]" value="<?=$rs['admin_gp_image']?>" >
			
		</td> 
    	<td><?=$rs['admin_gp_rank']?></td>
		<td><img src="../picture/picture_admin_gp_thumb/<?=$rs['admin_gp_thumb']?>" width="100"/></td> 
    	<td><?=$rs['admin_gp_name']?></td>
		<td>
			<?=dateform($rs['admin_gp_date'])?> <br/>
			<font class="text_small_gray">By <?=$rs['admin_gp_poster']?></font>
		</td>
		<td><?=$rs['admin_gp_publish']?></td>
    	<td><a href="?fix=true&admin_gp_id=<?=$rs["admin_gp_id"];?>"><img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/></a></td>
		<td>
			<a href="?action=del&admin_gp_id=<?=$rs["admin_gp_id"];?>&thumb=<?=$rs['admin_gp_thumb']?>&image=<?=$rs['admin_gp_image']?>"onClick="return Conf(<?=$rs["admin_gp_rank"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0"></a>	
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
				<div class="general">รวม <?= $Num_Rows;?> รายการ : 
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
