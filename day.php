<?php
$month = 1;
$sampledateint = mktime(0,0,0,$month,date("d")+2,date("Y"));
$startdateint = mktime(0,0,0,$month,1,date("Y"));
$sampledate = date("Y-F-d l", $sampledateint);
$monthyear = date("Y-F",$sampledateint);
$days_in_month=cal_days_in_month(CAL_GREGORIAN, date("m",$sampledateint), date("Y",$sampledateint));
echo $sampledate;

//Header
echo "<table border='1' align = 'center'/>";
echo "<tr bgcolor='#CCCCCC'><td colspan = '7' align = 'center' width = '840'>"; 
echo $monthyear; 
echo "</td></tr>";
 echo "<tr><td align = 'center' bgcolor='#FF3300' width = '120'> Sunday </td>";
 echo "<td align = 'center' width = '120'> Monday </td>";
 echo "<td align = 'center' width = '120'> Tuesday </td>";
 echo "<td align = 'center' width = '120'> Wednesday </td>";
 echo "<td align = 'center' width = '120'> Thursday </td>";
 echo "<td align = 'center' width = '120'> Friday </td>";
 echo "<td align = 'center' bgcolor='#CC6600' width = '120'> Saturday </td>";
 echo"</tr>";

 echo "<tr  height = '75'>";
//count blank days
$ctr = 1;
  while($ctr < 8)
  {  
	  switch($ctr)
	  {
		  case 1:
		   $day = 'Sunday';
		   echo "<td bgcolor='#FF3300'>";
		   break;
		  case 2:
		   echo "<td>";
		   $day = 'Monday';
		   break;
		  case 3:
		   echo "<td>";
		   $day = 'Tuesday';
		   break;
		  case 4:
		   echo "<td>";
		   $day = 'Wednesday';
		   break;
		  case 5:
		   echo "<td>";
		   $day = 'Thursday';
		   break;
		  case 6:
		   echo "<td>";
		   $day = 'Friday';
		   break;
		  case 7:
		   echo "<td bgcolor='#CC6600'>";
		   $day = 'Saturday';
		   break;
		  default:
		   echo "<td>";
		   break;
	  }
	  
	  if($day == date("l",$startdateint))
	  {		  	  
		  $datectr = $ctr;
		  $ctr = $ctr + 8;	
		  echo "1</td>";
	  }
	  
	  else
	  {
		  echo "&nbsp;</td>";
		  $ctr = $ctr + 1;
	  }
	  
	  
  }
  
//start counting days
$ctr = $datectr + 1;
$datectr = 2;
  while($datectr <= $days_in_month)
  {  
	  switch($ctr)
	  {
		  case 1:
		   $day = 'Sunday';
		   echo "<tr height = '75'>";
		   echo "<td bgcolor='#FF3300'>";
		   break;
		  case 2:
		   echo "<td>";
		   $day = 'Monday';
		   break;
		  case 3:
		   echo "<td>";
		   $day = 'Tuesday';
		   break;
		  case 4:
		   echo "<td>";
		   $day = 'Wednesday';
		   break;
		  case 5:
		   echo "<td>";
		   $day = 'Thursday';
		   break;
		  case 6:
		   echo "<td>";
		   $day = 'Friday';
		   break;
		  case 7:
		   echo "<td bgcolor='#CC6600'>";
		   $day = 'Saturday';
		   break;
		  default:
		   echo "<td>";
		   break;
	  }
	  
	  echo $datectr."</td>";
	  
	  //counter increment
	  
	  $datectr = $datectr + 1;
	  
	  
	  
      //week end
	  if($ctr >= 7)
	  {
		  echo "</tr>";
		  $ctr = 1;
	  }
	  else
	  {
		  $ctr = $ctr + 1;
	  }
	  
	  
  }  
  
  
  
  echo "</tr>";


?>
