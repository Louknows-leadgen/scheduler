<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php
   $con = mysql_connect("localhost","root","qwerty123");
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }
	
	mysql_select_db("VectorBPO", $con);
	
	    $employeeid=$_POST['employeeid'];
	    echo $employeeid;
	
	if($_GET['todo']=='15')
	  { 
        $employeeid = $_GET['employeeid'];
		$result =mysql_query("SELECT employeeid, hourlyrate, taxstatusid, firstname, lastname, periodrate, employmenttype from prlemployeemaster WHERE employeeid = $employeeid");
		$row = mysql_fetch_array($result);
		$hourlyrate = $row['hourlyrate'];
		$payoutamt = $row['periodrate']/'2';
		$nontaxableincome = '0';
		$taxableincome = '0';
		$sss = '0';
		$phic = '0';
		$hdmf = '0';
		$otherdeductions = '0';
		
		$overtime =mysql_query("SELECT overtimerate, overtimeid from prlovertimetable");
		 while($overtimerate = mysql_fetch_array($overtime))
		   {
		     $ctr = $overtimerate['overtimeid'];
			 $multiplier[$ctr] = $overtimerate['overtimerate'];
		   }
		 		   
		$nightamt = ($_GET['night'])*($hourlyrate)*($multiplier['15'] - '1');
		$regot = ($_GET['ot'])*($hourlyrate)*($multiplier['10']);
		$ot6amt = ($_GET['ot6'])*($hourlyrate)*($multiplier['20']);
		$ot7amt = ($_GET['ot7'])*($hourlyrate)*($multiplier['25']);
		$totalotamt = $regot + $ot6amt + $ot7amt;
		$sholidayamt = ($_GET['sholiday'])*($hourlyrate)*($multiplier['30']);
		$rholidayamt = ($_GET['rholiday'])*($hourlyrate)*($multiplier['35']);
		$holidayamt = $sholidayamt + $rholidayamt;
		$grosstaxable = $holidayamt + $nightamt + $totalotamt + $payoutamt ;
		$lateamt = (($_GET['late'])*($hourlyrate));
		$undertimeamt = (($_GET['undertime'])*($hourlyrate));
		$absencesamt = (($_GET['absences'])*'8'*($hourlyrate));
		$totaldeductions = $lateamt + $undertimeamt + $absencesamt;
		$totalsalary = $nettaxable + $nontaxableincome - $totaltax;
		$payoutday = str_replace("th","",$_GET['Period']);
		$payout = mktime(0,0,0,date("$_GET[Month]"),date("$payoutday"),date("Y"));
        $datepayout = date("Y-m-d", $payout);
		
		if($_GET['Period']=='25th')
		    {
			$deduct =mysql_query("SELECT * from prlsstable WHERE rangefrom <= '$row[periodrate]' AND rangeto >= '$row[periodrate]'");
			$value = mysql_fetch_array($deduct);
			$sss = $value['employeess'];
			$deduct =mysql_query("SELECT * from prlphilhealth WHERE rangefrom <= '$row[periodrate]' AND rangeto >= '$row[periodrate]'");
			$value = mysql_fetch_array($deduct);
			$phic = $value['employeeph'];
			$hdmf = '100';
			}
?>
<table width="550" border="0">
  <tr>
    <td width="107">&nbsp;</td>
    <td width="276" align = "right">PAYSLIP</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align = "right">&nbsp;</td>
    <td align = "center"> <?php echo $_GET['Month'];?>-<?php echo str_replace("th","",$_GET['Period']);?></td>
  </tr>
  <tr>
    <td align = "center">PAY NO.</td>
    <td>&nbsp;</td>
    <td align = "right">PAY PERIOD</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align = "right">&nbsp;</td>
  </tr>
  <tr>
    <td align = "center">&nbsp;</td>
    <td align = "right">Department</td>
  </tr>
  <tr>
    <td><?php echo $row['firstname'];?> <?php echo $row['lastname'];?></td>
    <td align = "center"><?php echo $employeeid ?></td>
  </tr>
  <tr>
    <td align = "center">Employee Name</td>
    <td align = "center"> Employee Number</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align = "left">&nbsp;</td>
  </tr>
  <tr>
    <td align = "center">&nbsp;</td>
    <td align = "left">Taxable Earnings</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align = "left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Basic Income</td>
    <td width="100">&nbsp;</td>
    <td width="49"><?php echo $payoutamt;?></td>
  </tr>
  <tr>
    <td align = "center">&nbsp;</td>
    <td align = "left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Night Differential</td>
    <td>&nbsp;</td>
    <td><?php echo $nightamt;?></td>
  </tr>
  <tr>
    <td align = "center">&nbsp;</td>
    <td align = "left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Overtime</td>
    <td>&nbsp;</td>
    <td><?php echo $totalotamt;?></td>
  </tr>
  <tr>
    <td align = "center">&nbsp;</td>
    <td align = "left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lates &amp; Absences</td>
    <td><?php echo $totaldeductions;?></td>
  </tr>
  <tr>
    <td align = "center">&nbsp;</td>
    <td align = "left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Holiday Pay</td>
    <td>&nbsp;</td>
    <td><?php echo $holidayamt;?></td>
  </tr>
<?php
      $otherinc =mysql_query("SELECT * from prlotherincassign WHERE employeeid = $employeeid AND taxable = '1' 
							   AND (othincdate = '00' || othincdate = '$_GET[Month]')");
		while($otherincdata = mysql_fetch_array($otherinc))
		   { 
		    if($otherincdata['payout']=='10th,25th')
			  {
			 $otherincamt =mysql_query("SELECT othincvalue, othincid, taxable from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amt = mysql_fetch_array($otherincamt); 
			  $halfamt = $amt['othincvalue'] / '2';
			  $taxableincome = $taxableincome + $halfamt;
?>		   
<tr>
    <td align = "right"></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $otherincdata['othincdescription']?></td>
    <td width="151" align = "right"><?php echo $halfamt;?></td>
 </tr> 
 
<?php

			  }
			  
             if($otherincdata['payout']==$_GET['Period'])
			   {
		      $otherincamt =mysql_query("SELECT othincvalue, othincid, taxable from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amt = mysql_fetch_array($otherincamt); 
			  
?>
  <tr>
    <td align = "center">&nbsp;</td>
    <td align = "left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $otherincdata['othincdescription']?></td>
    <td>&nbsp;</td>
    <td><?php echo $amt['othincvalue']?></td>
  </tr>
<?php
               $taxableincome = $taxableincome + $amt['othincvalue'];
			   }
		    }
  $grosspay = $grosstaxable + $taxableincome - $totaldeductions;			
  $nettaxable = $grosspay - $sss - $phic - $hdmf;
  
  		$gettax = mysql_query("SELECT * FROM prltaxtablerate WHERE taxstatusid = '$row[taxstatusid]' AND rangefrom <= $nettaxable AND rangeto >= $nettaxable");
		$witholdingtax = mysql_fetch_array($gettax);
		$percentover = ($nettaxable - $witholdingtax['rangefrom'])*(($witholdingtax['percentofexcessamount'])/'100');
		$totaltax =  $witholdingtax['fixtax'] + $percentover;
		$salarydeductions = $sss + $totaltax + $phic + $hdmf + $otherdeductions;
?>
  

  <tr>
    <td align = "center">&nbsp;</td>
    <td align = "right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gross Pay</td>
    <td>&nbsp;</td>
    <td><?php echo $grosspay?></td>
  </tr>
  <tr>
    <td align = "center">&nbsp;</td>
    <td align = "right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Taxable</td>
    <td>&nbsp;</td>
    <td><?php echo $nettaxable?></td>
  </tr>  
</table>
<table width="538" border="0">
   <tr>
     <td width="102" align = "right">&nbsp;</td>
     <td width="271" align = "left">Deductions</td>
   </tr>
   <tr>
    <td align = "right"></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Witholding Tax</td>
    <td width="151"><?php echo $totaltax;?></td>
   </tr>
<tr>
    <td align = "right"></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SSS</td>
    <td width="151"><?php echo $sss;?></td>
 </tr> 
<tr>
    <td align = "right"></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PHIC</td>
    <td width="151"><?php echo $phic;?></td>
 </tr> 
<tr>
    <td align = "right"></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HDMF</td>
    <td width="151"><?php echo $hdmf;?></td>
 </tr> 
<tr>
    <td align = "right"></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Others</td>
    <td width="151"><?php echo $otherdeductions;?></td>
 </tr>  
 <tr>
    <td align = "right"></td>
    <td align = "right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Deductions : </td>
    <td width="151"><?php echo $salarydeductions;?></td>
 </tr> 
</table>

</table>
<table width="538" border="0">
   <tr>
     <td width="102" align = "right">&nbsp;</td>
     <td width="254" align = "left">Other Income</td>
   </tr>
<?php   
        $nontaxableincome = '0';
   		$otherinc =mysql_query("SELECT * from prlotherincassign WHERE employeeid = $employeeid AND taxable = '0' AND (othincdate = '00' || othincdate = '$_GET[Month]') ");
		while($otherincdata = mysql_fetch_array($otherinc))
		   {  
		     if($otherincdata['payout']=='10th,25th')
			  {
			 $otherincamt =mysql_query("SELECT othincvalue, othincid, taxable from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amtnontax = mysql_fetch_array($otherincamt); 
			  $halfamt = $amtnontax['othincvalue'] / '2';
              $nontaxableincome = $nontaxableincome + $halfamt;
?>		   
<tr>
    <td align = "right"></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $otherincdata['othincdescription']?></td>
    <td width="151" align = "right"><?php echo $halfamt;?></td>
 </tr> 
 
<?php

			  }
			  
             if($otherincdata['payout']==$_GET['Period'])
			  {
			 $otherincamt =mysql_query("SELECT othincvalue, othincid, taxable from prlothinctable WHERE othincid = '$otherincdata[othincid]'");
			  $amtnontax = mysql_fetch_array($otherincamt); 
			  
?>		   
<tr>
    <td align = "right"></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $otherincdata['othincdescription']?></td>
    <td width="151" align = "right"><?php echo $amtnontax['othincvalue'];?></td>
 </tr> 
 
<?php
              $nontaxableincome = $nontaxableincome + $amtnontax['othincvalue'];
			  }
		   }

?>
 <tr>
    <td align = "right"></td>
    <td align = "right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Other Income: </td>
    <td width="168" align = "right"><?php echo $nontaxableincome;?></td>
 </tr> 
</table>
<table width="550" border="0">
  <tr>
    <td width="359">&nbsp;</td>
    <td width="181">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align = "right">&nbsp;</td>
  </tr>
    <tr>
    
<?php $netpay = $nettaxable + $nontaxableincome - $salarydeductions;?>    
    <td align = "right">NET PAY</td>
    <td align = "right"><?php echo $netpay?></td>
  </tr>
 </table>
 <input type="button" value="Print Page!" onclick="window.print()" />

<?php		
	  }
	 else
	  {
?>
<p>Enter Total Hours:</p>

<form action = "" method = "get">
  <p>Total Hours with Night Difference: 
  <input type="text" name="night" size = "10" />
  </p>
<p>Total Overtime Hours : 
  <input type="text" name="ot" size = "10" />
</p>
<p>Total 6th Day OT:
  <input type="text" name="ot6" size = "10" />
</p>
<p>Total 7th Day OT:
  <input type="text" name="ot7" size = "10" />
</p>
<p>Total Special Holiday Hours:
  <input type="text" name="sholiday" size = "10" />
</p>
<p>Total Regular Holiday Hours:
  <input type="text" name="rholiday" size = "10" />
</p>
<p>Late in Hours: 
  <input type="text" name="late" size = "10" />
  </p>
<p>Undertime in Hours : 
  <input type="text" name="undertime" size = "10" />
</p>
<p>Absences in Days: 
  <input type="text" name="absences" size = "10" />
</p>
<p>&nbsp;</p>
       <p>
         <select name="Month">
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
         
         <select name="Period">
           <option value="">Pay Period</option>
           <option value="10th">10th</option>
           <option value="25th">25th</option>
         </select> 
         <input type = "hidden" name = "employeeid" value = "<?php echo $employeeid; ?>"/>
         <input type = "hidden" name ="todo" value = "15"/>
         <input type="submit" name="generate" value="Generate" />
  </p>
</form>              
<?php
	  }
?>
</body>
</html>