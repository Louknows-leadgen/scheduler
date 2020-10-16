@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
			
				<div class="panel-body">
					<table class="table table-bordered">
						<tr>
							<th colspan="4" class="text-center">Employee Pay Summary</th>
						<tr>
						<tr>
							<th colspan="4"  class="text-center">Pay Slip for Pay Period {{isset($user->payperiod)?$user->payperiod:''}} </th>
						</tr>
						<tr>
							<td>Employee ID</td>
							<td>{{isset($user->employeeid)?$user->employeeid:''}}</td>
							<td>Employee Name</td>
							<td>{{isset($user->name)?$user->name:''}}</td>
						</tr>
						<tr>
							<td>Department</td>
							<td>{{isset($user->costcenter)?$user->costcenter:''}}</td>
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
							<td>{{isset($user->basicpay)?$user->basicpay:'0.00'}}</td>
							<td>Hourly Rate</td>
							<td>{{isset($user->hourlyrate)?$user->hourlyrate:'0.00'}}</td>
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
							<td>{{isset($user->basicpay)?$user->basicpay:'0.00'}}</td>
							<td>Late/Absences/Others</td>
							<td>{{isset($user->deductions)?$user->deductions:'0.00'}}</td>
						</tr>
						<tr>
							<td>Holiday Pay</td>
							<td>{{isset($user->holidaypay)?$user->holidaypay:'0.00'}}</td>
							<td>Loan Deductions</td>
							<td>{{isset($user->loandeductions)?$user->loandeductions:'0.00'}}</td>
						</tr>
						<tr>
							<td>Regular OT</td>
							<td>{{isset($user->regot)?$user->regot:'0.00'}}</td>
							<td>SSS</td>
							<td>{{isset($user->sss)?$user->sss:'0.00'}}</td>
						</tr>
						<tr>
							<td>6th Day OT</td>
							<td>{{isset($user->sixthdayOT)?$user->sixthdayOT:'0.00'}}</td>
							<td>PHIC</td>
							<td>{{isset($user->phic)?$user->phic:'0.00'}}</td>
						</tr>
						<tr>
							<td>7th Day OT</td>
							<td>{{isset($user->seventhdayOT)?$user->seventhdayOT:'0.00'}}</td>
							<td>HDMF</td>
							<td>{{isset($user->hdmf)?$user->hdmf:'0.00'}}</td>
						</tr>
						<tr>
							<td>Total ND</td>
							<td>{{isset($user->totalnd)?$user->totalnd:'0.00'}}</td>
							<td colspan="2"></td>
						</tr>
						<tr>
							<td>Non Taxable</td>
							<td>{{isset($user->nontaxable)?$user->nontaxable:'0.00'}}</td>
							<td colspan="2"></td>
						</tr>
						{{--<tr>
							<td>Taxable Other Income</td>
							<td>{{isset($user->total_tax_allowance)?$user->total_tax_allowance:'0.00'}}</td>
							<td>Tax</td>
							<td>{{isset($user->tax)?$user->tax:'0.00'}}</td>
						</tr>--}}
						<tr>
							<td>Taxable Income</td>
							<td>{{isset($user->gross_pay)?$user->gross_pay:'0.00'}}</td>
							<td colspan="2"></td>
						</tr>
						<tr>
							<td>Net Pay</td>
							<td>{{isset($user->netpay)?$user->netpay:'0.00'}}</td>
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
							<td>Allowance</td>
							<td colspan="3">{{isset($user->allowance)?$user->allowance:'0.00'}}</td>
						</tr>
						<tr>
                                                        <td>Incentives</td>
                                                       	<td colspan="3">{{isset($user->incentive)?$user->incentive:'0.00'}}</td>
                                                </tr>
					</table>
				</div>
					{{--json_encode($user)--}}
			</div>
		</div>
	</div>
</div>
@endsection
