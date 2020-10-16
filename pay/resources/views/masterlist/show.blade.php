@extends('default')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
		   <div class="panel panel-default">
			<div class="panel-heading">
				{{$masterlist->fullname}} - {{$masterlist->employeeid}}
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-6">
						<label>Associated Vicidial User</label>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>User</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($masterlist->vusers) && !empty($masterlist->vusers))
								@foreach($masterlist->vusers as $vuser)
								<tr>
									<td>{{$vuser}}</td>
									<td class="text-center">
										<a href=""><i class="fa fa-trash"></i></a>
									</td>
								</tr>
								@endforeach
								@endif
							</tbody>
						</table>
					</div>
					<div class="col-md-6">
						<label>Associate a Vici User <a href="/vici-users/create"><i class="fa fa-plus"></i></a></label>
						<input type="hidden" name="employeeid" value="{{$masterlist->employeeid}}">
						<select class="form-control" name="vici_user">
								
						</select>	
					</div>
				</div>
			</div>
		   </div>
		</div>
	</div>
</div>
@endsection