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
<form action = "" method = "post">
  <p>Generate Payroll</p>
       <p>
         Payroll ID:
         <input type="text" name="payrollid"/>
  </p>
       <p>Payroll Description:
         <input type="text" name="payrolldescription"/>
       </p>
       <p>
         <select name="Month">
           <option value="00">Month</option>
           <option value="01">January</option>
           <option value="02">February</option>
           <option value="03">March</option>
           <option value="04">April</option>
           <option value="05">May</option>
           <option value="06">June</option>
           <option value="07">July</option>
           <option value="08">August</option>
           <option value="09">September</option>
           <option value="10">October</option>
           <option value="11">November</option>
           <option value="12">December</option>
         </select>
         
         <select name="Period">
           <option value="">Pay Period</option>
           <option value="10th">10th</option>
           <option value="25th">25th</option>
         </select> 
         <input type = "hidden" name ="todo" value = "15"/>
         <input type="submit" name="generate" value="Create Pay Period" />
       </p>
</form> 


<?php

if($_POST['todo']=='15')
{
	 $payoutday = (str_replace("th","",$_POST['Period']));
	 $totalsss = '0';
	 $totalhdmf = '0';
	 $totalphilhealth = '0';
	 $totaltaxpaid = '0';
	 $totalincome = '0';
	 
		     if($payoutday == '25')
			   {
			    $paydaystart = 01;
				$paydayend = 15;
				$payoutmonth = $_POST['Month'];
			    $paystart = mktime(0,0,0,date("$payoutmonth"),date("$paydaystart"),date("Y"));
				$payend = mktime(0,0,0,date("$_POST[Month]"),date("$paydayend"),date("Y"));
			   }
			  else
			   {
			    $paydaystart = 16;
				$paydayend = 00;
				$payoutmonth = $_POST['Month'] - '1';
			    $paystart = mktime(0,0,0,date("$payoutmonth"),date("$paydaystart"),date("Y"));
				$payend = mktime(0,0,0,date("$_POST[Month]"),date("$paydayend"),date("Y"));
			   }	
					   

			 $year = date("Y");
			 $periodpay = "".$year."-".$_POST['Month']."-".$payoutday."";
		    
echo "<font size = '1'>";
echo "<table border = '1' align = 'center' width = '1100'";
echo "<tr><td align='center' colspan = '6'> Schedule</td></tr>";
						  echo "<tr><td align = 'center'>ShiftDate</td>";
						  echo "<td align = 'center'>DayofWeek</td>";
						  echo "<td align = 'center'>Work/Off</td>";
						  echo "<td align = 'center'>Log</td>";
						  echo "<td align = 'center'>Status</td>";
						  echo "<td align = 'center'>Scheduled Out</td></tr>";


				
		$result =mysqli_query($con,"SELECT * from prlemployeemaster WHERE active = '1' ORDER BY lastname asc");
		while($row = mysqli_fetch_array($result))
                  {
					  $ctr = 0;
					  
					  echo "<tr><td>";
					  $paystart = mktime(0,0,0,date("$payoutmonth"),date("$paydaystart"),date("Y"));					  
					  echo $row['employeeid']."</td>";
					  echo "<td align = 'center'>DayofWeek</td>";
						  echo "<td align = 'center'>Work/Off</td>";
						  echo "<td align = 'center'>Log</td>";
						  echo "<td align = 'center'>Status</td>";
						  echo "<td align = 'center'>Time In</td>";
						  echo "<td align = 'center'>Lunch In</td>";	
						  echo "<td align = 'center'>Lunch Out</td>";
						  echo "<td align = 'center'>Scheduled Out</td>";
						  echo "<td align = 'center'>Time Out</td>";
						  echo "<td align = 'center'>Total Late</td>";						  
						  echo "<td align = 'center'>Total OT</td></tr>";						  
		    
			           while($paystart<=$payend)
			            {$otday = 0;						
							$early = 0;
							$late = 0;
							$ot =0;
							$undertime = 0;
							$status = "";
							$totalot = 0;
							$lateundertime = 0;
						  $date = date("Y-m-d H:i:s", $paystart);
						  $test = date("l", $paystart);
				          $dateexplode = explode(" ", $date);
				          $dateday = $dateexplode[0];
				          $datetime = $dateexplode[1];		
						  
						  
						  if($test == 'Saturday')
						  {
							  $checkoff = "Sat";
						  }
						  else if($test == 'Sunday')
						  {
							  $checkoff = "Sun";
						  }
						  else if($test == 'Monday')
						  {
							  $checkoff = "Mon";
						  }
						  else if($test == 'Tuesday')
						  {
							  $checkoff = "Tue";
						  }
						  else if($test == 'Wednesday')
						  {
							  $checkoff = "Wed";
						  }		
						  else if($test == 'Thursday')
						  {
							  $checkoff = "Thu";
						  }
						  else if($test == 'Friday')
						  {
							  $checkoff = "Fri";
						  }						  
						  echo "<tr>";
						  echo "<td align = 'center'>"; echo $dateday; echo "</td>";
						  echo "<td align = 'center'>"; echo $test; echo "</td>";
						  $ctr = $ctr + 1;
						  
						  $resultday = mysqli_query($con,"SELECT * from groupschedule WHERE groupschedulename = '".$row['schedule']."'");	
						  $rowday = mysqli_fetch_array($resultday);								  						  
						  
						  $resultlog =mysqli_query($con,"SELECT * from uploaded WHERE userid = '".$row['employeeid']."' AND shiftdate = '$dateday' ");
						  $logcount = mysqli_num_rows($resultlog);
						  $log = mysqli_fetch_array($resultlog);
						  echo "<td align = 'center'>";
						             if ($rowday[$checkoff] == '1')
						               {
						                   echo $log['actualschedtimein'];
										   
						               }
						             else
						               {
						                   echo "Day OFF";
										   
										   if ($ctr > 7 || $ctr < 5)
										   {
										      $ctr = 0;
										   }										 
						               }					
						  
						  echo "</td>";								  
						  if($logcount == '1')
						  {
							    echo "<td align = 'center'>Has Log</td>";							      
							  if($log['status']!="")
							  {
								  echo "<td align = 'center'>";
								  echo $log['status']."</td>";
								  $status = $log['status'];								  
							  }		
							  else
							  {								
								  echo "<td align = 'center'>";
								  if ($ctr == 6)
								  {
									  $inscheddate = explode(" ", $log['actualin']);
									  $otday = $ctr;
									  $status = $otday;
								     echo "6th Day";
								  }
								  
								  else if ($ctr == 7)
								  {
									  $inscheddate = explode(" ", $log['actualin']);
									  echo "7th Day";
									  $otday = $ctr;
									  $status = $otday;
									  $ctr = 0;
								  }
								  else if ($ctr > 7)
								  {
									  $inscheddate = explode(" ", $log['actualschedtimein']);
									  $ctr = 1;
									  echo $ctr;
								      echo "Present</td>";
									  $status = "Present";
									  
									  
								  }

								  else
								  {
									  $inscheddate = explode(" ", $log['actualschedtimein']);
									  echo $ctr;
								     echo "Present</td>";
									 $status = "Present";
								  }
								  								  
							
							      echo "<td align = 'center'>";
							      echo $log['actualin'];
							      echo "</td>";				
							      echo "<td align = 'center'>";
							      echo $log['actuallunchin'];
							      echo "</td>";
								  echo "<td align = 'center'>";
							      echo $log['actuallunchout'];
							      echo "</td>";
								  echo "<td align = 'center'>";
							      echo $log['actualschedtimeout'];
							      echo "</td>";
								  echo "<td align = 'center'>";
							      echo $log['actualout'];
							      echo "</td>";								  
								  
								  $indate = explode(" ", $log['actualin']);
								  $inday = explode("-", $indate[0]);
								  $intime = explode(":", $indate[1]);
								  $intin = mktime($intime[0],$intime[1],$intime[2],$inday[1],$inday[2],$inday[0]);
								  								 
								  $inschedday = explode("-", $inscheddate[0]);
								  $inschedtime = explode(":", $inscheddate[1]);
								  $intschedin = mktime($inschedtime[0],$inschedtime[1],$inschedtime[2],$inschedday[1],$inschedday[2],$inschedday[0]);								  
								  
								  $inlunchdate = explode(" ", $log['actuallunchin']);
								  $inlunchday = explode("-", $inlunchdate[0]);
								  $inlunchtime = explode(":", $inlunchdate[1]);
								  $intlunchin = mktime($inlunchtime[0],$inlunchtime[1],$inlunchtime[2],$inlunchday[1],$inlunchday[2],$inlunchday[0]);
								  
								  $outlunchdate = explode(" ", $log['actuallunchout']);
								  $outlunchday = explode("-", $outlunchdate[0]);
								  $outlunchtime = explode(":", $outlunchdate[1]);
								  $intlunchout = mktime($outlunchtime[0],$outlunchtime[1],$outlunchtime[2],$outlunchday[1],$outlunchday[2],$outlunchday[0]);								  
								  
								  $outdate = explode(" ", $log['actualout']);
								  $outday = explode("-", $outdate[0]);
								  $outtime = explode(":", $outdate[1]);
								  $intout = mktime($outtime[0],$outtime[1],$outtime[2],$outday[1],$outday[2],$outday[0]);	
								  
								  $outscheddate = explode(" ", $log['actualschedtimeout']);
								  $outschedday = explode("-", $outscheddate[0]);
								  $outschedtime = explode(":", $outscheddate[1]);
								  $intschedout = mktime($outschedtime[0],$outschedtime[1],$outschedtime[2],$outschedday[1],$outschedday[2],$outschedday[0]);								  
								  
								  
								  $nytnine = $paystart + 79200;
								  $nyttwelve = $paystart + 86400;
								  $nytsix = $paystart + 108000;
								  $nytstart = $nytnine;
								  $nytend = $nytsix;
								  $nyttotal = 0;
								  
								  
								  
								  
								  if($intschedin > $intin)
								  {
									  $early = $intschedin - $intin;
									  echo "<td> Early : ".$early."</td>";
								  }
								  else
								  {
									  if($intin > $intlunchin)
									  {
										  $late = $intlunchin - $intschedin;
						                   if($late < 0 )
						                     {
							                     $late = 0;
						                     }										  
										  echo "<td> Late : ".$late." ".$otday."</td>";
										  
										  
									  }
									  else
									  {
									      $late = $intin - $intschedin;
									      echo "<td> Late : ".$late."</td>";									  
									  }
								  }
								  
								  //for 6th/7th day ot
								  if($otday == 6 || $otday == 7)
								  {
									  $ot = $intout - $intin;
									  echo "<td> OT  6/7: ".$ot."</td>";
									  
									  if($intin > $nytstart)
									  {
										  $nytstart = $intin;
									  }
							
									  if ($intout < $nytend && $intout > $nytstart)
									  {
										  $nytend = $intout;
									  }
									  else if ($intout < $nytstart)
									  {
										  $nytend = $nytstart;
									  }
									  $nyttotal = $nytend - $nytstart;

									  
									  echo "<td> nyt : ".$nyttotal;
									  
								  }
								  
								  else
								  {
									  if($intout > $intschedout)
									  {
									  $ot = $intout - $intschedout;
									  }
									  else
									  {
										  $undertime = $intschedout - $intout;
									  }
									  echo "<td> OT : ".$ot." Undertime : ".$undertime."</td>";
									  
									  if($intin > $nytnine && $intin < $intlunchin)
									  {   
									      $nytstart = $intin;
									  }
									  else if($intin > $nytnine && $intin>= $intlunchin)
									  {
										  $nytstart = $intlunchin;
									  }
									  									  
									  if($intlunchin > $nytnine && $intlunchin < $nyttwelve)
									  {
										  $nytend = $intlunchin;
									  }
									  else if($intlunchin < $nytnine)
									  {
										  $nytend = $nytstart;
									  }
									  else if ($intlunchin > $nytsix)
									  {
										  $nytend = $nytsix;
									  }
									  
									  else
									  {
										  $nytend = $intlunchin;
									  }
									  
									  $nyttotal = $nytend - $nytstart;

									  
									  //postlunch nytdiff
									  $nytstart = $nytnine;
								      $nytend = $nytsix;
									  if($intlunchout > $nytnine && $intlunchout <= $nytsix)
									  {
										  $nytstart = $intlunchout;
									  }
									  else if($intlunchout > $nytsix)
									  {
										  $nytstart = $nytsix;
									  }
									  else
									  {
										  $nytstart = $nytnine;
									  }
									  if($intout > $nytnine && $intout <= $nytsix)
									  {
										  $nytend = $intout;
									  }
									  else if($intout > $nytsix)
									  {
										  $nytend = $nytsix;
									  }
									  
									  else
									  {
										  $nytend = $nytnine;
									  }
									  
									  $nyttotal = $nyttotal + ($nytend - $nytstart);

									  echo "<td>totalnyt dif : ".$nyttotal."</td>";
								  }
								  
								  
		  					  }				
							  
						  }
						  
						  else
						  {
							  echo "<td align = 'center'>No Log</td>";
							  $status = "No Log";							      
						  }						  
						  
						  
						  /*Inserting into hours*/
						  echo "<tr><td>";
						  echo $dateday;
						  echo "</td>";
						  echo "<td>";
						  echo $row['employeeid'];
						  echo "</td>";
						  echo "<td>";
						  echo $status;
						  echo "</td>";	
						  echo "<td>";
						  echo $late." + ".$undertime;
						  $lateundertime = $late + $undertime;
						  echo "</td>";							  					  
						  echo "<td>";
						  echo $ot." + ".$early;
						  $totalot = $ot + $early;
						  echo "<td>";
						  echo $nyttotal;
						  echo "</td>";						  
						  echo "</td></tr>";
						  mysqli_query($con,"INSERT INTO hours(employeeid, date, night, status, ot, lateundertime) 
						  VALUES('".$row['employeeid']."', '$dateday', '$nyttotal', '$status', '$totalot', '$lateundertime')");
						  
						  
						  $paystart = $paystart + 86400;						  
			            }				  
				  }
			 
			 
			$paystart = date("Y-m-d", $paystart);
			$payend = date("Y-m-d H:i:s", $payend + 86399);

}

?>
</body>
</html>
</body>
</html>