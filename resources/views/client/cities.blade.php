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
						$tagName = 'Cities';
					}
					?>
					
					<i class="fa fa-globe"> </i> Cities
				</div>
			</div>
			
			<div class="ipad">
				
				<div class="thumbnail row padings padings" >
					
					
					<div class="col-sm-12">
						@foreach(array_chunk($cities->all(), 4) as $city)
							<div class="col-sm-12">
								@foreach($city as $val)
									
									<div class="col-sm-3 catThum center cPointer" onclick="window.location='/city/{{str_replace(' ', '-', $val->name)}}'">
										<img src="{{$val->thumbnail}}"  alt="{{$val->name}}" class="w100p">
										<p class="colorWhite" >{{$val->name}}</p>
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
						@foreach($cities as $val)
							<div class="col-sm-3 catThum center cPointer" onclick="window.location='/city/{{str_replace(' ', '-', $val->name)}}'">
								<img src="{{$val->thumbnail}}" alt="{{$val->name}}" class="w100p"  onerror="this.src='{{asset('assets/client/images/banner.jpg')}}'">
								<p class="colorWhite">{{$val->name}}</p>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		
		{{$cities->links()}}
		</div>
		
		@include('client.categoriesAndTags')
	</div>
	
	{{--<script src="https://player.vimeo.com/api/player.js"></script>--}}

@endsection