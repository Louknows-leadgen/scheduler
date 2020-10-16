@extends('app')

@section('content')

<div class="container">

	<div class="row">

		<div class="col-md-10 col-md-offset-1">

			<div class="panel panel-default">

				<div class="panel-heading">

					{!! Form::open(array('action' => 'HomeController@index')) !!}
				  

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

								<button type="submit" class="btn btn-info">View Payslip</button>

							</div>

						</div>

					<table class="table table-striped">
						<!-- 
						<?php foreach($payperiods as $payperiods_row) { ?>


						<?php } ?>
 -->
					</table>
					
					</div>
					
					<h4> Payslips </h4>


					<a href="temp_payslip" class="btn btn-info">   ( Jan 25, 2019) </a>

					<a href="temp_payslip1" class="btn btn-info"> ( Feb. 10, 2019) </a>

					{!! Form::close() !!}
					
 				
				</div>
				@if(isset($data['payperiod']))
				<div class="panel-body">
					<table class="table table-bordered">
						<tr>
							<th colspan="4" class="text-center">Employee Pay Summary</th>
						<tr>
						<tr>
							<th colspan="4"  class="text-center">Pay Slip for Pay Period {{isset($data['payperiod'])?$data['payperiod']:''}}</th>
						</tr>
						<tr>
							<td>Employee ID</td>
							<td>{{isset($user->employee_id)?$user->employee_id:''}}</td>
							<td>Employee Name</td>
							<td>{{isset($user->name)?$user->name:''}}</td>
						</tr>
						<tr>
							<td>Department</td>
							<td>{{isset($user->cost_center)?$user->cost_center:''}}</td>
							<td>Position</td>
							<td>{{isset($user->position)?$user->position:''}}</td>
						</tr>
						{{--<tr>
							<td>Employment Type</td>
							<td>{{isset($user->employment_type)?$user->employment_type:''}}</td>
							<td>Tax Status</td>
							<td>{{isset($user->taxstatusid)?$user->taxstatusid:''}}</td>
						</tr>--}}
						<tr>
							<td>Basic Pay</td>
							<td>{{isset($user->basic_pay)?$user->basic_pay:'0.00'}}</td>
							<td>Hourly Rate</td>
							<td>{{isset($user->hourly_rate)?$user->hourly_rate:'0.00'}}</td>
						</tr>
						<tr>
							<td colspan="4"></td>
						</tr>
						<tr>
							<td colspan="2" class="text-center">Earnings</td>
							<td colspan="2"  class="text-center">Deductions</td>
						</tr>
						<tr>
							<td>Basic Pay</td>
							<td>{{isset($user->basic_pay)?$user->basic_pay:'0.00'}}</td>
							<td>Late/Absences/Others</td>
							<td>{{isset($user->deductions)?$user->deductions:'0.00'}}</td>
						</tr>
						<tr>
							<td>Holiday Pay</td>
							<td>{{isset($user->holiday_pay)?$user->holiday_pay:'0.00'}}</td>
							<td>Loan Deductions</td>
							<td>{{isset($user->loan)?$user->loan:'0.00'}}</td>
						</tr>
						<tr>
							<td>Regular OT</td>
							<td>{{isset($user->regular_ot)?$user->regular_ot:'0.00'}}</td>
							<td>SSS</td>
							<td>{{isset($user->sss)?$user->sss:'0.00'}}</td>
						</tr>
						<tr>
							<td>6th Day OT</td>
							<td>{{isset($user->sixth_day_ot)?$user->sixth_day_ot:'0.00'}}</td>
							<td>PHIC</td>
							<td>{{isset($user->phic)?$user->phic:'0.00'}}</td>
						</tr>
						<tr>
							<td>7th Day OT</td>
							<td>{{isset($user->seventh_day_ot)?$user->seventh_day_ot:'0.00'}}</td>
							<td>HDMF</td>
							<td>{{isset($user->hdmf)?$user->hdmf:'0.00'}}</td>
						</tr>
						<tr>
							<td>Total ND</td>
							<td>{{isset($user->total_nd)?$user->total_nd:'0.00'}}</td>
							<td colspan="2"></td>
						</tr>
						<tr>
							<td>Non Taxable</td>
							<td>{{isset($user->total_non_tax_allowance)?$user->total_non_tax_allowance:'0.00'}}</td>
							<td colspan="2"></td>
						</tr>
						{{--<tr>
							<td>Taxable Other Income</td>
							<td>{{isset($user->total_tax_allowance)?$user->total_tax_allowance:'0.00'}}</td>
							<td>Tax</td>
							<td>{{isset($user->withold_tax)?$user->withold_tax:'0.00'}}</td>
						</tr>--}}
						<tr>
							<td>Taxable Income</td>
							<td>{{isset($user->gross_pay)?$user->gross_pay:'0.00'}}</td>
							<td colspan="2"></td>
						</tr>
						<tr>
							<td>Net Pay</td>
							<td>{{isset($user->net_pay)?$user->net_pay:'0.00'}}</td>
							<td colspan="2" class="text-center" >
								Employee Signature
							</td>
						</tr>
						<tr>
							<td colspan="4"></td>
						</tr>
						<tr>
							<td>Manual Adjustments</td>
							<td colspan="3">{{isset($user->manual_adjustment)?$user->manual_adjustment:'0.00'}}</td>
						</tr>
						<tr>
							<td>Allowwance</td>
							<td colspan="3">{{isset($user->allowance)?$user->allowance:'0.00'}}</td>
						</tr>
						<tr>
                                                        <td>Incentives</td>
                                                       	<td colspan="3">{{isset($user->incentive)?$user->incentive:'0.00'}}</td>
                                                </tr>
					</table>
				</div>
					{{--json_encode($user)--}}
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
