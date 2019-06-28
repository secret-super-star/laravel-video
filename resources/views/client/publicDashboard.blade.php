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
				<img src="{{$user->banner}}" onerror="this.src='{{asset('assets/client/images/banner.jpg')}}'" class="img-cover img-cover-celeb" id="bannerThumb">
				<input type="file" class="hide" id="banner" name="banner">
			</div>
			<div class="user clearfix">
				<div class="avatar">
					<img src="{{$user->image}}" onerror="this.src='{{asset('assets/client/images/nothumbuser.png')}}'" class="img-thumbnail img-profile" id="avatarThumb">
					<span class="colorWhite f20 ">{{$user->name}}</span>
				
				</div>
				
				<div class="edtAvatar">
					{{--<input type="button" value="Edit Avatar" class="btn btn-primary" onclick="$('#avatar').click()">--}}
					<input type="file" class="hide" id="avatar" name="avatar">
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
										@if(count($user->likedVideos) < 1)
											<div class="colorWhite mt20">No videos Liked..!</div>
										@endif
									
										@foreach(array_chunk($user->likedVideos->all(), 4) as $seriesVideos)
											<div class="col-sm-12">
												@foreach($seriesVideos as $val)
													<input type="hidden" id="linkMe_{{$val->videoDetail->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', $val->videoDetail->link))}}">
													<div class="col-sm-12 col-md-3 cPointer" onclick="redirectMe('{{$val->videoDetail->id}}')">
														<div class="thumbnail">
															<div align="center" class="embed-responsive embed-responsive-16by9">
																<img src="{{$val->videoDetail->thumbnail}}" alt="vimeo link test" onerror="this.src='http://localhost:8000/assets/client/images/thumb.png'" class="w100p">
																@if($val->videoDetail->duration > 0)
																<div class="duration">{{$val->videoDetail->getMSDuration()}}</div>
																@endif
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
									
								</div>
								<div class="tab-pane" id="2">
									
									<div class="form-group">
										<label class="control-label col-sm-2 colorWhite" for="name">Name:</label>
										<div class="col-sm-10 mb10 colorWhite">
											{{$user->name}}
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2 colorWhite" for="pwd">Country:</label>
										<div class="col-sm-10 mb10 colorWhite">
											{{$user->country}}
										</div>
									</div>
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