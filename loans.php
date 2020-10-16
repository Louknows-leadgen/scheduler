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
if($_GET['todo']=='10')//add loan
{

?>
<form action = "" method = "get">
  <p>Create Loan</p>
<p>
         Employee ID:
           <input type="text" name="employeeid"/>
  </p>
<p>
         Loan Description:
           <input type="text" name="description"/>
  </p>  
       <p>Amount:
         <input type="text" name="amount"/>
       </p>
       <p>Release Date:
         <select name="Yearrelease">
           <option value="0000">Year</option>
           <option value="2018">2018</option>
           <option value="2019">2019</option>
           <option value="2020">2020</option>
           <option value="2021">2021</option>
           <option value="2022">2022</option>
         </select>       
         <select name="Monthrelease">
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
         <select name="Periodrelease">
                <option selected="" value="00">Day</option>
                <?
				for($day=1;$day<32;$day++)
				{
				if($day<10)
				{
					$day="0".$day;
				}
				?>
                <option value="<?=$day?>"  <? if($bday[2]==$day){ echo 'selected="selected"';} ?>><?=$day?></option>
                <?
				}
				?>
         </select>
       </p>
       <p>Date End :
         <select name="Yearend">
           <option value="0000">Year</option>
           <option value="2018">2018</option>
           <option value="2019">2019</option>
           <option value="2020">2020</option>
           <option value="2021">2021</option>
           <option value="2022">2022</option>
         </select>         
         <select name="Monthend">
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
         
         <select name="Periodend">
           <option value="">Pay Period</option>
           <option value="10th">10th</option>
           <option value="25th">25th</option>
         </select> 
         <input type = "hidden" name ="todo" value = "15"/>
         <input type="submit" name="generate" value="Create Loan" />
  </p>
</form> 

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
			{   echo "<table align='center' width='700' border='2'>";
			    $amount = $_GET['amount'];
			    $description = $_GET['description'];
			    $monthrelease = $_GET['Monthrelease'];
				$dayrelease = (str_replace("th","",$_GET['Periodrelease']));
			    $monthend = $_GET['Monthend'];
				$dayend = (str_replace("th","",$_GET['Periodend']));
				$daterelease = $_GET['Yearrelease']."-".$monthrelease."-".$dayrelease;
				$dateend = $_GET['Yearend']."-".$monthend."-".$dayend;
				echo "<tr><td align = 'center'> Release Date </td><td align = 'center'>".$daterelease; echo "</td></tr>";
				echo "<tr><td align = 'center'> Payment End </td><td align = 'center'>".$dateend; echo "</td></tr>";
				$counteryear = ($_GET['Yearend']- $_GET['Yearrelease'])*24;
				$countermonth = ($monthend- $monthrelease)*2;
				if($dayend == '10')
				{
					if($dayrelease < '10')
					{
						$counterday = 1;
					}
					else if ($dayrelease >= '10' && $dayrelease < '25')
					{
						$counterday = 0;
					}
					else if ($dayrelease >= '25')
					{
						$counterday = -1;
					}					
					
				}
				else if($dayend == '25')
				{
					if($dayrelease < '10')
					{
						$counterday = 2;
					}
					else if ($dayrelease >= '10' && $dayrelease < '25')
					{
						$counterday = 1;
					}
					else if ($dayrelease >= '25')
					{
						$counterday = 0;
					}						
					
				}
				$counter = $counteryear + $countermonth + $counterday;				
				$amortization = $_GET['amount']/$counter;
				echo "<tr><td align = 'center'> Payroll Deduction </td><td align = 'center'>".$amortization; echo "</td></tr>";
				echo "</table>";
				echo "<form method = 'post'/>";
				echo "<input type = 'hidden' name ='todo' value = '25'/>";
				echo "<input type = 'hidden' name ='counter' value = '".$counter."'/>";
				echo "<input type = 'hidden' name ='amortization' value = '".$amortization."'/>";
				echo "<input type = 'hidden' name ='daterelease' value = '".$daterelease."'/>";
				echo "<input type = 'hidden' name ='dateend' value = '".$dateend."'/>";
				echo "<input type = 'hidden' name ='description' value = '".$description."'/>";
				echo "<input type = 'hidden' name ='amount' value = '".$amount."'/>";
				echo "<input type = 'hidden' name ='employee' value = '".$rowgetemplyees['employeeid']."'/>";
				echo "<br><br>";
				echo "<input type='submit' name='generate' value='Confirm' onclick='return(confirm('Proceed?'))' />";
				echo "</form>";

			}
	}
	else
	{
		echo "Employee Does not exist";
	}
}

if($_POST['todo']=='25')//confirmed loan
{
		$sql = "INSERT INTO prlloans (employeeid, payrelease, counter, payend, description, balance)
		VALUES('".$_POST['employee']."', '".$_POST['daterelease']."', '".$_POST['counter']."', '".$_POST['dateend']."',
				'".$_POST['description']."', '".$_POST['amount']."')";
		
	mysqli_query($con,$sql);
		
 	 $sqllog="INSERT INTO prlloanslog (Username, ipaddress, payrollid, description)
     VALUES
     ('".$_SESSION['Username']."','".$_SERVER['REMOTE_ADDR']."','".$_POST['daterelease']."', 
	 'Added Loan to ".$_POST['employee']."')";	
	mysqli_query($con,$sqllog);	
	
	echo "<br><br><br>";
	echo "Loan Added.  Deduction Will Start on the Next Pay Period and continue until Date Specified";

}

if($_GET['todo']=='20')//view/editloans(choose which loan)
{
	
?>
        <table border="1" align="center"/>
        <tr><td colspan="5" align = "center"> CURRENT LOANS </td></tr>
        <tr><td align = "center">Employee number</td>
			<td align = "center">Name</td>
			<td align = "center">Active/Inactive(0/1)</td>
			<td align = "center"> Loan Number </td>
        <td align = "center"> Balance </td><td align = "center"> Expiration </td>
        <td align = "center"> Edit </td></tr>

<?php

	$getloans = "SELECT * FROM prlloans WHERE counter > 0";
	$result = mysqli_query($con,$getloans);
	while($row = mysqli_fetch_array($result))
	{
?>
        <tr><td align = "center"><?php echo $row['employeeid'];?></td>
			
<?php
	   /*Get Employee Info*/
	 
	  $getemplyees=mysqli_query($con,"select * from prlemployeemaster WHERE employeeid = '".$row['employeeid']."' LIMIT 1");
	  $rowgetemplyees=mysqli_fetch_array($getemplyees);
	   
			
?>			
		<td align = "center"><?php echo $rowgetemplyees['lastname'].", ".$rowgetemplyees['firstname'];?></td>	
		<td align = "center"><?php echo $rowgetemplyees['active'];?></td>	
        <td align = "center"><?php echo $row['ctr'];?></td>
        <td align = "center"><?php echo $row['balance'];?></td>
        <td align = "center"><?php echo $row['payend'];?></td>
        <form action="" method = "post"/>        
        <input type = "hidden" name = "todo" value = "30"/>
        <input type = "hidden" name = "id" value = "<?php echo $row['ctr'];?>"/>
        <td align = "center"><input type = "submit" name="edit" value = "Edit"/></td></tr>
        </form>

<?php		
	}
	
?> 
        </table>
        <br />
        <br />

<?php	
	
}

if($_POST['todo']=='30')
{
	$data = mysqli_query($con,"SELECT * FROM prlloans WHERE ctr = '".$_POST['id']."'");
	$loandata = mysqli_fetch_array($data);
	$amortization = $loandata['balance']/ $loandata['counter'];
	echo "<table align = 'center' border = '1' width 400>";
	echo "<tr><td align = 'center' width = '150'>Employee ID</td><td align = 'center' width = '250'>".$loandata['employeeid']."</td></tr>";
	echo "<tr><td align = 'center'>Loan Description</td><td align = 'center'>".$loandata['description']."</td></tr>";
	echo "<tr><td align = 'center'>Loan Release</td><td align = 'center'>".$loandata['payrelease']."</td></tr>";
	echo "<tr><td align = 'center'>Loan Balance</td><td align = 'center'>".$loandata['balance']."</td></tr>";
	echo "<form action = '' method = 'post'";
	$datetoday = date("Y-m-d");;
	
	echo "<tr><td align = 'center'>Loan End</td><td align = 'center'>".$loandata['payend']."</td></tr>";
	echo "<tr><td align = 'center'>Change Loan End</td><td align = 'center'>";
	echo "<select name='Yearend'>
           <option value=''></option>
           <option value='2010'>2010</option>
           <option value='2011'>2011</option>
           <option value='2012'>2012</option>
           <option value='2013'>2013</option>
           <option value='2014'>2014</option>
         </select>   ";
    echo "<select name='Monthend'>
           <option value=''> </option>
           <option value='01'>January</option>
           <option value='02'>February</option>
           <option value='03'>March</option>
           <option value='04'>April</option>
           <option value='05'>May</option>
           <option value='06'>June</option>
           <option value='07'>July</option>
           <option value='08'>August</option>
           <option value='09'>September</option>
           <option value='10'>October</option>
           <option value='11'>November</option>
           <option value='12'>December</option>
         </select>";
	echo "<select name='Periodend'>
           <option value=''></option>
           <option value='10'>10th</option>
           <option value='25'>25th</option>
         </select> ";
	echo "</td></tr>";	
	echo "<tr><td align = 'center'>Amortization</td><td align = 'center'>".$amortization."</td></tr>";
	echo "<input type = 'hidden' name = 'todo' value = '35'/>";	
	echo "<input type = 'hidden' name = 'ctr' value = '".$_POST['id']."'/>";	
	echo "<tr><td align = 'center' colspan = '2'><input type = 'submit' name = 'edit' value = 'Edit'></td></tr>";
	echo "</form>";
    echo "</table>";	
}





?>
</body>
</html>
