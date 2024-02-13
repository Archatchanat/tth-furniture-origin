<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 
	if($_GET['orderid_id']!=""){
	$_SESSION["orderid_ids"] = $_GET['orderid_id'];
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

<script language="JavaScript">
	function checkvalue(action){
		filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(form1.orderid_id.value == "") {
			alert("กรุณากรอก ใบเสนอราคา");
			form1.orderid_id.focus();
			return false
		}
		if(form1.orderid_attn.value == "") {
			alert("กรุณากรอก เรียน");
			form1.orderid_attn.focus();
			return false
		}
		if(form1.orderid_co.value == "") {
			alert("กรุณาเลือก บริษัท");
			form1.orderid_co.focus();
			return false
		}
		if(form1.orderid_tel.value == "") {
			alert("กรุณาเลือก โทรศัพท์");
			form1.orderid_tel.focus();
			return false
		}if(form1.orderid_mail.value == ""){
			alert("กรุณากรอก อีเมลล์");
			form1.orderid_mail.focus();
			return false
		}
		if (!(filter.test(form1.orderid_mail.value))) {
			alert("กรุณากรอก รูปแบบอีเมลล์ให้ถูกต้อง");
			form1.orderid_mail.value = ""
			form1.orderid_mail.focus();
			return false;
		}
		if(form1.orderid_date.value == ""){
			alert("กรุณากรอก วันที่ ");
			form1.orderid_date.focus();
			return false
		}
		
		if(form1.bid_id.value == ""){
			alert("กรุณาเลือก จาก  ");
			form1.bid_id.focus();
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
                  <input name="button" type="button" value="กลับ" onclick="window.location='billing.php';"/></td>
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
                      <input name="orderid_attn" type="text" id="orderid_attn" value="<?=$rs_one4['customers_name']?>" size="50" />
                      <input type="hidden" name="customers_p_id"  id="customers_p_id" value="<?=$_GET['customers_p_id']?>" />                    </td>
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
                    <td><input name="orderid_mail" type="text" id="orderid_mail" value="<?=$rs_one4['customers_email']?>" size="50" />
                    <div  style="color:#000" id="customers_email"> </div></td>
                    <td><div align="right">อีเมล์ :</div></td>
                    <td><div  style="color:#000" id="bid_email"> </div>
                    <input type="hidden" name="bid_email1" id="bid_emails" /></td>
                  </tr>
                </table></td>
			</tr>
			<tr>
              <td width="8%"></td>
			  <td width="92%">
			    <select name="orderid_detail1" id="select">
		        <option value="">
  กรุณาเลือก  </option>
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
			  <td colspan="2"><table width="917" border="0" cellspacing="0">
                <tr>
                  <th width="7%" scope="col">No.</th>
                  <th width="12%" scope="col">NAME</th>
                  <th width="27%" scope="col" align="center">Description</th>
                  <th width="11%" scope="col" >Qty.</th>
                  <th width="7%" scope="col">Unit</th>
                  <th width="12%" scope="col">Price</th>
                  <th width="11%" scope="col"><div align="left">Total</div></th>
                  <th width="13%" scope="col">&nbsp;</th>
                </tr>
 <script type="text/javascript">
$(document).ready(function(){
    var i = 1; var cnt = 20; var html = '';
    //create object
    for(i=1;i<=cnt;i++){
		
        html +=  '<input name="no['+i+']" type="text" id="no['+i+']" size="5" />&nbsp;';
		html +=  '<input name="name['+i+']" type="text" id="name['+i+']" size="10" />&nbsp;';
		html +=  '<input name="description['+i+']" type="text" id="description['+i+']" size="40" />&nbsp;';
        html += '<input type ="text" name="qty['+i+']" id="qty_'+i+'"  size="7" autocomplete="off"/>&nbsp;';
		html +=  '<input name="detail_unit['+i+']" type="text" id="detail_unit['+i+']" size="7" />&nbsp;';
        html += '<input type ="text" name="price['+i+']" id="price_'+i+'" size="7" autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="total['+i+']" readonly="readonly"  id="total_'+i+'" size="7"/>&nbsp;';
		html += '</br>';
		$("#form1").html(html); 
       
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
                  <td colspan="8"><div id="form1"></div></td>
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
			  <td><input type="radio" name="orderid_publish" value="Yes" checked="checked" />
			     ส่งแล้ว&nbsp;
                   <input type="radio" name="orderid_publish" value="No" />
			    ไม่ส่ง </td>
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
	<form name="form1" action="?action=save" method="post" onSubmit="return checkvalue('fix')" enctype="multipart/form-data">
	<div class="text_detail">
		รายละเอียด : สร้างวันที่ : <?=dateform($orderid_date1)?> [ <?=$orderid_poster?> ] , แก้ไขล่าสุดวันที่ <?=dateform($orderid_update)?> , [ <?=$orderid_updater?> ]
	</div>
	<table id="myTable" bgcolor="#E6E6E6" width="100%">
		<tr>
			<td width="7%"></td>
			<td width="93%">
				<input type="hidden" name="company_id" 		value="<?=$company_id?>">
				<input type="hidden" name="orderid_num"  	value="<?=$orderid_num?>">
				<input type="button" name="Submit4" value="ยกเลิก" onclick="window.location='billing_edit.php?orderid_id=<?=$orderid_id?>';"/></td>
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
				$tel_one = "select  * from    customers_project where customers_p_id='".$_SESSION["str_customers_p_id"]."'
						";
			$get_one = mysql_query($tel_one);
			$rs_one = mysql_fetch_array($get_one);
				$customers_p_id  	= $rs_one['customers_p_id'];
				
			}
			?>
                      <input name="orderid_attn" type="text"  id="customers_name" value="<?=$orderid_attn?>" size="40" />
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
            </table></td>
		</tr>
  			<tr>
    			<td align="right">&nbsp;</td>
    			<td align="left">
             <?=$orderid_detail1?></td>
  			</tr>
		    <tr>
		      <td colspan="2"><table width="917" border="0" cellspacing="0">
                <tr>
                  <th width="5%" scope="col">No.</th>
                  <th width="10%" scope="col">NAME</th>
                  <th width="39%" scope="col">Description</th>
                  <th width="8%" scope="col"><div align="left">Qty.</div></th>
                  <th width="7%" scope="col"><div align="left">Unit</div></th>
                  <th width="8%" scope="col"><div align="left">Price</div></th>
                  <th width="20%" scope="col"><div align="left">Total</div></th>
                  <th width="3%" scope="col">&nbsp;</th>
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
		
        html +=  '<input name="no[<?=$i?>]" type="text" id="no[<?=$i?>]" value="<?=$order_detail_no["$i"]?>"  size="5" />&nbsp;';
		html +=  '<input name="name[<?=$i?>]" type="text" id="name[<?=$i?>]" size="10" value="<?=$order_detail_name["$i"]?>"/>&nbsp;';
		html +=  '<input name="description[<?=$i?>]" type="text" id="description[<?=$i?>]" value="<?=$order_detail_description["$i"]?>"size="40" />&nbsp;';
        html += '<input type ="text" name="qty[<?=$i?>]" id="qty_<?=$i?>" value="<?=$order_detail_qty["$i"]?>" size="7" autocomplete="off"/>&nbsp;';
		html +=  '<input name="detail_unit[<?=$i?>]" type="text" id="detail_unit[<?=$i?>]" value="<?=$order_detail_unit["$i"]?>" size="7" />&nbsp;';
        html += '<input type ="text" name="price[<?=$i?>]" id="price_<?=$i?>" size="7"  value="<?=$order_detail_price["$i"]?>"  autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="total[<?=$i?>]"  id="total_<?=$i?>"    value="<?=$order_detail_total["$i"]?>"size="7"/>&nbsp;';
		html += '<input type ="hidden" name="order_details_id[<?=$i?>]"  id="order_details_id[<?=$i?>]"   value="<?=$order_detail_id["$i"]?>" size="7"/>';
		html += '</br>';
		$("#form1").html(html);
  <?  } ?>
  <? $i1=$i+1?>
   var i =<?=$i1?> ; var cnt = 20;
    //create object
    for(i=<?=$i1?>;i<=cnt;i++){
		
        html +=  '<input name="no['+i+']" type="text" id="no['+i+']" size="5" />&nbsp;';
		html +=  '<input name="name['+i+']" type="text" id="name['+i+']" size="10" />&nbsp;';
		html +=  '<input name="description['+i+']" type="text" id="description['+i+']" size="40" />&nbsp;';
        html += '<input type ="text" name="qty['+i+']" id="qty_'+i+'"  size="7" autocomplete="off"/>&nbsp;';
		html +=  '<input name="detail_unit['+i+']" type="text" id="detail_unit['+i+']" size="7" />&nbsp;';
        html += '<input type ="text" name="price['+i+']" id="price_'+i+'" size="7" autocomplete="off"/>&nbsp;';
        html += '<input type ="text" name="total['+i+']" readonly="readonly" id="total_'+i+'" size="7"/>&nbsp;';
		html += '</br>';
		$("#form1").html(html); 
       
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
   
                  <div id="form1"></div>
             

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
              <td><input type="radio" name="orderid_publish" value="Yes" <? if($orderid_publish=="Yes"){?>checked="checked"<? } ?> />
                ส่งแล้ว&nbsp;
                    <input type="radio" name="orderid_publish" value="No" <? if($orderid_publish=="No"){?>checked="checked"<? } ?> />
              ไม่ส่ง</td>
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
              <td>&nbsp;</td>
            </tr>
          <tr>
			<td></td>
			<td><input type="button" name="Submit5" value="ยกเลิก" onclick="window.location='billing.php';"/></td>
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
	  <form name="list" method="post" action="?action=del_sel" onsubmit="return ConfAll()">
	  <table width="100%" border="0" cellspacing="0">
        <?
		// query area
		$i=0;
		if( $_SESSION["str_search"] ==""){
			$tel = "select * 
					from    orderid
					where  
						   orderid_id = '".$_SESSION["orderid_ids"]."'";
		} else {
		$search=$_GET[search1];
			$tel = "select * 
					from    orderid
					where  
						   $search like '%".$_SESSION["str_search"]."%' and orderid_id = '".$_SESSION["orderid_ids"]."'";
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
            <td width="5%">พิมพ์</td>
            <td width="5%">เลือก</td>
            </tr>
        </thead>
        <tbody>
          <?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
          <tr id="tr<?=$i?>" onmouseover='mOvr(this,&quot;#E6E6E6&quot;);' onmouseout='mOut(this,&quot;#ffffff&quot;);'>
            <td><?=$rs['orderid_id']?></td>
            <td><?=$rs['orderid_co']?>
              <br/>
              <font class="text_small_gray">เรียน
              <?=$rs['orderid_attn']?>
              </font></td>
            <td><?=dateform($rs['orderid_date1'])?>
                <br/>
                <font class="text_small_gray">By
                  <?=$rs['orderid_poster']?>
                </font> </td>
            <td><?php if (!(strcmp($rs['orderid_publish'], "Yes"))) {echo "ส่งแล้ว";} ?>
                <?php if (!(strcmp($rs['orderid_publish'], "No"))) {echo "ไม่ส่ง";} ?>            </td>
            <td><a href="MPDF56/examples/example01_basic.php?orderid_id=<?=$rs["orderid_id"];?>" target="_blank"> <img src="images/view.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
            <td><a href="billing_edit.php?fix=true&amp;orderid_id=<?=$rs["orderid_id"];?>&orderid_num=<?=$rs["orderid_num"];?>"> <img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
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
