<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 
if($_GET["action"]=="insert"){
	
		$tellway  = "INSERT INTO payment VALUES(";
		$tellway .= "0
					,'$_POST[payment_name]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		echo "<script language='JavaScript'>";
		echo "window.location='payment.php';";
		echo "</script>";
	}
	// start update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="save")
	{	
		
		$sql_up = "update payment set
					payment_name     = '$_POST[payment_name]'
					where payment_id  = '".$_POST['payment_id']."'";
		$dbquery = mysql_query($sql_up);
		
		echo "<script language='JavaScript'>";
		echo "window.location='payment.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>payment</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="partner.js"></script>

<script language="JavaScript">
	
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
		if(form2.payment_gp_id.value == "") {
			alert("กรูณาเลือก กลุ่ม");
			form2.payment_gp_id.focus();
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
		
			
			<form method="get" action="payment.php" name="form2" onSubmit="return checkvalue2()">
			<table width="100%">
				<tr>
					
					<td width="52%">
						เงื่อนไขการชาระเงิน :			  	  
					    <input name="button" type="button" value="+ เพิ่มข้อมูล" onclick="window.location='payment.php?action=add';"/></td>
				

				  <td width="18%" align="right">
						
			    </td>
					<td width="4%">&nbsp;</td>
			  <td width="6%">&nbsp;</td>
			  </tr>
			</table>
			</form>
			<hr/>
			<?
		if($_GET['action']=="add"){
		
	?>
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : add data -->
    <form name="form1" action="?action=insert" method="post" onSubmit="return checkvalue('')" enctype="multipart/form-data">

	<table id="myTable" width="100%">
	  <tr>
			<td width="17%"></td>
	  <td width="83%"><input type="submit" name="Submit"   		value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   		value="ยกเลิก" onClick="window.location='payment.php';"/>			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		    <tr>
		      <td>เงื่อนไขการชาระเงิน::</td>
		      <td><?php 
 						include("FCKeditor/fckeditor.php");
						$oFCKeditor = new FCKeditor('payment_name');
						$oFCKeditor->BasePath = 'FCKeditor/';
						$oFCKeditor->Width  = '300' ;
						$oFCKeditor->Height = '150' ;
						$oFCKeditor->Value = $payment_name;
						$oFCKeditor->ToolbarSet = 'write4';
						$oFCKeditor->Create(); 
					?></td>
	      </tr>
	      <tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   value="ยกเลิก" onClick="window.location='payment.php';"/>			</td>
		</tr>
		<tr>
			<td colspan="2"><hr/></td>
		</tr>
	</table>
        
    <!--end__ : add data -->
    </form>
    <!-------------------------------------------------------------------------------------------------------------------------------------- -->
	
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
    <? } ?>
	<!--start : edit data -->
	<?
		if($_GET['fix'] == "true"){
			$tel_one = "select  * 
						from    payment
						where 
						   	   payment.payment_id = '".$_GET['payment_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
			
				$payment_id  	= $rs_one['payment_id'];
				$payment_name  	= $rs_one['payment_name'];
				
				
			}
	?>	
	<form name="form1" action="?action=save" method="post" onSubmit="return checkvalue('fix')" enctype="multipart/form-data">
	<div class="text_detail">
		รายละเอียด : สร้างวันที่ : <?=dateform($payment_date)?> [ <?=$payment_poster?> ] , แก้ไขล่าสุดวันที่ <?=dateform($payment_update)?> , [ <?=$payment_updater?> ]
	</div>
	<table id="myTable" bgcolor="#E6E6E6" width="100%">
		<tr>
			<td width="17%"></td>
			<td width="83%">
				<input type="hidden" name="payment_id" 		value="<?=$payment_id?>">
				<input type="submit" name="Submit"   		value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   		value="ยกเลิก" onClick="window.location='payment.php';"/>			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		    <tr>
		      <td>เงื่อนไขการชาระเงิน::</td>
		      <td><?php 
 						include("FCKeditor/fckeditor.php");
						$oFCKeditor = new FCKeditor('payment_name');
						$oFCKeditor->BasePath = 'FCKeditor/';
						$oFCKeditor->Width  = '300' ;
						$oFCKeditor->Height = '150' ;
						$oFCKeditor->Value = $payment_name;
						$oFCKeditor->ToolbarSet = 'write4';
						$oFCKeditor->Create(); 
					?></td>
	      </tr>
	      <tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit"   value="ยกเลิก" onClick="window.location='payment.php';"/>			</td>
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
					from    payment
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
					
						$_GET['stack'] = "payment_id";
					
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>	
  	<thead>
		<tr>
		  <td width="7%">ลำดับ</td>
			<td width="93%">เงื่อนไขการชาระเงิน</td>
			<td width="7%">แก้ไข</td>
			<td width="4%">ลบ</td>
		</tr>
	</thead>
	<tbody>
	
	<?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
  	<tr id="tr<?=$i?>" onMouseOver='mOvr(this,"#E6E6E6");' onMouseOut='mOut(this,"#ffffff");'>
  	  <td><?=$rs['payment_id']?></td>
		<td><?=$rs['payment_name']?>
			</td>
		<td><a href="?fix=true&amp;payment_id=<?=$rs["payment_id"];?>"> <img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
		<td><a href="?action=del&amp;orderid_id=<?=$rs["payment_id"];?>"onclick="return Conf(<?=$rs["payment_id"];?>)"><img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0" /></a> </td>
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
