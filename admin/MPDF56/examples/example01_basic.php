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
						from    orderid
						where 
						   	   orderid_id = '".$_GET[orderid_id]."' and orderid_publish1='Yes'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
			
				$orderid_num  	= $rs_one['orderid_num'];
				$orderid_id  	= $rs_one['orderid_id'];
				$orderid_attn  	= $rs_one['orderid_attn'];
				$orderid_co   	= $rs_one['orderid_co'];
				$orderid_web  	= $rs_one['orderid_web'];
				$orderid_tel  	= $rs_one['orderid_tel'];
				$orderid_fax  	= $rs_one['orderid_fax'];
				$orderid_mail  	= $rs_one['orderid_mail'];
				$orderid_taxpayer  	= $rs_one['orderid_taxpayer'];
				$orderid_date  	= $rs_one['orderid_date'];
				$orderid_from  	= $rs_one['orderid_from'];
				$orderid_tel1  	= $rs_one['orderid_tel1'];
				$orderid_tel2  	= $rs_one['orderid_tel2'];
				$orderid_fax1  	= $rs_one['orderid_fax1'];
				$orderid_mail1  	= $rs_one['orderid_mail1'];
				$orderid_detail1  	= $rs_one['orderid_detail1'];
				
				$orderid_amount_th  	= $rs_one['orderid_amount_th'];
				$orderid_amount_en  	= number_format($rs_one['orderid_amount_en'], 2,'.',',');
				$orderid_amount_sum  	= number_format($rs_one['orderid_amount_sum'], 2,'.',',');
				$orderid_detail  	= $rs_one['orderid_detail'];
				$orderid_poster  	= $rs_one['orderid_poster'];
				$orderid_updater  	= $rs_one['orderid_updater'];
				$orderid_date1  	= $rs_one['orderid_date1'];
				$orderid_update  	= $rs_one['orderid_update'];
				
				
				
				
			}	
			$tel_one = "select * from   order_detail where   orderid_num = '$orderid_num' order by order_detail_id  ASC";
			$get_one = mysql_query($tel_one);
			$i=0;
			$s1=0;
			$rank_rows = mysql_num_rows($get_one);
			while($rs_one = mysql_fetch_array($get_one))
			{  $i++;
$order_detail_id=$rs_one[order_detail_id];
$order_detail_no=$rs_one[order_detail_no];
$order_detail_name=$rs_one[order_detail_name];
$order_detail_description=$rs_one[order_detail_description];
if($rs_one['order_detail_qty']!=""){
$order_detail_qty= number_format($rs_one['order_detail_qty'], 2,'.',',');
}else{
$order_detail_qty= $rs_one['order_detail_qty'];	
}
$order_detail_unit= $rs_one['order_detail_unit'];
if($rs_one['order_detail_price']!=""){
	
$order_detail_price= number_format($rs_one['order_detail_price'], 2,'.',',');
}else{
$order_detail_price= $rs_one['order_detail_price'];	
}
if($rs_one['order_detail_total']!=""){
$order_detail_total=number_format($rs_one['order_detail_total'], 2,'.',','); 
}else{
$order_detail_total= $rs_one['order_detail_total'];	
}

			if($s1==1){
			$s2="70";
			}else if ($s1>=2){
			$s2="35";
			}else{
			$s2="32";
			}
			if(($i%$s2)==0){
			$s1+=1;
			 $r2.="
			 </table>    
			<table width=\"100%\"  border=\"1\" cellspacing=\"0\">
    <tr>
      <th width=\"21%\" ><img src=\"../../../picture/picture_company_image/$company_image\"  width=\"100\" ></th>
      <th width=\"56%\" ><div align=\"left\">
         $company_name เลขประจําตัวผู้เสียภาษีอากร : $rs1[company1_name]
      </div>      </th>
      <th width=\"23%\" >Quotation<br/><br/>
ใบเสนอราคา<br/><br/></font>
$orderid_id</th>
    </tr>
  </table>
  <div style=\"height:2px;\">&nbsp;</div>
  <table width=\"100%\" border=\"1\" cellspacing=\"0\">
			 <tr>
                  <th width=7% scope=col>No.</th>
                  <th width=11% scope=col>NAME</th>
                  <th width=47% scope=col>Description</th>
                  <th width=9% scope=col>Qty.</th>
                  <th width=9% scope=col>Unit</th>
                  <th width=9% scope=col>Price</th>
                  <th width=8% scope=col>Total</th>
                </tr> ";      
			}
 $r2.="  <tr>
                    <td width=7% align=center>$order_detail_no&nbsp;</td>
                    <td width=11% align=center ><font size=-1>$order_detail_name</font></td>
                    <td width=47% ><font size=-1>$order_detail_description</font></td>
                    <td width=9% align=center>$order_detail_qty&nbsp;</td>
                    <td width=9% align=center>$order_detail_unit&nbsp;</td>
                    <td width=9% align=center>$order_detail_price&nbsp;</td>
                    <td width=8% align=center>$order_detail_total&nbsp;</td>
                  </tr>";
                   }
				   $j=$i;
				  while($j<=20){
			$j++;
				  $r2.="  <tr>
                    <td width=7% align=center>&nbsp;</td>
                    <td width=11% align=center >&nbsp;</td>
                    <td width=47% >&nbsp;</td>
                    <td width=9% align=center>&nbsp;</td>
                    <td width=9% align=center>&nbsp;</td>
                    <td width=9% align=center>&nbsp;</td>
                    <td width=8% align=center>&nbsp;</td>
                  </tr>"; 
				   
				   }
		
$y=substr($orderid_date,0,4);
$m=substr($orderid_date,5,2);
$d=substr($orderid_date,8,2);
$year=$y+543;
$day=$d;
$month=$m;
if ($month == 1) 
								{$month=มกราคม;}
								else if ($month == 2) 
								{$month=กุมภาพันธ์;}
								else if ($month == 3) 
								{$month=มีนาคม;}
								else if ($month == 4) 
								{$month=เมษายน;}
								else if ($month == 5) 
								{$month=พฤษภาคม;}
								else if ($month == 6) 
								{$month=มิถุนายน;}
								else if ($month == 7) 
								{$month=กรกฏาคม;}
								else if ($month == 8) 
								{$month=สิงหาคม;}
								else if ($month == 9) 
								{$month=กันยายน;}
								else if ($month == 10) 
								{$month=ตุลาคม;}
								else if ($month == 11) 
								{$month=พฤศจิกายน;}
								else {$month=ธันวาคม;}

$html = "<div style=width:880px;>
<table width=\"100%\"  border=\"1\" cellspacing=\"0\">
    <tr>
      <th width=\"21%\" ><img src=\"../../../picture/picture_company_image/$company_image\"  width=\"100\" ></th>
      <th width=\"56%\" ><div align=\"left\">
        $company_name เลขประจําตัวผู้เสียภาษีอากร : $rs1[company1_name]
      </div>      </th>
      <th width=\"23%\" ><font size=\"+1\">Quotation<br/><br/>
ใบเสนอราคา<br/><br/></font>
$orderid_id</th>
    </tr>
  </table>
<div style=\"height:2px;\">&nbsp;</div>
<table width=\"100%\" border=\"1\" cellspacing=\"0\">
                <tr>
                  <td width=13% align=\"right\"><div align=left>เรียน :</div></td>
                  <td width=36%><div align=left>$orderid_attn</div></td>
                  <td width=13% align=\"right\"><div align=left>วันที่ :</div></td>
                  <td width=36%> <div align=left>$day $month $year</div></td>
                </tr>
                <tr>
                  <td width=13% align=\"right\"><div align=right>บริษัท :</div></td>
                  <td width=36%><div align=left>$orderid_co</div></td>
                  <td width=13% align=\"right\"><div>จาก :</div></td>
                  <td width=36%> <div align=left>$orderid_from</div></td>
                </tr>
                <tr>
                  <td width=13% align=\"right\"><div >เว็บไซต์ :</div></td>
                  <td width=36%><div align=left>$orderid_web</div></td>
                  <td width=13% align=\"right\"><div>มือถือ :</div></td>
                  <td width=36%><div align=left>$orderid_tel1                    </div></td>
                </tr>
                <tr>
                  <td width=13% align=\"right\"><div >โทรศัพท์ :</div></td>
                  <td width=36%><div align=left>$orderid_tel</div></td>
                  <td width=13% align=\"right\"><div>โทรศัพท์ :</div></td>
                  <td width=36%>
                    <div align=left>$orderid_tel2                    </div></td>
                </tr>
                <tr>
                  <td width=13% align=\"right\"><div >แฟกซ์ :</div></td>
                  <td width=36%><div align=left>$orderid_fax</div></td>
                  <td width=13% align=\"right\"><div >แฟกซ์ :</div></td>
                  <td width=36%>
                    <div align=left>$orderid_fax1                    </div></td>
                </tr>
                <tr>
                  <td width=13% align=\"right\"><div>อีเมล์ :</div></td>
                  <td width=36%><div align=left>$orderid_mail</div></td>
                  <td width=13% align=\"right\"><div>อีเมล์ :</div></td>
                  <td width=36%>
                    <div align=left>$orderid_mail1                    </div></td>
                </tr>
				<tr>
                  <td width=13% align=\"right\"><div>เลขผู้เสียภาษี:</div></td>
                  <td width=36%><div align=left>$orderid_taxpayer</div></td>
                  <td width=13% align=\"right\"><div></div></td>
                  <td width=36%>
                    <div align=left> </div></td>
                </tr>
          </table>
<div align=\"center\"><font size=\"-1\">$orderid_detail1</font></div>
<table width=\"100%\" border=\"1\" cellspacing=\"0\">
                <tr>
                  <th width=7% scope=col>No.</th>
                  <th width=11% scope=col>NAME</th>
                  <th width=47% scope=col>Description</th>
                  <th width=9% scope=col>Qty.</th>
                  <th width=9% scope=col>Unit</th>
                  <th width=9% scope=col>Price</th>
                  <th width=8% scope=col>Total</th>
                </tr>                
            $r2   
              </table>    
			  <table width=\"100%\"  border=\"1\" cellspacing=\"0\">

                <tr>
                  <td width=69% rowspan=2 align=center><font size=+5>
$orderid_amount_th</font></td>
                  <td width=21%><div align=right>ราคารวม</div></td>
                  <td width=10%>$orderid_amount_en</td>
                </tr>
                <tr>
                <td width=21%><div align=right>รวมมูลค่าทั้งสิ้น</div></td>
                  <td width=10%>$orderid_amount_sum</td>
                </tr>
              </table>
			  <table width=917 border=0>
                  <tr>
                    <td width=18% align=center valign=top><div align=left>เงื่อนไขการชำระเงิน:</div></td>
                    <td width=52%>$orderid_detail</td>
					<td width=30% valign=top>ราคานี้ยังไม่รวมภาษีมูลค่าเพิ่ม7%</td>
                  </tr>
                </table>
				 <table width=\"100%\"  height=\"50\" border=\"0\" cellspacing=\"0\">
                  <tr>
                    <td width=50% align=center valign=\"bottom\">
                    <div style=height:20px; margin-bottom:-10px;></div>
                    <div>................................</div>
                      <div>รับทราบและดำเนินการได้</div></td>
                    <td width=\"50%\" align=\"center\" valign=\"bottom\">
					 <div style=height:20px; margin-bottom:-10px;>$orderid_from</div>
                    <div>................................</div>
                      <div>ผู้เสนอราคา</div>
                  </tr>
                </table>
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