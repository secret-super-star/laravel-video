@extends('admin.layouts.admin')

@section('title')
{{$categories->category_title}}
@endsection
@section('headerButton')
	<input type="button" onclick="window.location='/admin/new/categories'" class="btn btn-success" style="float: right" value="Add Category   ">
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
		<table class="table table-striped table-bordered dt-responsive nowrap " id="datatable_wrapper" cellspacing="0" width="100%">
			<thead class="sorted_head">
			<tr>
				<th>Id</th>
				<th>Category Image</th>
				<th>Category Title</th>
				<th>Category Description</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			@if(count($categories ) < 1)
			<tr>
				<td colspan="5">No Categories Found</td>
			</tr>
			@endif
			@foreach($categories->subCategories as $cat)
				<tr data-id="{{$cat->id}}">
					<td>{{ $loop->index }}</td>
					<td><img src="{{$cat->category_image}}" alt="{{ $cat->category_title}}" style="width: 100px; height: 50px" ></td>
					<td>{{ $cat->category_title }}</td>
					<td>{{ $cat->category_description}}</td>
					<td>
						<a class="btn btn-xs btn-primary" href="/admin/categories/{{$cat->id}}" data-toggle="tooltip" data-placement="top" data-title="Edit" data-original-title="" title="">
							<i class="fa fa-pencil"></i>
						</a>
						<a class="btn btn-xs btn-danger" href="/admin/category/{{$cat->id}}" data-toggle="tooltip" data-placement="top" data-title="Delete" data-original-title="" title="" >
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