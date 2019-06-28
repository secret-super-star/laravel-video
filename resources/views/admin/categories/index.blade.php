@extends('admin.layouts.admin')

@section('title', 'Categories')
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
		
		tbody tr:hover {
			cursor: pointer;
		}
	</style>
	<div class="row table-responsive">
		<table class="table table-striped table-bordered dt-responsive nowrap sorted_table" id="datatable_wrapper" cellspacing="0" width="100%">
			<thead class="sorted_head">
			<tr>
				<th>Id</th>
				<th>Category Image</th>
				<th>Category Title</th>
				<th>Category Description</th>
				<th>SubCategories</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			@if(count($categories ) < 1)
			<tr>
				<td colspan="5">No Categories Found</td>
			</tr>
			@endif
			@foreach($categories as $cat)
				<tr data-id="{{$cat->id}}">
					<td>{{ $loop->index }}</td>
					<td>
						<img src="{{$cat->category_image}}" alt="{{$cat->category_title}}" style="width: 100px; height: 50px" >
					</td>
					<td>{{ $cat->category_title }}</td>
					<td>{{ $cat->category_description}}</td>
					<td style="text-align: center">
						<a class="btn btn-xs btn-primary" href="subcategories/{{$cat->id}}" data-toggle="tooltip" data-placement="top" data-title="Sub Categories" data-original-title="" title="" >
							<i class="fa fa-list-alt"></i>
						</a>
						{{--@foreach($cat->subCategories as $val)--}}
						{{--<img style="width: 60px; margin-bottom:5px;" src="{{asset('assets/uploads/categories/')}}/{{$val->category_image}}" alt="">--}}
						{{--@endforeach--}}
					</td>
					<td>
						<a class="btn btn-xs btn-primary" href="categories/{{$cat->id}}" data-toggle="tooltip" data-placement="top" data-title="Edit" data-original-title="" title="">
							<i class="fa fa-pencil"></i>
						</a>
						
						<a class="btn btn-xs btn-danger" href="category/{{$cat->id}}" data-toggle="tooltip" data-placement="top" data-title="Delete" data-original-title="" title="" >
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