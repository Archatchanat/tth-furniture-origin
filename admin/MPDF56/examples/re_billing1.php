<?php
include "../../../connect/connect.php";
	include "../../../connect/function.php";
	include("../mpdf.php");
	$mpdf=new mPdf('th', 'A4', '0', 'THSaraban');

$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins

$mpdf->defaultheaderfontsize = 10;	/* in pts */
$mpdf->defaultheaderfontstyle = B;	/* blank, B, I, or BI */
$mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

$mpdf->defaultfooterfontsize = 12;	/* in pts */
$mpdf->defaultfooterfontstyle = B;	/* blank, B, I, or BI */
$mpdf->defaultfooterline = 1; 	/* 1 to include line below header/above footer */


$mpdf->SetHeader('||{PAGENO}/{nb}');
$mpdf->SetFooter('{PAGENO}');	/* defines footer for Odd and Even Pages - placed at Outer margin */

$mpdf->SetFooter(array(
	
	'R' => array(
		'content' => '{PAGENO}',
		'font-family' => 'serif',
		'font-style' => 'BI',
		'font-size' => '18',	/* gives default */
	),
	'line' => 1,		/* 1 to include line below header/above footer */
), 'E'	/* defines footer for Even Pages */
);
$tel_one1 = "select  * 
						from    company1
						where 
						   	   company1_id = '1'";
			$get_one1 = mysql_query($tel_one1);
			$rs1 = mysql_fetch_array($get_one1);
			
			
			$tel_one = "select  * 
						from    company
						where 
						   	   company_id = '1'";
			$get_one = mysql_query($tel_one);
			$rs = mysql_fetch_array($get_one);
			$company_image=$rs[company_image];
			$company_name=$rs[company_name];
			$tel_one = "select  * 
						from    billing
						where 
						   	   billing_id = '".$_GET['billing_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
			
				$billing_id  	= $rs_one['billing_id'];
				$billing_attn  	= $rs_one['billing_attn'];
				$billing_co   	= $rs_one['billing_co'];
				$billing_web  	= $rs_one['billing_web'];
				$billing_tel  	= $rs_one['billing_tel'];
				$billing_fax  	= $rs_one['billing_fax'];
				$billing_mail  	= $rs_one['billing_mail'];
				$billing_taxpayer  	= $rs_one['billing_taxpayer'];
				$billing_date=dateform1($rs_one['billing_date']);
				
				if($rs_one['billing_date_end']!="0000-00-00"){
				$billing_date_end=dateform1($rs_one['billing_date_end']);
				}
				$billing_address  	= $rs_one['billing_address'];
				$billing_from  	= $rs_one['billing_from'];
				$billing_mail1  	= $rs_one['billing_mail1'];
				$billing_approve  	= $rs_one['billing_approve'];			
				$billing_amount_th  	= $rs_one['billing_amount_th'];
				$billing_amount_en  	= number_format($rs_one['billing_amount_en'], 2,'.',',');
				$billing_amount_vat  	= number_format($rs_one['billing_amount_vat'], 2,'.',',');
				$billing_amount_sum  	= number_format($rs_one['billing_amount_sum'], 2,'.',',');
				$billing_approve  	= $rs_one['billing_approve'];
				$billing_poster  	= $rs_one['billing_poster'];
				$billing_updater  	= $rs_one['billing_updater'];
				$billing_date1  	= $rs_one['billing_date1'];
				$billing_update  	= $rs_one['billing_update'];
				
								
			}
			

			$tel_one = "select * from   billing_detail where   billing_id = '$billing_id' order by billing_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			$s1=0;
			$rank_rows = mysql_num_rows($get_one);
			while($rs_one = mysql_fetch_array($get_one))
			{  $i++;
$billing_detail_id=$rs_one[billing_detail_id];
$billing_detail_no=$rs_one[billing_detail_no];
$billing_detail_description=$rs_one[billing_detail_description];
if($rs_one['billing_detail_qty']!=""){
$billing_detail_qty= number_format($rs_one['billing_detail_qty'], 2,'.',',');
}else{
$billing_detail_qty= $rs_one['billing_detail_qty'];	
}
if($rs_one['billing_detail_unit']!=""){
$billing_detail_unit= number_format($rs_one['billing_detail_unit'], 2,'.',',');
}else{
$billing_detail_unit= $rs_one['billing_detail_unit'];	
}
if($rs_one['billing_detail_total']!=""){
$billing_detail_total=number_format($rs_one['billing_detail_total'], 2,'.',','); 
}else{
$billing_detail_total= $rs_one['billing_detail_total'];	
}

			if($s1==1){
			$s2="47";
			}else if ($s1>=2){
			$s2="47";
			}else{
			
			$s2="19";
			
			}
			if(($i%$s2)==0){
			$s1+=1;
			 $r2.="
			 </table>    
			<table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
    <tr>
      <th width=\"21%\" ><img src=\"../../../picture/picture_company_image/$company_image\" width=\"100\"/>$s1</th>
      <th width=\"56%\" ><div align=\"left\">
        $company_name
      </div>      </th>
    </tr>
  </table>
  <div style=\"height:2px;\">&nbsp;</div>
  <table width=\"100%\" border=\"1\" cellspacing=\"0\"  bordercolor=\"#333333\" bgcolor=\"#F3F4F4\">
			<tr>
                     <th width=\"11%\" scope=\"col\">No.</th>
                  <th width=\"37%\" scope=\"col\">Description</th>
                  <th width=\"11%\" scope=\"col\">Qty.</th>
                  <th width=\"20%\" scope=\"col\">Unit</th>
                  <th width=\"21%\" scope=\"col\">Total</th>
                  </tr>";      
			}
 $r2.="  <tr bgcolor=\"#FFFFFF\">
                   <td width=11% align=center height=\"28\" valign=\"middle\">$billing_detail_no&nbsp;</td>
                    <td width=37% height=\"28\" valign=\"middle\">$billing_detail_description</td>
                    <td width=11% align=center height=\"28\" valign=\"middle\">$billing_detail_qty&nbsp;</td>
                    <td width=20% align=center height=\"28\" valign=\"middle\">$billing_detail_unit&nbsp;</td>
                    <td width=21% align=center height=\"28\" valign=\"middle\">$billing_detail_total&nbsp;</td>
                  </tr>";
                   }
				   $j=$i;
				  while($j<=50){
			$j++;
				  $r21.="<br/>"; 
				   
				   }
		

$html = "<div style=width:880px;>
 <table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
    <tr>
      <th width=\"21%\" ><img src=\"../../../picture/picture_company_image/$company_image\" width=\"100\"/></th>
      <th width=\"56%\" ><div align=\"left\">
       $company_name
		เลขประจําตัวผู้เสียภาษีอากร : $rs1[company1_name]
      </div>      </th>
    </tr>
  </table>
 
<table id=\"myTable\"  width=\"100%\">
		<tr>
		  <td colspan=\"2\">
		  <table width=\"100%\" border=\"0\" cellspacing=\"0\">
            <tr>
              <th width=\"400\" rowspan=\"2\" valign=\"top\">
			  <div align=\"center\">ใบวางบิล/ใบแจ้งหนี้<br/>
              INVOICE</div></th>
              <th width=\"40%\" height=\"21\" scope=\"col\">&nbsp;</th>
            </tr>
            <tr>
              <th scope=\"col\">
			  <table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
                <tr>
                  <th  width=\"280\" height=\"52\" >ใบวางบิล/ใบแจ้งหนี้/ต้นฉบับ<br/>
                    INVOICE</th>
                </tr>
                <tr>
                  <td height=\"24\" align=\"center\"><div >
                    $billing_id
                  </div></td>
                </tr>
              </table></th>
            </tr>
          </table>
		  <table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"#000000\" >
            
            <tr>
              <td colspan=\"4\" height=\"30\" valign=\"middle\">เลขประจำตัวผู้เสียภาษีอากร : $billing_taxpayer</td>
            </tr>
            <tr>
              <td width=\"11%\" height=\"30\" valign=\"middle\"><div align=\"right\">ชื่อลูกค้า</div></td>
                    <td width=\"37%\" height=\"30\" valign=\"middle\">$billing_attn&nbsp;</td>
                    <td width=\"12%\" height=\"30\" valign=\"middle\"><div align=\"right\">วันที่ </div></td>
              <td width=\"40%\">$billing_date&nbsp;</td>
            </tr>
            <tr>
              <td ><div align=\"right\" height=\"30\" valign=\"middle\">ชื่อบริษัท </div></td>
                    <td height=\"30\" valign=\"middle\">$billing_co&nbsp;</td>
                    <td><div align=\"right\" height=\"30\" valign=\"middle\">เบอร์โทรศัพท์ </div></td>
                    <td height=\"30\" valign=\"middle\"> $billing_tel&nbsp;</td>
                  </tr>
            <tr>
              <td rowspan=\"2\" valign=\"top\" height=\"30\" ><div align=\"right\">ที่อยู่ </div>                </td>
                    <td rowspan=\"2\" valign=\"top\">$billing_address&nbsp;</td>
                    <td><div align=\"right\" height=\"30\" valign=\"middle\">เบอร์แฟกซ์ </div></td>
                    <td height=\"30\" valign=\"middle\">$billing_fax&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align=\"right\" height=\"30\" valign=\"middle\">วันที่ชำระ </div></td>
                    <td height=\"30\" valign=\"middle\">$billing_date_end&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan=\"2\" bgcolor=\"#F3F4F4\"> <div align=\"left\">Sale</div></td>
                    <td colspan=\"2\" bgcolor=\"#F3F4F4\"> <div align=\"center\">Payment Method</div></td>
                  </tr>
                  <tr>
                    <td colspan=\"2\" height=\"30\" valign=\"middle\"><div align=\"left\">$billing_from</div></td>
                    <td colspan=\"2\">&nbsp;</td>
                  </tr>
          </table></td>
		</tr>
  			<tr>
  			  <td width=\"97%\" align=\"left\"><div align=\"center\">$billing_detail1</div></td>
	</tr>
	 </table>
		   
              <table width=\"917\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\" bgcolor=\"#F3F4F4\">
                <tr>
                  <th width=\"11%\" scope=\"col\">No.</th>
                  <th width=\"37%\" scope=\"col\">Description</th>
                  <th width=\"11%\" scope=\"col\">Qty.</th>
                  <th width=\"20%\" scope=\"col\">Unit</th>
                  <th width=\"21%\" scope=\"col\">Total</th>
                </tr>                
               $r2
              </table>            
			  
			  
			   <table width=\"917\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">

                <tr>
                  <td width=\"59%\" rowspan=\"3\" align=\"center\"><font size=\"+5\">
$billing_amount_th</font></td>
                  <td width=\"20%\"><div align=\"right\">ราคารวม</div></td>
                  <td width=\"21%\">$billing_amount_en</td>
                </tr>
                <tr>
                  <td><div align=\"right\">ภาษีมูลค่าเพิ่ม 7 %</div></td>
                  <td>$billing_amount_vat</td>
                </tr>
                <tr>
                  <td><div align=\"right\">รวมมูลค่าทั้งสิ้น</div></td>
                  <td>$billing_amount_sum</td>
                </tr>
              </table>
	            <table width=\"917\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
                  <tr>
                    <td width=\"69%\" height=\"30\" valign=\"middle\" ><div align=\"left\">***กรุณาชำระเงินตามวันเวลาที่กำหนดในใบแจ้งหนี้นี้เพื่อหลีกเลี่ยงการระงับหรือส่งของล่าช้า</div></td>
                   
                  </tr>
                </table>
	            <table width=\"917\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
                  <tr>
                    <td width=\"69%\" height=\"30\" valign=\"middle\"><div align=\"left\">:ในกรณีที่ท่านต้องการชำระด้วยเช็คกรุณาแจ้งกับทางบริษัทก่อนครบกำหนดใบวางบิล</div></td>
                  </tr>
                </table>
	            <table width=\"917\" border=\"0\">
                  <tr>
                    <td width=\"50%\" align=\"center\" valign=\"top\"><br/><br/>
                    <div style=\"height:20px; margin-bottom:-10px;\"></div>
                     <div>วันที่รับเช็ค........./............/...........</div><br/>
                    <div>ลงชื่อ................................</div><br/>
                    <div>(................................)</div>
                      <div>ผู้รับวางบิล</div></td>
                    <td width=\"50%\"  align=\"center\" valign=\"bottom\">
                    <div style=\"height:20px; margin-bottom:-120px; float:right\">(...........$billing_approve..........)</div>
                    
                  <div style=\"height:30px; margin-bottom:-10px;\">ผู้อนุมัติ</div></td>               </tr>
                </table></td>
        
<div>
$r21

<div style=width:880px;>
 <table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
    <tr>
      <th width=\"21%\" ><img src=\"../../../picture/picture_company_image/$company_image\" width=\"100\"/></th>
      <th width=\"56%\" ><div align=\"left\">
        $company_name
		เลขประจําตัวผู้เสียภาษีอากร : $rs1[company1_name]
      </div>      </th>
    </tr>
  </table>
 
<table id=\"myTable\"  width=\"100%\">
		<tr>
		  <td colspan=\"2\">
		  <table width=\"100%\" border=\"0\" cellspacing=\"0\">
            <tr>
              <th width=\"400\" rowspan=\"2\" valign=\"top\">
			  <div align=\"center\">ใบวางบิล/ใบแจ้งหนี้<br/>
              INVOICE</div></th>
              <th width=\"40%\" height=\"21\" scope=\"col\">&nbsp;</th>
            </tr>
            <tr>
              <th scope=\"col\">
			  <table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
                <tr>
                  <th  width=\"280\" height=\"52\" >ใบวางบิล/ใบแจ้งหนี้/สำเนา<br/>
                    INVOICE</th>
                </tr>
                <tr>
                  <td height=\"24\" align=\"center\"><div >
                    $billing_id
                  </div></td>
                </tr>
              </table></th>
            </tr>
          </table>
		  <table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"#000000\" >
            
            <tr>
              <td colspan=\"4\" height=\"30\" valign=\"middle\">เลขประจำตัวผู้เสียภาษีอากร : $billing_taxpayer</td>
            </tr>
            <tr>
              <td width=\"11%\" height=\"30\" valign=\"middle\"><div align=\"right\">ชื่อลูกค้า</div></td>
                    <td width=\"37%\" height=\"30\" valign=\"middle\">$billing_attn&nbsp;</td>
                    <td width=\"12%\" height=\"30\" valign=\"middle\"><div align=\"right\">วันที่ </div></td>
              <td width=\"40%\">$billing_date&nbsp;</td>
            </tr>
            <tr>
              <td ><div align=\"right\" height=\"30\" valign=\"middle\">ชื่อบริษัท </div></td>
                    <td height=\"30\" valign=\"middle\">$billing_co&nbsp;</td>
                    <td><div align=\"right\" height=\"30\" valign=\"middle\">เบอร์โทรศัพท์ </div></td>
                    <td height=\"30\" valign=\"middle\"> $billing_tel&nbsp;</td>
                  </tr>
            <tr>
              <td rowspan=\"2\" valign=\"top\" height=\"30\" ><div align=\"right\">ที่อยู่ </div>                </td>
                    <td rowspan=\"2\" valign=\"top\">$billing_address&nbsp;</td>
                    <td><div align=\"right\" height=\"30\" valign=\"middle\">เบอร์แฟกซ์ </div></td>
                    <td height=\"30\" valign=\"middle\">$billing_fax&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align=\"right\" height=\"30\" valign=\"middle\">วันที่ชำระ </div></td>
                    <td height=\"30\" valign=\"middle\">$billing_date_end&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan=\"2\" bgcolor=\"#F3F4F4\"> <div align=\"left\">Sale</div></td>
                    <td colspan=\"2\" bgcolor=\"#F3F4F4\"> <div align=\"center\">Payment Methon</div></td>
                  </tr>
                  <tr>
                    <td colspan=\"2\" height=\"30\" valign=\"middle\"><div align=\"left\">$billing_from</div></td>
                    <td colspan=\"2\">&nbsp;</td>
                  </tr>
          </table></td>
		</tr>
  			<tr>
  			  <td width=\"97%\" align=\"left\"><div align=\"center\">$billing_detail1</div></td>
	</tr>
	 </table>
		   
              <table width=\"917\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\" bgcolor=\"#F3F4F4\">
                <tr>
                  <th width=\"11%\" scope=\"col\">No.</th>
                  <th width=\"37%\" scope=\"col\">Description</th>
                  <th width=\"11%\" scope=\"col\">Qty.</th>
                  <th width=\"20%\" scope=\"col\">Unit</th>
                  <th width=\"21%\" scope=\"col\">Total</th>
                </tr>                
               $r2
              </table>            
			  
			  
			   <table width=\"917\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">

                <tr>
                  <td width=\"59%\" rowspan=\"3\" align=\"center\"><font size=\"+5\">
$billing_amount_th</font></td>
                  <td width=\"20%\"><div align=\"right\">ราคารวม</div></td>
                  <td width=\"21%\">$billing_amount_en</td>
                </tr>
                <tr>
                  <td><div align=\"right\">ภาษีมูลค่าเพิ่ม 7 %</div></td>
                  <td>$billing_amount_vat</td>
                </tr>
                <tr>
                  <td><div align=\"right\">รวมมูลค่าทั้งสิ้น</div></td>
                  <td>$billing_amount_sum</td>
                </tr>
              </table>
	            <table width=\"917\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
                  <tr>
                    <td width=\"69%\" height=\"30\" valign=\"middle\" ><div align=\"left\">***กรุณาชำระเงินตามวันเวลาที่กำหนดในใบแจ้งหนี้นี้เพื่อหลีกเลี่ยงการระงับหรือส่งของล่าช้า</div></td>
                   
                  </tr>
                </table>
	            <table width=\"917\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
                  <tr>
                    <td width=\"69%\" height=\"30\" valign=\"middle\"><div align=\"left\">:ในกรณีที่ท่านต้องการชำระด้วยเช็คกรุณาแจ้งกับทางบริษัทก่อนครบกำหนดใบวางบิล</div></td>
                  </tr>
                </table>
	            <table width=\"917\" border=\"0\">
                  <tr>
                    <td width=\"50%\" align=\"center\" valign=\"top\"><br/><br/>
                    <div style=\"height:20px; margin-bottom:-10px;\"></div>
                     <div>วันที่รับเช็ค........./............/...........</div><br/>
                    <div>ลงชื่อ................................</div><br/>
                    <div>(................................)</div>
                      <div>ผู้รับวางบิล</div></td>
                    <td width=\"50%\"  align=\"center\" valign=\"bottom\">
                    <div style=\"height:20px; margin-bottom:-120px; float:right\">(...........$billing_approve..........)</div>
                    
                  <div style=\"height:30px; margin-bottom:-10px;\">ผู้อนุมัติ</div></td>               </tr>
                </table></td>
        
<div>";


//==============================================================
//==============================================================
//==============================================================


$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

//==============================================================
//==============================================================
//==============================================================


?>