<?php
session_start();
if(!isset($_SESSION['Username'])){
header("location:index.php");
}
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
			    $paystart = mktime(0,0,0,date("$_POST[Month]"),date("$paydaystart"),date("Y"));
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

            $paystart = date("Y-m-d", $paystart);
			$payend = date("Y-m-d", $payend);
            $year = date("Y");	
			
		     $periodpay = "".$year."-".$_POST['Month']."-".$payoutday."";			 

echo "Test ".$periodpay;


    $verify = mysqli_query($con,"SELECT * FROM prlpayrollperiod WHERE payperiod = '".$year."-".$_POST['Month']."-".$payoutday."'");
	  $verifypayperiod = mysqli_num_rows($verify);


     if ($verifypayperiod >= '1'){
		echo "Duplicate Pay Period <br>";
		echo "<a href='createpayperiod.php'> Back </a>";
		 
	 }
	 
     else{
	 			
          $sql="INSERT INTO prlpayrollperiod (payrollid, payrolldesc, startdate, enddate, payperiod)
            VALUES
            ('$_POST[payrollid]','$_POST[payrolldescription]','".$paystart."','".$payend."','".$year."-".$_POST['Month']."-".$payoutday."')";	
	  mysql_query($sql);
	  $sqllog="INSERT INTO prlpaylog (Username, ipaddress, payrollid, description)
            VALUES
            ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."','".$year."-".$_POST['Month']."-".$payoutday."', 
	    'Payroll created')";	
	  mysqli_query($con,$sqllog);
	 
	    	
?>        
          <table border = "1" align ="center">
	  <tr><td align = "center" colspan = "5"> Pay Period Created </td></tr>
          <tr><td align = "center"> Payroll ID </td> <td align = "center"> Payroll Description </td> 
          <td align = "center"> Pay Period </td> <td align = "center"> Pay Start Date </td> <td align = "center"> Pay End Date </td></tr>
          <tr><td align = "center"> <?php echo $_POST['payrollid'];?></td><td align = "center"> <?php echo $_POST['payrolldescription'];?></td>
          <td align = "center"> <?php echo $year;?>-<?php echo $_POST['Month'];?>-<?php echo $payoutday;?></td> 
          <td align = "center"> <?php echo $paystart;?></td>
          <td> <?php echo $payend;?></td></tr>
          </table>

          <table border = "1" align ="center">
          <tr><td COLSPAN = "10" align = "center" width = "900"> ACTIVE EMPLOYEES </td></tr>
          <tr><td align = "center"> Employee ID </td> <td align = "center"> RFID </td> <td align = "center"> Name </td> 
          <td align = "center">Cost Center</td><td align = "center"> Position </td><td align = "center"> Complete </td>
          <td align = "center"> Edit/View </td></tr>

<?php
  
		$result =mysqli_query($con,"SELECT * from prlemployeemaster WHERE active != '1'  ORDER BY lastname asc");
		while($row = mysqli_fetch_array($result))
		 {
        
		
 		   /*Setting Default Values*/
		   $ifcomplete = "Yes";
           $payoutamt = $row['periodrate']/'2';
		   $nightamt = '0';
		   $nightsecs = 0;
		   $hourlyrate = $row['hourlyrate'];
		   $holidayhours = '0';
		   $rholidayhours = '0';
		   $sholidayhours = '0';
		   $rholidayamt = '0';
		   $sholidayamt = '0';
		   $totalholidayamt = '0';
		   $regot = '0';
		   $ot6amt = '0';
		   $ot7amt = '0';
		   $totalotamt = '0';
		   $lateamt = '0';
		   $undertimeamt = '0';
		   $totallateundertime = '0';
		   $sss='0';
		   $phic='0';
		   $hdmf='0';
		   $csss='0';
		   $cphic='0';	
		   $taxableincome = '0';
		   $nettaxable = '0';
		   $nontaxableincome = '0';
		   $absent = 0;
		   $netincome = 0;
		   $deductions = 0;
		   $loanamt = 0;
		   $loandeduction = 0;
		   $loancounter = 0;
		   $shiftdate = '';
		   $govloans = 0;
		   $grossmonthprevious = 0;
		   $grossmonth = 0;
		   $taxableotherinc = 0;
		   $proration = 0;
			$workingdays = $_POST['workingdays'];
		  
                   /*For Floating*/
		     if($row['costcenterid']=='FLT')
		      {
			$hourlyrate = 0;
			$payoutamt = 0;			
		      }
		   
		   
		/*Extracting Overtime Rates*/
		 $overtime =mysqli_query($con,"SELECT overtimerate, overtimeid from prlovertimetable");
		 while($overtimerate = mysqli_fetch_array($overtime))
		   {
		     $ctr = $overtimerate['overtimeid'];
			 $multiplier[$ctr] = $overtimerate['overtimerate'];
		   }			   
		   
		   /*Total Hours*/
		 $resultlog = mysqli_query($con,"SELECT * from finalhourstable WHERE shiftdate >= '$paystart' AND shiftdate <= '$payend' AND userid = '".$row['employeeid']."' AND (status = 'Present' || status = '6th day OT' || status = '7th day OT')");
		 while($rowlog = mysqli_fetch_array($resultlog))
		   {  
		   
		       /*Night amount*/
			   if($row['nigthrate'] == '0.00'){
				$nightamt = 0;
			   }else{
			      $nightamt = $nightamt + ($hourlyrate * ($row['nightrate'] - 1) * ($rowlog['nightdiff_hours'] + $rowlog['nightdiff_ot_hours']));
			   }
			   /*Late Amount*/
			   $lateamt = $lateamt + ($hourlyrate * ($rowlog['late'] + $rowlog['undertime']));
			   /*OT*/			   
			   if($rowlog['status'] == '6th day OT')
			   {$ot6amt = $ot6amt + ($hourlyrate * $multiplier[20] * ($rowlog['regular_ot_hours'] + $rowlog['nightdiff_ot_hours']));}
			   else if($rowlog['status'] == '7th day OT')
			   {$ot7amt = $ot7amt + ($hourlyrate * $multiplier[25] * ($rowlog['regular_ot_hours'] + $rowlog['nightdiff_ot_hours']));}
			   else
			   {$regot = $regot + ($hourlyrate * $multiplier[10] * ($rowlog['regular_ot_hours'] + $rowlog['early'] + $rowlog['nightdiff_ot_hours']));}
			   
			   /*holiday check*/
			     $holidayhours = 0;
			   	 $holidaycheck=mysqli_query($con,"SELECT * from prlholidaytable WHERE holidaydate = '".$rowlog['shiftdate']."'");
			     $check=mysqli_num_rows($holidaycheck);
				 
			     if($check=='1')
			       {
					   $holidayhours = $rowlog['regular_hours'] + $rowlog['nightdiff_hours'] + $rowlog['early'] + $rowlog['regular_ot_hours'] + $rowlog['nightdiff_ot_hours'] + $rowlog['sixth_ot_hours'] + $rowlog['seventh_ot_hours'];
					   
					   if($holidayhours >= 9)
					   {
						   $holidayhours = $holidayhours - 1;
					   }
					   
					   $checktype=mysqli_fetch_array($holidaycheck);
					   
					   if($checktype['holidaytype'] == 'Regular Holiday')
					   {
						   $rholidayamt = $rholidayamt + ($hourlyrate * $holidayhours * ($multiplier[30] - 1));
					   }
					   else if($checktype['holidaytype'] == 'Special Holiday')
					   {
						   $sholidayamt = $sholidayamt + ($hourlyrate * $holidayhours * ($multiplier[35] - 1));
					   }					   					   
				   }
				   $totalholidayamt = $rholidayamt + $sholidayamt;
				   
			   
		   }
		   
			   /*Not Present*/
			   $absentlog = mysqli_query($con,"SELECT * FROM finalhourstable WHERE shiftdate >= '$paystart' AND shiftdate <= '$payend' AND userid = '".$row['employeeid']."' AND (status = 'Absent' OR status = 'USUP' OR status = 'LMAT' OR status = 'LOAM' OR status = 'BVUNP' OR status = 'LOAU' OR status = 'NCNS' OR status = 'SKUNP') GROUP BY shiftdate");
               $absentcount = mysqli_num_rows($absentlog);
			   $absent = $absent + $hourlyrate * $absentcount * 8;
			   $proration = $absentcount/$workingdays;
			   $proration = 1.0 - $proration;
			   
			   /*Logs Count*/
			   $absentlogpud = mysqli_query($con,"SELECT * FROM finalhourstable WHERE shiftdate >= '$paystart' AND shiftdate <= '$payend' AND userid = '".$row['employeeid']."'");
               $count = mysqli_num_rows($absentlogpud);	
			   if($count < 10)
			   {
				   $ifcomplete = "No";
			   }

			
			/*for exempt = 0 no nyt dif and overtime*/
           if($row['nightrate'] == '0.00')
		   {
			   $nightamt = 0;
			   
		   }
		    if($row['holidaypay'] == '0')
		   {
			   $totalholidayamt = 0;
		   }
		   if($row['overtimepay'] == '0')
		   {
			   $regot = 0;
			   $ot6amt = 0;
			   $ot7amt = 0;
		   }
		   
            /*Taxable Income*/
   		$otherinc =mysqli_query($con,"SELECT * from prlotherincassign WHERE employeeid = '".$row['employeeid']."' AND taxable = '1' AND (othincdate = '00' || othincdate = '$payoutday') ");
		while($otherincdata = mysqli_fetch_array($otherinc))
		   {  
		     if($otherincdata['payout']=='10th,25th')
			  {
			 $otherincamt =mysqli_query($con,"SELECT * from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amttax = mysqli_fetch_array($otherincamt); 
			  $halfamt = $amttax['othincvalue'] / '2';
              $taxableotherinc = $taxableotherinc + $halfamt*$proration;
			  mysqli_query($con,"Insert into prlotherinclog (employeeid, payperiod, description, amount) 
			  VALUES ('".$row['employeeid']."', '$periodpay', '".$amttax['othincdesc']."', '".$halfamt."')");
			  }

             if($otherincdata['payout']== $_POST['Period'])
			  {
			 $otherincamt =mysqli_query($con,"SELECT * from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amttax = mysqli_fetch_array($otherincamt);
              $taxableotherinc = $taxableotherinc + $amttax['othincvalue']*$proration;
			  mysqli_query($con,"Insert into prlotherinclog (employeeid, payperiod, description, amount) 
			  VALUES ('".$row['employeeid']."', '$periodpay', '".$amttax['othincdesc']."', '".$amttax['othincvalue']."')");
			  }
		   }		   
	/*NonTaxable Income*/
   		$otherinc =mysqli_query($con,"SELECT * from prlotherincassign WHERE employeeid = '".$row['employeeid']."' AND taxable = '0' AND (othincdate = '00' || othincdate = '$payoutday') ");
		while($otherincdata = mysqli_fetch_array($otherinc))
		   {  
		     if($otherincdata['payout']=='10th,25th')
			  {
			 $otherincamt =mysqli_query($con,"SELECT * from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amtnontax = mysqli_fetch_array($otherincamt); 
			  $halfamt = ($amtnontax['othincvalue'] / '2') * $proration;
              $nontaxableincome = $nontaxableincome + $halfamt;
			  mysqli_query($con,"Insert into prlotherinclog (employeeid, payperiod, description, amount) 
			  VALUES ('".$row['employeeid']."', '$periodpay', '".$amtnontax['othincdesc']."', '".$halfamt."')");
			  }

             if($otherincdata['payout']== $_POST['Period'])
			  {
			 $otherincamt =mysqli_query($con,"SELECT * from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amtnontax = mysqli_fetch_array($otherincamt);
              $nontaxableincome = $nontaxableincome + $amtnontax['othincvalue'];
			  mysqli_query($con,"Insert into prlotherinclog (employeeid, payperiod, description, amount) 
			  VALUES ('".$row['employeeid']."', '$periodpay', '".$amtnontax['othincdesc']."', '".$amtnontax['othincvalue']."')");
			  }
		   }	   
		   
		   
		   		   		   	 	 
	 
         /*Government Deductions*/
			if($row['costcenterid'] != 'FLT') /*Use if once a month deduction $payoutday=='10' && */ 
		   {
				$monthsummary = mysqli_query($con,"SELECT * from prlpaysummary WHERE employeeid = '".$rowgetemplyees['employeeid']."' AND payperiod < '".$_GET['payperiod']."' ORDER BY payperiod DESC limit 1"); /*Getting last pay for gross month, good for 10th payperiod only*/
               $rowmonthsummary=mysqli_fetch_array($monthsummary);
				$grossmonthprevious = $rowmonthsummary['basicpay'] + $rowmonthsummary['holidaypay'] + $rowmonthsummary['regot'] + $rowmonthsummary['6thdayot'] + $rowmonthsummary['7thdayot'] + $rowmonthsummary['totalnd'] + $rowmonthsummary['taxableotherinc'] + $rowmonthsummary['nontaxable'] - $rowmonthsummary['deductions'];
				
				//$grossmonth = $grossmonthprevious + $nontaxableincome + $taxableotherinc + $totalholidayamt + $payoutamt + $regot + $ot6amt + $ot7amt + $nightamt - ($lateamt + $absent);
				  /* Basis Gross pay for the month */
				
				$grossmonth = $row['periodrate']; /* Basis Basic pay only */
				
				
			$deduct =mysqli_query($con,"SELECT * from prlsstable WHERE rangefrom <= '$grossmonth' AND rangeto >= '$grossmonth'");
			$value = mysqli_fetch_array($deduct);
			$sss = $value['employeess']/2;
			$csss = ($value['employerss'] + $value['employerec'])/2;
 
		$deduct =mysqli_query($con,"SELECT * from prlphilhealth WHERE rangefrom <= '$grossmonth' AND rangeto >= '$grossmonth'");
			$value = mysqli_fetch_array($deduct);
			//$phic = $value['employeeph']/2;
			if($row['periodrate'] <= 10000){
				$cphic = $phic = (275 /2) / 2;
			}else if($row['periodrate'] > 40000){
				$cphic = $phic = (1100) / 2 / 2;
			}else{
				$cphic = $phic = (( $row['periodrate'] * 0.0275 ) /2 ) /2;
			}
			//$cphic = $value['employerph']/2;
			if($row['employeeid'] == '0900003')
			{
				$hdmf = '500';
			}
			 else
			 {
			    $hdmf = '50';
			 }
		    }		 

                   $totallateundertime = $lateamt + $absent;
		   $nettaxable = $nettaxable + $payoutamt + $taxableotherinc + $nightamt + $regot + $ot6amt + $ot7amt + $totalholidayamt - $totallateundertime - $sss - $phic - $hdmf;
		   
		   
		/*Tax Calculation*/
		if($nettaxable > '10000')
			{
				$totaltax = ($nettaxable - 10000)*0.25;
			}
			 else
			 {
			    $totaltax = '0';
			 }
		/*  OLD TAX Calculation
		$gettax = mysql_query("SELECT * FROM prltaxtablerate WHERE taxstatusid = '$row[taxstatusid]' AND rangefrom <= $nettaxable AND rangeto >= $nettaxable");
		$witholdingtax = mysql_fetch_array($gettax);
		$percentover = ($nettaxable - $witholdingtax['rangefrom'])*(($witholdingtax['percentofexcessamount'])/'100');
		$totaltax =  $witholdingtax['fixtax'] + $percentover;		*/   
		   
		   
            
		   
		   
      /*Loan Deductions*/
   		$loan =mysqli_query($con,"SELECT * from prlloans WHERE employeeid = '".$row['employeeid']."' AND counter > '0' AND payrelease < '$periodpay'");
		while($loandata = mysqli_fetch_array($loan))
		   { 
			  $loandeduction = $loandata['balance']/$loandata['counter'];
			  $loanbalance = $loandata['balance'] - $loandeduction;
			  $loanctr = $loandata['counter'] - 1;
			  $loanamt = $loanamt + $loandeduction;
			  
			  
			  $loanupdate="INSERT INTO prlloanstemp (loanctr, balance, loandeduction, empid, payrollid, loanid)
                          VALUES
                            ('$loanctr','$loanbalance','$loandeduction','".$row['employeeid']."','$periodpay', '".$loandata['ctr']."')";
	                  mysqli_query($con,$loanupdate);
			  			   
		   }	
		   
		   /*SSS & HDMF Loans & HMO Payments UNTESTED*/
		   $loan =mysqli_query($con,"SELECT * from prlloansgov WHERE empid = '".$row['employeeid']."' AND (deductiondate = '".$paydate."' || deductiondate = '1025')");
		while($loandata = mysqli_fetch_array($loan))
		   { 
			
			 $loanamount = 0;
			 if ($loandata['deductiondate']=='1025')
				   $loanamount = $loanamount + $loandata['loanamt']/2;
			 else
			       $loanamount = $loanamount + $loandata['loanamt'];
			  
			 $govloans = $govloans + $loanamount;

	                $loanlog="INSERT INTO prlloansgovlog (user, ipaddress, description, payperiod,employeeid,loantype,loanid)
                          VALUES('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."', '".$loanamount."','".$periodpay."', '".$row['employeeid']."','".$loandata['loantype']."','".$loandata['loanid']."')";	
	                mysqli_query($con,$loanlog);	 
		   }	 

		   
		   $loanamt = $loanamt + $govloans;
		   
		   $netincome = $nettaxable + $nontaxableincome - $totaltax;
		   $netincome = $netincome - $loanamt;		   

		   		   
?>		   
           <tr>	 
	       <td align = "center"> <?php echo $row['employeeid']; ?> </td><td align = "center"> <?php echo $row['RFID']; ?> </td>
           <td> <?php echo $row['lastname']; ?>, <?php echo $row['firstname']; ?> </td>
                      <td align = "center"> <?php echo $row['costcenterid']; ?> </td>
           <td align = "center"> <?php echo $row['position']; ?> </td>
           <td align = "center"> <?php echo $ifcomplete; ?> </td> <td align = "center"><a href="editpayslip.php?employee=<?php echo$row['employeeid']; ?>&todo=10&payperiod=<?php echo $periodpay;?>" alt="Edit"  name="Edit"> Edit </a></td>
           </tr>
<?php		 

     $sqlinsert="INSERT INTO prlpaysummary (payperiod, employeeid, costcenter, taxableincome, basicpay, holidaypay, regot, 6thdayot, 7thdayot, totalnd, nontaxable, taxableotherinc, deductions, loandeductions, sss, phic, hdmf, csss, cphic, tax, netpay, complete)
     VALUES
     ('".$periodpay."','".$row['employeeid']."','".$row['costcenterid']."','".$nettaxable."','".$payoutamt."','".$totalholidayamt."','".$regot."','".$ot6amt."','".$ot7amt."','".$nightamt."','".$nontaxableincome."','".$taxableotherinc."','".$totallateundertime."','".$loanamt."','".$sss."','".$phic."','".$hdmf."','".$csss."','".$cphic."','".$totaltax."','".$netincome."','".$ifcomplete."')";	
	 mysqli_query($con,$sqlinsert);

		 }
	 }


?>
</table>
         <form action = "deletepayroll.php" method = "post" >
           <input type = "hidden" name ="period" value = "<?php  echo $periodpay;?>"/>
         <input type = "hidden" name ="todo" value = "25"/>
         <input type="submit" name="generate" value="Delete This Pay Period" onclick = "return(confirm('Confirm Delete'))"/>
         <br />
         <br />
         </form> 
         
         <form action = "deletepayroll.php" method = "post" >
         <input type = "hidden" name ="period" value = "<?php  echo $periodpay;?>"/>
         <input type = "hidden" name ="todo" value = "35"/>
         <input type="submit" name="generate" value="Close This Pay Period" onclick = "return(confirm('Confirm Close'))"/>
         </form>     

</body>
</html>
