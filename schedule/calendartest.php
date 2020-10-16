<?php
session_start();
ob_start();


include('db_connect.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
<?
/**Getting Info**/
$month='07';
$year='2012';
$paydate='10';
$userid='0900018';
$payperiod='2012-07-10';

echo $payperiod." ".$userid."<br />";

$getdates = mysql_query("select * from prlpayrollperioddate WHERE payperiod = '2012-07-10'");
$getstartend = mysql_fetch_array($getdates);

$starttime = strtotime($getstartend['startdate']);
    
	while($starttime <= strtotime($getstartend['enddate']))
      {
		  echo date("Y-m-d", $starttime)." <br />";
		  $starttime = strtotime(date("Y-m-d",$starttime)."+ 1 day");
      }











?>
</body></html>

