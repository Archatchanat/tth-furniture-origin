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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?
	// start insert ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="insert")
	{
		
		// start resize picture		
		$tellway  = "INSERT INTO project_category VALUES(";
		$tellway .= "0
					,'$_POST[project_c_name]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		
		echo "<script language=\"JavaScript\">";
		echo "window.location='project_category.php';";
		echo "</script>";
    }
	// end__ insert ----------------------------------------------------------------------------------------------------------------------
	
	// start update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="save")
	{	
		
		$sql_up = "update project_category set
					 project_c_name    = '$_POST[project_c_name]'
					where project_c_id  = '".$_POST['project_c_id']."'";
		$dbquery = mysql_query($sql_up);
		
		echo "<script language='JavaScript'>";
		echo "window.location='project_category.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	
	// start delete ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="del")
	{
	
	
	$tel_one = "select  * 	from    customers_project
						where   project_c_id = '".$_GET['project_c_id']."'";
			$get_one = mysql_query($tel_one);
		$num_check  = mysql_num_rows($get_one);	
		if($num_check>0){
		echo "<script language='JavaScript'>";
		echo"alert('หมวดหมูู่โปรเจคนี้มีการใช้ในระบบไม่สามารถลบได้');";
		echo "window.location='project_category.php';";
		echo "</script>";
		exit();
		}
	
	
		$sql_del= "delete from project_category where project_c_id='".$_GET["project_c_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		
		echo "<script language='JavaScript'>";
		echo "window.location='project_category.php';";
		echo "</script>";
    }
	
	// delete_selected
	if($_GET["action"]=="del_sel")
	{
		$j=0;
		while($j<=$_POST['num_rows']){
			$j++;
			
			if($_POST["delete_id"][$j]!=""){
			
				$tel_one = "select  * 	from    customers_project
						where   project_c_id = '".$_POST["delete_id"][$j]."'";
			$get_one = mysql_query($tel_one);
		$num_check  = mysql_num_rows($get_one);	
		if($num_check>0){
		echo "<script language='JavaScript'>";
		echo"alert('หมวดหมูู่โปรเจค รหัส" .$_POST[delete_id][$j]. " นี้มีการใช้ในระบบไม่สามารถลบได้');";
		echo "window.location='project_category.php';";
		echo "</script>";
		}else{
				$sql_del= "delete from project_category where project_c_id='".$_POST["delete_id"][$j]."'";
				$dbquery_del = mysql_query($sql_del);
				
				}
			}		
		}
		
		echo "<script language='JavaScript'>";
		echo "window.location='project_category.php';";
		echo "</script>";
	}
	// end__ delete ----------------------------------------------------------------------------------------------------------------------
	
?>
<title>bid</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="partner.js"></script>

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
						หมวดหมูู่โปรเจค : 
					  <input name="button" type="button" value="+ เพิ่มข้อมูล" onclick="window.location='project_category.php?action=add';"/>
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
    			<td align="right">ชื่อ ::</td>
    			<td align="left"><input name="project_c_name" type="text" id="project_c_name" value="" size="40"/></td>
  			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="Submit" value="ยืนยันข้อมูล" >
					<input type="button" name="Submit" value="ยกเลิก" onClick="window.location='project_category.php';"/>				</td>
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
						from    project_category
						where 
						   	  project_c_id = '".$_GET['project_c_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
					
				$project_c_id	   	= $rs_one['project_c_id'];
				$project_c_name     = $rs_one['project_c_name'];
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
				<input type="hidden" name="project_c_id" 		value="<?=$project_c_id?>">
				<input type="submit" name="Submit"   		value="บันทึกข้อมูล" >
				<input type="button" name="Submit4" value="ยกเลิก" onclick="window.location='project_category.php';"/></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  			<tr>
    			<td align="right">ชื่อ ::</td>
    			<td align="left"><input name="project_c_name" type="text" id="project_c_name" value="<?=$project_c_name?>" size="40"/></td>
  			</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit5" value="ยกเลิก" onclick="window.location='project_category.php';"/></td>
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
					from    project_category
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
					
						$_GET['stack'] = "project_c_id";
					
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>	
  	<thead>
		<tr>
			<td width="7%"><input type=checkbox id="checkAll" onClick="selectAll(<?=$Num_Rows?>)"></td>
			
			
			<td width="82%">
            <? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
            <a href="?stack=project_c_name&type_stack=ASC" style="text-decoration:none; color:#000000;">ชื่อ</a>
				<? }else { ?>
   					<a href="?stack=project_c_name&type_stack=DESC" style="text-decoration:none; color:#000000;">ชื่อ</a>
				<? } ?>			</td>
			<td width="6%">แก้ไข</td>
			<td width="5%">ลบ</td>
		</tr>
	</thead>
	<tbody>
	
	<?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
  	<tr id="tr<?=$i?>" onMouseOver='mOvr(this,"#E6E6E6");' onMouseOut='mOut(this,"#ffffff");'>
		<td><input type=checkbox id="check<?=$i?>" name="delete_id[<?=$i?>]" value="<?=$rs['project_c_id']?>" onClick="if(this.checked==true){ selectRow('tr<?=$i?>'); }else{ deselectRow('tr<?=$i?>'); }"></td>
		
    	<td><?=$rs['project_c_name']?>
			</td>
		<td>
			<a href="?fix=true&project_c_id=<?=$rs["project_c_id"];?>">
				<img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/>			</a>		</td>
		<td>
			<a href="?action=del&project_c_id=<?=$rs["project_c_id"];?>"onClick="return Conf(<?=$rs["bid_rank"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0"></a>		</td>
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
