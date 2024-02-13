<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 
	if($_GET['all']=="true"){
		$_SESSION["str_prod_name"] = "";
	}
	
	if($_GET['prod_name']!=""){
		$_SESSION["str_prod_name"] = $_GET['prod_name'];
	}


	// start insert ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="insert")
	{
		// start resize picture		
		$tellway  = "INSERT INTO products VALUES(";
		$tellway .= "'$_POST[prod_id]'
					,'$_POST[prod_name]'
					,'$_POST[type2_id]'
					,'$_POST[commu_id]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		
		
		echo "<script language=\"JavaScript\">";
		echo "window.location='products.php';";
		echo "</script>";
    }
	// end__ insert ----------------------------------------------------------------------------------------------------------------------
	
	// start update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="save")
	{	
		// start resize picture	
	
		
		$sql_up = "update products set
					 prod_name   = '$_POST[prod_name]' 
					 ,type2_id   = '$_POST[type2_id]' 
					   ,commu_id   = '$_POST[commu_id]' 
					where prod_id     = '".$_POST['prod_id']."'";
		$dbquery = mysql_query($sql_up);
		
		
		echo "<script language='JavaScript'>";
		echo "window.location='products.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	
	// start delete ----------------------------------------------------------------------------------------------------------------------
	
	if($_GET["action"]=="del")
	{
		///$have = num_record("admin","where admin_gp_id = '".$_GET["admin_gp_id"]."'");
		
		///if($have == 0 ){
			$sql_del= "delete from products where prod_id='".$_GET["prod_id"]."'";
			$dbquery_del = mysql_query($sql_del);
			
			
			echo "<script language='JavaScript'>";
		echo "window.location='products.php';";
		echo "</script>";
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>
<link href="style.css" rel="stylesheet" type="text/css" />
 <script src="js/jquery-1.8.2.min.js"></script>
<script language="JavaScript">
	function checkvalue(action){
		if(form1.prod_id.value == "") {
			alert("กรุณากรอก รหัสผลิตภัณฑ์");
			form1.prod_id.focus();
			return false
		}
		
		
		
		if(form1.prod_name.value == "") {
			alert("กรุณากรอก ชื่อผลิตภัณฑ์");
			form1.prod_name.focus();
			return false
		} 
		if(form1.type2_id.value == "") {
			alert("กรุณาเลือก ประเภทผลิตภัณฑ์");
			form1.type2_id.focus();
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
		if(form2.question_cat_id.value == "") {
			alert("กรุณาเลือก หมวดหมู่");
			form2.question_cat_id.focus();
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
		
			
			<form method="get" action="products.php" name="form2" onSubmit="return checkvalue2()">
			<table width="100%">
				<tr>
					
					<td width="56%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="38%">ผลิตภัณฑ์ :
                  <?  if($_SESSION["str_admin_save"]=="Yes"){?>                    <input name="button" type="button" value="+ เพิ่มข้อมูล" onclick="window.location='products1.php?action=add';"/>
                  <? }?></td>
                  <td width="62%"> <div align="right">ค้นหาจาก<a href="?stack=type_name&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">รายชื่อภาค</a>::
                      <input name="prod_name" type="text" id="prod_name" value="<?=$_SESSION["str_prod_name"]?>" size="30" />
                      <input type="submit" name="Submit8" value="ตกลง" />
|
<input type="button" name="Submit7"   value="ทั้งหมด" onclick="window.location='products.php?all=true';"/>
                  </div></td>
                </tr>
      </table></td>
				

					
				</tr>
			</table>
			</form>
			<hr/>
			
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : add data -->
	<?
		if($_GET['action']=="add" ){
		
			
	?>
    <link rel="stylesheet" type="text/css" href="css/dd.css" />
<script src="js/jquery.dd.min.js"></script>
<script type="text/javascript" src="partner.js"></script>

	<form name="form1" action="?action=insert" method="post" onSubmit="return checkvalue('')"  enctype="multipart/form-data">
		<table width="100%">
			<tr>
				<td colspan="2">&nbsp;</td>
		  </tr>
			<tr>
				<td width="20%" align="right">ชื่อผลิตภัณฑ์ ::</td>
			  <td width="80%"><input name="prod_name" class="textinputdotted" type="text" id="part_name" value="<?=$prod_name?>" size="50"/></td>
			</tr>
			<tr>
			  <td align="right">ประเภท::</td>
               <?  $tel_one = "select *
						from   products_subcategory LEFT JOIN products_category ON products_subcategory.type_id = products_category.type_id  where products_subcategory.type_id='$_GET[type_id]'
						";
				
			$get_one = mysql_query($tel_one);
			
			$rs_one = mysql_fetch_array($get_one);?>
			  <td><?=$rs_one['type_name']?>
		      <input name="type2_id" type="hidden" id="type2_id" value="<?=$_GET['type2_id']?>" /></td>
		  </tr>
			<tr>
			  <td align="right">ประเภทผลิตภัณฑ์::</td>
			  <td><?=$rs_one['type2_name']?></td>
		  </tr>
			<tr>
			  <td align="right">&nbsp;</td>
		    <td>
                 <?php if (!(strcmp("$rs_one[type_detail]","1"))) {echo "กระทรวงมหาดไทย";} ?>
            <?php if (!(strcmp("$rs_one[type_detail1]","1"))) {echo "อย";} ?></td>
		  </tr>
			<tr>
              <td align="right">ผู้ผลิต::</td>
			  <td><label></label>
                  <select style="width:300px"  name="commu_id" id="assis_id">
                    <option value="">กรุณาเลือก</option>
                    <?  $tel_one = "select *
						from   customers
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
                    <option value="<?=$rs_one['customers_id'];?>"><?=$rs_one['customers_name'];?></option>
                    <? } ?>
                  </select>              </td>
		  </tr>
			<tr>
				<td colspan="2">&nbsp;</td>
		  </tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="Submit" value="ยืนยันข้อมูล" >
					<input type="button" name="Submit" value="ยกเลิก" onClick="window.location='products.php';"/>				</td>
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
		if($_GET['fix'] == "true" ){
	
			$tel_one = "select *
						from   products
						where   prod_id = '".$_GET['prod_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
				$prod_id = $rs_one['prod_id'];
				$prod_name = $rs_one['prod_name'];
				$type2_id = $rs_one['type2_id'];
				$commu_id = $rs_one['commu_id'];
			
				
			}
	?>	
    <link rel="stylesheet" type="text/css" href="css/dd.css" />
<script src="js/jquery.dd.min.js"></script>
<script type="text/javascript" src="partner.js"></script>
	<form name="form1" action="?action=save" method="post" onSubmit="return checkvalue('fix')" enctype="multipart/form-data">
	  <table id="myTable"  width="100%">
		<tr>
			<td width="16%"></td>
			<td width="85%">
				<input type="hidden" name="prod_id" 	value="<?=$prod_id?>">
				<input type="submit" name="Submit"   	value="บันทึกข้อมูล" >
				<input type="button" name="Submit2" value="ยกเลิก" onclick="window.location='products.php';"/></td>
		</tr>
		<tr>
			<!--<td align="right">รหัสผลิตภัณฑ์ ::</td>
			  <td><input name="prod_id" type="text" class="textinputdotted" readonly="readonly" id="prod_id" value="<?=$prod_id?>" size="20" /></td> -->
		  </tr>
			<tr>
				<td width="20%" align="right">ชื่อผลิตภัณฑ์ ::</td>
			  <td width="80%"><input name="prod_name" class="textinputdotted" type="text" id="part_name" value="<?=$prod_name?>" size="50"/></td>
			</tr>
			<tr>
            <?  
			if($_GET['type_id']!=""){
			$type2_id="$_GET[type2_id]";
			}
			$tel_one = "select *
						from    products_subcategory LEFT JOIN products_category ON products_subcategory.type_id = products_category.type_id  where type2_id='$type2_id'
						";
			$get_one = mysql_query($tel_one);
			$rs_one = mysql_fetch_array($get_one);
			?>
			  <td align="right">ประเภท::</td>
			  <td><?=$rs_one['type_name']?>
                <input name="type2_id" type="hidden" id="type2_id" value="<?=$_GET['type2_id']?>" />
                <a href="products1.php?action=edit&amp;prod_id=<?=$prod_id?>">
                <? if ($_SESSION["str_admin_edit"]=="Yes") { ?>
                <img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/>
                <? } ?>
              </a></td>
		  </tr>
			<tr>
			  <td align="right">ประเภทผลิตภัณฑ์::</td>
			  <td><?=$rs_one['type2_name']?></td>
		  </tr>
			<tr>
			  <td align="right">&nbsp;</td>
		    <td>
                 <?php if (!(strcmp("$rs_one[type_detail]","1"))) {echo "กระทรวงมหาดไทย".'<br/>';} ?>
            <?php if (!(strcmp("$rs_one[type_detail1]","1"))) {echo "อย";} ?></td>
		  </tr>
			<tr>
              <td align="right">ผู้ผลิต::</td>
			  <td><label></label>
                <select style="width:300px"  name="commu_id" id="assis_id">
                  <option value="" <?php if (!(strcmp("", "$commu_id"))) {echo "selected=\"selected\"";} ?>>กรุณาเลือก</option>
                  <?  $tel_one = "select *
						from   commu
						";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{?>
                  <option value="<?=$rs_one['commu_id'];?>" <?php if (!(strcmp($rs_one['commu_id'], "$commu_id"))) {echo "selected=\"selected\"";} ?>>
                  <?=$rs_one['commu_id'];?>
                  <?=$rs_one['commu_name'];?>
                  </option>
<? } ?>
                  </select>              </td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="Submit"   value="บันทึกข้อมูล" >
				<input type="button" name="Submit3" value="ยกเลิก" onclick="window.location='products.php';"/></td>
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
	
		if($_SESSION["str_part_name"] ==""){
		
			$tel = "select *
					from   products LEFT JOIN products_subcategory ON products.type2_id = products_subcategory.type2_id     
					LEFT JOIN commu ON products.commu_id = commu.commu_id LEFT JOIN products_category ON products_category.type_id = products_subcategory.type_id
					
					
				
					";
		} else {
			$tel = "select *
					from   products LEFT JOIN products_subcategory ON products.type2_id = products_subcategory.type2_id     
					LEFT JOIN commu ON products.commu_id = commu.commu_id LEFT JOIN products_category ON products_category.type_id = products_subcategory.type_id     
					where   part_name  like '%".$_SESSION["str_part_name"]."%'";
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
					if( $_SESSION["str_service_cat_id"] == ""){
						$_GET['type_stack'] = "DESC";
					} else {
						$_GET['type_stack'] = "DESC";
					}
				}
			
				if($_GET['stack']=="")
				{ 
					if( $_SESSION["str_service_cat_id"] ==""){
						$_GET['stack'] = "prod_id";
					} else {
						$_GET['stack'] = "prod_id";
					}
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>	
  	<thead>
		<tr>
			<td width="13%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=prod_id&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">รหัสผลิตภัณฑ์</a><a href="?stack=type_id&type_stack=ASC" style="text-decoration:none; color:#000000;"></a>
				<? }else { ?>
   					<a href="?stack=prod_id&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">รหัสผลิตภัณฑ์</a><a href="?stack=type_id&type_stack=DESC" style="text-decoration:none; color:#000000;"></a>
				<? } ?>			</td>
			<td width="29%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="?stack=prod_name&type_stack=ASC" style="text-decoration:none; color:#000000;">ชื่อผลิตภัณฑ์</a>
				<? }else { ?>
   					<a href="?stack=prod_name&type_stack=DESC" style="text-decoration:none; color:#000000;">ชื่อผลิตภัณฑ์</a>
				<? } ?>			</td>
			<td width="29%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
			  ประเภทผลิตภัณฑ์
			  <? }else { ?>
			  ประเภทผลิตภัณฑ์
  <? } ?>            </td>
			<td width="23%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
				ผู้ผลิต
				<? }else { ?>
				ผู้ผลิต				<? } ?>			</td>
			<td width="4%">แก้ไข</td>
			<td width="2%">ลบ</td>
			</tr>
	</thead>
	<tbody>
	
	<?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
  	<tr id="tr<?=$i?>" onMouseOver='mOvr(this,"#E6E6E6");' onMouseOut='mOut(this,"#ffffff");'>
    	<td valign="top">
    	  <?=$rs['prod_id']?>  	  </td>
		<td valign="top">
		  <?=$rs['prod_name']?>
		  <br/>		   </td>
		<td>
        <font class="text_small_gray">
        <?php if (!(strcmp("$rs[type_detail]","1"))) {echo "กระทรวงมหาดไทย".'<br/>';} ?>
            <?php if (!(strcmp("$rs[type_detail1]","1"))) {echo "อย".'<br/>';} ?></font>
         <? echo $rs['type2_name'];?></td>
		<td valign="top"><?=$rs['commu_id'];?> <?=$rs['commu_name'];?><br/></td>
		<td><a href="?fix=true&prod_id=<?=$rs["prod_id"];?>">
		  <? if ($_SESSION["str_admin_edit"]=="Yes") { ?>
		  <img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/>
		  <? } ?>
		</a></td>
		<td><a href="?action=del&amp;prod_id=<?=$rs["prod_id"];?>"onclick="return Conf(<?=$rs["prod_id"];?>)">
		  <? if ($_SESSION["str_admin_del"]=="Yes") { ?>
		  <img src="images/_delete_data.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'" border="0" />
		  <? } ?>
		</a> </td>
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
				<div class="general">รวม <?= $Num_Rows;?> รายการ : 
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
	$("select").msDropdown();
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

</body>

</html>
