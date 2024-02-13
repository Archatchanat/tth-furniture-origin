<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 
if($_GET['all']=="true"){
		$_SESSION["str_search"] = "";
	}
	if($_GET['customers_p_id']!=""){
		$_SESSION["str_customers_p_id"] = $_GET['customers_p_id'];
	}
	if($_GET['customers_p_id']==""){
	$_SESSION["str_customers_p_id"] = "";
	}
	if($_GET['customers_id']!=""){
	$_SESSION["str_customers_id"] = $_GET['customers_id'];
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>billing</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="partner.js"></script>
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
                  <td width="34%">ประวัติออกเอกสาร
                  <input name="button" type="button" value="กลับ" onclick="window.location='project.php?search=<?=$_SESSION["str_search"]?>';"/></td>
                </tr>
              </table>
		  </form>
			<hr/>
			
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
		
		
		$search=$_GET[customers_p_id];
			$tel = "select orderid_id,orderid_co,orderid_attn,orderid_publish,orderid_date1 from    orderid  
					where  
						   customers_p_id = '".$_SESSION["str_customers_p_id"]."' and orderid_publish1='Yes'
					UNION
					select billing_id,billing_co,billing_attn,billing_publish,billing_date1 from    billing  
					where  
						   customers_p_id = '".$_SESSION["str_customers_p_id"]."'
					UNION
					select billing2_id,billing2_co,billing2_attn,billing2_publish,billing2_date1 from    billing2  
					where  
						   customers_p_id = '".$_SESSION["str_customers_p_id"]."'
					
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
						$_GET['stack'] = "orderid_id";
					} else {
						$_GET['stack'] = "orderid_id";
					}
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>
        <thead>
          <tr>
            <td width="11%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=orderid_id&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">หมายเลข    </a>
                <? }else { ?>
                <a href="?stack=orderid_id&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">หมายเลข    </a>
              <? } ?>            </td>
            <td width="55%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=orderid_attn&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">ชื่อเอกสาร</a>
                <? }else { ?>
                <a href="?stack=orderid_attn&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">ชื่อเอกสาร</a>
              <? } ?>            </td>
            <td width="12%"><a href="?stack=orderid_date1&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a> </td>
            <td width="12%">สถานะ </td>
            <td width="10%">พิมพ์</td>
            </tr>
        </thead>
        <tbody>
          <?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
          <tr id="tr<?=$i?>" onmouseover='mOvr(this,&quot;#E6E6E6&quot;);' onmouseout='mOut(this,&quot;#ffffff&quot;);'>
            <td><?=$rs['orderid_id']?>            </td>
            <td><? $orderid_idts= substr ($rs[orderid_id],0,2);
			
			 if (!(strcmp($orderid_idts, "In"))) {
			echo "ใบวางบิล";
			 };
			 if (!(strcmp($orderid_idts, "Qu"))) {
			  	echo "ใบเสนอราคา";
			 };
			 if (!(strcmp($orderid_idts, "Iv"))) {
			 	echo "ใบเสร็จรับเงิน";
			 };?>
              <br/>
              <font class="text_small_gray">เรียน
              <?=$rs['orderid_attn']?>
              </font></td>
            <td><?=dateform($rs['orderid_date1'])?>
            </td>
            <td>
			<? 
			 if (!(strcmp($orderid_idts, "In"))) {
			 if (!(strcmp($rs['orderid_publish'], "Yes"))) {echo "วางบิล";}
			 if (!(strcmp($rs['orderid_publish'], "No"))) {echo "ไม่วางบิล";}
			 };
			 if (!(strcmp($orderid_idts, "Qu"))) {
			  if (!(strcmp($rs['orderid_publish'], "Yes"))) {echo "ส่งแล้ว";} 
			 if (!(strcmp($rs['orderid_publish'], "No"))) {echo "ไม่ส่งแล้ว";}
			
			 };
			 if (!(strcmp($orderid_idts, "Iv"))) {
			  if (!(strcmp($rs['orderid_publish'], "Yes"))) {echo "จ่ายแล้ว";}
			 if (!(strcmp($rs['orderid_publish'], "No"))) {echo "ไม่จ่าย";}
			 
			 };?>			</td>
            <td><a href="MPDF56/examples/<? if (!(strcmp($orderid_idts, "Qu"))) {echo"example01_basic.php?orderid_num=$rs[orderid_num]";};
				if (!(strcmp($orderid_idts, "In"))) {echo"re_billing1.php?billing_id=$rs[orderid_id]"; };
				if (!(strcmp($orderid_idts, "Iv"))) {echo"re_billing2.php?billing2_id=$rs[orderid_id]"; };?>" target="_blank"> <img src="images/view.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
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
	$("#bid_id").msDropdown();
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
