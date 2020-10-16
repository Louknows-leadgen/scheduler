<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
if($_GET['todo']=='15')
{ 
	  
   $con = mysql_connect("localhost","root","qwerty123");
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }
	
	mysql_select_db("VectorBPO", $con);
	 $payoutday = (str_replace("th","",$_GET['Period']));
	 $totalsss = '0';
	 $totalhdmf = '0';
	 $totalphilhealth = '0';
	 $totaltaxpaid = '0';
	 
		     if($payoutday == '25')
			   {
			    $paydaystart = 01;
				$paydayend = 15;
			    $paystart = mktime(0,0,0,date("$_GET[Month]"),date("$paydaystart"),date("Y"));
				$payend = mktime(0,0,0,date("$_GET[Month]"),date("$paydayend"),date("Y"));
			   }
			  else
			   {
			    $paydaystart = 16;
				$paydayend = 00;
				$payoutmonth = $_GET['Month'] + '1';
			    $paystart = mktime(0,0,0,date("$_GET[Month]"),date("$paydaystart"),date("Y"));
				$payend = mktime(0,0,0,date("$payoutmonth"),date("$paydayend"),date("Y"));
			   }			   
            $paystart = date("Y-m-d", $paystart);
			$payend = date("Y-m-d", $payend);
            $year = date("Y");			
     $sql="INSERT INTO prlpayrollperiod (payrollid, payrolldesc, startdate, enddate, fsmonth, fsyear)
     VALUES
     ('$_GET[payrollid]','$_GET[payrolldescription]',$paystart,$payend,'$_GET[Month]',$year)";			
	
//loop all employees from prl employeemaster		
		$result =mysql_query("SELECT employeeid, hourlyrate, taxstatusid, firstname, lastname, periodrate, employmenttype,RFID from prlemployeemaster");
		while($row = mysql_fetch_array($result))
		 {
//var default declaratins
		  $row = mysql_fetch_array($result);
		  $employeeid= $row['employeeid'];
		  $hourlyrate = $row['hourlyrate'];
		  $payoutamt = $row['periodrate']/'2';
		  $nontaxableincome = '0';
		  $taxableincome = '0';
		  $sss = '0';
		  $phic = '0';
		  $hdmf = '0';
		  $otherdeductions = '0';
		  $latehrs = '0';
		  $nighthrs = '0';
		  $othrs = '0';
		  $ot6hrs = '0';
		  $ot7hrs = '0';
		  $sholiday = '0';
		  $rholiday = '0';
		  $totalotamt = '0';
		  $grosstaxable = '0';
		  $daysabsent = '0';
		  $absentamt = '0';
		  $nontaxableincome = '0';
		  $taxableincome = '0';
		  
//end of var default declarations			  		  				  

//overtimerates
		$overtime =mysql_query("SELECT * from prlovertimetable");
		 while($overtimerate = mysql_fetch_array($overtime))
		   {
		     $ctr = $overtimerate['overtimeid'];
			 $multiplier[$ctr] = $overtimerate['overtimerate'];
		   }
//hoursworked for payroll period		   
		$hours =mysql_query("SELECT * from hourstable WHERE  userid = 'row[RFID]' AND dates >= $paystart AND dates <= $payend");
		 while($hoursworked = mysql_fetch_array($overtime))
		   {
			 $nighthrs = $nighthrs + $hoursworked['nightdiff_hours'] + $hoursworked['nightdiff_ot_hours']; 			
			 if($hoursworked['sixth_ot_hours'] == '1')
			    {
				  $ot6hrs = $ot6hrs + $hoursworked['regular_hours'] + $hoursworked['regular_ot_hours'] 
				  + $hoursworked['nightdiff_hours'] + $hoursworked['nightdiff_ot_hours'];				 
				}
			 else if($hoursworked['seventh_ot_hours'] == '1')
			    {
				  $ot7hrs = $ot7hrs + $hoursworked['regular_hours'] + $hoursworked['regular_ot_hours'] 
				  + $hoursworked['nightdiff_hours'] + $hoursworked['nightdiff_ot_hours'];				 
				}	
			 else
			    {
				  $latehrs = $latehrs + $hoursworked['late'] + $hoursworked['undertime'];
				  $othrs = $othrs + $hoursworked['regular_ot_hours'] + $hoursworked['nightdiff_ot_hours'];
				}
			  if($hoursworked['specialholiday_hours'] == '1')
			    {
				   $sholiday = $sholiday + $hoursworked['regular_hours'] + $hoursworked['regular_ot_hours'] 
				  + $hoursworked['nightdiff_hours'] + $hoursworked['nightdiff_ot_hours'];
				   $latehrs = $latehrs - $hoursworked['late'];
				   $othrs = $othrs - $hoursworked['regular_ot_hours'];
				}
			  else if($hoursworked['regular_holiday_hours'] == '1')
			    {
				   $rholiday = $rholiday + $hoursworked['regular_hours'] + $hoursworked['regular_ot_hours'] 
				  + $hoursworked['nightdiff_hours'] + $hoursworked['nightdiff_ot_hours'];
				   $latehrs = $latehrs - $hoursworked['late'];
				   $othrs = $othrs - $hoursworked['regular_ot_hours'];
				}	
				
            $absences =mysql_query("SELECT status,userid from timelog WHERE  userid = 'row[RFID]' AND status = 'Absent'");
			while($absent = mysql_fetch_array($absences))
			 {$daysabsent = $daysabsent + '1';}
				
		   }
//pay amt
		$nightamt = ($nighthrs)*($hourlyrate)*($multiplier['15'] - '1');
		$regot = ($othrs)*($hourlyrate)*($multiplier['10']);
		$ot6amt = ($ot6hrs)*($hourlyrate)*($multiplier['20']);
		$ot7amt = ($$ot7hrs)*($hourlyrate)*($multiplier['25']);
		$totalotamt = $regot + $ot6amt + $ot7amt;
		$sholidayamt = ($sholiday)*($hourlyrate)*($multiplier['30']);
		$rholidayamt = ($rholiday)*($hourlyrate)*($multiplier['35']);
		$holidayamt = $sholidayamt + $rholidayamt;
		$lateamt = $latehrs*($hourlyrate);
		$absentamt = ($daysabsent)*'8'*($hourlyrate);
		$grosstaxable = $holidayamt + $nightamt + $totalotamt + $payoutamt - $lateamt - $absentamt;
		$totaldeductions = $lateamt + $absencesamt;
		$payoutday = str_replace("th","",$_GET['Period']);
		$payout = mktime(0,0,0,date("$_GET[Month]"),date("$payoutday"),date("Y"));
        $datepayout = date("Y-m-d", $payout);
		
		if($_GET['Period']=='25th')
		    {
			$deduct =mysql_query("SELECT * from prlsstable WHERE rangefrom <= '$row[periodrate]' AND rangeto >= '$row[periodrate]'");
			$value = mysql_fetch_array($deduct);
			$sss = $value['employeess'];
			$deduct =mysql_query("SELECT * from prlphilhealth WHERE rangefrom <= '$row[periodrate]' AND rangeto >= '$row[periodrate]'");
			$value = mysql_fetch_array($deduct);
			$phic = $value['employeeph'];
			$hdmf = '100';
			}

		
//taxable income loop	
   		$test = mysql_query("SELECT * from prlotherincassign WHERE employeeid = $employeeid AND taxable = '0'");
		while($otherincdata = mysql_fetch_array($test))
		   { 
		    if($otherincdata['payout']=='10th,25th')
			  {
			 $otherincamt =mysql_query("SELECT othincvalue, othincid, taxable from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amt = mysql_fetch_array($otherincamt); 
			  $halfamt = $amt['othincvalue'] / '2';
			  $taxableincome = $taxableincome + $halfamt;
		  }
			  
             if($otherincdata['payout']==$_GET['Period'])
			   {
		      $otherincamt =mysql_query("SELECT othincvalue, othincid, taxable from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amt = mysql_fetch_array($otherincamt); 
               $taxableincome = $taxableincome + $amt['othincvalue'];
			   }
		    }//end of taxable income loop	
			
  $grosspay = $grosstaxable + $taxableincome - $totaldeductions;			
  $nettaxable = $grosspay - $sss - $phic - $hdmf;
  
  		$gettax = mysql_query("SELECT * FROM prltaxtablerate WHERE taxstatusid = '$row[taxstatusid]' AND rangefrom <= $nettaxable AND rangeto >= $nettaxable");
		$witholdingtax = mysql_fetch_array($gettax);
		$percentover = ($nettaxable - $witholdingtax['rangefrom'])*(($witholdingtax['percentofexcessamount'])/'100');
		$totaltax =  $witholdingtax['fixtax'] + $percentover;
		$salarydeductions = $sss + $totaltax + $phic + $hdmf + $otherdeductions;		

//nontaxable income loop
   		$otherinc =mysql_query("SELECT * from prlotherincassign WHERE employeeid = $employeeid AND taxable = '0' AND (othincdate = '00' OR othincdate = '$_GET[Month]') ");
		while($otherincdata = mysql_fetch_array($otherinc))
		   {  
		     if($otherincdata['payout']=='10th,25th')
			  {
			 $otherincamt =mysql_query("SELECT othincvalue, othincid, taxable from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amtnontax = mysql_fetch_array($otherincamt); 
			  $halfamt = $amtnontax['othincvalue'] / '2';
              $nontaxableincome = $nontaxableincome + $halfamt;
			  }
			  
             if($otherincdata['payout']==$_GET['Period'])
			  {
			 $otherincamt =mysql_query("SELECT othincvalue, othincid, taxable from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amtnontax = mysql_fetch_array($otherincamt); 
              $nontaxableincome = $nontaxableincome + $amtnontax['othincvalue'];
			  }
		   }//end of nontaxable income loop	

           $netpay = $nettaxable + $nontaxableincome - $salarydeductions;
		$totalsss = $totalsss + $sss;
		$totalhdmf = $totalhdmf + $hdmf;
		$totalphilhealth = $totalphilhealth + $phic;
		$totaltaxpaid = $totaltaxpaid + $totaltax;
		   
////////////////////////////////////Inserting Pay Data////////////////////////////////////

		 
		 }//end of loop employees
}
else {
?>
<form action = "" method = "get">
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
         <input type="submit" name="generate" value="Generate" />
       </p>
</form> 
<?php }?> 
</body>
</html>