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
						from    billing2
						where 
						   	   billing2_id = '".$_GET['billing2_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
			
				$billing2_id  	= $rs_one['billing2_id'];
				$billing2_attn  	= $rs_one['billing2_attn'];
				$billing2_co   	= $rs_one['billing2_co'];
				$billing2_web  	= $rs_one['billing2_web'];
				$billing2_tel  	= $rs_one['billing2_tel'];
				$billing2_fax  	= $rs_one['billing2_fax'];
				$billing2_mail  	= $rs_one['billing2_mail'];
				$billing2_taxpayer  	= $rs_one['billing2_taxpayer'];
				$billing2_date=dateform1($rs_one['billing2_date']);
				if($rs_one['billing2_date_to']!="0000-00-00"){
				$billing2_date_to=dateform1($rs_one['billing2_date_to']);
				}
				if($rs_one['billing2_date_end']!="0000-00-00"){
				$billing2_date_end=dateform1($rs_one['billing2_date_end']);
				}
				$billing2_address  	= $rs_one['billing2_address'];
				$billing2_from  	= $rs_one['billing2_from'];
				$billing2_mail1  	= $rs_one['billing2_mail1'];
				$billing2_approve  	= $rs_one['billing2_approve'];			
				$billing2_amount_th  	= $rs_one['billing2_amount_th'];
				$billing2_amount_en  	= number_format($rs_one['billing2_amount_en'], 2,'.',',');
				$billing2_amount_vat  	= number_format($rs_one['billing2_amount_vat'], 2,'.',',');
				$billing2_amount_sum  	= number_format($rs_one['billing2_amount_sum'], 2,'.',',');
				$billing2_approve  	= $rs_one['billing2_approve'];
				$billing2_poster  	= $rs_one['billing2_poster'];
				$billing2_updater  	= $rs_one['billing2_updater'];
				$billing2_date1  	= $rs_one['billing2_date1'];
				$billing2_update  	= $rs_one['billing2_update'];
				
								
			}
			$tel_one = "select  * 
						from    billing2_cash
						where 
						   	   billing2_id = '".$_GET['billing2_id']."'";
			$get_one = mysql_query($tel_one);
			$num_check  = mysql_num_rows($get_one);
			if($num_check==0){
				$billing2_cash_amount  	= "..............................";
				}
			while($rs_one = mysql_fetch_array($get_one))
			{
				$billing2_cash_id  	= $rs_one['billing2_cash_id'];
				$billing2_cash_amount  	= ".......".$rs_one['billing2_cash_amount']."........";
				if($rs_one[billing2_cash_id] !=""){
				$billing2_cash = 'checked=\"checked\"';
				}
			}
			
			$tel_one = "select  * 
						from    billing2_check
						where 
						   	   billing2_id = '".$_GET['billing2_id']."'";
			$get_one = mysql_query($tel_one);
			$num_check1  = mysql_num_rows($get_one);
			if($num_check1==0){
				$billing2_check_bank  	="..............................";
				$billing2_check_branch  	= "..............................";
				$billing2_check_number  	= "..............................";
				$billing2_check_date  	="..............................";
				$billing2_check_amount  	= "..............................";
				$billing2_check_date  	= "..............................";
			}
			while($rs_one = mysql_fetch_array($get_one))
			{
			if($rs_one[billing2_check_id] !=""){
				$billing2_check = 'checked=\"checked\"';
				}
				$billing2_check_id  	= $rs_one['billing2_check_id'];
				$billing2_check_bank  	= ".......".$rs_one['billing2_check_bank']."........";
				$billing2_check_branch  	= ".......".$rs_one['billing2_check_branch']."........";
				$billing2_check_number  	= ".......".$rs_one['billing2_check_number']."........";
				$billing2_check_date  	= ".......".$rs_one['billing2_check_date']."........";
				$billing2_check_amount  	= ".......".$rs_one['billing2_check_amount']."........";
				$billing2_check_date  	= ".......".$rs_one['billing2_check_date']."........";
			}

			$tel_one = "select * from   billing2_detail where   billing2_id = '$billing2_id' order by billing2_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			$s1=0;
			$rank_rows = mysql_num_rows($get_one);
			while($rs_one = mysql_fetch_array($get_one))
			{  $i++;
$billing2_detail_id=$rs_one[billing2_detail_id];
$billing2_detail_no=$rs_one[billing2_detail_no];
$billing2_detail_description=$rs_one[billing2_detail_description];
if($rs_one['billing2_detail_qty']!=""){
$billing2_detail_qty= number_format($rs_one['billing2_detail_qty'], 2,'.',',');
}else{
$billing2_detail_qty= $rs_one['billing2_detail_qty'];	
}
if($rs_one['billing2_detail_unit']!=""){
$billing2_detail_unit= number_format($rs_one['billing2_detail_unit'], 2,'.',',');
}else{
$billing2_detail_unit= $rs_one['billing2_detail_unit'];	
}
if($rs_one['billing2_detail_total']!=""){
$billing2_detail_total=number_format($rs_one['billing2_detail_total'], 2,'.',','); 
}else{
$billing2_detail_total= $rs_one['billing2_detail_total'];	
}


			if($s1==1){
			$s2="30";
			}else if ($s1>=2){
			$s2="47";
			}else{
			
			$s2="20";
			
			}
			if(($i%$s2)==0){
			$s1+=1;
			 $r2.="
			 </table>  
			 <div style=width:880px;height:50px;></div>
 <table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
    <tr>
      <th width=\"21%\" ><img src=\"../../../picture/picture_company_image/$company_image\" width=\"100\"/></th>
      <th width=\"56%\" ><div align=\"left\">
        $company_name<br/>
		เลขประจําตัวผู้เสียภาษีอากร 
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
                   <td width=11% align=center height=\"28\" valign=\"middle\">$billing2_detail_no&nbsp;</td>
                    <td width=37% height=\"28\" valign=\"middle\">$billing2_detail_description</td>
                    <td width=11% align=center height=\"28\" valign=\"middle\">$billing2_detail_qty&nbsp;</td>
                    <td width=20% align=center height=\"28\" valign=\"middle\">$billing2_detail_unit&nbsp;</td>
                    <td width=21% align=center height=\"28\" valign=\"middle\">$billing2_detail_total&nbsp;</td>
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
              <th width=\"480\" rowspan=\"2\" valign=\"top\">
			  <div align=\"center\">ใบเสร็จรับเงิน / ใบกำกับภาษี<br/>
              RECEIPT</div></th>
             
            </tr>
            <tr>
              <th scope=\"col\">
			  <table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
                <tr>
                  <th  width=\"230\" height=\"52\" >ต้นฉบับ</th>
                </tr>
                <tr>
                  <td height=\"24\" align=\"center\"><div >
                    $billing2_id
                  </div></td>
                </tr>
              </table></th>
            </tr>
          </table>
		  <table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"#000000\" >
            
            <tr>
              <td colspan=\"4\" height=\"30\" valign=\"middle\">เลขประจำตัวผู้เสียภาษีอากร : $billing2_taxpayer</td>
            </tr>
            <tr>
              <td width=\"11%\" height=\"30\" valign=\"middle\"><div align=\"right\">ชื่อลูกค้า</div></td>
                    <td width=\"37%\" height=\"30\" valign=\"middle\">$billing2_attn&nbsp;</td>
                    <td width=\"12%\" height=\"30\" valign=\"middle\"><div align=\"right\">วันที่ </div></td>
              <td width=\"40%\">$billing2_date&nbsp;</td>
            </tr>
            <tr>
              <td ><div align=\"right\" height=\"30\" valign=\"middle\">ชื่อบริษัท </div></td>
                    <td height=\"30\" valign=\"middle\">$billing2_co&nbsp;</td>
                    <td><div align=\"right\" height=\"30\" valign=\"middle\">ระยะเวลาชำระ </div></td>
                    <td height=\"30\" valign=\"middle\"> $billing2_date_to&nbsp;</td>
                  </tr>
            <tr>
              <td rowspan=\"2\" valign=\"top\" height=\"30\" ><div align=\"right\">ที่อยู่ </div>                </td>
                    <td rowspan=\"2\" valign=\"top\">$billing2_address&nbsp;</td>
                    <td><div align=\"right\" height=\"30\" valign=\"middle\">วันที่กำหนดชำระ</div></td>
                    <td height=\"30\" valign=\"middle\">$billing2_date_end&nbsp;</td>
                  </tr>
                  <tr>
                      <td height=\"30\" valign=\"middle\">พนักงานขาย</td>
                        <td height=\"30\" valign=\"middle\">$billing2_from&nbsp;</td>
</tr>
                  
          </table></td>
		</tr>
  			<tr>
  			  <td width=\"97%\" align=\"left\"><div align=\"center\">$billing2_detail1</div></td>
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
$billing2_amount_th</font></td>
                  <td width=\"20%\"><div align=\"right\">ราคารวม</div></td>
                  <td width=\"21%\">$billing2_amount_en</td>
                </tr>
                <tr>
                  <td><div align=\"right\">ภาษีมูลค่าเพิ่ม 7 %</div></td>
                  <td>$billing2_amount_vat</td>
                </tr>
                <tr>
                  <td><div align=\"right\">รวมมูลค่าทั้งสิ้น</div></td>
                  <td>$billing2_amount_sum</td>
                </tr>
              </table>
	            <table width=\"917\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
                  <tr>
                    <td width=\"69%\" height=\"30\" valign=\"middle\" ><div align=\"left\"> ชำระเงินสด <input name=\"billing2_check\" $billing2_cash type=\"checkbox\" id=\"checkbox\" /> จำนวนเงิน $billing2_cash_amount</div></td>
                   
                  </tr>
                </table>
	            <table width=\"917\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
                  <tr>
                    <td width=\"69%\" height=\"30\" valign=\"middle\"><div align=\"left\">เช็ค/โอนธนาคาร 
		                <input name=\"billing2_check\" $billing2_check type=\"checkbox\" id=\"checkbox\" /> 
		      ธนาคาร $billing2_check_bank สาขา $billing2_check_branch เลขที่เช็ค $billing2_check_number</div></td>
                  </tr>
                  <tr>
                    <td width=\"69%\" height=\"30\" valign=\"middle\"><div align=\"left\">วันที่ $billing2_check_date จำนวนเงิน $billing2_check_amount
                    </div></td>
                  </tr>
                </table>
	            <table width=\"917\" border=\"0\">
                  <tr>
                    <td width=\"50%\"  align=\"center\" valign=\"bottom\">
					 <div style=\"height:20px; margin-bottom:-120px;\"><br/><br/><br/><font size=\"+1\">............................................</font></div>
                    <div style=\"height:20px; margin-bottom:-120px;\"><br/><br/><font size=\"+1\">(............................................)</font></div>
                        <div style=\"height:30px; margin-bottom:-10px; margin-bottom:-10px;\"><font size=\"+1\">ผู้รับเงิน</font></div></td>
                    <td width=\"50%\"  align=\"center\" valign=\"bottom\">
					<div style=\"height:20px; margin-bottom:-120px;\"><br/><br/><br/><font size=\"+1\">............................................</font></div>
                    <div style=\"height:20px; margin-bottom:-120px;\"><br/><br/><font size=\"+1\">(............................................)</font></div>
                          <div style=\"height:30px; margin-bottom:-10px; margin-bottom:-10px;\"><font size=\"+1\">ผู้รับสินค้า</div>
                        </td>
                    <td width=\"50%\"  align=\"center\" valign=\"bottom\">
					<div style=\"height:20px; margin-bottom:-120px;\"><br/><br/><br/><font size=\"+1\">............................................</font></div>
                    <div style=\"height:20px; margin-bottom:-120px; float:right\"><br/><br/><font size=\"+1\">(...........$billing2_approve..........)</font></div>
                    
                  <div style=\"height:30px; margin-bottom:-10px;\"><font size=\"+1\">ผู้อนุมัติ</font></div></td>               </tr>
                </table>
</td>
        
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
              <th width=\"480\" rowspan=\"2\" valign=\"top\">
			  <div align=\"center\">ใบเสร็จรับเงิน / ใบกำกับภาษี<br/>
              RECEIPT</div></th>
             
            </tr>
            <tr>
              <th scope=\"col\">
			  <table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
                <tr>
                  <th  width=\"230\" height=\"52\" >สำเนา</th>
                </tr>
                <tr>
                  <td height=\"24\" align=\"center\"><div >
                    $billing2_id
                  </div></td>
                </tr>
              </table></th>
            </tr>
          </table>
		  <table width=\"100%\" border=\"1\" cellspacing=\"0\" bordercolor=\"#000000\" >
            
            <tr>
              <td colspan=\"4\" height=\"30\" valign=\"middle\">เลขประจำตัวผู้เสียภาษีอากร : $billing2_taxpayer</td>
            </tr>
            <tr>
              <td width=\"11%\" height=\"30\" valign=\"middle\"><div align=\"right\">ชื่อลูกค้า</div></td>
                    <td width=\"37%\" height=\"30\" valign=\"middle\">$billing2_attn&nbsp;</td>
                    <td width=\"12%\" height=\"30\" valign=\"middle\"><div align=\"right\">วันที่ </div></td>
              <td width=\"40%\">$billing2_date&nbsp;</td>
            </tr>
            <tr>
              <td ><div align=\"right\" height=\"30\" valign=\"middle\">ชื่อบริษัท </div></td>
                    <td height=\"30\" valign=\"middle\">$billing2_co&nbsp;</td>
                    <td><div align=\"right\" height=\"30\" valign=\"middle\">ระยะเวลาชำระ </div></td>
                    <td height=\"30\" valign=\"middle\"> $billing2_date_to&nbsp;</td>
                  </tr>
            <tr>
              <td rowspan=\"2\" valign=\"top\" height=\"30\" ><div align=\"right\">ที่อยู่ </div>                </td>
                    <td rowspan=\"2\" valign=\"top\">$billing2_address&nbsp;</td>
                    <td><div align=\"right\" height=\"30\" valign=\"middle\">วันที่กำหนดชำระ</div></td>
                    <td height=\"30\" valign=\"middle\">$billing2_date_end&nbsp;</td>
                  </tr>
                  <tr>
                      <td height=\"30\" valign=\"middle\">พนักงานขาย</td>
                        <td height=\"30\" valign=\"middle\">$billing2_from&nbsp;</td>
</tr>
                  
          </table></td>
		</tr>
  			<tr>
  			  <td width=\"97%\" align=\"left\"><div align=\"center\">$billing2_detail1</div></td>
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
$billing2_amount_th</font></td>
                  <td width=\"20%\"><div align=\"right\">ราคารวม</div></td>
                  <td width=\"21%\">$billing2_amount_en</td>
                </tr>
                <tr>
                  <td><div align=\"right\">ภาษีมูลค่าเพิ่ม 7 %</div></td>
                  <td>$billing2_amount_vat</td>
                </tr>
                <tr>
                  <td><div align=\"right\">รวมมูลค่าทั้งสิ้น</div></td>
                  <td>$billing2_amount_sum</td>
                </tr>
              </table>
	            <table width=\"917\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
                  <tr>
                    <td width=\"69%\" height=\"30\" valign=\"middle\" ><div align=\"left\"> ชำระเงินสด <input name=\"billing2_check\" $billing2_cash type=\"checkbox\" id=\"checkbox\" /> จำนวนเงิน $billing2_cash_amount</div></td>
                   
                  </tr>
                </table>
	            <table width=\"917\" border=\"1\" cellspacing=\"0\" bordercolor=\"#333333\">
                  <tr>
                    <td width=\"69%\" height=\"30\" valign=\"middle\"><div align=\"left\">เช็ค/โอนธนาคาร 
		                <input name=\"billing2_check\" $billing2_check type=\"checkbox\" id=\"checkbox\" /> 
		      ธนาคาร $billing2_check_bank สาขา $billing2_check_branch เลขที่เช็ค $billing2_check_number</div></td>
                  </tr>
                  <tr>
                    <td width=\"69%\" height=\"30\" valign=\"middle\"><div align=\"left\">วันที่ $billing2_check_date จำนวนเงิน $billing2_check_amount
                    </div></td>
                  </tr>
                </table>
	            <table width=\"917\" border=\"0\">
                  <tr>
                    <td width=\"50%\"  align=\"center\" valign=\"bottom\">
					 <div style=\"height:20px; margin-bottom:-120px;\"><br/><br/><br/><font size=\"+1\">............................................</font></div>
                    <div style=\"height:20px; margin-bottom:-120px;\"><br/><br/><font size=\"+1\">(............................................)</font></div>
                        <div style=\"height:30px; margin-bottom:-10px; margin-bottom:-10px;\"><font size=\"+1\">ผู้รับเงิน</font></div></td>
                    <td width=\"50%\"  align=\"center\" valign=\"bottom\">
					<div style=\"height:20px; margin-bottom:-120px;\"><br/><br/><br/><font size=\"+1\">............................................</font></div>
                    <div style=\"height:20px; margin-bottom:-120px;\"><br/><br/><font size=\"+1\">(............................................)</font></div>
                          <div style=\"height:30px; margin-bottom:-10px; margin-bottom:-10px;\"><font size=\"+1\">ผู้รับสินค้า</div>
                        </td>
                    <td width=\"50%\"  align=\"center\" valign=\"bottom\">
					<div style=\"height:20px; margin-bottom:-120px;\"><br/><br/><br/><font size=\"+1\">............................................</font></div>
                    <div style=\"height:20px; margin-bottom:-120px; float:right\"><br/><br/><font size=\"+1\">(...........$billing2_approve..........)</font></div>
                    
                  <div style=\"height:30px; margin-bottom:-10px;\"><font size=\"+1\">ผู้อนุมัติ</font></div></td>               </tr>
                </table>
</td>
        
<div>
";


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