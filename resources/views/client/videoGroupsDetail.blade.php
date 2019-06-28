@extends('client.layouts.app')

@section('content')
	
	<div class="row">
		<div class="col-sm-9">
			
			
			@include('client.includes.add1')
			
			<div class="row panel panel-default catVideoPanel" >
				<div class="panel-heading">
							<i class="fa fa-tag"> </i> {{isset($groupName) ? ucfirst($groupName) : 'Watch Videos Groups'}}
				</div>
			</div>
			
			<div class="thumbnail row padings padings" >
				@if(count($series) < 1)
					<span class="colorWhite">No Video Found Under This Category..!</span>
				@endif
					@foreach(array_chunk($series->all(), 4) as $seriesVideos)
						<div class="col-sm-12">
						@foreach($seriesVideos as $val)
							
								<input type="hidden" id="linkMe_{{$val->seriesDetail->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', $val->seriesDetail->link))}}">
						<div class="col-sm-12 col-md-3 cPointer" onclick="redirectMe('{{$val->seriesDetail->id}}')">
							<div class="thumbnail">
								<div align="center" class="embed-responsive embed-responsive-16by9">
									<img src="{{$val->seriesDetail->thumbnail}}" alt="{{$val->seriesDetail->name}}" onerror="this.src='{{asset('assets/client/images/thumb.png')}}'" class="w100p">
									@if($val->duration > 0)
									<div class="duration">{{$val->getMSDuration()}}</div>
									@endif
								</div>
								<div class="caption colorDarkGray">
									<h3>{{strlen($val->seriesDetail->name) > 45 ? substr($val->seriesDetail->name,0,45)."..." : $val->seriesDetail->name}}</h3>
									<p>
										<span>{{$val->seriesDetail->createdByUser->name or ''}}&nbsp</span>
										<span>{{\Carbon\Carbon::parse($val->updated_at)->diffForHumans()}}</span>
									</p>
								</div>
							</div>
						</div>
						@endforeach
						</div>
					@endforeach
			</div>
			
		
		</div>
		
		@include('client.categoriesAndTags')
	</div>
	
	{{--<script src="https://player.vimeo.com/api/player.js"></script>--}}

@endsection