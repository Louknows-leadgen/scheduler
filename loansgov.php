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
<?php

if($_GET['todo']=='40')//add loan
{

?>
<table align="center" border="2"/><form action = "" method = "get">
<tr><td align="center" colspan="2">Create SSS/HDMF Loan</td></tr>
<tr>
<td align="center">Employee ID:</td>
<td align="center"><input type="text" name="employeeid"/></td>
</tr>
<tr><td align="center">Loan ID:</td>
<td align="center"><input type="text" name="loanid"/></td>
</tr>    
<tr><td align="center">Amount:</td>
  <td align="center"><input type="text" name="amount"/></td>
</tr>
<tr><td align="center">Loan Type:</td>
<td align="center"><select name="loantype">
           <option value="hmoloan">HMO</option>
           <option value="hdmfloan">HDMF</option>
	       <option value="sssloan">SSS</option>
</select></td>
</tr> 
<tr>
<td align="center">Deducted on</td>
<td align="center"><select name="loanpay">
           <option value="10">10th</option>
           <option value="25">25th</option>
	       <option value="1025">10th & 25th</option>
         </select>   
         </td>               
</tr>
<tr>
<td align="center">&nbsp;</td>
         <input type = "hidden" name ="todo" value = "15"/>
<td align="center"><input type="submit" name="generate" value="Add Loan" onclick="return(confirm('Proceed?'))" /></td>
</tr>
</form> 
    
</table>

<?php    


}




if($_GET['todo']=='15')//verify loan
{
		$getemplyees="select * from prlemployeemaster where employeeid='".$_GET['employeeid']."'";
	$getemplyees=mysqli_query($con,$getemplyees);
	$count = mysqli_num_rows($getemplyees);
	$rowgetemplyees=mysqli_fetch_array($getemplyees);
	if($count == '1')
	{
?>
<table align="center" width="700" border="2">
<tr>
  <td colspan = "4" align="center"> <?php echo $rowgetemplyees['lastname']; ?>,  <?php echo $rowgetemplyees['firstname']; ?> 
<?php echo $rowgetemplyees['middlename']; ?> (<?php echo $rowgetemplyees['position']; ?>)</td>
</tr>
<tr><td width="118" align="center"> Employee Number </td><td align="center"><?php echo $rowgetemplyees['employeeid']; ?></td>
<td align="center"> Employment Status </td>
<td align="center"><? if($rowgetemplyees['active']=='0'){ echo "Active";} else { echo "InActive";} ?>
</td>
</tr>
</table>
<p>&nbsp;</p>


<?php
            if($rowgetemplyees['active']=='1')
			{
				echo "Employee is not Active.  Unable to Add loan!";
			}
			else
			{
				/*Verify Existing Loan*/
	            $getloan=mysqli_query($con,"select * from prlloansgov where loanid='".$_GET['loanid']."'");
	            $countloan = mysqli_num_rows($getloan);	            
	            if($countloan == '1')
	              {
					  echo "Loan ID Exists.  Unable to Add loan<br>";
				  }
				  
				else
				{
		          $sql = "INSERT INTO prlloansgov (empid, loanid, loantype, loanamt, deductiondate)
		          VALUES('".$_GET['employeeid']."', '".$_GET['loanid']."', '".$_GET['loantype']."', '".$_GET['amount']."',
				  '".$_GET['loanpay']."')";
		          mysqli_query($con,$sql);
				  
 	              $sqllog="INSERT INTO prlloansgovlog (user, ipaddress, description)
                   VALUES
                 ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."','LOAN ADDED ".$_GET['loanid']." - ".$_GET['amount']." Every ".$_GET['loanpay']." for ".$_GET['employeeid']."')";	
	              mysqli_query($con,$sqllog);	
				  
				  echo "Loan Added!";
				}
				
			}
	}
	else
	{
		echo "Employee Does not exist";
	}
	
}

if($_GET['todo']=='50')//Delete loan options
{

?>
<table align = "center" border="2"/>
<tr align="center" width = "700">
<td align="center" colspan = "7"> Delete SSS/HDMF Loan </td></tr>
<tr>
<td align="center"> Employee ID </td>
<td align="center"> Loan Type </td>
<td align="center"> Loan ID </td>
<td align="center"> Amount </td>
<td align="center"> Deduction Date </td>
<td align="center"> Delete </td>
</tr>
<tr>
<?php
	            $getloan=mysqli_query($con,"select * from prlloansgov order by ctr asc");
	            while($rowloan = mysqli_fetch_array($getloan))
				{

?>
<td align="center"> <?=$rowloan['empid']?> </td>
<td align="center"> <?=$rowloan['loantype']?> </td>
<td align="center"> <?=$rowloan['loanid']?> </td>
<td align="center"> <?=$rowloan['loanamt']?> </td>
<td align="center"> <?=$rowloan['deductiondate']?> </td>
<td align="center">
<form action = "" method = "get">
<input type = "hidden" name ="loanid" value = "<?=$rowloan['loanid']?>"/>
<input type = "hidden" name ="empid" value = "<?=$rowloan['empid']?>"/>
<input type = "hidden" name ="todo" value = "55"/>
<input type="submit" name="delete" value="Delete" onclick="return(confirm('Delete?'))" />
</form> 
</td>
</tr>
<?php
				}
?>
</table>  


<?php    


}

if($_GET['todo']=='55')//Delete loan
{
	mysqli_query($con,"Delete FROM prlloansgov WHERE loanid = '".$_GET['loanid']."'");
	
	 $sqllog="INSERT INTO prlloansgovlog (user, ipaddress, description)
        VALUES
        ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."','LOAN DELETED ".$_GET['loanid']." for ".$_GET['empid']."')";	
	 mysqli_query($con,$sqllog);
	 
	 echo "Loan ID ".$_GET['loanid']." Deleted";
}
?>



</body>
</html>