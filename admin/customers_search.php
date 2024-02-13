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
					,'$_POST[customers_name]'
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
		/*if ($_POST[customers_billing_id]!="") {
		$tellway  = "INSERT INTO customers_billing VALUES(";
		$tellway .= "0
					,'$_POST[customers_billing_id]'
					,'$customers_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		}
		if ($_POST[customers_billing2_id]!="") {
		$tellway  = "INSERT INTO customers_billing2 VALUES(";
		$tellway .= "0
					,'$_POST[customers_billing2_id]'
					,'$customers_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		}*/
		if ($_POST[customers_orderid_id]!="") {
		$tellway  = "INSERT INTO customers_orderid VALUES(";
		$tellway .= "0
					,'$_POST[customers_orderid_id]'
					,'$customers_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
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
					,customers_name     = '$_POST[customers_name]'
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
		
		/*if ($_POST[customers_billing_id]=="" and $_POST[customers_billing_date] !="") {
		$tellway  = "INSERT INTO customers_billing VALUES(";
		$tellway .= "0
					,'$_POST[customers_billing_date]'
					,'$customers_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		}
		if ($_POST[customers_billing_id]!="" and $_POST[customers_billing_date] !="Yes") {
		$sql_up = "update customers_billing set
					 customers_billing_date    = '$_POST[customers_billing_date]'
					where customers_billing_id  = '".$_POST['customers_billing_id']."'";
		$dbquery = mysql_query($sql_up);
		}else if($_POST[customers_billing_id]!="" and $_POST[customers_billing_date] =="Yes"){
		$sql_del= "delete from customers_billing where customers_billing_id='".$_POST["customers_billing_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		}
		if ($_POST[customers_billing2_id]=="" and $_POST[customers_billing2_date] !="") {
		$tellway  = "INSERT INTO customers_billing2 VALUES(";
		$tellway .= "0
					,'$_POST[customers_billing2_date]'
					,'$customers_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		}
		if ($_POST[customers_billing2_id]!="" and $_POST[customers_billing2_date] !="Yes") {
		$sql_up = "update customers_billing2 set
					 customers_billing2_date    = '$_POST[customers_billing2_date]'
					where customers_billing2_id  = '".$_POST['customers_billing2_id']."'";
		$dbquery = mysql_query($sql_up);
		}else if($_POST[customers_billing2_id]!="" and $_POST[customers_billing2_date] =="Yes"){
		$sql_del= "delete from customers_billing2 where customers_billing2_id='".$_POST["customers_billing2_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		}*/
		if ($_POST[customers_orderid_id]=="" and $_POST[customers_orderid_date] !="") {
		$tellway  = "INSERT INTO customers_orderid VALUES(";
		$tellway .= "0
					,'$_POST[customers_orderid_date]'
					,'$customers_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		}
		if ($_POST[customers_orderid_id]!="" and $_POST[customers_orderid_date] !="Yes") {
		$sql_up = "update customers_orderid set
					 customers_orderid_date    = '$_POST[customers_orderid_date]'
					where customers_orderid_id  = '".$_POST['customers_orderid_id']."'";
		$dbquery = mysql_query($sql_up);
		}else if($_POST[customers_orderid_id]!="" and $_POST[customers_orderid_date] =="Yes"){
		$sql_del= "delete from customers_orderid where customers_orderid_id='".$_POST["customers_orderid_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		}
		echo "<script language='JavaScript'>";
		echo "window.location='customers.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	
	// start delete ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="del")
	{
		$folder  = "../picture/picture_customers_thumb";
		$destroy = delete_one_image($folder,$_GET['thumb']);
		
		$folder  = "../picture/picture_customers_image";
		$destroy = delete_one_image($folder,$_GET['image']);
		
		$sql_del= "delete from customers where customers_id='".$_GET["customers_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		
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
		
			
			<form method="get" action="#" name="form2" onSubmit="return checkvalue2()">
			<table width="100%">
				<tr>
					
					<td width="43%">
						ชื่อลูกค้า : 
					  <input name="button" type="button" value="กลับ" onclick="window.location='re_project.php';"/>
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
			  <input type="hidden" name="project_c_id" id="project_c_id" value="<?=$_GET['project_c_id']?>" />				  </td>
			  <td width="11%">
						| 
			  <input type="button" name="Submit"   value="ทั้งหมด" onClick="window.location='customers_search.php?all=true&project_c_id=<?=$_GET['project_c_id']?>';"/>
				  </td>
			  </tr>
			</table>
			</form>
			<hr/>
			
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : add data --><!--end__ : edit data-->	
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
					from    customers  LEFT JOIN customers_project ON (customers.customers_id=customers_project.customers_id) where project_c_id='$_GET[project_c_id]'
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
						$_GET['stack'] = "customers.customers_id";
					} else {
						$_GET['stack'] = "customers_rank";
					}
				}
			
			
				$tel .=" Group  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>	
  	<thead>
		<tr>
			<td width="6%"><input type=checkbox id="checkAll" onClick="selectAll(<?=$Num_Rows?>)"></td>
			
			
			<td width="14%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=customers_rank&type_stack=ASC" style="text-decoration:none; color:#000000;">ลำดับ</a>
				<? }else { ?>
   					<a href="?stack=customers_rank&type_stack=DESC" style="text-decoration:none; color:#000000;">ลำดับ</a>
				<? } ?>                </td>

			<td width="73%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=customers_name&type_stack=ASC" style="text-decoration:none; color:#000000;">ชื่อ-นามสกุล</a>
				<? }else { ?>
   					<a href="?stack=customers_name&type_stack=DESC" style="text-decoration:none; color:#000000;">ชื่อ-นามสกุล</a>
				<? } ?>			</td>
			<td width="7%">เลือก</td>
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
		
		<td><?=$rs['customers_com']?><br/>
			<?=$rs['customers_name']?>
			<br/></td>
		<td>
			<a href="project_search.php?project_c_id=<?=$_GET["project_c_id"];?>&search=<?=$rs["customers_id"];?>">
				<img src="images/view.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/>			</a>		</td>
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
					echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&stack=".$_GET['stack']."&type_stack=".$_GET['type_stack']."&project_c_id=".$_GET['project_c_id']."'><< Back</a> ";
				}

				for($i=1; $i<=$Num_Pages; $i++){
					if($i != $Page)
					{
						echo "<a href='$_SERVER[SCRIPT_NAME]?Page=$i&stack=".$_GET['stack']."&type_stack=".$_GET['type_stack']."&project_c_id=".$_GET['project_c_id']."'> $i </a>";
					}
					else
					{
						echo " <font size=4 color=green><b> $i </b></font> ";
					}
				}
	
				if($Page!=$Num_Pages)
				{
					echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&stack=".$_GET['stack']."&type_stack=".$_GET['type_stack']."&project_c_id=".$_GET['project_c_id']."'>Next>></a> ";
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
