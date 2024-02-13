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
		$tel_check 	= "select * from billing where billing_id = '".$_POST['billing_id']."'";
		$get_check  = mysql_query($tel_check);
		$num_check  = mysql_num_rows($get_check);
		$billing_id=$_POST['billing_id'];
		if($num_check>0){
		$tel_auto_rank = "select billing_id from billing where billing_id like 'Iv%' ORDER  BY billing_num DESC";
		$get_auto_rank = mysql_query($tel_auto_rank);
		$rs_one_rank = mysql_fetch_array($get_auto_rank);
		$rank_rows = mysql_fetch_array($get_auto_rank);
		 $billing_idts= substr ($rs_one_rank[billing_id],2,2);
		$billing_idts1= date('y')+43;
		$billing_idt = substr ($rs_one_rank[billing_id],5,5);
		$billing_id="Iv";
		$billing_id.="$billing_idts";
		$billing_id.="-";
		$billing_idt=$billing_idt+1;
		$billing_id.="$billing_idt";
	
			echo "<script language='JavaScript'>
		if(confirm(\"ใบเสนอราคามีอยู่ในระบบแล้วต้องการเปลียนเป็น $billing_id\")==true)
		{
			
			
		}
		else
		{
			history.back()
			exit();
		}

</script>";
					
		
		}
		// check email duplicate ------------------------------------------------------------------------------------------------
		
	 $billing_amount_th=num2string("$_POST[billing_amount_sum]");	
	
		$tellway  = "INSERT INTO billing VALUES(";
		$tellway .= "'$_POST[billing_num]'
					,'$billing_id'
					,'$_POST[customers_p_id]'
					,'".$_SESSION["str_customers_id"]."'
					,'$_POST[billing_attn]'
					,'$_POST[billing_co]'
					,'$_POST[billing_web]'
					,'$_POST[billing_tel]'
					,'$_POST[billing_fax]'
					,'$_POST[billing_mail]'
					,'$_POST[billing_taxpayer]'
					,'$_POST[billing_date]'
					,'$_POST[billing_address]'
					,'$_POST[billing_date_end]'
					,'$_POST[billing_from]'
					,'$billing_amount_th'
					,'$_POST[billing_amount_en]'
					,'$_POST[billing_amount_vat]'
					,'$_POST[billing_amount_sum]'
					,'$_POST[billing_approve]'
					,'".$_SESSION["str_admin_email"]."'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,NOW()
					,'$_POST[billing_publish]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		//$billing_id=mysql_insert_id();
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
				
				$tellway  = "INSERT INTO billing_detail VALUES('0','".$_POST["no"][$j1]."','".$_POST["description"][$j1]."','".$_POST["qty"][$j1]."',$detail_unit,$total,'$billing_id')";
		$dbquery = mysql_query($tellway);
				
			}		
			}
		 
		  if($_POST["billing_comment_detail"]!=""){
				$tellway  = "INSERT INTO billing_comment VALUES('0','".$_POST["billing_comment_detail"]."','".$_SESSION["str_admin_email"]."',NOW(),'$billing_id')";
		$dbquery = mysql_query($tellway);
				
			}	
			$tel_one = "select  * 
						from    customers_orderid
						where 
						   	  customers_id = '".$_SESSION["str_customers_id"]."' and customers_orderid_publish='2'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
				$customers_orderid_id	   	= $rs_one['customers_orderid_id'];
				$customers_orderid_date	   	= $rs_one['customers_orderid_date'];
				$customers_orderid_m     = $rs_one['customers_orderid_m'];
			}
			
			 	  $inputDate=$customers_orderid_date;
				  $strCurrDate = strtotime($inputDate);
 $days=date("Y-m-d", mktime(date("H",$strCurrDate)+0, date("i",$strCurrDate)+0, date("s",$strCurrDate)+0, date("m",$strCurrDate)+$customers_orderid_m  , date("d",$strCurrDate)+0, date("Y",$strCurrDate)+0));
			
			
				$sql_del= "update  customers_orderid  set customers_orderid_date ='".$_POST["customers_orderid_date"]."' where customers_orderid_id='".$_POST["customers_orderid_id"]."'";
				$dbquery_del = mysql_query($sql_del);
		echo "<script language=\"javascript\">";
		echo "window.open('MPDF56/examples/re_billing1.php?billing_id=$_POST[billing_id]', 're_billing1')";
		echo "</script>";			
		echo "<script language=\"JavaScript\">";
		echo "window.location='billing1.php';";
		echo "</script>";
    }
	// end__ insert ----------------------------------------------------------------------------------------------------------------------
	
	// start update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="save")
	{	
		 $billing_amount_th=num2string("$_POST[billing_amount_sum]");	
		
		$sql_up = "update billing set
					 billing_attn = '$_POST[billing_attn]'
					,customers_p_id = '$_POST[customers_p_id]'
					,customers_id ='".$_SESSION["str_customers_id"]."'
					,billing_co ='$_POST[billing_co]'
					,billing_web ='$_POST[billing_web]'
					,billing_tel ='$_POST[billing_tel]'
					,billing_fax ='$_POST[billing_fax]'
					,billing_mail ='$_POST[billing_mail]'
					,billing_taxpayer ='$_POST[billing_taxpayer]'
					,billing_date ='$_POST[billing_date]'
					,billing_address ='$_POST[billing_address]'
					,billing_date_end ='$_POST[billing_date_end]'
					,billing_from ='$_POST[bid_name]'
					,billing_amount_th ='$billing_amount_th'
					,billing_amount_en ='$_POST[billing_amount_en]'
					,billing_amount_vat ='$_POST[billing_amount_vat]'
					,billing_amount_sum ='$_POST[billing_amount_sum]'
					,billing_approve ='$_POST[billing_approve]'
					,billing_updater ='".$_SESSION["str_admin_email"]."'
					,billing_update =NOW()
					,billing_publish ='$_POST[billing_publish]'
					where billing_id  = '".$_POST['billing_id']."'";
		$dbquery = mysql_query($sql_up);
		$j1=0;
		while($j1<=20){
			$j1++;
			if($_POST["description"][$j1]!="" and $_POST["billing_details_id"][$j1]!=""){
				if ($_POST["detail_unit"][$j1]!=""){
					$sql_up = "update billing_detail set 
				billing_detail_unit = '".$_POST["detail_unit"][$j1]."'				
				where billing_detail_id  = '".$_POST['billing_details_id'][$j1]."'";
				$dbquery = mysql_query($sql_up);
				}else{
					$sql_up = "update billing_detail set 
				billing_detail_unit = NULL				
				where billing_detail_id  = '".$_POST['billing_details_id'][$j1]."'";
				$dbquery = mysql_query($sql_up);
				}
				if ($_POST["total"][$j1]!=""){
					
				$sql_up = "update billing_detail set 
				billing_detail_total = '".$_POST["total"][$j1]."'
				where billing_detail_id  = '".$_POST['billing_details_id'][$j1]."'";
				$dbquery = mysql_query($sql_up);	
				}else{
				$sql_up = "update billing_detail set 
				billing_detail_total = NULL				
				where billing_detail_id  = '".$_POST['billing_details_id'][$j1]."'";
				$dbquery = mysql_query($sql_up);	
				}
				$sql_up = "update billing_detail set 
				billing_detail_no = '".$_POST["no"][$j1]."'
				,billing_detail_description = '".$_POST["description"][$j1]."'
				,billing_detail_qty = '".$_POST["qty"][$j1]."'
				,billing_id	 = '".$_POST["billing_id"]."'
				where billing_detail_id  = '".$_POST['billing_details_id'][$j1]."'";
				$dbquery = mysql_query($sql_up);
			}
			if($_POST["description"][$j1]!="" and $_POST["billing_details_id"][$j1]==""){
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
				
			$tellway  = "INSERT INTO billing_detail VALUES('0','".$_POST["no"][$j1]."','".$_POST["description"][$j1]."','".$_POST["qty"][$j1]."',$detail_unit,$total,'".$_POST["billing_id"]."')";
		$dbquery = mysql_query($tellway);
			
			}		
			}
			if($_POST["billing_comment_details"]!=""){
				$tellway  = "INSERT INTO billing_comment VALUES('0','".$_POST["billing_comment_details"]."','".$_SESSION["str_admin_email"]."',NOW(),'".$_POST["billing_id"]."')";
		$dbquery = mysql_query($tellway);
			}
			
		$j=0;
		while($j<=$_POST['comment_num']){
			$j++;
			if($_POST["billing_comment_publish"][$j]=="$_SESSION[str_admin_email]"){
			$sql_del= "update  billing_comment  set billing_comment_detail='".$_POST["billing_comment_detail"][$j]."' where billing_comment_id='".$_POST["billing_comment_id"][$j]."'";
				$dbquery_del = mysql_query($sql_del);
			}
			}	
			$tel_one = "select  * 
						from    customers_orderid
						where 
						   	  customers_id = '".$_SESSION["str_customers_id"]."' and customers_orderid_publish='2'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
				$customers_orderid_id	   	= $rs_one['customers_orderid_id'];
				$customers_orderid_date	   	= $rs_one['customers_orderid_date'];
				$customers_orderid_m     = $rs_one['customers_orderid_m'];
			}
			
			 	  $inputDate=$customers_orderid_date;
				  $strCurrDate = strtotime($inputDate);
 $days=date("Y-m-d", mktime(date("H",$strCurrDate)+0, date("i",$strCurrDate)+0, date("s",$strCurrDate)+0, date("m",$strCurrDate)+$customers_orderid_m  , date("d",$strCurrDate)+0, date("Y",$strCurrDate)+0));
			
			
				$sql_del= "update  customers_orderid  set customers_orderid_date ='".$_POST["customers_orderid_date"]."' where customers_orderid_id='".$_POST["customers_orderid_id"]."'";
				$dbquery_del = mysql_query($sql_del);
		echo "<script language=\"javascript\">";
		echo "window.open('MPDF56/examples/re_billing1.php?billing_id=$_POST[billing_id]', 're_billing1')";
		echo "</script>";			
		echo "<script language='JavaScript'>";
		echo "window.location='billing1.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="del")
	{
		
		
		$sql_del= "delete from billing where billing_id ='".$_GET["billing_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		
		$sql_del2= "delete from billing_detail where billing_id ='".$_GET["billing_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		echo "<script language='JavaScript'>";
		echo "window.location=\"billing1.php\";";
		echo "</script>";
		}
		if($_GET["action"]=="del1")
	{
		
		$sql_del2= "delete from billing_detail where billing_detail_id ='".$_GET["billing_detail_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		
		$tel_check 	= "select billing_detail_total from billing_detail where billing_id = '".$_GET['billing_id']."'";
		$get_check  = mysql_query($tel_check);
		while($rs_one = mysql_fetch_array($get_check))
			{
			$billing_detail_total=+ $rs_one[billing_detail_total];
			}
		
		$billing_amount_sum=number_format(($billing_detail_total*0.07)+$billing_detail_total, 0,'.','');
		$billing_amount_vat=number_format($billing_detail_total*0.07, 0,'.','');
		
		$billing_amount_th= num2string("$billing_amount_sum");	
		
		$sql_up = "update billing set
					 billing_amount_th ='$billing_amount_th'
					,billing_amount_en ='$billing_detail_total'
					,billing_amount_vat ='$billing_amount_vat'
					,billing_amount_sum ='$billing_amount_sum'
					,billing_updater ='".$_SESSION["str_admin_email"]."'
					,billing_update =NOW()
					where billing_id  = '".$_GET['billing_id']."'";
		$dbquery = mysql_query($sql_up);
		
		
		
		echo "<script language='JavaScript'>";
		echo "window.location=\"billing1.php?fix=true&billing_id=$_GET[billing_id]\";";
		echo "</script>";
		}
		if($_GET["action"]=="del2")
	{
		
		$sql_del2= "delete from billing_comment where billing_comment_id ='".$_GET["billing_comment_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		$sql_del2= "delete from billing_comment_re where billing_comment_id ='".$_GET["billing_comment_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		echo "<script language='JavaScript'>";
		echo "window.location=\"billing1.php?fix=true&billing_id=$_GET[billing_id]\";";
		echo "</script>";
		}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>billing</title>
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
		
		if(form1.billing_id.value == "") {
			alert("กรุณากรอก เลขที่ใบวางบิล");
			form1.billing_id.focus();
			return false
		}
		if(form1.billing_attn.value == "") {
			alert("กรุณากรอก เรียน");
			form1.billing_attn.focus();
			return false
		}
		if(form1.billing_co.value == "") {
			alert("กรุณาเลือก บริษัท");
			form1.billing_co.focus();
			return false
		}
		if(form1.billing_tel.value == "") {
			alert("กรุณาเลือก โทรศัพท์");
			form1.billing_tel.focus();
			return false
		}if(form1.billing_mail.value == ""){
			alert("กรุณากรอก อีเมลล์");
			form1.billing_mail.focus();
			return false
		}
		if (!(filter.test(form1.billing_mail.value))) {
			alert("กรุณากรอก รูปแบบอีเมลล์ให้ถูกต้อง");
			form1.billing_mail.value = ""
			form1.billing_mail.focus();
			return false;
		}
		if(form1.billing_date.value == ""){
			alert("กรุณากรอก วันที่ ");
			form1.billing_date.focus();
			return false
		}
		
		if(form1.bid_id.value == " "){
			alert("กรุณาเลือก Sale  ");
			form1.bid_id.focus();
			return false
		}
		
		
		if(form1.billing_amount_en.value == ""){
			alert("กรุณากรอก ราคารวม");
			form1.billing_amount_en.focus();
			return false
		}
		if(form1.billing_amount_sum.value == ""){
			alert("กรุณากรอก รวมมูลค่าทั้งสิ้น");
			form1.billing_amount_sum.focus();
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
		<div class="shirt_left">
			<? include "include_menu.php";?>
		</div>
		<div class="shirt_right">
		
			
			<form method="get" action="billing1.php" name="form2" onSubmit="return checkvalue2()">
			  <table width="100%">
                <tr>
                  <td width="34%"> ออกใบวางบิล :
                    <input name="button" type="button" value="+ เพิ่มข้อมูล" onclick="window.location='billing1_customers.php?action=add';"/></td>
                  <td width="47%" align="right">ค้นหา
                    <input name="search" type="text" id="search" value="<?=$_SESSION["str_search"]?>" />
                    เลือก
                    <select name="search1" id="search1">
                     
                      <option value="billing_id" <?php if (!(strcmp($_GET[search1], "billing_id"))) {echo "selected=\"selected\"";} ?>>ใบเสนอราคา</option>
                   	  <option value="billing_co" <?php if (!(strcmp($_GET[search1], "billing_co"))) {echo "selected=\"selected\"";} ?>>บริษัท</option>
                   	  <option value="billing_attn" <?php if (!(strcmp($_GET[search1], "billing_attn"))) {echo "selected=\"selected\"";} ?>>เรียน</option>
                    
                  </select></td>
                  <td width="9%"><input type="submit" name="Submit3" value="ตกลง" />
                  </td>
                  <td width="10%"> |
                    <input type="button" name="Submit2"   value="ทั้งหมด" onclick="window.location='billing1.php?all=true';"/>
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
			$tel_auto_rank = "select billing_id from billing where billing_id like 'Iv%'   ORDER  BY billing_num DESC LIMIT 0,1";
			$get_auto_rank = mysql_query($tel_auto_rank);
			$rs_one_rank = mysql_fetch_array($get_auto_rank);
			$rank_rows = mysql_fetch_array($get_auto_rank);
		
		 $billing_idts= substr ($rs_one_rank[billing_id],2,2);
		
		$billing_idts1= date('y')+43;
		if($billing_idts1>$billing_idts){
		$billing_id="Iv";
		$billing_id.="$billing_idts1";
		$billing_id.="-1";
		}else{
		$billing_idt = substr ($rs_one_rank[billing_id],5,5);
		$billing_id="Iv";
		$billing_id.="$billing_idts";
		$billing_id.="-";
		$billing_idt=$billing_idt+1;
		$billing_id.="$billing_idt";
		}
			
		
	?>
	<form name="form1" action="?action=insert" method="post" onSubmit="return checkvalue('')" enctype="multipart/form-data">
	  <table width="100%">
			<tr>
				<td colspan="2"><table width="100%" bbilling="0">
                  <tr>
                    <td><div align="right">เลขที่ใบวางบิล::</div></td>
                    <td> <input name="billing_id" class="textinputdotted" type="text" id="billing_id" size="40" value="<?=$billing_id?>" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="15%"> 
					<script type="text/javascript">
$(document).ready(function(){

	$("#billing_attn1").change(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'sCusIDs=' +$("#billing_attn1").val()
			})
			.success(function(result) { 

				var obj = jQuery.parseJSON(result);
				
					if(obj == '')
					{
						
						 $("#customers_com1").html('');
						 $("#billing_co").val('');
						
					}
					else
					{
						  $.each(obj, function(key, inval) {

							  
							   $("#customers_com1").html(inval["customers_com"]);
							   $("#customers_email").html(inval["customers_email"]);
							   $("#customers_web").html(inval["customers_web"]);
							   $("#customers_tel").html(inval["customers_tel"]);
							   $("#customers_fax").html(inval["customers_fax"]);
								
							   $("#billing_co").val(inval["customers_com"]);
							   $("#billing_mail").val(inval["customers_email"]);
							   $("#customers_name").val(inval["customers_name"]);
							   $("#billing_web").val(inval["customers_web"]);
							   $("#billing_tel").val(inval["customers_tel"]);
							   $("#billing_fax").val(inval["customers_fax"]);
							 
							 
				
						  });
					}

			});

		});
	});
	
</script><div align="right">เรียน :</div></td>
                    <td width="38%">    
                    
                    <? $tel_one = "select  * 
						from      customers where customers_id='".$_SESSION["str_customers_id"]."'
						";
			$get_one = mysql_query($tel_one);
			$rs_one4 = mysql_fetch_array($get_one);
	
?>       
            <select name="billing_attn" style="width:200px" id="billing_attn">
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
                    <td width="9%"><div align="right">วันที่ :</div></td>
                    <td width="38%">
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

<input name="billing_date" class="textinputdotted" type="text" id="dateInput" value="" size="20"/></td>
                  </tr>
                  <tr>
                    <td ><div align="right">บริษัท :</div></td>
                    <td><input name="billing_co" type="text" id="billing_co" size="50"  value="<?=$rs_one4['customers_com']?>"/>
                    <div  style="color:#000" id="customers_com1"></div></td>
                    <td align="left"><div align="right">Sale :</div></td>
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

							  
							 
								 $("#bid_name").val(inval["bid_name"]);
							
							 
				
						  });
					}

			});

		});
	});
	
</script>
<select name="billing_from" style="width:200px" id="billing_from">
  <option value="">กรุณาเลือก  </option>
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
</td>
                  </tr>
                  <tr>
                    <td><div align="right">เว็บไซต์ :</div></td>
                    <td><input name="billing_web" type="text" id="billing_web" size="50" value="<?=$rs_one4['customers_web']?>"/>
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
   
	$("#dateInput1").datepicker({ dateFormat: 'yy-mm-dd',
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
                        <input name="billing_date_end" class="textinputdotted" type="text" id="dateInput1" value="" size="20"/></td>
                  </tr>
                  <tr>
                    <td><div align="right">โทรศัพท์ :</div></td>
                    <td><input name="billing_tel" type="text" id="billing_tel" size="50" value="<?=$rs_one4['customers_tel']?>"/>
                    <div  style="color:#000" id="customers_tel"> </div></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="right">แฟกซ์ :</div></td>
                    <td><input name="billing_fax" type="text" id="billing_fax" size="50" value="<?=$rs_one4['customers_fax']?>"/>
                    <div  style="color:#000" id="customers_fax"> </div></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="right">อีเมล์ :</div></td>
                    <td>
                      <input name="billing_mail" type="text" id="billing_mail2" size="50" value="<?=$rs_one4['customers_email']?>"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right">เลขผู้เสียภาษ::</td>
                    <td><input name="billing_taxpayer" type="text" id="billing_taxpayer" size="50" value="<?=$rs_one4['customers_num']?>"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="right">ที่อยู่ :</div></td>
                    <td><textarea name="billing_address" cols="45" id="billing_address"><?=$rs_one4['customers_address']?>
                    </textarea></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
			</tr>
			<tr>
			  <td colspan="2">
              <table width="917" bbilling="0" cellspacing="0">
                <tr>
                  <th  class="a1" scope="col">No.</th>
                  <th  class="a31" scope="col">Description</th>
                  <th  class="a5" scope="col">Qty.</th>
                  <th  class="a5" scope="col">Unit</th>
                  <th  class="a5" scope="col">Total</th>
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
        html += '<input type ="text" name="total['+i+']"   id="total_'+i+'" size="7"/>&nbsp;';
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
        $("#billing_amount_en").val(all_result); 
		$("#billing_amount_vat").val(all_results.toFixed(0));        
		       
		 $("#billing_amount_sum").val(all_result_sum.toFixed(0));        
                
    });
});
</script> <div id="form14"></div> </td>
                  <td width="18%" valign="top">&nbsp;</td>
                </tr>
              </table>              </td>
		  </tr>
			<tr>
			  <td colspan="2"><hr/></td>
		  </tr>
			<tr>
              <td width="7%"></td>
			  <td width="93%"><table width="100%" bbilling="0">

                <tr>
                  <td width="52%" rowspan="3" align="center"><script type="text/javascript">
$(document).ready(function(){

	$("#billing_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing_amount_en=' +$("#billing_amount_en").val(),
				
			})
			.success(function(result) { 
					$("div#bid_tel5").html(result); 
					 $("#billing_amount_th").val(result);

			});

		});
		$("#billing_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing_amount_vat=' +$("#billing_amount_en").val(),
			})
			.success(function(result) { 
					 $("#billing_amount_vat").val(result);
			});

		});
		$("#billing_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing_amount_sum=' +$("#billing_amount_en").val(),
			})
			.success(function(result) { 
					 $("#billing_amount_sum").val(result);

			});

		});
		
	});
	
</script>

<div  style="color:#000" id="bid_tel5"></div><input type="hidden" name="billing_amount_th" id="billing_amount_th" /></td>
                  <td width="16%"><div align="right">ราคารวม</div></td>
                  <td width="32%"> <input type="text" name="billing_amount_en" id="billing_amount_en" /></td>
                </tr>
                <tr>
                  <td><div align="right">ภาษีมูลค่าเพิ่ม 7 %</div></td>
                  <td><input type="text" name="billing_amount_vat" id="billing_amount_vat" /></td>
                </tr>
                <tr>
                  <td><div align="right">รวมมูลค่าทั้งสิ้น</div></td>
                  <td><input type="text" name="billing_amount_sum" id="billing_amount_sum" /></td>
                </tr>
              </table></td>
		  </tr>
			<tr>
			  <td></td>
			  <td valign="top"><table width="100%" bbilling="0">
                <tr>
                  <th width="152" valign="top" ><div align="right">ผู้อนุมัติ :</div></th>
                  <th width="720" ><div align="left">
                   <script type="text/javascript">
$(document).ready(function(){

	$("#billing_approve").change(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing_approve=' +$("#billing_approve").val()
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
                    <select name="billing_approve" style="width:200px" id="billing_approve">
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
                    <input type="hidden" name="bid_name2"  id="bid_name2" />
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
                      <textarea name="billing_comment_detail" id="billing_comment_detail" cols="45" rows="5"></textarea>
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
						   	   status_b_s = '2' and status_b_publish ='Yes' order by status_b_id  DESC";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
             echo "<input type=\"radio\" name=\"billing_publish\" value=\"$rs_one[status_b_id]\" />$rs_one[status_b_name]";
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
					<input type="button" name="Submit" value="ยกเลิก" onClick="window.location='billing1.php';"/>				</td>
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
						from    billing
						where 
						   	   billing_id = '".$_GET['billing_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
			
				$billing_id  	= $rs_one['billing_id'];
				$customers_id  	= $rs_one['customers_id'];
				$customers_p_id = $rs_one['customers_p_id'];
				$billing_attn  	= $rs_one['billing_attn'];
				$billing_co   	= $rs_one['billing_co'];
				$billing_web  	= $rs_one['billing_web'];
				$billing_tel  	= $rs_one['billing_tel'];
				$billing_fax  	= $rs_one['billing_fax'];
				$billing_mail  	= $rs_one['billing_mail'];
				$billing_taxpayer  	= $rs_one['billing_taxpayer'];
				$billing_date  	= $rs_one['billing_date'];
				$billing_address  	= $rs_one['billing_address'];
				$billing_date_end  	= $rs_one['billing_date_end'];
				$billing_from  	= $rs_one['billing_from'];
				$billing_mail1  	= $rs_one['billing_mail1'];
				$billing_approve  	= $rs_one['billing_approve'];
				$billing_amount_th  	= $rs_one['billing_amount_th'];
				$billing_amount_en  	= $rs_one['billing_amount_en'];
				$billing_amount_vat  	= $rs_one['billing_amount_vat'];
				$billing_amount_sum  	= $rs_one['billing_amount_sum'];
				$billing_approve  	= $rs_one['billing_approve'];
				$billing_poster  	= $rs_one['billing_poster'];
				$billing_updater  	= $rs_one['billing_updater'];
				$billing_date1  	= $rs_one['billing_date1'];
				$billing_update  	= $rs_one['billing_update'];
				$billing_publish  	= $rs_one['billing_publish'];
				
				
				
				
				
			}
	?>	
	<form name="form1" action="?action=save" method="post" onSubmit="return checkvalue('fix')" enctype="multipart/form-data">
	<div class="text_detail">
		รายละเอียด : สร้างวันที่ : <?=dateform($billing_date1)?> [ <?=$billing_poster?> ] , แก้ไขล่าสุดวันที่ <?=dateform($billing_update)?> , [ <?=$billing_updater?> ]
	</div>
	<table id="myTable" bgcolor="#E6E6E6" width="100%">
		<tr>
			<td width="7%"></td>
			<td width="93%"><input type="submit" name="Submit"   		value="บันทึกข้อมูล" >
		    <input type="button" name="Submit4" value="ยกเลิก" onclick="window.location='billing1.php';"/></td>
		</tr>
		<tr>
			<td colspan="2"><table width="100%" bbilling="0">
                  <tr>
                    <td><div align="right">
                      <div align="right">เลขที่ใบวางบิล::</div>
                      </div></td>
                    <td> <input name="billing_id" type="text" id="billing_id" value="<?=$billing_id?>" size="50" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="14%"><div align="right">เรียน :</div></td>
                <td width="37%"><script type="text/javascript">
$(document).ready(function(){

	$("#billing_attn1").change(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'sCusIDs=' +$("#billing_attn1").val()
			})
			.success(function(result) { 

				var obj = jQuery.parseJSON(result);
				
					if(obj == '')
					{
						
						 $("#customers_com1").html('');
						 $("#billing_co").val('');
						
					}
					else
					{
						  $.each(obj, function(key, inval) {

							  
							   $("#customers_com1").html(inval["customers_com"]);
							   $("#customers_email").html(inval["customers_email"]);
							   $("#customers_web").html(inval["customers_web"]);
							   $("#customers_tel").html(inval["customers_tel"]);
							   $("#customers_fax").html(inval["customers_fax"]);
								
							   $("#billing_co").val(inval["customers_com"]);
							   $("#billing_mail").val(inval["customers_email"]);
							   $("#customers_name").val(inval["customers_name"]);
							   $("#billing_web").val(inval["customers_web"]);
							   $("#billing_tel").val(inval["customers_tel"]);
							   $("#billing_fax").val(inval["customers_fax"]);
							 
							 
				
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
				$billing_attn  	= $rs_one['customers_name'];
				$billing_co   	= $rs_one['customers_com'];
				$billing_web  	= $rs_one['customers_web'];
				$billing_tel  	= $rs_one['customers_tel'];
				$billing_fax  	= $rs_one['customers_fax'];
				$billing_mail  	= $rs_one['customers_email'];
				$billing_taxpayer  	= $rs_one['customers_num'];
				$billing_address  	= $rs_one['customers_address'];
			}
			$tel_one = "select  * from    customers_project where customers_p_id='".$_SESSION["str_customers_p_id"]."'
						";
			$get_one = mysql_query($tel_one);
			$rs_one = mysql_fetch_array($get_one);
				$customers_p_id  	= $rs_one['customers_p_id'];
			?>
              <? $tel_one4 = "select  * from    customers where customers_id='$customers_id'
						";
			$get_one4 = mysql_query($tel_one4);
			$rs_one4 = mysql_fetch_array($get_one4);
			?>  
             <select name="billing_attn" style="width:200px" id="billing_attn">
  <? $tel_one = "select  * 
						from    customers_detail  where   customers_id = '$rs_one4[customers_id]' order by customers_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option <?php if (!(strcmp($rs_one['customers_detail_name'], "$billing_attn"))) {echo "selected=\"selected\"";} ?> value="<?=$rs_one['customers_detail_name']?>">
  <?=$rs_one['customers_detail_name']?>
  </option>
  <? } ?>
</select>
<? if($_GET['customers_id']==""){
	$_SESSION["str_customers_id"] = $rs_one4[customers_id];
	} ?>
                      <a href="billing1_customers.php?fix=true&amp;billing1_id=<?=$billing_id;?>"><img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/></a><input type="hidden" name="customers_p_id"  id="customers_p_id" value="<?=$customers_p_id?>" /></td>
                    <td width="7%"><div align="right">วันที่ :</div></td>
                    <td width="42%">
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

<input name="billing_date" class="textinputdotted" type="text" id="dateInput" value="<?=$billing_date?>" size="20"/></td>
                  </tr>
                  <tr>
                    <td ><div align="right">บริษัท :</div></td>
                    <td><input name="billing_co" type="text" id="billing_co" value="<?=$billing_co?>" size="50" /></td>
                    <td><div align="right">จาก :</div></td>
                    <td>
                   
   
<select name="bid_name" style="width:200px" id="bid_id">
  <? $tel_one = "select  * 
						from    bid
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option value="<?=$rs_one['bid_name']?>" <?php if (!(strcmp($rs_one['bid_name'], "$billing_from"))) {echo "selected=\"selected\"";} ?>>
  <?=$rs_one['bid_name']?>
  </option>
  <? } ?>
</select></td>
                  </tr>
                  <tr>
                    <td><div align="right">เว็บไซต์ :</div></td>
                    <td><input name="billing_web" type="text" id="billing_web" value="<?=$billing_web?>" size="50" /></td>
                    <td><div align="right">วันที่ :</div></td>
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
                        <input name="billing_date_end" class="textinputdotted" type="text" id="dateInput1" value="<?=$billing_date_end?>" size="20"/></td>
                </tr>
                  <tr>
                    <td><div align="right">โทรศัพท์ :</div></td>
                    <td><input name="billing_tel" type="text" id="billing_tel" value="<?=$billing_tel?>" size="50" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                  <tr>
                    <td><div align="right">แฟกซ์ :</div></td>
                    <td><input name="billing_fax" type="text" id="billing_fax" value="<?=$billing_fax?>" size="50" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                  <tr>
                    <td><div align="right">อีเมล์ :</div></td>
                    <td><input name="billing_mail" type="text" id="billing_mail" value="<?=$billing_mail?>" size="50" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="right">เลขผู้เสียภาษี::</td>
                  <td><input name="billing_taxpayer" type="text" id="billing2_num" value="<?=$billing_taxpayer?>" size="50" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><div align="right">ที่อยู่ :</div></td>
                    <td><textarea name="billing_address" cols="45" id="billing_address"><?=$billing_address?>
                    </textarea></td> <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
            </table></td>
		</tr>
		    <tr>
		      <td colspan="2">
              <table width="917" bbilling="0" cellspacing="0">
                <tr>
                  <th width="7%" scope="col">No.</th>
                  <th width="41%" scope="col">Description</th>
                  <th width="9%" scope="col"><div align="left">Qty.</div></th>
                  <th width="9%" scope="col"><div align="left">Unit</div></th>
                  <th width="16%" scope="col"><div align="left">Total</div></th>
                </tr>
                <tr>
                  <td colspan="5"><script type="text/javascript">
$(document).ready(function(){
   	var html = '';
    //create object
    <?
	
$tel_one = "select * from   billing_detail where   billing_id = '$billing_id' order by billing_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			$rank_rows = mysql_num_rows($get_one);
			while($rs_one = mysql_fetch_array($get_one))
			{  $i++;
$billing_detail_id["$i"]=$rs_one[billing_detail_id];
$billing_detail_no["$i"]=$rs_one[billing_detail_no];
$billing_detail_description["$i"]=$rs_one[billing_detail_description];
$billing_detail_qty["$i"]=$rs_one[billing_detail_qty];
$billing_detail_unit["$i"]=$rs_one[billing_detail_unit];
$billing_detail_total["$i"]=$rs_one[billing_detail_total];
			?><?=$i?>
		
        html +=  '<input name="no[<?=$i?>]" type="text" id="no[<?=$i?>]" value="<?=$billing_detail_no["$i"]?>"  size="5" />&nbsp;';
		html +=  '<input name="description[<?=$i?>]" type="text" id="description[<?=$i?>]" value="<?=$billing_detail_description["$i"]?>"size="50" />&nbsp;';
        html += '<input type ="text" name="qty[<?=$i?>]" id="qty_<?=$i?>" value="<?=$billing_detail_qty["$i"]?>" size="7" autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="detail_unit[<?=$i?>]" id="price_<?=$i?>" size="7"  value="<?=$billing_detail_unit["$i"]?>"  autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="total[<?=$i?>]"  id="total_<?=$i?>"    value="<?=$billing_detail_total["$i"]?>"size="7"/>&nbsp;';
		html += '<input type ="hidden" name="billing_details_id[<?=$i?>]"  id="billing_details_id[<?=$i?>]"   value="<?=$billing_detail_id["$i"]?>" size="7"/>';
		html += '<a href="?action=del1&amp;billing_detail_id=<?=$billing_detail_id["$i"];?>&billing_id=<?=$billing_id?>"onclick="return Conf(<?=$order_detail_id["$i"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = "20px" onmouseout="this.style.width = "16px" border="0" /></a>'
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
        $("#billing_amount_en").val(all_result); 
		$("#billing_amount_vat").val(all_results.toFixed(0));        
		       
		 $("#billing_amount_sum").val(all_result_sum.toFixed(0));        
                
    });
});
</script> <div id="form14"></div> </td>
                  <td width="18%" valign="top">	</td>
                </tr>
              </table>              </td>
		    </tr>
	        <tr>
	          <td colspan="2"><hr/></td>
          </tr>
	        <tr>
	          <td></td>
	          <td><table width="100%" bbilling="0">

                <tr>
                  <td width="52%" rowspan="3" align="center"><script type="text/javascript">
$(document).ready(function(){

	$("#billing_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing_amount_en=' +$("#billing_amount_en").val(),
				
			})
			.success(function(result) { 
					$("div#bid_tel5").html(result); 
					 $("#billing_amount_th").val(result);

			});

		});
		$("#billing_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing_amount_vat=' +$("#billing_amount_en").val(),
			})
			.success(function(result) { 
					 $("#billing_amount_vat").val(result);
			});

		});
		$("#billing_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing_amount_sum=' +$("#billing_amount_en").val(),
			})
			.success(function(result) { 
					 $("#billing_amount_sum").val(result);

			});

		});
		
	});
	
</script><div  style="color:#000" id="bid_tel5">
  <?=$billing_amount_th?>
   
                     
</div>
</td>
                  <td width="16%"><div align="right">ราคารวม</div></td>
                  <td width="32%"> <input name="billing_amount_en" type="text" id="billing_amount_en" value="<?=$billing_amount_en?>" /></td>
                </tr>
                <tr>
                  <td><div align="right">ภาษีมูลค่าเพิ่ม 7 %</div></td>
                  <td><input type="text" name="billing_amount_vat" id="billing_amount_vat" value="<?=$billing_amount_vat?>"/></td>
                </tr>
                <tr>
                  <td><div align="right">รวมมูลค่าทั้งสิ้น</div></td>
                  <td><input name="billing_amount_sum" type="text" id="billing_amount_sum" value="<?=$billing_amount_sum?>" /></td>
                </tr>
              </table></td>
          </tr>
            <tr>
              <td></td>
              <td><table width="100%" bbilling="0">
                <tr>
                  <th width="152" valign="top" ><div align="right">ผู้อนุมัติ :</div></th>
                  <th width="720" ><div align="left">
                      <script type="text/javascript">
$(document).ready(function(){

	$("#billing_approve").change(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'billing_approve=' +$("#billing_approve").val()
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
                        <select name="billing_approve" style="width:200px" id="billing_approve">
                        <? $tel_one = "select  * 
						from    bid
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option value="<?=$rs_one['bid_name']?>" <?php if (!(strcmp($rs_one['bid_name'], "$billing_approve"))) {echo "selected=\"selected\"";} ?>>
  <?=$rs_one['bid_name']?>
  </option>
                        <? } ?>
                      </select>
                      <input type="hidden" name="bid_name3"  id="bid_name3" />
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
                   <textarea name="billing_comment_details" id="billing_comment_details" cols="45" rows="5"></textarea><br/>
                 <? $tel_one = "select  * 
						from    billing_comment
						where 
						   	   billing_id = '".$billing_id."' ORDER  BY billing_comment_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			while($rs_one = mysql_fetch_array($get_one))
			{ 
			$i++;
						$tel_one2 = "select  * 
						from    billing_comment_re
						where  billing_comment_id = '".$rs_one['billing_comment_publish']."' and billing_com_re_publish = '".$_SESSION["str_admin_email"]."'";
			$get_one2 = mysql_query($tel_one2);			
			$Num_Rows2 = mysql_num_rows($get_one2);
			if ($Num_Rows2==0){
						if($rs_one[billing_comment_publish]!="$_SESSION[str_admin_email]"){

			$tellway  = "INSERT INTO billing_comment_re VALUES(";
		$tellway .= "0
					,'".$_SESSION["str_admin_email"]."'
					,'$rs_one[billing_comment_id]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
			}
			}
			$tel_one1 = "select  * 
						from    admin
						where  admin_email = '".$rs_one['billing_comment_publish']."'";
			$get_one1 = mysql_query($tel_one1);
			$rs_one1 = mysql_fetch_array($get_one1);
			echo $rs_one1[admin_name];
			?>
            <br/>
            <? if ($rs_one['billing_comment_publish'] == $_SESSION["str_admin_email"]) { ?>
                      <textarea name="billing_comment_detail[<?=$i?>]" id="billing_comment_detail[<?=$i?>]" cols="45" rows="5"><?=$rs_one['billing_comment_detail']?></textarea>
                      <input type="hidden" name="billing_comment_id[<?=$i?>]" id="billing_comment_id[<?=$i?>]" value="<?=$rs_one['billing_comment_id']?>" />
                      <input type="hidden" name="billing_comment_publish[<?=$i?>]" id="billing_comment_publish[<?=$i?>]" value="<?=$rs_one['billing_comment_publish']?>" />
                      <a href="?action=del2&amp;billing_comment_id=<?=$rs_one['billing_comment_id']?>&amp;billing_id=<?=$billing_id?>"onclick="return Conf(<?=$order_detail_id["$i"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0" /></a><br/>
                      <? }else{ 
                      echo $rs_one['billing_comment_detail'].'<br/>';
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
						   	   status_b_s = '2' and status_b_publish ='Yes' order by status_b_id DESC";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{ ?>
            <input type="radio" name="billing_publish" value="<?=$rs_one[status_b_id]?>" <? if($billing_publish=="$rs_one[status_b_id]"){?>checked="checked"<? } ?> /><?=$rs_one[status_b_name]?>&nbsp;
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
				<input type="button" name="Submit5" value="ยกเลิก" onclick="window.location='billing1.php';"/></td>
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
	<?
		if($_GET['view'] == "true"){
			$tel_one = "select  * 
						from    billing
						where 
						   	   billing_id = '".$_GET['billing_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
			
				$billing_id  	= $rs_one['billing_id'];
				$customers_p_id = $rs_one['customers_p_id'];
				$billing_attn  	= $rs_one['billing_attn'];
				$billing_co   	= $rs_one['billing_co'];
				$billing_web  	= $rs_one['billing_web'];
				$billing_tel  	= $rs_one['billing_tel'];
				$billing_fax  	= $rs_one['billing_fax'];
				$billing_mail  	= $rs_one['billing_mail'];
				$billing_taxpayer  	= $rs_one['billing_taxpayer'];
				$billing_date  	= $rs_one['billing_date'];
				$billing_address  	= $rs_one['billing_address'];
				$billing_date_end  	= $rs_one['billing_date_end'];
				$billing_from  	= $rs_one['billing_from'];
				$billing_mail1  	= $rs_one['billing_mail1'];
				$billing_approve  	= $rs_one['billing_approve'];
				$billing_amount_th  	= $rs_one['billing_amount_th'];
				$billing_amount_en  	= $rs_one['billing_amount_en'];
				$billing_amount_vat  	= $rs_one['billing_amount_vat'];
				$billing_amount_sum  	= $rs_one['billing_amount_sum'];
				$billing_approve  	= $rs_one['billing_approve'];
				$billing_poster  	= $rs_one['billing_poster'];
				$billing_updater  	= $rs_one['billing_updater'];
				$billing_date1  	= $rs_one['billing_date1'];
				$billing_update  	= $rs_one['billing_update'];
				$billing_publish  	= $rs_one['billing_publish'];
				
			}
	?>
    <form action="?action=save" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return checkvalue('fix')">
      <div class="text_detail"> รายละเอียด : สร้างวันที่ :
        <?=dateform($billing_date1)?>
        [
        <?=$billing_poster?>
        ] , แก้ไขล่าสุดวันที่
        <?=dateform($billing_update)?>
        , [
        <?=$billing_updater?>
        ] </div>
      <table id="myTable2" bgcolor="#E6E6E6" width="100%">
        <tr>
          <td width="7%"></td>
          <td width="93%"><input type="button" name="Submit6" value="กลับ" onclick="window.location='billing1.php';"/></td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" bbilling="0">
              <tr>
                <td><div align="right">
                    <div align="right">เลขที่ใบวางบิล::</div>
                </div></td>
                <td><?=$billing_id?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="14%"><div align="right">เรียน :</div></td>
                <td width="37%">
                   <?=$billing_attn?></td>
                <td width="7%"><div align="right">วันที่ :</div></td>
                <td width="42%">
                  <?=$billing_date?></td>
              </tr>
              <tr>
                <td ><div align="right">บริษัท :</div></td>
                <td><?=$billing_co?></td>
                <td><div align="right">จาก :</div></td>
                <td>
                    <?=$billing_from?>
                   </td>
              </tr>
              <tr>
                <td><div align="right">เว็บไซต์ :</div></td>
                <td><?=$billing_web?></td>
                <td><div align="right">วันที่ :</div></td>
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
                    <?=$billing_date_end?></td>
              </tr>
              <tr>
                <td><div align="right">โทรศัพท์ :</div></td>
                <td><?=$billing_tel?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="right">แฟกซ์ :</div></td>
                <td><?=$billing_fax?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="right">อีเมล์ :</div></td>
                <td><?=$billing_mail?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right">เลขผู้เสียภาษ::</td>
                <td><?=$billing_taxpayer?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="right">ที่อยู่ :</div></td>
                <td><?=$billing_address?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2"><table width="917" bbilling="0" cellspacing="0">
              <tr>
                <th width="7%" scope="col">No.</th>
                <th width="41%" scope="col">Description</th>
                <th width="9%" scope="col"><div align="left">Qty.</div></th>
                <th width="9%" scope="col"><div align="left">Unit</div></th>
                <th width="16%" scope="col"><div align="left">Total</div></th>
              </tr>
              <tr>
                <td colspan="5"><script type="text/javascript">
$(document).ready(function(){
   	var html = '';
    //create object
    <?
	
$tel_one = "select * from   billing_detail where   billing_id = '$billing_id' order by billing_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			$rank_rows = mysql_num_rows($get_one);
			while($rs_one = mysql_fetch_array($get_one))
			{  $i++;
$billing_detail_id["$i"]=$rs_one[billing_detail_id];
$billing_detail_no["$i"]=$rs_one[billing_detail_no];
$billing_detail_description["$i"]=$rs_one[billing_detail_description];
$billing_detail_qty["$i"]=$rs_one[billing_detail_qty];
$billing_detail_unit["$i"]=$rs_one[billing_detail_unit];
$billing_detail_total["$i"]=$rs_one[billing_detail_total];
			?><?=$i?>
		
        html +=  '<input name="no[<?=$i?>]" type="text" id="no[<?=$i?>]" value="<?=$billing_detail_no["$i"]?>"  size="5" />&nbsp;';
		html +=  '<input name="description[<?=$i?>]" type="text" id="description[<?=$i?>]" value="<?=$billing_detail_description["$i"]?>"size="50" />&nbsp;';
        html += '<input type ="text" name="qty[<?=$i?>]" id="qty_<?=$i?>" value="<?=$billing_detail_qty["$i"]?>" size="7" autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="detail_unit[<?=$i?>]" id="price_<?=$i?>" size="7"  value="<?=$billing_detail_unit["$i"]?>"  autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="total[<?=$i?>]"  id="total_<?=$i?>"    value="<?=$billing_detail_total["$i"]?>"size="7"/>&nbsp;';
		html += '<input type ="hidden" name="billing_details_id[<?=$i?>]"  id="billing_details_id[<?=$i?>]"   value="<?=$billing_detail_id["$i"]?>" size="7"/>';
		html += '</br>';
		$("#form14").html(html);
  <?  } ?>
  <? $i1=$i+1?>
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
        $("#billing_amount_en").val(all_result); 
		$("#billing_amount_vat").val(all_results.toFixed(0));        
		       
		 $("#billing_amount_sum").val(all_result_sum.toFixed(0));        
                
    });
});
    </script>
                    <div id="form14"></div></td>
                <td width="18%" valign="top"></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2"><hr/></td>
        </tr>
        <tr>
          <td></td>
          <td><table width="100%" bbilling="0">
              <tr>
                <td width="52%" rowspan="3" align="center">
                    <div  style="color:#000" id="bid_tel">
                      <?=$billing_amount_th?>
                  </div></td>
                <td width="16%"><div align="right">ราคารวม</div></td>
                <td width="32%"><?=$billing_amount_en?></td>
              </tr>
              <tr>
                <td><div align="right">ภาษีมูลค่าเพิ่ม 7 %</div></td>
                <td><?=$billing_amount_vat?></td>
              </tr>
              <tr>
                <td><div align="right">รวมมูลค่าทั้งสิ้น</div></td>
                <td><?=$billing_amount_sum?></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td></td>
          <td><table width="100%" bbilling="0">
              <tr>
                <th width="152" valign="top" ><div align="right">ผู้อนุมัติ :</div></th>
                <th width="720" ><div align="left">
                      <?=$billing_approve?>
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
						from    billing_comment
						where 
						   	   billing_id = '".$billing_id."' ORDER  BY billing_comment_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			while($rs_one = mysql_fetch_array($get_one))
			{ 
			$i++;
						$tel_one2 = "select  * 
						from    billing_comment_re
						where  billing_comment_id = '".$rs_one['billing_comment_publish']."' and billing_com_re_publish = '".$_SESSION["str_admin_email"]."'";
			$get_one2 = mysql_query($tel_one2);			
			$Num_Rows2 = mysql_num_rows($get_one2);
			if ($Num_Rows2==0){
						if($rs_one[billing_comment_publish]!="$_SESSION[str_admin_email]"){

			$tellway  = "INSERT INTO billing_comment_re VALUES(";
		$tellway .= "0
					,'".$_SESSION["str_admin_email"]."'
					,'$rs_one[billing_comment_id]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
			}
			}
			$tel_one1 = "select  * 
						from    admin
						where  admin_email = '".$rs_one['billing_comment_publish']."'";
			$get_one1 = mysql_query($tel_one1);
			$rs_one1 = mysql_fetch_array($get_one1);
			echo $rs_one1[admin_name];
			?>
                    <br/>
                    <? if ($rs_one['billing_comment_publish'] == $_SESSION["str_admin_email"]) { ?>
                    <textarea name="billing_comment_detail[<?=$i?>]2" id="billing_comment_detail[<?=$i?>]2" cols="45" rows="5"><?=$rs_one['billing_comment_detail']?>
    </textarea>
                    <input type="hidden" name="billing_comment_id[<?=$i?>]2" id="billing_comment_id[<?=$i?>]2" value="<?=$rs_one['billing_comment_id']?>" />
                    <input type="hidden" name="billing_comment_publish[<?=$i?>]2" id="billing_comment_publish[<?=$i?>]2" value="<?=$rs_one['billing_comment_publish']?>" />
                    <br/>
                    <? }else{ 
                      echo $rs_one['billing_comment_detail'].'<br/>';
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
						   	   status_b_id = '$billing_publish'  ";
				
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
          <td><input type="button" name="Submit6" value="กลับ" onclick="window.location='billing1.php';"/></td>
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
	  <table width="100%" bbilling="0" cellspacing="0">
        <?
		// query area
		$i=0;
		
		if( $_SESSION["str_search"] ==""){
			$tel = "select * 
					from    billing
					 ";
		} else {
		$search=$_GET[search1];
			$tel = "select * 
					from    billing
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
						$_GET['stack'] = "billing_num";
					} else {
						$_GET['stack'] = "billing_num";
					}
				}
			
			
				$tel .=" order  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>
        <thead>
          <tr>
            <td width="8%">สถานะ</td>
            <td width="11%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=billing_num&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">ใบวางบิล</a>
                <? }else { ?>
                <a href="?stack=billing_num&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">ใบวางบิล</a>
                <? } ?>            </td>
            <td width="32%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=billing_co&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">บริษัท </a>
                <? }else { ?>
                <a href="?stack=billing_co&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">บริษัท </a>
                <? } ?>            </td>
            <td width="19%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=billing_date1&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
                <? }else { ?>
                <a href="?stack=billing_date1&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
                <? } ?>            </td>
            <td width="12%"><a href="?stack=admin_publish&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">สถานะ</a></td>
            <td width="5%">รายงาน</td>
            <td width="4%">พิมพ์</td>
            <td width="5%">แก้ไข</td>
           <!-- <td width="4%">ลบ</td> -->
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
						from     billing_comment
						where 
						   	    billing_id = '".$rs[billing_id]."' and  billing_comment_publish != '".$_SESSION["str_admin_email"]."' ORDER  BY billing_comment_id   ASC";
			$get_one = mysql_query($tel_one);
			$num_check1  = mysql_num_rows($get_one);
			$i=0;
			if ($num_check1 > 0){
			while($rs_one = mysql_fetch_array($get_one))
			{ $i++;
			$tel_one5 = "select  * 
						from    billing_comment_re
						where   billing_comment_id = '".$rs_one['billing_comment_id']."' and billing_com_re_publish ='".$_SESSION["str_admin_email"]."' ";
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
            <td><?=$rs['billing_id']?>            </td>
            <td><?=$rs['billing_co']?>
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
            <td><?=dateform($rs['billing_date1'])?>
                <br/>
                <font class="text_small_gray">By
                  <?=$rs['billing_poster']?>
                </font> </td>
            <td><?  
			$tel_one = "select  * 
						from    status_billing
						where 
						   	   status_b_id = '$rs[billing_publish]' and status_b_publish ='Yes' order by status_b_id  ASC";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{ echo"$rs_one[status_b_name]"; } ?></td>
            <td><a href="?view=true&amp;billing_id=<?=$rs["billing_id"];?>"><img src="images/view.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/></a><a href="?fix=true&amp;billing_id=<?=$rs["billing_id"];?>"></a> </td>
            <td><a href="MPDF56/examples/re_billing1.php?billing_id=<?=$rs["billing_id"];?>" target="_blank"> <img src="images/view.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
            <td><a href="?fix=true&amp;billing_id=<?=$rs["billing_id"];?>"> <img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
           <!-- <td><a href="?action=del&amp;billing_id=<?=$rs["billing_id"];?>" onclick="return confirm('ยืนยันการลบ ใบวางบิล<?=$rs["billing_id"]?>')"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" bbilling="0" /></a> </td>
          </tr> -->
          <?
			
		}
	?>
        </tbody>
      </table>
	  <hr/>
	<div style="float:right"><img src="images/f_poll.gif" /> = อ่านแล้ว <img src="images/f_hot.gif"/> = ยังไม่ได้อ่าน</div>
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
	$("#billing_attn1").msDropdown();
	$("#bid_id").msDropdown();
	$("#billing_attn").msDropdown();
	$("#billing_from").msDropdown();
	$("#billing_approve").msDropdown();
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
