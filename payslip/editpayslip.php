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
<title>Edit/View</title>
</head>

<body>
<?php

if($_POST['todo']=='15')
{
	$updaterate = $_POST['basicpay']*'12'/'261'/'8';
	$sql = "UPDATE prlemployeemaster SET periodrate = '".$_POST['basicpay']."', hourlyrate = $updaterate, 
	taxstatusid = '".$_POST['taxstatus']."', employmenttype = '".$_POST['employmenttype']."',
	active = '".$_POST['active']."', costcenterid = '".$_POST['costcenter']."' WHERE employeeid = '".$_POST['employeeid']."'";
	mysqli_query($con,$sql);

 	 $sqllog="INSERT INTO prlpaylog (Username, ipaddress, payrollid, description)
     VALUES
     ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."','".$_POST['payperiod']."', 
	 '".$_POST['employeeid']." Updated/Changed Info')";	
	 mysqli_query($con,$sqllog);	
	
	if($_POST['active'] == '1')
	{
		mysqli_query($con,"DELETE FROM prlpaysummary WHERE employeeid = '".$_POST['employeeid']."'");
		
 	 $sqllog="INSERT INTO prlpaylog (Username, ipaddress, payrollid, description)
     VALUES
     ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."','".$_POST['payperiod']."', 
	 '".$_POST['employeeid']." Removed From Payroll')";	
	 mysqli_query($con,$sqllog);		
	}
	
	
	if($_POST['amount'] != "")
	{			
		$adjustment = "INSERT into prladjustmentlog(employeeid, payrollid, category, description, amount, taxable, user, ipaddress)
		VALUE('".$_POST['employeeid']."','".$_POST['payperiod']."','".$_POST['category']."','".$_POST['description']."',
		'".$_POST['amount']."','".$_POST['taxable']."','".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."')";		
		mysqli_query($con,$adjustment);
	}
	
}

	$getemplyees="select * from prlemployeemaster where employeeid='".$_GET['employee']."'";
	$getemplyees=mysqli_query($con,$getemplyees);
	$rowgetemplyees=mysqli_fetch_array($getemplyees)

?>
<form action = "" method="post"/>
<table align="center" width="700" border="2">
<tr>
  <td colspan = "4" align="center"> <?php echo $rowgetemplyees['lastname']; ?>,  <?php echo $rowgetemplyees['firstname']; ?> 
<?php echo $rowgetemplyees['middlename']; ?> (<?php echo $rowgetemplyees['position']; ?>)</td>
</tr>
<tr><td width="118" align="center"> Employee Number </td><td align="center"><?php echo $rowgetemplyees['employeeid']; ?></td>
<td align="center"> Employment Status </td>
<td align="center"><select name="active">
    	  <option value="0" <? if($rowgetemplyees['active']=='0'){ echo 'selected="selected"';} ?>>Active</option>
    	  <option value="1" <? if($rowgetemplyees['active']=='1'){ echo 'selected="selected"';} ?>>Inactive</option>
  	  </select>
</td>
</tr>
<tr><td width="118" align="center"> RFID </td><td width="121" align="center"> <?php echo $rowgetemplyees['RFID']; ?></td>
<td width="121" align="center"> Tax Status </td> <td width="120" align="center">
    	<select name="taxstatus">
<?php        $result = mysqli_query($con,"SELECT taxstatusid, taxstatusdescription from prltaxstatus");
             while($rowgetstatus=mysqli_fetch_array($result))
			 {
?>        
        	<option value="<?php echo $rowgetstatus['taxstatusid'];?>"  <? if($rowgetemplyees['taxstatusid']==$rowgetstatus['taxstatusid']){ echo 'selected="selected"';} ?>><?php echo $rowgetstatus['taxstatusdescription'];?></option>

<?php         
              }
?>	            
      </select>
</td></tr>
<tr>
<td width="118" align="center"> Employment Type </td><td width="121" align="center"> 
      <select name="employmenttype">
    	  <option value="0" <? if($rowgetemplyees['employmenttype']=='0'){ echo 'selected="selected"';} ?>>Exempt</option>
    	  <option value="1" <? if($rowgetemplyees['employmenttype']=='1'){ echo 'selected="selected"';} ?>>Non Exempt</option>
  	  </select></td>
<td align="center"> Schedule </td>  
<td align="center"><?php echo $rowgetemplyees['schedule']; ?></td>
</tr>
<tr><td width="118" align="center"> Basic Pay </td>
<td width="121" align="center"><input type="text" name="basicpay" value="<?php echo $rowgetemplyees['periodrate']; ?>"/></td>
<td width="121" align="center"> Hourly Rate </td> 
<td width="120" align="center"><?php echo $rowgetemplyees['hourlyrate']; ?></td></tr>
<tr>
<td width="118" align="center"> Cost Center </td>
<td width="121" align="center"> 
    	<select name="costcenter">
            <option value="MGT" <? if($rowgetemplyees['costcenterid']=='MGT'){ echo 'selected="selected"';} ?>>Management</option>
            <option value="SPV" <? if($rowgetemplyees['costcenterid']=='SPV'){ echo 'selected="selected"';} ?>>Supervisor</option>
            <option value="IT" <? if($rowgetemplyees['costcenterid']=='IT'){ echo 'selected="selected"';} ?>>Information Technology</option>
            <option value="FCL" <? if($rowgetemplyees['costcenterid']=='FCL'){ echo 'selected="selected"';} ?>>Facilities</option>
            <option value="MAR" <? if($rowgetemplyees['costcenterid']=='MAR'){ echo 'selected="selected"';} ?>>Marketing</option>
            <option value="QA" <? if($rowgetemplyees['costcenterid']=='QA'){ echo 'selected="selected"';} ?>>Quality Control</option>
            <option value="AGT" <? if($rowgetemplyees['costcenterid']=='AGT'){ echo 'selected="selected"';} ?>>Agent</option>
            <option value="WFM" <? if($rowgetemplyees['costcenterid']=='WFM'){ echo 'selected="selected"';} ?>>Work Force Management</option>
            <option value="HC" <? if($rowgetemplyees['costcenterid']=='HC'){ echo 'selected="selected"';} ?>>Human Capital</option>
            <option value="REC" <? if($rowgetemplyees['costcenterid']=='REC'){ echo 'selected="selected"';} ?>>Recruiting</option>
            <option value="TRNG" <? if($rowgetemplyees['costcenterid']=='TRNG'){ echo 'selected="selected"';} ?>>Training</option>
            <option value="FNA" <? if($rowgetemplyees['costcenterid']=='FNA'){ echo 'selected="selected"';} ?>>Finance/Accounting</option>      
            <option value="FLT" <? if($rowgetemplyees['costcenterid']=='FLT'){ echo 'selected="selected"';} ?>>Floating</option>      
        </select> </td>
<td width="118" align="center"> Complete </td>
<td width="121" align="center"> 
<?php
$resultsummary = mysqli_query($con,"SELECT * from prlpaysummary WHERE employeeid = '".$rowgetemplyees['employeeid']."' AND payperiod = '".$_GET['payperiod']."'");
$rowgetsummary=mysqli_fetch_array($resultsummary);
?>
<select name="ifcomplete">
    	  <option value="No" <? if($rowgetsummary['complete']=='No'){ echo 'selected="selected"';} ?>>NO</option>
    	  <option value="Yes" <? if($rowgetsummary['complete']=='Yes'){ echo 'selected="selected"';} ?>>YES</option>
  </select></td></tr>

</table>
<?php
 $pay=mysqli_query($con,"SELECT * FROM prlpayrollperiod WHERE payperiod = '".$_GET['payperiod']."'");
 $rowpay=mysqli_fetch_array($pay);

?>
<br />
<br />
<table border = "1" align ="center">
  <tr>
  <td align = "center" colspan = "5"> Pay Period</td></tr>
<tr><td align = "center"> Payroll ID </td> <td align = "center"> Payroll Description </td> 
<td align = "center"> Pay Period </td> <td align = "center"> Pay Start Date </td> <td align = "center"> Pay End Date </td></tr>
<tr><td align = "center"> <? echo $rowpay['payrollid'];?></td><td align = "center"> <? echo $rowpay['payrolldesc'];?></td>
<td align = "center"> <? echo $rowpay['payperiod'];?></td>
<td align = "center"> <? echo $rowpay['startdate'];?></td>
<td align="center"> <? echo $rowpay['enddate'];?></td></tr>
</table>
<p>&nbsp;</p>
<?php
         /*Setting Default Values*/
		 $ifcomplete = "Yes";
        $payoutamt = $rowgetemplyees['periodrate']/'2';
		$nightamt = '0';
		$nightsecs = 0;
		$hourlyrate = $rowgetemplyees['hourlyrate'];
		$holidayhours = '0';
		$rholidayhours = '0';
		$sholidayhours = '0';
		$rholidayamt = '0';
		$sholidayamt = '0';
		$totalholidayamt = '0';
		$regot = '0';
		$regothours = '0';
		$ot6amt = '0';
		$ot6hours = '0';
		$ot7amt = '0';
		$ot7hours = '0';
		$totalotamt = '0';
		$lateamt = '0';
		$undertimeamt = '0';
		$totallateundertime = '0';
		$payday = explode("-",$_GET['payperiod']);
		$paydate = $payday[2];
		$paydateth = $payday[2]."th";
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
		$govloancounter = 0;
		/*For Floating*/
		if($rowgetemplyees['costcenterid']=='FLT')
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

?>
<table border = "1" align ="center" width="850"><font size="2">
  <tr>
  <td align = "center" colspan = "9"> Logs </td></tr>
<tr><td align = "center"> Status </td><td align = "center"> Shift Date </td><td align = "center"> Date Log </td>
<td align = "center"> Total Regular hours </td>
<td align = "center"> Total 6th Day </td>
<td align = "center"> Total 7th Day </td>
<td align = "center"> Total OT </td>
<td align = "center"> Total ND </td><td align = "center"> Late/Undertime </td>
<td align = "center"> Special Rate</td></tr>

<?php

		/*LOGS*/

	 $payoutday = $paydate;
	 
		     if($payoutday == '25')
			   {
			    $paydaystart = 01;
				$paydayend = 15;
				$payoutmonth = $payday[1];
			    $paystart = mktime(0,0,0,date("$payoutmonth"),date("$paydaystart"),date("$payday[0]"));
				$payend = mktime(0,0,0,date("$payday[1]"),date("$paydayend"),date("$payday[0]"));
			   }
			  else
			   {
			    $paydaystart = 16;
				$paydayend = 00;
				$payoutmonth = $payday[1] - '1';
			    $paystart = mktime(0,0,0,date("$payoutmonth"),date("$paydaystart"),date("$payday[0]"));
				$payend = mktime(0,0,0,date("$payday[1]"),date("$paydayend"),date("$payday[0]"));
			   }	
			   
			$paystart = date("Y-m-d", $paystart);
			$payend = date("Y-m-d", $payend);
					   

$resultlog = mysqli_query($con,"SELECT * from finalhourstable WHERE shiftdate >= '$paystart' AND shiftdate <= '$payend' AND userid = '".$rowgetemplyees['employeeid']."' ORDER BY shiftdate asc");
		while($rowlog = mysqli_fetch_array($resultlog))
		   {  
		      if($rowlog['status'] == 'Present' || $rowlog['status'] == '6th day OT' || $rowlog['status'] == '7th day OT')
			  {
				  $othours = 0;
				  $othours = $rowlog['regular_ot_hours'] + $rowlog['early'];
		       echo "<tr>";
			   echo "<td align = 'center'>".$rowlog['status']."</td>";
			   echo "<td align = 'center'>".$rowlog['shiftdate']."</td>";
			   echo "<td align = 'center'>".$rowlog['dates']."</td>";
			   echo "<td align = 'center'>".$rowlog['regular_hours']."</td>";
			   echo "<td align = 'center'>".$rowlog['sixth_ot_hours']."</td>";
			   echo "<td align = 'center'>".$rowlog['seventh_ot_hours']."</td>";
			   echo "<td align = 'center'>".$othours."</td>";
			   $temp = 0;
			   $temp = $rowlog['nightdiff_hours'] + $rowlog['nightdiff_ot_hours'];
		       /*Night amount*/
			   $nightsecs = $nightsecs + $rowlog['nightdiff_hours'] + $rowlog['nightdiff_ot_hours'];
			   $nightamt = $nightamt + ($hourlyrate * ($rowgetemplyees['nightrate'] - 1) * ($rowlog['nightdiff_hours'] + $rowlog['nightdiff_ot_hours']));
			   echo "<td align = 'center'>".$temp."</td>";
			   
			   /*Late Amount*/
			   $totallateundertime = $totallateundertime + $rowlog['late'] + $rowlog['undertime'];
			   $lateamt = $lateamt + ($hourlyrate * ($rowlog['late'] + $rowlog['undertime']));
			   $temp = 0;
			   $temp = $rowlog['late'] + $rowlog['undertime'];
			   echo "<td align = 'center'>".$temp."</td>";
			   
			   /*OT*/
			   if($rowlog['status'] == '6th day OT')
			   {$ot6amt = $ot6amt + ($hourlyrate * $multiplier[20] * ($rowlog['regular_ot_hours'] + $rowlog['nightdiff_ot_hours']));
			     $ot6hours = $ot6hours + $rowlog['regular_ot_hours'] + $rowlog['nightdiff_ot_hours'];}
			   else if($rowlog['status'] == '7th day OT')
			   {$ot7amt = $ot7amt + ($hourlyrate * $multiplier[25] * ($rowlog['regular_ot_hours'] + $rowlog['nightdiff_ot_hours']));
			    $ot7hours = $ot7hours + $rowlog['regular_ot_hours'] + $rowlog['nightdiff_ot_hours'];}
			   else
			   {$regot = $regot + ($hourlyrate * $multiplier[10] * ($rowlog['regular_ot_hours'] + $rowlog['early']));
			   $regothours = $regothours + $rowlog['regular_ot_hours'] + $rowlog['early'] + $rowlog['nightdiff_ot_hours'] ;}
			  
			   
			   
			   /*holiday check*/
			     $holidayhours = 0;
			   	 $holidaycheck=mysqli_query($con,"SELECT * from prlholidaytable WHERE holidaydate = '".$rowlog['shiftdate']."'");
			     $check=mysqli_num_rows($holidaycheck);
				 
			     if($check=='1')
			       {
					   $holidayhours = $rowlog['regular_hours'] + $rowlog['nightdiff_hours'] + $rowlog['regular_ot_hours'] + $rowlog['nightdiff_ot_hours'] + $rowlog['sixth_ot_hours'] + $rowlog['seventh_ot_hours'];
					   $checktype=mysqli_fetch_array($holidaycheck);
					   
					  if($holidayhours >= 9)
					   {
						   $holidayhours = $holidayhours - 1;
					   }
					   
					   
					   if($checktype['holidaytype'] == 'Regular Holiday')
					   {
						   $rholidayamt = $rholidayamt + ($hourlyrate * $holidayhours * ($multiplier[30] - 1));
						   $rholidayhours = $rholidayhours + $holidayhours;
						   
					   }
					   else if($checktype['holidaytype'] == 'Special Holiday')
					   {
						   $sholidayamt = $sholidayamt + ($hourlyrate * $holidayhours * ($multiplier[35] - 1));
						   $sholidayhours = $sholidayhours + $holidayhours;
					   }	
					   
					   echo "<td>".$checktype['holidaytype']."(".$holidayhours." hrs)</td>";
				   }
				   $totalholidayamt = $rholidayamt + $sholidayamt;
				   
				 echo "</tr>";  
				 
			  }
			  
			  else if ($rowlog['status'] == 'Absent')
			  {
				  echo "<tr>";
				  echo "<td colspan = '9' bgcolor='#FF0000' align = 'center'>";
				  echo $rowlog['status'];
				  echo "</td>";
				  echo "</tr>";
			  }
			  else
			  {
				  echo "<tr>";
				  echo "<td colspan = '9' bgcolor='#FFCC66' align = 'center'>";
				  echo $rowlog['status'];
				  echo "</td>";
				  echo "</tr>";
			  }			  
			   
		   }
		   
			   /*Logs Count*/
			   $log = mysqli_query($con,"SELECT * FROM finalhourstable WHERE shiftdate >= '$paystart' AND shiftdate <= '$payend' AND userid = '".$rowgetemplyees['employeeid']."'");
               $count = mysqli_num_rows($log);	
			   if($count < 10)
			   {
				   $ifcomplete = "No";
				   echo "NO LOGS"; echo "<br>"; echo "<br>";
			   }	
			   
			   /*Not Present*/
			   $absentlog = mysqli_query($con,"SELECT * FROM finalhourstable WHERE shiftdate >= '$paystart' AND shiftdate <= '$payend' AND userid = '".$rowgetemplyees['employeeid']."' AND (status = 'Absent' OR status = 'USUP') GROUP BY shiftdate");
               $absent = mysqli_num_rows($absentlog);
			   		   



?>


</font>
<tr><td colspan = "3">&nbsp;</td>
<td align="center">TOTAL</td>
<td align="center"><?php echo $ot6hours;?></td>
<td align="center"><?php echo $ot7hours;?></td>
<td align="center"><?php echo $regothours;?></td>
<td align="center"><?php echo $nightsecs; ?></td>
<td align="center"><?php echo $totallateundertime; ?></td></tr>
</table>
Absences = 1Day = 8hours <br />
Absences Deductions = #ofworkingdays * 8 * hourlyrate(<?php echo $hourlyrate;?>)<br />
Absences Deductions = <?php echo $absent;?> * 8 * <?php echo $hourlyrate;?><br />
Absences Deductions = <?php $absent = $absent*8*$hourlyrate; echo $absent;?><br />
Late/Undertime Deductions = totalhours * hourlyrate(<?php echo $hourlyrate;?>)<br />
Late/Undertime Deductions = <?php echo $totallateundertime;?> 
* hourlyrate(<?php echo $hourlyrate;?>)<br />
Late/Undertime Deductions = <?php echo $lateamt;?><br /><br />

Regular Overtime = totalhours * hourlyrate(<?php echo $hourlyrate;?>) * 1.35<br />
Regular Overtime = <?php echo $regothours;?> * hourlyrate(<?php echo $hourlyrate;?>) * 1.35<br />
Regular Overtime = <?php echo $regot;?><br /><br />

Total ND Amt = totalhours * hourlyrate(<?php echo $hourlyrate;?>) * ND Rate <br />
Total ND Amt = <?php echo $nightsecs;?> * hourlyrate(<?php echo $hourlyrate;?>) * 0.3<br />
Total ND Amt = <?php echo $nightamt;?><br /><br />

6th day OT = totalhours * hourlyrate(<?php echo $hourlyrate;?>) * 6thDayRate <br />
6th day OT = <?php echo $ot6hours;?> * hourlyrate(<?php echo $hourlyrate;?>) * 1.4<br />
6th day OT = <?php echo $ot6amt;?><br /><br />

7th day OT = totalhours * hourlyrate(<?php echo $hourlyrate;?>) * 7thDayRate <br />
7th day OT = <?php echo $ot7hours;?> * hourlyrate(<?php echo $hourlyrate;?>) * 1.7<br />
7th day OT = <?php echo $ot7amt;?><br /><br />

Regular Holiday Pay = totalhours * hourlyrate(<?php echo $hourlyrate;?>) * Regular Holiday Rate(1) <br />
Regular Holiday Pay = <?php echo $rholidayhours;?> * hourlyrate(<?php echo $hourlyrate;?>) * 1 <br />
Regular Holiday Pay = <?php echo $rholidayamt;?><br /><br />

Special Holiday Pay = totalhours * hourlyrate(<?php echo $hourlyrate;?>) * Special Holiday Rate(0.5) <br />
Special Holiday Pay = <?php echo $sholidayhours;?> * hourlyrate(<?php echo $hourlyrate;?>) * 0.5 <br />
Special Holiday Pay = <?php echo $sholidayamt;?><br /><br />
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>
<?php
					   
		   /*Summary Amount*/
           if($rowgetemplyees['employmenttype'] == '0')//for exempt = 0 no nyt dif and overtime
		   {
		      $nightamt = 0;
			  $totalholidayamt= 0;
			  $regot = 0;
?>
Exempt employees : No ND , No Regular OT <br />
ND = 0 <br />
OT(Reg OT) = 0 </p>
<p>&nbsp;</p>
<?php			  
		   }		   
		   $totalotamt = $totalotamt + $regot + $ot6amt + $ot7amt;
		   $lateamt = $lateamt + $absent;
		   
?>		   
<table border = "1" align ="center" width="650">
  <tr>
    <td colspan="4" align="center">
Manual Adjustment</td></tr>
<tr>
<td width="71" align="center">
Category </td><td width="173" align="center"><select name="category">
    	  <option value="Allowance Correction">Allowance Correction</option>
    	  <option value="Leave Correction">Leave Correction</option>
    <option value="Pay Correction">Pay Correction</option>
    <option value="Tax Correction">Tax Correction</option>
    <option value="Overtime Correction">Overtime Correction</option>
    <option value="ND Correction">ND Correction</option>
    <option value="Others">Others</option>
</select></td>
<td width="138" align="center">Description</td>
<td width="240" align="center"><input type="text" name="description" size="40"/></td>
</tr>
<tr>
<td align="center">Amount </td>
<td align="center"><input type="text" name="amount" size="15"/></td>
<td align="center">Taxable </td>
<td align="center"><select name="taxable">
  <option value="1">Taxable</option>
  <option value="0">Non Taxable</option></select> 
</td></tr>
<tr>
<td colspan="4">&nbsp;</td>
</tr>
<?php
      /*Manual Adjustment*/
     $resultadjustment = mysqli_query($con,"SELECT * from prladjustmentlog WHERE employeeid = '".$_GET['employee']."' AND payrollid = '".$_GET['payperiod']."'");
	 while($resultadjustdata = mysqli_fetch_array($resultadjustment))
	 {
		echo "<tr><td align = 'center'>";
		echo "Category</td><td align = 'center'>".$resultadjustdata['category']."</td><td align = 'center'> Description </td>";
		echo "<td align = 'center'>".$resultadjustdata['description']."</td></tr>";
		echo "<tr><td align = 'center'>";
		echo "Amount</td><td align = 'center'>".$resultadjustdata['amount'];
		
		if($resultadjustdata['taxable'] == '1')
		{
			$nettaxable = $nettaxable + $resultadjustdata['amount'];
			echo "</td><td align = 'center'> Taxable </td>";
		}
		else
		{
			$nontaxableincome = $nontaxableincome + $resultadjustdata['amount'];
			echo "</td><td align = 'center'> Non Taxable </td>";
		}
		
		if($resultadjustdata['amount'] < 0)
		{
			$deductions = $deductions - $resultadjustdata['amount'];
		}
		
		echo "<td align = 'center'>Added By: "; echo $resultadjustdata['user']."</td></tr>";		
		echo "</td></tr>"; 
		echo "</td></tr><tr><td colspan='4'>&nbsp;</td></tr>";
	 }

?>

</table>

<p>&nbsp;</p>
<table border = "1" align ="center" width="450">
  <tr>
  <td align = "center" colspan = "3">Taxable Income</td></tr>
<tr><td width="250" align = "center"> Definition </td> <td width="78" align = "center"> Debit </td> 
<td width="100" align = "center"> Credit </td></tr>
<tr><td align = "center"> Period Income </td><td align = "center"> <? echo $payoutamt;?></td>
<td align = "center">&nbsp;</td>
</tr>
<tr><td align = "center"> Night Differential </td><td align = "center"> <? echo $nightamt;?></td>
<td align = "center">&nbsp;</td>
</tr>
<tr>
  <td align = "center"> Holiday Pay</td>
  <td align = "center"> <? echo $totalholidayamt;?></td>
<td align = "center">&nbsp;</td>
</tr>
<tr>
  <td align = "center"> Total Overtime</td>
  <td align = "center"> <? echo $totalotamt;?></td>
<td align = "center">&nbsp;</td>
</tr>
<tr>
  <td align = "center"> Lates/Absences </td>
  <td align = "center">&nbsp;</td>
<td align = "center"><? echo $lateamt;?></td>
</tr>

<?php
         /*Government Deductions*/		 
			if($paydate=='25' && $rowgetemplyees['costcenterid'] != 'FLT')
		    {
			$deduct =mysqli_query($con,"SELECT * from prlsstable WHERE rangefrom <= '$rowgetemplyees[periodrate]' AND rangeto >= '$rowgetemplyees[periodrate]'");
			$value = mysqli_fetch_array($deduct);
			$sss = $value['employeess'];
			$csss = $value['employerss'] + $value['employerec'];
			$deduct =mysqli_query($con,"SELECT * from prlphilhealth WHERE rangefrom <= '$rowgetemplyees[periodrate]' AND rangeto >= '$rowgetemplyees[periodrate]'");
			$value = mysqli_fetch_array($deduct);
			$phic = $value['employeeph'];
			$cphic = $value['employerph'];
			if($rowgetemplyees['employeeid'] == '0900003')
			{
				$hdmf = '500';
			}
			 else
			 {
			    $hdmf = '100';
			 }
			}		 
		 /*Taxable Income*/
      $otherinc =mysqli_query($con,"SELECT * from prlotherincassign WHERE employeeid = '".$rowgetemplyees['employeeid']."' 
	                           AND taxable = '1' AND (othincdate = '00' || othincdate = '$paydate')");
		while($otherincdata = mysqli_fetch_array($otherinc))
		   { 
		    if($otherincdata['payout']=='10th,25th')
			  {			  
			 $otherincamt =mysqli_query($con,"SELECT othincvalue, othincid, taxable from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amt = mysqli_fetch_array($otherincamt); 
			  $halfamt = $amt['othincvalue'] / '2';
			  echo "<tr><td width='250' align = 'center'>".$otherincdata['othincdescription']."</td><td align = 'center'>".$halfamt."</td><td>&nbsp;</td></tr>";
			  $taxableincome = $taxableincome + $halfamt;

			  }
             if($otherincdata['payout']==$paydateth)
			   {
		      $otherincamt =mysqli_query($con,"SELECT othincvalue, othincid, taxable from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amt = mysqli_fetch_array($otherincamt);
			  echo "<tr><td align = 'center'>".$otherincdata['othincdescription']."</td><td align = 'center'>".$amt['othincvalue']."</td><td>&nbsp;</td></tr>"; 
			  $taxableincome = $taxableincome + $amt['othincvalue'];
			   }
		   }		 


            /*Result*/
			$deductions = $deductions + $lateamt;
$nettaxable = $nettaxable + $payoutamt + $nightamt + $totalholidayamt + $totalotamt + $taxableincome - $lateamt - $phic - $sss - $hdmf;


?>
<tr>
<td align = "center">SSS</td>
<td>&nbsp;</td>
<td align = "center"><? echo $sss;?></td>
</tr>
<tr>
<td align = "center">PHIC</td>
<td>&nbsp;</td>
<td align = "center"><? echo $phic;?></td>
</tr>
<tr>
<td align = "center">HDMF</td>
<td>&nbsp;</td>
<td align = "center"><? echo $hdmf;?></td>
</tr>

<tr><td></td></tr>
<tr>
<td align = "center"> Total </td>
<td align = "center"><? echo $nettaxable;?></td>
<td align>&nbsp;</td></tr>
</table>
<p>&nbsp;</p>


<table align ="center" width="600">
  <?php
		/*Tax Calculation*/
		$gettax = mysqli_query($con,"SELECT * FROM prltaxtablerate WHERE taxstatusid = '$rowgetemplyees[taxstatusid]' AND rangefrom <= $nettaxable AND rangeto >= $nettaxable");
		$witholdingtax = mysqli_fetch_array($gettax);
		$percentover = ($nettaxable - $witholdingtax['rangefrom'])*(($witholdingtax['percentofexcessamount'])/'100');
	  echo "<tr><td>Tax Status (".$witholdingtax['taxstatusid'].") Range : ".$witholdingtax['rangefrom']."-".$witholdingtax['rangeto']."<br></td></tr>";
		echo "<tr><td>Fixed Tax : ".$witholdingtax['fixtax']." Percent Over Excess : ".$witholdingtax['percentofexcessamount']/'100'."<br></td></tr>";
		echo "<tr><td>Witholding Tax = Fixed Tax + Percent Over <br></td></tr>";
		echo "<tr><td>Witholding Tax = Fixed Tax + ((Taxable Income - Lower Range) x (Percent Over Excess))<br></td></tr>";
		echo "<tr><td>Witholding Tax = ".$witholdingtax['fixtax']." + ((".$nettaxable." - ".$witholdingtax['rangefrom'].") x (".$witholdingtax['percentofexcessamount']/'100'."))<br></td></tr>";
		$sum = $nettaxable-$witholdingtax['rangefrom'];
echo "<tr><td>Witholding Tax = ".$witholdingtax['fixtax']." + ((".$sum.") x (".$witholdingtax['percentofexcessamount']/'100'."))<br></td></tr>";
		echo "<tr><td>Witholding Tax = ".$witholdingtax['fixtax']." + (".$percentover.")<br></td></tr>";
		$totaltax =  $witholdingtax['fixtax'] + $percentover;
		echo "<tr><td>Witholding Tax = ".$totaltax."</td></tr>";

?>
</table>


</p>
<p>&nbsp;</p>
<table border = "1" align ="center" width="450">
<td align = "center" colspan = "3">Non Taxable Income</td></tr>
<tr><td width="250" align = "center"> Definition </td> <td width="78" align = "center"> Debit </td>
<td align="center">Credit</td></tr>

<?php
            /*NonTaxable Income*/
   		$otherinc =mysqli_query($con,"SELECT * from prlotherincassign WHERE employeeid = '".$rowgetemplyees['employeeid']."' AND taxable = '0' AND (othincdate = '00' || othincdate = '$paydate') ");
		while($otherincdata = mysqli_fetch_array($otherinc))
		   {  
		     if($otherincdata['payout']=='10th,25th')
			  {
			 $otherincamt =mysqli_query($con,"SELECT othincvalue, othincid, taxable from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amtnontax = mysqli_fetch_array($otherincamt); 
			  $halfamt = $amtnontax['othincvalue'] / '2';
			  echo "<tr><td align = 'center'>".$otherincdata['othincdescription']."</td><td align = 'center'>".$halfamt['othincvalue']."</td><td>&nbsp;</td></tr>";
              $nontaxableincome = $nontaxableincome + $halfamt;
			  }

             if($otherincdata['payout']==$paydateth)
			  {
			 $otherincamt =mysqli_query($con,"SELECT othincvalue, othincid, taxable from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amtnontax = mysqli_fetch_array($otherincamt);
			  echo "<tr><td align = 'center'>".$otherincdata['othincdescription']."</td><td align = 'center'>".$amtnontax['othincvalue']."</td><td>&nbsp;</td></tr>"; 
              $nontaxableincome = $nontaxableincome + $amtnontax['othincvalue'];
			  }
		   }	
		   
		   echo "<tr><td align = 'center'> Total </td><td align = 'center'>".$nontaxableincome."</td><td></td></tr>";

?>
</table>



<p>&nbsp;</p>
<table border = "1" align ="center" width="650">
<td align = "center" colspan = "5">LOANS</td></tr>
<tr><td width="56" align = "center"> Loan ID </td><td width="214" align = "center"> Definition </td> 
<td width="121" align = "center"> Balance</td>
<td width="108" align="center">Deduction</td><td width="117" align="center">Expiration</td></tr>
<?php
      /*Loan Deductions*/
   		$loan =mysqli_query($con,"SELECT * from prlloans WHERE employeeid = '".$rowgetemplyees['employeeid']."' AND counter > '0' AND payrelease < '".$_GET['payperiod']."'");
		while($loandata = mysqli_fetch_array($loan))
		   {  $loancounter = $loancounter + 1;
		      echo "<tr>";
			  echo "<td align = 'center'>";
			  echo $loandata['ctr'];
			  echo "</td>";
			  echo "<td align = 'center'>";
			  echo $loandata['description'];
			  echo "</td>";
			  echo "<td align = 'center'>";
			  echo $loandata['balance'];
			  echo "</td>";
			  $loandeduction = $loandata['balance']/$loandata['counter'];
			  echo "<td align = 'center'>";
			  echo $loandeduction;
			  echo "</td>";
			  echo "<td align = 'center'>";
			  echo $loandata['payend'];	
			  echo "</td>";
		      echo "</tr>"; 
			  $loanamt = $loanamt + $loandeduction;
		   }
		   
		   /*SSS & HDMF Loans*/	
            $loan =mysqli_query($con,"SELECT * from prlloansgov WHERE empid = '".$rowgetemplyees['employeeid']."' AND deductiondate = '".$paydate."'");
		while($loandata = mysqli_fetch_array($loan))
		   { 
		    $govloancounter = $govloancounter + 1;
		     echo "<tr>"; 
			 echo "<td align='center'>"; echo $loandata['loanid']; echo "</td>";
			 echo "<td align='center'>"; echo $loandata['loantype']; echo "</td>"; 	
			 echo "<td align='center'> N/A </td>";			 
			 echo "<td align='center'>"; echo $loandata['loanamt']; echo "</td>"; 
			 echo "<td align='center'> N/A </td>";			 
			 echo "</tr>";
			 
			 $govloans = $govloans + $loandata['loanamt'];
		   }
		   
		   	
			$loanamt = $loanamt + $govloans;		   
		   
		   
		   
	  

?>
</table>
<p>&nbsp;</p>
<p>Total Net Income: Taxable Income + Non Taxable Income - Total Tax - Total Loan Deductions</p>
<p>Total Net Income: <?php echo $nettaxable;?> + <?php echo $nontaxableincome;?> - <?php echo $totaltax;?> - <?php echo $loanamt;?></p>
<?php

		  
		   $netincome = $nettaxable + $nontaxableincome - $totaltax;
		   $netincome = $netincome - $loanamt;
		   
?>
		   
<p>Total Net Income = <?php echo $netincome;?></p>

<p>
  <input type="hidden" name = "todo" value="15"/>
  <input type="hidden" name = "employeeid" value = "<?php echo $_GET['employee'];?>"/>
  <input type="hidden" name = "payperiod" value = "<?php echo $_GET['payperiod'];?>"/>
  <input type="submit" name="recalculate" value = "Recalculate" onclick = "return(confirm('Confirm Changes'))"/>
</p>
</form>
<?php
	if($_POST['ifcomplete'] == 'Yes')
	{
		
/*LOOK INTO THIS LOAN PROBLEM*/	

          $loanamt = 0;
 
		    if($loancounter > '0')
			{
				
   		$loan =mysqli_query($con,"SELECT * from prlloans WHERE employeeid = '".$rowgetemplyees['employeeid']."' AND counter > '0' AND payrelease < '".$_POST['payperiod']."'");
		while($loandata = mysqli_fetch_array($loan))
		   { 
			  $loandeduction = $loandata['balance']/$loandata['counter'];
			  $loanbalance = $loandata['balance'] - $loandeduction;
			  $loanctr = $loandata['counter'] - 1;
			  $loanamt = $loanamt + $loandeduction;
			  
			  $loanupdate = "UPDATE prlloans SET counter = '$loanctr', balance = '$loanbalance' WHERE ctr = '".$loandata['ctr']."'";
			  mysqli_query($con,$loanupdate);
			  
 	 $loanlog="INSERT INTO prlloanslog (Username, ipaddress, payrollid, loanid, description)
     VALUES
     ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."','".$_POST['payperiod']."','".$loandata['ctr']."', 
	 'Payroll Loan Deduction ".$_POST['employeeid']." Loan Number ".$loandata['ctr']." amount = ".$loandeduction."')";	
	 mysqli_query($con,$loanlog);	   
							  
			  
		   }
		   
			}
			
		    if($govloancounter > '0')
			{
   		$loan =mysqli_query($con,"SELECT * from prlloansgov WHERE empid = '".$rowgetemplyees['employeeid']."' AND deductiondate = '".$paydate."'");
		while($loandata = mysqli_fetch_array($loan))
		   {  $loanamt = $loanamt + $loandata['loanamt'];

			  
 	 $loanlog="INSERT INTO prlloansgovlog (user, ipaddress, description)
     VALUES
     ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."', 'Payroll Deduction of ".$rowgetemplyees['employeeid']." amount ".$loandata['loanamt']."')";	
	 mysqli_query($con,$loanlog);	   
							  
			  
		   }
		   
			}	
/*END OF LOAN PROBLEM*/				
			
			
		$sqlcomplete = "UPDATE prlpaysummary SET costcenter = '".$_POST['costcenter']."', taxableincome = '$nettaxable',
		basicpay = '$payoutamt', holidaypay = '$totalholidayamt', regot = '$regot', 6thdayot = '$ot6amt', 7thdayot = '$ot7amt', 
		totalnd = '$nightamt',nontaxable = '$nontaxableincome', deductions = '$deductions', loandeductions = '$loanamt', 
		sss = '$sss', phic = '$phic', hdmf = '$hdmf', csss = '$csss', cphic = '$cphic', tax = '$totaltax', 
		netpay = '$netincome', complete = 'Yes' 
		WHERE employeeid = '".$_POST['employeeid']."' AND payperiod = '".$_POST['payperiod']."'";

 	 $sqllog="INSERT INTO prlpaylog (Username, ipaddress, payrollid, description)
     VALUES
     ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."','".$_POST['payperiod']."', 
	 '".$_POST['employeeid']." Completed/Verified')";	
	 mysqli_query($con,$sqllog);
     mysqli_query($con,$sqlcomplete);		
	 
	 
	 
	 
	}
?>	
</body>
</html>