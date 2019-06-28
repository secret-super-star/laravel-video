@extends('admin.layouts.admin')

@section('title', 'Places')
@section('headerButton')
	<input type="button" onclick="window.location='/admin/new/place'" class="btn btn-success" style="float: right" value="Add Place">
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
				<th>Places Name</th>
				{{--<th>Places Name ( اردو )</th>--}}
				<th>City Name</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			@if(count($places ) < 1)
			<tr>
				<td colspan="5">No Places Found</td>
			</tr>
			@endif
			@foreach($places as $city)
				<tr>
					<td> {{ $loop->index }} </td>
					<td> {{$city->name or ''}} </td>
{{--					<td> {{$city->name_urd or ''}} </td>--}}
					<td> {{$city->city->name or ''}} </td>
					<td>
						<a class="btn btn-xs btn-primary" href="/admin/places/edit/{{$city->id}}" data-toggle="tooltip" data-placement="top" data-title="Edit" data-original-title="" title="">
							<i class="fa fa-pencil"></i>
						</a>
						
						<a class="btn btn-xs btn-danger" href="/admin/places/delete/{{$city->id}}" data-toggle="tooltip" data-placement="top" data-title="Delete" data-original-title="" title="" >
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