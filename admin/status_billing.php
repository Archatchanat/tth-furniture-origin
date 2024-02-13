<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 
	
	
	if($_GET['id_s']!=""){
		$_SESSION["str_id_s"] = $_GET['id_s'];
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
		$tellway  = "INSERT INTO status_billing VALUES(";
		$tellway .= "0
					,'$_POST[status_b_name]'
					,'".$_SESSION["str_id_s"]."'
					,'$_POST[status_b_publish]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		
		echo "<script language=\"JavaScript\">";
		echo "window.location='status_billing.php';";
		echo "</script>";
    }
	// end__ insert ----------------------------------------------------------------------------------------------------------------------
	
	// start update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="save")
	{	
		
		$sql_up = "update status_billing set
					 status_b_name    = '$_POST[status_b_name]'
					 ,status_b_s  = '".$_SESSION["str_id_s"]."'
					 ,status_b_publish    = '$_POST[status_b_publish]'
					where status_b_id  = '".$_POST['status_b_id']."'";
		$dbquery = mysql_query($sql_up);
		
		echo "<script language='JavaScript'>";
		echo "window.location='status_billing.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	
	// start delete ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="del")
	{
		$tel_one = "select  * 	from    orderid
						where   orderid_publish = '".$_GET['status_b_id']."'";
			$get_one = mysql_query($tel_one);
		$num_check  = mysql_num_rows($get_one);	
		if($num_check>0){
		echo "<script language='JavaScript'>";
		echo"alert('สถานะนี้มีการใช้ในระบบไม่สามารถลบได้');";
		echo "window.location='status_billing.php';";
		echo "</script>";
		exit();
		}
		$tel_one = "select  * 	from    billing
						where    	billing_publish = '".$_GET['status_b_id']."'";
			$get_one = mysql_query($tel_one);
		$num_check  = mysql_num_rows($get_one);	
		if($num_check>0){
		echo "<script language='JavaScript'>";
		echo"alert('สถานะนี้มีการใช้ในระบบไม่สามารถลบได้');";
		echo "window.location='status_billing.php';";
		echo "</script>";
		exit();
		}
		$tel_one = "select  * 	from    billing2
						where    	billing2_publish = '".$_GET['status_b_id']."'";
			$get_one = mysql_query($tel_one);
		$num_check  = mysql_num_rows($get_one);	
		if($num_check>0){
		echo "<script language='JavaScript'>";
		echo"alert('สถานะนี้มีการใช้ในระบบไม่สามารถลบได้');";
		echo "window.location='status_billing.php';";
		echo "</script>";
		exit();
		}
		
		$sql_del= "delete from status_billing where status_b_id='".$_GET["status_b_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		
		echo "<script language='JavaScript'>";
		echo "window.location='status_billing.php';";
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
						สถานะ : <? if ($_SESSION["str_id_s"]=="1") { echo"สถานะออกใบเสนอราคา"; }else if ($_SESSION["str_id_s"]=="2"){echo"สถานะออกใบวางบิล";}else if ($_SESSION["str_id_s"]=="3") {echo"สถานะออกใบเสร็จรับเงิน";}?>
         
         
					  <input name="button" type="button" value="+ เพิ่มข้อมูล" onclick="window.location='status_billing.php?action=add';"/>
			  	  </td>
				

				  <td width="18%" align="right">
						
			    </td>
					<td width="4%">&nbsp;</td>
			  <td width="6%">&nbsp;</td>
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
    			<td width="15%" align="right">ชื่อสถานะ ::</td>
    			<td width="85%" align="left"><input name="status_b_name" type="text" id="status_b_name" value="" size="40"/></td>
  			</tr>
  			<tr>
              <td align="right">สถานะ ::</td>
  			  <td><input type="radio" name="status_b_publish" value="Yes" checked="checked" />
  			    อนุญาต
  			    &nbsp;
                        <input type="radio" name="status_b_publish" value="No" />
  			    ไม่อนุญาต </td>
		  </tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="Submit" value="ยืนยันข้อมูล" >
					<input type="button" name="Submit4" value="ยกเลิก" onclick="window.location='status_billing.php';"/></td>
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
						from    status_billing
						where 
						   	  status_b_id = '".$_GET['status_b_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
					
				$status_b_id	   	= $rs_one['status_b_id'];
				$status_b_name	   	= $rs_one['status_b_name'];
				$status_b_publish     = $rs_one['status_b_publish'];
			}
	?>	
	<form name="form1" action="?action=save" method="post" onSubmit="return checkvalue('fix')" enctype="multipart/form-data">
	<div class="text_detail">
	
	</div>
	<table id="myTable" bgcolor="#E6E6E6" width="100%">
		<tr>
			<td width="15%"></td>
			<td>
				<input type="hidden" name="status_b_id" 		value="<?=$status_b_id?>">
				<input type="submit" name="Submit"   		value="บันทึกข้อมูล" >
				<input type="button" name="Submit3" value="ยกเลิก" onclick="window.location='status_billing.php';"/></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  			<tr>
    			<td align="right">ชื่อสถานะ ::</td>
   			  <td align="left"><input name="status_b_name" type="text" id="status_b_name" value="<?=$status_b_name?>" size="40"/></td>
  			</tr>
  			<tr>
              <td align="right">สถานะ ::</td>
  			  <td><input type="radio" name="status_b_publish" value="Yes" <? if($status_b_publish=="Yes"){?>checked="checked"<? } ?> />
  			    อนุญาต
  			    &nbsp;
                    <input type="radio" name="status_b_publish" value="No" <? if($status_b_publish=="No"){?>checked="checked"<? } ?> />
  			    ไม่อนุญาต </td>
		  </tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit5" value="ยกเลิก" onclick="window.location='status_billing.php';"/></td>
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
					from    status_billing where status_b_s ='".$_SESSION["str_id_s"]."'
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
					
						$_GET['stack'] = "status_b_id";
					
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>	
  	<thead>
		<tr>
			<td width="7%">&nbsp;</td>
			<td width="82%">
            <? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
            <a href="?stack=status_b_name&type_stack=ASC" style="text-decoration:none; color:#000000;">ชื่อสถานะ</a>
				<? }else { ?>
   					<a href="?stack=status_b_name&type_stack=DESC" style="text-decoration:none; color:#000000;">ชื่อสถานะ</a>
				<? } ?>			</td>
			<td width="8%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=status_b_publish&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">สถานะ</a>
                <? }else { ?>
                <a href="?stack=status_b_publish&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">สถานะ</a>
                <? } ?>
            </td>
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
		<td>&nbsp;</td>
		
    	<td><?=$rs['status_b_name']?>			</td>
		<td><?=$rs['status_b_publish'];?>
        </td>
		<td>
			<a href="?fix=true&status_b_id=<?=$rs["status_b_id"];?>">
				<img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/>			</a>		</td>
		<td>
			<a href="?action=del&status_b_id=<?=$rs["status_b_id"];?>"onClick="return Conf(<?=$rs["status_b_id"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0"></a>		</td>
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
