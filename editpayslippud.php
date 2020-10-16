<?php
session_start();
if(!isset($_SESSION['Code'])){
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
     if($_POST['active'] != '2')
	{$updaterate = $_POST['basicpay']*'12'/'261'/'8';}
     else
       {$updaterate = '50.00';}

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
	$rowgetemplyees=mysqli_fetch_array($getemplyees);

    $getsummary="select * from prlpaysummary where employeeid='".$_GET['employee']."' AND payperiod = '".$_GET['payperiod']."'";
	$getsummary=mysqli_query($con,$getsummary);
	$rowgetsummary=mysqli_fetch_array($getsummary);
	$hourlyrate = $rowgetemplyees['hourlyrate'];
	$payoutamt = $rowgetsummary['basicpay'];
	

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
         <option value="2" <? if($rowgetemplyees['active']=='2'){ echo 'selected="selected"';} ?>>Part-Time</option>

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
<td width="121" align="center"><input type="text" name="basicpay" value="<?php echo $payoutamt; ?>"/></td>
<td width="121" align="center"> Hourly Rate </td> 
<td width="120" align="center"><?php echo $hourlyrate; ?></td></tr>
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
		$nightamt = '0';
		$nightsecs = 0;		
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
			   {$regot = $regot + ($hourlyrate * $multiplier[10] * ($rowlog['regular_ot_hours'] + $rowlog['early'] + $rowlog['nightdiff_ot_hours']));
			   $regothours = $regothours + $rowlog['regular_ot_hours'] + $rowlog['early'] + $rowlog['nightdiff_ot_hours'] ;}
			  
			   
			   
			   /*holiday check*/
			     $holidayhours = 0;
			   	 $holidaycheck=mysqli_query($con,"SELECT * from prlholidaytable WHERE holidaydate = '".$rowlog['shiftdate']."'");
			     $check=mysqli_num_rows($holidaycheck);
				 
			     if($check=='1')
			       {
					   $holidayhours = $rowlog['regular_hours'] + $rowlog['nightdiff_hours'] + $rowlog['regular_ot_hours'] + $rowlog['nightdiff_ot_hours'] + $rowlog['sixth_ot_hours'] + $rowlog['seventh_ot_hours'];
					   $checktype=mysqli_fetch_array($holidaycheck);
					   
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
			  $absentlog = mysqli_query($con,"SELECT * FROM finalhourstable WHERE shiftdate >= '$paystart' AND shiftdate <= '$payend' AND userid = '".$row['employeeid']."' AND (status = 'Absent' OR status = 'USUP' OR status = 'LMAT' OR status = 'LOAM' OR status = 'BVUNP' OR status = 'LOAU' OR status = 'NCNS' OR status = 'SKUNP') GROUP BY shiftdate");
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
<p>
  <?php
					   
		   /*Summary Amount*/
           if($rowgetemplyees['nightrate'] == '0')
		   {
		      $nightamt = 0;
?>Not Entitled to Night Differential<br />
<p>&nbsp;</p>
<?php			  
		   }	
		   
		   if($rowgetemplyees['overtimepay'] == '0')
		   {
			  $regot = 0;
			  $ot6amt = 0;
			  $ot7amt = 0;
?>Not Entitled to Overtime Pay <br />
<p>&nbsp;</p>
<?php			  
		   }	
		   if($rowgetemplyees['holidaypay'] == '0')
		   {
			  $totalholidayamt= 0;
?>Not Entitled to Holiday Pay <br />
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
<?
	$getpaysummary=mysqli_query($con,"SELECT * FROM prlpaysummary WHERE employeeid = '".$rowgetemplyees['employeeid']."' AND payperiod = '".$_GET['payperiod']."'");
    $rowgetpaysummary=mysqli_fetch_array($getpaysummary);
	$getemp=mysqli_query($con,"SELECT * FROM prlemployeemaster WHERE employeeid = '".$rowgetemplyees['employeeid']."'");
    $rowgetemp=mysqli_fetch_array($getemp);
	if($rowgetemp['employmenttype']=='0'){ $type = "Exempt";}
	else if($rowgetemp['employmenttype']=='1'){ $type = "NonExempt";}
	
	$getsummary="select * from prlpaysummary where employeeid='".$rowgetemplyees['employeeid']."' AND payperiod = '".$_GET['payperiod']."'";
	$getsummary=mysqli_query($con,$getsummary);
	$rowgetsummary=mysqli_fetch_array($getsummary);
	$hourlyrate = $rowgetemp['hourlyrate'];
	$payoutamt = $rowgetsummary['basicpay'];
	$payperiodth = explode("-",$_GET['payperiod']);
	$payoutamt = number_format($payoutamt,2,'.',',');
	$hourlyrate = number_format($hourlyrate,2,'.',',');
	

	echo "<table width='750' border='1' align='center' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>";

					echo "<table width='750' align = 'center' border='1' cellpadding='3' cellspacing='1' bgcolor='#FFFFFF'>
                      <tr><td align = 'center' colspan = '17' height = '15'><strong><h2>Employee Pay Summary</h2></strong></td></tr>
					  <tr><td align = 'center' colspan = '17' height = '15'><strong>Pay Slip for Pay Period ".$_GET['payperiod']."</strong></td></tr>
					  <tr><td align = 'center' width = '175'>Employee ID</td>
					  <td align = 'center' width = '200'>".$rowgetemplyees['employeeid']."</td>
					  <td align = 'center' width = '175'>Employee Name : </td>
					  <td align = 'center' width = '200'>".$rowgetemp['lastname'].", ".$rowgetemp['firstname']."</td>
					  </tr>
					  <tr><td align = 'center' width = '175'>Department</td>
					  <td align = 'center' width = '200'>".$rowgetemp['costcenterid']."</td>
					  <td align = 'center' width = '175'>Position</td>
					  <td align = 'center' width = '200'>".$rowgetemp['position']."</td>
					  </tr>		
					  <tr><td align = 'center' width = '175'>Employment Type</td>
					  <td align = 'center' width = '200'>".$type."</td>
					  <td align = 'center' width = '175'>Tax Status</td>
					  <td align = 'center' width = '200'>".$rowgetemp['taxstatusid']."</td>
					  </tr>		
					  <tr><td align = 'center' width = '175'>Basic Pay</td>
					  <td align = 'center' width = '200'>".$payoutamt."</td>
					  <td align = 'center' width = '175'>Hourly Rate</td>
					  <td align = 'center' width = '200'>".$hourlyrate."</td>
					  </tr>	
					  <tr><td colspan = '4'>&nbsp</td></tr>
					  <tr><td align = 'center' colspan = '2'>Earnings</td>
					  <td align = 'center' colspan = '2'>Deductions</td>
					  </tr>					  
					  <tr><td align = 'center'>Basic Pay</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['basicpay'],2,'.',',')."</td>
					  <td align = 'center'>Late/Absences/Others</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['deductions'],2,'.',',')."</td>
					  </tr>						  
					  <tr><td align = 'center'>Holiday Pay</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['holidaypay'],2,'.',',')."</td>
					  <td align = 'center'>Loan Deductions</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['loandeductions'],2,'.',',')."</td>
					  </tr>						  
					  <tr><td align = 'center'>Regular OT</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['regot'],2,'.',',')."</td>
					  <td align = 'center'>SSS</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['sss'],2,'.',',')."</td>
					  </tr>
					  <tr><td align = 'center'>6th Day OT</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['6thdayot'],2,'.',',')."</td>
					  <td align = 'center'>PHIC</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['phic'],2,'.',',')."</td>
					  </tr>
					  <tr><td align = 'center'>7th Day OT</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['7thdayot'],2,'.',',')."</td>
					  <td align = 'center'>HDMF</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['hdmf'],2,'.',',')."</td>
					  </tr>	
					  <tr><td align = 'center'>Total ND</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['totalnd'],2,'.',',')."</td>
					  <td colspan = '2'>&nbsp</td>
					  </tr>							  
					  <tr><td align = 'center'>Non Taxable</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['nontaxable'],2,'.',',')."</td>
					  <td colspan = '2'>&nbsp</td>
					  </tr>					  						  
					  <tr><td align = 'center'>Taxable Other Income</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['taxableotherinc'],2,'.',',')."</td>
					  <td align = 'center'>Tax</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['tax'],2,'.',',')."</td>
					  </tr>";
			  
	$getadjustment=mysqli_query($con,"SELECT * FROM prladjustmentlog WHERE employeeid = '".$rowgetemplyees['employeeid']."' AND payrollid = '".$_GET['payperiod']."'");
    while($rowgetadjustment=mysqli_fetch_array($getadjustment))
	{
		echo "<tr>";
		if($rowgetadjustment['amount'] < 0)
		{
			 echo "<td colspan = '2'>&nbsp</td>";
		}
		echo "<td align = 'center'>".$rowgetadjustment['category']."(".$rowgetadjustment['description'].") </td>
		      <td align = 'center'>".number_format($rowgetadjustment['amount'],2,'.',',')."</td></tr>";
	} 
	
	//getting YTD
	$gross = 0;
	$sumbasic = 0;
	$sumnet = 0;
	
	$timeunix = mktime(0,0,0,1,10,$_GET['payperiod']);
	$startyear = date("Y-m-d",$timeunix);       
       if($startyear == $_GET['payperiod'])
        {
          $startyear =  date("Y-m-d",mktime(0,0,0,1,10,$_GET['payperiod'] - 1));
        }

	$getytd=mysqli_query($con,"SELECT SUM(basicpay) as basic, SUM(netpay) as net, SUM(taxableincome) as taxable, SUM(nontaxable) as nontaxable, SUM(sss) as sss, SUM(phic) as phic, SUM(hdmf) as hdmf, SUM(tax) as tax FROM `prlpaysummary` WHERE `payperiod` <= '".$_GET['payperiod']."' AND `payperiod` > '".$startyear."' AND `employeeid` LIKE '".$rowgetemplyees['employeeid']."'");
	$rowgetytd=mysqli_fetch_array($getytd);
	$gross = $rowgetytd['taxable'] + $rowgetytd['nontaxable'] - $rowgetytd['sss'] - $rowgetytd['phic'] - $rowgetytd['hdmf'];
	
			  
					  echo "<tr height = '2px'><td colspan = '4'></td>
					  </tr>	
					  <tr><td align = 'center'>Taxable Income</td>
					  <td align = 'center'>".number_format($rowgetpaysummary['taxableincome'],2,'.',',')."</td>
					  </tr>	
					  <tr><td align = 'center'>NetPay</strong></td>
					  <td align = 'center'>".number_format($rowgetpaysummary['netpay'],2,'.',',')."</td>
					  </tr>		
					  <tr height = '2px'><td colspan = '4'></td>
					  </tr>
					  <tr><td align = 'center'> YTD Basic Pay</td>
					  <td align = 'center'>".number_format($rowgetytd['basic'],2,'.',',')."</td>
					  </tr>		
					  <tr><td align = 'center'> YTD Taxable Income </td>
					  <td align = 'center'>".number_format($rowgetytd['taxable'],2,'.',',')."</td>
					  <td align = 'center'> YTD Witholding Tax </td>
					  <td align = 'center'>".number_format($rowgetytd['tax'],2,'.',',')."</td>
					  </tr>	
					  <tr><td align = 'center'> YTD Gross Pay </td>
					  <td align = 'center'>".number_format($gross,2,'.',',')."</td>
					  </tr>	
					  <tr><td align = 'center'> YTD Net Pay </td>
					  <td align = 'center'>".number_format($rowgetytd['net'],2,'.',',')."</td>
					  </tr>	
				      ";								
					  
					  
					  
					  
					  
					 echo "</table>";




?>

<p>&nbsp;</p>
<table align ="center" width="600">

</table>
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
<p>&nbsp;</p>
</body>
</html>