@extends('admin.layouts.admin')

@section('title', 'Celebrities')
@section('headerButton')
	<input type="button" onclick="window.location='/admin/new/celebrity'" class="btn btn-success" style="float: right" value="Add Celebrity">
@endsection

@section('content')
	
	<style>
		.table-responsive {
			overflow-x: inherit !important;
		}
	</style>
	<script src="{{asset('assets/admin/js/jquery-2.2.3.min.js')}}"></script>
	
	<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.css"/>
	{{--<script type="text/javascript" src="http://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.js"></script>--}}
	<script type="text/javascript" src="{{asset('assets/admin/js/jquery.dataTables.js')}}"></script>
	
	
	<div class="row table-responsive">
		<table class="table table-striped table-bordered dt-responsive nowrap" id="example" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th>Id</th>
				<th>Image</th>
				<th>Name</th>
				{{--<th>Date of Birth</th>--}}
				{{--<th>Country</th>--}}
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			@if(count($celebrities ) < 1)
				<tr>
					<td colspan="5">No Celebrity Found</td>
				</tr>
			@endif
			@foreach($celebrities as $val)
				<tr>
					<td>{{ $loop->index }}</td>
					<td><img src="{{$val->image}}" alt="" style="width: 100px; height: 100px"></td>
					<td>{{ $val->name }}</td>
					{{--<td>{{ $val->dob }}</td>--}}
					{{--<td>{{ $val->country }}</td>--}}
					<td>
						<a class="btn btn-xs btn-primary" href="edit/{{strtolower(str_replace(' ', '-', $val->name))}}" data-toggle="tooltip" data-placement="top" data-title="Edit" data-original-title="" title="">
							<i class="fa fa-pencil"></i>
						</a>
						<a class="btn btn-xs btn-danger" onclick="var r = window.confirm('are you sure you want to delete this celebrity?'); if(r==true){window.location='/admin/celebrity/delete/{{$val->id}}'}" data-toggle="tooltip" data-placement="top" data-title="Delete" data-original-title="" title="" >
							<i class="fa fa-trash"></i>
						</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		
		<script>
      //      $(document).ready(function() {
      //        setTimeout(function () {
      //          $('#example').DataTable();
      //          alert()
      //        },3000)
      //      } );

      $(function () {
        $('#example').dataTable();
      })
		</script>
	
	</div>
@endsection