@extends('app')

@section('title')
Payroll Import
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			@if(isset($message))
			<div class="ibox alert alert-success text-center">
				<strong>{{$message}}</strong>
			</div>
			@endif
			<div class="panel panel-default">
				<div class="panel-heading">
					Upload Payroll in (.csv) format
				</div>
				<div class="panel-body">
					{!! Form::open(array('action' => 'PayrollController@upload','files' => true)) !!}
					{!! Form::file('payroll'); !!}
					<br/>
					<div class="form-group">
						<button type="submit" class="btn btn-success">Upload</button>
					</div>
					{!! Form::close() !!}
				
</div>
</div>
</div>
</div>
@endsection
