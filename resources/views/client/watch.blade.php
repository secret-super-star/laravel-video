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
					<i class="fa fa-tag"> </i> Watch Videos
				</div>
			</div>
			
			<div class="ipad">
				<div class="thumbnail row padings padings" >
					@if(count($series) < 1)
						<span class="colorWhite">No Video Found Under This Category..!</span>
					@endif
					@foreach(array_chunk($series->all(), 2) as $seriesVideos)
							<div class="col-sm-12">
							@foreach($seriesVideos as $val)
									
									<script type="application/ld+json">
								{
								  "@context": "http://schema.org",
								  "@type": "VideoObject",
								  "name": "{{$val->name or 'Dummy Name'}}",
								  "description": "{{$val->description}}",
								  "thumbnailUrl": "{{$val->thumbnail}}",
								  "uploadDate": "{{$val->created_at}}",
								  "duration": "{{$val->duration}}",
								  "publisher": {
								    "@type": "Organization",
								    "name": "{{$val->createdByUser->name or ''}}",
								    "logo": {
								      "@type": "ImageObject",
								      "url": "{{$val->thumbnail}}",
								      "width": 600,
								      "height": 60
								    }
								  },
								"contentUrl": "{{URL::to('video/'.str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link))))}}",
								"embedUrl": "{{URL::to('video/'.str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link))))}}",

									  "interactionCount": "{{count($val->videoViews)}}"
								}
								</script>
									
								
									<div class="col-sm-6">
								<input type="hidden" id="linkMe_{{$val->id}}"  value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}">
								
								<div class="col-sm-12 col-md-3">
									<div class="thumbnail">
										<div align="center" class="embed-responsive embed-responsive-16by9">
											<img src="{{$val->thumbnail}}" alt="{{$val->name}}" onerror="this.src='{{asset('assets/client/images/thumb.png')}}'" class="w100p cPointer" onclick="redirectMe('{{$val->id}}')">
											@if($val->duration > 0)
											<div class="duration">{{$val->getMSDuration()}}</div>
											@endif
										</div>
										<div class="caption colorDarkGray">
											<h3 onclick="redirectMe('{{$val->id}}')" class="cPointer">{{strlen($val->name) > 22 ? substr($val->name,0,22)."..." : $val->name}}</h3>
											<p>
												<span class="cPointer" onclick="window.location = '/user/{{str_replace('#', '_', str_replace(' ', '-', isset($val->createdByUser->name) ? $val->createdByUser->name : ''))}}'">{{$val->createdByUser->name or ''}}&nbsp</span>
												<span>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</span>
											</p>
										</div>
									</div>
								</div>
								</div>
							@endforeach
							@if($loop->first)
								</div>
								<div class="clearfix"></div>
								<div class="col-md-12 mb30">
									@include('client.includes.add2')
								</div>
							@else
								</div>
							@endif
					@endforeach
					
					{{$series->links()}}
				</div>
			</div>
			<div class="nonipad">
				<div class="thumbnail row padings padings" >
					@if(count($series) < 1)
						<span class="colorWhite">No Video Found Under This Category..!</span>
					@endif
					
					@foreach(array_chunk($series->all(), 4) as $seriesVideos)
						<div class="col-sm-12">
							@foreach($seriesVideos as $val)
								<input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}">
								<div class="col-sm-12 col-md-3">
									<div class="thumbnail">
										<div align="center" class="embed-responsive embed-responsive-16by9">
											<img src="{{$val->thumbnail}}" alt="{{$val->name}}" onerror="this.src='{{asset('assets/client/images/thumb.png')}}'" class="w100p cPointer" onclick="redirectMe('{{$val->id}}')">
											@if($val->duration > 0)
											<div class="duration">{{$val->getMSDuration()}}</div>
											@endif
										</div>
										<div class="caption colorDarkGray">
											<h3 class="cPointer" onclick="redirectMe('{{$val->id}}')">{{strlen($val->name) > 55 ? substr($val->name,0,55)."..." : $val->name}}</h3>
											<p>
												<span onclick="window.location = '/user/{{str_replace('#', '_', str_replace(' ', '-', isset($val->createdByUser->name) ? $val->createdByUser->name : ''))}}'" class="cPointer">{{$val->createdByUser->name or ''}}&nbsp</span>
												<span>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</span>
											</p>
										</div>
									</div>
								</div>
							@endforeach
							<div class="col-md-12 mb30">
								@if($loop->first)
									@include('client.includes.add2')
								@endif
							</div>
							
						</div>
					@endforeach
					
					{{$series->links()}}
				</div>
			</div>
		
		
		</div>
		
		@include('client.categoriesAndTags')
	</div>
	
	{{--<script src="https://player.vimeo.com/api/player.js"></script>--}}

@endsection