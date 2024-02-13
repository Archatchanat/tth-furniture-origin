<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="cloth">
	
	<!----------------------------------------------------------------------------------------------------------------------------- -->
	<? include "include_top.php";?>
	<div class="top_bar"></div>
	<!----------------------------------------------------------------------------------------------------------------------------- -->
	
	<!----------------------------------------------------------------------------------------------------------------------------- -->
	<div class="shirt">
		<div class="shirt_left">
			<? include "include_menu.php";?>
		</div>
		<div class="shirt_right">
			ยินดีต้อนรับสู่ ระบบแอดมิน<hr/>
			<div style="height:485px; background-color:#FFFFFF; margin-top:10px;">
			  <div align="left">แจ้งเตือน
			    <!--end__ : edit data-->
                <!---------------------------------------------------------------------------------------------------------------------------- -->
                <!-------------------------------------------------------------------------------------------------------------------------------------- -->
                <!--start : list data -->
			  </div>
			  <form action="?action=del_sel" method="post" name="list" id="list" onsubmit="return ConfAll()">
                <div align="left">
                  <table width="100%" border="0" cellspacing="0">
                         <?
						 				 
						 
			   $ate1=date('d');
				   $inputDate1=date('Y-m-d');
				  $inputDate=date('Y-m-d');
				  $strCurrDate = strtotime($inputDate);
 $days=date("Y-m-d", mktime(date("H",$strCurrDate)+0, date("i",$strCurrDate)+0, date("s",$strCurrDate)+0, date("m",$strCurrDate)+1  , date("d",$strCurrDate)+0, date("Y",$strCurrDate)+0));
		// query area
		$i=0;
			$tel = "select customers_orderid_date, customers_project.customers_id,customers_p_id,customers_orderid_detail,customers_p_name,customers_orderid_publish
					from    customers_orderid 
					LEFT JOIN customers_project ON (customers_project.customers_p_id=customers_orderid.customers_id)
					 ";
		
				$objQuery = mysql_query($tel) or die ("Error Query [".$tel."]");
				$Num_Rows = mysql_num_rows($objQuery);
		
				$Per_Page = 10;   // Per Page

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
						$_GET['stack'] = "customers_project.customers_id";
					} else {
						$_GET['stack'] = "customers_project.customers_id";
					}
				}
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>
                    <thead>
                      <tr>
                        <td width="2%">&nbsp;</td>
                      <td width="34%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                            <a href="?stack=customers_name&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">ชื่อ-นามสกุล</a>
                            <? }else { ?>
                            <a href="?stack=customers_name&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">ชื่อ-นามสกุล</a>
                            <? } ?>                      </td>
                        <td width="23%">งาน</td>
                        <td width="19%">วันครบกำหนด</td>
                        <td width="13%">สถานะ</td>
                        <td width="9%">เลือก</td>
                      </tr>
                    </thead>
                    <tbody>
                      <?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
		$tel_one = "select  * 
						from    customers
						where 
						   	   customers.customers_id = '".$rs['customers_id']."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
					
				$customers_id	   	= $rs_one['customers_id'];
				$customers_com	   	= $rs_one['customers_com'];
				$customers_name     = $rs_one['customers_name'];
			
				
			}
	?>
                      <tr id="tr<?=$i?>" onmouseover='mOvr(this,&quot;#E6E6E6&quot;);' onmouseout='mOut(this,&quot;#ffffff&quot;);'>
                        <td>&nbsp;</td>
                        <td><a href="re_billing.php?customers_p_id=<?=$rs['customers_p_id']?>">
                          <?=$customers_com?>
                          </a><br/>
                          <?=$customers_name?>
                          <br/></td>
                        <td> <?=$rs[customers_p_name]?>
						<br/>
			<font class="text_small_gray">
						<? if ($rs[customers_orderid_publish] == "1") { echo'ใบเสนอราคา';}else{echo 'ใบวางบิล';}?>
                        </font></td>
                        <td><?=$rs[customers_orderid_detail]?></td>
                        <td>
			<font class="text_small_gray"><?  if ($rs[customers_orderid_publish] == "1") {
                        $tel_one = "select  * 
						from    orderid
						where 
						   	   orderid_date >= '$rs[customers_orderid_date]' and customers_p_id='$rs[customers_p_id]' and orderid_publish1='Yes'" ;
						$get_one = mysql_query($tel_one);
						$rs_one = mysql_fetch_array($get_one);
				if ($rs_one['orderid_id']!=""){
				  echo $rs_one['orderid_id'].'<br/>';
				  if($rs_one[orderid_publish]=="Yes"){echo"ส่งแล้ว";} 
				  if($rs_one[orderid_publish]=="No"){echo"ไม่ส่ง";}
				  }else{
				  echo"ไม่ได้ทำเอกสาร";
				  }
				  } else {
				   
				  $tel_one = "select  * 
						from    billing
						where 
						   	   billing_date >= '$rs[customers_orderid_date]' and customers_p_id='$rs[customers_p_id]'" ;
						$get_one = mysql_query($tel_one);
						$rs_one = mysql_fetch_array($get_one);
				if ($rs_one['billing_id']!=""){
				 echo $rs_one['billing_id'].'<br/>';
				  if($rs_one[billing_publish]=="Yes"){echo"วางบิล";} 
				  if($rs_one[billing_publish]=="No"){echo"รอวางบิล";}
				  }else{
				  echo"ไม่ได้ทำเอกสาร";
				  }
				  
				  
				  
				  }
               ?></font></td>
                        <td><a href="<? if($rs[customers_orderid_publish] == "1") { echo'billing.php';}else{echo 'billing1.php';}?>?action=add&customers_id=<?=$rs["customers_id"];?>&customers_p_id=<?=$rs["customers_p_id"];?>"><img src="images/b_edit.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/></a></td>
                      </tr>
                      <?
			
		}
	?>
                    </tbody>
                                  </table>
                </div>
                <hr align="left"/>
                <div align="left">
                  <table width="100%">
                    <tr>
                      <td width="30%">&nbsp;</td>
                      <td width="70%" align="right"><div class="general">รวม
                        <?= $Num_Rows;?>
                        รายการ :
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
                      </div></td>
                    </tr>
                                  </table>
                  <input type="hidden" name="num_rows" id="num_rows" value="<?=$Num_Rows?>" />
                  </div>
			  </form>
		      <div align="left">นัดพบลูกค้า
		        <!--end__ : edit data-->
                  <!---------------------------------------------------------------------------------------------------------------------------- -->
                  <!-------------------------------------------------------------------------------------------------------------------------------------- -->
                  <!--start : list data -->
              </div>
		      <form action="?action=del_sel" method="post" name="list" id="list2" onsubmit="return ConfAll()">
                <div align="left">
                  <table width="100%" border="0" cellspacing="0">
                    <?
						 				 
						 
			   $ate1=date('d');
				   $str_content2=date('Y-m-d');
				  $inputDate=date('Y-m-d');
		// query area
		$i=0;
			$tel = "select *
					from    note where   note_today <='$str_content2' and  note_endday >='$str_content2'  
					 ";
		
				$objQuery = mysql_query($tel) or die ("Error Query [".$tel."]");
				$Num_Rowsy = mysql_num_rows($objQuery);
		
				$Per_Pagey = 10;   // Per Page

				$Pagey = $_GET["Pagey"];
				if(!$_GET["Pagey"])
				{
					$Pagey=1;
				}

				$Prev_Pagey = $Pagey-1;
				$Next_Pagey = $Pagey+1;

				$Page_Starty = (($Per_Pagey*$Pagey)-$Per_Pagey);
				if($Num_Rowsy<=$Per_Pagey)
				{
					$Num_Pagesy =1;
				}
			
				else if(($Num_Rowsy % $Per_Pagey)==0)
				{
					$Num_Pagesy =($Num_Rowsy/$Per_Pagey) ;
				}
				else
				{
					$Num_Pagesy =($Num_Rowsy/$Per_Pagey)+1;
					$Num_Pagesy = (int)$Num_Pagesy;
				}
						$_GET['type_stacky'] = "DESC";
						$_GET['stacky'] = "note_id";
			
				$tel .=" ORDER  BY ".$_GET['stacky']." ".$_GET['type_stacky']." LIMIT $Page_Starty , $Per_Pagey";
				$objQuery  = mysql_query($tel);
		
	?>
                    <thead>
                      <tr>
                        <td width="4%">&nbsp;</td>
                        <td width="55%"><a href="?stack=note_name&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">หัวเรื่อง</a></td>
                        <td width="17%">วันที่ีนัด</td>
                        <td width="13%">โดย</td>
                        <td width="11%">อ่าน</td>
                      </tr>
                    </thead>
                    <tbody>
                      <?
		while($rs = mysql_fetch_array($objQuery)){
		$iy++;
		
	?>
                      <tr id="tr<?=$i?>2" onmouseover='mOvr(this,&quot;#E6E6E6&quot;);' onmouseout='mOut(this,&quot;#ffffff&quot;);'>
                        <td>&nbsp;</td>
                        <td>
                          <?=$rs[note_name]?>
                          <br/></td>
                        <td><?=$rs[note_date1]?></td>
                        <td><?=dateform($rs['note_date'])?>
                          <br/>
                          <font class="text_small_gray">By
                          <?=$rs['note_poster']?>
                        </font></td>
                        <td><a href="re_note.php?fix=true&amp;note_id=<?=$rs["note_id"];?>"  target="_blank" ><img src="images/view.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/></a></td>
                      </tr>
                      <?
			
		}
	?>
                    </tbody>
                  </table>
                </div>
		        <hr align="left"/>
                <div align="left">
                  <table width="100%">
                    <tr>
                      <td width="30%">&nbsp;</td>
                      <td width="70%" align="right"><div class="general">รวม
                        <?= $Num_Rowsy;?>
                        รายการ :
                        <?
				if($Prev_Pagey)
				{
					echo " <a href='$_SERVER[SCRIPT_NAME]?Pagey=$Prev_Pagey'><< Back</a> ";
				}

				for($i=1; $i<=$Num_Pagesy; $i++){
					if($i != $Pagey)
					{
						echo "<a href='$_SERVER[SCRIPT_NAME]?Pagey=$i'> $i </a>";
					}
					else
					{
						echo " <font size=4 color=green><b> $i </b></font> ";
					}
				}
	
				if($Pagey!=$Num_Pagesy)
				{
					echo " <a href ='$_SERVER[SCRIPT_NAME]?Pagey=$Next_Pagey'>Next>></a> ";
				}
				?>
                      </div></td>
                    </tr>
                  </table>
                  <input type="hidden" name="num_rows2" id="num_rows2" value="<?=$Num_Rows?>" />
                </div>
	          </form>
		  </div>
	  </div>
	</div>
	<!----------------------------------------------------------------------------------------------------------------------------- -->
	
	<div class="down_bar"></div>
	<? include "include_down.php";?>
</div>
</body>

</html>
