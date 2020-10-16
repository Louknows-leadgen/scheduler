
<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

<link href="{{ asset('css/payslip.css') }}" rel="stylesheet">

<body style="background: url({{ asset('assets/dci-background.png') }});"> 

<?php 

/* List Variables */
  
  

//* Sample Value for display purposes just remove for  

	$emp_id = $emp_name = $dept_name = $position = $basic_pay = $total_nd = $holiday_pay = $non_taxable_allowance = $non_taxable_allowance = $regular_ot = $taxable_allowance = $sixth_day_ot = $incentives = $seventh_day_ot = $disputes = $lates_or_absences = $load_deductions =  $phic = $withholding_tax = $hdmf = $taxable_income = $gross_income= $net_income = $sss= 1;
 

		/* Employee Information */


		$pay_date_period = isset($data['payperiod']) ? $data['payperiod']:'';
 
		$emp_id 	= isset($pay_info->employeeid)?$pay_info->employeeid:'';

		$emp_name 	= isset($pay_info->name)?$pay_info->name:'';

		$dept_name 	= isset($pay_info->costcenter)?$pay_info->costcenter:'';

		$position  	= isset($pay_info->position)?$pay_info->position:'';

		/* EARNINGS */

  		$basic_pay 				= isset($pay_info->basicpay)?$pay_info->basicpay:'0.00';
	
		$total_nd 				= isset($pay_info->totalnd)? $pay_info->totalnd:'0.00';
 
		$adjustment_details 	= isset($pay_info->manual_adjustment)?$pay_info->manual_adjustment:'0.00';
				
		$holiday_pay 			= isset($pay_info->holidaypay)? $pay_info->holidaypay:'0.00';

		$non_taxable_allowance	= isset($pay_info->nontaxable)?$pay_info->nontaxable:'0.00';

  		$regular_ot 			= isset($pay_info->regot)?$pay_info->regot:'0.00';

 		$sixth_day_ot			= isset($pay_info->sixthdayOT)?$pay_info->sixthdayOT:'0.00';

		$seventh_day_ot 		= isset($pay_info->seventhdayOT)?$pay_info->seventhdayOT:'0.00';

		$incentives 			= isset($pay_info->incentive)?$pay_info->incentive:'0.00';
		 
		$disputes 				= isset($pay_info->disputes) ? $pay_info->disputes:'0.00';

  		$taxable_allowance 		= isset($pay_info->allowance)?$pay_info->allowance:'0.00';

  		$gross_income			= $basic_pay + $holiday_pay + $regular_ot + $sixth_day_ot + $seventh_day_ot + $incentives + $disputes + $taxable_allowance + $non_taxable_allowance + $total_nd;

 		$total_earnings = $basic_pay + $total_nd + $holiday_pay + $non_taxable_allowance + $regular_ot + $sixth_day_ot + $seventh_day_ot + $incentives + $disputes + $taxable_allowance;

		/* DEDUCTIONS */

		$lates_or_absences = isset($pay_info->deductions)?$pay_info->deductions:'0.00';
		
		$sss = isset($pay_info->sss)? $pay_info->sss:'0.00';

		$loan_deductions =  isset($pay_info->loandeductions)? $pay_info->loandeductions:'0.00';

		$phic = isset($pay_info->phic)?$pay_info->phic:'0.00';
		
		$withholding_tax = isset($pay_info->tax)?$pay_info->tax:'0.00';
		
		$hdmf = isset($pay_info->hdmf)?$pay_info->hdmf:'0.00';
		
		$adjustment_details  = isset($pay_info->manual_adjustment)?$pay_info->manual_adjustment:'0.00';
 		
 		$total_deductions = $lates_or_absences + $sss + $loan_deductions + $phic + $withholding_tax + $hdmf;

		/* INCOME SUMMARY */

		$taxable_income = isset($pay_info->taxableincome)?$pay_info->taxableincome:'0.00';

 		$net_income = isset($pay_info->netpay)?$pay_info->netpay:'0.00';



?>
		<table border="1" id= "emp_pay_summary-table" class="table center-table"> 

			<tr><td colspan="4" class=""> <h1> <b> Employee Pay Summary </h1>

			<tr><td id=  "payslip_date" colspan="4"> 

				<h3>  Payslip for Pay Period: {{ $pay_date_period }}</h3>

						<tr><td>Employee Id <td class="payslip_date-detail" > {{ $emp_id }} 
							<td>Employee Name <td class="payslip-detail">  {{ $emp_name }}   

						<tr>
							<td> Department <td class="payslip-detail"> {{ $dept_name }}  
							<td> Position <td class="payslip-detail"> {{ $position }}  

		</table>

		<table border="1" class="table center-table"> 

						<tr><td colspan="4" class="tbl-header"> <h2> <b> EARNINGS </h2>

						<tr><td>Basic Pay <td class="payslip-detail" ><?php echo "P ". number_format($basic_pay, 2); ?>

							<td>Total ND  <td class="payslip-detail" ><?php echo "P ". number_format($total_nd, 2); ?> 

						<tr>
							<td>Holiday Pay <td class="payslip-detail"><?php echo "P ". number_format($holiday_pay, 2); ?>
							
							<td> Non- taxable Allowance 
								<td class="payslip-detail"><?php echo "P ". number_format($non_taxable_allowance, 2); ?>
						<tr><td >Regular OT

							<td class="payslip-detail"><?php echo "P ". number_format($regular_ot, 2); ?>

							<td> Taxable Allowance <td class="payslip-detail"><?php echo "P ". number_format($taxable_allowance, 2); ?>

						<tr><td > 6th Day OT 

							<td class="payslip-detail"><?php echo "P ". number_format($sixth_day_ot, 2); ?>  

							<td> Incentives <td class="payslip-detail"><?php echo "P ". number_format($incentives, 2); ?>
						<tr>
							<td> 7th Day OT <td class="payslip-detail"><?php echo "P ". number_format($seventh_day_ot, 2); ?>

							<td> Disputes <td class="payslip-detail"><?php echo "P ". number_format($disputes, 2); ?>
			 			
			 			<tr><td colspan="4"> <b> Others </b>

						<tr><td align="center"><?php foreach($adjustment_log as $adjustments){ ?> 
										
 			 							<?php 
 	
 			 							if($adjustments->amount > 0)
	 			 							echo $adjustments->description. "- P " . number_format($adjustments->amount, 2) . "<br><td colspan = '3'> "; ?>

			 				<?php }	?>
					</table>

		<table border="1" class="table center-table"> 

						<tr><td colspan="4" class="tbl-header"> <h2> <b> DEDUCTIONS </h2>

						<tr><td>Late/Absences/Others 
							<td class="payslip-detail"><?php echo "P ". number_format($lates_or_absences, 2); ?>

							<td> SSS <td  class="payslip-detail"><?php echo "P ". number_format($sss, 2); ?> 

						<tr><td >Load Deductions 	 
								<td  class="payslip-detail"><?php echo "P ". number_format($loan_deductions, 2); ?> 
							
							<td> PHIC 
								<td class="payslip-detail"><?php echo "P ". number_format($phic, 2); ?> 

						<tr><td >Witholding Tax 
								<td  class="payslip-detail"><?php echo "P ". number_format($withholding_tax, 2); ?> 
								<td> HDMF <td> <?php echo "P ". number_format( $hdmf ); ?>

						<tr><td colspan="4"> <b> Adjustment Details </b>

						<tr><td align="center"><?php foreach($adjustment_log as $adjustments){ ?> 
										
 			 							<?php 
 	
 			 							if($adjustments->amount < 0){

											echo $adjustments->description. "- P" . number_format($adjustments->amount, 2) . "<br><td colspan = '3'> "; 
											 
												$total_deductions += $adjustments->amount;

											}

											?>

			 				<?php }	?>
					
					<tr><td><b>Total Deductions </b><td>
							
							P <?php echo number_format($total_deductions, 2); ?>

					</table>



					<table border="1" width="40%" class="table pull-left" id = "income_summary"> 

						<tr>
							<td> Taxable Income 
							<td class="payslip-detail"> <?php echo "P ". number_format($taxable_income, 2); ?> 

							<tr>
							<td> <b> Gross Income </b>
							<td class="payslip-detail">  <?php echo "P ". number_format($gross_income, 2); ?>  
							
							<tr><td> <b> Net Income </b> 
							<td class="payslip-detail">  <?php echo "P ". number_format($net_income, 2); ?>  
	
					</table>
	</center>

</body>
