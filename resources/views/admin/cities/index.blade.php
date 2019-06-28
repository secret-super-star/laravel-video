@extends('admin.layouts.admin')

@section('title', 'Cities')
@section('headerButton')
	<input type="button" onclick="window.location='/admin/new/city'" class="btn btn-success" style="float: right" value="Add City">
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
		<table class="table table-striped table-bordered dt-responsive nowrap" id="datatable_wrapper" cellspacing="0" width="100%">
			<thead class="sorted_head">
			<tr>
				<th>Id</th>
				<th>City Name</th>
				{{--<th>City Name ( اردو )</th>--}}
				<th>Places</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			@if(count($cities ) < 1)
			<tr>
				<td colspan="5">No Cities Found</td>
			</tr>
			@endif
			@foreach($cities as $city)
				<tr data-id="{{$city->id}}">
					<td> {{ $loop->index }} </td>
					<td> {{$city->name}} </td>
					{{--<td> {{$city->name_urd}} </td>--}}
					<td style="text-align: center">
						<a class="btn btn-xs btn-primary" href="places/{{$city->id}}" data-toggle="tooltip" data-placement="top" data-title="Places" data-original-title="" title="" >
							<i class="fa fa-list-alt"></i>
						</a>
					</td>
					<td>
						<a class="btn btn-xs btn-primary" href="cities/{{$city->id}}" data-toggle="tooltip" data-placement="top" data-title="Edit" data-original-title="" title="">
							<i class="fa fa-pencil"></i>
						</a>
						
						<a class="btn btn-xs btn-danger" href="cities/delete/{{$city->id}}" data-toggle="tooltip" data-placement="top" data-title="Delete" data-original-title="" title="" >
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