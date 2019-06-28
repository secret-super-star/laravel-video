@extends('admin.layouts.admin')

@section('title', 'Tags')
@section('headerButton')
	<input type="button" onclick="window.location='/admin/new/tags'" class="btn btn-success" style="float: right" value="Add Tags">
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
				<th>Tag</th>
				<th>Tag Description</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			@if(count($tags ) < 1)
			<tr>
				<td colspan="5">No Tag Found</td>
			</tr>
			@endif
			@foreach($tags as $val)
				<tr>
					<td>{{ $loop->index }}</td>
					<td>{{ $val->tag }}</td>
					<td>{{ $val->tag_description }}</td>
					<td>
						<a class="btn btn-xs btn-primary" href="tags/{{$val->id}}" data-toggle="tooltip" data-placement="top" data-title="Edit" data-original-title="" title="">
							<i class="fa fa-pencil"></i>
						</a>
						<a class="btn btn-xs btn-danger" href="tag/{{$val->id}}" data-toggle="tooltip" data-placement="top" data-title="Delete" data-original-title="" title="" >
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