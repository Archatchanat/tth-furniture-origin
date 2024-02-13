<?php
		
					$admin_name='worlditcenter';
					$admin_wed='http://www.worldit.co.th/';
					$admin_mail='wongsakorn@worldit.co.th';
					// Function Random String 4-1-2555
					function chkBrowser($nameBroser){  
    return preg_match("/".$nameBroser."/",$_SERVER['HTTP_USER_AGENT']);  
}  

					function random_char($len)
					{
						$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
						$ret_char = "";
						$num = strlen($chars);
						for($i = 0; $i < $len; $i++)
						{
							$ret_char.= $chars[rand()%$num];
							$ret_char.=""; 
						}
						return $ret_char; 
					}
					
					
					// Function Diff
					function DateDiff($strDate1,$strDate2)
	 				{
						return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 				}
					
					
					// Function Delete Thumb && Image
					function dateform($getdate){
						$date  = substr($getdate,8,2);
						$month = substr($getdate,5,2);
						$year  = substr($getdate,0,4);
						$str_date = $date."-".$month."-".$year;
						return $str_date;
					}
					
					function dateform1($getdate){
						$date  = substr($getdate,8,2);
						$month = substr($getdate,5,2);
						$year  = substr($getdate,0,4);
						
						 $_month_name = array("01"=>"ม.ค.",  "02"=>"ก.พ.",  "03"=>"มี.ค.",    
    "04"=>"เม.ย.",  "05"=>"พ.ค.",  "06"=>"มิ.ย.",    
    "07"=>"ก.ค.",  "08"=>"ส.ค.",  "09"=>"ก.ย.",    
    "10"=>"ต.ค.", "11"=>"พ.ย.",  "12"=>"ธ.ค.");  

	$thai_m=array("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$month=$_month_name[$month];
		$year=$year+543;
						$str_date = $date."  ".$month."  ".$year;
						return $str_date;
					}
					function Yearform1($getdate){
						$date  = substr($getdate,8,2);
						$month = substr($getdate,5,2);
						$year  = substr($getdate,0,4);
						
						
						$str_date = $year;
						return $str_date;
					}
					
						function monthform1($getdate){
						$date  = substr($getdate,8,2);
						$month = substr($getdate,5,2);
						$year  = substr($getdate,0,4);
						
						
						$str_date = $month."-".$year;
						return $str_date;
					}
					function monthform2($getdate){
						$date  = substr($getdate,8,2);
						$month = substr($getdate,5,2);
						$year  = substr($getdate,0,4);
						
						
						$str_date = $year."-".$month;
						return $str_date;
					}
					// Function Delete Thumb && Image
					function delete_image($folder,$thumb,$image)
					{
						if($thumb !="" && $image !=""){
						$flgDelete_thumb = unlink("$folder/".$thumb."");
						$flgDelete_image = unlink("$folder/".$image."");
						
						if($flgDelete_thumb && $flgDelete_image){
							$result = "File Deleted";
						}
						else{
							$result = "File can not deleted";
						}
						return $result;
						}
					}
					
					
					// Function Delete Image
					function delete_one_image($folder,$image)
					{
						if($image !=""){
						
							$flgDelete_image = unlink("$folder/".$image."");
						
							if($flgDelete_image){
								$result = "File Deleted";
							}
							else{
								$result = "File can not deleted";
							}
							
							return $result;
						}
					}
					
					
					// Function Insert
					function insert($field,$value,$table)
					{
						$sql = "INSERT INTO $table ($field) VaLUES ($value)";
						//echo $sql;
						$result= mysql_query($sql);
						return $result;
					}
							
							
					// Function Delete 
					function delete($table,$condition)
					{
						$sql ="delete from $table $condition";
						$result = mysql_query($sql);
						return $result;
					}
					
							
					// Function Update
					function update($table,$command,$condition)
					{
						$sql = "UPDaTE $table SET $command $condition";
						$result = mysql_query($sql);
						return $result;
					}
					
							
					// Function Select		
					function select($table,$condition)
					{
						$sql = "select * from $table $condition";
						//echo $sql;
						$dbquery = mysql_query($sql);
						$result= mysql_fetch_array($dbquery);
						return $result;
					}
					
					
					// Function Select Alldate	
					function selectalldate($table,$condition,$listby)
					{
						$sql = "select * from  $table  $condition $listby";
						//echo $sql;
						$dbquery = mysql_query($sql);
						return $dbquery;	
					}
					
									
					// Function Select MaxorMin
					function selectMaxOrMin($maxormin,$field,$table,$condition)
					{
						$sql = "select $maxormin($field) as $field from $table $condition";
						$dbquery = mysql_query($sql);
						$result= mysql_fetch_array($dbquery);
						return $result;
					}
					
							
					// Function Select First or Last 
					function selectFistOrLast($table,$condition,$fieldlist,$bylist)
					{
						$sql 	 = "select * from $table $condition order by $fieldlist $bylist";
						$dbquery = mysql_query($sql);
						$result	 = mysql_fetch_array($dbquery);
						return $result;
					}
					
					
					// Function Check Charactor
					function checkcharector($temp)
					{
						$temp=Trim(eregi_replace ( "'" , "" , $temp));
						$temp=Trim(eregi_replace ( "\"" , "&quot;" , $temp));
						return $temp;
					}
																				
					
					// Function Check Num Record		
					function num_record($table,$condition)
					{
						$sql = "select * from $table $condition";
						$dbquery = mysql_query($sql);
						$num_rows = mysql_num_rows($dbquery);
						return $num_rows;
					}
					
					
					// Function Check Null Value		
					function JscheckValueNull($form,$field,$msg)
					{
						echo"\nif(trim(document.$form.$field.value)=='')\n";
						echo"{\n";
						echo"alert('$msg');\n";
						echo"document.$form.$field.focus();\n";
						echo"return false;\n";
						echo"}\n\n";
					}
					
 function num2wordsThai($num){     
    $num=str_replace(",","",$num);  
    $num_decimal=explode(".",$num);  
    $num=$num_decimal[0];  
    $returnNumWord;     
    $lenNumber=strlen($num);     
    $lenNumber2=$lenNumber-1;     
    $kaGroup=array("","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน");     
    $kaDigit=array("","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ต","แปด","เก้า");     
    $kaDigitDecimal=array("ศูนย์","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ต","แปด","เก้า");  
	if($num==0)
   return "ศูนย์บาทถ้วน";
   
    $ii=0;     
    for($i=$lenNumber2;$i>=0;$i--){     
        $kaNumWord[$i]=substr($num,$ii,1);     
        $ii++;    
		 
    }     
    $ii=0;     
    for($i=$lenNumber2;$i>=0;$i--){  
	
   
        if(($kaNumWord[$i]==2 && $i==1) || ($kaNumWord[$i]==2 && $i==7)){     
            $kaDigit[$kaNumWord[$i]]="ยี่";     
        }else{     
            if($kaNumWord[$i]==2){     
                $kaDigit[$kaNumWord[$i]]="สอง";          
            }     
            if(($kaNumWord[$i]==1 && $i<=2 && $i==0) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==6)){     
                if($kaNumWord[$i+1]==0){     
                    $kaDigit[$kaNumWord[$i]]="หนึ่ง";        
                }else{     
                    $kaDigit[$kaNumWord[$i]]="เอ็ด";         
                }     
            }elseif(($kaNumWord[$i]==1 && $i<=2 && $i==1) || ($kaNumWord[$i]==1 && $lenNumber>6 && $i==7)){     
                $kaDigit[$kaNumWord[$i]]="";     
            }else{     
                if($kaNumWord[$i]==1){     
                    $kaDigit[$kaNumWord[$i]]="หนึ่ง";     
                }     
            }     
        }     
        if($kaNumWord[$i]==0){     
            if($i!=6){  
                $kaGroup[$i]="";     
            }  
        }     
        $kaNumWord[$i]=substr($num,$ii,1);     
        $ii++;     
        $returnNumWord.=$kaDigit[$kaNumWord[$i]].$kaGroup[$i].$kaGroup[$i];     
    }        
    if(isset($num_decimal[1])){  
        $returnNumWord.="จุด";  
        for($i=0;$i<strlen($num_decimal[1]);$i++){  
                $returnNumWord.=$kaDigitDecimal[substr($num_decimal[1],$i,1)];    
        }  
    }         
    return $returnNumWord;     
} 
function num2string($num)
 {
  $digit=Array("หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ด","แปด","เก้า");
  $unit=Array("สิบ","ร้อย","พัน","หมื่น","แสน");

  if($num==0)
   return "ศูนย์บาทถ้วน";

  if(strpos($num,".")==0)
   $num.=".00";

  $tmp=substr($num,0,strpos($num,"."));
  while(strlen($tmp)>6)
  {
   $cut=strlen($tmp)%6;
   if($cut==0)$cut=6;
   $data=substr($tmp,0,$cut);
   for($i=0;$i<strlen($data)-2;$i++)
   {
    if($data[$i]==0)
     continue;

    $ans.=$digit[$data[$i]-1].$unit[strlen($data)-$i-2];
   }
   $ans.=num2string_2digit(substr($data,strlen($data)-2))."ล้าน";
   $tmp=substr($tmp,$cut);
  }

  for($i=0;$i<strlen($tmp)-2;$i++)
  {
   if($tmp[$i]==0)
    continue;

   $ans.=$digit[$tmp[$i]-1].$unit[strlen($tmp)-$i-2];
  }

  $ans.=num2string_2digit(substr($tmp,strlen($tmp)-2))."บาท";

  $tmp=substr($num,strpos($num,".")+1);
  if(substr($tmp,0,2)=="00")
   return $ans."ถ้วน";

  return $ans.num2string_2digit($tmp)."สตางค์";
 }
 function num2string_2digit($num)
 {
  if($num!=0)
  $digit=Array("ศูนย์","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ด","แปด","เก้า");

  $ans="";
  $num=sprintf("%d",$num);

  if(strlen($num)==1)
   return $digit[$num];

  if($num[0]==2)
   $ans.="ยี่";
  else if($num[0]>2)
   $ans.=$digit[$num[0]];

  if($num[0]>0)
   $ans.="สิบ";

  if($num[1]>1)
   $ans.=$digit[$num[1]];
  else if($num[1]==1)
   $ans.="เอ็ด";

  return $ans;
 }
    
?>
