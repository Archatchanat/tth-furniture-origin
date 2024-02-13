<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 
	if($_GET['all']=="true"){
		$_SESSION["str_customers_search"] = "";
		$_SESSION["str_select"] = "";
	}
	
	if($_GET['customers_search']!=""){
		$_SESSION["str_customers_search"] = $_GET['customers_search'];
		$_SESSION["str_select"] = $_GET['select'];
	}
?>

<?
	// start insert ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="insert")
	{
		$_POST['customers_email'] = trim($_POST['customers_email']);
		
		// check email duplicate ------------------------------------------------------------------------------------------------
		$tel_check 	= "select * from customers where customers_email = '".$_POST['customers_email']."'";
		$get_check  = mysql_query($tel_check);
		$num_check  = mysql_num_rows($get_check);
		
		if($num_check>0){
			echo "<script language=\"JavaScript\">";
			echo "window.location='customers.php?say=duplicate';";
			echo "</script>";
			exit();
		}
		// check email duplicate ------------------------------------------------------------------------------------------------
		
		
		// start resize picture		
		$tellway  = "INSERT INTO customers VALUES(";
		$tellway .= "0
					,'$_POST[customers_email]'
					,'$_POST[customers_num]'
					,'$_POST[customers_com]'
					,'$_POST[customers_web]'
					,'$_POST[customers_tel]'
					,'$_POST[customers_fax]'
					,'$_POST[customers_address]'
					,'".$_SESSION["str_admin_email"]."'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,NOW()
					,'$_POST[customers_publish]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		$customers_id=mysql_insert_id();
		$j1=0;
		while($j1<=$_POST['hdnMaxLine2']){
			$j1++;
			if($_POST["customers_detail_name"][$j1]!=""){
				$tellway  = "INSERT INTO customers_detail VALUES('0','".$_POST["customers_detail_name"][$j1]."','$customers_id')";
		$dbquery = mysql_query($tellway);
				
			}		
			}
		
		echo "<script language=\"JavaScript\">";
		echo "window.location='customers.php';";
		echo "</script>";
    }
	// end__ insert ----------------------------------------------------------------------------------------------------------------------
	
	// start update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="save")
	{	
		
		$sql_up = "update customers set
					 customers_email    = '$_POST[customers_email]'
					,customers_num     = '$_POST[customers_num]'
					,customers_tel     = '$_POST[customers_tel]'
					,customers_com     = '$_POST[customers_com]'
					,customers_web     = '$_POST[customers_web]'
					,customers_fax     = '$_POST[customers_fax]'
					,customers_address     = '$_POST[customers_address]'
					,customers_updater  = '".$_SESSION["str_admin_email"]."'
					,customers_update   = NOW()
					,customers_publish  = '$_POST[customers_publish]'
					where customers_id  = '".$_POST['customers_id']."'";
		$dbquery = mysql_query($sql_up);
		
		$j1=0;
		while($j1<=$_POST['hdnMaxLine2']){
			$j1++;
			if($_POST["customers_detail_name"][$j1]!="" and $_POST["customers_detail_id"][$j1]!=""){
				$sql_up = "update customers_detail set 
				customers_detail_name = '".$_POST["customers_detail_name"][$j1]."'
				where customers_detail_id  = '".$_POST['customers_detail_id'][$j1]."'";
				$dbquery = mysql_query($sql_up);
			}
			
			if($_POST["customers_detail_name"][$j1]!="" and $_POST["customers_detail_id"][$j1]==""){
				$tellway  = "INSERT INTO customers_detail VALUES('0','".$_POST["customers_detail_name"][$j1]."','$_POST[customers_id]')";
		$dbquery = mysql_query($tellway);
			
			}
			}		
		echo "<script language='JavaScript'>";
		echo "window.location='customers.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	
	// start delete ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="del1")
	{
		
		$sql_del2= "delete from customers_detail where customers_detail_id ='".$_GET["customers_detail_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		echo "<script language='JavaScript'>";
		echo "window.location=\"customers.php?fix=true&customers_id=$_GET[customers_id]\";";
		echo "</script>";
		}
	
	if($_GET["action"]=="del")
	{
		
		$sql_del= "delete from customers where customers_id='".$_GET["customers_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		$sql_del2= "delete from customers_detail where customers_id ='".$_GET["customers_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		
		echo "<script language='JavaScript'>";
		echo "window.location='customers.php';";
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
				$folder1  = "../picture/picture_customers_thumb";
				$destroy = delete_one_image($folder1,$_POST['thumb'][$j]);
				
				$folder2  = "../picture/picture_customers_image";
				$destroy = delete_one_image($folder2,$_POST['image'][$j]);
				// end__ process delete old picture
				
				$sql_del= "delete from customers where customers_id='".$_POST["delete_id"][$j]."'";
				$dbquery_del = mysql_query($sql_del);
			}		
		}
		
		echo "<script language='JavaScript'>";
		echo "window.location='customers.php';";
		echo "</script>";
	}
	// end__ delete ----------------------------------------------------------------------------------------------------------------------
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>customers</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="partner.js"></script>
 <script src="js/jquery-1.8.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/dd.css" />
<script src="js/jquery.dd.min.js"></script>


<script language="JavaScript">
	function checkvalue(action){
		filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		
		if(form1.customers_email.value == ""){
			alert("กรุณากรอก อีเมลล์");
			form1.customers_email.focus();
			return false
		}
		if (!(filter.test(form1.customers_email.value))) {
			alert("กรุณากรอก รูปแบบอีเมลล์ให้ถูกต้อง");
			form1.customers_email.value = ""
			form1.customers_email.focus();
			return false;
		}
		if(form1.customers_name.value == ""){
			alert("กรุณากรอก ชื่อ");
			form1.customers_name.focus();
			return false
		}
		if(form1.customers_tel.value == ""){
			alert("กรุณากรอก เบอร์โทรศัพท์");
			form1.customers_tel.focus();
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
		if(form2.customers_gp_id.value == "") {
			alert("กรูณาเลือก กลุ่ม");
			form2.customers_gp_id.focus();
			return false
		}
		return true;
	}
</script>
</head>

<body  Onload="<? if ($_GET[action]=="add"){ echo'CreateNewRow2()';}?>">
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
		
			
			<form method="get" action="customers.php" name="form2" onSubmit="return checkvalue2()">
			<table width="100%">
				<tr>
					
					<td width="43%">
						ชื่อลูกค้า : 
					  <input name="button" type="button" value="+ เพิ่มข้อมูล" onclick="window.location='customers.php?action=add';"/>
			  	  </td>
				

				  <td width="36%" align="right">ค้นหา
				    <input name="customers_search" type="text" id="customers_search" value="<?=$_SESSION["str_customers_search"]?>" />
				    จาก
				      <select name="select" id="select" >
                       <option value="customers_name"  <?php if (!(strcmp("customers_name", "$_SESSION[str_select]"))) {echo "selected=\"selected\"";} ?>>ชื่อ</option>
                       <option value="customers_com"  <?php if (!(strcmp("customers_com", "$_SESSION[str_select]"))) {echo "selected=\"selected\"";} ?>>บริษัท</option>
		          </select></td>
			  <td width="10%">
			  <input type="submit" name="Submit3" value="ตกลง" /> 
				  </td>
			  <td width="11%">
						| 
			  <input type="button" name="Submit"   value="ทั้งหมด" onClick="window.location='customers.php?all=true';"/>
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
    			<td width="19%" align="right" valign="top">ชื่อ ::</td>
   			  <td width="81%" align="left"> <script language="javascript">
function CreateNewRow2()
	{
		var x =parseFloat(form1.hdnMaxLine2.value);
var y =1;
var sum;
sum=x+y; 
	$("#hdnMaxLine2").val(sum);	
		var intLine = parseInt(document.form1.hdnMaxLine2.value);
		intLine++;
			
		var theTable = document.getElementById("tbExp2");
		var newRow = theTable.insertRow(theTable.rows.length)
		newRow.id = newRow.uniqueID

		var newCell
		
		//*** Column 1 ***//
		newCell = newRow.insertCell(0);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<td width=\"10\"><input name=\"customers_detail_name["+intLine+"]\" type=\"text\" id=\"customers_detail_name["+intLine+"]\" size=\"40\" />&nbsp;</td>";
			
	}
	function RemoveRow2()
	{
		var x =parseFloat(form1.hdnMaxLine2.value);
var y =1;
var sum;
sum=x-y; 
           
			
		intLine = sum;
		if(parseInt(intLine) >= 0)
		{
			$("#hdnMaxLine2").val(sum);	
				theTable = document.getElementById("tbExp2");				
				theTableBody = theTable.tBodies[0];
				theTableBody.deleteRow(intLine);
				intLine--;
				document.frmMain.hdnMaxLine2.value = intLine;
		}	
	}
</script><div style="float:left;"><table  width="100%" border="0" cellspacing="0" id="tbExp2">
	            </table></div>
 <div style="float:left;"><input name="btnAdd2" type="button" id="btnAdd2" value="+" onclick="CreateNewRow2();" />
                  <input name="btnDel2" type="button" id="btnDel2" value="-" onclick="RemoveRow2();" />
              <input type="hidden" id="hdnMaxLine2" name="hdnMaxLine2" value="0" /></div>   </td>
  			</tr>
			<tr>
			  <td align="right">บริษัท ::</td>
			  <td align="left"><input name="customers_com" type="text" id="customers_com" value="" size="40"/></td>
		  </tr>
			<tr>
			  <td align="right">เลขผู้เสียภาษ::</td>
			  <td align="left"><input type="text" name="customers_num" id="customers_num" /></td>
		  </tr>
			<tr>
			  <td align="right">เว็บไซต์ ::</td>
			  <td align="left"><input name="customers_web" type="text" id="customers_web" value="" size="40"/></td>
		  </tr>
			<tr>
    			<td align="right"> โทรศัพท์::</td>
    			<td align="left"><input name="customers_tel" type="text" id="customers_tel" value="" size="40"/></td>
  			</tr>
			<tr>
              <td align="right">แฟกซ์ ::</td>
			  <td align="left"><input name="customers_fax" type="text" id="customers_fax" value="" size="40"/></td>
		  </tr>
			<tr>
              <td align="right">อีเมล์ ::</td>
			  <td align="left"><input name="customers_email" type="text" id="customers_email" value="" size="40"/></td>
		  </tr>
			<tr>
              <td align="right">ที่อยู่ ::</td>
			  <td align="left"><textarea name="customers_address" cols="40" rows="10" id="customers_address"></textarea></td>
		  </tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td align="right">สถานะ ::</td>
				<td>
					<input type="radio" name="customers_publish" value="Yes" checked="checked">อนุญาต
					&nbsp;
					<input type="radio" name="customers_publish" value="No" >ไม่อนุญาต				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="Submit" value="ยืนยันข้อมูล" >
					<input type="button" name="Submit" value="ยกเลิก" onClick="window.location='customers.php';"/></td>
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
						from    customers
						where 
						   	   customers.customers_id = '".$_GET['customers_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
					
				$customers_id	   	= $rs_one['customers_id'];
				$customers_email    = $rs_one['customers_email'];
				$customers_num    = $rs_one['customers_num'];
				$customers_name     = $rs_one['customers_name'];
				$customers_com     = $rs_one['customers_com'];
				$customers_tel     	= $rs_one['customers_tel'];
				$customers_web     	= $rs_one['customers_web'];
				$customers_fax     	= $rs_one['customers_fax'];
				$customers_address     	= $rs_one['customers_address'];
				$customers_poster   = $rs_one['customers_poster'];
				$customers_updater  = $rs_one['customers_updater'];
				$customers_date     = $rs_one['customers_date'];
				$customers_update   = $rs_one['customers_update'];
				$customers_publish  = $rs_one['customers_publish'];
				
			}
	?>	
	<form name="form1" action="?action=save" method="post" onSubmit="return checkvalue('fix')" enctype="multipart/form-data">
	<div class="text_detail">
		รายละเอียด : สร้างวันที่ : <?=dateform($customers_date)?> [ <?=$customers_poster?> ] , แก้ไขล่าสุดวันที่ <?=dateform($customers_update)?> , [ <?=$customers_updater?> ]
	</div>
	<table id="myTable" bgcolor="#E6E6E6" width="100%">
		<tr>
			<td width="19%"></td>
			<td width="81%">
				<input type="hidden" name="customers_id" 		value="<?=$customers_id?>">
				<input type="submit" name="Submit"   		value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   		value="ยกเลิก" onClick="window.location='customers.php';"/>			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  		
  			<tr>
    			<td width="19%" align="right" valign="top">ชื่อ ::</td>
   			  <td width="81%" align="left"> <script language="javascript">
function CreateNewRow2()
	{
		var x =parseFloat(form1.hdnMaxLine2.value);
var y =1;
var sum;
sum=x+y; 
	$("#hdnMaxLine2").val(sum);	
		var intLine = parseInt(document.form1.hdnMaxLine2.value);
		intLine++;
			
		var theTable = document.getElementById("tbExp2");
		var newRow = theTable.insertRow(theTable.rows.length)
		newRow.id = newRow.uniqueID

		var newCell
		
		//*** Column 1 ***//
		newCell = newRow.insertCell(0);
		newCell.id = newCell.uniqueID;
		newCell.setAttribute("className", "css-name");
		newCell.innerHTML = "<td width=\"10\"><input name=\"customers_detail_name["+intLine+"]\" type=\"text\" id=\"customers_detail_name["+intLine+"]\" size=\"40\" />&nbsp;</td>";
			
	}
	function RemoveRow2()
	{
		var x =parseFloat(form1.hdnMaxLine2.value);
var y =1;
var sum;
sum=x-y; 
           
			
		intLine = sum;
		if(parseInt(intLine) >= 0)
		{
			$("#hdnMaxLine2").val(sum);	
				theTable = document.getElementById("tbExp2");				
				theTableBody = theTable.tBodies[0];
				theTableBody.deleteRow(intLine);
				intLine--;
				document.frmMain.hdnMaxLine2.value = intLine;
		}	
	}
</script><div style="float:left;">
<?
$tel_one = "select * from   customers_detail where   customers_id = '$customers_id' order by customers_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			$rank_rows = mysql_num_rows($get_one);
			while($rs_one = mysql_fetch_array($get_one))
			{  $i++;
$customers_detail_id["$i"]=$rs_one[customers_detail_id];
$customers_detail_name["$i"]=$rs_one[customers_detail_name];
?><div style=" height:30px;"><input name="customers_detail_name[<?=$i?>]" type="text" id="customers_detail_name[<?=$i?>]" value="<?=$customers_detail_name["$i"]?>" size="40" />
 <input type="hidden" name="customers_detail_id[<?=$i?>]" id="customers_detail_id[<?=$i?>]" value="<?=$customers_detail_id["$i"]?>" />
 <a href="?action=del1&amp;customers_detail_id=<?=$customers_detail_id["$i"];?>&customers_id=<?=$customers_id?>"onclick="return Conf(<?=$customers_detail_id["$i"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0" /></a></div>
 <? } ?>
<table  width="100%" border="0" cellspacing="0" id="tbExp2">
	            </table></div>
 <div style="float:left;"><input name="btnAdd2" type="button" id="btnAdd2" value="+" onclick="CreateNewRow2();" />
                  <input name="btnDel2" type="button" id="btnDel2" value="-" onclick="RemoveRow2();" />
              <input type="hidden" id="hdnMaxLine2" name="hdnMaxLine2" value="<?=$i?>" /></div>   </td>
  			</tr>
  			<tr>
              <td align="right">บริษัท ::</td>
  			  <td align="left"><input name="customers_com" type="text" id="customers_com" value="<?=$customers_com?>" size="40"/></td>
		  </tr>
  			<tr>
  			  <td align="right">เลขผู้เสียภาษ::</td>
  			  <td align="left"><input name="customers_num" type="text" id="customers_num" value="<?=$customers_num?>" /></td>
		  </tr>
  			<tr>
              <td align="right">เว็บไซต์ ::</td>
  			  <td align="left"><input name="customers_web" type="text" id="customers_web" value="<?=$customers_web?>" size="40"/></td>
		  </tr>
		<tr>
			<td align="right"> โทรศัพท์ ::</td>
			  <td align="left"><input name="customers_tel" type="text" id="customers_tel" value="<?=$customers_tel?>" size="40"/></td>
		  </tr>
			<tr>
              <td align="right">แฟกซ์ ::</td>
			  <td align="left"><input name="customers_fax" type="text" id="customers_fax" value="<?=$customers_fax?>" size="40"/></td>
		</tr>
        <tr>
    			<td align="right">อีเมลล์ ::</td>
    			<td align="left"><input name="customers_email" type="text" id="customers_email" value="<?=$customers_email?>" size="40"/></td>
  			</tr>
        <tr>
          <td align="right">ที่อยู่ ::</td>
          <td align="left"><textarea name="customers_address" cols="40" rows="10" id="customers_address"><?=$customers_address?></textarea></td>
        </tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="right">สถานะ ::</td>
			<td>
				<input type="radio" name="customers_publish" value="Yes" <? if($customers_publish=="Yes"){?>checked="checked"<? } ?>>อนุญาต
				&nbsp;
				<input type="radio" name="customers_publish" value="No" <? if($customers_publish=="No"){?>checked="checked"<? } ?>>ไม่อนุญาต			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   value="ยกเลิก" onClick="window.location='customers.php';"/>			</td>
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
		$str_select=$_SESSION["str_select"];
		if( $_SESSION["str_customers_search"] ==""){
			$tel = "select * 
					from    customers
					 ";
		} else {
			$tel = "select * 
					from    customers
					where  
						   $str_select like '%".$_SESSION["str_customers_search"]."%'";
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
					if( $_SESSION["str_customers_gp_id"] == ""){
						$_GET['type_stack'] = "DESC";
					} else {
						$_GET['type_stack'] = "DESC";
					}
				}
			
				if($_GET['stack']=="")
				{ 
					if( $_SESSION["str_customers_gp_id"] ==""){
						$_GET['stack'] = "customers_id";
					} else {
						$_GET['stack'] = "customers_rank";
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
   					<a href="?stack=customers_rank&type_stack=ASC" style="text-decoration:none; color:#000000;">ลำดับ</a>
				<? }else { ?>
   					<a href="?stack=customers_rank&type_stack=DESC" style="text-decoration:none; color:#000000;">ลำดับ</a>
				<? } ?>                </td>

			<td width="36%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=customers_name&type_stack=ASC" style="text-decoration:none; color:#000000;">ชื่อ-นามสกุล</a>
				<? }else { ?>
   					<a href="?stack=customers_name&type_stack=DESC" style="text-decoration:none; color:#000000;">ชื่อ-นามสกุล</a>
				<? } ?>			</td>
			<td width="18%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=customers_date&type_stack=ASC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
				<? }else { ?>
   					<a href="?stack=customers_date&type_stack=DESC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
				<? } ?>			</td>
			<td width="12%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=customers_publish&type_stack=ASC" style="text-decoration:none; color:#000000;">สถานะ</a>
				<? }else { ?>
   					<a href="?stack=customers_publish&type_stack=DESC" style="text-decoration:none; color:#000000;">สถานะ</a>
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
		<td><input type=checkbox id="check<?=$i?>" name="delete_id[<?=$i?>]" value="<?=$rs['customers_id']?>" onClick="if(this.checked==true){ selectRow('tr<?=$i?>'); }else{ deselectRow('tr<?=$i?>'); }">
		
			<input type="hidden" id="thumb<?=$i?>" name="thumb[<?=$i?>]" value="<?=$rs['customers_thumb']?>" >
			<input type="hidden" id="image<?=$i?>" name="image[<?=$i?>]" value="<?=$rs['customers_image']?>" >		</td>
		
    	<td>
			<?=$rs['customers_id']?>		</td>
		
		<td><a href="project.php?search=<?=$rs['customers_id']?>"><?=$rs['customers_com']?></a><br/>
		<br/></td>
		<td>
			<?=dateform($rs['customers_date'])?> 
			<br/>
			<font class="text_small_gray">By <?=$rs['customers_poster']?></font>		</td>
		<td>
			<?=$rs['customers_publish'];?>		</td>
    	<td>
			<a href="?fix=true&customers_id=<?=$rs["customers_id"];?>">
				<img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/>			</a>		</td>
		<td>
			<a href="?action=del&customers_id=<?=$rs["customers_id"];?>&thumb=<?=$rs['customers_thumb']?>&image=<?=$rs['customers_image']?>"onClick="return Conf(<?=$rs["customers_rank"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0"></a>		</td>
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
