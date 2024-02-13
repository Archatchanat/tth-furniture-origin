<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 
	if($_GET['all']=="true"){
		$_SESSION["str_search_re"] = "";
	}
	if($_GET['search']!=""){
		$_SESSION["str_search_re"] = $_GET['search'];
	}
	if($_GET['search']==""){
	$_SESSION["str_search_re"] = "";
	}
	if($_GET[fix]=="true"){ $edit="&fix=true&orderid_id=$_GET[orderid_id]&edit=true";}else{$edit="action=add";}
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
		
			
			<form method="get" action="billing2_customers.php" name="form2" onSubmit="return checkvalue2()">
			<table width="100%">
				<tr>
					
					<td width="26%">
						ชื่อลูกค้า : 
					  <input name="button" type="button" value="กลับ" onclick="window.location='billing2.php';"/>
                      <? if($_GET[fix]=="true"){?>
					  <input type="hidden" name="fix" id="fix"  value="true"/>
					  <input type="hidden" name="billing2_id" id="billing2_id" value="<?=$_GET[billing2_id]?>" />
					  <input type="hidden" name="edit" id="edit"  value="true"/>
                      <? } else { ?>
					  <input type="hidden" name="action" id="action" value="add"/>
                      <? } ?>
                      </td>
				

				  <td width="57%" align="right">ค้นหา
                    <input name="search" type="text" id="search" value="<?=$_SESSION["str_search_re"]?>" size="50" />
เลือก
<select name="search1" id="search1">
  <option value="customers_com" <?php if (!(strcmp($_GET[search1], "customers_com"))) {echo "selected=\"selected\"";} ?>>บริษัท</option>
<!--  <option value="customers_name" <?php if (!(strcmp($_GET[search1], "customers_name"))) {echo "selected=\"selected\"";} ?>>ชื่อ</option>
 --></select>			    </td>
	  <td width="6%">
	  <input type="submit" name="Submit3" value="ตกลง" /> 
				  </td>
	  <td width="11%">
						| 
                        
			  <input type="button" name="Submit"   value="ทั้งหมด" onClick="window.location='billing2_customers.php?all=true<?=$edit?>';"/>
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
		
		if( $_SESSION["str_search_re"] ==""){
			$tel = "select * 
					from    customers  where customers_publish='Yes'
					 ";
		} else {
		$search=$_GET[search1];
			$tel = "select * 
					from    customers
					where  customers_publish='Yes' and  
						   $search  like '%".$_SESSION["str_search_re"]."%'";
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
			<td width="15%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=customers_rank&type_stack=ASC" style="text-decoration:none; color:#000000;">ลำดับ</a>
				<? }else { ?>
   					<a href="?stack=customers_rank&type_stack=DESC" style="text-decoration:none; color:#000000;">ลำดับ</a>
				<? } ?>                </td>

			<td width="37%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=customers_name&type_stack=ASC" style="text-decoration:none; color:#000000;">บริษัท </a>
				<? }else { ?>
   					<a href="?stack=customers_name&type_stack=DESC" style="text-decoration:none; color:#000000;">บริษัท </a>
				<? } ?>			</td>
			<td width="41%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>ที่อยู่<? }else { ?>
   					<a href="?stack=customers_date&type_stack=DESC" style="text-decoration:none; color:#000000;">ที่อยู่</a>
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
		<td>
			<?=$rs['customers_id']?>		</td>
		
		<td><?=$rs['customers_com']?>
<br/>
			<font class="text_small_gray"><?=$rs['customers_name']?></font>
			<br/></td>
		<td>
			<font class="text_small_gray"><?=$rs['customers_address'];?> </font>		</td>
		<td>
			<a href="billing2_customers_p.php?<? if($_GET[fix]=="true"){echo "fix=true&billing2_id=$_GET[billing2_id]&edit=true";}else{echo"action=add";}?>&customers_id=<?=$rs["customers_id"];?>">
				<img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/>			</a>		</td>
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
				
					echo " <a href='$_SERVER[SCRIPT_NAME]?$edit&Page=$Prev_Page&stack=".$_GET['stack']."&type_stack=".$_GET['type_stack']."'><< Back</a> ";
				}

				for($i=1; $i<=$Num_Pages; $i++){
					if($i != $Page)
					{
						echo "<a href='$_SERVER[SCRIPT_NAME]?$edit&Page=$i&stack=".$_GET['stack']."&type_stack=".$_GET['type_stack']."'> $i </a>";
					}
					else
					{
						echo " <font size=4 color=green><b> $i </b></font> ";
					}
				}
	
				if($Page!=$Num_Pages)
				{
					echo " <a href ='$_SERVER[SCRIPT_NAME]?$edit&Page=$Next_Page&stack=".$_GET['stack']."&type_stack=".$_GET['type_stack']."'>Next>></a> ";
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
