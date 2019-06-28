@extends('client.layouts.app')

@section('content')

	<div class="col-md-12 biggerBadgeParent">
		<a href="#">
			@if(isset($groupCategories))
			@foreach($groupCategories as $val)
				<span class="badge cHand biggerBadge" onclick="window.location='/groups/category/{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}'">{{$val->name}}</span>
			@endforeach
			@endif
			@if(isset($places))
			@foreach($places as $val)
				<span class="badge cHand biggerBadge"
					  onclick="window.location='/city/{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->name)))}}'">{{$val->name}}</span>
			@endforeach
			@endif
		</a>
	</div>

	<div class="row">
		<div class="col-sm-9">
			
			
			@include('client.includes.add1')
			
			<div class="row panel panel-default catVideoPanel" >
				<div class="panel-heading">
							<i class="fa fa-tag"> </i> {{isset($cityName) ? $cityName . ' -' : ''}} Watch Videos Groups
				</div>
			</div>
			
			<div class="thumbnail row padings padings" >
				@if(count($series) < 1)
					<span class="colorWhite">No Video Found Under This Category..!</span>
				@endif
					@foreach(array_chunk($series->all(), 4) as $seriesVideos)
						<div class="col-sm-12">
						@foreach($seriesVideos as $val)
						
								<input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', $val->link))}}">
						<div class="col-sm-12 col-md-3">
							<div class="thumbnail">
								<div align="center" class="embed-responsive embed-responsive-16by9 cPointer" onclick="redirectMeForGroup('{{$val->id}}')">
									<img src="{{$val->thumbnail}}" alt="{{$val->name}}" onerror="this.src='{{asset('assets/client/images/thumb.png')}}'" class="w100p">
									@if($val->duration > 0)
									<div class="duration">{{$val->getMSDuration()}}</div>
									@endif
								</div>
								<div class="caption colorDarkGray fn14">
									<h3 class="cPointer">{{strlen($val->name) > 45 ? substr($val->name,0,45)."..." : $val->name}}</h3>
									<p>
										@php
											$city = isset($val->cities->name) ? trim($val->cities->name) : '';
											$places = isset($val->places->name) ? $val->places->name : '';
										  $separator = strlen($places) > 0 ? ',' : '';
										@endphp

										<span class="cPointer" onclick="window.location='/city/{{str_replace(' ', '-', $city)}}'">{{$city}}{{$separator}}</span>
										<span class="cPointer" onclick="window.location='/city/{{str_replace(' ', '-', $places)}}'">{{$places}}</span>
									</p>
								</div>
							</div>
						</div>
						@endforeach
						</div>
					@endforeach

				{{$series->links()}}
			</div>
			
		
		</div>
		
		@include('client.categoriesAndTags')
	</div>
	
	{{--<script src="https://player.vimeo.com/api/player.js"></script>--}}

@endsection