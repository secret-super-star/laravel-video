@extends('admin.layouts.admin')

@section('title', 'Video Groups')
@section('headerButton')
	<input type="button" onclick="window.location='/admin/new/video-groups'" class="btn btn-success" style="float: right" value="Add Video Group">
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
				<th>Group Thumbnail</th>
				<th>Group Name</th>
				<th>Group Category</th>
				<th>Date Recorded</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			@if(count($groups ) < 1)
			<tr>
				<td colspan="5">No Video Groups Found</td>
			</tr>
			@endif
			@foreach($groups as $val)
				@php
				try {
					$category = $val->category->categoryDetail->name;
				} catch(\Exception $e) {
					$category = 'N/A';
				}
				@endphp
				<tr>
					<td width="2%">{{ $loop->index }}</td>
					<td><img src="{{ $val->thumbnail }}" alt="{{$val->name}}" style="width: 117px; height: 70px"></td>
					<td>{{ $val->name }}</td>
					<td>{{ $category}}</td>
					<td>{{$val->date_recorded or ''}}</td>
					<td>
						<a class="btn btn-xs btn-primary" href="/admin/video-groups/{{$val->id}}" data-toggle="tooltip" data-placement="top" data-title="Edit" data-original-title="" title="">
							<i class="fa fa-pencil"></i>
						</a>
						<a class="btn btn-xs btn-danger" href="#" data-toggle="tooltip" data-placement="top" data-title="Delete" data-original-title="" title="" onclick="var r = window.confirm('are you sure you want to delete this video?'); if(r==true){window.location='/admin/delete/video-groups/{{$val->id}}'}">
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