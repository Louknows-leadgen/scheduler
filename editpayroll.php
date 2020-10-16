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
if ($_GET['todo']=='10')
{
?>
OPEN PAYROLL
<form action="" method="get"/>
    	<p>
  <select name="payperiod">
    <?php        $result = mysqli_query($con,"SELECT payperiod, openclose from prlpayrollperiod WHERE openclose = 0");
             while($row=mysqli_fetch_array($result))
			 {
?>        
    <option value="<?php echo $row['payperiod'];?>"><?php echo $row['payperiod'];?></option>
    
    <?php         
              }
?>	            
  </select>
  <input type="hidden" name="todo" value="15"/>
   	  </p>
    	<p>
    	  <input type="submit" name="confirm" value="Confirm"/>
  	  </p>
</form>
<?php
	
}

else if ($_GET['todo']=='15')
{
?>
	
<table border = "1" align ="center">
<tr><td COLSPAN = "8" align = "center" width = "900"> ACTIVE EMPLOYEES </td></tr>
<tr><td align = "center"> Employee ID </td> <td align = "center"> Name </td> 
<td align = "center"> Taxable Income </td> 
<td align = "center"> Tax </td>
<td align = "center"> Allowance </td>
<td align = "center"> Net Pay </td> 
<td align = "center"> Complete </td>
<td align = "center"> Edit/View </td></tr>
<?php
        $payday = explode("-",$_GET['payperiod']);
		$pay = $payday[2];
		$payth = $payday[2]."th";
		$counter = 0;
		$grosspaytotal = 0;
		
		if ($payday[1] == '13th Month')
		{
			echo "13th Month Pay";
					$result =mysqli_query($con,"SELECT * FROM prl13thpay WHERE payperiod = '".$payday[0]."' ORDER BY ctr asc");
		while($row = mysqli_fetch_array($result))
		 { $counter = $counter + 1;
		   $grosspay = 0;
		   $grosspay = $row['income'];

		   $resultemployee =mysqli_query($con,"SELECT * FROM prlemployeemaster WHERE employeeid = '".$row['employeeid']."'");
		   $rowemployee = mysqli_fetch_array($resultemployee);
		   
?>		   
           <tr>	 
	       <td align = "center"> <?php echo $row['employeeid']; ?>
           <td> <?php echo $rowemployee['lastname']; ?>, <?php echo $rowemployee['firstname']; ?>  </td>
           <td align = "center"> <?php echo $rowemployee['position']; ?> </td>   
           <td align = "center"> <?php echo $grosspay; ?> </td>  
           <td align = "center"> <?php echo $row['complete']; ?> </td> 
           <td align = "center"><a href="edit13pay.php?employee=<?php echo $row['employeeid']; ?>&todo=10&payperiod=<?php echo $payday[0];?>" alt="Edit"  name="Edit"> Edit </a></td>
           </tr>
         
<?php	
		 }

		}
		
		else
		{

		
		$result =mysqli_query($con,"SELECT * FROM prlpaysummary WHERE payperiod = '".$_GET['payperiod']."' ORDER BY ctr asc");
		while($row = mysqli_fetch_array($result))
		 { $counter = $counter + 1;
		   $grosspay = 0;
		   $grosspay = $row['basicpay'] + $row['holidaypay'] + $row['regot'] + $row['6thdayot'] + $row['7thdayot'] + $row['totalnd'] + $row['nontaxable'] + $row['taxableotherinc'] - $row['deductions'];
		   $grosspaytotal = $grosspaytotal + $grosspay;
		   $netpaytotal = $netpaytotal + $row['netpay']; 
		   $taxableincome=$row['basicpay'] + $row['holidaypay'] + $row['regot'] + $row['6thdayot'] + $row['7thdayot'] + $row['totalnd'] +  $row['taxableotherinc'] - $row['deductions'];
		  

		   $resultemployee =mysqli_query($con,"SELECT * FROM prlemployeemaster WHERE employeeid = '".$row['employeeid']."'");
		   $rowemployee = mysqli_fetch_array($resultemployee);
		   $hourlyrate = $rowemployee['hourlyrate'];
		   $payoutamt = $rowemployee['periodrate']/'2';				   
?>		   
           <tr>	 
	       <td align = "center"> <?php echo $row['employeeid']; ?>
           <td> <?php echo $rowemployee['lastname']; ?>, <?php echo $rowemployee['firstname']; ?>  </td>
		   <td align = "center"> <?php echo $taxableincome; ?> </td>
		   <td align = "center"> <?php echo $row['tax']; ?> </td>
           <td align = "center"> <?php echo $row['nontaxable']; ?> </td>   
           <td align = "center"> <?php echo $row['netpay']; ?> </td>  
           <td align = "center"> <?php echo $row['complete']; ?> </td> 
           <td align = "center"><a href="editpayslip.php?employee=<?php echo $row['employeeid']; ?>&todo=10&payperiod=<?php echo $_GET['payperiod'];?>" alt="Edit"  name="Edit"> Edit </a></td>
           </tr>
         
<?php	
		 }
		 
		 
		}
?> 
<tr><td align = "center" colspan = "5"> <strong>TOTAL NET PAY</strong></td><td><?php echo $netpaytotal; ?></td></tr>
</table> 
         <p>&nbsp;</p>
         <form action = "deletepayroll.php" method = "post" >
           <input type = "hidden" name ="period" value = "<?php  echo $_GET['payperiod'];?>"/>
         <input type = "hidden" name ="todo" value = "25"/>
         <input type="submit" name="generate" value="Delete This Pay Period" onclick = "return(confirm('Confirm Delete'))"/>
         <br />
         <br />
         </form> 
         
         <form action = "deletepayroll.php" method = "post" >
           <input type = "hidden" name ="period" value = "<?php  echo $_GET['payperiod'];?>"/>
         <input type = "hidden" name ="todo" value = "35"/>
         <input type="submit" name="generate" value="Close This Pay Period" onclick = "return(confirm('Confirm Close'))"/>
         </form>          
         
         
              
<?php		 
		  
}

?>
</body>
</html>