@extends('admin.layouts.admin')

@section('title', 'Video Group Categories')
@section('headerButton')
	<input type="button" onclick="window.location='/admin/new/video-group-categories'" class="btn btn-success" style="float: right" value="Add Video Group Categories">
@endsection

@section('content')
	
	<style>
		.table-responsive {
			overflow-x: inherit !important;
		}
		
		td {word-break: break-all}
	</style>
	<script src="{{asset('assets/admin/js/jquery-2.2.3.min.js')}}"></script>
	
	<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.css"/>
	<script type="text/javascript" src="{{asset('assets/admin/js/jquery.dataTables.js')}}"></script>
	
	
	<div class="row table-responsive">
		<table class="table table-striped table-bordered dt-responsive" id="example" cellspacing="0" width="100%" style="word-wrap:break-word;
              table-layout: fixed;">
			<thead>
			<tr>
				<th width="10%">Id</th>
				<th>Name</th>
				<th width="10%">Action</th>
			</tr>
			</thead>
			<tbody>
			@if(count($groupCategories ) < 1)
			<tr>
				<td colspan="5">No Video Groups Categories Found</td>
			</tr>
			@endif
			@foreach($groupCategories as $val)
				<tr>
					<td width="2%">{{ $loop->index }}</td>
					<td>{{$val->name}}</td>
					<td>
						<a class="btn btn-xs btn-primary" href="/admin/video-group-categories/{{$val->id}}" data-toggle="tooltip" data-placement="top" data-title="Edit" data-original-title="" title="">
							<i class="fa fa-pencil"></i>
						</a>
						<a class="btn btn-xs btn-danger" href="#" data-toggle="tooltip" data-placement="top" data-title="Delete" data-original-title="" title="" onclick="var r = window.confirm('are you sure you want to delete this video category?'); if(r==true){window.location='/admin/delete/video-group-categories/{{$val->id}}'}">
							<i class="fa fa-trash"></i>
						</a>
						
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		
		<script>
			$(function () {
        $('#example').dataTable();
      })
		</script>
		
	</div>
@endsection