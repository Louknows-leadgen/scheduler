@extends('app')

@section('content')

<div class="container">

	<div class="row">

		<div class="col-md-10 col-md-offset-1">

			<div class="panel panel-default">

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
							<td>{{isset($pay_info->employeeid)?$pay_info->employeeid:''}}</td>
							<td>Employee Name</td>
							<td>{{isset($pay_info->name)?$pay_info->name:''}}</td>
						</tr>
						<tr>
							<td>Department</td>
							<td>{{isset($pay_info->cost_center)?$pay_info->cost_center:''}}</td>
							<td>Position</td>
							<td>{{isset($pay_info->position)?$pay_info->position:''}}</td>
						</tr>
						{{--<tr>
							<td>Employment Type</td>
							<td>{{isset($pay_info->employmenttype)?$pay_info->employmenttype:''}}</td>
							<td>Tax Status</td>
							<td>{{isset($pay_info->taxstatusid)?$pay_info->taxstatusid:''}}</td>
						</tr>--}}
						<tr>
							<td>Basic Pay</td>
							<td>P {{isset($pay_info->basicpay)? number_format($pay_info->basicpay, 2):'0.00'}}</td>
							<td>Hourly Rate</td>
							<td>P {{isset($pay_info->hourlyrate)? number_format($pay_info->hourlyrate, 2):'0.00'}}</td>
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
							<td>P {{isset($pay_info->basicpay)? number_format($pay_info->basicpay, 2):'0.00'}}</td>
							<td>Late/Absences/Others</td>
							<td>P {{isset($pay_info->deductions)? number_format($pay_info->deductions, 2):'0.00'}}</td>
						</tr>
						<tr>
							<td>Holiday Pay</td>
							<td>P {{isset($pay_info->holiday_pay)? number_format($pay_info->holiday_pay, 2):'0.00'}}</td>
							<td>Loan Deductions</td>
							<td>P {{isset($pay_info->loandeductions)? number_format($pay_info->loandeductions, 2):'0.00'}}</td>
						</tr>
						<tr>
							<td>Regular OT</td>
							<td>P {{isset($pay_info->regot)? number_format($pay_info->regot, 2):'0.00'}}</td>
							<td>SSS</td>
							<td>P{{isset($pay_info->sss)? number_format($pay_info->sss, 2):'0.00'}}</td>
						</tr>
						<tr>
							<td>6th Day OT</td>
							<td>P {{isset($pay_info->sixthdayOT)? number_format($pay_info->sixthdayOT, 2):'0.00'}}</td>
							<td>PHIC</td>

							<td>P {{isset($pay_info->phic)? number_format($pay_info->phic, 2):'0.00'}}</td>
						</tr>
						<tr>
							<td>7th Day OT</td>
							<td>P {{isset($pay_info->seventhdayOT)? number_format($pay_info->seventhdayOT, 2):'0.00'}}</td>
							<td>HDMF</td>
							<td>P {{isset($pay_info->hdmf)? number_format($pay_info->hdmf, 2):'0.00'}}</td>
						</tr>
						<tr>
							<td>Total ND</td>
							<td>P {{isset($pay_info->totalnd)? number_format($pay_info->totalnd, 2):'0.00'}}</td>
							<td colspan="2"></td>
						</tr>
						<tr>
							<td>Non Taxable</td>
							<td>P {{isset($pay_info->nontaxable) ? number_format($pay_info->nontaxable, 2):'0.00'}}</td>
							<td colspan="2"></td>
						</tr>
						{{--<tr>
							<td>Taxable Other Income</td>
							<td>P {{isset($pay_info->taxableotherinc) ? number_format($pay_info->taxableotherinc, 2):'0.00'}}</td>
							<td>Tax</td>
							<td>P {{isset($pay_info->tax)? number_format($pay_info->tax, 2):'0.00'}}</td>
						</tr>--}}
						<tr>
							<td>Taxable Income</td>
							<td>P {{isset($pay_info->taxableincome)? number_format($pay_info->taxableincome, 2):'0.00'}}</td>
							<td colspan="2"></td>
						</tr>
						<tr>
							<td>Net Pay</td>
							<td>P {{isset($pay_info->netpay)? number_format($pay_info->netpay, 2):'0.00'}}</td>
							<td colspan="2" class="text-center" >
								Employee Signature
							</td>
						</tr>
						<tr>
							<td colspan="4"></td>
						</tr>
						<tr>
							<td>Manual Adjustments</td>
							<td colspan="3">P {{isset($pay_info->manual_adjustment)? number_format($pay_info->manual_adjustment, 2):'0.00'}}</td>
						</tr>
						<tr>
							<td>Allowance</td>
							<td colspan="3">P {{isset($pay_info->allowance)? number_format($pay_info->allowance, 2):'0.00'}}</td>
						</tr>
						<tr>
                                                        <td>Incentives</td>
                                                       	<td colspan="3">P {{isset($pay_info->incentive)? number_format($pay_info->incentive, 2):'0.00'}}</td>
                                                </tr>
					</table>
				</div>
 				@endif
			</div>
	
	{!! Form::open(array('action' => 'HomeController@new_payslip', 'target'=> '_new')) !!}

		<button type = "submit" class="btn btn-info"> New Payslip  </button>

		<input type="hidden" name = "payperiod" value="{{isset($data['payperiod'])?$data['payperiod']:''}}">
		
	{!! Form::close() !!}

	</div>

</div>

</div>

@endsection
