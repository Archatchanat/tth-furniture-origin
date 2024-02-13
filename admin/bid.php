<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 
	if($_GET['all']=="true"){
		$_SESSION["str_bid_gp_id"] = "";
	}
	
	if($_GET['bid_gp_id']!=""){
		$_SESSION["str_bid_gp_id"] = $_GET['bid_gp_id'];
	}
?>

<?
	// start insert ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="insert")
	{
		$_POST['bid_email'] = trim($_POST['bid_email']);
		
		// check email duplicate ------------------------------------------------------------------------------------------------
		/*$tel_check 	= "select * from bid where bid_email = '".$_POST['bid_email']."'";
		$get_check  = mysql_query($tel_check);
		$num_check  = mysql_num_rows($get_check);
		
		if($num_check>0){
			echo "<script language=\"JavaScript\">";
			echo "window.location='bid.php?say=duplicate';";
			echo "</script>";
			exit();
		}*/
		// check email duplicate ------------------------------------------------------------------------------------------------
		
		
		// start resize picture		
		$tellway  = "INSERT INTO bid VALUES(";
		$tellway .= "0
					,'$_POST[bid_email]'
					,'$_POST[bid_name]'
					,'$_POST[bid_tel]'
					,'$_POST[bid_tel2]'
					,'$_POST[bid_fax]'
					,'".$_SESSION["str_admin_email"]."'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,NOW()
					,'$_POST[bid_publish]'
					";
		$tellway .= ")";
		$dbquery = mysqli_query($conn,$tellway);
		
		echo "<script language=\"JavaScript\">";
		echo "window.location='bid.php';";
		echo "</script>";
    }
	// end__ insert ----------------------------------------------------------------------------------------------------------------------
	
	// start update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="save")
	{	
		
		$sql_up = "update bid set
					 bid_email    = '$_POST[bid_email]'
					,bid_name     = '$_POST[bid_name]'
					,bid_tel     = '$_POST[bid_tel]'
					,bid_tel2     = '$_POST[bid_tel2]'
					,bid_fax     = '$_POST[bid_fax]'
					,bid_updater  = '".$_SESSION["str_admin_email"]."'
					,bid_update   = NOW()
					,bid_publish  = '$_POST[bid_publish]'
					where bid_id  = '".$_POST['bid_id']."'";
		$dbquery = mysql_query($sql_up);
		
		echo "<script language='JavaScript'>";
		echo "window.location='bid.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	
	// start delete ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="del")
	{
		$folder  = "../picture/picture_bid_thumb";
		$destroy = delete_one_image($folder,$_GET['thumb']);
		
		$folder  = "../picture/picture_bid_image";
		$destroy = delete_one_image($folder,$_GET['image']);
		
		$sql_del= "delete from bid where bid_id='".$_GET["bid_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		
		echo "<script language='JavaScript'>";
		echo "window.location='bid.php';";
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
				$folder1  = "../picture/picture_bid_thumb";
				$destroy = delete_one_image($folder1,$_POST['thumb'][$j]);
				
				$folder2  = "../picture/picture_bid_image";
				$destroy = delete_one_image($folder2,$_POST['image'][$j]);
				// end__ process delete old picture
				
				$sql_del= "delete from bid where bid_id='".$_POST["delete_id"][$j]."'";
				$dbquery_del = mysql_query($sql_del);
			}		
		}
		
		echo "<script language='JavaScript'>";
		echo "window.location='bid.php';";
		echo "</script>";
	}
	// end__ delete ----------------------------------------------------------------------------------------------------------------------
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>bid</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="partner.js"></script>

<script language="JavaScript">
	function checkvalue(action){
		filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		
		if(form1.bid_email.value == ""){
			alert("กรุณากรอก อีเมลล์");
			form1.bid_email.focus();
			return false
		}
		if (!(filter.test(form1.bid_email.value))) {
			alert("กรุณากรอก รูปแบบอีเมลล์ให้ถูกต้อง");
			form1.bid_email.value = ""
			form1.bid_email.focus();
			return false;
		}
		if(form1.bid_name.value == ""){
			alert("กรุณากรอก ชื่อ");
			form1.bid_name.focus();
			return false
		}
		if(form1.bid_tel.value == ""){
			alert("กรุณากรอก เบอร์โทรศัพท์");
			form1.bid_tel.focus();
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
		if(form2.bid_gp_id.value == "") {
			alert("กรูณาเลือก กลุ่ม");
			form2.bid_gp_id.focus();
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
		
			
			<form method="get" action="bid.php" name="form2" onSubmit="return checkvalue2()">
			<table width="100%">
				<tr>
					
					<td width="52%">
						ชื่อผู้เสนอราคา : 
					  <input name="button" type="button" value="+ เพิ่มข้อมูล" onclick="window.location='bid.php?action=add';"/>
			  	  </td>
				

				  <td width="18%" align="right">
						
			    </td>
					<td width="4%">
						<input type="submit" name="Submit3" value="ตกลง" /> 
				  </td>
						<td width="6%">
						| 
						<input type="button" name="Submit"   value="ทั้งหมด" onClick="window.location='bid.php?all=true';"/>
				  </td>
				</tr>
			</table>
			</form>
			<hr/>
			
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : add data -->
	<?
		if($_GET['action']=="add"){
		
		
	?>
	<form name="form1" action="?action=insert" method="post" onSubmit="return checkvalue('')" enctype="multipart/form-data">
		<table width="100%">
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
    			<td align="right">อีเมลล์ ::</td>
    			<td align="left"><input name="bid_email" type="text" id="bid_email" value="" size="40"/></td>
  			</tr>
  			<tr>
    			<td align="right">ชื่อ ::</td>
    			<td align="left"><input name="bid_name" type="text" id="bid_name" value="" size="40"/></td>
  			</tr>
			<tr>
    			<td align="right"> มือถือ::</td>
    			<td align="left"><input name="bid_tel" type="text" id="bid_tel" value="" size="40"/></td>
  			</tr>
			<tr>
              <td align="right">โทรศัพท์ ::</td>
			  <td align="left"><input name="bid_tel2" type="text" id="bid_tel2" value="" size="40"/></td>
		  </tr>
			<tr>
              <td align="right">แฟกซ์ ::</td>
			  <td align="left"><input name="bid_fax" type="text" id="bid_fax" value="" size="40"/></td>
		  </tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td align="right">สถานะ ::</td>
				<td>
					<input type="radio" name="bid_publish" value="Yes" checked="checked">อนุญาต
					&nbsp;
					<input type="radio" name="bid_publish" value="No" >ไม่อนุญาต				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="Submit" value="ยืนยันข้อมูล" >
					<input type="button" name="Submit" value="ยกเลิก" onClick="window.location='bid.php';"/>				</td>
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
						from    bid
						where 
						   	   bid.bid_id = '".$_GET['bid_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
					
				$bid_id	   	= $rs_one['bid_id'];
				$bid_email    = $rs_one['bid_email'];
				$bid_name     = $rs_one['bid_name'];
				$bid_tel     	= $rs_one['bid_tel'];
				$bid_tel2     	= $rs_one['bid_tel2'];
				$bid_fax     	= $rs_one['bid_fax'];
				$bid_poster   = $rs_one['bid_poster'];
				$bid_updater  = $rs_one['bid_updater'];
				$bid_date     = $rs_one['bid_date'];
				$bid_update   = $rs_one['bid_update'];
				$bid_publish  = $rs_one['bid_publish'];
			}
	?>	
	<form name="form1" action="?action=save" method="post" onSubmit="return checkvalue('fix')" enctype="multipart/form-data">
	<div class="text_detail">
		รายละเอียด : สร้างวันที่ : <?=dateform($bid_date)?> [ <?=$bid_poster?> ] , แก้ไขล่าสุดวันที่ <?=dateform($bid_update)?> , [ <?=$bid_updater?> ]
	</div>
	<table id="myTable" bgcolor="#E6E6E6" width="100%">
		<tr>
			<td width="15%"></td>
			<td>
				<input type="hidden" name="bid_id" 		value="<?=$bid_id?>">
				<input type="submit" name="Submit"   		value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   		value="ยกเลิก" onClick="window.location='bid.php';"/>			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  		<tr>
    			<td align="right">อีเมลล์ ::</td>
    			<td align="left"><input name="bid_email" type="text" id="bid_email" value="<?=$bid_email?>" size="40"/></td>
  			</tr>
  			<tr>
    			<td align="right">ชื่อ ::</td>
    			<td align="left"><input name="bid_name" type="text" id="bid_name" value="<?=$bid_name?>" size="40"/></td>
  			</tr>
			<tr>
    			<td align="right">มือถือ ::</td>
    			<td align="left"><input name="bid_tel" type="text" id="bid_tel" value="<?=$bid_tel?>" size="40"/></td>
  			</tr>
		<tr>
			<td align="right"> โทรศัพท์ ::</td>
			  <td align="left"><input name="bid_tel2" type="text" id="bid_tel2" value="<?=$bid_tel2?>" size="40"/></td>
		  </tr>
			<tr>
              <td align="right">แฟกซ์ ::</td>
			  <td align="left"><input name="bid_fax" type="text" id="bid_fax" value="<?=$bid_fax?>" size="40"/></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="right">สถานะ ::</td>
			<td>
				<input type="radio" name="bid_publish" value="Yes" <? if($bid_publish=="Yes"){?>checked="checked"<? } ?>>อนุญาต
				&nbsp;
				<input type="radio" name="bid_publish" value="No" <? if($bid_publish=="No"){?>checked="checked"<? } ?>>ไม่อนุญาต			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   value="ยกเลิก" onClick="window.location='bid.php';"/>			</td>
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
		
		if( $_SESSION["str_bid_gp_id"] ==""){
			$tel = "select * 
					from    bid
					 ";
		} else {
			$tel = "select * 
					from    bid
					where  
						   bid.bid_gp_id = '".$_SESSION["str_bid_gp_id"]."'";
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
					if( $_SESSION["str_bid_gp_id"] == ""){
						$_GET['type_stack'] = "DESC";
					} else {
						$_GET['type_stack'] = "DESC";
					}
				}
			
				if($_GET['stack']=="")
				{ 
					if( $_SESSION["str_bid_gp_id"] ==""){
						$_GET['stack'] = "bid_id";
					} else {
						$_GET['stack'] = "bid_rank";
					}
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>	
  	<thead>
		<tr>
			<td width="10%"><input type=checkbox id="checkAll" onClick="selectAll(<?=$Num_Rows?>)"></td>
			
			
			<td width="8%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=bid_rank&type_stack=ASC" style="text-decoration:none; color:#000000;">ลำดับ</a>
				<? }else { ?>
   					<a href="?stack=bid_rank&type_stack=DESC" style="text-decoration:none; color:#000000;">ลำดับ</a>
				<? } ?>                </td>

			<td width="36%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=bid_name&type_stack=ASC" style="text-decoration:none; color:#000000;">ชื่อ-นามสกุล</a>
				<? }else { ?>
   					<a href="?stack=bid_name&type_stack=DESC" style="text-decoration:none; color:#000000;">ชื่อ-นามสกุล</a>
				<? } ?>			</td>
			<td width="18%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=bid_date&type_stack=ASC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
				<? }else { ?>
   					<a href="?stack=bid_date&type_stack=DESC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
				<? } ?>			</td>
			<td width="12%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=bid_publish&type_stack=ASC" style="text-decoration:none; color:#000000;">สถานะ</a>
				<? }else { ?>
   					<a href="?stack=bid_publish&type_stack=DESC" style="text-decoration:none; color:#000000;">สถานะ</a>
				<? } ?>			</td>
			<td width="9%">แก้ไข</td>
			<td width="7%">ลบ</td>
		</tr>
	</thead>
	<tbody>
	
	<?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
  	<tr id="tr<?=$i?>" onMouseOver='mOvr(this,"#E6E6E6");' onMouseOut='mOut(this,"#ffffff");'>
		<td><input type=checkbox id="check<?=$i?>" name="delete_id[<?=$i?>]" value="<?=$rs['bid_id']?>" onClick="if(this.checked==true){ selectRow('tr<?=$i?>'); }else{ deselectRow('tr<?=$i?>'); }">
		
			<input type="hidden" id="thumb<?=$i?>" name="thumb[<?=$i?>]" value="<?=$rs['bid_thumb']?>" >
			<input type="hidden" id="image<?=$i?>" name="image[<?=$i?>]" value="<?=$rs['bid_image']?>" >		</td>
		
    	<td>
			<?=$rs['bid_id']?>		</td>
		
		<td>
			Email : <?=$rs['bid_email']?> <br/>
			<?=$rs['bid_name']?>
			<br/></td>
		<td>
			<?=dateform($rs['bid_date'])?> 
			<br/>
			<font class="text_small_gray">By <?=$rs['bid_poster']?></font>		</td>
		<td>
			<?=$rs['bid_publish'];?>		</td>
    	<td>
			<a href="?fix=true&bid_id=<?=$rs["bid_id"];?>">
				<img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/>			</a>		</td>
		<td>
			<a href="?action=del&bid_id=<?=$rs["bid_id"];?>&thumb=<?=$rs['bid_thumb']?>&image=<?=$rs['bid_image']?>"onClick="return Conf(<?=$rs["bid_rank"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0"></a>		</td>
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
