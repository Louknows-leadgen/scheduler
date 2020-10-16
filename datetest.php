<?php
include("db_connect.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
$counter = 0;
$result = mysqli_query($con,"SELECT * from uploaded");
while($row=mysqli_fetch_array($result))
{
if(($row['status']=="") || (($row['timein']!= "00:00:00") &&($row['timeout'] != "00:00:00")))
{
	$counter = $counter + 1;
	if($counter>8)
	{$counter = 0;}

   
/*Getting time&date for logins/logouts*/  
   $indate = explode("-",$row['shiftdate']);
   $intime = explode(":",$row['timein']);
   $intin = mktime($intime[0],$intime[1],$intime[2],$indate[1],$indate[2],$indate[0]);
   $outtime = explode(":",$row['timeout']);
   $intout = mktime($outtime[0],$outtime[1],$outtime[2],$indate[1],$indate[2] + 1,$indate[0]);   

   /*Start Shift(any time in thats less than 7am is the previous days shift )*/
   $intstartshift = mktime(7,$intime[1],$intime[2],$indate[1],$indate[2],$indate[0]);
   
   if($intin<$intstartshift)
   {
      $intin = mktime($intime[0],$intime[1],$intime[2],$indate[1],$indate[2] + 1,$indate[0]);
   }
    
    /*End Shift(If time out - time in is greater the 1 day that is the previous days shift time out)*/
	if(($intout-$intin)>86400)
	{
		$intout = mktime($outtime[0],$outtime[1],$outtime[2],$indate[1],$indate[2],$indate[0]);
	}
	
	
	 
   $varin = date("y-m-d H:i:s", $intin);
   $varout = date("y-m-d H:i:s", $intout);

   
/*Getting Shift Schedules from Scheduler to uploader*/
    $resultemployee = mysqli_query($con,"SELECT employeeid,schedule FROM prlemployeemaster WHERE employeeid LIKE '%".$row['userid']."%'");
    $rowemployee = mysqli_fetch_array($resultemployee);

	  $resultime = mysqli_query($con,"SELECT * FROM groupschedule WHERE groupschedulename = '".$rowemployee['schedule']."'");
      $rowtime = mysqli_fetch_array($resultime);
      $schedintime = explode(":",$rowtime['starttime']);
      $intschedin = mktime($schedintime[0],$schedintime[1],$schedintime[2],$indate[1],$indate[2],$indate[0]);
	  $intschedout = mktime($schedintime[0] + 9,$schedintime[1],$schedintime[2],$indate[1],$indate[2],$indate[0]);
	  

	  $lunchstart = $rowtime['prelunch'] * 3600;
	  /*For Flexible Schedule scheduled in = actual log in*/
	  if($rowtime['groupschedulename'] =='Flexible')
	  {
		 $varschedin = date("y-m-d H:i:s", $intin);
		 $varschedout = date("y-m-d H:i:s", $intin + 32400);
		 $varlunchstart = date("y-m-d H:i:s", $intin + 14400);
		 $varlunchend = date("y-m-d H:i:s", $intin + 14400 +3600);
		 
	  } 
	  else
	  {
		  $varschedin = date("y-m-d H:i:s", $intschedin);
		  $varschedout = date("y-m-d H:i:s", $intschedout);
		  $varlunchstart = date("y-m-d H:i:s", $intschedin + $lunchstart);
		  $varlunchend = date("y-m-d H:i:s", $intschedin + $lunchstart + 3600);
	  }
	  
	  
	 
mysqli_query($con,"UPDATE uploaded set actuallunchout = '".$varlunchend."' WHERE id = '".$row['id']."'");	  
	  
echo $varschedin." ".$varin."---------------".$varlunchstart." ".$varlunchend."<br>";

//change userid in uploaded
//mysql_query("Update uploaded set userid = '".$rowemployee['employeeid']."' WHERE id = '".$row['id']."'");//





 

   
   
}
else
{
	$counter = 0;
echo " ID: ".$row['userid']." ".$row['status']."<br>";
}
}
?>

</body>
</html>