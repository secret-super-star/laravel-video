@extends('client.layouts.app')

@section('content')
	
	<div class="row">
		<div class="col-sm-9">
			
			
			@include('client.includes.add1')
			
			<div class="row panel panel-default catVideoPanel" >
				<div class="panel-heading">
					<?php
					try {
						$tagName = $series[0]->albumDetail->name;
					} catch(\Exception $e) {
						$tagName = 'Category Name';
					}
					?>
					@if(\Request::path() == 'watch')
							<i class="fa fa-tag"> </i> Watch Videos
					@else
							<i class="fa fa-video-camera"> </i> Album: {{ isset($tagName) ? $tagName : 'Videos'}}
					@endif
				</div>
			</div>
			
			<div class="thumbnail row padings padings" >
				@if(count($series) < 1)
					<span class="colorWhite">No Video Found Under This Category..!</span>
				@endif
					@foreach(array_chunk($series->all(), 4) as $seriesVideos)
						<div class="col-sm-12">
						@foreach($seriesVideos as $val)
								<input type="hidden" id="linkMe_{{$val->seriesDetailSingle->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', $val->seriesDetailSingle->link))}}">
						<div class="col-sm-12 col-md-3 cPointer" onclick="redirectMe('{{$val->seriesDetailSingle->id}}')">
							<div class="thumbnail">
								<div align="center" class="embed-responsive embed-responsive-16by9">
									<img src="{{$val->seriesDetailSingle->thumbnail}}" alt="{{$val->seriesDetailSingle->name}}" onerror="this.src='{{asset('assets/client/images/thumb.png')}}'" class="w100p">
									@if($val->seriesDetailSingle->duration > 0)
									<div class="duration">{{$val->seriesDetailSingle->getMSDuration()}}</div>
									@endif
								</div>
								<div class="caption colorDarkGray">
									<h3>{{strlen($val->seriesDetailSingle->name) > 45 ? substr($val->seriesDetailSingle->name,0,45)."..." : $val->seriesDetailSingle->name}}</h3>
									<p>
										<span>{{$val->createdByUser->name or ''}}&nbsp</span>
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