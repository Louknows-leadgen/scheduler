@extends('app')

@section('content')

<style type="text/css">
	
	td{
		text-align: center;
	}

</style>

<div class="container">
	
	<h4> <center> Employee ID: {{ Auth::user()->employee_id }} </h4> </center>

	<div class="row">

		<div class="col-md-10 col-md-offset-1">

			<div class="panel panel-default">

				<div class="panel-heading">

					<div class="row">
					
					
					<div class="col-md-12">

							<div class="form-group">

								<h4> <center> Pay Slip History 
										<i class="fa fa-money-bill-alt"></i> 
									</center> 
								</h4>

							</div>

					</div>

					<table class="table table-striped">
					
							<?php foreach($payperiods as $payperiods_row): ?>
							

								<tr><td>{{ date("M d, Y", strtotime($payperiods_row->payperiod)) }} 

									<td>
										{!! Form::open(array('action' => 'HomeController@new_payslip')) !!}

										<button type="submit" class="btn btn-info" >
										 	View 
										</button>
										
										<input type="hidden" name = "payperiod" value="{{ $payperiods_row->payperiod }}">
								
										{!! Form::close() !!}

										<?php if (Auth::user()->employee_id == "201700246"){ ?>
											
										 <td><a href="#" class="btn btn-info"> View Attendance </a>
 										
 										<?php } ?>

							<?php endforeach; ?>

					</table>
					
					</div> 

					
 				
				</div>
			
			</div>
		</div>
	</div>
</div>
@endsection
