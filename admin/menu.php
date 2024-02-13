<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
	header("Cache-control: private"); 
	

if($_GET['menu_cat_id']!=""){
		$_SESSION["str_menu_cat_id"] = $_GET['menu_cat_id'];
	}?>
<?
	// start insert ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="insert")
	{
		// start resize picture		

		$tellway  = "INSERT INTO menu VALUES(";
		$tellway .= "0
					,'".$_SESSION["str_menu_cat_id"]."'
					,'".$_POST[menu_rank]."'	
					,'".$_POST[menu_name_th]."'
					,'".$_POST[menu_name_en]."'
					,'".$_POST[menu_name_ch]."'
					,'".$_POST[menu_url]."'
					,NOW()
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		 
		echo "<script language=\"JavaScript\">";
		echo "window.location='menu.php';";
		echo "</script>";
    }
	// end__ insert ----------------------------------------------------------------------------------------------------------------------
	
	// start update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="save")
	{	
		// start resize picture	
		
		
		$sql_up = "update menu set 
					menu_url    = '".$_POST[menu_url]."'
				   ,menu_name_th     = '".$_POST[menu_name_th]."'
					,menu_name_en     = '".$_POST[menu_name_en]."'
					,menu_name_ch     = '".$_POST[menu_name_ch]."'
					,menu_day       = NOW()
					,menu_rank     = '".$_POST[menu_rank]."'
					where menu_id  = '".$_POST[menu_id]."'";
		$dbquery = mysql_query($sql_up);
		
		echo "<script language='JavaScript'>";
		echo "window.location='menu.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	
	// start delete ----------------------------------------------------------------------------------------------------------------------
	
	// delete_selected
	if($_GET["action"]=="del_sel")
	{
		$j=0;
		while($j<=$_POST['num_rows']){
			$j++;
			
			if($_POST["delete_id"][$j]!=""){
			
				//check can delete
				$have = num_record("edit","where edit_id = '".$_POST["delete_id"][$j]."'");
			
				if($have == 0 ){
					// start process delete old picture
					$folder1  = "../picture/picture_edit_thumb";
					$destroy = delete_one_image($folder1,$_POST['thumb'][$j]);
				
					$folder2  = "../picture/picture_edit_image";
					$destroy = delete_one_image($folder2,$_POST['image'][$j]);
					// end__ process delete old picture
				
					$sql_del= "delete from editegory where edit_id='".$_POST["delete_id"][$j]."'";
					$dbquery_del = mysql_query($sql_del);
				}
			}		
		}
		
		echo "<script language='JavaScript'>";
		echo "window.location='edit.php';";
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
		if(form1.edit_name.value == "") {
			alert("กรุณากรอก ชื่อเมนูภาษาไทย");
			form1.edit_name.focus();
			return false
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
			แก้ไขเมนู :
		    <hr/>
			
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : add data -->
    <?
		if($_GET['action']=="add"){
		if($_SESSION["str_menu_cat_id"]!=""){
			// auto rank
			$tel_auto_rank = "select * from menu where menu_cat_id = '".$_SESSION["str_menu_cat_id"]."' order by menu_id DESC LIMIT 0,1";
			$get_auto_rank = mysql_query($tel_auto_rank);
		
			$rank_rows = mysql_num_rows($get_auto_rank);
		
			if($rank_rows == 0){
					$auto_rank = 1;
				} else {
					while($rs_auto_rank = mysql_fetch_array($get_auto_rank)){
					$auto_rank = $rs_auto_rank['menu_rank']+1;
				}
			}
		}	
	?>
	
	<form name="form1" action="?action=insert" method="post" onSubmit="return checkvalue('')" enctype="multipart/form-data">
		<table width="100%">
		  <tr>
		    <td align="right">ลำดับ ::</td>
		    <td><input name="menu_rank" type="text" id="menu_rank" value="<?=$auto_rank?>" size="5" maxlength="5"/></td>
	      </tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
  			<tr>
    			<td align="right"> <img src="images/ln_1.png" /> ชื่อ ::</td>
    			<td align="left"><input type="text" name="menu_name_th" id="menu_name_th" size="50"/></td>
  			</tr>
  			<tr>
  			  <td align="right"><img src="images/ln_2.png" /> ชื่อ ::</td>
  			  <td align="left"><input type="text" name="menu_name_en" id="menu_name_en" size="50"/></td>
		  </tr>
  			<tr>
              <td align="right">url  ::</td>
  			  <td align="left"><input type="text" name="menu_url" id="menu_url" size="50"/></td>
		  </tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="Submit" value="ยืนยันข้อมูล" >
					<input type="button" name="Submit" value="ยกเลิก" onClick="window.location='menu.php';"/>				</td>
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
			$tel_one = "select * from menu where menu_id = '".$_GET['menu_id']."'";
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
				$menu_id	  = $rs_one['menu_id'];
				$menu_rank	  = $rs_one['menu_rank'];
				$menu_name_th    = $rs_one['menu_name_th'];
				$menu_name_en    = $rs_one['menu_name_en'];
				$menu_name_ch    = $rs_one['menu_name_ch'];
				$menu_url    = $rs_one['menu_url'];
			
				
			
				
				
			}
	?>	
	<form name="form1" action="?action=save" method="post" onSubmit="return checkvalue('fix')" enctype="multipart/form-data">
	
	
	<div class="text_detail">
		รายละเอียด : สร้างวันที่ : <?=dateform($edit_date)?> [ <?=$edit_poster?> ] , แก้ไขล่าสุดวันที่ <?=dateform($edit_update)?> , [ <?=$edit_updater?> ]
	</div>
	<table id="myTable" bgcolor="#E6E6E6" width="100%">
		<tr>
			<td></td>
			<td>
				<input type="hidden" name="menu_id" value="<?=$menu_id?>">
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   value="ยกเลิก" onClick="window.location='menu.php';"/>			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
		  <td align="right">ลำดับ ::</td>
		  <td><input type="text" name="menu_rank" size="5" maxlength="5" value="<?=$menu_rank?>"/></td>
		  </tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  		<tr>
    		<td align="right"><img src="images/ln_1.png" /> ชื่อเมนู ::</td>
    		<td align="left"><input type="text" name="menu_name_th" id="menu_name_th" size="40" value="<?=$menu_name_th?>"/></td>
  		</tr>
  		<tr>
  		  <td align="right"><img src="images/ln_2.png" /> ชื่อเมนู ::</td>
  		  <td align="left"><input type="text" name="menu_name_en" id="menu_name_en" size="40" value="<?=$menu_name_en?>"/></td>
		  </tr>
  		<tr>
  		 <? if ($_SESSION["str_menu_cat_id"]=="2") { ?><td align="right">url  ::</td>
  		  <td align="left"><input name="menu_url" type="text" id="edit_size3" value="<?=$menu_url?>" size="50"/></td>
		  <? } ?>
		  </tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   value="ยกเลิก" onClick="window.location='menu.php';"/>			</td>
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
		
		$tel = "select * from menu where menu_cat_id='".$_SESSION["str_menu_cat_id"]."'";
					   
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
					$_GET['stack'] = "menu_rank"; 
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>	
  	<thead>
		<tr>
			<td width="13%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=menu_id&type_stack=ASC" style="text-decoration:none; color:#000000;">ลำดับ</a>
				<? }else { ?>
   					<a href="?stack=menu_id&type_stack=DESC" style="text-decoration:none; color:#000000;">ลำดับ</a>
				<? } ?>			</td>
			<td width="25%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=menu_name_th&type_stack=ASC" style="text-decoration:none; color:#000000;">ชื่อเมนู</a>
				<? }else { ?>
   					<a href="?stack=menu_name_th&type_stack=DESC" style="text-decoration:none; color:#000000;">ชื่อเมนู</a>
				<? } ?>			</td>
			<td width="37%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=menu_day&type_stack=ASC" style="text-decoration:none; color:#000000;">วันที่สร้างและแก้ไข</a>
				<? }else { ?>
   					<a href="?stack=menu_day&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">วันที่สร้างและแก้ไข</a><a href="?stack=edit_date&type_stack=DESC" style="text-decoration:none; color:#000000;"></a>
				<? } ?>			</td>
			<td width="12%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=menu_day&type_stack=ASC" style="text-decoration:none; color:#000000;">แสดง</a>
				<? }else { ?>
   					<a href="?stack=menu_day&type_stack=DESC" style="text-decoration:none; color:#000000;">แสดง</a>
				<? } ?>			</td>
			<td width="5%">แก้ไข</td>
			</tr>
	</thead>
	<tbody>
	
	<?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
  	<tr id="tr<?=$i?>" onMouseOver='mOvr(this,"#E6E6E6");' onMouseOut='mOut(this,"#ffffff");'>
		<td><?=$rs['menu_rank']?></td>
		<td><img src="images/ln_1.png" width="14"/><?=$rs['menu_name_th']?><br/> 
        <? if($rs['menu_name_en']!=""){ echo "<img src='images/ln_2.png' width='14'/>"; echo $rs['menu_name_en']; }?>
               </td>
		<td>
			<?=dateform($rs['menu_day'])?> <br/></td>
		<td><? if($rs['menu_name_th']!=""){?><img src="images/ln_1.png" width="14"/><? } ?> 
			<? if($rs['menu_name_en']!=""){?><img src="images/ln_2.png" width="14"/><? } ?> 
			<? if($rs['menu_name_ch']!=""){?><img src="images/ln_3.png" width="14"/><? } ?>
         
          <td><a href="?fix=true&menu_id=<?=$rs['menu_id'];?>"><img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/></a></td> <? }?> 
	</tbody>
    
  	</table>
	
	<hr/>
	
	<table width="100%">
		<tr>
			<td width="30%"><!--<input type="submit" name="Submit2" value="ลบรายการที่เลือก" /> --></td>
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
