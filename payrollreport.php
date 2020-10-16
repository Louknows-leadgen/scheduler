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
if($_GET['todo'] == '10')
{
?>
View Payroll
	<form action="" method="get"/>
    	<p>
  <select name="payperiod">
<?php        $result = mysqli_query($con,"SELECT payperiod, openclose from prlpayrollperiod WHERE openclose = 1");
             while($row=mysqli_fetch_array($result))
			 {
?>        
    <option value="<?php echo $row['payperiod'];?>"><?php echo $row['payperiod'];?></option>
    
<?php         
              }
?>
 <option value="Summary">Summary</option>	            
  </select>
  <input type="hidden" name="todo" value="15"/>
   	  </p>
    	<p>
    	  <input type="submit" name="confirm" value="Confirm"/>
  	  </p>
</form>

<?php
}

else if($_GET['todo']=='15')
{
	$payday = explode("-",$_GET['payperiod']);
	
	if($payday[1] == '13th Month')
	{
		echo $payday[0]." 13th Month Pay";
		
		 $pay=mysqli_query($con,"SELECT * FROM prlpayrollperiod WHERE payperiod = '".$_GET['payperiod']."'");
 $rowpay=mysqli_fetch_array($pay);		
		
?>

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
		
		  echo "<table border='1' align='center'>";
	   echo "<tr><td align='center' colspan = '14'> Payroll Summary By Department</td></tr>";
	   echo "<tr>";
	   echo "<td align='center'>COST CENTER</td>";
	   echo "<td align='center'>Income</td>";
	   echo "<td align='center'>Deductions</td>";
	   echo "<td align='center'>Net Pay</td>";
	   
	   echo "</tr>";
	   
	$sql = "SELECT *, SUM(income) as income13, SUM(deductions) as deduction13, SUM(netpay ) as netpay13
	 FROM prl13thpay WHERE payperiod = '".$payday[0]."' GROUP BY costcenter";
	$result = mysqli_query($con,$sql);
      while($row=mysqli_fetch_array($result))
		{
         echo "<tr>";
		 echo "<td align='center'>".$row['costcenter']."</td>";
		 echo "<td align='center'>".$row['income']."</td>"; $b = $b + $row['income13'];
		 echo "<td align='center'>".$row['deductions']."</td>"; $c = $c + $row['deduction13'];
		 echo "<td align='center'>".$row['netpay']."</td>"; $d = $d + $row['netpay13'];
		 
		 echo "</tr>";
		}
		echo "<tr><td colspan = '14'>&nbsp;</td></tr>";
         echo "<tr>";
		 echo "<td align='center'>TOTAL</td>";
		 echo "<td align='center'>".$b."</td>";
		 echo "<td align='center'>".$c."</td>";
		 echo "<td align='center'>".$d."</td>";
		 echo "</tr>";		
		
	echo "</table>";
	
	
	
	echo "<table border='1' align='center'>";
	   echo "<tr><td align='center' colspan = '14'> Payroll Summary By Employee </td></tr>";
	   echo "<tr>";
   	   echo "<td align='center'>Agent ID</td>";
	   echo "<td align='center'>Agent Name</td>";	   
	   echo "<td align='center'>COST CENTER</td>";
	   echo "<td align='center'>Monthly Pay</td>";
	   echo "<td align='center'>Income</td>";	   
	   echo "<td align='center'>Deductions</td>";
	   echo "<td align='center'>Net 13th Month</td>";
	  
	   echo "<td align='center'>View Details</td>";
	   
	   echo "</tr>";
	  $b=0;
	  $c=0;
	  $d=0;
   
	echo "<p>&nbsp;</p>";
	$sqlemp = "SELECT * FROM prl13thpay WHERE payperiod = '".$payday[0]."'";
	$resultemp = mysqli_query($con,$sqlemp);
      while($rowemp=mysqli_fetch_array($resultemp))
		{
	  $resultdata = mysqli_query($con,"SELECT employeeid,atmnumber lastname,firstname,periodrate from prlemployeemaster WHERE employeeid = '".$rowemp['employeeid']."'");
      $rowdata=mysqli_fetch_array($resultdata);	
	     
         echo "<tr>";
		 echo "<td align='center'>".$rowemp['employeeid']."</td>";
		 echo "<td align='center'>".$rowdata['lastname'].", ".$rowdata['firstname']."</td>";	
		 echo "<td align='center'>".$rowemp['costcenter']."</td>";
		 echo "<td align='center'>".$rowdata['periodrate']."</td>";
		 echo "<td align='center'>".$rowemp['income']."</td>"; $b = $b + $rowemp['income'];
		 echo "<td align='center'>".$rowemp['deductions']."</td>"; $c = $c + $rowemp['deductions'];
		 echo "<td align='center'>".$rowemp['netpay']."</td>"; $d = $d + $rowemp['netpay'];
		
echo "<td><a href='edit13paypud.php?employee=".$rowemp['employeeid']."&todo=10&payperiod=".$_GET['payperiod']."' target='iframe1'>View Detail</a></td>";		 
		 echo "</tr>";

		}
		echo "<tr><td colspan = '14'>&nbsp;</td></tr>";
         echo "<tr>";
		 echo "<td align='center' colspan = '4'>TOTAL</td>";		 
		 echo "<td align='center'>".$b."</td>";		 
		 echo "<td align='center'>".$c."</td>";
		 echo "<td align='center'>".$d."</td>";
		 echo "</tr>";		
		
	echo "</table>";
		
		echo "<form action = 'downloadreport.php' method = 'post'/>";
	echo "<input type='hidden' name = 'payperiod' value='".$_GET['payperiod']."'/>";
	echo "<input type='submit' name='download' value='Download'/>";
	echo "</form>";
		
		
	}
	
	
	else
	{
	if($_GET['payperiod'] == 'Summary')
	{
	   echo "<table border='1' align='center'>";
	   echo "<tr><td align='center' colspan = '14'> Payroll Summary By Department</td></tr>";
	   echo "<tr>";
	   echo "<td align='center'>COST CENTER</td>";
	   echo "<td align='center'>Taxable Income</td>";
	   echo "<td align='center'>Regular OT</td>";
	   echo "<td align='center'>6th Day OT</td>";
	   echo "<td align='center'>7th Day OT</td>";
	   echo "<td align='center'>Total ND</td>";
	   echo "<td align='center'>Non Taxable</td>";
	   echo "<td align='center'>Deductions</td>";
	   echo "<td align='center'>Loan Deductions</td>";
	   echo "<td align='center'>SSS</td>";
	   echo "<td align='center'>PHIC</td>";
	   echo "<td align='center'>HDMF</td>";
	   echo "<td align='center'>Employer SSS</td>";
	   echo "<td align='center'>Employer PHIC</td>";
	   echo "<td align='center'>TAX</td>";	   
	   echo "</tr>";
	   
	$sql = "SELECT *, SUM(taxableincome) as taxable, SUM(regot) as regot, SUM(6thdayot ) as 6thdayot, SUM(7thdayot ) as 7thdayot,
	 SUM(totalnd ) as totalnd, SUM(nontaxable) as nontaxable, SUM(deductions ) as deductions, SUM(loandeductions ) as loandeductions, SUM(sss) as sss, SUM(phic) as phic,
	 SUM(hdmf) as hdmf, SUM(csss) as csss, SUM(cphic) as cphic, SUM(tax) as tax
	 FROM prlpaysummary GROUP BY costcenter";
	$result = mysqli_query($con,$sql);
      while($row=mysqli_fetch_array($result))
		{

			$b = $b + $row['taxable'];
			$c = $c + $row['regot'];
			$d = $d + $row['6thdayot'];
			$e = $e + $row['7thdayot'];
			$f = $f + $row['totalnd'];
			$g = $g + $row['nontaxable'];
			$h = $h + $row['deductions'];
			$loan = $loan + $row['loandeductions'];
			$i = $i + $row['sss'];
			$j = $j + $row['phic'];
			$k = $k + $row['hdmf'];
			$l = $l + $row['csss'];
			$m = $m + $row['cphic'];
			$n = $n + $row['tax'];

         echo "<tr>";
		 echo "<td align='center'>".$row['costcenter']."</td>";
		 echo "<td align='center'>".$row['taxable']."</td>"; 
		 echo "<td align='center'>".$row['regot']."</td>"; 
		 echo "<td align='center'>".$row['6thdayot']."</td>"; 
		 echo "<td align='center'>".$row['7thdayot']."</td>"; 
		 echo "<td align='center'>".$row['totalnd']."</td>"; 
		 echo "<td align='center'>".$row['nontaxable']."</td>"; 
		 echo "<td align='center'>".$row['deductions']."</td>";
		 echo "<td align='center'>".$row['loandeductions']."</td>";
		 echo "<td align='center'>".$row['sss']."</td>"; 
		 echo "<td align='center'>".$row['phic']."</td>"; 
		 echo "<td align='center'>".$row['hdmf']."</td>"; 
		 echo "<td align='center'>".$row['csss']."</td>"; 
		 echo "<td align='center'>".$row['cphic']."</td>"; 
		 echo "<td align='center'>".$row['tax']."</td>"; 		
		 echo "</tr>";		
		}
		
		echo "<tr><td colspan = '14'>&nbsp;</td></tr>";
         echo "<tr>";
		 echo "<td align='center'>TOTAL</td>";
		 echo "<td align='center'>".$b."</td>";
		 echo "<td align='center'>".$c."</td>";
		 echo "<td align='center'>".$d."</td>";
		 echo "<td align='center'>".$e."</td>";
		 echo "<td align='center'>".$f."</td>";
		 echo "<td align='center'>".$g."</td>";
		 echo "<td align='center'>".$h."</td>";
		 echo "<td align='center'>".$loan."</td>";
		 echo "<td align='center'>".$i."</td>";
		 echo "<td align='center'>".$j."</td>";
		 echo "<td align='center'>".$k."</td>";
		 echo "<td align='center'>".$l."</td>";
		 echo "<td align='center'>".$m."</td>";
		 echo "<td align='center'>".$n."</td>";
		 echo "</tr>";		
		
	echo "</table>";	
	

    echo "<br><br>";
    echo "
	<form action='' method='post'>
<table align = 'center' border ='1'>
    <tr><td colspan = '3' align = 'center'>Employee Summary</td></tr>
	<tr>
    	<td align = 'center' colspan = '3'><strong>Search</strong></td>
    </tr>
    <tr>
    	<td>Employee ID</td><td>First Name</td><td>Last Name</td>
    </tr>
    <tr>
    	<td><input type='text' name='employeeid' /></td>
        <td><input type='text' name='firstname' /></td>
        <td><input type='text' name='lastname' /></td>
    </tr>
    <tr>
    	<td colspan='3' align='right'>
        (Leave all blank to view all)
        <input type = 'hidden' name = 'searching' value='1' />
        <input type='submit' name='search' value='Search' /></td>
    </tr>
</table>

</form>";


		 if($_POST['searching']=='1')
            {
				echo "<table align = 'center' border ='1'>
                      <tr><td align = 'center' colspan = '17'><strong>Employee Summary</td></tr>
					  <tr><td align = 'center'>Employee ID</td>
					  <td align = 'center'>Agent Name</td>
					  <td align = 'center'>Taxable Income</td>
					  <td align = 'center'>Regular OT</td>
					  <td align = 'center'>6th Day OT</td>
					  <td align = 'center'>7th Day OT</td>
					  <td align = 'center'>Total ND</td>
					  <td align = 'center'>Non Taxable</td>
					  <td align = 'center'>Deductions</td>
					  <td align = 'center'>Loan Deductions</td>
					  <td align = 'center'>SSS</td>
					  <td align = 'center'>PHIC</td>
					  <td align = 'center'>HDMF</td>
					  <td align = 'center'>Employer SSS</td>
					  <td align = 'center'>employer PHIC</td>
					  <td align = 'center'>Tax</strong></td>
					  
					  </tr>";					  
					  
                $getemplyees=mysqli_query($con,"select * from prlemployeemaster WHERE employeeid LIKE '%".$_POST['employeeid']."%' and lastname LIKE '%".$_POST['lastname']."%'  and firstname LIKE '%".$_POST['firstname']."%' and active = '0' ORDER BY lastname asc");
               while($rowgetemplyees=mysqli_fetch_array($getemplyees))
			     {
					 
	  $b=0;
	  $c=0;
	  $d=0;
	  $e=0;
	  $f=0;
	  $g=0;
	  $h=0;
	  $loan=0;
	  $i=0;
	  $j=0;
	  $k=0;
	  $l=0;
	  $m=0;
	  $n=0;	  					 
					 $getpaysummary=mysqli_query($con,"SELECT * FROM prlpaysummary WHERE employeeid = '".$rowgetemplyees['employeeid']."'");
               while($rowgetpaysummary=mysqli_fetch_array($getpaysummary))
			     {
					$b = $b + $rowgetpaysummary['taxableincome'];
		        	$c = $c + $rowgetpaysummary['regot'];
					$d = $d + $rowgetpaysummary['6thdayot'];
					$e = $e + $rowgetpaysummary['7thdayot'];
					$f = $f + $rowgetpaysummary['totalnd'];
					$g = $g + $rowgetpaysummary['nontaxable'];
					$h = $h + $rowgetpaysummary['deductions'];
					$loan = $loan + $rowgetpaysummary['loandeductions'];
					$i = $i + $rowgetpaysummary['sss'];
					$j = $j + $rowgetpaysummary['phic'];
					$k = $k + $rowgetpaysummary['hdmf'];
					$l = $l + $rowgetpaysummary['csss'];
					$m = $m + $rowgetpaysummary['cphic'];
					$n = $n + $rowgetpaysummary['tax'];
				 }
					 echo "<tr>";
					 echo "<td align = 'center'>".$rowgetemplyees['employeeid']."</td>";
					 echo "<td align = 'center'>".$rowgetemplyees['lastname'].", ".$rowgetemplyees['firstname']." ".$rowgetemplyees['middlename']."</td>";
					 echo "<td align = 'center'>".$b."</td>";
					 echo "<td align = 'center'>".$c."</td>";
					 echo "<td align = 'center'>".$d."</td>";
					 echo "<td align = 'center'>".$e."</td>";
					 echo "<td align = 'center'>".$f."</td>";
					 echo "<td align = 'center'>".$g."</td>";
					 echo "<td align = 'center'>".$h."</td>";
					 echo "<td align = 'center'>".$loan."</td>";
					 echo "<td align = 'center'>".$i."</td>";
					 echo "<td align = 'center'>".$j."</td>";
					 echo "<td align = 'center'>".$k."</td>";
					 echo "<td align = 'center'>".$l."</td>";
					 echo "<td align = 'center'>".$m."</td>";
					 echo "<td align = 'center'>".$n."</td>";	
 
					 echo "</tr>";
				 
				 }
				  
					  
			    echo "</table>";
			}
	
	
	

	}
	
	else
	{
 $pay=mysqli_query($con,"SELECT * FROM prlpayrollperiod WHERE payperiod = '".$_GET['payperiod']."'");
 $rowpay=mysqli_fetch_array($pay);		
		
?>

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
       echo "<table border='1' align='center'>";
	   echo "<tr><td align='center' colspan = '14'> Payroll Summary By Department</td></tr>";
	   echo "<tr>";
	   echo "<td align='center'>COST CENTER</td>";
	   echo "<td align='center'>Taxable Income</td>";
	   echo "<td align='center'>Regular OT</td>";
	   echo "<td align='center'>6th Day OT</td>";
	   echo "<td align='center'>7th Day OT</td>";
	   echo "<td align='center'>Total ND</td>";
	   echo "<td align='center'>Non Taxable</td>";
	   echo "<td align='center'>Taxable Other Income</td>";
	   echo "<td align='center'>Deductions</td>";
	   echo "<td align='center'>Loan Deductions</td>";
	   echo "<td align='center'>SSS</td>";
	   echo "<td align='center'>PHIC</td>";
	   echo "<td align='center'>HDMF</td>";
	   echo "<td align='center'>Employer SSS</td>";
	   echo "<td align='center'>Employer PHIC</td>";
	   echo "<td align='center'>Employer HDMF</td>";
	   echo "<td align='center'>TAX</td>";
	   
	   echo "</tr>";
	   
	$sql = "SELECT *, SUM(taxableincome) as taxable, SUM(regot) as regot, SUM(6thdayot ) as 6thdayot, SUM(7thdayot ) as 7thdayot,
	 SUM(totalnd ) as totalnd, SUM(nontaxable) as nontaxable, SUM(taxableotherinc) as taxableotherinc, SUM(deductions ) as deductions, SUM(sss) as sss, SUM(phic) as phic,
	 SUM(hdmf) as hdmf, SUM(csss) as csss, SUM(cphic) as cphic, SUM(chdmf) as chdmf, SUM(tax) as tax
	 FROM prlpaysummary WHERE payperiod = '".$_GET['payperiod']."' GROUP BY costcenter";
	$result = mysqli_query($con,$sql);
      while($row=mysqli_fetch_array($result))
		{
         echo "<tr>";
		 echo "<td align='center'>".$row['costcenter']."</td>";
		 echo "<td align='center'>".$row['taxable']."</td>"; $b = $b + $row['taxable'];
		 echo "<td align='center'>".$row['regot']."</td>"; $c = $c + $row['regot'];
		 echo "<td align='center'>".$row['6thdayot']."</td>"; $d = $d + $row['6thdayot'];
		 echo "<td align='center'>".$row['7thdayot']."</td>"; $e = $e + $row['7thdayot'];
		 echo "<td align='center'>".$row['totalnd']."</td>"; $f = $f + $row['totalnd'];
		 echo "<td align='center'>".$row['nontaxable']."</td>"; $g = $g + $row['nontaxable'];
		 echo "<td align='center'>".$row['taxableotherinc']."</td>"; $sumtaxableotherinc = $sumtaxableotherinc + $row['taxableotherinc'];
		 echo "<td align='center'>".$row['deductions']."</td>"; $h = $h + $row['deductions'];
		 echo "<td align='center'>".$row['loandeductions']."</td>"; $loan = $loan + $row['loandeductions'];
		 echo "<td align='center'>".$row['sss']."</td>"; $i = $i + $row['sss'];
		 echo "<td align='center'>".$row['phic']."</td>"; $j = $j + $row['phic'];
		 echo "<td align='center'>".$row['hdmf']."</td>"; $k = $k + $row['hdmf'];
		 echo "<td align='center'>".$row['csss']."</td>"; $l = $l + $row['csss'];
		 echo "<td align='center'>".$row['cphic']."</td>"; $m = $m + $row['cphic'];
		 echo "<td align='center'>".$row['chdmf']."</td>"; $sumhdmf = $sumhdmf + $row['chdmf'];
		 echo "<td align='center'>".$row['tax']."</td>"; $n = $n + $row['tax'];
		 echo "</tr>";
		}
		echo "<tr><td colspan = '14'>&nbsp;</td></tr>";
         echo "<tr>";
		 echo "<td align='center'>TOTAL</td>";
		 echo "<td align='center'>".$b."</td>";
		 echo "<td align='center'>".$c."</td>";
		 echo "<td align='center'>".$d."</td>";
		 echo "<td align='center'>".$e."</td>";
		 echo "<td align='center'>".$f."</td>";
		 echo "<td align='center'>".$g."</td>";
		 echo "<td align='center'>".$sumtaxableotherinc."</td>";
		 echo "<td align='center'>".$h."</td>";
		 echo "<td align='center'>".$loan."</td>";
		 echo "<td align='center'>".$i."</td>";
		 echo "<td align='center'>".$j."</td>";
		 echo "<td align='center'>".$k."</td>";
		 echo "<td align='center'>".$l."</td>";
		 echo "<td align='center'>".$m."</td>";
		 echo "<td align='center'>".$sumhdmf."</td>";
		 echo "<td align='center'>".$n."</td>";
		 echo "</tr>";		
		
	echo "</table>";
	

	echo "<br \>";
	echo "<br \>";echo "<br \>";echo "<br \>";
	
       echo "<table border='1' align='center'>";
	   echo "<tr><td align='center' colspan = '14'> Payroll Summary By Employee </td></tr>";
	   echo "<tr>";
   	   echo "<td align='center'>Agent ID</td>";
	   echo "<td align='center'>Account Num</td>";
	   echo "<td align='center'>Agent Name</td>";	   
	   echo "<td align='center'>COST CENTER</td>";
	   echo "<td align='center'>Basic Pay</td>";
	   echo "<td align='center'>Taxable Income</td>";	   
	   echo "<td align='center'>Regular OT</td>";
	   echo "<td align='center'>6th Day OT</td>";
	   echo "<td align='center'>7th Day OT</td>";
	   echo "<td align='center'>Total ND</td>";
	   echo "<td align='center'>Non Taxable</td>";
	   echo "<td align='center'>Taxable Other Income</td>";
	   echo "<td align='center'>Deductions</td>";
	   echo "<td align='center'>Loan Deductions</td>";
	   echo "<td align='center'>SSS</td>";
	   echo "<td align='center'>PHIC</td>";
	   echo "<td align='center'>HDMF</td>";
	   echo "<td align='center'>Employer SSS</td>";
	   echo "<td align='center'>Employer PHIC</td>";
	   echo "<td align='center'>Employer HDMF</td>";
	   echo "<td align='center'>TAX</td>";
	   echo "<td align='center'>Gross Pay</td>
	   <td align='center'>View Details</td>";
	   
	   echo "</tr>";
	  $b=0;
	  $c=0;
	  $d=0;
	  $e=0;
	  $f=0;
	  $g=0;
	  $sumtaxableotherinc=0;
	  $h=0;
	  $loan=0;
	  $i=0;
	  $j=0;
	  $k=0;
	  $l=0;
	  $m=0;
	  $sumhdmf=0;
	  $n=0;	   
	   $grosspaytotal = 0;
	$sqlemp = "SELECT * FROM prlpaysummary WHERE payperiod = '".$_GET['payperiod']."'";
	$resultemp = mysqli_query($con,$sqlemp);
      while($rowemp=mysqli_fetch_array($resultemp))
		{
	  $resultdata = mysqli_query($con,"SELECT employeeid,atmnumber, lastname,firstname from prlemployeemaster WHERE employeeid = '".$rowemp['employeeid']."'");
      $rowdata=mysqli_fetch_array($resultdata);	
	  
			 //adjustments
			 $adjustmenttotal = 0;
			 $resultadjust = mysqli_query($con,"SELECT * from prladjustmentlog 
									  WHERE employeeid='".$rowemp['employeeid']."' AND payrollid = '".$_GET['payperiod']."'");
			 while($rowadjust =  mysqli_fetch_array($resultadjust))
			   {
				   $adjustmenttotal = $adjustmenttotal + $rowadjust['amount'];
			   }	  
	  
		   $grosspay = 0;
		   $grosspay = $rowemp['basicpay'] + $rowemp['holidaypay'] + $rowemp['regot'] + $rowemp['6thdayot'] + $rowemp['7thdayot'] + $rowemp['totalnd'] + $rowemp['nontaxable'] + $rowemp['taxableotherinc'] - $rowemp['deductions'] + $adjustmenttotal;		   
         echo "<tr>";
		 echo "<td align='center'>".$rowemp['employeeid']."</td>";
		 echo "<td align='center'>".$rowdata['atmnumber']."</td>";
		 echo "<td align='center'>".$rowdata['lastname'].", ".$rowdata['firstname']."</td>";	
		 echo "<td align='center'>".$rowemp['costcenter']."</td>";
		 echo "<td align='center'>".$rowemp['basicpay']."</td>";
		 echo "<td align='center'>".$rowemp['taxableincome']."</td>"; $b = $b + $rowemp['taxableincome'];
		 echo "<td align='center'>".$rowemp['regot']."</td>"; $c = $c + $rowemp['regot'];
		 echo "<td align='center'>".$rowemp['6thdayot']."</td>"; $d = $d + $rowemp['6thdayot'];
		 echo "<td align='center'>".$rowemp['7thdayot']."</td>"; $e = $e + $rowemp['7thdayot'];
		 echo "<td align='center'>".$rowemp['totalnd']."</td>"; $f = $f + $rowemp['totalnd'];
		 echo "<td align='center'>".$rowemp['nontaxable']."</td>"; $g = $g + $rowemp['nontaxable'];
		 echo "<td align='center'>".$rowemp['taxableotherinc']."</td>"; $sumtaxableotherinc = $sumtaxableotherinc + $rowemp['taxableotherinc'];
		 echo "<td align='center'>".$rowemp['deductions']."</td>"; $h = $h + $rowemp['deductions'];
		 echo "<td align='center'>".$rowemp['loandeductions']."</td>"; $loan = $loan + $rowemp['loandeductions'];
		 echo "<td align='center'>".$rowemp['sss']."</td>"; $i = $i + $rowemp['sss'];
		 echo "<td align='center'>".$rowemp['phic']."</td>"; $j = $j + $rowemp['phic'];
		 echo "<td align='center'>".$rowemp['hdmf']."</td>"; $k = $k + $rowemp['hdmf'];
		 echo "<td align='center'>".$rowemp['csss']."</td>"; $l = $l + $rowemp['csss'];
		 echo "<td align='center'>".$rowemp['cphic']."</td>"; $m = $m + $rowemp['cphic'];
		 echo "<td align='center'>".$rowemp['chdmf']."</td>"; $sumhdmf = $sumhdmf + $rowemp['chdmf'];
		 echo "<td align='center'>".$rowemp['tax']."</td>"; $n = $n + $rowemp['tax'];
		 echo "<td align='center'>".$grosspay."</td>"; $grosspaytotal = $grosspaytotal + $grosspay;
echo "<td><a href='editpayslippud.php?employee=".$rowemp['employeeid']."&todo=10&payperiod=".$_GET['payperiod']."' target='iframe1'>View Detail</a></td>";		 
		 echo "</tr>";

		}
		echo "<tr><td colspan = '14'>&nbsp;</td></tr>";
         echo "<tr>";
		 echo "<td align='center' colspan = '4'>TOTAL</td>";		 
		 echo "<td align='center'>".$b."</td>";		 
		 echo "<td align='center'>".$c."</td>";
		 echo "<td align='center'>".$d."</td>";
		 echo "<td align='center'>".$e."</td>";
		 echo "<td align='center'>".$f."</td>";
		 echo "<td align='center'>".$g."</td>";
		 echo "<td align='center'>".$sumtaxableotherinc."</td>";
		 echo "<td align='center'>".$h."</td>";
		 echo "<td align='center'>".$loan."</td>";
		 echo "<td align='center'>".$i."</td>";
		 echo "<td align='center'>".$j."</td>";
		 echo "<td align='center'>".$k."</td>";
		 echo "<td align='center'>".$l."</td>";
		 echo "<td align='center'>".$m."</td>";
		 echo "<td align='center'>".$sumhdmf."</td>";
		 echo "<td align='center'>".$n."</td>";
		 echo "<td align='center'>".$grosspaytotal."</td>";
		 echo "</tr>";		
		
	echo "</table>";
	
	echo "<form action = 'downloadreport.php' method = 'post'/>";
	echo "<input type='hidden' name = 'payperiod' value='".$_GET['payperiod']."'/>";
	echo "<input type='submit' name='download' value='Download'/>";
	echo "</form>";
	
	}
	}
		
}
?>




</body>
</html>