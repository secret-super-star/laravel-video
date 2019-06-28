@extends('client.layouts.app')

@section('content')

	<div class="row">
		<div class="col-sm-9">
			
			
			@include('client.includes.add1')
			
			
			<div class="row panel panel-default subCatView">
				<div class="panel-heading">
					<?php
					try {
						$tagName = ucfirst($categoriesName->category_title);
					} catch(\Exception $e) {
						$tagName = 'Category Name';
					}
					?>
						@if(\Request::path() == 'categories')
							<i class="fa fa-tag"> </i> All Categories
							
						@else
					<i class="fa fa-tag"> </i> {{ isset($tagName) ? $tagName : 'Videos'}} ==> Sub Categories
						@endif
				</div>
			</div>
			
			<div class="ipad">
				
				<div class="thumbnail row padings padings" >
					
					
					<div class="col-sm-12">
						@foreach(array_chunk($subCategories->all(), 4) as $subCat)
							<div class="col-sm-12">
								@foreach($subCat as $val)
									<div class="col-sm-3 catThum center cPointer" onclick="window.location='/category/{{str_replace(' ', '-', $val->category_title)}}'">
										<img src="{{$val->category_image}}"  alt="{{$val->category_title}}" class="w100p">
										<p class="colorWhite" >{{$val->category_title}}</p>
									</div>
								@endforeach
							</div>
						@endforeach
					</div>
				
				</div>
			</div>

			
			<div class="nonipad">
				
				<div class="thumbnail row padings padings" >
					
					<div class="col-sm-12">
						@foreach($subCategories as $val)
							<div class="col-sm-3 catThum center cPointer" onclick="window.location='/category/{{str_replace(' ', '-', $val->category_title)}}'">
								<img src="{{$val->category_image}}" alt="{{$val->category_title}}" class="w100p">
								<p class="colorWhite">{{$val->category_title}}</p>
							</div>
						@endforeach
					</div>
				
				</div>
			</div>
		
		
		</div>
		
		@include('client.categoriesAndTags')
	</div>
	
	{{--<script src="https://player.vimeo.com/api/player.js"></script>--}}

@endsection