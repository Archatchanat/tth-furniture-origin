<?
header("Content-type:text/html; charset=utf-8");          
header("Cache-Control: no-store, no-cache, must-revalidate");         
header("Cache-Control: post-check=0, pre-check=0", false); 
	include "../connect/connect.php";
	include "../connect/function.php";	
	if ($_POST["sCusID"]!=""){
	$strSQL = "SELECT * FROM bid WHERE 1 AND bid_id = '".$_POST["sCusID"]."' ";
	$objQuery = mysql_query($strSQL) or die (mysql_error());
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close();
	
	echo json_encode($resultArray);
	}
	if ($_POST["price1"]!=""){
	
echo $_POST["price1"]*$_POST["qty1"];

	}
	if ($_POST["sCus"]!=""){
	
echo num2string("$_POST[sCus]");

	}
	
	if ($_POST["billing_amount_vat"]!=""){
echo number_format($_POST[billing_amount_vat]*0.07, 0,'.','');

	}
	if ($_POST["billing_amount_sum"]!=""){
echo ($_POST[billing_amount_sum]+number_format($_POST[billing_amount_sum]*0.07, 0,'.',''));

	}
	if ($_POST["billing_amount_en"]!=""){
	$b1=($_POST[billing_amount_en]+number_format($_POST[billing_amount_en]*0.07, 0,'.',''));
echo num2string("$b1");

	}
	if ($_POST["sCusIDs"]!=""){
	$strSQL = "SELECT * FROM customers WHERE 1 AND customers_id = '".$_POST["sCusIDs"]."' ";
	$objQuery = mysql_query($strSQL) or die (mysql_error());
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close();
	
	echo json_encode($resultArray);
	}
	if ($_POST["billing_approve"]!=""){
	$strSQL = "SELECT * FROM bid WHERE 1 AND bid_id = '".$_POST["billing_approve"]."' ";
	$objQuery = mysql_query($strSQL) or die (mysql_error());
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close();
	
	echo json_encode($resultArray);
	}
	
?>