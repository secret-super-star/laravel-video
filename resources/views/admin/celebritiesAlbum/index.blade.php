@extends('admin.layouts.admin')

@section('title', 'Celebrity Album')
@section('headerButton')
	<input type="button" onclick="window.location='/admin/celebrity/new/album'" class="btn btn-success" style="float: right" value="Add Album">
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
				<th>Id</th>
				<th>Album Thumbnail</th>
				<th>Album Name</th>
				<th>Celebrity</th>
				<th>Published</th>
				<th>Created By</th>
				<th>Created</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			@if(count($albums ) < 1)
			<tr>
				<td colspan="5">No Album Found</td>
			</tr>
			@endif
			@foreach($albums as $val)
				<tr>
					<td width="2%">{{ $loop->index }}</td>
					<td><img src="{{ $val->thumbnail }}" alt="{{$val->name}}" style="width: 117px; height: 70px"></td>
					<td>{{ $val->name }}</td>
					<td>{{$val->celebrity->name or ''}}</td>
					<td>{{$val->publish >= 1 ? 'Published' : 'UnPublished'}}</td>
					<td>{{$val->createdByUser->name or ''}}</td>
					<td>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</td>
					<td>
						<a class="btn btn-xs btn-primary" href="/admin/celebrity/album/{{$val->id}}" data-toggle="tooltip" data-placement="top" data-title="Edit" data-original-title="" title="">
							<i class="fa fa-pencil"></i>
						</a>
						<a class="btn btn-xs btn-danger" href="#" data-toggle="tooltip" data-placement="top" data-title="Delete" data-original-title="" title="" onclick="var r = window.confirm('are you sure you want to delete this video?'); if(r==true){window.location='/admin/celebrity/deleteAlbum/{{$val->id}}'}">
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