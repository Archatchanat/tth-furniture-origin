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
	}?>
    
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
	// start insert ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="insert" )
	{
		$_POST['admin_email'] = trim($_POST['admin_email']);
		
		// check email duplicate ------------------------------------------------------------------------------------------------
		$tel_check 	= "select * from orderid where orderid_id = '".$_POST['orderid_id']."'";
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
		 $orderid_amount_th=num2string("$_POST[orderid_amount_sum]");
	
		$tellway  = "INSERT INTO orderid VALUES(";
		$tellway .= "'$_POST[orderid_num]'
					,'$_POST[orderid_id]'
					,'$_POST[customers_p_id]'
					,'$_POST[customers_id]'
					,'$_POST[orderid_attn]'
					,'$_POST[orderid_co]'
					,'$_POST[orderid_web]'
					,'$_POST[orderid_tel]'
					,'$_POST[orderid_fax]'
					,'$_POST[orderid_mail]'
					,'$_POST[orderid_taxpayer]'
					,'$_POST[orderid_date]'
					,'$_POST[bid_name]'
					,'$_POST[bid_tel]'
					,'$_POST[bid_tel2]'
					,'$_POST[bid_fax1]'
					,'$_POST[bid_email1]'
					,'$_POST[orderid_detail1]'
					,'$orderid_amount_th'
					,'$_POST[orderid_amount_en]'
					,'$_POST[orderid_amount_sum]'
					,'$_POST[orderid_detail]'
					,'".$_SESSION["str_admin_email"]."'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,NOW()
					,'$_POST[orderid_publish]'
					,'Yes'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		$orderid_num=mysql_insert_id();
		 $j1=0;
		while($j1<=20){
			$j1++;
			if($_POST["description"][$j1]!=""){
				if ($_POST["price"][$j1]!=""){
					
					$price = "'".$_POST["price"][$j1]."'";
					
				}else{
					$price = 'NULL';
					
				}
				
				if ($_POST["total"][$j1]!=""){
					
					$total = "'".$_POST["total"][$j1]."'";
				}else{
					$total = 'NULL';
				}
				
				
				$tellway  = "INSERT INTO order_detail VALUES('0','".$_POST["no"][$j1]."','".$_POST["name"][$j1]."','".$_POST["description"][$j1]."','".$_POST["qty"][$j1]."','".$_POST["detail_unit"][$j1]."',$price,$total,'$orderid_num')";
		$dbquery = mysql_query($tellway);
				
			}		
			}
		 if($_POST["orderid_comment_detail"]!=""){
				$tellway  = "INSERT INTO orderid_comment VALUES('0','".$_POST["orderid_comment_detail"]."','".$_SESSION["str_admin_email"]."',NOW(),'$orderid_num')";
		$dbquery = mysql_query($tellway);
				
			}	
			
			$tel_one = "select  * 
						from    customers_orderid
						where 
						   	   customers_id = '".$_SESSION["str_customers_id"]."' and customers_orderid_publish='1'";
				
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
				
				if($_POST[checkbox1]=="1"){
					$orderid_ids = substr ($_POST[orderid_id],3,99);
					$picture="MyPDF/Quotation.pdf"; //file ต้นฉบับ
					$Quotation ="Quotation"."$orderid_ids".".pdf";
					$image="MyPDF/$Quotation";// file ใหม่
					$copied=copy($picture,$image);
					include "mail.php";
	
				}
			
		echo "<script language=\"javascript\">";
		echo "window.open('MPDF56/examples/example01_basic.php?orderid_id=$_POST[orderid_id]', 'example01_basic')";
		echo "</script>";
		echo "<script language=\"JavaScript\">";
		echo "window.location='billing.php';";
		echo "</script>";
    }
	// end__ insert ----------------------------------------------------------------------------------------------------------------------
	
	// start update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="save" and $_POST["publish"]=="No")
	{	
		$orderid_amount_th=num2string("$_POST[orderid_amount_sum]");
		
		$sql_up = "update orderid set
					orderid_publish1 ='No'
					where orderid_num  = '".$_POST['orderid_num']."'";
		$dbquery = mysql_query($sql_up);
		
		$tellway  = "INSERT INTO orderid VALUES(";
		$tellway .= "0
					,'$_POST[orderid_id]'
					,'$_POST[customers_p_id]'
					,'".$_SESSION["str_customers_id"]."'
					,'$_POST[orderid_attn]'
					,'$_POST[orderid_co]'
					,'$_POST[orderid_web]'
					,'$_POST[orderid_tel]'
					,'$_POST[orderid_fax]'
					,'$_POST[orderid_mail]'
					,'$_POST[orderid_taxpayer]'
					,'$_POST[orderid_date]'
					,'$_POST[bid_name]'
					,'$_POST[bid_tel]'
					,'$_POST[bid_tel2]'
					,'$_POST[bid_fax1]'
					,'$_POST[bid_email1]'
					,'$_POST[orderid_detail1]'
					,'$orderid_amount_th'
					,'$_POST[orderid_amount_en]'
					,'$_POST[orderid_amount_sum]'
					,'$_POST[orderid_detail]'
					,'".$_SESSION["str_admin_email"]."'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,NOW()
					,'$_POST[orderid_publish]'
					,'Yes'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		$orderid_num=mysql_insert_id();
		
		
		$j1=0;
		while($j1<=20){
			$j1++;
			if($_POST["description"][$j1]!=""){
				if ($_POST["price"][$j1]!=""){
					
					$price = "'".$_POST["price"][$j1]."'";
					
				}else{
					$price = 'NULL';
					
				}
				
				
				if ($_POST["total"][$j1]!=""){
					
					$total = "'".$_POST["total"][$j1]."'";
				}else{
					$total = 'NULL';
				}
				
				
				$tellway  = "INSERT INTO order_detail VALUES('0','".$_POST["no"][$j1]."','".$_POST["name"][$j1]."','".$_POST["description"][$j1]."','".$_POST["qty"][$j1]."','".$_POST["detail_unit"][$j1]."',$price,$total,'$orderid_num')";
				
		$dbquery = mysql_query($tellway);
				
			}		
			}
			
	if($_POST["orderid_comment_details"]!=""){
				$tellway  = "INSERT INTO orderid_comment VALUES('0','".$_POST["orderid_comment_details"]."','".$_SESSION["str_admin_email"]."',NOW(),'".$_POST["orderid_id"]."')";
		$dbquery = mysql_query($tellway);
			}
			
		$j=0;
		while($j<=$_POST['comment_num']){
			$j++;
			if($_POST["orderid_comment_publish"][$j]=="$_SESSION[str_admin_email]"){
				
			$sql_del= "update  orderid_comment  set orderid_comment_detail='".$_POST["orderid_comment_detail"][$j]."' where orderid_comment_id='".$_POST["orderid_comment_id"][$j]."'";
				$dbquery_del = mysql_query($sql_del);
			}
			}	
			$tel_one = "select  * 
						from    customers_orderid
						where 
						   	   customers_id = '".$_SESSION["str_customers_id"]."' and customers_orderid_publish='1'";
				
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
				
				if($_POST[checkbox1]=="1"){
					$orderid_ids= substr ($_POST[orderid_id],3,99);
					$picture="MyPDF/Quotation.pdf"; //file ต้นฉบับ
					$image="MyPDF/Quotation"."$orderid_ids".".pdf";// file ใหม่
					$copied=copy($picture,$image);
					include "mail.php";
		
				}
				echo "<script language=\"javascript\">";
		echo "window.open('MPDF56/examples/example01_basic.php?orderid_id=$_POST[orderid_id]', 'example01_basic')";
		echo "</script>";			
		echo "<script language='JavaScript'>";
		echo "window.location='billing.php';";
		echo "</script>";
    }
	if($_GET["action"]=="save" and $_POST["publish"]=="Yes")
	{
	/////
	$sql_up = "update orderid set
					orderid_publish ='".$_POST['orderid_publish']."'
					where orderid_num  = '".$_POST['orderid_num']."'";
		$dbquery = mysql_query($sql_up);
	if($_POST["orderid_comment_details"]!=""){
				$tellway  = "INSERT INTO orderid_comment VALUES('0','".$_POST["orderid_comment_details"]."','".$_SESSION["str_admin_email"]."',NOW(),'".$_POST["orderid_num"]."')";
		$dbquery = mysql_query($tellway);
			}
			
		$j=0;
		while($j<=$_POST['comment_num']){
			$j++;
			if($_POST["orderid_comment_publish"][$j]=="$_SESSION[str_admin_email]"){
			$sql_del= "update  orderid_comment  set orderid_comment_detail='".$_POST["orderid_comment_detail"][$j]."' where orderid_comment_id='".$_POST["orderid_comment_id"][$j]."'";
				$dbquery_del = mysql_query($sql_del);
			}
			}
			if($_POST[checkbox1]=="1"){
				$orderid_ids = substr ($_POST[orderid_id],3,99);
					$picture="MyPDF/Quotation.pdf"; //file ต้นฉบับ
					$Quotation ="Quotation"."$orderid_ids".".pdf";
					$image="MyPDF/$Quotation";// file ใหม่
			include "mail.php";

				
				}	
	echo "<script language='JavaScript'>";
		echo "window.location='billing.php';";
		echo "</script>";
	}	
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	// start insert ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="copy" )
	{
		$_POST['admin_email'] = trim($_POST['admin_email']);
		
		// check email duplicate ------------------------------------------------------------------------------------------------
		$tel_check 	= "select * from orderid where orderid_id = '".$_POST['orderid_id']."'";
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
		 $orderid_amount_th=num2string("$_POST[orderid_amount_sum]");
	
		$tellway  = "INSERT INTO orderid VALUES(";
		$tellway .= "'$_POST[orderid_num]'
					,'$_POST[orderid_id]'
					,'$_POST[customers_p_id]'
					,'".$_SESSION["str_customers_id"]."'
					,'$_POST[orderid_attn]'
					,'$_POST[orderid_co]'
					,'$_POST[orderid_web]'
					,'$_POST[orderid_tel]'
					,'$_POST[orderid_fax]'
					,'$_POST[orderid_mail]'
					,'$_POST[orderid_taxpayer]'
					,'$_POST[orderid_date]'
					,'$_POST[bid_name]'
					,'$_POST[bid_tel]'
					,'$_POST[bid_tel2]'
					,'$_POST[bid_fax1]'
					,'$_POST[bid_email1]'
					,'$_POST[orderid_detail1]'
					,'$orderid_amount_th'
					,'$_POST[orderid_amount_en]'
					,'$_POST[orderid_amount_sum]'
					,'$_POST[orderid_detail]'
					,'".$_SESSION["str_admin_email"]."'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,NOW()
					,'$_POST[orderid_publish]'
					,'Yes'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		$orderid_num=mysql_insert_id();
		 $j1=0;
		while($j1<=20){
			$j1++;
			if($_POST["description"][$j1]!=""){
				$tellway  = "INSERT INTO order_detail VALUES('0','".$_POST["no"][$j1]."','".$_POST["name"][$j1]."','".$_POST["description"][$j1]."','".$_POST["qty"][$j1]."','".$_POST["detail_unit"][$j1]."','".$_POST["price"][$j1]."','".$_POST["total"][$j1]."','$orderid_num')";
		$dbquery = mysql_query($tellway);
				
			}		
			}
		 if($_POST["orderid_comment_detail"]!=""){
				$tellway  = "INSERT INTO orderid_comment VALUES('0','".$_POST["orderid_comment_detail"]."','".$_SESSION["str_admin_email"]."',NOW(),'$orderid_num')";
		$dbquery = mysql_query($tellway);
				
			}	
			
			$tel_one = "select  * 
						from    customers_orderid
						where 
						   	   customers_id = '".$_SESSION["str_customers_id"]."' and customers_orderid_publish='1'";
				
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
				
				if($_POST[checkbox1]=="1"){
					$orderid_ids = substr ($_POST[orderid_id],3,99);
					$picture="MyPDF/Quotation.pdf"; //file ต้นฉบับ
					$Quotation ="Quotation"."$orderid_ids".".pdf";
					$image="MyPDF/$Quotation";// file ใหม่
					include "mail.php";
		
				}
		echo "<script language=\"javascript\">";
		echo "window.open('MPDF56/examples/example01_basic.php?orderid_id=$_POST[orderid_id]', 'example01_basic')";
		echo "</script>";
		echo "<script language=\"JavaScript\">";
		echo "window.location='billing.php';";
		echo "</script>";
    }
	// end__ insert ----------------------------------------------------------------------------------------------------------------------
	
	if($_GET["action"]=="del")
	{
		
		
		$sql_del= "delete from orderid where orderid_id ='".$_GET["orderid_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		
		$sql_del2= "delete from order_detail where orderid_id ='".$_GET["orderid_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		echo "<script language='JavaScript'>";
		echo "window.location=\"billing.php\";";
		echo "</script>";
		}
		if($_GET["action"]=="del1")
	{
		
		$sql_del2= "delete from order_detail where order_detail_id ='".$_GET["order_detail_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		
		
		$tel_check 	= "select order_detail_total from order_detail where orderid_num = '".$_GET['orderid_num']."'";
		$get_check  = mysql_query($tel_check);
		while($rs_one = mysql_fetch_array($get_check))
			{
			$billing_detail_total=+ $rs_one[order_detail_total];
			}
		
		$billing_amount_sum=number_format(($billing_detail_total*0.07)+$billing_detail_total, 0,'.','');
		$billing_amount_vat=number_format($billing_detail_total*0.07, 0,'.','');
		
		$billing_amount_th= num2string("$billing_amount_sum");	
		
		$sql_up = "update order set
					 order_amount_th ='$billing_amount_th'
					,order_amount_en ='$billing_detail_total'
					,order_amount_vat ='$billing_amount_vat'
					,order_amount_sum ='$billing_amount_sum'
					,order_updater ='".$_SESSION["str_admin_email"]."'
					,order_update =NOW()
					where order_id  = '".$_GET['billing_id']."'";
		$dbquery = mysql_query($sql_up);
		
		echo "<script language='JavaScript'>";
		echo "window.location=\"billing.php?fix=true&orderid_id=$_GET[orderid_id]&orderid_num=$_GET[orderid_num]\";";
		echo "</script>";
		}
			if($_GET["action"]=="del2")
	{
		
		$sql_del2= "delete from orderid_comment where orderid_comment_id ='".$_GET["orderid_comment_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		$sql_del2= "delete from orderid_comment_re where orderid_comment_id ='".$_GET["orderid_comment_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		echo "<script language='JavaScript'>";
		echo "window.location=\"billing.php?fix=true&orderid_id=$_GET[orderid_id]\";";
		echo "</script>";
		}
?>

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

<script language="JavaScript">
	function checkvalue(action){
		filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		if(form1.bid_id.value == ""){
			alert("กรุณาเลือก จาก  ");
			form1.bid_id.focus();
			return false
		}
		if(form1.orderid_detail1.value == ""){
			alert("กรุณาเลือก กรุณาเลือกหัวเอกสาร  ");
			form1.orderid_detail1.focus();
			return false
		}
		
		if(form1.orderid_amount_en.value == ""){
			alert("กรุณากรอก ราคารวม");
			form1.orderid_amount_en.focus();
			return false
		}
		if(form1.orderid_amount_sum.value == ""){
			alert("กรุณากรอก รวมมูลค่าทั้งสิ้น");
			form1.orderid_amount_sum.focus();
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
 <script src="js/jquery-1.8.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/dd.css" />
<script src="js/jquery.dd.min.js"></script>
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
		
			
			<form method="get" action="billing.php" name="form2" onSubmit="return checkvalue2()">
			  <table width="100%">
                <tr>
                  <td width="34%"> ออกใบเสนอราคา :
                  <input name="button" type="button" value="+ เพิ่มข้อมูล" onclick="window.location='billing_customers.php';"/></td>
                  <td width="47%" align="right">ค้นหา
                    <input name="search" type="text" id="search" value="<?=$_SESSION["str_search"]?>" />
                    เลือก
                    <select name="search1" id="search1">
                     
                      <option value="orderid_id" <?php if (!(strcmp($_GET[search1], "orderid_id"))) {echo "selected=\"selected\"";} ?>>ใบเสนอราคา</option>
                   	  <option value="orderid_co" <?php if (!(strcmp($_GET[search1], "orderid_co"))) {echo "selected=\"selected\"";} ?>>บริษัท</option>
                   	  <option value="orderid_attn" <?php if (!(strcmp($_GET[search1], "orderid_attn"))) {echo "selected=\"selected\"";} ?>>เรียน</option>
                    
                  </select></td>
                  <td width="9%"><input type="submit" name="Submit3" value="ตกลง" />
                  </td>
                  <td width="10%"> |
                    <input type="button" name="Submit2"   value="ทั้งหมด" onclick="window.location='billing.php?all=true';"/>
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
			$tel_auto_rank = "select orderid_id from orderid ORDER  BY orderid_num DESC LIMIT 0,1";
			$get_auto_rank = mysql_query($tel_auto_rank);
			$rs_one_rank = mysql_fetch_array($get_auto_rank);
			$rank_rows = mysql_fetch_array($get_auto_rank);
		$orderid_idts= substr ($rs_one_rank[orderid_id],3,2);
		
		$orderid_idts1= date('y')+43;
		if($orderid_idts1>$orderid_idts){
		$orderid_id="Quo";
		$orderid_id.="$orderid_idts1";
		$orderid_id.="-1";
		}else{
		$orderid_idt = substr ($rs_one_rank[orderid_id],6,5);
		$orderid_id="Quo";
		$orderid_id.="$orderid_idts";
		$orderid_id.="-";
		$orderid_idt=$orderid_idt+1;
		$orderid_id.="$orderid_idt";
		}
	?>
	<form name="form1" action="?action=insert" method="post" onSubmit="return checkvalue('')" enctype="multipart/form-data">
<table width="100%">
			<tr>
				<td colspan="2"><table width="100%" border="0">
                  <tr>
                    <td><div align="right">ใบเสนอราคา::</div></td>
                    <td> <input name="orderid_id" class="textinputdotted" type="text" id="orderid_id" size="40"  value="<?=$orderid_id?>"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="11%"> 
					<div align="right">เรียน :</div></td>
                    <td width="38%">  
                     <? $tel_one4 = "select  * from    customers where customers_id='".$_SESSION["str_customers_id"]."'
						";
			$get_one4 = mysql_query($tel_one4);
			$rs_one4 = mysql_fetch_array($get_one4);
			?>  
            <select name="orderid_attn" style="width:300px" id="orderid_attn">
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
                      <input type="hidden" name="customers_p_id"  id="customers_p_id" value="<?=$_GET['customers_p_id']?>" />                    					                      <input type="hidden" name="customers_id"  id="customers_id" value="<?=$_GET['customers_id']?>" /></td>
                    <td width="9%"><div align="right">วันที่ :</div></td>
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

<input name="orderid_date" class="textinputdotted" type="text" id="dateInput" value="" size="20"/></td>
                  </tr>
                  <tr>
                    <td ><div align="right">บริษัท :</div></td>
                    <td><input name="orderid_co" type="text" id="orderid_co" size="50" value="<?=$rs_one4['customers_com']?>" />
                    <div  style="color:#000" id="customers_com1"></div></td>
                    <td><div align="right">จาก :</div></td>
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
<select name="bid_id" style="width:200px" id="bid_id">
  <option value="">
  กรุณาเลือก  </option>
  <? $tel_one = "select  * 
						from    bid
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option value="<?=$rs_one['bid_id']?>">
  <?=$rs_one['bid_name']?>
  </option>
  <? } ?>
</select>
<input type="hidden" name="bid_name"  id="bid_name" />
</td>
                  </tr>
                  <tr>
                    <td><div align="right">เว็บไซต์ :</div></td>
                    <td><input name="orderid_web" type="text" id="orderid_web" value="<?=$rs_one4['customers_web']?>" size="50" />
                    <div  style="color:#000" id="customers_web"> </div></td>
                    <td><div align="right">มือถือ :</div></td>
                    <td><div  style="color:#000" id="bid_tel">
                     
</div> 
                    <input type="hidden" name="bid_tel" id="bid_tels" /></td>
                  </tr>
                  <tr>
                    <td><div align="right">โทรศัพท์ :</div></td>
                    <td><input name="orderid_tel" type="text" id="orderid_tel" value="<?=$rs_one4['customers_tel']?>" size="50" />
                    <div  style="color:#000" id="customers_tel"> </div></td>
                    <td><div align="right">โทรศัพท์ :</div></td>
                    <td><div  style="color:#000" id="bid_tel2"> </div>
                     <input type="hidden" name="bid_tel2" id="bid_tels2" />                    </td>
                  </tr>
                  <tr>
                    <td><div align="right">แฟกซ์ :</div></td>
                    <td><div  style="color:#000" id="customers_fax"><input name="orderid_fax" type="text" id="orderid_fax" value="<?=$rs_one4['customers_fax']?>" size="50" /> </div></td>
                    <td><div align="right">แฟกซ์ :</div></td>
                    <td><div  style="color:#000" id="bid_fax"> </div> <input type="hidden" name="bid_fax1" id="bid_faxs" /></td>
                  </tr>
                  <tr>
                    <td><div align="right">อีเมล์ :</div></td>
                    <td><input name="orderid_mail" type="text" id="orderid_mail"  value="<?=$rs_one4['customers_email']?>" size="50" />
                    <div  style="color:#000" id="customers_email"> </div></td>
                    <td><div align="right">อีเมล์ :</div></td>
                    <td><div  style="color:#000" id="bid_email"> </div>
                    <input type="hidden" name="bid_email1" id="bid_emails" /></td>
                  </tr>
                  <tr>
                    <td align="right">เลขผู้เสียภาษี::</td>
                    <td><input name="orderid_taxpayer" type="text" id="orderid_taxpayer" size="50" value="<?=$rs_one4['customers_num']?>"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table></td>
			</tr>
			<tr>
              <td width="8%"></td>
			  <td width="92%">
			    <select name="orderid_detail1" id="select">
		        <option value="">
  กรุณาเลือกหัวเอกสาร  </option>
  <? $tel_one = "select  * 
						from    ex
						";
				
			$get_one = mysql_query($tel_one);
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option value="<?=$rs_one['ex_name']?>">
  <?=$rs_one['ex_name']?>
  </option>
  <? } ?>
</select>
		      </td>
		  </tr>
			<tr>
			  <td colspan="2">
              <table width="917" border="0" cellspacing="0">
                <tr>
                  <th  class="a1"  scope="col">No.</th>
                  <th class="a2" align="center">NAME</th>
                  <th class="a3" scope="col" align="center">Description</th>
                  <th class="a4" scope="col" >Qty.</th>
                  <th class="a5" scope="col">Unit</th>
                  <th class="a6" scope="col">Price</th>
                  <th class="a7" scope="col"><div  align="left">Total</div></th>
                  <th class="a8"  scope="col">&nbsp;</th>
                </tr>
 <script type="text/javascript">
$(document).ready(function(){
    var i = 1; var cnt = 20; var html = '';
    //create object
    for(i=1;i<=cnt;i++){
		
        html +=  '<input name="no['+i+']" type="text" id="no['+i+']" class="b1"/>&nbsp;';
		html +=  '<input name="name['+i+']" type="text" id="name['+i+']" class="b2" />&nbsp;';
		html +=  '<input name="description['+i+']" type="text" id="description['+i+']"class="b3" />&nbsp;';
        html += '<input type ="text" name="qty['+i+']" id="qty_'+i+'"  class="b4" autocomplete="off"/>&nbsp;';
		html +=  '<input name="detail_unit['+i+']" type="text" id="detail_unit['+i+']" class="b5"" />&nbsp;';
        html += '<input type ="text" name="price['+i+']" id="price_'+i+'" class="b6" autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="total['+i+']"   id="total_'+i+'" class="b7"/>&nbsp;';
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
        //update all value
        $("#orderid_amount_en").val(all_result);        
		 $("#orderid_amount_sum").val(all_result);        
                
    });
});
</script> 
           
 <tr>
                  <td colspan="8"><div id="form14"></div></td>
                  </tr>
               
                
              </table>              </td>
		  </tr>
			<tr>
			  <td colspan="2"><hr/></td>
		  </tr>
			<tr>
              <td></td>
			  <td><table width="100%" border="0">

                <tr>
                  <td width="52%" rowspan="2" align="center"><div  style="color:#000" id="bid_tel5">
   
                     
</div><input type="hidden" name="orderid_amount_th" id="orderid_amount_th" /></td>
                  <td width="16%"><div align="right">ราคารวม</div></td>
                  <td width="32%"> <input type="text" name="orderid_amount_en" id="orderid_amount_en" /></td>
                </tr>
                <tr>
                  <td><div align="right">รวมมูลค่าทั้งสิ้น</div></td>
                  <td><input type="text" name="orderid_amount_sum" id="orderid_amount_sum" /></td>
                </tr>
              </table></td>
		  </tr>
			<tr>
			  <td></td>
			  <td valign="top"><table width="100%" border="0">
                <tr>
                  <th width="185" valign="top" ><div align="left">เงื่อนไขการชาระเงิน:</div></th>
                  <th width="647" ><div align="left">
                      <?php 
 						include("FCKeditor/fckeditor.php");
						$oFCKeditor = new FCKeditor('orderid_detail');
						$oFCKeditor->BasePath = 'FCKeditor/';
						$oFCKeditor->Width  = '300' ;
						$oFCKeditor->Height = '150' ;
						$oFCKeditor->ToolbarSet = 'write4';
						$oFCKeditor->Create(); 
					?>
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
                    <textarea name="orderid_comment_detail" id="orderid_comment_detail" cols="45" rows="5"></textarea>
                  </div></th>
                </tr>
              </table></td>
		  </tr>
			<tr>
              <td align="right">สถานะ ::</td>
			  <td>
            <?  
			$tel_one = "select  * 
						from    status_billing
						where 
						   	   status_b_s = '1' and status_b_publish ='Yes' order by status_b_id  DESC";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
             echo "<input type=\"radio\" name=\"orderid_publish\" value=\"$rs_one[status_b_id]\" />$rs_one[status_b_name]";
				echo '&nbsp';
				}?>
			 </td>
		  </tr>
			<tr>
			  <td></td>
			  <td>ส่งใบเสนอราคาทางเมล์::
              <input name="checkbox1" type="checkbox" id="checkbox1" value="1" /></td>
		  </tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="Submit" value="ยืนยันข้อมูล" >
					<input type="button" name="Submit" value="ยกเลิก" onClick="window.location='billing.php';"/></td>
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
						from    orderid
						where 
						   	   orderid_num = '".$_GET['orderid_num']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
			
				$orderid_num  	= $rs_one['orderid_num'];
				$orderid_id  	= $rs_one['orderid_id'];
				$customers_id  	= $rs_one['customers_id'];
				$customers_p_id = $rs_one['customers_p_id'];
				$orderid_attn  	= $rs_one['orderid_attn'];
				$orderid_co   	= $rs_one['orderid_co'];
				$orderid_web  	= $rs_one['orderid_web'];
				$orderid_tel  	= $rs_one['orderid_tel'];
				$orderid_fax  	= $rs_one['orderid_fax'];
				$orderid_mail  	= $rs_one['orderid_mail'];
				$orderid_taxpayer  	= $rs_one['orderid_taxpayer'];
				$orderid_date  	= $rs_one['orderid_date'];
				$orderid_from  	= $rs_one['orderid_from'];
				$orderid_tel1  	= $rs_one['orderid_tel1'];
				$orderid_tel2  	= $rs_one['orderid_tel2'];
				$orderid_fax1  	= $rs_one['orderid_fax1'];
				$orderid_mail1  	= $rs_one['orderid_mail1'];
				$orderid_detail1  	= $rs_one['orderid_detail1'];
				$orderid_amount_th  	= $rs_one['orderid_amount_th'];
				$orderid_amount_en  	= $rs_one['orderid_amount_en'];
				$orderid_amount_sum  	= $rs_one['orderid_amount_sum'];
				$orderid_detail  	= $rs_one['orderid_detail'];
				$orderid_poster  	= $rs_one['orderid_poster'];
				$orderid_updater  	= $rs_one['orderid_updater'];
				$orderid_date1  	= $rs_one['orderid_date1'];
				$orderid_update  	= $rs_one['orderid_update'];
				$orderid_publish  	= $rs_one['orderid_publish'];
				
				
				
				
			}
	?>	
	<form name="form1" action="?action=save" method="post" onSubmit="return checkvalue('fix')" enctype="multipart/form-data">
	<div class="text_detail">
		รายละเอียด : สร้างวันที่ : <?=dateform($orderid_date1)?> [ <?=$orderid_poster?> ] , แก้ไขล่าสุดวันที่ <?=dateform($orderid_update)?> , [ <?=$orderid_updater?> ]
	</div>
	<table id="myTable" bgcolor="#E6E6E6" width="100%">
		<tr>
			<td width="7%"></td>
			<td width="93%">
				<input type="hidden" name="orderid_id" 		value="<?=$orderid_id?>">
				<input type="hidden" name="orderid_num"  	value="<?=$orderid_num?>">
				<input type="submit" name="Submit"   		value="บันทึกข้อมูล" >
			  <input type="button" name="Submit4" value="ยกเลิก" onclick="window.location='billing.php';"/></td>
		</tr>
		<tr>
			<td colspan="2"><table width="100%" border="0">
                  <tr>
                    <td><div align="right">ใบเสนอราคา::</div></td>
                    <td> 
                    <input name="orderid_id" type="text" id="orderid_id"  readonly="readonly" value="<?=$orderid_id?>" size="50" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="11%"><div align="right">เรียน :</div></td>
                    <td width="38%"><script type="text/javascript">
$(document).ready(function(){

	$("#orderid_attn1").change(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'sCusIDs=' +$("#orderid_attn1").val()
			})
			.success(function(result) { 

				var obj = jQuery.parseJSON(result);
				
					if(obj == '')
					{
						
						 $("#customers_com1").html('');
						 $("#orderid_co").val('');
						
					}
					else
					{
						  $.each(obj, function(key, inval) {

							  
							   $("#customers_com1").html(inval["customers_com"]);
							   $("#customers_email").html(inval["customers_email"]);
							   $("#customers_web").html(inval["customers_web"]);
							   $("#customers_tel").html(inval["customers_tel"]);
							   $("#customers_fax").html(inval["customers_fax"]);
								
							   $("#orderid_co").val(inval["customers_com"]);
							   $("#orderid_mail").val(inval["customers_email"]);
							   $("#customers_name").val(inval["customers_name"]);
							   $("#orderid_web").val(inval["customers_web"]);
							   $("#orderid_tel").val(inval["customers_tel"]);
							   $("#orderid_fax").val(inval["customers_fax"]);
							 
							 
				
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
				$orderid_attn  	= $rs_one['customers_name'];
				$orderid_co   	= $rs_one['customers_com'];
				$orderid_web  	= $rs_one['customers_web'];
				$orderid_tel  	= $rs_one['customers_tel'];
				$orderid_fax  	= $rs_one['customers_fax'];
				$orderid_mail  	= $rs_one['customers_email'];
				$orderid_taxpayer = $rs_one['customers_num'];
				$tel_one = "select  * from    customers_project where customers_p_id='".$_SESSION["str_customers_p_id"]."'
						";
			$get_one = mysql_query($tel_one);
			$rs_one = mysql_fetch_array($get_one);
				$customers_p_id  	= $rs_one['customers_p_id'];
				
			}
			?>
                     <? $tel_one4 = "select  * from    customers where customers_id='$customers_id'
						";
			$get_one4 = mysql_query($tel_one4);
			$rs_one4 = mysql_fetch_array($get_one4);
			?>  
            <select name="orderid_attn" style="width:300px" id="orderid_attn">
  <? $tel_one = "select  * 
						from    customers_detail  where   customers_id = '$rs_one4[customers_id]' order by customers_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option <?php if (!(strcmp($rs_one['customers_detail_name'], "$orderid_attn"))) {echo "selected=\"selected\"";} ?> value="<?=$rs_one['customers_detail_name']?>">
  <?=$rs_one['customers_detail_name']?>
  </option>
  <? } ?>
</select>
<? if($_GET['customers_id']==""){
	$_SESSION["str_customers_id"] = $rs_one4[customers_id];
	} ?>
            <a href="billing_customers.php?fix=true&amp;orderid_id=<?=$orderid_id;?>&orderid_num=<?=$_GET[orderid_num];?>"><img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/></a>
                      
                    <input type="hidden" name="customers_p_id"  id="customers_p_id" value="<?=$customers_p_id?>" /></td>
                    <td width="9%"><div align="right">วันที่ :</div></td>
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

<input name="orderid_date" class="textinputdotted" type="text" id="dateInput" value="<?=$orderid_date?>" size="20"/></td>
                  </tr>
                  <tr>
                    <td ><div align="right">บริษัท :</div></td>
                    <td><input name="orderid_co" type="text" id="orderid_co" value="<?=$orderid_co?>" size="50" /></td>
                    <td><div align="right">จาก :</div></td>
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
<select name="bid_id" style="width:200px" id="bid_id">
  <? $tel_one = "select  * 
						from    bid
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option value="<?=$rs_one['bid_id']?>" <?php if (!(strcmp($rs_one['bid_name'], "$orderid_from"))) {echo "selected=\"selected\"";} ?>>
  <?=$rs_one['bid_name']?>
  </option>
  <? } ?>
</select><input type="hidden" name="bid_name"  id="bid_name"  value="<?=$orderid_from?>"/></td>
                  </tr>
                  <tr>
                    <td><div align="right">เว็บไซต์ :</div></td>
                    <td><input name="orderid_web" type="text" id="orderid_web" value="<?=$orderid_web?>" size="50" /></td>
                    <td><div align="right">มือถือ :</div></td>
                    <td><div  style="color:#000" id="bid_tel"><?=$orderid_tel1?></div> 
                    <input name="bid_tel" type="hidden" id="bid_tels" value="<?=$orderid_tel1?>" /></td>
                  </tr>
                  <tr>
                    <td><div align="right">โทรศัพท์ :</div></td>
                    <td><input name="orderid_tel" type="text" id="orderid_tel" value="<?=$orderid_tel?>" size="50" /></td>
                    <td><div align="right">โทรศัพท์ :</div></td>
                    <td><div  style="color:#000" id="bid_tel2">
                      <?=$orderid_tel2?>
</div>
                     <input name="bid_tel2" type="hidden" id="bid_tels2" value="<?=$orderid_tel2?>" />                    </td>
                  </tr>
                  <tr>
                    <td><div align="right">แฟกซ์ :</div></td>
                    <td><input name="orderid_fax" type="text" id="orderid_fax" value="<?=$orderid_fax?>" size="50" /></td>
                    <td><div align="right">แฟกซ์ :</div></td>
                    <td><div  style="color:#000" id="bid_fax">
                      <?=$orderid_fax1?>
</div> 
                    <input name="bid_fax1" type="hidden" id="bid_faxs" value="<?=$orderid_fax1?>" /></td>
                  </tr>
                  <tr>
                    <td><div align="right">อีเมล์ :</div></td>
                    <td><input name="orderid_mail" type="text" id="orderid_mail" value="<?=$orderid_mail?>" size="50" /></td>
                    <td><div align="right">อีเมล์ :</div></td>
                    <td><div  style="color:#000" id="bid_email">
                      <?=$orderid_mail1?>
</div>
                    <input name="bid_email1" type="hidden" id="bid_emails" value="<?=$orderid_mail1?>" /></td>
                  </tr>
                  <tr>
                    <td align="right">เลขผู้เสียภาษี::</td>
                    <td><input name="orderid_taxpayer" type="text" id="orderid_taxpayer" value="<?=$orderid_taxpayer?>" size="50" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
            </table></td>
		</tr>
  			<tr>
    			<td align="right">&nbsp;</td>
    			<td align="left">
                <select name="orderid_detail1" id="orderid_detail1">
  <? $tel_one = "select  * 
						from    ex
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option value="<?=$rs_one['ex_name']?>" <?php if (!(strcmp($rs_one['ex_name'], "$orderid_detail1"))) {echo "selected=\"selected\"";} ?>>
  <?=$rs_one['ex_name']?>
  </option>
  <? } ?>
</select>               </td>
  			</tr>
		    <tr>
		      <td colspan="2"><table width="917" border="0" cellspacing="0">
                <tr>
                   <th  class="a1"  scope="col">No.</th>
                  <th class="a2" align="center">NAME</th>
                  <th class="a3" scope="col" align="center">Description</th>
                  <th class="a4" scope="col" >Qty.</th>
                  <th class="a5" scope="col">Unit</th>
                  <th class="a6" scope="col">Price</th>
                  <th class="a7" scope="col"><div  align="left">Total</div></th>
                  <th class="a8" scope="col">&nbsp;</th>
                </tr>
                <tr>
                  <td colspan="7"> <table  width="98%" border="0" cellspacing="0" >
                 
				  <script type="text/javascript">
$(document).ready(function(){
	var html = '';
    //create object
    <?
$tel_one = "select * from   order_detail where   orderid_num = '$orderid_num' order by order_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			$rank_rows = mysql_num_rows($get_one);
			while($rs_one = mysql_fetch_array($get_one))
			{  $i++;
			$order_detail_id["$i"]=$rs_one[order_detail_id];
$order_detail_no["$i"]=$rs_one[order_detail_no];
$order_detail_name["$i"]=$rs_one[order_detail_name];
$order_detail_description["$i"]=$rs_one[order_detail_description];
$order_detail_qty["$i"]=$rs_one[order_detail_qty];
$order_detail_unit["$i"]=$rs_one[order_detail_unit];
$order_detail_price["$i"]=$rs_one[order_detail_price];
$order_detail_total["$i"]=$rs_one[order_detail_total];
			?><?=$i?>
		
        html +=  '<input name="no[<?=$i?>]" type="text" id="no[<?=$i?>]" value="<?=$order_detail_no["$i"]?>"  class="b1" />&nbsp;';
		html +=  '<input name="name[<?=$i?>]" type="text" id="name[<?=$i?>]" class="b2" value="<?=$order_detail_name["$i"]?>"/>&nbsp;';
		html +=  '<input name="description[<?=$i?>]" type="text" id="description[<?=$i?>]" value="<?=$order_detail_description["$i"]?>" class="b3" />&nbsp;';
        html += '<input type ="text" name="qty[<?=$i?>]" id="qty_<?=$i?>" value="<?=$order_detail_qty["$i"]?>" class="b4" autocomplete="off"/>&nbsp;';
		html +=  '<input name="detail_unit[<?=$i?>]" type="text" id="detail_unit[<?=$i?>]" value="<?=$order_detail_unit["$i"]?>" class="b5" />&nbsp;';
        html += '<input type ="text" name="price[<?=$i?>]" id="price_<?=$i?>" class="b6"  value="<?=$order_detail_price["$i"]?>"  autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="total[<?=$i?>]"  id="total_<?=$i?>"    value="<?=$order_detail_total["$i"]?>" class="b7"/>&nbsp;';
		html += '<input type ="hidden" name="order_details_id[<?=$i?>]"  id="order_details_id[<?=$i?>]"   value="<?=$order_detail_id["$i"]?>"class="b8" />';
		html += '<a href="?action=del1&amp;order_detail_id=<?=$order_detail_id["$i"];?>&orderid_id=<?=$orderid_id?>&orderid_num=<?=$orderid_num?>"onclick="return Conf(<?=$order_detail_id["$i"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = "20px" onmouseout="this.style.width = "16px" border="0" /></a>'
		html += '</br>';
		$("#form14").html(html);
  <?  } ?>
  <? $i1=$i+1?>
   var i =<?=$i1?> ; var cnt = 20;
    //create object
    for(i=<?=$i1?>;i<=cnt;i++){
		
        html +=  '<input name="no['+i+']" type="text" id="no['+i+']" class="b1" />&nbsp;';
		html +=  '<input name="name['+i+']" type="text" id="name['+i+']" class="b2"/>&nbsp;';
		html +=  '<input name="description['+i+']" type="text" id="description['+i+']" class="b3" />&nbsp;';
        html += '<input type ="text" name="qty['+i+']" id="qty_'+i+'"   autocomplete="off" class="b4"/>&nbsp;';
		html +=  '<input name="detail_unit['+i+']" type="text" id="detail_unit['+i+']" class="b5" />&nbsp;';
        html += '<input type ="text" name="price['+i+']" id="price_'+i+'"  autocomplete="off" class="b6"/>&nbsp;';
        html += '<input type ="text" name="total['+i+']" readonly="readonly" id="total_'+i+'" class="b7"/>&nbsp;';
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
        //update all value
        $("#orderid_amount_en").val(all_result);        
		 $("#orderid_amount_sum").val(all_result);        
                
    });
});
</script> 
   
                  <div id="form14"></div>
             

</table>
                  <td valign="top">&nbsp;</td>
                </tr>
                  
                
              </table></td>
	      </tr>
	        <tr>
	          <td colspan="2"><hr/></td>
          </tr>
	        <tr>
	          <td></td>
	          <td><table width="100%" border="0">

                <tr>
                  <td width="52%" rowspan="2" align="center"><script type="text/javascript">
$(document).ready(function(){

	$("#orderid_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'sCus=' +$("#orderid_amount_en").val()
			})
			.success(function(result) { 
$("div#bid_tel5").html(result); 
					 $("#orderid_amount_th").val(result);

			});

		});
	});
	
</script>
                    <div  style="color:#000" id="bid_tel5"></div></td>
                  <td width="16%"><div align="right">ราคารวม</div></td>
                  <td width="32%"> <input name="orderid_amount_en" type="text" id="orderid_amount_en" value="<?=$orderid_amount_en?>" /></td>
                </tr>
                <tr>
                  <td><div align="right">รวมมูลค่าทั้งสิ้น</div></td>
                  <td><input name="orderid_amount_sum" type="text" id="orderid_amount_sum" value="<?=$orderid_amount_sum?>" /></td>
                </tr>
              </table></td>
          </tr>
            <tr>
              <td></td>
              <td><table width="100%" border="0">
                  <tr>
                    <th width="177" valign="top" ><div align="left">เงื่อนไขการชาระเงิน:</div></th>
                    <th width="664" ><div align="left">
                      <?php 
 						include("FCKeditor/fckeditor.php");
						$oFCKeditor = new FCKeditor('orderid_detail');
						$oFCKeditor->BasePath = 'FCKeditor/';
						$oFCKeditor->Width  = '300' ;
						$oFCKeditor->Height = '150' ;
						$oFCKeditor->Value = $orderid_detail;
						$oFCKeditor->ToolbarSet = 'write4';
						$oFCKeditor->Create(); 
					?>
                    </div>                    </th>
                </tr>
                </table></td>
            </tr>
            <tr>
              <td></td>
              <td><table width="100%" border="0">
                <tr>
                  <th width="152" valign="top" ><div align="right">หมายเหตุ:</div></th>
                  <th width="720" ><div align="left">
                   <textarea name="orderid_comment_details" id="orderid_comment_detaisl" cols="45" rows="5"></textarea><br/>
                 <? $tel_one = "select  * 
						from    orderid_comment
						where 
						   	   orderid_id = '".$orderid_num."' ORDER  BY orderid_comment_id   ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			while($rs_one = mysql_fetch_array($get_one))
			{ 
			$i++;
						$tel_one2 = "select  * 
						from    orderid_comment_re
						where  orderid_comment_id = '".$rs_one['orderid_comment_publish']."' and orderid_com_re_publish = '".$_SESSION["str_admin_email"]."'";
			$get_one2 = mysql_query($tel_one2);			
			$Num_Rows2 = mysql_num_rows($get_one2);
			if ($Num_Rows2==0){
						if($rs_one[orderid_comment_publish]!="$_SESSION[str_admin_email]"){

			$tellway  = "INSERT INTO orderid_comment_re VALUES(";
		$tellway .= "0
					,'".$_SESSION["str_admin_email"]."'
					,'$rs_one[orderid_comment_id]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
			}
			}
			$tel_one1 = "select  * 
						from    admin
						where  admin_email = '".$rs_one['orderid_comment_publish']."'";
			$get_one1 = mysql_query($tel_one1);
			$rs_one1 = mysql_fetch_array($get_one1);
			echo $rs_one1[admin_name];
			?>
            <br/>
            <? if ($rs_one['orderid_comment_publish'] == $_SESSION["str_admin_email"]) { ?>
                      <textarea name="orderid_comment_detail[<?=$i?>]" id="orderid_comment_detail[<?=$i?>]" cols="45" rows="5"><?=$rs_one['orderid_comment_detail']?></textarea>
                      <input type="hidden" name="orderid_comment_id[<?=$i?>]" id="orderid_comment_id[<?=$i?>]" value="<?=$rs_one['orderid_comment_id']?>" />
                      <input type="hidden" name="orderid_comment_publish[<?=$i?>]" id="orderid_comment_publish[<?=$i?>]" value="<?=$rs_one['orderid_comment_publish']?>" />
                      <a href="?action=del2&amp;orderid_comment_id=<?=$rs_one['orderid_comment_id']?>&amp;orderid_id=<?=$orderid_id?>"onclick="return Conf(<?=$order_detail_id["$i"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0" /></a><br/>
                      <? }else{ 
                      echo $rs_one['orderid_comment_detail'].'<br/>';
					  }
					   } ?>
                      <input type="hidden" name="comment_num" id="comment_num" value="<?=$i?>" />

                  </div></th>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td align="right">สถานะ ::</td>
              <td>
               <?  
			$tel_one = "select  * 
						from    status_billing
						where 
						   	   status_b_s = '1' and status_b_publish ='Yes' order by status_b_id  DESC";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{ ?>
            <input type="radio" name="orderid_publish" value="<?=$rs_one[status_b_id]?>" <? if($orderid_publish=="$rs_one[status_b_id]"){?>checked="checked"<? } ?> /><?=$rs_one[status_b_name]?>&nbsp;
				<? }?>
</td>
            </tr>
          
            <tr>
              <td>&nbsp;</td>
              <td><input type="radio" name="publish" value="Yes" checked="checked" />
                หมายเหตุ
                &nbsp;
                <input type="radio" name="publish" value="No" />
              แก้ไขออกใบเสนอราคา</td>
            </tr>
            <tr>
              <td></td>
              <td>ส่งใบเสนอราคาทางเมล์::
              <input name="checkbox1" type="checkbox" id="checkbox1" value="1" />&nbsp;</td>
            </tr>
          <tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
			  <input type="button" name="Submit5" value="ยกเลิก" onclick="window.location='billing.php';"/></td>
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
		if($_GET['copy'] == "true"){
			$tel_auto_rank = "select orderid_id from orderid ORDER  BY orderid_id DESC";
			$get_auto_rank = mysql_query($tel_auto_rank);
			$rs_one_rank = mysql_fetch_array($get_auto_rank);
			$rank_rows = mysql_fetch_array($get_auto_rank);
		$orderid_idts= substr ($rs_one_rank[orderid_id],3,2);
		
		$orderid_idts1= date('y')+43;
		if($orderid_idts1>$orderid_idts){
		$orderid_id="Quo";
		$orderid_id.="$orderid_idts1";
		$orderid_id.="-1";
		}else{
		$orderid_idt = substr ($rs_one_rank[orderid_id],6,5);
		$orderid_id="Quo";
		$orderid_id.="$orderid_idts";
		$orderid_id.="-";
		$orderid_idt=$orderid_idt+1;
		$orderid_id.="$orderid_idt";
		}
			
	?>
    <form action="?action=copy" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return checkvalue('fix')">
      <div class="text_detail"></div>
      <table id="myTable"  width="100%">
		<tr>
			<td width="7%"></td>
			<td width="93%">
				<input type="submit" name="Submit"   		value="บันทึกข้อมูล" >
			  <input type="button" name="Submit4" value="ยกเลิก" onclick="window.location='billing.php';"/></td>
		</tr>
		<tr>
			<td colspan="2"><table width="100%" border="0">
                  <tr>
                    <td><div align="right">ใบเสนอราคา::</div></td>
                    <td> 
                    <input name="orderid_id" type="text" id="orderid_id"  readonly="readonly" value="<?=$orderid_id?>" size="50" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="11%"><div align="right">เรียน :</div></td>
                    <td width="38%"><script type="text/javascript">
$(document).ready(function(){

	$("#orderid_attn1").change(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'sCusIDs=' +$("#orderid_attn1").val()
			})
			.success(function(result) { 

				var obj = jQuery.parseJSON(result);
				
					if(obj == '')
					{
						
						 $("#customers_com1").html('');
						 $("#orderid_co").val('');
						
					}
					else
					{
						  $.each(obj, function(key, inval) {

							  
							   $("#customers_com1").html(inval["customers_com"]);
							   $("#customers_email").html(inval["customers_email"]);
							   $("#customers_web").html(inval["customers_web"]);
							   $("#customers_tel").html(inval["customers_tel"]);
							   $("#customers_fax").html(inval["customers_fax"]);
								
							   $("#orderid_co").val(inval["customers_com"]);
							   $("#orderid_mail").val(inval["customers_email"]);
							   $("#customers_name").val(inval["customers_name"]);
							   $("#orderid_web").val(inval["customers_web"]);
							   $("#orderid_tel").val(inval["customers_tel"]);
							   $("#orderid_fax").val(inval["customers_fax"]);
							 
							 
				
						  });
					}

			});

		});
	});
	
</script>
                        <? 
						$tel_one = "select  * 
						from    orderid
						where 
						   	   orderid_num = '".$_GET['orderid_num']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
			
				$orderid_num  	= $rs_one['orderid_num'];
				$orderid_id  	= $rs_one['orderid_id'];
				$customers_id  	= $rs_one['customers_id'];
				$customers_p_id = $rs_one['customers_p_id'];
				$orderid_attn  	= $rs_one['orderid_attn'];
				$orderid_co   	= $rs_one['orderid_co'];
				$orderid_web  	= $rs_one['orderid_web'];
				$orderid_tel  	= $rs_one['orderid_tel'];
				$orderid_fax  	= $rs_one['orderid_fax'];
				$orderid_mail  	= $rs_one['orderid_mail'];
				$orderid_date  	= $rs_one['orderid_date'];
				$orderid_from  	= $rs_one['orderid_from'];
				$orderid_tel1  	= $rs_one['orderid_tel1'];
				$orderid_tel2  	= $rs_one['orderid_tel2'];
				$orderid_fax1  	= $rs_one['orderid_fax1'];
				$orderid_mail1  	= $rs_one['orderid_mail1'];
				$orderid_detail1  	= $rs_one['orderid_detail1'];
				$orderid_amount_th  	= $rs_one['orderid_amount_th'];
				$orderid_amount_en  	= $rs_one['orderid_amount_en'];
				$orderid_amount_sum  	= $rs_one['orderid_amount_sum'];
				$orderid_detail  	= $rs_one['orderid_detail'];
				$orderid_poster  	= $rs_one['orderid_poster'];
				$orderid_updater  	= $rs_one['orderid_updater'];
				$orderid_date1  	= $rs_one['orderid_date1'];
				$orderid_update  	= $rs_one['orderid_update'];
				$orderid_publish  	= $rs_one['orderid_publish'];
				
				
				
				
			}
						if ($_GET[edit]=="true"){
						$tel_one = "select  * from    customers where customers_id='".$_SESSION["str_customers_id"]."'
						";
			$get_one = mysql_query($tel_one);
			$rs_one = mysql_fetch_array($get_one);
				$customers_id  	= $rs_one['customers_id'];
				$orderid_attn  	= $rs_one['customers_name'];
				$orderid_co   	= $rs_one['customers_com'];
				$orderid_web  	= $rs_one['customers_web'];
				$orderid_tel  	= $rs_one['customers_tel'];
				$orderid_fax  	= $rs_one['customers_fax'];
				$orderid_mail  	= $rs_one['customers_email'];
				$tel_one = "select  * from    customers_project where customers_p_id='".$_SESSION["str_customers_p_id"]."'
						";
			$get_one = mysql_query($tel_one);
			$rs_one = mysql_fetch_array($get_one);
				$customers_p_id  	= $rs_one['customers_p_id'];
				
			}
			?>
                     <? $tel_one4 = "select  * from    customers where customers_id='$customers_id'
						";
			$get_one4 = mysql_query($tel_one4);
			$rs_one4 = mysql_fetch_array($get_one4);
			?>  
            <select name="orderid_attn" style="width:200px" id="orderid_attn">
  <? $tel_one = "select  * 
						from    customers_detail  where   customers_id = '$rs_one4[customers_id]' order by customers_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option <?php if (!(strcmp($rs_one['customers_detail_name'], "$orderid_attn"))) {echo "selected=\"selected\"";} ?> value="<?=$rs_one['customers_detail_name']?>">
  <?=$rs_one['customers_detail_name']?>
  </option>
  <? } ?>
</select>
            <a href="billing_customers_copy.php?copy=true&amp;orderid_id=<?=$orderid_id;?>&orderid_num=<?=$_GET[orderid_num];?>"><img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/></a>
                      
                    <input type="hidden" name="customers_p_id"  id="customers_p_id" value="<?=$customers_p_id?>" /></td>
                    <td width="9%"><div align="right">วันที่ :</div></td>
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

<input name="orderid_date" class="textinputdotted" type="text" id="dateInput" value="<?=$orderid_date?>" size="20"/></td>
                  </tr>
                  <tr>
                    <td ><div align="right">บริษัท :</div></td>
                    <td><input name="orderid_co" type="text" id="orderid_co" value="<?=$orderid_co?>" size="50" /></td>
                    <td><div align="right">จาก :</div></td>
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
<select name="bid_id" style="width:200px" id="bid_id">
  <? $tel_one = "select  * 
						from    bid
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option value="<?=$rs_one['bid_id']?>" <?php if (!(strcmp($rs_one['bid_name'], "$orderid_from"))) {echo "selected=\"selected\"";} ?>>
  <?=$rs_one['bid_name']?>
  </option>
  <? } ?>
</select><input type="hidden" name="bid_name"  id="bid_name"  value="<?=$orderid_from?>"/></td>
                  </tr>
                  <tr>
                    <td><div align="right">เว็บไซต์ :</div></td>
                    <td><input name="orderid_web" type="text" id="orderid_web" value="<?=$orderid_web?>" size="50" /></td>
                    <td><div align="right">มือถือ :</div></td>
                    <td><div  style="color:#000" id="bid_tel"><?=$orderid_tel1?></div> 
                    <input name="bid_tel" type="hidden" id="bid_tels" value="<?=$orderid_tel1?>" /></td>
                  </tr>
                  <tr>
                    <td><div align="right">โทรศัพท์ :</div></td>
                    <td><input name="orderid_tel" type="text" id="orderid_tel" value="<?=$orderid_tel?>" size="50" /></td>
                    <td><div align="right">โทรศัพท์ :</div></td>
                    <td><div  style="color:#000" id="bid_tel2">
                      <?=$orderid_tel2?>
</div>
                     <input name="bid_tel2" type="hidden" id="bid_tels2" value="<?=$orderid_tel2?>" />                    </td>
                  </tr>
                  <tr>
                    <td><div align="right">แฟกซ์ :</div></td>
                    <td><input name="orderid_fax" type="text" id="orderid_fax" value="<?=$orderid_fax?>" size="50" /></td>
                    <td><div align="right">แฟกซ์ :</div></td>
                    <td><div  style="color:#000" id="bid_fax">
                      <?=$orderid_fax1?>
</div> 
                    <input name="bid_fax1" type="hidden" id="bid_faxs" value="<?=$orderid_fax1?>" /></td>
                  </tr>
                  <tr>
                    <td><div align="right">อีเมล์ :</div></td>
                    <td><input name="orderid_mail" type="text" id="orderid_mail" value="<?=$orderid_mail?>" size="50" /></td>
                    <td><div align="right">อีเมล์ :</div></td>
                    <td><div  style="color:#000" id="bid_email">
                      <?=$orderid_mail1?>
</div>
                    <input name="bid_email1" type="hidden" id="bid_emails" value="<?=$orderid_mail1?>" /></td>
                  </tr>
                  <tr>
                    <td align="right">เลขผู้เสียภาษี::</td>
                    <td><input name="orderid_taxpayer" type="text" id="orderid_taxpayer" size="50" value="<?=$rs_one4['customers_num']?>"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
            </table></td>
		</tr>
  			<tr>
    			<td align="right">&nbsp;</td>
    			<td align="left">
                <select name="orderid_detail1" id="orderid_detail1">
  <? $tel_one = "select  * 
						from    ex
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
  <option value="<?=$rs_one['ex_name']?>" <?php if (!(strcmp($rs_one['ex_name'], "$orderid_detail1"))) {echo "selected=\"selected\"";} ?>>
  <?=$rs_one['ex_name']?>
  </option>
  <? } ?>
</select>               </td>
  			</tr>
		    <tr>
		      <td colspan="2"><table width="917" border="0" cellspacing="0">
                <tr>
                   <th  class="a1"  scope="col">No.</th>
                  <th class="a2" align="center">NAME</th>
                  <th class="a3" scope="col" align="center">Description</th>
                  <th class="a4" scope="col" >Qty.</th>
                  <th class="a5" scope="col">Unit</th>
                  <th class="a6" scope="col">Price</th>
                  <th class="a7" scope="col"><div  align="left">Total</div></th>
                  <th class="a8" scope="col">&nbsp;</th>
                </tr>
                <tr>
                  <td colspan="7"> <table  width="98%" border="0" cellspacing="0" >
                 <? if($_GET['copy'] == "true" and $_GET['order_detail_id']=="" ){
		$_SESSION["order_detail_ids"]="";
	session_write_close(); } ?>
				  <script type="text/javascript">
$(document).ready(function(){
	var html = '';
    //create object
    <?
$tel_one = "select * from   order_detail where   orderid_num = '$orderid_num' order by order_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			$i2=0;
			$rank_rows = mysql_num_rows($get_one);
			while($rs_one = mysql_fetch_array($get_one))
			{ $i++; 
			
			if ($_GET[order_detail_id] == "$rs_one[order_detail_id]") {
			$_SESSION["order_detail_ids"][$_GET[a]]=$_GET["order_detail_id"];
			}
if($rs_one[order_detail_id] != $_SESSION["order_detail_ids"][$i]){
 $i2++; 	
$order_detail_id["$i2"]=$rs_one[order_detail_id];
$order_detail_no["$i2"]=$rs_one[order_detail_no];
$order_detail_name["$i2"]=$rs_one[order_detail_name];
$order_detail_description["$i2"]=$rs_one[order_detail_description];
$order_detail_qty["$i2"]=$rs_one[order_detail_qty];
$order_detail_unit["$i2"]=$rs_one[order_detail_unit];
$order_detail_price["$i2"]=$rs_one[order_detail_price];
$order_detail_total["$i2"]=$rs_one[order_detail_total];
			?>
        html +=  '<input name="no[<?=$i2?>]" type="text" id="no[<?=$i2?>]" value="<?=$order_detail_no["$i2"]?>"  class="b1" />&nbsp;';
		html +=  '<input name="name[<?=$i2?>]" type="text" id="name[<?=$i2?>]" class="b2" value="<?=$order_detail_name["$i2"]?>"/>&nbsp;';
		html +=  '<input name="description[<?=$i2?>]" type="text" id="description[<?=$i2?>]" value="<?=$order_detail_description["$i2"]?>" class="b3" />&nbsp;';
        html += '<input type ="text" name="qty[<?=$i2?>]" id="qty_<?=$i2?>" value="<?=$order_detail_qty["$i2"]?>" class="b4" autocomplete="off"/>&nbsp;';
		html +=  '<input name="detail_unit[<?=$i2?>]" type="text" id="detail_unit[<?=$i2?>]" value="<?=$order_detail_unit["$i2"]?>" class="b5" />&nbsp;';
        html += '<input type ="text" name="price[<?=$i2?>]" id="price_<?=$i2?>" class="b6"  value="<?=$order_detail_price["$i2"]?>"  autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="total[<?=$i2?>]"  id="total_<?=$i2?>"    value="<?=$order_detail_total["$i2"]?>" class="b7"/>&nbsp;';
		html += '<input type ="hidden" name="order_details_id[<?=$i2?>]"  id="order_details_id[<?=$i2?>]"   value="<?=$order_detail_id["$i2"]?>"class="b8" />';
		html += '<a href="?copy=true&order_detail_id=<?=$order_detail_id["$i2"];?>&orderid_id=<?=$orderid_id?>&orderid_num=<?=$orderid_num?>&a=<?=$i?>&<?=$_SESSION["order_detail_ids"][$i]?>" onclick="return Conf(<?=$order_detail_id["$i2"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = "20px" onmouseout="this.style.width = "16px" border="0" /></a>'
		html += '</br>';
		$("#form14").html(html);
		
  <? } 
  } ?>
  <? $i1=$i2+1?>
   var i =<?=$i1?> ; var cnt = 20;
    //create object
    for(i=<?=$i1?>;i<=cnt;i++){
		
        html +=  '<input name="no['+i+']" type="text" id="no['+i+']" class="b1" />&nbsp;';
		html +=  '<input name="name['+i+']" type="text" id="name['+i+']" class="b2"/>&nbsp;';
		html +=  '<input name="description['+i+']" type="text" id="description['+i+']" class="b3" />&nbsp;';
        html += '<input type ="text" name="qty['+i+']" id="qty_'+i+'"   autocomplete="off" class="b4"/>&nbsp;';
		html +=  '<input name="detail_unit['+i+']" type="text" id="detail_unit['+i+']" class="b5" />&nbsp;';
        html += '<input type ="text" name="price['+i+']" id="price_'+i+'"  autocomplete="off" class="b6"/>&nbsp;';
        html += '<input type ="text" name="total['+i+']" readonly="readonly" id="total_'+i+'" class="b7"/>&nbsp;';
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
        //update all value
        $("#orderid_amount_en").val(all_result);        
		 $("#orderid_amount_sum").val(all_result);        
                
    });
});
</script> 
   
                  <div id="form14"></div>
             

</table>
                  <td valign="top">&nbsp;</td>
                </tr>
                  
                
              </table></td>
	      </tr>
	        <tr>
	          <td colspan="2"><hr/></td>
          </tr>
	        <tr>
	          <td></td>
	          <td><table width="100%" border="0">

                <tr>
                  <td width="52%" rowspan="2" align="center"><script type="text/javascript">
$(document).ready(function(){

	$("#orderid_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'sCus=' +$("#orderid_amount_en").val()
			})
			.success(function(result) { 
$("div#bid_tel5").html(result); 
					 $("#orderid_amount_th").val(result);

			});

		});
	});
	
</script>
                    <div  style="color:#000" id="bid_tel5"></div></td>
                  <td width="16%"><div align="right">ราคารวม</div></td>
                  <td width="32%"> <input name="orderid_amount_en" type="text" id="orderid_amount_en" value="<?=$orderid_amount_en?>" /></td>
                </tr>
                <tr>
                  <td><div align="right">รวมมูลค่าทั้งสิ้น</div></td>
                  <td><input name="orderid_amount_sum" type="text" id="orderid_amount_sum" value="<?=$orderid_amount_sum?>" /></td>
                </tr>
              </table></td>
          </tr>
            <tr>
              <td></td>
			  <td valign="top"><table width="100%" border="0">
                <tr>
                  <th width="185" valign="top" ><div align="left">เงื่อนไขการชาระเงิน:</div></th>
                  <th width="647" ><div align="left">
                      <?php 
 						include("FCKeditor/fckeditor.php");
						$oFCKeditor = new FCKeditor('orderid_detail');
						$oFCKeditor->BasePath = 'FCKeditor/';
						$oFCKeditor->Width  = '300' ;
						$oFCKeditor->Height = '150' ;
						$oFCKeditor->ToolbarSet = 'write4';
						$oFCKeditor->Create(); 
					?>
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
                    <textarea name="orderid_comment_detail" id="orderid_comment_detail" cols="45" rows="5"></textarea>
                  </div></th>
                </tr>
              </table></td>
		  </tr>
			<tr>
              <td align="right">สถานะ ::</td>
			  <td>
            <?  
			$tel_one = "select  * 
						from    status_billing
						where 
						   	   status_b_s = '1' and status_b_publish ='Yes' order by status_b_id  DESC";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
             echo "<input type=\"radio\" name=\"orderid_publish\" value=\"$rs_one[status_b_id]\" />$rs_one[status_b_name]";
				echo '&nbsp';
				}?>
			 </td>
            </tr>
            <tr>
              <td></td>
              <td>ส่งใบเสนอราคาทางเมล์::
              <input name="checkbox1" type="checkbox" id="checkbox1" value="1" /></td>
            </tr>
          <tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
			  <input type="button" name="Submit5" value="ยกเลิก" onclick="window.location='billing.php';"/></td>
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
						from    orderid
						where 
						   	   orderid_num = '".$_GET['orderid_num']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
			
				$orderid_num  	= $rs_one['orderid_num'];
				$orderid_id  	= $rs_one['orderid_id'];
				$customers_p_id = $rs_one['customers_p_id'];
				$orderid_attn  	= $rs_one['orderid_attn'];
				$orderid_co   	= $rs_one['orderid_co'];
				$orderid_web  	= $rs_one['orderid_web'];
				$orderid_tel  	= $rs_one['orderid_tel'];
				$orderid_fax  	= $rs_one['orderid_fax'];
				$orderid_mail  	= $rs_one['orderid_mail'];
				$orderid_date  	= $rs_one['orderid_date'];
				$orderid_from  	= $rs_one['orderid_from'];
				$orderid_tel1  	= $rs_one['orderid_tel1'];
				$orderid_tel2  	= $rs_one['orderid_tel2'];
				$orderid_fax1  	= $rs_one['orderid_fax1'];
				$orderid_mail1  	= $rs_one['orderid_mail1'];
				$orderid_detail1  	= $rs_one['orderid_detail1'];
				$orderid_amount_th  	= $rs_one['orderid_amount_th'];
				$orderid_amount_en  	= $rs_one['orderid_amount_en'];
				$orderid_amount_sum  	= $rs_one['orderid_amount_sum'];
				$orderid_detail  	= $rs_one['orderid_detail'];
				$orderid_poster  	= $rs_one['orderid_poster'];
				$orderid_updater  	= $rs_one['orderid_updater'];
				$orderid_date1  	= $rs_one['orderid_date1'];
				$orderid_update  	= $rs_one['orderid_update'];
				$orderid_publish  	= $rs_one['orderid_publish'];
				
				
				
				
			}
	?>
	<table id="myTable2" bgcolor="#E6E6E6" width="100%">
      <tr>
        <td width="7%"></td>
        <td width="93%"><input type="hidden" name="company_id" 		value="<?=$company_id?>" />
            <input type="hidden" name="orderid_num2"  	value="<?=$orderid_num?>" />
            <input type="button" name="Submit6" value="กลับ" onclick="window.location='billing.php';"/></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0">
            <tr>
              <td><div align="right">ใบเสนอราคา::</div></td>
              <td><?=$orderid_id?></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="11%"><div align="right">เรียน :</div></td>
              <td width="38%">
                  <? 
						if ($_GET[edit]=="true"){
						$tel_one = "select  * from    customers where customers_id='".$_SESSION["str_customers_id"]."'
						";
			$get_one = mysql_query($tel_one);
			$rs_one = mysql_fetch_array($get_one);
				$customers_id  	= $rs_one['customers_id'];
				$orderid_attn  	= $rs_one['customers_name'];
				$orderid_co   	= $rs_one['customers_com'];
				$orderid_web  	= $rs_one['customers_web'];
				$orderid_tel  	= $rs_one['customers_tel'];
				$orderid_fax  	= $rs_one['customers_fax'];
				$orderid_mail  	= $rs_one['customers_email'];
				$tel_one = "select  * from    customers_project where customers_p_id='".$_SESSION["str_customers_p_id"]."'
						";
			$get_one = mysql_query($tel_one);
			$rs_one = mysql_fetch_array($get_one);
				$customers_p_id  	= $rs_one['customers_p_id'];
				
			}
			?>
                <?=$orderid_attn?></td>
              <td width="9%"><div align="right">วันที่ :</div></td>
              <td width="42%">
              <?=$orderid_date?></td>
            </tr>
            <tr>
              <td ><div align="right">บริษัท :</div></td>
              <td><?=$orderid_co?></td>
              <td><div align="right">จาก :</div></td>
              <td><script type="text/javascript">
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
	
    </script><?=$orderid_from?>                </td>
            </tr>
            <tr>
              <td><div align="right">เว็บไซต์ :</div></td>
              <td><?=$orderid_web?></td>
              <td><div align="right">มือถือ :</div></td>
              <td><div  style="color:#000" id="bid_tel3">
                <?=$orderid_tel1?>
              </div>                </td>
            </tr>
            <tr>
              <td><div align="right">โทรศัพท์ :</div></td>
              <td><?=$orderid_tel?></td>
              <td><div align="right">โทรศัพท์ :</div></td>
              <td><div  style="color:#000" id="bid_tel4">
                  <?=$orderid_tel2?>
                </div>                </td>
            </tr>
            <tr>
              <td><div align="right">แฟกซ์ :</div></td>
              <td><?=$orderid_fax?></td>
              <td><div align="right">แฟกซ์ :</div></td>
              <td><div  style="color:#000" id="bid_fax2">
                  <?=$orderid_fax1?>
                </div>                </td>
            </tr>
            <tr>
              <td><div align="right">อีเมล์ :</div></td>
              <td><?=$orderid_mail?></td>
              <td><div align="right">อีเมล์ :</div></td>
              <td><div  style="color:#000" id="bid_email2">
                  <?=$orderid_mail1?>
                </div>                </td>
            </tr>
            <tr>
              <td align="right">เลขผู้เสียภาษี::</td>
              <td><?=$billing_taxpayer?></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td align="left"><?=$orderid_detail1?>        </td>
      </tr>
      <tr>
        <td colspan="2"><table width="917" border="0" cellspacing="0">
            <tr>
              <th  class="a1"  scope="col">No.</th>
                  <th class="a2" align="center">NAME</th>
                  <th class="a3" scope="col" align="center">Description</th>
                  <th class="a4" scope="col" >Qty.</th>
                  <th class="a5" scope="col">Unit</th>
                  <th class="a6" scope="col">Price</th>
                  <th class="a7" scope="col"><div  align="left">Total</div></th>
                  <th class="a8" scope="col">&nbsp;</th>
            </tr>
            <tr>
              <td colspan="7"><table  width="98%" border="0" cellspacing="0" >
                  <script type="text/javascript">
$(document).ready(function(){
	var html = '';
    //create object
    <?
$tel_one = "select * from   order_detail where   orderid_num = '$orderid_num' order by order_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			$rank_rows = mysql_num_rows($get_one);
			while($rs_one = mysql_fetch_array($get_one))
			{  $i++;
			$order_detail_id["$i"]=$rs_one[order_detail_id];
$order_detail_no["$i"]=$rs_one[order_detail_no];
$order_detail_name["$i"]=$rs_one[order_detail_name];
$order_detail_description["$i"]=$rs_one[order_detail_description];
$order_detail_qty["$i"]=$rs_one[order_detail_qty];
$order_detail_unit["$i"]=$rs_one[order_detail_unit];
$order_detail_price["$i"]=$rs_one[order_detail_price];
$order_detail_total["$i"]=$rs_one[order_detail_total];
			?><?=$i?>
		
        html +=  '<input name="no[<?=$i?>]" type="text" id="no[<?=$i?>]" value="<?=$order_detail_no["$i"]?>"  class="b1" />&nbsp;';
		html +=  '<input name="name[<?=$i?>]" type="text" id="name[<?=$i?>]" class="b2" value="<?=$order_detail_name["$i"]?>"/>&nbsp;';
		html +=  '<input name="description[<?=$i?>]" type="text" id="description[<?=$i?>]" value="<?=$order_detail_description["$i"]?>" class="b3" />&nbsp;';
        html += '<input type ="text" name="qty[<?=$i?>]" id="qty_<?=$i?>" value="<?=$order_detail_qty["$i"]?>" class="b4" autocomplete="off"/>&nbsp;';
		html +=  '<input name="detail_unit[<?=$i?>]" type="text" id="detail_unit[<?=$i?>]" value="<?=$order_detail_unit["$i"]?>" class="b5" />&nbsp;';
        html += '<input type ="text" name="price[<?=$i?>]" id="price_<?=$i?>" class="b6"  value="<?=$order_detail_price["$i"]?>"  autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="total[<?=$i?>]"  id="total_<?=$i?>"    value="<?=$order_detail_total["$i"]?>" class="b7"/>&nbsp;';
		html += '<input type ="hidden" name="order_details_id[<?=$i?>]"  id="order_details_id[<?=$i?>]"   value="<?=$order_detail_id["$i"]?>" class="b8"/>';
		html += '</br>';
		$("#form14").html(html);
  <?  } ?>
  <? $i1=$i+1?>
   var i =<?=$i1?> ; var cnt = 20;
    //create object
    
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
        //update all value
        $("#orderid_amount_en").val(all_result);        
		 $("#orderid_amount_sum").val(all_result);        
                
    });
});
    </script>
                  <div id="form14"></div>
              </table></td>
              <td valign="top">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><hr/></td>
      </tr>
      <tr>
        <td></td>
        <td><table width="100%" border="0">
            <tr>
              <td width="52%" rowspan="2" align="center"><script type="text/javascript">
$(document).ready(function(){

	$("#orderid_amount_en").keyup(function(){
			$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: 'sCus=' +$("#orderid_amount_en").val()
			})
			.success(function(result) { 
$("div#bid_tel5").html(result); 
					 $("#orderid_amount_th").val(result);

			});

		});
	});
	
    </script>
                  <div  style="color:#000" id="bid_tel6"></div></td>
              <td width="16%"><div align="right">ราคารวม</div></td>
              <td width="32%"><input name="orderid_amount_en2" type="text" id="orderid_amount_en2" value="<?=$orderid_amount_en?>" /></td>
            </tr>
            <tr>
              <td><div align="right">รวมมูลค่าทั้งสิ้น</div></td>
              <td><input name="orderid_amount_sum2" type="text" id="orderid_amount_sum2" value="<?=$orderid_amount_sum?>" /></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td></td>
        <td><table width="100%" border="0">
            <tr>
              <th width="177" valign="top" ><div align="left">เงื่อนไขการชาระเงิน:</div></th>
              <th width="664" ><div align="left">
                  <?php 
 						include("FCKeditor/fckeditor.php");
						$oFCKeditor = new FCKeditor('orderid_detail');
						$oFCKeditor->BasePath = 'FCKeditor/';
						$oFCKeditor->Width  = '300' ;
						$oFCKeditor->Height = '150' ;
						$oFCKeditor->Value = $orderid_detail;
						$oFCKeditor->ToolbarSet = 'write4';
						$oFCKeditor->Create(); 
					?>
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
						from    orderid_comment
						where 
						   	   orderid_id = '".$orderid_id."' ORDER  BY orderid_comment_id   ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			while($rs_one = mysql_fetch_array($get_one))
			{ 
			$i++;
						$tel_one2 = "select  * 
						from    orderid_comment_re
						where  orderid_comment_id = '".$rs_one['orderid_comment_publish']."' and orderid_com_re_publish = '".$_SESSION["str_admin_email"]."'";
			$get_one2 = mysql_query($tel_one2);			
			$Num_Rows2 = mysql_num_rows($get_one2);
			if ($Num_Rows2==0){
						if($rs_one[orderid_comment_publish]!="$_SESSION[str_admin_email]"){

			$tellway  = "INSERT INTO orderid_comment_re VALUES(";
		$tellway .= "0
					,'".$_SESSION["str_admin_email"]."'
					,'$rs_one[orderid_comment_id]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
			}
			}
			$tel_one1 = "select  * 
						from    admin
						where  admin_email = '".$rs_one['orderid_comment_publish']."'";
			$get_one1 = mysql_query($tel_one1);
			$rs_one1 = mysql_fetch_array($get_one1);
			echo $rs_one1[admin_name];
			?>
                  <br/>
                  <? if ($rs_one['orderid_comment_publish'] == $_SESSION["str_admin_email"]) { ?>
                  <textarea name="orderid_comment_detail[<?=$i?>]2" id="orderid_comment_detail[<?=$i?>]2" cols="45" rows="5"><?=$rs_one['orderid_comment_detail']?>
    </textarea>
                  <br/>
                  <? }else{ 
                      echo $rs_one['orderid_comment_detail'].'<br/>';
					  }
					   } ?>
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
						   	   status_b_id = '$orderid_publish'  ";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{ ?>
            <?=$rs_one[status_b_name]?>&nbsp;
				<? }?></td>
      </tr>
      <tr>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td><input type="button" name="Submit6" value="กลับ" onclick="window.location='billing.php';"/></td>
      </tr>
      <tr>
        <td colspan="2"><hr/></td>
      </tr>
    </table>
	<?
		}
	?>
	<form name="list" method="post" action="?action=del_sel" onsubmit="return ConfAll()">
	  <table width="100%" border="0" cellspacing="0">
        <?
		// query area
		$i=0;
		
		if( $_SESSION["str_search"] ==""){
			$tel = "select * 
					from    orderid where orderid_publish1='Yes'
					 ";
		} else {
		$search=$_GET[search1];
			$tel = "select * 
					from    orderid
					where  
						   $search like '%".$_SESSION["str_search"]."%' and orderid_publish1='Yes'";
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
						$_GET['stack'] = "orderid_num";
					} else {
						$_GET['stack'] = "orderid_num";
					}
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>
        <thead>
          <tr>
            <td width="10%">สถานะ</td>
            <td width="14%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=orderid_id&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">ใบเสนอราคา</a>
                <? }else { ?>
                <a href="?stack=orderid_id&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">ใบเสนอราคา</a>
                <? } ?>            </td>
            <td width="38%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=orderid_attn&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">บริษัท </a>
                <? }else { ?>
                <a href="?stack=orderid_attn&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">บริษัท </a>
                <? } ?>            </td>
            <td width="29%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=orderid_date1&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
                <? }else { ?>
                <a href="?stack=orderid_date1&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a>
                <? } ?>            </td>
            <td width="11%"><a href="?stack=admin_publish&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">สถานะ</a></td>
            <td width="5%">รายงาน</td>
            <td width="5%">พิมพ์</td>
            <td width="5%">copy</td>
            <td width="5%">แก้ไข</td>
            <!--<td width="4%">ลบ</td> -->
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
						from    orderid_comment
						where 
						   	   orderid_id = '".$rs[orderid_id]."' and orderid_comment_publish != '".$_SESSION["str_admin_email"]."' ORDER  BY orderid_id   ASC";
			$get_one = mysql_query($tel_one);
			$num_check1  = mysql_num_rows($get_one);
			$i=0;
			if ($num_check1 > 0){
			while($rs_one = mysql_fetch_array($get_one))
			{ $i++;
			$tel_one5 = "select  * 
						from    orderid_comment_re
						where   orderid_comment_id = '".$rs_one['orderid_comment_id']."' and orderid_com_re_publish ='".$_SESSION["str_admin_email"]."' ";
			$get_one5 = mysql_query($tel_one5);
			$num_check5  = mysql_num_rows($get_one5);
			}
			if($num_check5 > "0"){
				
				$color = "#FF0000";
			?> <img src="images/f_poll.gif" />
             
              <?
			   } else {
				$color = "#000000";
				
			?>
              <img src="images/f_hot.gif" width="18" height="12" />
              <? } 
			  }
			  ?></td>
            <td><a href="billing_edit.php?orderid_id=<?=$rs['orderid_id']?>" ><?=$rs['orderid_id']?></a> </td>
            <td><?=$rs['orderid_co']?>
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
            <td><?=dateform($rs['orderid_date1'])?>
                <br/>
                <font class="text_small_gray">By
                  <?=$rs['orderid_poster']?>
                </font> </td>
            <td><?  
			$tel_one = "select  * 
						from    status_billing
						where 
						   	   status_b_id = '$rs[orderid_publish]' and status_b_publish ='Yes' order by status_b_id  ASC";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{ echo"$rs_one[status_b_name]"; } ?> </td>
            <td><a href="billing.php?view=true&amp;orderid_id=<?=$rs["orderid_id"];?>&orderid_num=<?=$rs["orderid_num"];?>"> <img src="images/view.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
            <td><a href="MPDF56/examples/example01_basic.php?orderid_id=<?=$rs["orderid_id"];?>" target="_blank"> <img src="images/view.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
            <td><a href="billing.php?copy=true&amp;orderid_id=<?=$rs["orderid_id"];?>&orderid_num=<?=$rs["orderid_num"];?>"> <img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
            <td><a href="billing.php?fix=true&amp;orderid_id=<?=$rs["orderid_id"];?>&amp;orderid_num=<?=$rs["orderid_num"];?>"> <img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/></a></td>
            <!--<td><a href="?action=del&amp;orderid_id=<?=$rs["orderid_id"];?>"onclick="return confirm('ยืนยันการลบ ใบเสนอราคา<?=$rs["orderid_id"]?>')"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0" /></a> </td>
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
	$("#orderid_attn1").msDropdown();
	$("#bid_id").msDropdown();
	$("#orderid_attn").msDropdown();
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
