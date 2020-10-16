@extends('default')


@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Employee Masterlist</h2>
				</div>
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>EmployeeId</th>
								<th>Fullname</th>
								<th>Vicidial Users</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($masterlists as $masterlist)
							<tr>
								<td>{{$masterlist->employeeid}}</td>
								<td>{{$masterlist->fullname}}</td>
								<td>

								</td>
								<td>
									<a href="masterlist/{{$masterlist->employeeid}}"><i class="fa fa-eye"></i></a>
									<a href="masterlist/{{$masterlist->employeeid}}/edit"><i class="fa fa-edit"></i></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection