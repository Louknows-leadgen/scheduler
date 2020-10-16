<?
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
<?
if(isset($_POST['todo']) && $_POST['todo']=='25')
{
 mysqli_query($con,"DELETE FROM prlpayrollperiod WHERE payperiod = '".$_POST['period']."'");
 mysqli_query($con,"DELETE FROM prlpaysummary WHERE payperiod = '".$_POST['period']."'");
 mysqli_query($con,"DELETE FROM prladjustmentlog WHERE payrollid = '".$_POST['period']."'");
 mysqli_query($con,"DELETE FROM prlloanstemp WHERE payrollid = '".$_POST['period']."'");
 mysqli_query($con,"DELETE FROM prlotherinclog WHERE payperiod = '".$_POST['period']."'");
 mysqli_query($con,"DELETE FROM prlloansgovlog WHERE payperiod = '".$_POST['period']."'");
 	 $sqllog="INSERT INTO prlpaylog (Username, ipaddress, payrollid, description)
     VALUES
     ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."','".$_POST['period']."', 
	 'Payroll Deleted')";	
	 mysqli_query($con,$sqllog);
 echo "Payroll Deleted!!";
}

else if(isset($_POST['todo']) && $_POST['todo']=='35')
{
	mysqli_query($con,"UPDATE prlpayrollperiod SET openclose = '1' WHERE payperiod = '".$_POST['period']."'");
	 	 $sqllog="INSERT INTO prlpaylog (Username, ipaddress, payrollid, description)
     VALUES
     ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."','".$_POST['period']."', 
	 'Payroll Closed')";	
	 mysqli_query($con,$sqllog);
	 
	 
	    		$loan =mysqli_query($con,"SELECT * from prlloanstemp WHERE payrollid = '".$_POST['period']."'");
		while($loandata = mysqli_fetch_array($loan))
		   { 
		   mysqli_query($con,"UPDATE prlloans SET counter = '".$loandata['loanctr']."', 
																   balance = '".$loandata['balance']."' 
																   WHERE ctr = '".$loandata['loanid']."'");
		   
 	 $loanlog="INSERT INTO prlloanslog (Username, ipaddress, payrollid, loanid, description)
     VALUES
     ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."','".$_POST['period']."','".$loandata['loanid']."', 
	 'Payroll Loan Deduction ".$loandata['empid']." Loan Number ".$loandata['loanid']." amount = ".$loandata['loandeduction']."')";	
	 mysqli_query($con,$loanlog);	   		   
		   
		   }
		   
		    mysqli_query($con,"DELETE FROM prlloanstemp WHERE payrollid = '".$_POST['period']."'");
}
?> 
</body>
</html>