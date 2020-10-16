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
	if($_POST['ifcomplete'] == 'Yes' && $_POST['todo'] == 15)
	{ 
	    $PAY = 0;
		$PAY = $_POST['basicpay'] + $_POST['amount'];
			
		$sqlcomplete = "UPDATE prl13thpay SET costcenter = '".$_POST['costcenter']."', income = '".$_POST['basicpay']."',
		deductions = '".$_POST['amount']."', complete = 'Yes', netpay = '".$PAY."' WHERE employeeid = '".$_POST['employeeid']."' AND payperiod = '".$_POST['payperiod']."'";

 	 $sqllog="INSERT INTO prlpaylog (Username, ipaddress, payrollid, description)
     VALUES
     ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."','".$_POST['payperiod']."', 
	 '".$_POST['employeeid']." Completed/Verified')";	
	 mysqli_query($con,$sqllog);
     mysqli_query($con,$sqlcomplete);		
	 
	 
	 
	 
	}
?>	


<?php

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
<td width="118" align="center"> RFID </td><td width="121" align="center"> <?php echo $rowgetemplyees['RFID']; ?></td>
</tr>
<tr>
<td width="118" align="center"> 13th Month Pay </td>
<td width="200" align="center"><input type="text" name="basicpay" value="<?php echo $rowgetemplyees['periodrate']; ?>"/></td>
<td align="center" colspan = "2"><strong><---- Edit to change Base 13th Month Pay</strong></td></tr>
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
$resultsummary = mysqli_query($con,"SELECT * from prl13thpay WHERE employeeid = '".$rowgetemplyees['employeeid']."' AND payperiod = '".$_GET['payperiod']."'");
$rowgetsummary=mysqli_fetch_array($resultsummary);
?>
<select name="ifcomplete">
    	  <option value="No" <? if($rowgetsummary['complete']=='No'){ echo 'selected="selected"';} ?>>NO</option>
    	  <option value="Yes" <? if($rowgetsummary['complete']=='Yes'){ echo 'selected="selected"';} ?>>YES</option>
  </select></td></tr>

</table>

<p>&nbsp;</p>
<table border = "1" align ="center">
  <tr>
  <td align = "center" colspan = "5"> 13th Pay Period</td></tr>
<tr><td align = "center"> Payroll ID </td> <td align = "center"> Payroll Description </td> 
<td align = "center"> Pay Period </td> <td align = "center"> Pay Start Date </td> <td align = "center"> Pay End Date </td></tr>
<tr><td align = "center"> <? echo $rowpay['payrollid'];?></td><td align = "center"> <? echo $rowpay['payrolldesc'];?></td>
<td align = "center"> <? echo $rowpay['payperiod'];?></td>
<td align = "center"> <? echo $rowpay['startdate'];?></td>
<td align="center"> <? echo $rowpay['enddate'];?></td></tr>
</table>
<p>&nbsp;</p>
<table border = "1" align ="center" width="650">
  <tr>
    <td colspan="4" align="center">
Adjustment Amount</td></tr>
<tr>
<td width="138" align="center">Description</td>
<td width="240" align="center"><input type="text" name="description" size="40"/></td>

<td align="center">Amount </td>
<td align="center"><input type="text" name="amount" size="15"/></td></tr>
<tr>
<td colspan="4">&nbsp;</td>
</tr>

</table>
<?php

?>

<p>&nbsp;</p>
<table border = "1" align ="center" width="450">
  <tr>
  <td align = "center" colspan = "3">13th Month Income</td></tr>
<tr><td width="250" align = "center"> Definition </td> <td width="78" align = "center"> Debit </td> 
<td width="100" align = "center"> Credit </td></tr>
<tr>
  <td align = "center"> 13th Month Pay</td>
  <td align = "center"> <? echo $rowgetsummary['income'];?></td>
  
<?php
$additionalpay = 0;
$deductionpay = 0;
if ($rowgetsummary['deductions'] > 0)
{
	$additionalpay = $rowgetsummary['deductions'];
	$netpay = $additionalpay + $rowgetsummary['income'];
}
else
{
	$deductionpay = $rowgetsummary['deductions'];
	$netpay = $rowgetsummary['income'] + $deductionpay;
}


?>
<td align = "center">&nbsp;</td>
</tr>
<tr>
  <td align = "center"> Additional Pay</td>
  <td align = "center"><? echo $additionalpay;?></td>
<td align = "center">&nbsp;</td>
</tr>
<tr>
  <td align = "center"> Deductions</td>
  <td align = "center">&nbsp;</td>
<td align = "center"><? echo $deductionpay;?></td>
</tr>


<tr><td></td></tr>
<tr>
<td align = "center"> Total </td>
<td align = "center"><input type="text" name="netpay" value="<?php echo $netpay; ?>"/></td>
<td align>&nbsp;</td></tr>
</table>
<p>&nbsp;</p>

<p>
  <input type="hidden" name = "todo" value="15"/>
  <input type="hidden" name = "employeeid" value = "<?php echo $_GET['employee'];?>"/>
  <input type="hidden" name = "payperiod" value = "<?php echo $_GET['payperiod'];?>"/>
  <input type="submit" name="recalculate" value = "Recalculate" onclick = "return(confirm('Confirm Changes'))"/>
</p>
</form>

</body>
</html>