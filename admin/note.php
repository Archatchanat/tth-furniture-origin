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
		
		// start resize picture		
		$tellway  = "INSERT INTO note VALUES(";
		$tellway .= "0
					,'$_POST[note_name]'
					,'$_POST[note_detail]'
					,'$_POST[note_date1]'
					,'$_POST[note_today]'
					,'$_POST[note_endday]'
					,'".$_SESSION["str_admin_email"]."'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,NOW()
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		
		echo "<script language=\"JavaScript\">";
		echo "window.location='note.php';";
		echo "</script>";
    }
	// end__ insert ----------------------------------------------------------------------------------------------------------------------
	
	// start update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="save")
	{	
		
		$sql_up = "update note set
					 note_name    = '$_POST[note_name]'
					,note_detail    = '$_POST[note_detail]'
					,note_date1    = '$_POST[note_date1]'
					,note_today    = '$_POST[note_today]'
					,note_endday    = '$_POST[note_endday]'
					,note_updater  = '".$_SESSION["str_admin_email"]."'
					,note_update   = NOW()
					where note_id  = '".$_POST['note_id']."'";
		$dbquery = mysql_query($sql_up);
		
		echo "<script language='JavaScript'>";
		echo "window.location='note.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	
	// start delete ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="del")
	{
		$sql_del= "delete from note where note_id='".$_GET["note_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		
		echo "<script language='JavaScript'>";
		echo "window.location='note.php';";
		echo "</script>";
    }
	
	// delete_selected
	if($_GET["action"]=="del_sel")
	{
		$j=0;
		while($j<=$_POST['num_rows']){
			$j++;
			
			if($_POST["delete_id"][$j]!=""){
			
				
				$sql_del= "delete from note where note_id='".$_POST["delete_id"][$j]."'";
				$dbquery_del = mysql_query($sql_del);
			}		
		}
		
		echo "<script language='JavaScript'>";
		echo "window.location='note.php';";
		echo "</script>";
	}
	// end__ delete ----------------------------------------------------------------------------------------------------------------------
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>นัดพบลูกค้า</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="partner.js"></script>
 <script src="js/jquery-1.8.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/dd.css" />
<script src="js/jquery.dd.min.js"></script>

<script language="JavaScript">
	function checkvalue(action){
		if(form1.project_c_name.value == ""){
			alert("กรุณากรอก ชื่อ");
			form1.project_c_name.focus();
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
						นัดพบลูกค้า : 
					  <input name="button" type="button" value="+ เพิ่มข้อมูล" onclick="window.location='note.php?action=add';"/>
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
    			<td align="right">หัวเรื่อง ::</td>
   			  <td align="left"><input name="note_name" type="text" id="note_name" value="" size="40"/></td>
  			</tr>
  			<tr>
              <td align="right">รายละเอียด ::</td>
  			  <td align="left"><?php 
 			include("FCKeditor/fckeditor.php");
			$oFCKeditor = new FCKeditor('note_detail');
			$oFCKeditor->BasePath = 'FCKeditor/';
			$oFCKeditor->Width = '600' ;
			$oFCKeditor->Height = '300' ;
			$oFCKeditor->ToolbarSet = 'write2';
			/*$oFCKeditor->Value = $content_th;*/
			$oFCKeditor->Create(); 
		?></td>
		  </tr>
  			<tr>
  			  <td><div align="right">
  			    <div align="right">วันที่นัด :</div>
  			  </div></td>
  			  <td><input name="note_date1" type="text" id="note_date1" value="" size="40"/></td>
		  </tr>
  			<tr>
              <td><div align="right">วันที่เริ่มแจ้งเตือน :</div></td>
  			  <td><link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.7.2.custom.css" />
                  <style type="text/css">  
.ui-datepicker{  
    width:180px; 
    font-family:tahoma;  
    font-size:9px;  
    text-align:center; 
}  
              </style>
                <script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
                <script type="text/javascript">  
$(function(){  
    // แทรกโค้ต jquery  
   $("#dateInput").datepicker({ dateFormat: 'yy-mm-dd' });  
    $("#dateInput1").datepicker({ dateFormat: 'yy-mm-dd' }); 
	
$("#dateInput").datepicker({ dateFormat: 'yy-mm-dd',
     isBuddhist: true, 
     dayNames: ['อาทิตย์','จันทร์','อังคาร',
                        'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
     dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
     monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
                        'เมษายน','พฤษภาคม','มิถุนายน',
                        'กรกฎาคม','สิงหาคม','กันยายน',
                        'ตุลาคม','พฤศจิกายน','ธันวาคม'],
     monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
                         'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
                         'พ.ย.','ธ.ค.']
    }); 
});  

              </script>
                  <input name="note_today" class="textinputdotted" type="text" id="dateInput" value="" size="20"/> 
                  วันที่สิ้นสุดการแจ้งเตือน
                  <input name="note_endday" class="textinputdotted" type="text" id="dateInput1" value="" size="20"/></td>
		  </tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="Submit" value="ยืนยันข้อมูล" >
					<input type="button" name="Submit" value="ยกเลิก" onClick="window.location='note.php';"/>				</td>
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
						from    note
						where 
						   	  note_id = '".$_GET['note_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
					
				$note_id	   	= $rs_one['note_id'];
				$note_name     = $rs_one['note_name'];
				$note_detail     = $rs_one['note_detail'];
				$note_date1 = $rs_one['note_date1'];
				$note_today     = $rs_one['note_today'];
				$note_endday     = $rs_one['note_endday'];
				$note_detail     = $rs_one['note_detail'];
				$bid_poster     = $rs_one['note_poster'];
				$bid_updater     = $rs_one['note_updater'];
				$bid_date     = $rs_one['note_date'];
				$bid_update     = $rs_one['note_update'];
				
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
				<input type="hidden" name="note_id" 		value="<?=$note_id?>">
				<input type="submit" name="Submit"   		value="บันทึกข้อมูล" >
				<input type="button" name="Submit4" value="ยกเลิก" onclick="window.location='note.php';"/></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  			<tr>
    			<td align="right">หัวเรื่อง ::</td>
   			  <td align="left"><input name="note_name" type="text" id="note_name" value="<?=$note_name?>" size="40"/></td>
  			</tr>
  			<tr>
              <td align="right">รายละเอียด ::</td>
  			  <td align="left"><?php 
 			include("FCKeditor/fckeditor.php");
			$oFCKeditor = new FCKeditor('note_detail');
			$oFCKeditor->BasePath = 'FCKeditor/';
			$oFCKeditor->Width = '600' ;
			$oFCKeditor->Height = '300' ;
			$oFCKeditor->ToolbarSet = 'write2';
			$oFCKeditor->Value = $note_detail;
			$oFCKeditor->Create(); 
		?></td>
		  </tr>
  			<tr>
  			<td><div align="right">วันที่นัด :</div></td>
  			  <td><input name="note_date1" type="text" id="note_date1" value="<?=$note_date1?>" size="40"/></td>
		  </tr>
  			<tr>
              <td><div align="right">วันที่เริ่มแจ้งเตือน :</div></td>
  			  <td><link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.7.2.custom.css" />
                  <style type="text/css">  
.ui-datepicker{  
    width:180px; 
    font-family:tahoma;  
    font-size:9px;  
    text-align:center; 
}  
              </style>
                <script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
                <script type="text/javascript">  
$(function(){  
    // แทรกโค้ต jquery  
   $("#dateInput").datepicker({ dateFormat: 'yy-mm-dd' });  
    $("#dateInput1").datepicker({ dateFormat: 'yy-mm-dd' }); 
	
$("#dateInput").datepicker({ dateFormat: 'yy-mm-dd',
     isBuddhist: true, 
     dayNames: ['อาทิตย์','จันทร์','อังคาร',
                        'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
     dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
     monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
                        'เมษายน','พฤษภาคม','มิถุนายน',
                        'กรกฎาคม','สิงหาคม','กันยายน',
                        'ตุลาคม','พฤศจิกายน','ธันวาคม'],
     monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
                         'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
                         'พ.ย.','ธ.ค.']
    }); 
});  

              </script>
                  <input name="note_today" class="textinputdotted" type="text" id="dateInput" value="<?=$note_today?>" size="20"/> 
                  วันที่สิ้นสุดการแจ้งเตือน
                  <input name="note_endday" class="textinputdotted" type="text" id="dateInput1" value="<?=$note_endday?>" size="20"/></td>
  			</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit5" value="ยกเลิก" onclick="window.location='note.php';"/></td>
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
					from    note
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
					
						$_GET['stack'] = "note_id";
					
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>	
  	<thead>
		<tr>
			<td width="6%"><input type=checkbox id="checkAll" onClick="selectAll(<?=$Num_Rows?>)"></td>
			
			
			<td width="64%">
            <? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
            <a href="?stack=note_name&type_stack=ASC" style="text-decoration:none; color:#000000;">หัวเรื่อง</a>
				<? }else { ?>
   					<a href="?stack=note_name&type_stack=DESC" style="text-decoration:none; color:#000000;">หัวเรื่อง</a>
				<? } ?>			</td>
			<td width="19%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=note_date&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
                <? }else { ?>
                <a href="?stack=note_date&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
                <? } ?>            </td>
			<td width="5%">แก้ไข</td>
			<td width="6%">ลบ</td>
		</tr>
	</thead>
	<tbody>
	
	<?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
  	<tr id="tr<?=$i?>" onMouseOver='mOvr(this,"#E6E6E6");' onMouseOut='mOut(this,"#ffffff");'>
		<td><input type=checkbox id="check<?=$i?>" name="delete_id[<?=$i?>]" value="<?=$rs['note_id']?>" onClick="if(this.checked==true){ selectRow('tr<?=$i?>'); }else{ deselectRow('tr<?=$i?>'); }"></td>
		
    	<td><?=$rs['note_name']?>			</td>
		<td><?=dateform($rs['note_date'])?>
            <br/>
            <font class="text_small_gray">By
              <?=$rs['note_poster']?>
            </font> </td>
		<td>
			<a href="?fix=true&note_id=<?=$rs["note_id"];?>">
				<img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/>			</a>		</td>
		<td>
			<a href="?action=del&note_id=<?=$rs["note_id"];?>"onClick="return Conf(<?=$rs["note_id"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0"></a>		</td>
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
