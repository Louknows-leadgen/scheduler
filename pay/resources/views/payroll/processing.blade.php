@extends('app')

@section('title')
Payroll Import Processing
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					Processing file <u>{{$request->file('payroll')->getClientOriginalName()}}</u>
				</div>
				<div class="panel-body">
					{!! Form::open(array('action' => 'PayrollController@upload','files' => true)) !!}
					{!! Form::hidden('datas',$datas) !!}
					<div class="form-group">
						<div class="row">
						<div class="col-md-5">
							<label>Payperiod</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('payperiod', $payperiods, null,array('class'=>'form-control')); !!}
						</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
						<div class="col-md-5">
							<label>Employee ID</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('employee_id', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Last Name</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('last_name', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>First Name</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('first_name', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Cost Center</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('cost_center', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Basic Pay</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('basic_pay', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Holiday Pay</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('holiday_pay', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Regular OT</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('regular_ot', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>6th Day OT</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('6th_day_ot', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>7th Day OT</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('7th_day_ot', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Total Night Diff</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('total_nd', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Allowance</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('allowance', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Manual Adjusment</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('manual_adjustment', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Total Non Tax Allowance</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('total_non_tax_allowance', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Total Tax Allowance</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('total_tax_allowance', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Deductions</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('deductions', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>

					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Loan</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('loan', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>SSS</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('sss', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Philhealth</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('phic', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>HDMF</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('hdmf', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Withholding Tax</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('withhold_tax', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Gross Pay</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('gross_pay', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Net Pay</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('net_pay', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>After Release</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('after_release', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Disputes</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('disputes', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Incentive</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('incentive', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<div class="form-group"><div class="row">
						<div class="col-md-5">
							<label>Taxable Income</label>
						</div>
						<div class="col-md-5">
							{!! Form::select('taxable_income', [''=> '( none )'] + $fields, null,array('class'=>'form-control')); !!}
						</div></div>
					</div>
					<br/>
					<div class="form-group">
						<button type="submit" class="btn btn-success">Process</button>
					</div>
					{!! Form::close() !!}
				
</div>
</div>
</div>
</div>
@endsection
