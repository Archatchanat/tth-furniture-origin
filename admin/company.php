<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 

	
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
			
			
			copy($_FILES["fileUpload"]["tmp_name"],"../picture/picture_company_image/".$_FILES["fileUpload"]["name"]);
			
			
			$folder2  = "../picture/picture_company_image";
			$destroy = delete_one_image($folder2,$_POST['company_image']);
			// end__ process delete old picture
		}
		else {
			$_FILES["fileUpload"]["name"] = $_POST['company_image'];
		}
		// end__ resize picture
		
		$sql_up = "update company set
					company_name     = '$_POST[company_name]'
				   	,company_image    = '".$_FILES["fileUpload"]["name"]."'
					where company_id  = '".$_POST['company_id']."'";
		$dbquery = mysql_query($sql_up);
		
		echo "<script language='JavaScript'>";
		echo "window.location='company.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>company</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="partner.js"></script>

<script language="JavaScript">
	function checkvalue(action){
		filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		if(form1.company_rank.value == "") {
			alert("กรุณากรอก ลำดับ");
			form1.company_rank.focus();
			return false
		}
		/*<!--<!--if(form1.company_level.value == "") {
			alert("กรุณาเลือก ระดับของผู้ดูแลระบบ");
			form1.company_level.focus();
			return false
		}
		if(form1.company_gp_id.value == "") {
			alert("กรุณาเลือก กลุ่มของผู้ดูแลระบบ");
			form1.company_gp_id.focus();
			return false
		} --> -->*/
		if(form1.company_email.value == ""){
			alert("กรุณากรอก อีเมลล์");
			form1.company_email.focus();
			return false
		}
		if (!(filter.test(form1.company_email.value))) {
			alert("กรุณากรอก รูปแบบอีเมลล์ให้ถูกต้อง");
			form1.company_email.value = ""
			form1.company_email.focus();
			return false;
		}
		if(form1.company_name.value == ""){
			alert("กรุณากรอก ชื่อ");
			form1.company_name.focus();
			return false
		}
		if(form1.company_tel.value == ""){
			alert("กรุณากรอก เบอร์โทรศัพท์");
			form1.company_tel.focus();
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
		if(form2.company_gp_id.value == "") {
			alert("กรูณาเลือก กลุ่ม");
			form2.company_gp_id.focus();
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
		
			
			<form method="get" action="company.php" name="form2" onSubmit="return checkvalue2()">
			<table width="100%">
				<tr>
					
					<td width="52%">
						ชื่อบริษัท :			  	  </td>
				

				  <td width="18%" align="right">
						
			    </td>
					<td width="4%">&nbsp;</td>
			  <td width="6%">&nbsp;</td>
			  </tr>
			</table>
			</form>
			<hr/>
			
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : add data --><!--end__ : add data -->
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : edit data -->
	<?
		if($_GET['fix'] == "true"){
			$tel_one = "select  * 
						from    company
						where 
						   	   company.company_id = '".$_GET['company_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
			
				$company_id  	= $rs_one['company_id'];
				$company_name  	= $rs_one['company_name'];
				$company_image  	= $rs_one['company_image'];
				
				
			}
	?>	
	<form name="form1" action="?action=save" method="post" onSubmit="return checkvalue('fix')" enctype="multipart/form-data">
	<div class="text_detail">
		รายละเอียด : สร้างวันที่ : <?=dateform($company_date)?> [ <?=$company_poster?> ] , แก้ไขล่าสุดวันที่ <?=dateform($company_update)?> , [ <?=$company_updater?> ]
	</div>
	<table id="myTable" bgcolor="#E6E6E6" width="100%">
		<tr>
			<td width="15%"></td>
			<td>
				<input type="hidden" name="company_id" 		value="<?=$company_id?>">
				<input type="hidden" name="company_image"  	value="<?=$company_image?>">
				<input type="submit" name="Submit"   		value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   		value="ยกเลิก" onClick="window.location='company.php';"/>			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  			<tr>
    			<td align="right">บริษัท ::</td>
    			<td align="left">
   			    <?php 
 						include("FCKeditor/fckeditor.php");
						$oFCKeditor = new FCKeditor('company_name');
						$oFCKeditor->BasePath = 'FCKeditor/';
						$oFCKeditor->Width  = '600' ;
						$oFCKeditor->Height = '300' ;
						$oFCKeditor->Value = $company_name;
						$oFCKeditor->ToolbarSet = 'Default';
						$oFCKeditor->Create(); 
					?></td>
  			</tr>
	
		<tr>
			<td align="right">รูปภาพ ::</td>
	  	  	<td valign="top">
				<? @list($width, $height, $type, $attr) = getimagesize("../picture/picture_company_image/".$company_image.""); ?>
				<p>กว้าง = <?=$width;?> , สูง = <?=$height;?></p>
				<p><img src="../picture/picture_company_image/<?=$company_image?>"/></p>
				<p><input type="file" name="fileUpload"></p>			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   value="ยกเลิก" onClick="window.location='company.php';"/>			</td>
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
		
			$tel = "select * 
					from    company
					 ";
					   
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
					
						$_GET['type_stack'] = "DESC";
					
				}
			
				if($_GET['stack']=="")
				{ 
					
						$_GET['stack'] = "company_id";
					
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>	
  	<thead>
		<tr>
			<td width="25%"><a href="?stack=company_rank&type_stack=ASC" style="text-decoration:none; color:#000000;">รูปภาพ</a></td>
			<td width="69%">บริษัท</td>
			<td width="6%">แก้ไข</td>
			</tr>
	</thead>
	<tbody>
	
	<?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
  	<tr id="tr<?=$i?>" onMouseOver='mOvr(this,"#E6E6E6");' onMouseOut='mOut(this,"#ffffff");'>
		<td><img src="../picture/picture_company_image/<?=$rs['company_image']?>" width="100"/></td> 
    	<td><br/>
			<?=$rs['company_name']?>
			<br/></td>
		<td>
			<a href="?fix=true&company_id=<?=$rs["company_id"];?>">
				<img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/>			</a>		</td>
		</tr>
	<?
			
		}
	?>
	</tbody>
  	</table>
	
	<hr/>
	
	<table width="100%">
		<tr>
			<td width="30%">&nbsp;</td>
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
