<?
	session_start();
	include "../connect/connect.php";
	include "../connect/function.php";
		header("Cache-control: private"); 
if($_GET['all']=="true"){
		$_SESSION["str_search"] = "";
	}
	if($_GET['search']!=""){
		$_SESSION["str_search"] = $_GET['search'];
		$_SESSION["str_project_c_id"] = $_GET['project_c_id'];
		
	}
	
	// start insert ----------------------------------------------------------------------------------------------------------------------
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
if($_GET["action"]=="insert")
	{
		$tellway  = "INSERT INTO customers_project VALUES(";
		$tellway .= "0
					,'$_POST[project_c_id]'
					,'$_POST[customers_id]'
					,'$_POST[customers_p_name]'
					,'".$_SESSION["str_admin_email"]."'
					,'".$_SESSION["str_admin_email"]."'
					,NOW()
					,NOW()
					,'$_POST[customers_p_publish]'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		$customers_id=mysql_insert_id();
		if ($_POST[customers_orderid_id]!="") {
		$tellway  = "INSERT INTO customers_orderid VALUES(";
		$tellway .= "0
					,'$_POST[customers_orderid_id]'
					,'$customers_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		}	
		echo "<script language=\"JavaScript\">";
		echo "window.location='project.php';";
		echo "</script>";
    }
	// end__ insert ----------------------------------------------------------------------------------------------------------------------
	
	// start update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="save")
	{	
		
		
		$sql_up = "update customers_project set
					 customers_p_name = '$_POST[customers_p_name]'
					,project_c_id ='$_POST[project_c_id]'
					,customers_p_updater ='".$_SESSION["str_admin_email"]."'
					,customers_p_update =NOW()
					,customers_p_publish ='$_POST[customers_p_publish]'
					where customers_p_id  = '".$_POST['customers_p_id']."'";
		$dbquery = mysql_query($sql_up);
		$j1=0;
		
			if ($_POST[customers_orderid_id]=="" and $_POST[customers_orderid_date] !="") {
		$tellway  = "INSERT INTO customers_orderid VALUES(";
		$tellway .= "0
					,'$_POST[customers_orderid_date]'
					,'$customers_p_id'
					";
		$tellway .= ")";
		$dbquery = mysql_query($tellway);
		}
		if ($_POST[customers_orderid_id]!="" and $_POST[customers_orderid_date] !="Yes") {
		$sql_up = "update customers_orderid set
					 customers_orderid_date    = '$_POST[customers_orderid_date]'
					where customers_orderid_id  = '".$_POST['customers_orderid_id']."'";
		$dbquery = mysql_query($sql_up);
		}else if($_POST[customers_orderid_id]!="" and $_POST[customers_orderid_date] =="Yes"){
		$sql_del= "delete from customers_orderid where customers_orderid_id='".$_POST["customers_orderid_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		}
				
		echo "<script language='JavaScript'>";
		echo "window.location='project.php';";
		echo "</script>";
    }
	// end__ update ----------------------------------------------------------------------------------------------------------------------
	if($_GET["action"]=="del")
	{
		
		$tel_check 	= "select orderid_id,orderid_co,orderid_attn,orderid_publish,orderid_date1 from    orderid  
					where  
						   customers_p_id = '".$_GET["customers_p_id"]."'
					UNION
					select billing_id,billing_co,billing_attn,billing_publish,billing_date1 from    billing  
					where  
						   customers_p_id = '".$_GET["customers_p_id"]."'
					UNION
					select billing2_id,billing2_co,billing2_attn,billing2_publish,billing2_date1 from    billing2  
					where  
						   customers_p_id = '".$_GET["customers_p_id"]."'";
		$get_check  = mysql_query($tel_check);
		$num_check  = mysql_num_rows($get_check);
		
		if($num_check>0){
		
			echo "<script language=\"JavaScript\">";
			echo"alert('รหัสโปรเจคมีอยู่ในระบบไม่สามารถลบได้');";
			echo "window.location='project.php';";
			echo "</script>";
			exit();
		}
		
		$sql_del= "delete from customers_project where customers_p_id ='".$_GET["customers_p_id"]."'";
		$dbquery_del = mysql_query($sql_del);
		
		$sql_del2= "delete from customers_orderid where customers_id ='".$_GET["customers_p_id"]."'";
		$dbquery_del2 = mysql_query($sql_del2);
		echo "<script language='JavaScript'>";
		echo "window.location=\"project.php\";";
		echo "</script>";
		}
	?>

<title>billing</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="partner.js"></script>
 <script src="js/jquery-1.8.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/dd.css" />
<script src="js/jquery.dd.min.js"></script>

<script language="JavaScript">
	function checkvalue(action){
		filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(form1.customers_p_name.value == "") {
			alert("กรุณากรอก โปรเจคชื่อ");
			form1.customers_p_name.focus();
			return false
		}
	}
	if(form1.project_c_id.value == "") {
			alert("กรุณาเลือก หมวดหมูู่โปรเจค");
			form1.project_c_id.focus();
			return false
		}
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
		
			
		  <form method="get" action="billing.php" name="form2" onSubmit="return checkvalue2()">
		    <table width="100%">
                <tr>
                  <td width="34%"><? $tel_one = "select  * 
						from    customers
						where 
						   	   customers_id = '".$_SESSION["str_search"]."'";
				
			$get_one = mysql_query($tel_one);
			
			while($rs_one = mysql_fetch_array($get_one))
			{
					
			
				$customers_com    = $rs_one['customers_com'];
				$customers_name    = $rs_one['customers_name'];
				
				
			}?>โปรเจค:<?=$customers_name?>
                  <input name="button" type="button" value="กลับ" onclick="window.location='customers_search.php?project_c_id=<?=$_GET['project_c_id']?>';"/></td>
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
		
		
		$search=$_GET[search1];
			$tel = "select * from    customers_project  
					where  
						   customers_id = '".$_SESSION["str_search"]."' and project_c_id = '".$_SESSION["str_project_c_id"]."'
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
						$_GET['stack'] = "customers_p_id";
					} else {
						$_GET['stack'] = "customers_p_id";
					}
				}
			
			
				$tel .=" ORDER  BY ".$_GET['stack']." ".$_GET['type_stack']." LIMIT $Page_Start , $Per_Page";
				$objQuery  = mysql_query($tel);
		
	?>
        <thead>
          <tr>
            <td width="43%"><? if($_GET['type_stack']=="" || $_GET['type_stack']=="DESC"){?>
                <a href="?stack=orderid_attn&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">ชื่อโปรเจค</a>
                <? }else { ?>
                <a href="?stack=orderid_attn&amp;type_stack=DESC" style="text-decoration:none; color:#000000;">ชื่อโปรเจค</a>
              <? } ?>            </td>
            <td width="23%"><a href="?stack=orderid_date1&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">หมวดหมูู่โปรเจค</a> </td>
            <td width="21%"><a href="?stack=orderid_date1&amp;type_stack=ASC" style="text-decoration:none; color:#000000;">วันที่สร้าง</a> </td>
            <td width="6%">เลือก</td>
            </tr>
        </thead>
        <tbody>
          <?
		while($rs = mysql_fetch_array($objQuery )){
		$i++;
	?>
          <tr id="tr<?=$i?>" onmouseover='mOvr(this,&quot;#E6E6E6&quot;);' onmouseout='mOut(this,&quot;#ffffff&quot;);'>
            <td><?=$rs['customers_p_name']?></td>
            <td><? $tel_onew = "select  * 
						from    project_category where project_c_id='".$rs['project_c_id']."' 
						";
			$get_onew= mysql_query($tel_onew);
			$rs_onew = mysql_fetch_array($get_onew);?>
                  <?=$rs_onew['project_c_name']?>            </td>
            <td><?=dateform($rs['customers_p_date'])?>            </td>
            <td><a href="re_project_p1.php?customers_p_id=<?=$rs['customers_p_id']?>&project_c_id=<?=$_GET['project_c_id']?>&search=<?=$_GET['search']?>"> <img src="images/view.png" onmouseover="this.style.width = '20px'" onmouseout="this.style.width = '16px'"/> </a> </td>
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
	$("#project_c_id").msDropdown();
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
