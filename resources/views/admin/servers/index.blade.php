@extends('admin.layouts.admin')

@section('title', 'Servers')
@section('headerButton')
	<input type="button" onclick="window.location='/admin/new/server'" class="btn btn-success" style="float: right" value="Add Server">
@endsection

@section('content')
	
	<style>
		.table-responsive {
			overflow-x: inherit !important;
		}
		
		body.dragging, body.dragging * {
			cursor: move !important;
		}
		
		.dragged {
			position: absolute;
			opacity: 0.5;
			z-index: 2000;
		}
		
		ol.example li.placeholder {
			position: relative;
			/** More li styles **/
		}
		ol.example li.placeholder:before {
			position: absolute;
			/** Define arrowhead **/
		}
		
	</style>
	<div class="row table-responsive">
		<table class="table table-striped table-bordered dt-responsive nowrap" id="datatable_wrapper" cellspacing="0" width="100%">
			<thead class="sorted_head">
			<tr>
				<th>Id</th>
				<th>Server IP</th>
				<th>Server Port</th>
				<th>Server User</th>
				<th>Server Password</th>
				<th>Server Status</th>
				<th>SFTP Connection Status</th>
				<th>RUN SFTP Test</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			@if(count($servers) < 1)
			<tr>
				<td colspan="5">No Categories Found</td>
			</tr>
			@endif
			@foreach($servers as $server)
				<tr data-id="{{$server->id}}">
					<td>{{ $loop->index }}</td>
					<td>{{ $server->ip}}</td>
					<td>{{ $server->port}}</td>
					<td>{{ $server->user}}</td>
					<td>
						<span class="passwordDiv_{{$server->id}}" style="display: none">{{ $server->password}}</span>
						<span class="passwordDiv_{{$server->id}}">******</span>
						<span onclick="$('.passwordDiv_{{$server->id}}').toggle(); $(this).hide()" style="color: blue;">Show</span>
					</td>
					<?php
						if ($server->active && $server->active == 1 ) {
							$c = 'green';
							$t = 'Active';
						} else {
							$c = 'red';
							$t = 'InActive';
						}
					?>
					<td style="color: {{$c}}">{{ $t }}</td>
					<?php
					if (!$server->sftp_status || $server->sftp_status == 'NULL' || $server->sftp_status == NULL  ) {
						$cs = 'orange';
						$ts = 'Status Never Checked';
					} else if ($server->sftp_status && $server->sftp_status == 1 ) {
						$cs = 'green';
						$ts = 'Successful';
					} else if ($server->sftp_status && $server->sftp_status == 2 ) {
						$cs = 'red';
						$ts = 'Failure';
					}
					?>
					<td style="color: {{$cs}}" id="server_sftp_status_{{$server->id}}">{{ $ts }}</td>
					
					<td>
						<input type="text" class="btn btn-success" value="Retest SFTP" onclick="reTest('{{$server->id}}')" style="width: 110px">
					</td>
					
					<td>
						<a class="btn btn-xs btn-primary" href="servers/{{$server->id}}" data-toggle="tooltip" data-placement="top" data-title="Edit" data-original-title="" title="">
							<i class="fa fa-pencil"></i>
						</a>
						
						<a class="btn btn-xs btn-danger" href="server/{{$server->id}}" data-toggle="tooltip" data-placement="top" data-title="Delete" data-original-title="" title="" >
							<i class="fa fa-trash"></i>
						</a>
						
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		
	</div>
	<script>
    window.token = '{{csrf_token()}}'
	</script>
@endsection