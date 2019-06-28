@extends('admin.layouts.admin')

@section('title', 'Combination Images')
@section('headerButton')
	<input type="button" onclick="window.location='/admin/new/combination-images'" class="btn btn-success" style="float: right" value="Add Image">
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
		
		tbody tr:hover {
			cursor: pointer;
		}
	</style>
	<div class="row table-responsive">
		<table class="table table-striped table-bordered dt-responsive nowrap sorted_table" id="datatable_wrapper" cellspacing="0" width="100%">
			<thead class="sorted_head">
			<tr>
				<th>Id</th>
				<th>City Name</th>
				<th>Place Name</th>
				<th>Image</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			@if(count($data ) < 1)
			<tr>
				<td colspan="5">No Data Found</td>
			</tr>
			@endif
			@foreach($data as $val)
				<tr data-id="{{$val->id}}">
					<td> {{ $loop->index }} </td>
					<td> {{$val->cityDetail->name}} </td>
					<td> {{$val->placeDetail->name or 'N/A'}} </td>
					<td style="text-align: center">
						<img src="{{$val->image}}" alt="" style="width: 100px">
					</td>
					<td>
						<a class="btn btn-xs btn-primary" href="combination-images/{{$val->id}}" data-toggle="tooltip" data-placement="top" data-title="Edit" data-original-title="" title="">
							<i class="fa fa-pencil"></i>
						</a>
						{{--<a class="btn btn-xs btn-primary" href="combination-images/delete/{{$val->id}}" data-toggle="tooltip" data-placement="top" data-title="Edit" data-original-title="" title="">--}}
							{{--<i class="fa fa-trash"></i>--}}
						{{--</a>--}}

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