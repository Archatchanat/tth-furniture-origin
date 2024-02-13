<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 
	
	if($_GET['customers_id']!=""){
		$_SESSION["str_customers_id"] = $_GET['customers_id'];
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>customers</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="partner.js"></script>


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
		
			
			<form method="get" action="billing_customers.php" name="form2" onSubmit="return checkvalue2()">
			<table width="100%">
				<tr>
					
					<td width="26%">
						โปรเจค : <? $tel_one = "select  * 
						from    customers
						where 
						   	   customers.customers_id = '".$_SESSION["str_customers_id"]."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
					
			
				echo $customers_com    = $rs_one['customers_com'];
				
				
			}?>
					  <input name="button" type="button" value="กลับ" onclick="window.location='billing1_customers.php';"/>
                      <? if($_GET[fix]=="true"){?>
					  <input type="hidden" name="fix" id="fix"  value="true"/>
					  <input type="hidden" name="orderid_id" id="orderid_id" value="<?=$_GET[orderid_id]?>" />
					  <input type="hidden" name="edit" id="edit"  value="true"/>
                      <? } else { ?>
					  <input type="hidden" name="action" id="action" value="add"/>
                      <? } ?>                  </td>
			  </tr>
			</table>
			</form>
			<hr/>
			
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : add data --><!--end__ : edit data-->	
	<!---------------------------------------------------------------------------------------------------------------------------- -->
	
	<!-------------------------------------------------------------------------------------------------------------------------------------- -->
	<!--start : list data -->		
	<form name="list" method="post" action="" onsubmit="return ConfAll()">
	<table width="100%" border="0" cellspacing="0">
	<?
		// query area
		$i=0;
		
	
		
			$tel = "select * 
					from    customers_project
					where  customers_p_publish='Yes' and  
						   customers_id   = '".$_SESSION["str_customers_id"]."'";
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
				
						$_GET['type_stack'] = "DESC";
				}
			
				if($_GET['stack']=="")
				{ 
						$_GET['stack'] = "customers_p_id";
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>	
  	<thead>
		<tr>
			<td width="63%">
				<? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
   					<a href="" style="text-decoration:none; color:#000000;">ชื่อโปรเจค</a><a href="" style="text-decoration:none; color:#000000;"></a>
				<? }else { ?>
   					<a href="" style="text-decoration:none; color:#000000;">ชื่อโปรเจค</a><a href="" style="text-decoration:none; color:#000000;"></a>
				<? } ?>			</td>
			<td width="25%"><a href="?stack=orderid_date1&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">หมวดหมู่โปรเจค</a> </td>
			<td width="12%">เลือก</td>
			</tr>
	</thead>
	<tbody>
	
	<?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
  	<tr id="tr<?=$i?>" onMouseOver='mOvr(this,"#E6E6E6");' onMouseOut='mOut(this,"#ffffff");'>
		<td><?=$rs['customers_p_name']?></td>
		<td><? $tel_onew = "select  * 
						from    project_category where project_c_id='".$rs['project_c_id']."' 
						";
			$get_onew= mysql_query($tel_onew);
			$rs_onew = mysql_fetch_array($get_onew);?>
            <?=$rs_onew['project_c_name']?>
        </td>
		<td>
			<a href="billing1.php?<? if($_GET[fix]=="true"){echo "fix=true&billing_id=$_GET[billing1_id]&edit=true";}else{echo"action=add";}?>&customers_id=<?=$rs["customers_id"];?>&customers_p_id=<?=$rs["customers_p_id"];?>">
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
