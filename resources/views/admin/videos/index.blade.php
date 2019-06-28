@extends('admin.layouts.admin')

@section('title', 'Videos')
@section('headerButton')
	<input type="button" onclick="window.location='/admin/new/video'" class="btn btn-success" style="float: right" value="Add Videos">
@endsection

@section('content')

	<style>
		.table-responsive {
			overflow-x: inherit !important;
		}

		td {word-break: break-all}

		.pagination {
			margin-left: 30%;
		}
	</style>
	<script src="{{asset('assets/admin/js/jquery-2.2.3.min.js')}}"></script>

	<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.css"/>
	{{--<script type="text/javascript" src="http://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.js"></script>--}}
	<script type="text/javascript" src="{{asset('assets/admin/js/jquery.dataTables.js')}}"></script>


	<div class="row table-responsive">
		<br/>
		<br/>
		<div class="col-md-3" style="float: right">
			<input type="text" class="form-control" placeholder="Search" id="searchVideos">
		</div>
		<div class="col-md-12" id="listing">
			<table class="table table-striped table-bordered dt-responsive" id="example" cellspacing="0" width="100%" style="word-wrap:break-word;
              table-layout: fixed;">
				<thead>
				<tr>
					<th>Id</th>
					<th>Image</th>
					<th>Series Name</th>
					<th>Category</th>
					<th>Status</th>
					<th>Views Count</th>
					<th>Create By</th>
					<th>Create</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				@if(count($series) < 1)
					<tr>
						<td colspan="5">No Video Found</td>
					</tr>
				@endif
				@foreach($series as $val)
					@php
						$color = $val->publish >= 1 ? 'label label-success' : 'label label-danger';
                        $text = $val->publish >= 1 ? 'Published' : 'UnPublished';
					@endphp
					<tr>
						<td width="2%">{{ (int)$loop->index +1 }}</td>
						<td><img src="{{ $val->thumbnail }}" alt="{{$val->name}}" style="width: 100%; height: 70px"></td>
						<td>{{ $val->name }}</td>
						<td>{{$val->seriesCategory->categoryDetail->category_title or ''}}</td>
						<td>
							<p class="{{$color}}">{{$text}}</p>
						</td>
						<td>{{count($val->videoViews)}}</td>
						<td>{{$val->createdByUser->name or ''}}</td>
						<td>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</td>
						<td>
							<a class="btn btn-xs btn-primary" href="/admin/videos/{{$val->id}}" data-toggle="tooltip" data-placement="top" data-title="Edit" data-original-title="" title="">
								<i class="fa fa-pencil"></i>
							</a>
							{{--/admin/video/{{$val->id}}--}}
							<a class="btn btn-xs btn-danger" href="#" data-toggle="tooltip" data-placement="top" data-title="Delete" data-original-title="" title="" onclick="var r = window.confirm('are you sure you want to delete this video?'); if(r==true){window.location='/admin/video/{{$val->id}}'}">
								<i class="fa fa-trash"></i>
							</a>

							<a class="btn btn-xs btn-primary" href="#" data-toggle="tooltip" data-placement="top" data-title="Send Notification" data-original-title="" title="" onclick="window.location='/admin/sendNotification/?series_id={{$val->id}}'">
								<i class="fa fa-bell"></i>
							</a>

						</td>
					</tr>
				@endforeach
				</tbody>

			</table>
			{{$series->links()}}

		</div>

		<script src="https://content.jwplatform.com/libraries/JnL07XOZ.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.6/handlebars.js"></script>

		{{--<div id="myDiv">This text will be replaced with a player.</div>--}}
		{{--<script>--}}
		{{--jwplayer("myDiv").setup({--}}
		{{--"file": "http://storage.ahsanhussain.info/storage/q.mp4",--}}
		{{--"image": "http://example.com/myImage.png",--}}
		{{--"height": 360,--}}
		{{--"width": 640,--}}
		{{--autostart: false--}}
		{{--});--}}
		{{--</script>--}}

		<script>
			$(function () {
				$('#searchVideos').on('keyup', function(){
					console.log($(this).val());

					$.ajax({
						url: '/api/search/video?name='+$(this).val(),
						type: 'GET',
						headers: {
							'X-CSRF-TOKEN': '{{ csrf_token() }}'
						},
						success: function(result){
							console.log((result));
							$('#listing').html("")
							$('#listing').html(result)
						},
						error: function (jqXHR, textStatus, errorThrown) {
							console.log(errorThrown);
						}
					});
				})
			})
		</script>

	</div>
@endsection