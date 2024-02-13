<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 
if($_GET['all']=="true"){
	$_SESSION["str_searchs_1"]= "";
		$_SESSION["str_searchs_2"]= "";
	}
	if($_GET['searchs_1']!="" and $_GET['searchs_2']!=""){
		$_SESSION["str_searchs_1"] = $_GET['searchs_1'];
		$_SESSION["str_searchs_2"] = $_GET['searchs_2'];
	}
	if($_GET['searchs_1']==""){
	$_SESSION["str_searchs_1"] = "";
	$_SESSION["str_searchs_2"] = "";
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
		
			
			<form method="get" action="#" name="form2" onSubmit="return checkvalue2()">
			  <table width="100%">
                <tr>
                  <td width="34%"> report ใบเสนอราคา : </td>
                  <td width="47%" align="right">ค้นหา
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
});  

                </script>
                      <input name="searchs_1" class="textinputdotted" type="text" id="dateInput" value="<?=$_SESSION[str_searchs_1]?>" size="20"/>
                    ถึง
                    <input name="searchs_2" class="textinputdotted" type="text" id="dateInput2" value="<?=$_SESSION[str_search_2]?>" size="20"/></td>
                  <td width="9%"><input type="submit" name="Submit3" value="ตกลง" />
                  </td>
                  <td width="10%"> |
                    <input type="button" name="Submit2"   value="ทั้งหมด" onclick="window.location='re_billing1_all.php?all=true';"/>
                  </td>
                </tr>
              </table>
		  </form>
			<hr/>
			
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : add data --><?
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
				$billing_address  	= $rs_one['customers_address'];
			}
			$tel_one = "select  * from    customers_project where customers_p_id='".$_SESSION["str_customers_p_id"]."'
						";
			$get_one = mysql_query($tel_one);
			$rs_one = mysql_fetch_array($get_one);
				$customers_p_id  	= $rs_one['customers_p_id'];
			?>
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
          <td><input type="radio" name="billing_publish" value="Yes" <? if($billing_publish=="Yes"){?>checked="checked"<? } ?> />
            วางบิล&nbsp;
            <input type="radio" name="billing_publish" value="No" <? if($billing_publish=="No"){?>checked="checked"<? } ?> />
            รอวางบิล</td>
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
	<form name="list" method="post" action="#" onsubmit="return ConfAll()">
	  <table width="100%" bbilling="0" cellspacing="0">
        <?
		// query area
		$i=0;
		
		if( $_SESSION["str_searchs_1"] !=""){
		  $inputDate = "$_SESSION[str_searchs_2]";
$strCurrDate = strtotime($inputDate);
 $days=date("Y-m-d", mktime(date("H",$strCurrDate)+0, date("i",$strCurrDate)+0, date("s",$strCurrDate)+0, date("m",$strCurrDate)+0  , date("d",$strCurrDate)+1, date("Y",$strCurrDate)+0));
			$tel = "select * 
					from    billing where   	billing_date  between '".$_SESSION["str_search_1"]."' and '$days'
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
						$_GET['stack'] = "billing_id";
					} else {
						$_GET['stack'] = "billing_id";
					}
				}
			
			
				$tel .=" order  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		}
	?>
        <thead>
          <tr>
            <td width="11%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=billing_id&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">ใบวางบิล</a>
                <? }else { ?>
                <a href="?stack=billing_id&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">ใบวางบิล</a>
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
            </tr>
        </thead>
        <tbody>
          <?
		   if( $_SESSION["str_searchs_1"] !=""){
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
          <tr id="tr<?=$i?>" onmouseover='mOvr(this,&quot;#E6E6E6&quot;);' onmouseout='mOut(this,&quot;#ffffff&quot;);'>
            <td><?=$rs['billing_id']?>            </td>
            <td><?=$rs['billing_co']?>
              <br/>
              <font class="text_small_gray">เรียน
              <?=$rs['billing_attn']?>
              </font></td>
            <td><?=dateform($rs['billing_date1'])?>
                <br/>
                <font class="text_small_gray">By
                  <?=$rs['billing_poster']?>
                </font> </td>
            <td> <?php if (!(strcmp($rs['billing_publish'], "Yes"))) {echo "วางบิล";} ?>
            <?php if (!(strcmp($rs['billing_publish'], "No"))) {echo "รอวางบิล";} ?>              </td>
            <td><a href="?view=true&amp;billing_id=<?=$rs["billing_id"];?>"><img src="images/view.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/></a><a href="?fix=true&amp;billing_id=<?=$rs["billing_id"];?>"></a> </td>
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
				</div>			</td>
		</tr>
		<tr>
          <td><div align="right">ยอดรวมใบเสนอราคา ::</div></td>
		  <td align="right"><div align="left">
		    <?=$Num_Rows?>
		    </div></td>
		  </tr>
		<tr>
          <td><div align="right">ยอดรวมทั้งหมด ::</div></td>
		  <td align="right"><div align="left">
		    <? $tel = "select SUM(billing_amount_sum)  as billing_amount_sum
					from    billing where  	billing_date  between '".$_SESSION["str_search_1"]."' and '$days'
					 ";
					$objQuery = mysql_query($tel) or die ("Error Query [".$tel."]");
              		$rs = mysql_fetch_array($objQuery );
					echo $rs['billing_amount_sum'];
					 ?>
          </div></td>
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
