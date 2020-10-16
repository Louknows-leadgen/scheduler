<?php

  $con = mysql_connect("localhost","root","");
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }
	
	mysql_select_db("workforce", $con);

if($_GET['todo'] == '100')
 {
  mysql_query ($sql = "TRUNCATE TABLE data"); 
  mysql_query ($sql = "TRUNCATE TABLE datatemp"); 
 }
 
else if($_GET['todo'] == '10')
 {
$filename = "data.xls";
header("Content-Disposition: attachment; filename=\"$filename\""); 
header("Content-Type: application/vnd.ms-excel");

echo "BTN"; echo "\t";
echo "Batchfile"; echo "\t";
echo "Timezone"; echo "\t";
echo "Calldate"; echo "\t";
echo "Disposition"; echo "\t";
echo "\n";

$result = mysql_query("SELECT * FROM data");
 while($row = mysql_fetch_array($result))
  {
echo $row['btn']; echo "\t";
echo $row['batchfile']; echo "\t";
echo $row['timezone']; echo "\t";
echo $row['calldate']; echo "\t";
echo $row['disposition']; echo "\t";
echo "\n";	  
  }


 }
 
 else if($_GET['todo'] == '30')
 {
$filename = "data.xls";
header("Content-Disposition: attachment; filename=\"$filename\""); 
header("Content-Type: application/vnd.ms-excel");

$contact = mysql_query("SELECT COUNT(disposition) AS counter FROM datatemp");
$contactctr = mysql_fetch_array($contact);

echo "\t\t";echo "Total Leads Selected"; echo "\t\t\t";echo $contactctr['counter']; echo "\n";

     $totalcomplete = 0;
	 $result = mysql_query("SELECT * FROM dispotable WHERE complete = 'Y'");
	 while($row = mysql_fetch_array($result))
	 {
		$contact = mysql_query("SELECT COUNT(disposition) AS counter FROM datatemp WHERE disposition='".$row['dispo']."'");
		$contactctr = mysql_fetch_array($contact);
		if($contactctr['counter'] > 0)
		{
		$totalcomplete = $totalcomplete + $contactctr['counter'];	        
		}		
	 }

echo "\t\t";echo "Completes"; echo "\t\t\t";echo $totalcomplete; echo "\n";
echo "\n\n";
echo " Disposition "; echo "\t";
echo " BTN Count "; echo "\t";
echo " "; echo "\t";
echo "\n";

echo " NO CONTACTS "; echo "\n";
     $totalnocont = 0;
	 $result = mysql_query("SELECT * FROM dispotable WHERE contact = 'N'");
	 while($row = mysql_fetch_array($result))
	 {
		$contact = mysql_query("SELECT COUNT(disposition) AS counter FROM datatemp WHERE disposition='".$row['dispo']."'");
		$contactctr = mysql_fetch_array($contact);
		if($contactctr['counter'] > 0)
		{
		$totalnocont = $totalnocont + $contactctr['counter'];	
        echo $row['dispo']; echo "\t"; echo $contactctr['counter']; echo "\n";
		}
	 }
	 echo "Total No Contact"; echo "\t"; echo $totalnocont; echo "\n\n";

echo " NO RPC "; echo "\n";
     $totalnorpc = 0;
	 $result = mysql_query("SELECT * FROM dispotable WHERE rpc = 'N'");
	 while($row = mysql_fetch_array($result))
	 {
		$contact = mysql_query("SELECT COUNT(disposition) AS counter FROM datatemp WHERE disposition='".$row['dispo']."'");
		$contactctr = mysql_fetch_array($contact);
		if($contactctr['counter'] > 0)
		{
		$totalnorpc = $totalnorpc + $contactctr['counter'];	
        echo $row['dispo']; echo "\t"; echo $contactctr['counter']; echo "\n";
		}
	 }
	 echo "Total No RPC"; echo "\t"; echo $totalnorpc; echo "\n\n";
	 
echo " NOT QUALIFIED "; echo "\n";
     $totalnotqual = 0;
	 $result = mysql_query("SELECT * FROM dispotable WHERE qualified = 'N'");
	 while($row = mysql_fetch_array($result))
	 {
		$contact = mysql_query("SELECT COUNT(disposition) AS counter FROM datatemp WHERE disposition='".$row['dispo']."'");
		$contactctr = mysql_fetch_array($contact);
		if($contactctr['counter'] > 0)
		{
		$totalnotqual = $totalnotqual + $contactctr['counter'];	
        echo $row['dispo']; echo "\t"; echo $contactctr['counter']; echo "\n";
		}
	 }
	 echo "Total Not Qualified"; echo "\t"; echo $totalnotqual; echo "\n\n";
	 

echo " FAILED RPC "; echo "\n";
     $totalrpcf = 0;
	 $result = mysql_query("SELECT * FROM dispotable WHERE rpc = 'F'");
	 while($row = mysql_fetch_array($result))
	 {
		$contact = mysql_query("SELECT COUNT(disposition) AS counter FROM datatemp WHERE disposition='".$row['dispo']."'");
		$contactctr = mysql_fetch_array($contact);
		if($contactctr['counter'] > 0)
		{
		$totalrpcf = $totalrpcf + $contactctr['counter'];	
        echo $row['dispo']; echo "\t"; echo $contactctr['counter']; echo "\n";
		}
	 }
	 echo "Total Failed RPC"; echo "\t"; echo $totalrpcf; echo "\n\n";	 
	 
	 
	    $sale = 'sale';
		$contact = mysql_query("SELECT COUNT(disposition) AS counter FROM datatemp WHERE disposition LIKE '%sale%'");
		$contactctr = mysql_fetch_array($contact);	 
		$totalsale = $contactctr['counter'];
		$sumtotal = $totalsale + $totalrpcf +  $totalnotqual + $totalnorpc + $totalnocont;	 
	 
	 echo "VERIFIED SALE"; echo "\t"; echo $totalsale; echo "\n";
	 echo "PREMIUM SALE"; echo "\t"; echo "0";	 echo "\n";
	 echo "COMBINED SALE"; echo "\t"; echo $totalsale;	 echo "\n\n";
	 echo "TOTAL CALLS"; echo "\t"; echo $sumtotal;	 echo "\n";
	 
echo " SYSTEM DISPOSITION "; echo "\n";
     $totalsyst = 0;
	 $result = mysql_query("SELECT * FROM dispotable WHERE systdispo = 'Y'");
	 while($row = mysql_fetch_array($result))
	 {
		$contact = mysql_query("SELECT COUNT(disposition) AS counter FROM datatemp WHERE disposition='".$row['dispo']."'");
		$contactctr = mysql_fetch_array($contact);
		if($contactctr['counter'] > 0)
		{
		$totalsyst = $totalsyst + $contactctr['counter'];	
        echo $row['dispo']; echo "\t"; echo $contactctr['counter']; echo "\n";
		}
	 }
	 echo "Total System Disposition"; echo "\t"; echo $totalsyst; echo "\n\n";	
	 
	  	 
echo " TIMEZONE "; echo "\n";	
echo " Leads Selected "; echo "\t";
echo " BTN Count "; echo "\t"; 
echo " Completed "; echo "\t";
echo " Available "; echo "\t"; echo "\n";

	 $result = mysql_query("SELECT timezone,disposition,COUNT(timezone) AS counter FROM datatemp GROUP BY timezone");
	 while($row = mysql_fetch_array($result))
	 {
      $resultpud = mysql_query("SELECT COUNT(datatemp.timezone) AS counterpud FROM datatemp, dispotable WHERE datatemp.disposition = dispotable.dispo AND dispotable.complete = 'Y' AND datatemp.timezone = '".$row['timezone']."'");
      $rowpud = mysql_fetch_array($resultpud);
      $sum = $row['counter'] - $rowpud['counterpud'];
      echo $row['timezone']; echo "\t";
	  echo $row['counter']; echo "\t";
	  echo $rowpud['counterpud']; echo "\t";
	  echo $sum; echo "\t"; echo "\n";
	 }
	 
 }
 
 
 


?>