<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 
if($_GET['all']=="true"){
		$_SESSION["str_FromYY2s"] = " ";
	}
	if($_GET['FromYY2s']!=" "){
		$_SESSION["str_FromYY2s"] = $_GET['FromYY2s'];
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
		
			
			<form method="get" action="#" name="form2" onSubmit="return checkvalue2()">
			  <table width="100%">
                <tr>
                  <td width="34%"> สรุปยอดใบวางบิล : </td>
                  <td width="47%" align="right">ค้นหาจากปี::
                    <select name="FromYY2s" id="FromYY2s" class="txtbox">
                      <? $tel_one = "SELECT billing_date FROM billing group by Year(billing_date)	";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{ ?>
                      <option value="<?=Yearform1($rs_one[billing_date])?>" <?php if (!(strcmp(Yearform1($rs_one[billing_date]), "$_GET[FromYY2s]"))) {echo "selected=\"selected\"";} ?>>
                      <?=Yearform1($rs_one[billing_date])?>
  </option>
                      <? } ?>
</select></td>
                  <td width="9%"><input type="submit" name="Submit3" value="ตกลง" />
                  </td>
                  <td width="10%"> |
                    <input type="button" name="Submit2"   value="ยกเลิก" onclick="window.location='re_billing1_s.php?all=true';"/>
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
    	<? if($_GET['view'] == "true"){ ?>
    	<table id="myTable2" bgcolor="#E6E6E6" width="100%">
    	  <tr>
    	    <td width="7%"></td>
    	    <td width="93%"><input type="button" name="Submit" value="กลับ" onclick="window.location='re_billing1_s.php?FromYY2s=<?=$_GET[FromYY2s]?>';"/></td>
  	    </tr>
    	  <tr>
    	    <td colspan="2">
              <?
	
			 $inputDate11 = "$_GET[billing_date]".'-01';
$strCurrDate = strtotime($inputDate11);
 $days=date("Y-m-d", mktime(date("H",$strCurrDate)+0, date("i",$strCurrDate)+0, date("s",$strCurrDate)+0, date("m",$strCurrDate)+1  , date("d",$strCurrDate)+0, date("Y",$strCurrDate)+0));
  
		$tel_one = "select * 
					from    billing  where billing_date  between '$inputDate11' and '$days' group by customers_id ";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
			///SUM(orderid.orderid_amount_en) as  orderid_amount_en	
					
			$tel_one1 = "select   SUM(billing_amount_sum) as  billing_amount_sum 
						from    billing 
						where customers_id='$rs_one[customers_id]'
						and billing_date  between '$inputDate11' and '$days'
						   	  ";
				///orderid_publish1='Yes' and  orderid_publish='Yes' and
			$get_one1 = mysql_query($tel_one1);
			
			while($rs_one1 = mysql_fetch_array($get_one1))
			{ ?>
              <table width="100%" bbilling="0">
    	      <tr>
    	        <td width="14%"><div align="right">บริษัท  :</div></td>
    	        <td width="37%">
    	          <?=$rs_one[billing_co]?></td>
    	        <td width="7%"><div align="right">ราคา :</div></td>
    	        <td width="42%"><?=$rs_one1[billing_amount_sum]?></td>
  	        </tr>
    	      <tr>
    	        <td><div align="right">เรียน :</div></td>
    	        <td><?=$rs_one[billing_attn]?></td>
    	        <td>&nbsp;</td>
    	        <td>&nbsp;</td>
  	        </tr>
  	        </table>
              <hr/>
            <? }
			}
		  ?></td>
  	    </tr>
    	  <tr>
    	    <td></td>
    	    <td>&nbsp;</td>
  	    </tr>
    	  <tr>
    	    <td></td>
    	    <td><input type="button" name="Submit6" value="กลับ" onclick="window.location='re_billing1_s.php?FromYY2s=<?=$_GET[FromYY2s]?>';"/></td>
  	    </tr>
    	  <tr>
    	    <td colspan="2"><hr/></td>
  	    </tr>
  	  </table>
    	<?
		}
	?>
      <table width="100%" border="0" cellspacing="0">
        <?
		if ($_GET[FromYY2s]!=""){
		// query area
		  $inputDate = "$_GET[FromYY2s]".'-'.'01'.'-'.'01';
$strCurrDate = strtotime($inputDate);
 $days=date("Y-m-d", mktime(date("H",$strCurrDate)+0, date("i",$strCurrDate)+0, date("s",$strCurrDate)+0, date("m",$strCurrDate)+0  , date("d",$strCurrDate)+0, date("Y",$strCurrDate)+1));
		$i=0;
			$tel = "SELECT * FROM billing where    	billing_date  between '$inputDate' and '$days' group by month(billing_date) 	
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
					
						$_GET['type_stack'] = "ASC";
					
				}
			
				if($_GET['stack']=="")
				{ 
					
						$_GET['stack'] = "billing_id";
					
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		}
	
	?>
        <thead>
          <tr>
            <td width="7%">&nbsp;</td>
            <td width="85%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="ASC"){?>
             <a href="?stack=billing2_id&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">สรุปยอดเดือน</a>
              <? }else { ?>
                <a href="?stack=billing2_id&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">สรุปยอดเดือน</a>
                <? } ?>       </td>
            <td width="8%">รายงาน</td>
          </tr>
        </thead>
        <tbody>
          <?
		  if ($_SESSION["str_FromYY2s"]!=""){
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
          <tr id="tr<?=$i?>" onmouseover='mOvr(this,&quot;#E6E6E6&quot;);' onmouseout='mOut(this,&quot;#ffffff&quot;);'>
            <td>&nbsp;</td>
            <td><?=monthform1($rs['billing_date'])?>
                <br/></td>
            <td><a href="re_billing1_s.php?view=true&amp;billing_date=<?=monthform2($rs['billing_date'])?>&FromYY2s=<?=$_GET[FromYY2s]?>"> <img src="images/view.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
          </tr>
          <?
		}
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
					echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&stack=".$_GET['stack']."&type_stack=".$_GET['type_stack']."&FromYY2s=$_GET[FromYY2s]'><< Back</a> ";
				}

				for($i=1; $i<=$Num_Pages; $i++){
					if($i != $Page)
					{
						echo "<a href='$_SERVER[SCRIPT_NAME]?Page=$i&stack=".$_GET['stack']."&type_stack=".$_GET['type_stack']."&FromYY2s=$_GET[FromYY2s]'> $i </a>";
					}
					else
					{
						echo " <font size=4 color=green><b> $i </b></font> ";
					}
				}
	
				if($Page!=$Num_Pages)
				{
					echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&stack=".$_GET['stack']."&type_stack=".$_GET['type_stack']."&FromYY2s=$_GET[FromYY2s]'>Next>></a> ";
				}
				?>
				</div>			</td>
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
