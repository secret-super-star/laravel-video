@extends('client.layouts.app')

@section('content')

	<div class="row">
		<div class="col-sm-9">
			
			@include('client.includes.add1')
			
			<div class="row panel panel-default mt15">
				<div class="panel-heading">
					<h1><i class="fa fa-star"> </i> Featured VideosXX</h1>
				</div>
				
				<div class="panel-body" style="border: solid 1px red;">

					<div class="ipad">
						@foreach(array_chunk($featuredSeries->all(), 2) as $seriesVideos)
							<div class="col-sm-6">
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
									
									
									<input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}">
								
									<div class="col-sm-12 col-md-3 ">
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
													<span onclick="window.location = '/user/{{str_replace('#', '_', str_replace(' ', '-', isset($val->createdByUser->name) ? $val->createdByUser->name : ''))}}'" class="cPointer">{{$val->createdByUser->name or ''}}&nbsp</span>
													<span>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</span>
												</p>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						@endforeach
					</div>
					<div class="nonipad">
						@foreach(array_chunk($featuredSeries->all(), 4) as $seriesVideos)
							<div class="col-sm-12">
								@foreach($seriesVideos as $val)
									
									<input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}">
									
									<div class="col-sm-12 col-md-3" >
										<div class="thumbnail">
											<div align="center" class="embed-responsive embed-responsive-16by9">
												<img src="{{$val->thumbnail}}" alt="{{$val->name}}" onerror="this.src='{{asset('assets/client/images/thumb.png')}}'" class="w100p cPointer" onclick="redirectMe('{{$val->id}}')">
												@if($val->duration > 0)
												<div class="duration">{{$val->getMSDuration()}}</div>
												@endif
											</div>
											<div class="caption colorDarkGray">
												<h3 onclick="redirectMe('{{$val->id}}')" class="cPointer">{{strlen($val->name) > 55 ? substr($val->name,0,55)."..." : $val->name}}</h3>
												<p>
													<span onclick="window.location = '/user/{{str_replace('#', '_', str_replace(' ', '-', isset($val->createdByUser->name) ? $val->createdByUser->name : ''))}}'" class="cPointer">{{$val->createdByUser->name or ''}}&nbsp</span>
													<span>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</span>
												</p>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						@endforeach
					</div>
				
				
				
				</div>
			</div>
			
			@include('client.includes.add2')
			
			
			<div class="row panel panel-default mt15">
				<div class="panel-heading">
					<h1><i class="fa fa-star"> </i> New Videos</h1>
				</div>
				
				
				<div class="panel-body">
					
					<div class="ipad">
						@foreach(array_chunk($series->all(), 2) as $seriesVideos)
							<div class="col-sm-6">
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
								  "contentUrl": "{{URL::to('video/'.str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->name))))}}",
								  "embedUrl": "{{URL::to('video/'.str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->name))))}}",
								  "interactionCount": "{{count($val->videoViews)}}"
								}
							</script>
									
								
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
												<h3 onclick="redirectMe('{{$val->id}}')" class="cPointer">{{strlen($val->name) > 22 ? substr($val->name,0,22)."..." : $val->name}}</h3>
												<p>
													<span onclick="window.location = '/user/{{str_replace('#', '_', str_replace(' ', '-', isset($val->createdByUser->name) ? $val->createdByUser->name : ''))}}'"  class="cPointer">{{$val->createdByUser->name or ''}}>{{$val->createdByUser->name or ''}}&nbsp</span>
													<span>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</span>
												</p>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						@endforeach
					</div>
					<div class="nonipad">
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
												<h3 onclick="redirectMe('{{$val->id}}')" class="cPointer">{{strlen($val->name) > 55 ? substr($val->name,0,55)."..." : $val->name}}</h3>
												<p>
													<span onclick="window.location = '/user/{{str_replace('#', '_', str_replace(' ', '-', isset($val->createdByUser->name) ? $val->createdByUser->name : ''))}}'" class="cPointer">{{$val->createdByUser->name or ''}}&nbsp</span>
													<span>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</span>
												</p>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						@endforeach
					</div>
				</div>
			</div>

			@if(isset($video_groups_module) && $video_groups_module)

			<div class="row panel panel-default mt15">
				<div class="panel-heading">
					<h1><i class="fa fa-star"> </i> Latest Video Groups</h1>
				</div>

				<div class="panel-body">

					<div class="ipad">
						@foreach(array_chunk($videoGroups->all(), 2) as $seriesVideos)
							<div class="col-sm-6">
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


									<input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}">

									<div class="col-sm-12 col-md-3 ">
										<div class="thumbnail">
											<div align="center" class="embed-responsive embed-responsive-16by9">
												<img src="{{$val->thumbnail}}" alt="{{$val->name}}" onerror="this.src='{{asset('assets/client/images/thumb.png')}}'" class="w100p cPointer" onclick="redirectMeForGroup('{{$val->id}}')">
												@if($val->duration > 0)
													<div class="duration">{{$val->getMSDuration()}}</div>
												@endif
											</div>
											<div class="caption colorDarkGray">
												<h3 onclick="redirectMeForGroup('{{$val->id}}')" class="cPointer">{{strlen($val->name) > 22 ? substr($val->name,0,22)."..." : $val->name}}</h3>
												<p>
													<span onclick="window.location = '/user/{{str_replace('#', '_', str_replace(' ', '-', isset($val->createdByUser->name) ? $val->createdByUser->name : ''))}}'" class="cPointer">{{$val->createdByUser->name or ''}}&nbsp</span>
													<span>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</span>
												</p>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						@endforeach
					</div>
					<div class="nonipad">
						@foreach(array_chunk($videoGroups->all(), 4) as $seriesVideos)
							<div class="col-sm-12">
								@foreach($seriesVideos as $val)

									<input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}">

									<div class="col-sm-12 col-md-3" >
										<div class="thumbnail">
											<div align="center" class="embed-responsive embed-responsive-16by9">
												<img src="{{$val->thumbnail}}" alt="{{$val->name}}" onerror="this.src='{{asset('assets/client/images/thumb.png')}}'" class="w100p cPointer" onclick="redirectMeForGroup('{{$val->id}}')">
												@if($val->duration > 0)
													<div class="duration">{{$val->getMSDuration()}}</div>
												@endif
											</div>
											<div class="caption colorDarkGray">
												<h3 onclick="redirectMeForGroup('{{$val->id}}')" class="cPointer">{{strlen($val->name) > 55 ? substr($val->name,0,55)."..." : $val->name}}</h3>
												<p>
													<span onclick="window.location = '/user/{{str_replace('#', '_', str_replace(' ', '-', isset($val->createdByUser->name) ? $val->createdByUser->name : ''))}}'" class="cPointer">{{$val->createdByUser->name or ''}}&nbsp</span>
													<span>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</span>
												</p>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						@endforeach
					</div>



				</div>
			</div>

			@endif

		</div>
		@include('client.categoriesAndTags')
	</div>
	
	{{--<script src="https://player.vimeo.com/api/player.js"></script>--}}

@endsection