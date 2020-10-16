@extends('app')

@section('content')

<link href="{{ asset('css/payslip.css') }}" rel="stylesheet">

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">

					{!! Form::open(array('action' => 'HomeController@payslip',  'target' =>"_blank" )) !!}

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-2">
								  <label>Payperiod</label>
								</div>
								<div class="col-md-5">
								  {!! Form::select('payperiod', json_decode(json_encode($payperiods), true), 'S',array('class'=>'form-control')); !!}											</div>
							</div>				
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<button type="submit" class="btn btn-success" >View Payslip</button>
							</div>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
	</div>

</div>

</div>
</div>

<?php 


/* List Variables */


$pay_date_period = date("Y-m-d");


//* Sample Value for display purposes just remove for  

$emp_id = $emp_name = $dept_name = $position = $basic_pay = $total_nd = $holiday_pay = $non_taxable_allowance = $non_taxable_allowance = $regular_ot = $taxable_allowance = $sixth_day_ot = $incentives = $seventh_day_ot = $disputes = $lates_or_absences = $load_deductions =  $phic = $withholding_tax = $hdmf = $taxable_income = $gross_income= $net_income = $sss= 1;


/* Employee Information */

// $pay_date_period
// $emp_id
// $emp_name
// $dept_name
// $position

/* EARNINGS */

// $basic_pay
// $total_nd
// $holiday_pay
// $non_taxable_allowance
// $regular_ot
// $taxable_allowance
// $sixth_day_ot
// $incentives
// $seventh_day_ot
// $disputes


/* DEDUCTIONS */

// $lates_or_absences
// $sss
// $load_deductions
// $phic
// $withholding_tax
// $hdmf
// $adjustment_details

/* INCOME SUMMARY */

// $taxable_income
// $gross_income
// $net_income ;

?>

@if(isset($data['payperiod']))

<div class="container" id = "payslip-body">

	<div class="row" id = "row-payslip" style="background: url('/assets/dci-background.png');">

		<table border="1" id= "emp_pay_summary-table"> 

						<tr><td colspan="4" class=""> <h1> <b> Employee Pay Summary </h1>

						<tr><td id=  "payslip_date" colspan="4"> 
							<h3>  Payslip for Pay Period: <?php echo $pay_date_period; ?> </h3>
						
						<tr><td>Employee Id <td class="payslip_date-detail" > <?php echo $emp_id; ?> 
							<td>Employee Name <td class="payslip-detail"> <?php echo $emp_name; ?>

						<tr>
							<td> Department <td class="payslip-detail"> <?php echo $dept_name; ?> 
							<td> Position <td class="payslip-detail"> 	<?php echo $position; ?>

					</table>


					<table border="1" > 

						<tr><td colspan="4" class="tbl-header"> <h2> <b> EARNINGS </h2>

						<tr><td>Basic Pay <td class="payslip-detail" > <?php echo $basic_pay; ?> 

							<td>Total ND  <td class="payslip-detail" > <?php echo $total_nd; ?>

						<tr>
							<td>Holiday Pay <td class="payslip-detail"><?php echo $holiday_pay; ?> 
							
							<td> Non- taxable Allowance 
								<td class="payslip-detail"> <?php echo $non_taxable_allowance; ?>

						<tr><td >Regular OT

							<td class="payslip-detail"> <?php echo $regular_ot; ?> 

							<td> Taxable Allowance <td class="payslip-detail"> 
														<?php echo $taxable_allowance; ?>

						<tr><td > 6th Day OT 
							<td class="payslip-detail"> <?php echo $sixth_day_ot; ?> <td> Incentives <td class="payslip-detail"> <?php echo $incentives; ?>
						<tr>
							<td> 7th Day OT <td class="payslip-detail"> <?php echo $seventh_day_ot; ?> 
							<td> Disputes <td class="payslip-detail"> <?php echo $disputes; ?>
			 
					</table>

					<table border="1" class=""> 

						<tr><td colspan="4" class="tbl-header"> <h2> <b> DEDUCTIONS </h2>

						<tr><td>Late/Absences/Others 
							<td class="payslip-detail"><?php echo $lates_or_absences; ?> 
							<td> SSS <td  class="payslip-detail"> <?php echo $sss; ?>

						<tr><td >Load Deductions 	 <td  class="payslip-detail">  
							<?php echo $load_deductions; ?> <td > PHIC 
							<td class="payslip-detail"> <?php echo $phic; ?>

						<tr><td >Witholding Tax <td  class="payslip-detail">  
							<?php echo $withholding_tax; ?> 
							<td > HDMF <td> <?php echo $hdmf; ?>

						<tr><td> Adjustment Details <td colspan="3"> <?php $adjustment_details; ?> 
			 
					</table>

					<table border="1" width="40%" class="pull-left" id = "income_summary"> 

						<tr>
							<td> Taxable Income 
							<td class="payslip-detail"> <?php echo $taxable_income; ?> 

							<tr>
							<td> <b> Gross Income </b>
							<td class="payslip-detail">  <?php echo $gross_income; ?>  
							
							<tr><td> <b> Net Income </b> 
							<td class="payslip-detail">  <?php echo $net_income; ?>  

					</table>

@endif
				
	</div>		

</div>

		</div>

	</div>

</div>

@endsection
