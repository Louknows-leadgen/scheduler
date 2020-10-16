@extends('app')


@section('content')
	<div class="container">
	   <div class="row">
		<div class="col-md-10 col-md-offset-1">
		    <div class="panel panel-default">
			<div class="panel-heading">
				<label>Vici Users</label>
			</div>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>User</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($viciusers as $user)
					<tr>
						<td>{{$user->id}}</td>
						<td>{{$user->dci_vici_user}}</td>
						<td>
							<a href="vici-users/{{$user->id}}"><i class="fa fa-eye"></i></a>
							<a href="vici-users/{{$user->id}}/edit"><i class="fa fa-edit"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		    </div>
		</div>
  	    </div>
	</div>
@endsection