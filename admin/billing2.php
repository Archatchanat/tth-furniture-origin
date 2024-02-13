<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 
if($_GET['all']=="true"){
		$_SESSION["str_search"] = "";
	}
	
	if($_GET['search']!=""){
		$_SESSION["str_search"] = $_GET['search'];
	}
	if($_GET['search']==""){
	$_SESSION["str_search"] = "";
	}
	if($_GET['customers_id']!=""){
	$_SESSION["str_customers_id"] = $_GET['customers_id'];
	$_SESSION["str_customers_p_id"] = $_GET['customers_p_id'];
	}
	// start insert ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="insert")
	{
		$_POST['admin_email'] = trim($_POST['admin_email']);
		
		// check email duplicate ------------------------------------------------------------------------------------------------
		$tel_check 	= "select * from billing2 where billing2_id = '".$_POST['billing2_id']."'";
		$get_check  = mysql_query($tel_check);
		$num_check  = mysql_num_rows($get_check);
		
		if($num_check>0){
		echo"<script language='JavaScript'>";
					echo"alert('ใบเสนอราคามีอยู่ในระบบแล้ว');";
					echo"</script>";
					echo "<script>history.back()</script>";
					exit();
		
		}
		// check email duplicate ------------------------------------------------------------------------------------------------
		$billing2_amount_th=num2string("$_POST[billing2_amount_sum]");
		
	
		$tellway  = "INSERT INTO billing2 VALUES(";
		$tellway .= "'$_POST[orderid_num]'
					,'$_POST[billing2_id]'
					,'$_POST[customers_p_id]'
					,'".$_SESSION["str_customers_id"]."'
					,'$_POST[billing2_attn]'
					,'$_POST[billing2_co]'
					,'$_POST[billing2_web]'
					,'$_POST[billing2_tel]'
					,'$_POST[billing2_fax]'
					,'$_POST[billing2_mail]'
					,'$_POST[billing2_taxpayer]'
					,'$_POST[billing2_date]'
					,'$_POST[billing2_address]'
					,'$_POST[billing2_date_to]'
					,'$_POST[billing2_date_end]'
					,'$_POST[bid_name]'
					,'$billing2_amount_th'
					,'$_POST[billing2_amount_en]'
					,'$_POST[billing2_amount_vat]'
					,'$_POST[billing2_amount_sum]'
					,'$_POST[billing2_approve]'
					,'".$_SESSION["str_admin_email"]."'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,NOW()
					,'$_POST[billing2_publish]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		$billing2_id=$_POST[billing2_id];
		
		$orderid_num= $_POST[billing2_id];
		$log_detail = 'INSERT ออกใบเสร็จรับเงิน  '.' '.$_POST[billing2_id];
		$log_date = 'billing2';
		$tellway  = "INSERT INTO log VALUES(";
				$tellway .= "'0'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,'".$orderid_num."'
					,'".$log_detail."'
					,'".$log_date."'
					,'".$_SERVER["REMOTE_ADDR"]."'
					";
				$tellway .= ")";
				$dbquery = mysql_query($tellway);
				
		 $j1=0;
		while($j1<=20){
			$j1++;
			if($_POST["description"][$j1]!=""){
				
				if ($_POST["detail_unit"][$j1]!=""){
					
					$detail_unit = "'".$_POST["detail_unit"][$j1]."'";
				}else{
					$detail_unit = 'NULL';
				}
				
				if ($_POST["total"][$j1]!=""){
					
					$total = "'".$_POST["total"][$j1]."'";
				}else{
					$total = 'NULL';
				}
				
				
				$tellway  = "INSERT INTO billing2_detail VALUES('0','".$_POST["no"][$j1]."','".$_POST["description"][$j1]."','".$_POST["qty"][$j1]."',$detail_unit,$total,'$billing2_id')";
		$dbquery = mysql_query($tellway);
				
			}		
			}
		if($_POST[billing2_cash]=="1") {
		$tellway  = "INSERT INTO billing2_cash VALUES(";
		$tellway .= "0
					,'$_POST[billing2_cash_amount]'
					,'$billing2_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		} if($_POST[billing2_check]=="1") {
		$tellway  = "INSERT INTO billing2_check VALUES(";
		$tellway .= "0
					,'$_POST[billing2_check_bank]'
					,'$_POST[billing2_check_branch]'
					,'$_POST[billing2_check_number]'
					,'$_POST[billing2_check_date]'
					,'$_POST[billing2_check_amount]'
					,'$billing2_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		
		
		}
		 if($_POST["billing2_comment_detail"]!=""){
				$tellway  = "INSERT INTO billing2_comment VALUES('0','".$_POST["billing2_comment_detail"]."','".$_SESSION["str_admin_email"]."',NOW(),'$billing2_id')";
		$dbquery = mysql_query($tellway);
				
}
		echo "<script language=\"javascript\">";
		echo "window.open('MPDF56/examples/re_billing2.php?billing2_id=$_POST[billing2_id]', 're_billing2')";
		echo "</script>";	
		echo "<script language=\"JavaScript\">";
		echo "window.location='billing2.php';";
		echo "</script>";
    }
	// end__ insert ----------------------------------------------------------------------------------------------------------------------
	
	// start update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="save")
	{	
		$billing2_amount_th=num2string("$_POST[billing2_amount_sum]");
		
		$sql_up = "update billing2 set
					 billing2_attn = '$_POST[billing2_attn]'
					,customers_p_id = '$_POST[customers_p_id]'
					,customers_id ='".$_SESSION["str_customers_id"]."'
					,billing2_co ='$_POST[billing2_co]'
					,billing2_web ='$_POST[billing2_web]'
					,billing2_tel ='$_POST[billing2_tel]'
					,billing2_fax ='$_POST[billing2_fax]'
					,billing2_mail ='$_POST[billing2_mail]'
					,billing2_taxpayer ='$_POST[billing2_taxpayer]'
					,billing2_date ='$_POST[billing2_date]'
					,billing2_address ='$_POST[billing2_address]'
					,billing2_date_to ='$_POST[billing2_date_to]'
					,billing2_date_end ='$_POST[billing2_date_end]'
					,billing2_from ='$_POST[bid_name]'
					,billing2_amount_th ='$billing2_amount_th'
					,billing2_amount_en ='$_POST[billing2_amount_en]'
					,billing2_amount_vat ='$_POST[billing2_amount_vat]'
					,billing2_amount_sum ='$_POST[billing2_amount_sum]'
					,billing2_approve ='$_POST[billing2_approve]'
					,billing2_updater ='".$_SESSION["str_admin_email"]."'
					,billing2_update =NOW()
					,billing2_publish ='$_POST[billing2_publish]'
					where billing2_id  = '".$_POST['billing2_id']."'";
		$dbquery = mysql_query($sql_up);
		
		$orderid_num= $_POST[billing2_id];
		$log_detail = 'update ออกใบเสร็จรับเงิน '.$_POST['billing2_id'];
		$log_date = 'billing2';
		$tellway  = "INSERT INTO log VALUES(";
				$tellway .= "'0'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,'".$orderid_num."'
					,'".$log_detail."'
					,'".$log_date."'
					,'".$_SERVER["REMOTE_ADDR"]."'
					";
				$tellway .= ")";
				$dbquery = mysql_query($tellway);
				
		$j1=0;
		while($j1<=20){
			$j1++;
			if($_POST["description"][$j1]!="" and $_POST["billing2_details_id"][$j1]!=""){
				if ($_POST["detail_unit"][$j1]!=""){
					$sql_up = "update billing2_detail set 
				billing2_detail_unit = '".$_POST["detail_unit"][$j1]."'				
				where billing2_detail_id  = '".$_POST['billing2_details_id'][$j1]."'";
				$dbquery = mysql_query($sql_up);
				}else{
					$sql_up = "update billing2_detail set 
				billing2_detail_unit = NULL				
				where billing2_detail_id  = '".$_POST['billing2_details_id'][$j1]."'";
				$dbquery = mysql_query($sql_up);
				}
				if ($_POST["total"][$j1]!=""){
					
				$sql_up = "update billing2_detail set 
				billing2_detail_total = '".$_POST["total"][$j1]."'
				where billing2_detail_id  = '".$_POST['billing2_details_id'][$j1]."'";
				$dbquery = mysql_query($sql_up);	
				}else{
				$sql_up = "update billing2_detail set 
				billing2_detail_total = NULL				
				where billing2_detail_id  = '".$_POST['billing2_details_id'][$j1]."'";
				$dbquery = mysql_query($sql_up);	
				}
				
				$sql_up = "update billing2_detail set 
				billing2_detail_no = '".$_POST["no"][$j1]."'
				,billing2_detail_description = '".$_POST["description"][$j1]."'
				,billing2_detail_qty = '".$_POST["qty"][$j1]."'
				,billing2_id	 = '".$_POST["billing2_id"]."'
				where billing2_detail_id  = '".$_POST['billing2_details_id'][$j1]."'";
				$dbquery = mysql_query($sql_up);
			}
			
			if($_POST["description"][$j1]!="" and $_POST["billing2_details_id"][$j1]==""){
				
				if ($_POST["detail_unit"][$j1]!=""){
					
					$detail_unit = "'".$_POST["detail_unit"][$j1]."'";
				}else{
					$detail_unit = 'NULL';
				}
				
				if ($_POST["total"][$j1]!=""){
					
					$total = "'".$_POST["total"][$j1]."'";
				}else{
					$total = 'NULL';
				}
				
				
				
				$tellway  = "INSERT INTO billing2_detail VALUES('0','".$_POST["no"][$j1]."','".$_POST["description"][$j1]."','".$_POST["qty"][$j1]."',$detail_unit,$total,'".$_POST["billing2_id"]."')";

		$dbquery = mysql_query($tellway);
			
			}		
			}
			
			
			if($_POST[billing2_cash]=="1") {
				$tel_check 	= "select * from  billing2_cash where  billing2_id = '".$_POST['billing2_id']."'";
		$get_check  = mysql_query($tel_check);
		$num_check  = mysql_num_rows($get_check);
		
		if($num_check>0){
		$sql_up = "update billing2_cash set
					 billing2_check_bank  = '$_POST[billing2_check_bank]'
					,billing2_check_branch  = '$_POST[billing2_check_branch]'
					,billing2_check_date  = '$_POST[billing2_check_date]'
					,billing2_cash_amount  = '$_POST[billing2_cash_amount]'
					where billing2_cash_id  = '".$_POST['billing2_cash_id']."'";
						$dbquery = mysql_query($sql_up);
		}else{
			
			$tellway  = "INSERT INTO billing2_check VALUES(";
		$tellway .= "0
					,'$_POST[billing2_check_bank]'
					,'$_POST[billing2_check_branch]'
					,'$_POST[billing2_check_number]'
					,'$_POST[billing2_check_date]'
					,'$_POST[billing2_check_amount]'
					,'$billing2_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		}
		} 
		
		
		if($_POST[billing2_check]=="1") {
		
		$tel_check 	= "select * from billing2_check where  billing2_id = '".$_POST['billing2_id']."'";
		$get_check  = mysql_query($tel_check);
		$num_check  = mysql_num_rows($get_check);
		
		if($num_check>0){
		$sql_up = "update billing2_check set
					 billing2_check_bank  = '$_POST[billing2_check_bank]'
					 ,billing2_check_branch  = '$_POST[billing2_check_branch]'
					 ,billing2_check_number  = '$_POST[billing2_check_number]'
					 ,billing2_check_date  = '$_POST[billing2_check_date]'
					 ,billing2_check_amount  = '$_POST[billing2_check_amount]'
					where billing2_check_id  = '".$_POST['billing2_check_id']."'";
						$dbquery = mysql_query($sql_up);
		}else{
		$tellway  = "INSERT INTO billing2_check VALUES(";
		$tellway .= "0
					,'$_POST[billing2_check_bank]'
					,'$_POST[billing2_check_branch]'
					,'$_POST[billing2_check_number]'
					,'$_POST[billing2_check_date]'
					,'$_POST[billing2_check_amount]'
					,'$billing2_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		
		}
		}
			
		if($_POST["billing2_comment_details"]!=""){
				$tellway  = "INSERT INTO billing2_comment VALUES('0','".$_POST["billing2_comment_details"]."','".$_SESSION["str_admin_email"]."',NOW(),'$billing2_id')";
		$dbquery = mysql_query($tellway);
			}
			
		$j=0;
		while($j<=$_POST['comment_num']){
			$j++;
			if($_POST["billing2_comment_publish"][$j]=="$_SESSION[str_admin_email]"){
			$sql_del= "update  billing2_comment  set billing2_comment_detail='".$_POST["billing2_comment_detail"][$j]."' where billing2_comment_id='".$_POST["billing2_comment_id"][$j]."'";
				$dbquery_del = mysql_query($sql_del);
			}
			}
		echo "<script language=\"javascript\">";
		echo "window.open('MPDF56/examples/re_billing2.php?billing2_id=$_POST[billing2_id]', 're_billing2')";
		echo "</script>";				
		echo "<script language='JavaScript'>";
		echo "window.location='billing2.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="del")
	{
		
		
		$sql_del= "delete from billing2 where billing2_id ='".$_GET["billing2_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		
		$sql_del2= "delete from billing2_detail where billing2_id ='".$_GET["billing2_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		
		
				
		echo "<script language='JavaScript'>";
		echo "window.location=\"billing2.php\";";
		echo "</script>";
		}
		if($_GET["action"]=="del1")
	{
		
		$sql_del2= "delete from billing2_detail where billing2_detail_id ='".$_GET["billing2_detail_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		$tel_check 	= "select billing2_detail_total from billing2_detail where billing2_id = '".$_GET['billing2_id']."'";
		$get_check  = mysql_query($tel_check);
		while($rs_one = mysql_fetch_array($get_check))
			{
			$billing_detail_total=+ $rs_one[billing2_detail_total];
			}
		
		$billing_amount_sum=number_format(($billing_detail_total*0.07)+$billing_detail_total, 0,'.','');
		$billing_amount_vat=number_format($billing_detail_total*0.07, 0,'.','');
		
		$billing_amount_th= num2string("$billing_amount_sum");	
		
		$sql_up = "update billing2 set
					 billing2_amount_th ='$billing_amount_th'
					,billing2_amount_en ='$billing_detail_total'
					,billing2_amount_vat ='$billing_amount_vat'
					,billing2_amount_sum ='$billing_amount_sum'
					,billing2_updater ='".$_SESSION["str_admin_email"]."'
					,billing2_update =NOW()
					where billing2_id  = '".$_GET['billing2_id']."'";
		$dbquery = mysql_query($sql_up);
		
		$orderid_num= $_GET['billing2_id'];
		$log_detail = 'delete รายละเอียด ออกใบเสร็จรับเงิน  '.' '.$_GET['billing2_id'];
		$log_date = 'billing2';
		$tellway  = "INSERT INTO log VALUES(";
				$tellway .= "'0'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,'".$orderid_num."'
					,'".$log_detail."'
					,'".$log_date."'
					,'".$_SERVER["REMOTE_ADDR"]."'
					";
				$tellway .= ")";
				$dbquery = mysql_query($tellway);
		
		echo "<script language='JavaScript'>";
		echo "window.location=\"billing2.php?fix=true&billing2_id=$_GET[billing2_id]\";";
		echo "</script>";
		}
		if($_GET["action"]=="del2")
	{
		
		$orderid_num= $_GET['billing2_id'];
		$log_detail = 'delete 	ชำระเงินสด ออกใบเสร็จรับเงิน  '.' '.$_GET['billing2_id'];
		$log_date = 'billing2_check';
		$tellway  = "INSERT INTO log VALUES(";
				$tellway .= "'0'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,'".$orderid_num."'
					,'".$log_detail."'
					,'".$log_date."'
					,'".$_SERVER["REMOTE_ADDR"]."'
					";
				$tellway .= ")";
				$dbquery = mysql_query($tellway);
				
		$sql_del2= "delete from billing2_cash where billing2_cash_id ='".$_GET["billing2_cash_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		echo "<script language='JavaScript'>";
		echo "window.location=\"billing2.php?fix=true&billing2_id=$_GET[billing2_id]\";";
		echo "</script>";
		
		
		}
		if($_GET["action"]=="del3")
	{
		
		$sql_del2= "delete from billing2_check where billing2_check_id ='".$_GET["billing2_check_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		
		$orderid_num= $_GET['billing2_id'];
		$log_detail = 'delete ชำระเงินสด ออกใบเสร็จรับเงิน  '.' '.$_GET['billing2_id'];
		$log_date = 'billing2';
		$tellway  = "INSERT INTO log VALUES(";
				$tellway .= "'0'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,'".$orderid_num."'
					,'".$log_detail."'
					,'".$log_date."'
					,'".$_SERVER["REMOTE_ADDR"]."'
					";
				$tellway .= ")";
				$dbquery = mysql_query($tellway);
		echo "<script language='JavaScript'>";
		echo "window.location=\"billing2.php?fix=true&billing2_id=$_GET[billing2_id]\";";
		echo "</script>";
		}
	if($_GET["action"]=="del4")
	{
		
		$sql_del2= "delete from billing2_comment where billing2_comment_id ='".$_GET["billing2_comment_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		$sql_del2= "delete from billing2_comment_re where billing2_comment_id ='".$_GET["billing2_comment_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		echo "<script language='JavaScript'>";
		echo "window.location=\"billing2.php?fix=true&billing2_id=$_GET[billing2_id]\";";
		echo "</script>";
		}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>billing2</title>
<?php  
		if(chkBrowser("MSIE")==1){ 
	 $style="style";
	if(chkBrowser("MSIE 8")==1){  
    $style="style";
    }elseif(chkBrowser("MSIE 7")==1){  
    $style="style";
    }elseif(chkBrowser("MSIE 6")==1){  
    $style="style";
    }else{  
     $style="style";
    }     
}elseif(chkBrowser("Firefox")==1){  
    $style="style_firefox";
}elseif(chkBrowser("Chrome")==1){  
    $style="style";
}elseif(chkBrowser("Chrome")==0 && chkBrowser("Safari")==1){  
    $style="style";
}elseif(chkBrowser("Opera")==1){  
    $style="style";
}elseif(chkBrowser("Netscape")==1){  
    $style="style";
}else{  
   $style="style";
} 
?>  
<link href="<?=$style?>.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="partner.js"></script>
 <script src="js/jquery-1.8.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/dd.css" />
<script src="js/jquery.dd.min.js"></script>

<script language="JavaScript">
	function checkvalue(action){
		filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		if(form1.billing2_id.value == "") {
			alert("กรุณากรอก เลขที่ใบวางบิล");
			form1.billing2_id.focus();
			return false
		}
		if(form1.billing2_attn.value == "") {
			alert("กรุณากรอก เรียน");
			form1.billing2_attn.focus();
			return false
		}
		if(form1.billing2_co.value == "") {
			alert("กรุณาเลือก บริษัท");
			form1.billing2_co.focus();
			return false
		}
		if(form1.billing2_tel.value == "") {
			alert("กรุณาเลือก โทรศัพท์");
			form1.billing2_tel.focus();
			return false
		}if(form1.billing2_mail.value == ""){
			alert("กรุณากรอก อีเมลล์");
			form1.billing2_mail.focus();
			return false
		}
		if (!(filter.test(form1.billing2_mail.value))) {
			alert("กรุณากรอก รูปแบบอีเมลล์ให้ถูกต้อง");
			form1.billing2_mail.value = ""
			form1.billing2_mail.focus();
			return false;
		}
		if(form1.billing2_date.value == ""){
			alert("กรุณากรอก วันที่ ");
			form1.billing2_date.focus();
			return false
		}
		
		if(form1.bid_name.value == ""){
			alert("กรุณาเลือก พนักงานขาย");
			form1.bid_name.focus();
			return false
		}
		
		
		if(form1.billing2_amount_en.value == ""){
			alert("กรุณากรอก ราคารวม");
			form1.billing2_amount_en.focus();
			return false
		}
		if(form1.billing2_amount_sum.value == ""){
			alert("กรุณากรอก รวมมูลค่าทั้งสิ้น");
			form1.billing2_amount_sum.focus();
			return false
		}
		
		if(form1.billing2_approve.value == ""){
			alert("กรุณาเลือก ผู้อนุมัติ");
			form1.billing2_approve.focus();
			return false
		}
		return true;
	}
	
	function Conf(text) {
		if (confirm("กรุณายืนยัน การลบ [ "+text+" ]") ==true) {
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

<body  Onload="<? if ($_GET[action]=="add"){ echo'CreateNewRow2()';}?>">
<div class="cloth">
	
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<? include "include_top.php";?>
	<div class="top_bar"></div>
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<div class="shirt">
		
		<div class="shirt_right">
		
			
			<form method="get" action="billing2.php" name="form2" onSubmit="return checkvalue2()">
			  <table width="100%">
                <tr>
                  <td width="34%"> ออกใบเสร็จรับเงิน :
                    <input name="button" type="button" value="+ เพิ่มข้อมูล" onclick="window.location='billing2_customers.php?action=add';"/></td>
                  <td width="47%" align="right">ค้นหา
                    <input name="search" type="text" id="search" value="<?=$_SESSION["str_search"]?>" />
                    เลือก
                    <select name="search1" id="search1">
                     
                      <option value="billing2_id" <?php if (!(strcmp($_GET[search1], "billing2_id"))) {echo "selected=\"selected\"";} ?>>ใบเสนอราคา</option>
                   	  <option value="billing2_co" <?php if (!(strcmp($_GET[search1], "billing2_co"))) {echo "selected=\"selected\"";} ?>>บริษัท</option>
                   	  <option value="billing2_attn" <?php if (!(strcmp($_GET[search1], "billing2_attn"))) {echo "selected=\"selected\"";} ?>>เรียน</option>
                    
                  </select></td>
                  <td width="9%"><input type="submit" name="Submit3" value="ตกลง" />
                  </td>
                  <td width="10%"> |
                    <input type="button" name="Submit2"   value="ทั้งหมด" onclick="window.location='billing2.php?all=true';"/>
                  </td>
                </tr>
              </table>
		  </form>
			<hr/>
			
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : add data -->
	<?
		if($_GET['action']=="add"){
			//Quo56-12
			// auto rank
			$tel_auto_rank = "select billing2_id from billing2 ORDER  BY billing2_num DESC LIMIT 0,1";
			$get_auto_rank = mysql_query($tel_auto_rank);
			$rs_one_rank = mysql_fetch_array($get_auto_rank);
			$rank_rows = mysql_fetch_array($get_auto_rank);
		 $billing2_idts= substr ($rs_one_rank[billing2_id],2,2);
		
		$billing2_idts1= date('y')+43;
		if($billing2_idts1>$billing2_idts){
		$billing2_id="Rc";
		$billing2_id.="$billing2_idts1";
		$billing2_id.="-1";
		}else{
		$billing2_idt = substr ($rs_one_rank[billing2_id],5,5);
		$billing2_id="Rc";
		$billing2_id.="$billing2_idts";
		$billing2_id.="-";
		$billing2_idt=$billing2_idt+1;
		$billing2_id.="$billing2_idt";
		}
			
		
	?>
	<form name="form1" action="?action=insert" method="post" onSubmit="return checkvalue('')" enctype="multipart/form-data">
	  <table width="100%">
			<tr>
				<td colspan="2"><table width="100%" bbilling2="0">
                  <tr>
                    <td><div align="right">เลขที่ใบเสร็จรับเงิน:</div></td>
                    <td> <input name="billing2_id" class="textinputdotted" type="text" id="billing2_id" size="40"  value="<?=$billing2_id?>"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="17%"> 
					<script type="text/javascript">
$(document).ready(function(){

	$("#billing2_attn1").change(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'sCusIDs=' +$("#billing2_attn1").val()
			})
			.success(function(result) { 

				var obj = jQuery.parseJSON(result);
				
					if(obj == '')
					{
						
						 $("#customers_com1").html('');
						 $("#billing2_co").val('');
						
					}
					else
					{
						  $.each(obj, function(key, inval) {

							  
							   $("#customers_com1").html(inval["customers_com"]);
							   $("#customers_email").html(inval["customers_email"]);
							   $("#customers_web").html(inval["customers_web"]);
							   $("#customers_tel").html(inval["customers_tel"]);
							   $("#customers_fax").html(inval["customers_fax"]);
								
							   $("#billing2_co").val(inval["customers_com"]);
							   $("#billing2_mail").val(inval["customers_email"]);
							   $("#customers_name").val(inval["customers_name"]);
							   $("#billing2_web").val(inval["customers_web"]);
							   $("#billing2_tel").val(inval["customers_tel"]);
							   $("#billing2_fax").val(inval["customers_fax"]);
							 
							 
				
						  });
					}

			});

		});
	});
	
</script><div align="right">เรียน :</div></td>
                    <td width="38%">    
                    
                    <? 
					$tel_one = "select  * 
						from      customers where customers_id='".$_SESSION["str_customers_id"]."'
						";
			$get_one = mysql_query($tel_one);
			$rs_one4 = mysql_fetch_array($get_one);
	
?>                      
 <select name="billing2_attn" style="width:200px" id="billing2_attn">
  <? $tel_one = "select  * 
						from    customers_detail  where   customers_id = '$rs_one4[customers_id]' order by customers_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option value="<?=$rs_one['customers_detail_name']?>">
  <?=$rs_one['customers_detail_name']?>
  </option>
  <? } ?>
</select>
<input type="hidden" name="customers_p_id"  id="customers_p_id" value="<?=$_GET['customers_p_id']?>" />                  </td>
                    <td width="16%"><div align="right">วันที่ :</div></td>
                    <td width="29%">
                    <link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.7.2.custom.css">  
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
   //$("#dateInput").datepicker({ dateFormat: 'yy-mm-dd' });  
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

<input name="billing2_date" class="textinputdotted" type="text" id="dateInput" value="" size="20"/></td>
                  </tr>
                  <tr>
                    <td ><div align="right">บริษัท :</div></td>
                    <td><input name="billing2_co" type="text" id="billing2_co" size="50"  value="<?=$rs_one4['customers_com']?>"/>
                    <div  style="color:#000" id="customers_com1"></div></td>
                    <td align="left"><div align="right">พนักงานขาย :</div></td>
                    <td>
                   
   
<select name="bid_name" style="width:200px" id="bid_name">
  <option value="">
  กรุณาเลือก  </option>
  <? $tel_one = "select  * 
						from    bid
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option value="<?=$rs_one['bid_name']?>">
  <?=$rs_one['bid_name']?>
  </option>
  <? } ?>
</select></td>
                  </tr>
                  <tr>
                    <td><div align="right">เว็บไซต์ :</div></td>
                    <td><input name="billing2_web" type="text" id="billing2_web" size="50" value="<?=$rs_one4['customers_web']?>"/>
                    <div  style="color:#000" id="customers_web"> </div></td>
                    <td><div align="right">วันที่ชำระ :</div></td>
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
   
	$("#dateInput2").datepicker({ dateFormat: 'yy-mm-dd',
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
	$("#dateInput3").datepicker({ dateFormat: 'yy-mm-dd',
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
                        <input name="billing2_date_to" class="textinputdotted" type="text" id="dateInput2" value="" size="20"/></td>
                  </tr>
                  <tr>
                    <td><div align="right">โทรศัพท์ :</div></td>
                    <td><input name="billing2_tel" type="text" id="billing2_tel" size="50" value="<?=$rs_one4['customers_tel']?>"/>
                    <div  style="color:#000" id="customers_tel"> </div></td>
                    <td><div align="right">วันที่กำหนดชำระ :</div></td>
                    <td><input name="billing2_date_end" class="textinputdotted" type="text" id="dateInput3" value="" size="20"/></td>
                  </tr>
                  <tr>
                    <td><div align="right">แฟกซ์ :</div></td>
                    <td><input name="billing2_fax" type="text" id="billing2_fax" size="50" value="<?=$rs_one4['customers_fax']?>"/>
                    <div  style="color:#000" id="customers_fax"> </div></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="right">อีเมล์ :</div></td>
                    <td>
                      <input name="billing2_mail" type="text" id="billing2_mail" size="50" value="<?=$rs_one4['customers_email']?>"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right">เลขผู้เสียภาษ::</td>
                    <td><input name="billing2_taxpayer" type="text" id="billing2_taxpayer" size="50" value="<?=$rs_one4['customers_num']?>"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="right">ที่อยู่ :</div></td>
                    <td><textarea name="billing2_address" cols="45" id="billing2_address"><?=$rs_one4['customers_address']?>
                    </textarea></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
			</tr>
			<tr>
			  <td colspan="2"><table width="917" bbilling2="0" cellspacing="0">
                <tr>
                <th class="a1" scope="col">No.</th>
                  <th class="a32" scope="col">Description</th>
                  <th class="a52" scope="col">Qty.</th>
                  <th class="a52" scope="col">Unit</th>
                  <th class="a52" scope="col">AMOUNT</th>
                </tr>
                
                <tr>
                  <td colspan="5"><script type="text/javascript">
$(document).ready(function(){
    var i = 1; var cnt = 20; var html = '';
    //create object
    for(i=1;i<=cnt;i++){
		
        html +=  '<input name="no['+i+']" type="text" id="no['+i+']" size="5" />&nbsp;';
		html +=  '<input name="description['+i+']" type="text" id="description['+i+']" size="50" />&nbsp;';
        html += '<input type ="text" name="qty['+i+']" id="qty_'+i+'"  size="7" autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="detail_unit['+i+']" id="price_'+i+'" size="7" autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="total['+i+']"  id="total_'+i+'" size="7"/>&nbsp;';
		html += '</br>';
		$("#form14").html(html); 
       
    }
    
    //trigger when type
    $('input[id^="qty"], input[id^="price"]').keyup(function(){
        //find value1
        var value1 = parseFloat($(this).val());
        //check if is not a number, skip
        if(isNaN(value1)) return false;
        //find type of trigged
        var type = $(this).attr("id").split("_");
        //find number
        var no = parseInt(type[1]);
        //delete number
        type = type[0];
        //find Multiplier
        var value2 = parseFloat($('#'+(type=="value"?"price":"qty")+"_"+no).val());
        //check if is not a number, skip
        if(isNaN(value2)) return false;
        //chenge value
        $("#total_"+no).val(value1*value2);
        //set start value
        var all_result = 0;
        //travel all result
        $('input[id^="total"]').each(function(){
            var curr_val = parseFloat($(this).val());
            if(!isNaN(curr_val)) all_result += curr_val;
        });
		 var all_results = 0;
		$('input[id^="total"]').each(function(){
            var curr_vals = parseFloat($(this).val());
  
            if(!isNaN(curr_vals)) all_results += curr_vals*0.07;
        });
		var all_result_sum = 0;
		$('input[id^="total"]').each(function(){
            var curr_val_sum = parseFloat($(this).val());
            if(!isNaN(curr_val_sum)) all_result_sum += (curr_val_sum*0.07)+curr_val_sum;
        });
        //update all valuea.toPrecision(4)
        $("#billing2_amount_en").val(all_result.toFixed(2));        
		$("#billing2_amount_vat").val(all_results.toFixed(2));        
		       
		 $("#billing2_amount_sum").val(all_result_sum.toFixed(2));        
                
    });
});
</script> <div id="form14"></div></td>
                  <td width="18%" valign="top">                                </td>
                </tr>
                  
                
              </table>              </td>
		  </tr>
			<tr>
			  <td colspan="2"><hr/></td>
		  </tr>
			<tr>
              <td width="7%"></td>
			  <td width="93%"><table width="100%" bbilling2="0">

                <tr>
                  <td width="52%" rowspan="3" align="center"><script type="text/javascript">
$(document).ready(function(){

	$("#billing2_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing_amount_en=' +$("#billing2_amount_en").val(),
				
			})
			.success(function(result) { 
					$("div#bid_tel5").html(result); 
					 $("#billing2_amount_th").val(result);

			});

		});
		$("#billing2_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing_amount_vat=' +$("#billing2_amount_en").val(),
			})
			.success(function(result) { 
					 $("#billing2_amount_vat").val(result);
			});

		});
		$("#billing2_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing_amount_sum=' +$("#billing2_amount_en").val(),
			})
			.success(function(result) { 
					 $("#billing2_amount_sum").val(result);

			});

		});
		
	});
	
</script>

<div  style="color:#000" id="bid_tel5"></div><input type="hidden" name="billing2_amount_th" id="billing2_amount_th" /></td>
                  <td width="16%"><div align="right">ราคารวม</div></td>
                  <td width="32%"> <input type="text" name="billing2_amount_en" id="billing2_amount_en" /></td>
                </tr>
                <tr>
                  <td><div align="right">ภาษีมูลค่าเพิ่ม 7 %</div></td>
                  <td><input type="text" name="billing2_amount_vat" id="billing2_amount_vat" /></td>
                </tr>
                <tr>
                  <td><div align="right">รวมมูลค่าทั้งสิ้น</div></td>
                  <td><input type="text" name="billing2_amount_sum" id="billing2_amount_sum" /></td>
                </tr>
              </table></td>
		  </tr>
			<tr>
			  <td></td>
			  <td valign="top">ชำระเงินสด
		      <input name="billing2_cash" type="checkbox" id="checkbox2" value="1" />
		      จำนวนเงิน
		      <input name="billing2_cash_amount" class="textinputdotted" type="text" id="billing2_cash_amount" size="40" /></td>
		  </tr>
			<tr>
			  <td></td>
			  <td valign="top">เช็ค/โอนธนาคาร 
		      <input name="billing2_check" type="checkbox" id="checkbox" value="1" /> 
		      ธนาคาร
		      <input name="billing2_check_bank" class="textinputdotted" type="text" id="billing2_check_bank" size="25" />
		      สาขา
		      <input name="billing2_check_branch" class="textinputdotted" type="text" id="billing2_check_branch" size="25" />
		      เลขที่เช็ค <input name="billing2_check_number" class="textinputdotted" type="text" id="billing2_check_number" size="25" /></td>
		  </tr>
			<tr>
			  <td></td>
			  <td valign="top"> <script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
                        <script type="text/javascript">  
$(function(){  
   
	
	$("#dateInput4").datepicker({ dateFormat: 'yy-mm-dd',
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

                      </script>วันที่
			    <input name="billing2_check_date" class="textinputdotted" type="text" id="dateInput4" value="" size="20"/>
		      จำนวนเงิน
		      <input name="billing2_check_amount" class="textinputdotted" type="text" id="billing2_check_amount" size="25" /></td>
		  </tr>
			<tr>
			  <td></td>
			  <td valign="top"><table width="100%" bbilling2="0">
                <tr>
                  <th valign="top" >&nbsp;</th>
                  <th >&nbsp;</th>
                </tr>
                <tr>
                  <th width="152" valign="top" ><div align="right">ผู้อนุมัติ :</div></th>
                  <th width="720" ><div align="left">
                   <script type="text/javascript">
$(document).ready(function(){

	$("#billing2_approve").change(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing2_approve=' +$("#billing2_approve").val()
			})
			.success(function(result) { 

				var obj = jQuery.parseJSON(result);
				
					if(obj == '')
					{
						$("#bid_id").val('');
						 $("#bid_name").html('');
					}
					else
					{
						  $.each(obj, function(key, inval) {
								 $("#bid_name2").val(inval["bid_name"]);
						  });
					}

			});

		});
	});
	
</script>
                    <select name="billing2_approve" style="width:200px" id="billing2_approve">
                      <option value=""> กรุณาเลือก </option>
                      <? $tel_one = "select  * 
						from    bid
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
                      <option value="<?=$rs_one['bid_name']?>">
                      <?=$rs_one['bid_name']?>
                      </option>
                      <? } ?>
                    </select>
                   
                  </div></th>
                </tr>
              </table></td>
		  </tr>
			<tr>
			  <td></td>
			  <td><table width="100%" border="0">
                <tr>
                  <th width="152" valign="top" ><div align="right">หมายเหตุ:</div></th>
                  <th width="720" ><div align="left">
                      <textarea name="billing2_comment_detail" id="billing2_comment_detail" cols="45" rows="5"></textarea>
                  </div></th>
                </tr>
              </table></td>
		  </tr>
			<tr>
              <td align="right">สถานะ ::</td>
			  <td><?  
			$tel_one = "select  * 
						from    status_billing
						where 
						   	   status_b_s = '3' and status_b_publish ='Yes' order by status_b_id DESC";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
             echo "<input type=\"radio\" name=\"billing2_publish\" value=\"$rs_one[status_b_id]\" />$rs_one[status_b_name]";
				echo '&nbsp';
				}?></td>
		  </tr>
			<tr>
			  <td></td>
			  <td>&nbsp;</td>
		  </tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="Submit" value="ยืนยันข้อมูล" >
					<input type="button" name="Submit" value="ยกเลิก" onClick="window.location='billing2.php';"/>				</td>
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
						from    billing2
						where 
						   	   billing2_id = '".$_GET['billing2_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
				$billing2_num  	= $rs_one['billing2_num'];
				$billing2_id  	= $rs_one['billing2_id'];
				$customers_p_id = $rs_one['customers_p_id'];
				$customers_id  	= $rs_one['customers_id'];
				$billing2_attn  	= $rs_one['billing2_attn'];
				$billing2_co   	= $rs_one['billing2_co'];
				$billing2_web  	= $rs_one['billing2_web'];
				$billing2_tel  	= $rs_one['billing2_tel'];
				$billing2_fax  	= $rs_one['billing2_fax'];
				$billing2_mail  	= $rs_one['billing2_mail'];
				$billing2_taxpayer  	= $rs_one['billing2_taxpayer'];
				$billing2_date  	= $rs_one['billing2_date'];
				$billing2_address  	= $rs_one['billing2_address'];
				if($rs_one['billing2_date_to']!="0000-00-00"){
				$billing2_date_to=$rs_one['billing2_date_to'];
				}
				if($rs_one['billing2_date_end']!="0000-00-00"){
				$billing2_date_end=$rs_one['billing2_date_end'];
				}
				$billing2_from  	= $rs_one['billing2_from'];
				$billing2_mail1  	= $rs_one['billing2_mail1'];
				$billing2_approve  	= $rs_one['billing2_approve'];
				$billing2_amount_th  	= $rs_one['billing2_amount_th'];
				$billing2_amount_en  	= $rs_one['billing2_amount_en'];
				$billing2_amount_vat  	= $rs_one['billing2_amount_vat'];
				$billing2_amount_sum  	= $rs_one['billing2_amount_sum'];
				$billing2_approve  	= $rs_one['billing2_approve'];
				$billing2_poster  	= $rs_one['billing2_poster'];
				$billing2_updater  	= $rs_one['billing2_updater'];
				$billing2_date1  	= $rs_one['billing2_date1'];
				$billing2_update  	= $rs_one['billing2_update'];
				$billing2_publish  	= $rs_one['billing2_publish'];
			}
			
			$tel_one = "select  * 
						from    billing2_cash
						where 
						   	   billing2_id = '".$_GET['billing2_id']."'";
			$get_one = mysql_query($tel_one);
			while($rs_one = mysql_fetch_array($get_one))
			{
				$billing2_cash_id  	= $rs_one['billing2_cash_id'];
				$billing2_cash_amount  	= $rs_one['billing2_cash_amount'];
			}
			
			$tel_one = "select  * 
						from    billing2_check
						where 
						   	   billing2_id = '".$_GET['billing2_id']."'";
			$get_one = mysql_query($tel_one);
			while($rs_one = mysql_fetch_array($get_one))
			{
				$billing2_check_id  	= $rs_one['billing2_check_id'];
				$billing2_check_bank  	= $rs_one['billing2_check_bank'];
				$billing2_check_branch  	= $rs_one['billing2_check_branch'];
				$billing2_check_number  	= $rs_one['billing2_check_number'];
				$billing2_check_date  	= $rs_one['billing2_check_date'];
				$billing2_check_amount  	= $rs_one['billing2_check_amount'];
				$billing2_check_date  	= $rs_one['billing2_check_date'];
			}
	?>	
	<form name="form1" action="?action=save" method="post" onSubmit="return checkvalue('fix')" enctype="multipart/form-data">
	<div class="text_detail">
		รายละเอียด : สร้างวันที่ : <?=dateform($billing2_date1)?> [ <?=$billing2_poster?> ] , แก้ไขล่าสุดวันที่ <?=dateform($billing2_update)?> , [ <?=$billing2_updater?> ]
	</div>
	<table id="myTable" bgcolor="#E6E6E6" width="100%">
		<tr>
			<td width="7%"></td>
			<td width="93%"><input type="submit" name="Submit"   		value="บันทึกข้อมูล" >
		    <input type="button" name="Submit4" value="ยกเลิก" onclick="window.location='billing2.php';"/></td>
		</tr>
		<tr>
			<td colspan="2"><table width="100%" bbilling2="0">
                  <tr>
                    <td><div align="right">
                      <div align="right">เลขที่ใบวางบิล::</div>
                      </div></td>
                    <td> <input name="billing2_id" type="text" id="billing2_id" value="<?=$billing2_id?>" size="50" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="13%"><div align="right">เรียน :</div></td>
              <td width="36%"><script type="text/javascript">
$(document).ready(function(){

	$("#billing2_attn1").change(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'sCusIDs=' +$("#billing2_attn1").val()
			})
			.success(function(result) { 

				var obj = jQuery.parseJSON(result);
				
					if(obj == '')
					{
						
						 $("#customers_com1").html('');
						 $("#billing2_co").val('');
						
					}
					else
					{
						  $.each(obj, function(key, inval) {

							  
							   $("#customers_com1").html(inval["customers_com"]);
							   $("#customers_email").html(inval["customers_email"]);
							   $("#customers_web").html(inval["customers_web"]);
							   $("#customers_tel").html(inval["customers_tel"]);
							   $("#customers_fax").html(inval["customers_fax"]);
								
							   $("#billing2_co").val(inval["customers_com"]);
							   $("#billing2_mail").val(inval["customers_email"]);
							   $("#customers_name").val(inval["customers_name"]);
							   $("#billing2_web").val(inval["customers_web"]);
							   $("#billing2_tel").val(inval["customers_tel"]);
							   $("#billing2_fax").val(inval["customers_fax"]);
							 
							 
				
						  });
					}

			});

		});
	});
	
</script>
                      <? 
						if ($_GET[edit]=="true"){
						$tel_one = "select  * from    customers where customers_id='".$_SESSION["str_customers_id"]."'
						";
			$get_one = mysql_query($tel_one);
			$rs_one = mysql_fetch_array($get_one);
				$customers_id  	= $rs_one['customers_id'];
				$billing2_attn  	= $rs_one['customers_name'];
				$billing2_co   	= $rs_one['customers_com'];
				$billing2_web  	= $rs_one['customers_web'];
				$billing2_tel  	= $rs_one['customers_tel'];
				$billing2_fax  	= $rs_one['customers_fax'];
				$billing2_mail  	= $rs_one['customers_email'];
				$billing2_taxpayer  	= $rs_one['customers_num'];
				$billing2_address  	= $rs_one['customers_address'];
			}
			$tel_one = "select  * from    customers_project where customers_p_id='".$_GET["customers_p_id"]."'
						";
			$get_one = mysql_query($tel_one);
			$rs_one = mysql_fetch_array($get_one);
				$customers_p_id  	= $rs_one['customers_p_id'];
			?><? $tel_one4 = "select  * from    customers where customers_id='$customers_id'
						";
			$get_one4 = mysql_query($tel_one4);
			$rs_one4 = mysql_fetch_array($get_one4);
			?>  
             <select name="billing2_attn" style="width:200px" id="billing2_attn">
  <? $tel_one = "select  * 
						from    customers_detail  where   customers_id = '$rs_one4[customers_id]' order by customers_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option <?php if (!(strcmp($rs_one['customers_detail_name'], "$billing2_attn"))) {echo "selected=\"selected\"";} ?> value="<?=$rs_one['customers_detail_name']?>">
  <?=$rs_one['customers_detail_name']?>
  </option>
  <? } ?>
</select>
<? if($_GET['customers_id']==""){
	$_SESSION["str_customers_id"] = $rs_one4[customers_id];
	} ?>
                      
                      <a href="billing2_customers.php?fix=true&amp;billing2_id=<?=$billing2_id;?>"><img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/></a><input type="hidden" name="customers_p_id"  id="customers_p_id" value="<?=$customers_p_id?>" /></td>
                    <td width="14%"><div align="right">วันที่ :</div></td>
                    <td width="37%">
                    <link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.7.2.custom.css">  
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
   //$("#dateInput").datepicker({ dateFormat: 'yy-mm-dd' });  
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

<input name="billing2_date" class="textinputdotted" type="text" id="dateInput" value="<?=$billing2_date?>" size="20"/></td>
                </tr>
                  <tr>
                    <td ><div align="right">บริษัท :</div></td>
                    <td><input name="billing2_co" type="text" id="billing2_co" value="<?=$billing2_co?>" size="50" /></td>
                    <td><div align="right">พนักงานขาย :</div></td>
                    <td>
                   
    <script type="text/javascript">
$(document).ready(function(){

	$("#bid_id").change(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'sCusID=' +$("#bid_id").val()
			})
			.success(function(result) { 

				var obj = jQuery.parseJSON(result);
				
					if(obj == '')
					{
						$("#bid_id").val('');
						 $("#bid_name").html('');
							  
						
					}
					else
					{
						  $.each(obj, function(key, inval) {

							  
							   $("#bid_tel").html(inval["bid_tel"]);
							     $("#bid_tel2").html(inval["bid_tel2"]);
								$("#bid_fax").html(inval["bid_fax"]);
								$("#bid_email").html(inval["bid_email"]);
								 $("#bid_name").val(inval["bid_name"]);
							  $("#bid_tels").val(inval["bid_tel"]); 
							   $("#bid_tels2").val(inval["bid_tel2"]); 
							    $("#bid_faxs").val(inval["bid_fax"]); 
							  $("#bid_emails").val(inval["bid_email"]);
							 
				
						  });
					}

			});

		});
	});
	
</script>
<select name="bid_name" style="width:200px" id="bid_name">
  <? $tel_one = "select  * 
						from    bid
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option value="<?=$rs_one['bid_name']?>" <?php if (!(strcmp($rs_one['bid_name'], "$billing2_from"))) {echo "selected=\"selected\"";} ?>>
  <?=$rs_one['bid_name']?>
  </option>
  <? } ?>
</select></td>
                  </tr>
                  <tr>
                    <td><div align="right">เว็บไซต์ :</div></td>
                    <td><input name="billing2_web" type="text" id="billing2_web" value="<?=$billing2_web?>" size="50" /></td>
                    <td><div align="right">วันที่ชำระ :</div></td>
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
   
	$("#dateInput2").datepicker({ dateFormat: 'yy-mm-dd',
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
	$("#dateInput3").datepicker({ dateFormat: 'yy-mm-dd',
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
                        <input name="billing2_date_to" class="textinputdotted" type="text" id="dateInput2" value="<?=$billing2_date_to?>" size="20"/></td>
                </tr>
                  <tr>
                    <td><div align="right">โทรศัพท์ :</div></td>
                    <td><input name="billing2_tel" type="text" id="billing2_tel" value="<?=$billing2_tel?>" size="50" /></td>
                    <td><div align="right">วันที่กำหนดชำระ :</div></td>
                    <td><input name="billing2_date_end" class="textinputdotted" type="text" id="dateInput3" value="<?=$billing2_date_end?>" size="20"/></td>
                </tr>
                  <tr>
                    <td><div align="right">แฟกซ์ :</div></td>
                    <td><input name="billing2_fax" type="text" id="billing2_fax" value="<?=$billing2_fax?>" size="50" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                  <tr>
                    <td><div align="right">อีเมล์ :</div></td>
                    <td><input name="billing2_mail" type="text" id="billing2_mail" value="<?=$billing2_mail?>" size="50" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">เลขผู้เสียภาษ::</td>
                  <td><input name="billing2_taxpayer" type="text" id="billing2_taxpayer" value="<?=$billing2_taxpayer?>" size="50" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><div align="right">ที่อยู่ :</div></td>
                    <td><textarea name="billing2_address" cols="45" id="billing2_address"><?=$billing2_address?>
                    </textarea></td> <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
            </table></td>
		</tr>
		    <tr>
		      <td colspan="2"><table width="950" bbilling2="0" cellspacing="0">
                <tr>
                 <th class="a1" scope="col">No.</th>
                  <th class="a32" scope="col">Description</th>
                  <th class="a52" scope="col">Qty.</th>
                  <th class="a52" scope="col">Unit</th>
                  <th class="a52" scope="col">AMOUNT</th>
                </tr>
               
                <tr>
                  <td colspan="5"> <table  width="98%" bbilling2="0" cellspacing="0" >
				  <script type="text/javascript">
$(document).ready(function(){
   	var html = '';
    //create object
    <?
	
$tel_one = "select * from   billing2_detail where   billing2_id = '$billing2_id' order by billing2_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			$rank_rows = mysql_num_rows($get_one);
			while($rs_one = mysql_fetch_array($get_one))
			{  $i++;
$billing2_detail_id["$i"]=$rs_one[billing2_detail_id];
$billing2_detail_no["$i"]=$rs_one[billing2_detail_no];
$billing2_detail_description["$i"]=$rs_one[billing2_detail_description];
$billing2_detail_qty["$i"]=$rs_one[billing2_detail_qty];
$billing2_detail_unit["$i"]=$rs_one[billing2_detail_unit];
$billing2_detail_total["$i"]=$rs_one[billing2_detail_total];
			?><?=$i?>
		
        html +=  '<input name="no[<?=$i?>]" type="text" id="no[<?=$i?>]" value="<?=$billing2_detail_no["$i"]?>"  size="5" />&nbsp;';
		html +=  '<input name="description[<?=$i?>]" type="text" id="description[<?=$i?>]" value="<?=$billing2_detail_description["$i"]?>"size="50" />&nbsp;';
        html += '<input type ="text" name="qty[<?=$i?>]" id="qty_<?=$i?>" value="<?=$billing2_detail_qty["$i"]?>" size="7" autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="detail_unit[<?=$i?>]" id="price_<?=$i?>" size="7"  value="<?=$billing2_detail_unit["$i"]?>"  autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="total[<?=$i?>]"  id="total_<?=$i?>"    value="<?=$billing2_detail_total["$i"]?>"size="7"/>&nbsp;';
		html += '<input type ="hidden" name="billing2_details_id[<?=$i?>]"  id="billing2_details_id[<?=$i?>]"   value="<?=$billing2_detail_id["$i"]?>" size="7"/>';
		html += '<a href="?action=del1&amp;billing2_detail_id=<?=$billing2_detail_id["$i"];?>&billing2_id=<?=$billing2_id?>"onclick="return Conf(<?=$illing2_detail_id["$i"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = "20px" onmouseout="this.style.width = "16px" border="0" /></a>'
		html += '</br>';
		$("#form1").html(html);
  <?  } ?>
  <? $i1=$i+1?>
   var i =<?=$i1?> ; var cnt = 20;
    //create object
    for(i=<?=$i1?>;i<=cnt;i++){
		
       html +=  '<input name="no['+i+']" type="text" id="no['+i+']" size="5" />&nbsp;';
		html +=  '<input name="description['+i+']" type="text" id="description['+i+']" size="50" />&nbsp;';
        html += '<input type ="text" name="qty['+i+']" id="qty_'+i+'"  size="7" autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="detail_unit['+i+']" id="price_'+i+'" size="7" autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="total['+i+']" readonly="readonly"  id="total_'+i+'" size="7"/>&nbsp;';
		html += '</br>';
		$("#form14").html(html); 
       
    }
    
    //trigger when type
    $('input[id^="qty"], input[id^="price"]').keyup(function(){
        //find value1
        var value1 = parseFloat($(this).val());
        //check if is not a number, skip
        if(isNaN(value1)) return false;
        //find type of trigged
        var type = $(this).attr("id").split("_");
        //find number
        var no = parseInt(type[1]);
        //delete number
        type = type[0];
        //find Multiplier
        var value2 = parseFloat($('#'+(type=="value"?"price":"qty")+"_"+no).val());
        //check if is not a number, skip
        if(isNaN(value2)) return false;
        //chenge value
        $("#total_"+no).val(value1*value2);
        //set start value
        var all_result = 0;
        //travel all result
        $('input[id^="total"]').each(function(){
            var curr_val = parseFloat($(this).val());
            if(!isNaN(curr_val)) all_result += curr_val;
        });
		 var all_results = 0;
		$('input[id^="total"]').each(function(){
            var curr_vals = parseFloat($(this).val());
  
            if(!isNaN(curr_vals)) all_results += curr_vals*0.07;
        });
		var all_result_sum = 0;
		$('input[id^="total"]').each(function(){
            var curr_val_sum = parseFloat($(this).val());
            if(!isNaN(curr_val_sum)) all_result_sum += (curr_val_sum*0.07)+curr_val_sum;
        });
        //update all valuea.toPrecision(4)
        $("#billing2_amount_en").val(all_result); 
		$("#billing2_amount_vat").val(all_results.toFixed(0));        
		       
		 $("#billing2_amount_sum").val(all_result_sum.toFixed(0));        
                
    });
});
</script> <div id="form14"></div>
</table>
<table  width="100%" bbilling2="0" cellspacing="0" id="tbExp2">
	            </table> 
                  <td width="18%" valign="top">&nbsp;</td>
                </tr>
                  
                
              </table></td>
	      </tr>
	        <tr>
	          <td colspan="2"><hr/></td>
          </tr>
	        <tr>
	          <td></td>
	          <td><table width="100%" bbilling2="0">

                <tr>
                  <td width="52%" rowspan="3" align="center"><script type="text/javascript">
$(document).ready(function(){

	$("#billing2_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing2_amount_en=' +$("#billing2_amount_en").val(),
				
			})
			.success(function(result) { 
					$("div#bid_tel5").html(result); 
					 $("#billing2_amount_th").val(result);

			});

		});
		$("#billing2_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing2_amount_vat=' +$("#billing2_amount_en").val(),
			})
			.success(function(result) { 
					 $("#billing2_amount_vat").val(result);
			});

		});
		$("#billing2_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing2_amount_sum=' +$("#billing2_amount_en").val(),
			})
			.success(function(result) { 
					 $("#billing2_amount_sum").val(result);

			});

		});
		
	});
	
</script><div  style="color:#000" id="bid_tel5">
  <?=$billing2_amount_th?>
   
                     
</div>
<input name="billing2_amount_th" type="hidden" id="billing2_amount_th" value="<?=$billing2_amount_th?>" /></td>
                  <td width="16%"><div align="right">ราคารวม</div></td>
                  <td width="32%"> <input name="billing2_amount_en" type="text" id="billing2_amount_en" value="<?=$billing2_amount_en?>" /></td>
                </tr>
                <tr>
                  <td><div align="right">ภาษีมูลค่าเพิ่ม 7 %</div></td>
                  <td><input type="text" name="billing2_amount_vat" id="billing2_amount_vat" value="<?=$billing2_amount_vat?>"/></td>
                </tr>
                <tr>
                  <td><div align="right">รวมมูลค่าทั้งสิ้น</div></td>
                  <td><input name="billing2_amount_sum" type="text" id="billing2_amount_sum" value="<?=$billing2_amount_sum?>" /></td>
                </tr>
              </table></td>
          </tr>
            <tr>
              <td></td>
			  <td valign="top">ชำระเงินสด
		      <input <?php if ($billing2_cash_id!="") {echo "checked=\"checked\"";} ?> name="billing2_cash" type="checkbox" id="checkbox2" value="1" />
		      จำนวนเงิน
		      <input name="billing2_cash_amount" class="textinputdotted" type="text" id="billing2_cash_amount" size="40"  value="<?=$billing2_cash_amount?>"/>
		      <input type="hidden" name="billing2_cash_id" id="hiddenField" value="<?=$billing2_cash_id?>"/>
		      <a href="?action=del2&amp;billing2_cash_id=<?=$billing2_cash_id;?>&amp;billing2_id=<?=$billing2_id?>"onclick="return Conf(<?=$billing2_cash_id;?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" bbilling2="0" /></a></td>
		  </tr>
			<tr>
			  <td></td>
			  <td valign="top">เช็ค/โอนธนาคาร 
		      <input name="billing2_check" <?php if ($billing2_check_id!="") {echo "checked=\"checked\"";} ?>  type="checkbox" id="checkbox" value="1" /> 
		      ธนาคาร
		      <input type="hidden" name="billing2_check_id" id="hiddenField2"  value="<?=$billing2_check_id?>"/>
		      <input name="billing2_check_bank" class="textinputdotted" type="text" id="billing2_check_bank"  value="<?=$billing2_check_bank?>" size="25" />
		      สาขา
		      <input name="billing2_check_branch" class="textinputdotted" type="text" id="billing2_check_branch" size="25" value="<?=$billing2_check_branch?>" />
		      เลขที่เช็ค <input name="billing2_check_number" class="textinputdotted" type="text" id="billing2_check_number" size="25" value="<?=$billing2_check_number?>"/></td>
		  </tr>
			<tr>
			  <td></td>
			  <td valign="top"> <script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
                        <script type="text/javascript">  
$(function(){  
   
	
	$("#dateInput4").datepicker({ dateFormat: 'yy-mm-dd',
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

                      </script>วันที่
			    <input name="billing2_check_date" class="textinputdotted" type="text" id="dateInput4" value="<?=$billing2_check_date?>" size="20"/>
		      จำนวนเงิน
		      <input name="billing2_check_amount" class="textinputdotted" type="text" id="billing2_check_amount" value="<?=$billing2_check_amount?>"  size="25" />
		      <a href="?action=del3&amp;billing2_check_id=<?=$billing2_check_id;?>&amp;billing2_id=<?=$billing2_id?>"onclick="return Conf(<?=$billing2_check_id;?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" bbilling2="0" /></a></td>
            </tr>
            <tr>
              <td></td>
              <td><table width="100%" bbilling2="0">
                <tr>
                  <th width="152" valign="top" ><div align="right">ผู้อนุมัติ :</div></th>
                  <th width="720" ><div align="left">
                      <script type="text/javascript">
$(document).ready(function(){

	$("#billing2_approve").change(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing2_approve=' +$("#billing2_approve").val()
			})
			.success(function(result) { 

				var obj = jQuery.parseJSON(result);
				
					if(obj == '')
					{
						$("#bid_id").val('');
						 $("#bid_name").html('');
					}
					else
					{
						  $.each(obj, function(key, inval) {
								 $("#bid_name2").val(inval["bid_name"]);
						  });
					}

			});

		});
	});
	
              </script>
                        <select name="billing2_approve" style="width:200px" id="billing2_approve">
                        <? $tel_one = "select  * 
						from    bid
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option value="<?=$rs_one['bid_name']?>" <?php if (!(strcmp($rs_one['bid_name'], "$billing2_approve"))) {echo "selected=\"selected\"";} ?>>
  <?=$rs_one['bid_name']?>
  </option>
                        <? } ?>
                      </select>
                     
                  </div></th>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td></td>
              <td><table width="100%" border="0">
                <tr>
                  <th width="152" valign="top" ><div align="right">หมายเหตุ:</div></th>
                  <th width="720" ><div align="left">
                      <textarea name="billing2_comment_details" id="billing2_comment_details" cols="45" rows="5"></textarea>
                      <br/>
                      <? $tel_one = "select  * 
						from    billing2_comment
						where 
						   	   billing2_id = '".$billing2_id."' ORDER  BY billing2_comment_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			while($rs_one = mysql_fetch_array($get_one))
			{ 
			$i++;
						$tel_one2 = "select  * 
						from    billing2_comment_re
						where  billing2_comment_id = '".$rs_one['billing2_comment_publish']."' and billing2_com_re_publish = '".$_SESSION["str_admin_email"]."'";
			$get_one2 = mysql_query($tel_one2);			
			$Num_Rows2 = mysql_num_rows($get_one2);
			if ($Num_Rows2==0){
						if($rs_one[billing2_comment_publish]!="$_SESSION[str_admin_email]"){

			$tellway  = "INSERT INTO billing2_comment_re VALUES(";
		$tellway .= "0
					,'".$_SESSION["str_admin_email"]."'
					,'$rs_one[billing2_comment_id]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
			}
			}
			$tel_one1 = "select  * 
						from    admin
						where  admin_email = '".$rs_one['billing2_comment_publish']."'";
			$get_one1 = mysql_query($tel_one1);
			$rs_one1 = mysql_fetch_array($get_one1);
			echo $rs_one1[admin_name];
			?>
                      <br/>
                      <? if ($rs_one['billing2_comment_publish'] == $_SESSION["str_admin_email"]) { ?>
                      <textarea name="billing2_comment_detail[<?=$i?>]" id="billing2_comment_detail[<?=$i?>]" cols="45" rows="5"><?=$rs_one['billing2_comment_detail']?>
              </textarea>
                      <input type="hidden" name="billing2_comment_id[<?=$i?>]" id="billing2_comment_id[<?=$i?>]" value="<?=$rs_one['billing2_comment_id']?>" />
                      <input type="hidden" name="billing2_comment_publish[<?=$i?>]" id="billing2_comment_publish[<?=$i?>]" value="<?=$rs_one['billing2_comment_publish']?>" />
                      <a href="?action=del4&amp;billing2_comment_id=<?=$rs_one['billing2_comment_id']?>&amp;billing2_id=<?=$billing2_id?>"onclick="return Conf(<?=$order_detail_id["$i"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0" /></a><br/>
                      <? }else{ 
                      echo $rs_one['billing2_comment_detail'].'<br/>';
					  }
					   } ?>
                      <input type="hidden" name="comment_num" id="comment_num" value="<?=$i?>" />
                  </div></th>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td align="right">สถานะ ::</td>
              <td><?  
			$tel_one = "select  * 
						from    status_billing
						where 
						   	   status_b_s = '3' and status_b_publish ='Yes' order by status_b_id  DESC";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{ ?>
                <input type="radio" name="billing2_publish" value="<?=$rs_one[status_b_id]?>" <? if($billing2_publish=="$rs_one[status_b_id]"){?>checked="checked"<? } ?> />
                <?=$rs_one[status_b_name]?>
                &nbsp;
                <? }?></td>
          </tr>
            <tr>
              <td></td>
              <td>&nbsp;</td>
            </tr>
          <tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit5" value="ยกเลิก" onclick="window.location='billing2.php';"/></td>
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
	<?
		if($_GET['view'] == "true"){
			$tel_one = "select  * 
						from    billing2
						where 
						   	   billing2_id = '".$_GET['billing2_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
				$billing2_num  	= $rs_one['billing2_num'];
				$billing2_id  	= $rs_one['billing2_id'];
				$customers_p_id = $rs_one['customers_p_id'];
				$billing2_attn  	= $rs_one['billing2_attn'];
				$billing2_co   	= $rs_one['billing2_co'];
				$billing2_web  	= $rs_one['billing2_web'];
				$billing2_tel  	= $rs_one['billing2_tel'];
				$billing2_fax  	= $rs_one['billing2_fax'];
				$billing2_mail  	= $rs_one['billing2_mail'];
				$billing2_taxpayer  	= $rs_one['billing2_taxpayer'];
				$billing2_date  	= $rs_one['billing2_date'];
				$billing2_address  	= $rs_one['billing2_address'];
				if($rs_one['billing2_date_to']!="0000-00-00"){
				$billing2_date_to=$rs_one['billing2_date_to'];
				}
				if($rs_one['billing2_date_end']!="0000-00-00"){
				$billing2_date_end=$rs_one['billing2_date_end'];
				}
				$billing2_from  	= $rs_one['billing2_from'];
				$billing2_mail1  	= $rs_one['billing2_mail1'];
				$billing2_approve  	= $rs_one['billing2_approve'];
				$billing2_amount_th  	= $rs_one['billing2_amount_th'];
				$billing2_amount_en  	= $rs_one['billing2_amount_en'];
				$billing2_amount_vat  	= $rs_one['billing2_amount_vat'];
				$billing2_amount_sum  	= $rs_one['billing2_amount_sum'];
				$billing2_approve  	= $rs_one['billing2_approve'];
				$billing2_poster  	= $rs_one['billing2_poster'];
				$billing2_updater  	= $rs_one['billing2_updater'];
				$billing2_date1  	= $rs_one['billing2_date1'];
				$billing2_update  	= $rs_one['billing2_update'];
				$billing2_publish  	= $rs_one['billing2_publish'];
			}
			
			$tel_one = "select  * 
						from    billing2_cash
						where 
						   	   billing2_id = '".$_GET['billing2_id']."'";
			$get_one = mysql_query($tel_one);
			while($rs_one = mysql_fetch_array($get_one))
			{
				$billing2_cash_id  	= $rs_one['billing2_cash_id'];
				$billing2_cash_amount  	= $rs_one['billing2_cash_amount'];
			}
			
			$tel_one = "select  * 
						from    billing2_check
						where 
						   	   billing2_id = '".$_GET['billing2_id']."'";
			$get_one = mysql_query($tel_one);
			while($rs_one = mysql_fetch_array($get_one))
			{
				$billing2_check_id  	= $rs_one['billing2_check_id'];
				$billing2_check_bank  	= $rs_one['billing2_check_bank'];
				$billing2_check_branch  	= $rs_one['billing2_check_branch'];
				$billing2_check_number  	= $rs_one['billing2_check_number'];
				$billing2_check_date  	= $rs_one['billing2_check_date'];
				$billing2_check_amount  	= $rs_one['billing2_check_amount'];
				$billing2_check_date  	= $rs_one['billing2_check_date'];
			}
	?>
    <form action="?action=save" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return checkvalue('fix')">
      <div class="text_detail"> รายละเอียด : สร้างวันที่ :
        <?=dateform($billing2_date1)?>
        [
        <?=$billing2_poster?>
        ] , แก้ไขล่าสุดวันที่
        <?=dateform($billing2_update)?>
        , [
        <?=$billing2_updater?>
        ] </div>
      <table id="myTable2" bgcolor="#E6E6E6" width="100%">
        <tr>
          <td width="7%"></td>
          <td width="93%"><input type="button" name="Submit6" value="กลับ" onclick="window.location='billing2.php';"/></td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" bbilling2="0">
              <tr>
                <td><div align="right">
                    <div align="right">เลขที่ใบวางบิล::</div>
                </div></td>
                <td><?=$billing2_id?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="13%"><div align="right">เรียน :</div></td>
                <td width="36%"><script type="text/javascript">
$(document).ready(function(){

	$("#billing2_attn1").change(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'sCusIDs=' +$("#billing2_attn1").val()
			})
			.success(function(result) { 

				var obj = jQuery.parseJSON(result);
				
					if(obj == '')
					{
						
						 $("#customers_com1").html('');
						 $("#billing2_co").val('');
						
					}
					else
					{
						  $.each(obj, function(key, inval) {

							  
							   $("#customers_com1").html(inval["customers_com"]);
							   $("#customers_email").html(inval["customers_email"]);
							   $("#customers_web").html(inval["customers_web"]);
							   $("#customers_tel").html(inval["customers_tel"]);
							   $("#customers_fax").html(inval["customers_fax"]);
								
							   $("#billing2_co").val(inval["customers_com"]);
							   $("#billing2_mail").val(inval["customers_email"]);
							   $("#customers_name").val(inval["customers_name"]);
							   $("#billing2_web").val(inval["customers_web"]);
							   $("#billing2_tel").val(inval["customers_tel"]);
							   $("#billing2_fax").val(inval["customers_fax"]);
							 
							 
				
						  });
					}

			});

		});
	});
	
    </script>
                    <? 
						if ($_GET[edit]=="true"){
						$tel_one = "select  * from    customers where customers_id='".$_SESSION["str_customers_id"]."'
						";
			$get_one = mysql_query($tel_one);
			$rs_one = mysql_fetch_array($get_one);
				$customers_id  	= $rs_one['customers_id'];
				$billing2_attn  	= $rs_one['customers_name'];
				$billing2_co   	= $rs_one['customers_com'];
				$billing2_web  	= $rs_one['customers_web'];
				$billing2_tel  	= $rs_one['customers_tel'];
				$billing2_fax  	= $rs_one['customers_fax'];
				$billing2_mail  	= $rs_one['customers_email'];
				$billing2_address  	= $rs_one['customers_address'];
			}
			$tel_one = "select  * from    customers_project where customers_p_id='".$_SESSION["str_customers_p_id"]."'
						";
			$get_one = mysql_query($tel_one);
			$rs_one = mysql_fetch_array($get_one);
				$customers_p_id  	= $rs_one['customers_p_id'];
			?>
                    <?=$billing2_attn?></td>
                <td width="14%"><div align="right">วันที่ :</div></td>
                <td width="37%"><?=$billing2_date?></td>
              </tr>
              <tr>
                <td ><div align="right">บริษัท :</div></td>
                <td><?=$billing2_co?></td>
                <td><div align="right">พนักงานขาย :</div></td>
                <td><?=$billing2_from?></td>
              </tr>
              <tr>
                <td><div align="right">เว็บไซต์ :</div></td>
                <td><?=$billing2_web?></td>
                <td><div align="right">วันที่ชำระ :</div></td>
                <td><?=$billing2_date_to?></td>
              </tr>
              <tr>
                <td><div align="right">โทรศัพท์ :</div></td>
                <td><?=$billing2_tel?></td>
                <td><div align="right">วันที่กำหนดชำระ :</div></td>
                <td><?=$billing2_date_end?></td>
              </tr>
              <tr>
                <td><div align="right">แฟกซ์ :</div></td>
                <td><?=$billing2_fax?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="right">อีเมล์ :</div></td>
                <td><?=$billing2_mail?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right">เลขผู้เสียภาษ::</td>
                <td><?=$billing2_taxpayer?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="right">ที่อยู่ :</div></td>
                <td><?=$billing2_address?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2"><table width="917" bbilling2="0" cellspacing="0">
              <tr>
               <th class="a1" scope="col">No.</th>
                  <th class="a32" scope="col">Description</th>
                  <th class="a52" scope="col">Qty.</th>
                  <th class="a52" scope="col">Unit</th>
                  <th class="a52" scope="col">AMOUNT</th>
              </tr>
              <tr>
                <td colspan="5"><table  width="98%" bbilling2="0" cellspacing="0" >
                    <script type="text/javascript">
$(document).ready(function(){
   	var html = '';
    //create object
    <?
	
$tel_one = "select * from   billing2_detail where   billing2_id = '$billing2_id' order by billing2_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			$rank_rows = mysql_num_rows($get_one);
			while($rs_one = mysql_fetch_array($get_one))
			{  $i++;
$billing2_detail_id["$i"]=$rs_one[billing2_detail_id];
$billing2_detail_no["$i"]=$rs_one[billing2_detail_no];
$billing2_detail_description["$i"]=$rs_one[billing2_detail_description];
$billing2_detail_qty["$i"]=$rs_one[billing2_detail_qty];
$billing2_detail_unit["$i"]=$rs_one[billing2_detail_unit];
$billing2_detail_total["$i"]=$rs_one[billing2_detail_total];
			?><?=$i?>
		
        html +=  '<input name="no[<?=$i?>]" type="text" id="no[<?=$i?>]" value="<?=$billing2_detail_no["$i"]?>"  size="5" />&nbsp;';
		html +=  '<input name="description[<?=$i?>]" type="text" id="description[<?=$i?>]" value="<?=$billing2_detail_description["$i"]?>"size="50" />&nbsp;';
        html += '<input type ="text" name="qty[<?=$i?>]" id="qty_<?=$i?>" value="<?=$billing2_detail_qty["$i"]?>" size="7" autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="detail_unit[<?=$i?>]" id="price_<?=$i?>" size="7"  value="<?=$billing2_detail_unit["$i"]?>"  autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="total[<?=$i?>]"  id="total_<?=$i?>"    value="<?=$billing2_detail_total["$i"]?>"size="7"/>&nbsp;';
		html += '<input type ="hidden" name="billing2_details_id[<?=$i?>]"  id="billing2_details_id[<?=$i?>]"   value="<?=$billing2_detail_id["$i"]?>" size="7"/>';
		html += '</br>';
		$("#form14").html(html);
  <?  } ?>
    $('input[id^="qty"], input[id^="price"]').keyup(function(){
        //find value1
        var value1 = parseFloat($(this).val());
        //check if is not a number, skip
        if(isNaN(value1)) return false;
        //find type of trigged
        var type = $(this).attr("id").split("_");
        //find number
        var no = parseInt(type[1]);
        //delete number
        type = type[0];
        //find Multiplier
        var value2 = parseFloat($('#'+(type=="value"?"price":"qty")+"_"+no).val());
        //check if is not a number, skip
        if(isNaN(value2)) return false;
        //chenge value
        $("#total_"+no).val(value1*value2);
        //set start value
        var all_result = 0;
        //travel all result
        $('input[id^="total"]').each(function(){
            var curr_val = parseFloat($(this).val());
            if(!isNaN(curr_val)) all_result += curr_val;
        });
		 var all_results = 0;
		$('input[id^="total"]').each(function(){
            var curr_vals = parseFloat($(this).val());
  
            if(!isNaN(curr_vals)) all_results += curr_vals*0.07;
        });
		var all_result_sum = 0;
		$('input[id^="total"]').each(function(){
            var curr_val_sum = parseFloat($(this).val());
            if(!isNaN(curr_val_sum)) all_result_sum += (curr_val_sum*0.07)+curr_val_sum;
        });
        //update all valuea.toPrecision(4)
        $("#billing2_amount_en").val(all_result); 
		$("#billing2_amount_vat").val(all_results.toFixed(0));        
		       
		 $("#billing2_amount_sum").val(all_result_sum.toFixed(0));        
                
    });
});
    </script>
                    <div id="form14"></div>
                </table>
                    <table  width="100%" bbilling2="0" cellspacing="0" id="tbExp">
                  </table></td>
                <td width="18%" valign="top">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2"><hr/></td>
        </tr>
        <tr>
          <td></td>
          <td><table width="100%" bbilling2="0">
              <tr>
                <td width="52%" rowspan="3" align="center"><?=$billing2_amount_th?></td>
                <td width="16%"><div align="right">ราคารวม</div></td>
                <td width="32%"><?=$billing2_amount_en?></td>
              </tr>
              <tr>
                <td><div align="right">ภาษีมูลค่าเพิ่ม 7 %</div></td>
                <td><?=$billing2_amount_vat?></td>
              </tr>
              <tr>
                <td><div align="right">รวมมูลค่าทั้งสิ้น</div></td>
                <td><?=$billing2_amount_sum?></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td></td>
          <td valign="top">ชำระเงินสด
            <input <?php if ($billing2_cash_id!="") {echo "checked=\"checked\"";} ?> name="checkbox" type="checkbox" id="checkbox3" value="1" />
            จำนวนเงิน
           <?=$billing2_cash_amount?>
            <?=$billing2_cash_id?></td>
        </tr>
        <tr>
          <td></td>
          <td valign="top">เช็ค/โอนธนาคาร
            <input name="checkbox" <?php if ($billing2_check_id!="") {echo "checked=\"checked\"";} ?>  type="checkbox" id="checkbox4" value="1" />
            ธนาคาร
            <input type="hidden" name="hiddenField" id="hiddenField4"  value="<?=$billing2_check_id?>"/>
            <?=$billing2_check_bank?>
สาขา
<?=$billing2_check_branch?>
เลขที่เช็ค
<?=$billing2_check_number?></td>
        </tr>
        <tr>
          <td></td>
          <td valign="top"><script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
              <script type="text/javascript">  
$(function(){  
   
	
	$("#dateInput4").datepicker({ dateFormat: 'yy-mm-dd',
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
            วันที่
            <?=$billing2_check_date?>
            จำนวนเงิน
            <?=$billing2_check_amount?></td>
        </tr>
        <tr>
          <td></td>
          <td><table width="100%" bbilling2="0">
              <tr>
                <th width="152" valign="top" ><div align="right">ผู้อนุมัติ :</div></th>
                <th width="720" ><div align="left">
                  <?=$billing2_approve?>
                </div></th>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td></td>
          <td><table width="100%" border="0">
              <tr>
                <th width="152" valign="top" ><div align="right">หมายเหตุ:</div></th>
                <th width="720" ><div align="left"><br/>
                    <? $tel_one = "select  * 
						from    billing2_comment
						where 
						   	   billing2_id = '".$billing2_id."' ORDER  BY billing2_comment_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			while($rs_one = mysql_fetch_array($get_one))
			{ 
			$i++;
						$tel_one2 = "select  * 
						from    billing2_comment_re
						where  billing2_comment_id = '".$rs_one['billing2_comment_publish']."' and billing2_com_re_publish = '".$_SESSION["str_admin_email"]."'";
			$get_one2 = mysql_query($tel_one2);			
			$Num_Rows2 = mysql_num_rows($get_one2);
			if ($Num_Rows2==0){
						if($rs_one[billing2_comment_publish]!="$_SESSION[str_admin_email]"){

			$tellway  = "INSERT INTO billing2_comment_re VALUES(";
		$tellway .= "0
					,'".$_SESSION["str_admin_email"]."'
					,'$rs_one[billing2_comment_id]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
			}
			}
			$tel_one1 = "select  * 
						from    admin
						where  admin_email = '".$rs_one['billing2_comment_publish']."'";
			$get_one1 = mysql_query($tel_one1);
			$rs_one1 = mysql_fetch_array($get_one1);
			echo $rs_one1[admin_name];
			?>
                    <br/>
                    <? if ($rs_one['billing2_comment_publish'] == $_SESSION["str_admin_email"]) { ?>
                    <textarea name="billing2_comment_detail[<?=$i?>]2" id="billing2_comment_detail[<?=$i?>]2" cols="45" rows="5"><?=$rs_one['billing2_comment_detail']?>
              </textarea>
                    <input type="hidden" name="billing2_comment_id[<?=$i?>]2" id="billing2_comment_id[<?=$i?>]2" value="<?=$rs_one['billing2_comment_id']?>" />
                    <input type="hidden" name="billing2_comment_publish[<?=$i?>]2" id="billing2_comment_publish[<?=$i?>]2" value="<?=$rs_one['billing2_comment_publish']?>" />
                    <br/>
                    <? }else{ 
                      echo $rs_one['billing2_comment_detail'].'<br/>';
					  }
					   } ?>
                    <input type="hidden" name="comment_num2" id="comment_num2" value="<?=$i?>" />
                </div></th>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td align="right">สถานะ ::</td>
          <td><?  
			$tel_one = "select  * 
						from    status_billing
						where 
						   	   status_b_id = '$billing2_publish'  ";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{ ?>
            <?=$rs_one[status_b_name]?>
<? }?></td>
        </tr>
        <tr>
          <td></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td></td>
          <td><input type="button" name="Submit6" value="กลับ" onclick="window.location='billing2.php';"/></td>
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
    <form name="list" method="post" action="?action=del_sel" onsubmit="return ConfAll()">
	  <table width="100%" bbilling2="0" cellspacing="0">
        <?
		// query area
		$i=0;
		
		if( $_SESSION["str_search"] ==""){
			$tel = "select * 
					from    billing2
					 ";
		} else {
		$search=$_GET[search1];
			$tel = "select * 
					from    billing2
					where  
						   $search like '%".$_SESSION["str_search"]."%'";
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
					if( $_SESSION["str_admin_gp_id"] == ""){
						$_GET['type_stack'] = "DESC";
					} else {
						$_GET['type_stack'] = "DESC";
					}
				}
			
				if($_GET['stack']=="")
				{ 
					if( $_SESSION["str_admin_gp_id"] ==""){
						$_GET['stack'] = "billing2_num";
					} else {
						$_GET['stack'] = "billing2_num";
					}
				}
			
			
				$tel .=" order  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>
        <thead>
          <tr>
            <td width="8%">สถานะ</td>
            <td width="13%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=billing2_id&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">ใบเสร็จรับเงิน</a>
                <? }else { ?>
                <a href="?stack=billing2_id&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">ใบเสร็จรับเงิน</a>
                <? } ?>            </td>
            <td width="32%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=billing2_co&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">บริษัท </a>
                <? }else { ?>
                <a href="?stack=billing2_co&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">บริษัท </a>
                <? } ?>            </td>
            <td width="18%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=billing2_date1&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
                <? }else { ?>
                <a href="?stack=billing2_date1&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
                <? } ?>            </td>
            <td width="15%"><a href="?stack=admin_publish&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">สถานะ</a></td>
            <td width="4%">รายงาน</td>
            <td width="4%">พิมพ์</td>
            <td width="4%">แก้ไข</td>
           <!-- <td width="6%">ลบ</td> -->
          </tr>
        </thead>
        <tbody>
          <?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
          <tr id="tr<?=$i?>" onmouseover='mOvr(this,&quot;#E6E6E6&quot;);' onmouseout='mOut(this,&quot;#ffffff&quot;);'>
            <td><? 
			$tel_one = "select  * 
						from     billing2_comment
						where 
						   	    billing2_id = '".$rs[billing2_id]."' and  billing2_comment_publish != '".$_SESSION["str_admin_email"]."' ORDER  BY billing2_comment_id   ASC";
			$get_one = mysql_query($tel_one);
			$num_check1  = mysql_num_rows($get_one);
			$i=0;
			if ($num_check1 > 0){
			while($rs_one = mysql_fetch_array($get_one))
			{ $i++;
			$tel_one5 = "select  * 
						from    billing2_comment_re
						where   billing2_comment_id = '".$rs_one['billing2_comment_id']."' and billing2_com_re_publish ='".$_SESSION["str_admin_email"]."' ";
			$get_one5 = mysql_query($tel_one5);
			$num_check5  = mysql_num_rows($get_one5);
			}
			if($num_check5 > "0"){
				
				$color = "#FF0000";
			?>
              <img src="images/f_poll.gif" />
              <?
			   } else {
				$color = "#000000";
				
			?>
              <img src="images/f_hot.gif" width="18" height="12" />
              <? } 
			  }
			  ?></td>
            <td><?=$rs['billing2_id']?>            </td>
            <td><?=$rs['billing2_co']?>
              <br/>
              <font class="text_small_gray">โปรเจค <? 
			  $tel_one1 = "select * 
					from    customers_project
					where  
						   customers_p_id = '".$rs["customers_p_id"]."'";
			$get_one1 = mysql_query($tel_one1);
			$rs_one1 = mysql_fetch_array($get_one1);
			 echo $rs_one1[customers_p_name]; 			  
			  ?>
              </font></td>
            <td><?=dateform($rs['billing2_date1'])?>
                <br/>
                <font class="text_small_gray">By
                  <?=$rs['billing2_poster']?>
                </font> </td>
            <td><?  
			$tel_one = "select  * 
						from    status_billing
						where 
						   	   status_b_id = '$rs[billing2_publish]' and status_b_publish ='Yes' order by status_b_id  DESC";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{ echo"$rs_one[status_b_name]"; } ?></td>
            <td><a href="?view=true&amp;billing2_id=<?=$rs["billing2_id"];?>" > <img src="images/view.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
            <td><a href="MPDF56/examples/re_billing2.php?billing2_id=<?=$rs["billing2_id"];?>" target="_blank"> <img src="images/view.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
            <td><a href="?fix=true&amp;billing2_id=<?=$rs["billing2_id"];?>"> <img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
            <!--<td><a href="?action=del&amp;billing2_id=<?=$rs["billing2_id"];?>"  onclick="return confirm('ยืนยันการลบ ออกใบเสร็จรับเงิน<?=$rs["billing2_id"]?>')"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" bbilling2="0" /></a> </td> -->
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
<script>
function createByJson() {
	var jsonData = [					
					{description:'Choos your payment gateway', value:'', text:'Payment Gateway'},					
					{image:'images/msdropdown/icons/Amex-56.png', description:'My life. My card...', value:'amex', text:'Amex'},
					{image:'images/msdropdown/icons/Discover-56.png', description:'It pays to Discover...', value:'Discover', text:'Discover'},
					{image:'images/msdropdown/icons/Mastercard-56.png', title:'For everything else...', description:'For everything else...', value:'Mastercard', text:'Mastercard'},
					{image:'images/msdropdown/icons/Cash-56.png', description:'Sorry not available...', value:'cash', text:'Cash on devlivery', disabled:true},
					{image:'images/msdropdown/icons/Visa-56.png', description:'All you need...', value:'Visa', text:'Visa'},
					{image:'images/msdropdown/icons/Paypal-56.png', description:'Pay and get paid...', value:'Paypal', text:'Paypal'}
					];
	$("#byjson").msDropDown({byJson:{data:jsonData, name:'payments2'}}).data("dd");
}
$(document).ready(function(e) {		
	//no use
	try {
		var pages = $("#pages").msDropdown({on:{change:function(data, ui) {
												var val = data.value;
												if(val!="")
													window.location = val;
											}}}).data("dd");

		var pagename = document.location.pathname.toString();
		pagename = pagename.split("/");
		pages.setIndexByValue(pagename[pagename.length-1]);
		$("#ver").html(msBeautify.version.msDropdown);
	} catch(e) {
		//console.log(e);	
	}
	
	$("#ver").html(msBeautify.version.msDropdown);
		
	//convert
	$("#billing2_attn1").msDropdown();
	$("#billing2_attn").msDropdown();
	$("#bid_name").msDropdown();
	$("#billing2_approve").msDropdown();
	createByJson();
	$("#tech").data("dd");
});
function showValue(h) {
	console.log(h.name, h.value);
}
$("#tech").change(function() {
	console.log("by jquery: ", this.value);
})
//
</script>
</html>
