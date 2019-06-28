@extends('client.layouts.app')

@section('content')

	<style>
		#exTab1 .nav-pills > li > a {
			border-radius: 0;
		}

		#exTab3 .nav-pills > li > a {
			border-radius: 4px 4px 0 0 ;
		}

		#exTab2 .nav>li.active>a {
			padding: 10px 0;
			margin-right: 10px;
			margin-left: 10px;
			padding-right: 10px;
			padding-left: 10px;
			color: black;
		}

		#exTab2 .nav>li>a {
			padding: 10px 0;
			margin-right: 10px;
			margin-left: 10px;
			padding-right: 10px;
			padding-left: 10px;
			color: white;
		}

		 .colorWhite h1 {
			 font-size: 36px !important;
		 }

		.colorWhite h2 {
			font-size: 30px !important;
		}

		.colorWhite h3 {
			font-size: 16px !important;
		}

		.colorWhite .h1, .h2, .h3, h1, h2, h3 {
			margin-top: 20px;
			margin-bottom: 10px;
		}
	</style>

	<div class="col-md-12 ">
		<div class="profile clearfix">
			<form action="/updateRecord" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
				<input type="hidden" name="_token" value="{{csrf_token()}}"/>
				<div class="image">
					@php
						$banner = isset($data->banner) ? $data->banner : '';
					  $image = isset($data->image) ? $data->image : '';
					@endphp
					<img src="{{$banner}}" onerror="this.src='{{asset('assets/client/images/banner.jpg')}}'" class="img-cover-celeb" id="bannerThumb">
					<input type="file" class="hide" id="banner" name="banner">
				</div>
				<div class="user clearfix">
					<div class="avatar">
						<img src="{{$image}}" class="img-thumbnail img-profile" id="avatarThumb">
						<span class="colorWhite f20 ">{{$data->name or ''}}</span>
					</div>

				</div>
				<div class="col-sm-12">
					<div class="col-sm-12 col-md-9 mt60">
						<div id="exTab2" class="">
							<ul class="nav nav-tabs ">
								<li class="active">
									<a  href="#1" data-toggle="tab">Videos</a>
								</li>
								@if(isset($data->album) && count($data->album) > 0)
									<li><a href="#2" data-toggle="tab">Albums</a>
									</li>
								@endif
								<li><a href="#3" data-toggle="tab">About</a>
								</li>
							</ul>

							<div class="tab-content ">
								<div class="tab-pane active" id="1">

									<div class="col-sm-12">
										@if(isset($data->celebritiesVideos) && count($data->celebritiesVideos) < 1)
											<div class="colorWhite mt20 col-md-12 mb10">No contributed videos..!</div>
										@endif
									</div>

									@if(isset($videos))
										@foreach(array_chunk($videos->all(), 4) as $seriesVideos)
											<div class="col-sm-12">
												@foreach($seriesVideos as $val)
													@if(isset($val->seriesDetail))

														<input type="hidden" id="linkMe_{{$val->seriesDetail->id }}" value="{{str_replace('|', '-', str_replace('--', '-', str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->seriesDetail->link)))))}}">
														<div class="col-sm-12 col-md-3 cPointer" onclick="redirectMe('{{$val->seriesDetail->id  or ''}}')">
															<div class="thumbnail">
																<div align="center" class="embed-responsive embed-responsive-16by9">
																	<img src="{{$val->seriesDetail->thumbnail or ''}}" alt="vimeo link test" onerror="this.src='/assets/client/images/thumb.png'" class="w100p">
																	@if($val->seriesDetail->duration > 0)
																		<div class="duration">{{$val->seriesDetail->getMSDuration()}}</div>
																	@endif
																</div>
																<div class="caption colorDarkGray">
																	<h3>{{$val->seriesDetail->name}}</h3>
																	<p>
																		<span>{{$val->seriesDetail->createdByUser->name or 'Admin'}}</span>
																		<span>{{\Carbon\Carbon::parse($val->seriesDetail->created_at)->diffForHumans()}}</span>
																	</p>
																</div>
															</div>
														</div>
													@endif
												@endforeach
											</div>
										@endforeach
										{{$videos->links()}}
									@endif
								</div>
								@if(isset($data->album) && count($data->album) > 0)
									<div class="tab-pane" id="2">


										<div class="col-sm-12">
											@if(isset($data->album) && count($data->album) < 1)
												<div class="colorWhite mt20 col-md-12 mb10">No contributed videos..!</div>
											@endif
										</div>

										@if($data->album)
											@foreach(array_chunk($data->album->all(), 4) as $seriesVideos)
												<div class="col-sm-12">
													@foreach($seriesVideos as $val)

														<div class="col-sm-12 col-md-3 cPointer" onclick="window.location='/album/{{str_replace('#', '_', str_replace(' ', '-', $val->name))}}'">
															<div class="thumbnail">
																<div align="center" class="embed-responsive embed-responsive-16by9">
																	<img src="{{$val->thumbnail}}" alt="vimeo link test" onerror="this.src='http://localhost:8000/assets/client/images/thumb.png'" class="w100p">
																	@if($val->duration > 0)
																		<div class="duration">{{$val->getMSDuration()}}</div>
																	@endif
																</div>
																<div class="caption colorDarkGray">
																	<h3>{{$val->name}}</h3>
																	<p>
																		<span>{{$val->createdByUser->name or 'Admin'}}</span>
																		<span>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</span>
																	</p>
																</div>
															</div>
														</div>
													@endforeach
												</div>
											@endforeach
										@endif
									</div>
								@endif
								<div class="tab-pane" id="3">

									<div class="form-group">
										<label class="control-label col-sm-2 colorWhite" for="name">Name:</label>
										<div class="col-sm-10 mb10 ">
											<p class="colorWhite">{{$data->name or ''}}</p>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2 colorWhite" for="pwd">Bio:</label>
										<div class="col-sm-10 mb10 ">
											<div class="colorWhite">{!! $data->bio !!}</div>
										</div>
									</div>


								</div>
							</div>
						</div>


					</div>
					<div class="col-sm-12 col-sm-3">
						@include('client.includes.add3')
					</div>
				</div>
			</form>
		</div>

	</div>

@endsection