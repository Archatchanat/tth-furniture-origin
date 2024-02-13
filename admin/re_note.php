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
						นัดพบลูกค้า :	  			  	  </td>
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
			  <input type="button" name="Submit4" value="ยกเลิก" onclick="window.close();"/></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  			<tr>
    			<td align="right">หัวเรื่อง ::</td>
   			  <td align="left"><?=$note_name?></td>
  			</tr>
  			<tr>
              <td align="right">รายละเอียด ::</td>
  			  <td align="left"><?=$note_detail?></td>
		  </tr>
  			<tr>
  			<td><div align="right">วันที่่นัด :</div></td>
  			  <td><?=$note_date1?></td>
		  </tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="button" name="Submit5" value="ยกเลิก" onclick="window.location='note.php';"/></td>
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
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	  </div>
	</div>
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<div class="down_bar"></div>
	<? include "include_down.php";?>
</div>
</body>

</html>
