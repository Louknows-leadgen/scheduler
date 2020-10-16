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
<title>Untitled Document</title>
</head>

<body>

<table border = "1" align ="center">
  <tr>
  <td align = "center" colspan = "5"> YTD Period</td></tr>
<tr><td align = "center"> Payroll Year </td> 
 <td align = "center"> Pay Start Date </td> <td align = "center"> Pay End Date </td></tr>

<tr><td align = "center"> <?php echo $_POST['Year'];?></td>

<?php $startperiod = date("Y-m-d",mktime(0,0,0,1,25,$_POST['Year'])); 
   $endperiod = date("Y-m-d",mktime(0,0,0,1,10,$_POST['Year'] + 1)); 
?>


<td align = "center"> <?php echo $startperiod;?></td>
<td align="center"> <?php echo $endperiod;?></td></tr>
</table>
</p>

<table border = "1" align ="center">
<tr><td COLSPAN = "18" align = "center" width = "900"> ACTIVE EMPLOYEES </td></tr>
<tr><td align = "center"> Employee ID </td> <td align = "center"> RFID </td> <td align = "center"> Name </td> 
<td align = "center"> Position </td> <td align = "center"> Basic Income </td> 
<td align = "center"> Non Taxable Allowances </td> 
<td align = "center"> Taxable Allowances </td> 
<td align = "center"> Total ND </td> 
<td align = "center"> Total OT </td>
<td align = "center"> Total Holiday Pay </td>
<td align = "center"> Taxable Income </td>
<td align = "center"> Absences/Lates </td>
<td align = "center"> Taxable Adjustments </td> 
<td align = "center"> NonTaxable Adjustments </td>
<td align = "center"> Government Deductions </td> 
<td align = "center"> Loan Deductions </td> <td align = "center"> Witholding Tax </td>
<td align = "center"> View Details </td></tr>
<?php

$result =mysqli_query($con,"SELECT * from prlemployeemaster WHERE active = '0' ORDER BY lastname asc");
		while($row = mysqli_fetch_array($result))
		 {
			 echo "<tr>";
			 echo "<td align = 'center'>".$row['employeeid']."</td>";
			 echo "<td align = 'center'>".$row['RFID']."</td>";
			 echo "<td align = 'left'> ".$row['lastname'].", ".$row['firstname']." ".$row['middlename']."</td>";
			 echo "<td align = 'left'> ".$row['position']."</td>";
			 
			 /***GETTING Pay Details***/
			 $payresultsummary =mysqli_query($con,"SELECT payperiod,employeeid, sum(taxableincome) as taxableincome, sum(basicpay) as basicpay, sum(totalnd) as totalnd, sum(holidaypay) as holidaypay, sum(regot) as regot, sum(6thdayot) as 6thdayot, sum(7thdayot) as 7thdayot, sum(nontaxable) as nontaxable, sum(taxableotherinc) as taxableotherinc, sum(loandeductions) as loandeductions, sum(sss) as sss, sum(phic) as phic, sum(hdmf) as hdmf, sum(tax) as tax from prlpaysummary WHERE employeeid = '".$row['employeeid']."' AND payperiod >= '".$startperiod."' AND payperiod <= '".$endperiod."'");			  
			 $getpaysummary = mysqli_fetch_array($payresultsummary);
			 $mandatorydeductions = $getpaysummary['sss'] + $getpaysummary['phic'] + $getpaysummary['hdmf'];
			 $totalot = $getpaysummary['regot'] + $getpaysummary['6thdayot'] + $getpaysummary['7thdayot'];
			 
			 /***GETTING Adjustment Details***/
			 $adjustmenttaxable =mysqli_query($con,"SELECT employeeid, payrollid, category, description, taxable, sum(amount) as amount from prladjustmentlog WHERE employeeid = '".$row['employeeid']."' AND payrollid >= '".$startperiod."' AND payrollid <= '".$endperiod."' AND taxable = '1' AND category != 'Tax Refund' AND description != 'SIL Conversion'");			  
			 $getadjustmenttaxable = mysqli_fetch_array($adjustmenttaxable);
			 
			 $adjustmentnontaxable =mysqli_query($con,"SELECT employeeid, payrollid,category, description, taxable, sum(amount) as amount from prladjustmentlog WHERE employeeid = '".$row['employeeid']."' AND payrollid >= '".$startperiod."' AND payrollid <= '".$endperiod."' AND taxable = '0' AND category != 'Tax Refund' AND description != 'SIL Conversion'");			  
			 $getadjustmentnontaxable = mysqli_fetch_array($adjustmentnontaxable);
			 
			 $nontaxable = $getpaysummary['nontaxable'] - ($getadjustmentnontaxable['amount']);
			 $latesabsences = ($getpaysummary['basicpay'] + $getpaysummary['taxableotherinc'] + $getpaysummary['totalnd'] + $totalot + $getpaysummary['holidaypay'] + $getadjustmenttaxable['amount'] - $mandatorydeductions) - $getpaysummary['taxableincome'];
			 
			 echo "<td align = 'center'>".$getpaysummary['basicpay']."</td>";
			 echo "<td align = 'center'>".$nontaxable."</td>";
			 echo "<td align = 'center'>".$getpaysummary['taxableotherinc']."</td>";
			 echo "<td align = 'center'>".$getpaysummary['totalnd']."</td>";
			 echo "<td align = 'center'>".$totalot."</td>";
			 echo "<td align = 'center'>".$getpaysummary['holidaypay']."</td>";
			 echo "<td align = 'center'>".$getpaysummary['taxableincome']."</td>";
			 echo "<td align = 'center'>".$latesabsences."</td>";
			 echo "<td align = 'center'>".$getadjustmenttaxable['amount']."</td>";
			 echo "<td align = 'center'>".$getadjustmentnontaxable['amount']."</td>";
			 echo "<td align = 'center'>".$mandatorydeductions."</td>";
			 echo "<td align = 'center'>".$getpaysummary['loandeductions']."</td>";
			 echo "<td align = 'center'>".$getpaysummary['tax']."</td>";
?>

			 <td align = 'center'><a href='viewdetails.php?employee=<?php echo $row['employeeid']; ?>&startperiod=<?php echo $startperiod;?>&endperiod=<?php echo $endperiod;?>' alt='Details'  name='Details'> Details </a> </td>
<?php
			 echo "</tr>";
		 }

?>
</table>
</body>
</html>