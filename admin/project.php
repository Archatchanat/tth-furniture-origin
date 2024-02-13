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
	if($_GET['customers_id']!=""){
	$_SESSION["str_customers_id"] = $_GET['customers_id'];
	}
	// start insert ----------------------------------------------------------------------------------------------------------------------
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
if($_GET["action"]=="insert")
	{
		$tellway  = "INSERT INTO customers_project VALUES(";
		$tellway .= "0
					,'$_POST[project_c_id]'
					,'$_POST[customers_id]'
					,'$_POST[customers_p_name]'
					,'".$_SESSION["str_admin_email"]."'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,NOW()
					,'$_POST[customers_p_publish]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		$customers_id=mysql_insert_id();
		if ($_POST[customers_orderid_date]!="" and $_POST[customers_orderid_publish]!="") {
		
		$tellway  = "INSERT INTO customers_orderid VALUES(";
		$tellway .= "0
					,'$_POST[customers_orderid_date]'
					,'$_POST[customers_orderid_detail]'
					,'$_POST[customers_orderid_m]'
					,'$_POST[customers_orderid_publish]'
					,'$customers_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		}
		if ($_POST[customers_orderid_date1]!="" and $_POST[customers_orderid_publish1]!="") {
		
		$tellway  = "INSERT INTO customers_orderid VALUES(";
		$tellway .= "0
					,'$_POST[customers_orderid_date1]'
					,'$_POST[customers_orderid_detail1]'
					,'$_POST[customers_orderid_m1]'
					,'$_POST[customers_orderid_publish1]'
					,'$customers_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		}
			
		echo "<script language=\"JavaScript\">";
		echo "window.location='project.php';";
		echo "</script>";
    }
	// end__ insert ----------------------------------------------------------------------------------------------------------------------
	
	// start update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="save")
	{	
		
		
		$sql_up = "update customers_project set
					 customers_p_name = '$_POST[customers_p_name]'
					,project_c_id ='$_POST[project_c_id]'
					,customers_p_updater ='".$_SESSION["str_admin_email"]."'
					,customers_p_update =NOW()
					,customers_p_publish ='$_POST[customers_p_publish]'
					where customers_p_id  = '".$_POST['customers_p_id']."'";
		$dbquery = mysql_query($sql_up);
		$j1=0;
		
			if ($_POST[customers_orderid_id]=="" and $_POST[customers_orderid_date] !="") {
		$tellway  = "INSERT INTO customers_orderid VALUES(";
		$tellway .= "0
					,'$_POST[customers_orderid_date]'
					,'$customers_p_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		}
		if ($_POST[customers_orderid_id]!="" and $_POST[customers_orderid_date] !="Yes") {
		$sql_up = "update customers_orderid set
					 customers_orderid_date    = '$_POST[customers_orderid_date]'
					 ,customers_orderid_m    = '$_POST[customers_orderid_m]'
					  ,customers_orderid_detail    = '$_POST[customers_orderid_detail]'
					  ,customers_orderid_publish    = '$_POST[customers_orderid_publish]' 
					where customers_orderid_id  = '".$_POST['customers_orderid_id']."'";
		$dbquery = mysql_query($sql_up);
		}else if($_POST[customers_orderid_id]!="" and $_POST[customers_orderid_date] =="Yes"){
		$sql_del= "delete from customers_orderid where customers_orderid_id='".$_POST["customers_orderid_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		}
		if ($_POST[customers_orderid_id1]!="" and $_POST[customers_orderid_date1] !="Yes") {
		$sql_up = "update customers_orderid set
					 customers_orderid_date    = '$_POST[customers_orderid_date1]'
					 ,customers_orderid_m    = '$_POST[customers_orderid_m1]'
					  ,customers_orderid_detail    = '$_POST[customers_orderid_detail1]'
					  ,customers_orderid_publish    = '$_POST[customers_orderid_publish1]' 
					where customers_orderid_id  = '".$_POST['customers_orderid_id1']."'";
		$dbquery = mysql_query($sql_up);
		}else if($_POST[customers_orderid_id1]!="" and $_POST[customers_orderid_date1] =="Yes"){
		$sql_del= "delete from customers_orderid where customers_orderid_id='".$_POST["customers_orderid_id1"]."'";
		$dbquery_del = mysql_query($sql_del);
		}
				
		echo "<script language='JavaScript'>";
		echo "window.location='project.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="del")
	{
		
		$tel_check 	= "select orderid_id,orderid_co,orderid_attn,orderid_publish,orderid_date1 from    orderid  
					where  
						   customers_p_id = '".$_GET["customers_p_id"]."'
					UNION
					select billing_id,billing_co,billing_attn,billing_publish,billing_date1 from    billing  
					where  
						   customers_p_id = '".$_GET["customers_p_id"]."'
					UNION
					select billing2_id,billing2_co,billing2_attn,billing2_publish,billing2_date1 from    billing2  
					where  
						   customers_p_id = '".$_GET["customers_p_id"]."'";
		$get_check  = mysql_query($tel_check);
		$num_check  = mysql_num_rows($get_check);
		
		if($num_check>0){
		
			echo "<script language=\"JavaScript\">";
			echo"alert('รหัสโปรเจคมีอยู่ในระบบไม่สามารถลบได้');";
			echo "window.location='project.php';";
			echo "</script>";
			exit();
		}
		
		$sql_del= "delete from customers_project where customers_p_id ='".$_GET["customers_p_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		
		$sql_del2= "delete from customers_orderid where customers_id ='".$_GET["customers_p_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		echo "<script language='JavaScript'>";
		echo "window.location=\"project.php\";";
		echo "</script>";
		}
	?>

<title>billing</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="partner.js"></script>
 <script src="js/jquery-1.8.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/dd.css" />
<script src="js/jquery.dd.min.js"></script>

<script language="JavaScript">
	function checkvalue(action){
		filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(form1.customers_p_name.value == "") {
			alert("กรุณากรอก โปรเจคชื่อ");
			form1.customers_p_name.focus();
			return false
		}
	}
	if(form1.project_c_id.value == "") {
			alert("กรุณาเลือก หมวดหมูู่โปรเจค");
			form1.project_c_id.focus();
			return false
		}
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
		
			
		  <form method="get" action="billing.php" name="form2" onSubmit="return checkvalue2()">
		    <table width="100%">
                <tr>
                  <td width="34%"><? $tel_one = "select  * 
						from    customers
						where 
						   	   customers_id = '".$_SESSION["str_search"]."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
					
			
				$customers_com    = $rs_one['customers_com'];
				
				
			}?>โปรเจค:<?=$customers_name?>
                  <input name="button" type="button" value="+ เพิ่มข้อมูล" onclick="window.location='project.php?action=add';"/></td>
                </tr>
            </table>
		      </form>
			<hr/>
			<?
		if($_GET['action']=="add"){
		
		
	?>
         	<form name="form1" action="?action=insert" method="post" onSubmit="return checkvalue('')" enctype="multipart/form-data">

            <table width="100%">
              <tr>
                <td colspan="2"><input type="hidden" name="customers_id" id="customers_id"  value="<?=$_SESSION["str_search"]?>"/></td>
              </tr>
              <tr>
                <td width="19%" align="right">โปรเจคชื่อ ::</td>
                <td width="81%" align="left"><input name="customers_p_name" type="text" id="customers_p_name" value="" size="40"/></td>
              </tr>

              <tr>
                <td align="right">หมวดหมูู่โปรเจค::</td>
                <td><select name="project_c_id" style="width:200px" id="project_c_id">
                  <option value=""> กรุณาเลือก </option>
                  <? $tel_one = "select  * 
						from    project_category
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
                  <option value="<?=$rs_one['project_c_id']?>">
                  <?=$rs_one['project_c_name']?>
                  </option>
                  <? } ?>
                </select></td>
              </tr>
              <tr>
                <td align="right">วันที่เริ่มแจ้งเตือน::</td>
                <td>
				 <link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.7.2.custom.css" />
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
                  <input name="customers_orderid_date" class="textinputdotted" type="text" id="dateInput" value="" size="20"/></td>
              </tr>
              <tr>
                <td align="right">แจ้งเตือนใบเสนอราคา::</td>
                <td>ทุก
                  <select name="customers_orderid_m" id="customers_orderid_m" class="txtbox">
                  <option value="">เลือก</option>
                  <?
						  	for($i=1;$i<=12;$i++)
							{
								if($FromDD == $i)
								{
									$sel = "selected";
								}
								else
								{
									$sel = "";
								}
						  ?>
                  <option value="<?=$i;?>" <?=$sel;?>>
                  <?=substr("0$i",-2);?>
                  </option>
                  <?
							}
							?>
                </select>
                เดือน</td>
              </tr>

              <tr>
                <td align="right">รายละเอียดแจ้งเตือน::</td>
                <td><input name="customers_orderid_detail" type="text" id="textfield" size="40" /></td>
              </tr>
              <tr>
                <td align="right">แจ้งเตือน ::</td>
                <td><input name="customers_orderid_publish" type="checkbox" id="checkbox" value="1" />
                ใบเสนอราคา
        &nbsp;</td>
              </tr>
              <tr>
                <td align="right">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right">วันที่เริ่มแจ้งเตือน::</td>
                <td>
				 <link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.7.2.custom.css" />
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
                  <input name="customers_orderid_date1" class="textinputdotted" type="text" id="dateInput1" value="" size="20"/></td>
              </tr>
              <tr>
                <td align="right">แจ้งเตือนใบเสนอราคา::</td>
                <td>ทุก
                  <select name="customers_orderid_m1" id="customers_orderid_m" class="txtbox">
                  <option value="">เลือก</option>
                  <?
						  	for($i=1;$i<=12;$i++)
							{
								if($FromDD == $i)
								{
									$sel = "selected";
								}
								else
								{
									$sel = "";
								}
						  ?>
                  <option value="<?=$i;?>" <?=$sel;?>>
                  <?=substr("0$i",-2);?>
                  </option>
                  <?
							}
							?>
                </select>
                เดือน</td>
              </tr>

              <tr>
                <td align="right">รายละเอียดแจ้งเตือน::</td>
                <td><input name="customers_orderid_detail1" type="text" id="textfield" size="40" /></td>
              </tr>
              <tr>
                <td align="right">แจ้งเตือน ::</td>
                <td><input name="customers_orderid_publish1" type="checkbox" id="checkbox" value="2" />
                  ใบวางบิล </td>
              </tr>
              <tr>
                <td align="right">สถานะแจ้งเตือน ::</td>
                <td><input type="radio" name="customers_p_publish" value="Yes" checked="checked" />
                ใช้งาน
        &nbsp;
                          <input type="radio" name="customers_publish" value="No" />
                  ไม่ใช้งาน </td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td></td>
                <td><input type="submit" name="Submit" value="ยืนยันข้อมูล" />
                    <input type="button" name="Submit" value="ยกเลิก" onclick="window.location='customers.php';"/>                </td>
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
						from    customers_project
						where 
						   	   customers_p_id = '".$_GET['customers_p_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
					
				$customers_p_id	   	= $rs_one['customers_p_id'];
				$project_c_id	   	= $rs_one['project_c_id'];
				$customers_id    = $rs_one['customers_id'];
				$customers_p_name     = $rs_one['customers_p_name'];
				$customers_poster   = $rs_one['customers_p_date'];
				$customers_updater  = $rs_one['customers_p_updater'];
				$customers_date     = $rs_one['customers_p_date'];
				$customers_update   = $rs_one['customers_p_update'];
				$customers_p_publish  = $rs_one['customers_p_publish'];
				
			}
	?>
            <div class="text_detail"> รายละเอียด : สร้างวันที่ : <?=dateform($customers_date)?>[<?=$customers_poster?>] , แก้ไขล่าสุดวันที่
  <?=dateform($customers_update)?>, [<?=$customers_updater?>] </div>
              <form name="form1" action="?action=save" method="post" onSubmit="return checkvalue('fix')" enctype="multipart/form-data">
            <table id="myTable" bgcolor="#E6E6E6" width="100%">
              <tr>
                <td width="19%"></td>
                <td width="81%"><input type="hidden" name="customers_p_id" 		value="<?=$customers_p_id?>" />
                  <input type="hidden" name="customers_id" id="customers_id"  value="<?=$customers_id?>"/>
                    <input type="submit" name="Submit"   		value="บันทึกข้อมูล" />
                    <input type="button" name="Submit"   		value="ยกเลิก" onclick="window.location='customers.php';"/>                </td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td align="right">โปรเจคชื่อ ::</td>
                <td align="left"><input name="customers_p_name" type="text" id="customers_p_name" value="<?=$customers_p_name?>" size="40"/></td>
              </tr>

              <tr>
                <td align="right">หมวดหมูู่โปรเจค::</td>
                <td><select name="project_c_id" style="width:200px" id="project_c_id">
                  <option value="" <?php if (!(strcmp("", "$project_c_id"))) {echo "selected=\"selected\"";} ?>> กรุณาเลือก </option>
                  <? $tel_one = "select  * 
						from    project_category
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
                  <option value="<?=$rs_one['project_c_id']?>" <?php if (!(strcmp($rs_one['project_c_id'], "$project_c_id"))) {echo "selected=\"selected\"";} ?>>
                  <?=$rs_one['project_c_name']?>
                  </option>
                  <? } ?>
                </select></td>
              </tr>
              <tr>
                <td align="right">วันที่เริ่มแจ้งเตือน::</td>
                <td>
				<? $tel = "select  * 
						from    customers_orderid
						where 
						   	   customers_id = '".$_GET['customers_p_id']."' and customers_orderid_publish='1'";
			$get = mysql_query($tel);
			$rs = mysql_fetch_array($get);
			 $customers_orderid_date = $rs[customers_orderid_date];
			 $customers_orderid_m = $rs[customers_orderid_m];
			 $customers_orderid_id = $rs[customers_orderid_id];
			 $customers_orderid_detail = $rs[customers_orderid_detail];
			 $customers_orderid_publish = $rs[customers_orderid_publish];
			   
			?>
				 <link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.7.2.custom.css" />
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
                  <input name="customers_orderid_date" class="textinputdotted" type="text" id="dateInput" value="<?=$customers_orderid_date?>" size="20"/></td>
              </tr>
              <tr>
                <td align="right">แจ้งเตือนใบเสนอราคา::</td>
                <td>ทุก
                  <select name="customers_orderid_m" id="customers_orderid_m" class="txtbox">
                      <option value="<? if($customers_orderid_m!=""){echo"Yes";}?>">
                      <? if($customers_orderid_m == "" ){echo"เลือก";}else{echo"ยกเลิกการแจ้งเตือน";}?>
                      </option>
                      <? $i = 0;
						  	for($i=1;$i<=12;$i++)
							{
								if($customers_orderid_m == $i)
								{
									$sel = "selected=\"selected\"";
								}
								else
								{
									$sel = "";
								}
						  ?>
                      <option value="<?=$i;?>" <?=$sel;?>>
                      <?=substr("0$i",-2);?>
                      </option>
                      <?
							}
							?>
                  </select>
                <input type="hidden" name="customers_orderid_id" id="customers_orderid_id" value="<?=$customers_orderid_id?>"/>
                เดือน</td>
              </tr>

              <tr>
                <td align="right">รายละเอียดแจ้งเตือน::</td>
                <td><input name="customers_orderid_detail" type="text" id="textfield" size="40"  value="<?=$customers_orderid_detail?>"/></td>
              </tr>
              <tr>
                <td align="right">แจ้งเตือน ::</td>
                <td><input <?php if (!(strcmp("$customers_orderid_publish",1))) {echo "checked=\"checked\"";} ?> name="customers_orderid_publish" type="checkbox" id="checkbox" value="1" />
                ใบเสนอราคา
        &nbsp;</td>
              </tr>
              <tr>
                <td align="right">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right">วันที่เริ่มแจ้งเตือน::</td>
                <td>
				<? $tel = "select  * 
						from    customers_orderid
						where 
						   	   customers_id = '".$_GET['customers_p_id']."' and customers_orderid_publish='2'";
			$get = mysql_query($tel);
			$rs = mysql_fetch_array($get);
			 $customers_orderid_date1 = $rs[customers_orderid_date];
			 $customers_orderid_m1 = $rs[customers_orderid_m];
			 $customers_orderid_id1 = $rs[customers_orderid_id];
			 $customers_orderid_detail1 = $rs[customers_orderid_detail];
			 $customers_orderid_publish1 = $rs[customers_orderid_publish];
			   
			?>
				 <link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.7.2.custom.css" />
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
                  <input name="customers_orderid_date1" class="textinputdotted" type="text" id="dateInput" value="<?=$customers_orderid_date1?>" size="20"/></td>
              </tr>
              <tr>
                <td align="right">แจ้งเตือนใบเสนอราคา::</td>
                <td>ทุก
                  <select name="customers_orderid_m1" id="customers_orderid_m" class="txtbox">
                      <option value="<? if($customers_orderid_m!=""){echo"Yes";}?>">
                      <? if($customers_orderid_m == "" ){echo"เลือก";}else{echo"ยกเลิกการแจ้งเตือน";}?>
                      </option>
                      <? $i = 0;
						  	for($i=1;$i<=12;$i++)
							{
								if($customers_orderid_m == $i)
								{
									$sel = "selected=\"selected\"";
								}
								else
								{
									$sel = "";
								}
						  ?>
                      <option value="<?=$i;?>" <?=$sel;?>>
                      <?=substr("0$i",-2);?>
                      </option>
                      <?
							}
							?>
                  </select>
                <input type="hidden" name="customers_orderid_id1" id="customers_orderid_id" value="<?=$customers_orderid_id1?>"/>
                เดือน</td>
              </tr>

              <tr>
                <td align="right">รายละเอียดแจ้งเตือน::</td>
                <td><input name="customers_orderid_detail1" type="text" id="textfield" size="40"  value="<?=$customers_orderid_detail1?>"/></td>
              </tr>
              <tr>
                <td align="right">แจ้งเตือน ::</td>
                <td><input <?php if (!(strcmp("$customers_orderid_publish1",2))) {echo "checked=\"checked\"";} ?> name="customers_orderid_publish" type="checkbox" id="checkbox" value="2" />
                ใบวางบิล&nbsp;</td>
              </tr>
              <tr>
                <td align="right">สถานะแจ้งเตือน ::</td>
                <td><input type="radio" name="customers_p_publish" value="Yes" <? if($customers_p_publish=="Yes"){?>checked="checked"<? } ?> />
                  ใช้งาน&nbsp;
                  <input type="radio" name="customers_p_publish" value="No" <? if($customers_p_publish=="No"){?>checked="checked"<? } ?> />
                  ไม่ใช้งาน</td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td></td>
                <td><input type="submit" name="Submit"   value="บันทึกข้อมูล" />
                    <input type="button" name="Submit"   value="ยกเลิก" onclick="window.location='customers.php';"/>                </td>
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
			
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : add data --><!--end__ : add data -->
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : edit data -->
<form name="list" method="post" action="?action=del_sel" onsubmit="return ConfAll()">
	  <table width="100%" border="0" cellspacing="0">
        <?
		// query area
		$i=0;
		
		
		$search=$_GET[search1];
			$tel = "select * from    customers_project  
					where  
						   customers_id = '".$_SESSION["str_search"]."'
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
					if( $_SESSION["str_admin_gp_id"] == ""){
						$_GET['type_stack'] = "DESC";
					} else {
						$_GET['type_stack'] = "DESC";
					}
				}
			
				if($_GET['stack']=="")
				{ 
					if( $_SESSION["str_admin_gp_id"] ==""){
						$_GET['stack'] = "customers_p_id";
					} else {
						$_GET['stack'] = "customers_p_id";
					}
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>
        <thead>
          <tr>
            <td width="43%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=orderid_attn&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">ชื่อโปรเจค</a>
                <? }else { ?>
                <a href="?stack=orderid_attn&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">ชื่อโปรเจค</a>
              <? } ?>            </td>
            <td width="23%"><a href="?stack=orderid_date1&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">หมวดหมูู่โปรเจค</a> </td>
            <td width="21%"><a href="?stack=orderid_date1&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a> </td>
            <td width="6%">แก้ไข</td>
            <td width="7%">ยกเลิก</td>
            </tr>
        </thead>
        <tbody>
          <?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
          <tr id="tr<?=$i?>" onmouseover='mOvr(this,&quot;#E6E6E6&quot;);' onmouseout='mOut(this,&quot;#ffffff&quot;);'>
            <td><a href="re_billing.php?customers_p_id=<?=$rs['customers_p_id']?>"><?=$rs['customers_p_name']?></a></td>
            <td><? $tel_onew = "select  * 
						from    project_category where project_c_id='".$rs['project_c_id']."' 
						";
			$get_onew= mysql_query($tel_onew);
			$rs_onew = mysql_fetch_array($get_onew);?>
                  <?=$rs_onew['project_c_name']?>
            </td>
            <td><?=dateform($rs['customers_p_date'])?>            </td>
            <td><a href="?fix=true&amp;customers_p_id=<?=$rs["customers_p_id"];?>"> <img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
            <td><a href="?action=del&amp;customers_p_id=<?=$rs["customers_p_id"];?>"onclick="return Conf(<?=$rs["customers_p_id"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0" /></a></td>
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
	$("#orderid_attn1").msDropdown();
	$("#project_c_id").msDropdown();
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
