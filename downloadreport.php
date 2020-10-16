<? session_start();
          ob_start();
          $filename = "payroll_".$_POST['payperiod'].".xls";
          header("Content-Disposition: attachment; filename=\"$filename\""); 
          header("Content-Type: application/vnd.ms-excel"); 

          $con = mysqli_connect("localhost", "digicono_HRadmin", "DigiC0n0nlin3!",'internal');
          if (!$con)
            {
             die('Could not connect: ' . mysqli_connect_error());
             }

            // mysql_select_db("internal", $con);
			
	
	$payday = explode("-",$_POST['payperiod']);
	if ($payday[1] == '13th Month')
	
	{
		
		//1st Line title Area
		echo "Atm Number"; echo "\t";
		echo "Employee ID"; echo "\t";
		echo "Agent Lastname"; echo "\t";
		echo "Agent Firstname"; echo "\t";
		echo "Cost Center"; echo "\t";
		echo "Monthly Basic"; echo "\t";
		echo "13th Month Income"; echo "\t";
		echo "Deductions"; echo "\t";
		echo "Net Pay"; echo "\t";	
		
		echo "\n";
		
		$result = mysqli_query($con,"SELECT * FROM prl13thpay WHERE payperiod = '".$payday[0]."'");
		while($row = mysqli_fetch_array($result))
         {
			 //empname

		   
			 $resultemp = mysqli_query($con,"SELECT atmnumber,firstname, lastname, employeeid, periodrate from prlemployeemaster 
									  WHERE employeeid='".$row['employeeid']."'");
			 $rowemp = mysqli_fetch_array($resultemp);
			 
			 echo $rowemp['atmnumber']; echo "\t";
			 echo $row['employeeid']; echo "\t";
			 echo $rowemp['lastname']; echo "\t";
			 echo $rowemp['firstname']; echo "\t";
			 echo $row['costcenter']; echo "\t";
			 echo $rowemp['periodrate']; echo "\t";
			 echo $row['income']; echo "\t";
			 echo $row['deductions']; echo "\t";
			 echo $row['netpay']; echo "\t";		   
			   
			   echo "\n";
		 }
		 
	}
	
		
	else
	{
		//1st Line title Area
		echo "Atm Number"; echo "\t";
                echo "Site"; echo "\t";
		echo "Employee ID"; echo "\t";
		echo "Agent Lastname"; echo "\t";
		echo "Agent Firstname"; echo "\t";
		echo "Cost Center"; echo "\t";
		echo "Basic Pay"; echo "\t";
		echo "Taxable Income"; echo "\t";
		echo "Basic Pay"; echo "\t";
		echo "Holiday Pay"; echo "\t";
		echo "Regular Overtime"; echo "\t";
		echo "6th Day OT"; echo "\t";
		echo "7th Day OT"; echo "\t";
		echo "Total ND"; echo "\t";
		echo "Allowances"; echo "\t";
		echo "Manual Adjustment"; echo "\t";
		echo "Total NonTax Allowances"; echo "\t";
		echo "Total Tax Allowances"; echo "\t";
		echo "Deductions"; echo "\t";
		echo "Loan Deductions"; echo "\t";
		echo "SSS"; echo "\t";
		echo "PHIC"; echo "\t";
		echo "HDMF"; echo "\t";
		echo "Company SSS"; echo "\t";
		echo "Company PHIC"; echo "\t";
		echo "Company HDMF"; echo "\t";
		echo "Witholding Tax"; echo "\t";
		echo "Net Pay"; echo "\t";
		echo "Gross Pay"; echo "\t";		
		
		echo "\n";
		
		$result = mysqli_query($con,"SELECT * FROM prlpaysummary WHERE payperiod = '".$_POST['payperiod']."'");
		while($row = mysqli_fetch_array($result))
         {
			 //empname

		   
			 $resultemp = mysqli_query($con,"SELECT atmnumber,site,firstname, lastname, employeeid from prlemployeemaster 
									  WHERE employeeid='".$row['employeeid']."'");
			 $rowemp = mysqli_fetch_array($resultemp);
			 
			 echo $rowemp['atmnumber']; echo "\t";
                         echo $rowemp['site']; echo "\t";
			 echo $row['employeeid']; echo "\t";
			 echo $rowemp['lastname']; echo "\t";
			 echo $rowemp['firstname']; echo "\t";
			 echo $row['costcenter']; echo "\t";
			 echo $row['basicpay']; echo "\t";
			 echo $row['taxableincome']; echo "\t";
			 echo $row['basicpay']; echo "\t";
			 echo $row['holidaypay']; echo "\t";
			 echo $row['regot']; echo "\t";
			 echo $row['6thdayot']; echo "\t";
			 echo $row['7thdayot']; echo "\t";
			 echo $row['totalnd']; echo "\t";
			 
			 //allowances
			 $resultincome = mysqli_query($con,"SELECT * from prlotherinclog 
									  WHERE employeeid='".$row['employeeid']."' AND payperiod = '".$_POST['payperiod']."'");
			 while($rowincome =  mysqli_fetch_array($resultincome))
			   {
				   echo $rowincome['description']."(".$rowincome['amount'].") ;";
			   }
			   echo "\t";
			   
			 //adjustments
			 $adjustmenttotal = 0;
			 $resultadjust = mysqli_query($con,"SELECT * from prladjustmentlog 
									  WHERE employeeid='".$row['employeeid']."' AND payrollid = '".$_POST['payperiod']."'");
			 while($rowadjust =  mysqli_fetch_array($resultadjust))
			   {
				   echo $rowadjust['category']." - ".$rowadjust['description']."(".$rowadjust['amount'].") ;";
				   $adjustmenttotal = $adjustmenttotal + $rowadjust['amount'];
			   }
			   echo "\t";			   
			   
			   echo $row['nontaxable']; echo "\t";
			   echo $row['taxableotherinc']; echo "\t";
			   echo $row['deductions']; echo "\t";
			   echo $row['loandeductions']; echo "\t";
			   echo $row['sss']; echo "\t";
			   echo $row['phic']; echo "\t";
			   echo $row['hdmf']; echo "\t";
			   echo $row['csss']; echo "\t";
			   echo $row['cphic']; echo "\t";
			   echo $row['chdmf']; echo "\t";
			   echo $row['tax']; echo "\t";
			   echo $row['netpay']; echo "\t";
			 		   $grosspay = 0;
		   $grosspay = $row['basicpay'] + $row['holidaypay'] + $row['regot'] + $row['6thdayot'] + $row['7thdayot'] + $row['totalnd'] + $row['nontaxable'] + $row['taxableotherinc'] - $row['deductions'] + $adjustmenttotal;	
		   
			   echo $grosspay; echo "\t";			   
			   
			   echo "\n";
		 }
		 
	}
			
	ob_end_flush();		   
?>			
