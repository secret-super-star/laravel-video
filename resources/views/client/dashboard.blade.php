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
	
	</style>
	
	<div class="col-md-12 ">
		<div class="profile clearfix">
			<form action="/updateRecord" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
				<input type="hidden" name="_token" value="{{csrf_token()}}"/>
			<div class="image">
				<img src="{{Auth::user()->banner}}" onerror="this.src='{{asset('assets/client/images/banner.jpg')}}'" class="img-cover" id="bannerThumb">
				<input type="button" value="Edit Banner" class="btn btn-primary edtBtn" onclick="$('#banner').click()">
				<input type="file" class="hide" id="banner" name="banner">
			</div>
			<div class="user clearfix">
				<div class="avatar">
					<img src="{{Auth::user()->image}}" class="img-thumbnail img-profile" id="avatarThumb">
				</div>
				
				<div class="edtAvatar">
					<input type="button" value="Edit Avatar" class="btn btn-primary" onclick="$('#avatar').click()">
					<input type="file" class="hide" id="avatar" name="avatar">
				</div>
				
				<div class="col-sm-12 mt20">
					
					@if (!$errors->isEmpty())
						<div class="alert alert-danger" role="alert">
							{!! $errors->first() !!}
						</div>
					@endif

				</div>
				

			</div>
				<div class="col-sm-12">
					<div class="col-sm-12 col-md-9 mt20">
						{{--<form class="form-horizontal" action="/updateUser" method="post">--}}
						<div id="exTab2" class="">
							<ul class="nav nav-tabs ">
								<li class="active">
									<a  href="#1" data-toggle="tab">Liked Videos</a>
								</li>
								<li><a href="#2" data-toggle="tab">Personal Information</a>
								</li>
							</ul>
							
							<div class="tab-content ">
								<div class="tab-pane active" id="1">
									
									{{--<div class="col-sm-12">--}}
										@if(count($likedVideos) < 1)
											<div class="colorWhite mt20">No videos Liked..!</div>
										@endif
										@foreach(array_chunk($likedVideos->all(), 4) as $seriesVideos)
											<div class="col-sm-12">
												@foreach($seriesVideos as $val)
													<input type="hidden" id="linkMe_{{$val->videoDetail->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', $val->videoDetail->link))}}">
													<div class="col-sm-12 col-md-3 cPointer" onclick="redirectMe('{{$val->videoDetail->id}}')">
														<div class="thumbnail">
															<div align="center" class="embed-responsive embed-responsive-16by9">
																<img src="{{$val->videoDetail->thumbnail}}" alt="vimeo link test" onerror="this.src='http://localhost:8000/assets/client/images/thumb.png'" class="w100p">
															</div>
															<div class="caption colorDarkGray">
																<h3>{{$val->videoDetail->name}}</h3>
																<p>
																	<span>{{$val->videoDetail->createdByUser->name or 'Admin'}}</span>
																	<span>{{\Carbon\Carbon::parse($val->videoDetail->created_at)->diffForHumans()}}</span>
																</p>
															</div>
														</div>
													</div>
												@endforeach
											</div>
										@endforeach
										
										{{--<input type="hidden" id="linkMe_25" value="flicker-link-test">--}}
										{{--<div class="col-sm-12 col-md-3 cPointer" onclick="redirectMe('25')">--}}
											{{--<div class="thumbnail">--}}
												{{--<div align="center" class="embed-responsive embed-responsive-16by9">--}}
													{{--<img src="http://www.filiptv.com/assets/uploads/Desert.jpg" alt="flicker link test" onerror="this.src='http://localhost:8000/assets/client/images/thumb.png'" class="w100p">--}}
												{{--</div>--}}
												{{--<div class="caption colorDarkGray">--}}
													{{--<h3>flicker link test</h3>--}}
													{{--<p>--}}
														{{--<span>Sajjad Raja&nbsp;</span>--}}
														{{--<span>2 weeks ago</span>--}}
													{{--</p>--}}
												{{--</div>--}}
											{{--</div>--}}
										{{--</div>--}}
										{{--<input type="hidden" id="linkMe_24" value="youtube-link-test">--}}
										{{--<div class="col-sm-12 col-md-3 cPointer" onclick="redirectMe('24')">--}}
											{{--<div class="thumbnail">--}}
												{{--<div align="center" class="embed-responsive embed-responsive-16by9">--}}
													{{--<img src="http://www.filiptv.com/assets/uploads/Desert.jpg" alt="youtube link test" onerror="this.src='http://localhost:8000/assets/client/images/thumb.png'" class="w100p">--}}
												{{--</div>--}}
												{{--<div class="caption colorDarkGray">--}}
													{{--<h3>youtube link test</h3>--}}
													{{--<p>--}}
														{{--<span>Sajjad Raja&nbsp;</span>--}}
														{{--<span>2 weeks ago</span>--}}
													{{--</p>--}}
												{{--</div>--}}
											{{--</div>--}}
										{{--</div>--}}
										{{--<input type="hidden" id="linkMe_23" value="Twilight-Saga">--}}
										{{--<div class="col-sm-12 col-md-3 cPointer" onclick="redirectMe('23')">--}}
											{{--<div class="thumbnail">--}}
												{{--<div align="center" class="embed-responsive embed-responsive-16by9">--}}
													{{--<img src="http://localhost:8000/assets/uploads/categories/fbshare%20(1).jpg" alt="Twilight Saga" onerror="this.src='http://localhost:8000/assets/client/images/thumb.png'" class="w100p">--}}
												{{--</div>--}}
												{{--<div class="caption colorDarkGray">--}}
													{{--<h3>Twilight Saga</h3>--}}
													{{--<p>--}}
														{{--<span>Sajjad Raja&nbsp;</span>--}}
														{{--<span>2 weeks ago</span>--}}
													{{--</p>--}}
												{{--</div>--}}
											{{--</div>--}}
										{{--</div>--}}
								{{----}}
									{{----}}
									{{--</div>--}}
									
								</div>
								<div class="tab-pane" id="2">
									
									<div class="form-group">
										<label class="control-label col-sm-2 colorWhite" for="name">Name:</label>
										<div class="col-sm-10 mb10 ">
											<input type="text" class="form-control" id="email" placeholder="Enter email" name="name" value="{{Auth::user()->name}}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2 colorWhite" for="pwd">Country:</label>
										<div class="col-sm-10 mb10 ">
											<select class="form-control" name="country">
												@foreach($countries as $key => $val)
													@if($val->short_name == Auth::user()->country)
														<option value="{{$val->short_name}}" selected>{{$val->long_name}} </option>
													@else
														<option value="{{$val->short_name}}">{{$val->long_name}} </option>
													@endif
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2 colorWhite" for="pwd">Password:</label>
										<div class="col-sm-10 mb10 ">
											<input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" value="" autocomplete="false">
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" class="btn btn-success pushRight">Save</button>
										</div>
									</div>
									{{--<h3>Notice the gap between the content and tab after applying a background color</h3>--}}
								</div>
							</div>
						</div>
						
					
						{{--</form>--}}
					</div>
					<div class="col-sm-12 col-sm-3">
					@include('client.includes.add3')
				</div>
				</div>
			</form>
		</div>
		
		
	</div>
	
@endsection