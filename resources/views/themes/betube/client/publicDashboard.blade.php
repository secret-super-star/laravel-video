@extends('client.layout.app')
@section('content')
    <style href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></style>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        @php
        $banner = isset($user->banner) ? $user->banner : asset('assets/client/images/banner.jpg');
        @endphp
        .topProfile {
            background: url('{{$banner}}') no-repeat;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

    </style>
    @php
        $likedVideos = $user->likedVideos;
    @endphp
    <!-- profile top section -->
    <section class="topProfile">
        <div class="main-text text-center">
            <div class="row">
                <div class="large-12 columns"></div>
            </div>
        </div>
        <div class="profile-stats">
            <div class="row secBg">
                <div class="large-12 columns">
                    <div class="profile-author-img">
                        <img src="{{$user->image}}"
                             onerror="this.src='{{asset('assets/client/images/nothumbuser.png')}}'"
                             alt="profile author img">
                    </div>

                    <div class="clearfix">
                        <div class="profile-author-name float-left">
                            <h4>{{$user->name}}</h4>
                            <p>Join Date :
                                <span>{{\Carbon\Carbon::parse($user->created_at)->toDateString()}}</span></p>
                        </div>
                        <div class="profile-author-stats float-right">
                            <ul class="menu">
                                <li>
                                    <div class="icon float-left">
                                        <i class="fa fa-video-camera"></i>
                                    </div>
                                    <div class="li-text float-left">
                                        <p class="number-text">{{count($likedVideos)}}</p>
                                        <span>Videos</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End profile top section -->

    <div class="row">
        <!-- left sidebar -->
        <div class="large-4 columns">
            <aside class="secBg sidebar">
                <div class="row">
                    <!-- profile overview -->
                    <div class="large-12 columns">
                        <div class="widgetBox">
                            <div class="widgetTitle">
                                <h5>Profile Overview</h5>
                            </div>
                            <div class="widgetContent">
                                <ul class="profile-overview">
                                    <li class="clearfix" id="abtMeBan">
                                        <a class="active" href="javascript:;" id="abtMeMan">
                                            <i class="fa fa-user"></i>about me
                                        </a>
                                    </li>


                                    <li class="clearfix" id="likedVideosBan">
                                        <a href="javascript:;" id="likedVidMan">
                                            <i class="fa fa-heart"></i>Favorite Videos
                                            <span class="float-right">{{isset($likedVideos)}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- End profile overview -->
                </div>
            </aside>
        </div><!-- end sidebar -->

        <!-- right side content area -->

        <div id="abtMeSec" class="large-8 columns profile-inner">
            <!-- single post description -->
            <section class="singlePostDescription">
                <div class="row secBg">
                    <div class="large-12 columns">
                        <section class="singlePostDescription">
                            <div class="row secBg">
                                <div class="large-12 columns">
                                    <div class="heading">
                                        <i class="fa fa-user"></i>
                                        <h4>Description</h4>
                                    </div>
                                    <div class="description">
                                        <div class="site profile-margin">
                                            <button><i class="fa fa-user"></i>Name</button>
                                            <a href="#" class="inner-btn">{{$user->name}}</a>
                                        </div>
                                        <div class="email profile-margin">
                                            <button><i class="fa fa-globe"></i>Country</button>
                                            <span class="inner-btn">{{$user->country}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </section><!-- End single post description -->
        </div>


        <div style="display: none" id="profileSettingSec" class="large-8 columns profile-inner">
            <!-- single post description -->
            <section class="singlePostDescription">
                <div class="row secBg">
                    <div class="large-12 columns">
                        <section class="submit-post">
                            <div class="row secBg">
                                <div class="large-12 columns">
                                    <div class="heading">
                                        <i class="fa fa-pencil-square-o"></i>
                                        <h4>Update Profile</h4>
                                    </div>
                                    <div class="row">
                                        <div class="large-12 columns">

                                            <form action="/updateRecord" method="post" enctype="multipart/form-data" data-abide="dq3mux-abide" novalidate="">
                                                {{csrf_field()}}
                                                <div data-abide-error="" class="alert callout" style="display: none;">
                                                    <p><i class="fa fa-exclamation-triangle"></i>
                                                        There are some errors in your form.</p>
                                                </div>
                                                <div class="row">
                                                    <div class="large-12 columns">
                                                        <label>Name
                                                            <input type="text" placeholder="enter you full name" required="" name="name" id="name" value="{{$user->name}}">
                                                            <span class="form-error">
                                                            Yo, you had better fill this out, it's required.
                                                        </span>
                                                        </label>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label>Country
                                                            <select name="country" id="country">
                                                                @foreach($countries as $key => $val)
                                                                    <option value="{{$val->short_name}}">{{$val->long_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="form-error">
                                                            Yo, you had better fill this out, it's required.
                                                        </span>
                                                        </label>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label>Image
                                                        </label>
                                                        <div class="upload-video">
                                                            <label for="videoUpload" class="button">Upload Image</label>
                                                            <input type="file" id="videoUpload" name="avatar" class="show-for-sr">
                                                            <span>No file chosen</span>
                                                        </div>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label>Banner
                                                        </label>
                                                        <div class="upload-video">
                                                            <label for="banner" class="button">Upload Banner</label>
                                                            <input type="file" id="banner" name="banner" class="show-for-sr">
                                                            <span>No file chosen</span>
                                                        </div>
                                                    </div>

                                                    <div class="large-12 columns">
                                                        <button class="button expanded" type="submit" name="submit">Save Profile</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </section><!-- End single post description -->
        </div>


        <div style="display: none" id="likedVidSec" class="large-8 columns profile-inner">
            <section class="profile-videos content content-with-sidebar">
                <!-- newest video -->
                <div class="main-heading">
                    <div class="row secBg padding-14">
                        <div class="medium-8 small-8 columns">
                            <div class="head-title">
                                <i class="fa fa-film"></i>
                                <h4>Videos</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row secBg">
                    <div class="large-12 columns">
                        <div class="row column head-text clearfix">
                            <p class="pull-left">All Videos : <span>{{count($likedVideos)}}</span></p>
                            <div class="grid-system pull-right show-for-large">
                                <a class="secondary-button current grid-default" href="#"><i class="fa fa-th"></i></a>
                                <a class="secondary-button grid-medium" href="#"><i class="fa fa-th-large"></i></a>
                                <a class="secondary-button list" href="#"><i class="fa fa-th-list"></i></a>
                            </div>
                        </div>
                        <div class="tabs-content" data-tabs-content="newVideos">



                            <div class="tabs-content" data-tabs-content="popularVideos">
                                <div class="tabs-panel is-active" id="popular-all">
                                    <div class="row list-group">
                                        @foreach($likedVideos as $key => $val)
                                            @if($loop->last)
                                                <div class="item large-3 medium-6 columns group-item-grid-default end">
                                                    @else
                                                        <div class="item large-3 medium-6 columns group-item-grid-default">
                                                            @endif
                                                            <input type="hidden" id="linkMe_{{$val->videoDetail->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->videoDetail->link)))}}">

                                                            <div class="post thumb-border">
                                                                <div class="post-thumb">
                                                                    <img src="{{$val->videoDetail->thumbnail}}" alt="new video" onerror="this.src='{{asset('assets/client/images/thumb.png')}}'" >
                                                                    <a href="javascript:;" class="hover-posts"  onclick="redirectMe('{{$val->videoDetail->id}}')">
                                                                        <span><i class="fa fa-play"></i>Watch {{$val->videoDetail->name}}</span>
                                                                    </a>
                                                                    <div class="video-stats clearfix">
                                                                    </div>
                                                                </div>
                                                                <div class="post-des">
                                                                    <h6><a href="javascript:;" onclick="redirectMe('{{$val->videoDetail->id}}')">{{strlen($val->videoDetail->name) > 22 ? substr($val->videoDetail->name,0,22)."..." : $val->videoDetail->name}}</a></h6>
                                                                    <div class="post-stats clearfix">
                                                                        <p class="pull-left">
                                                                            <i class="fa fa-user"></i>
                                                                            <span onclick="window.location = '/user/{{str_replace('#', '_', str_replace(' ', '-', isset($val->videoDetail->createdByUser->name) ? $val->videoDetail->createdByUser->name : ''))}}'"><a href="javascript:;">{{$val->videoDetail->createdByUser->name or ''}}</a></span>
                                                                        </p>
                                                                        <p class="pull-left">
                                                                            <i class="fa fa-clock-o"></i>
                                                                            <span>{{\Carbon\Carbon::parse($val->videoDetail->created_at)->diffForHumans()}}</span>
                                                                        </p>
                                                                    </div>
                                                                    <div class="post-summary">
                                                                        <p>{{$val->videoDetail->description}}</p>
                                                                    </div>
                                                                    <div class="post-button">
                                                                        <a href="javascript:;" class="secondary-button" onclick="redirectMe('{{$val->videoDetail->id}}')"><i class="fa fa-play-circle"></i>watch video</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            </section>
        </div>

    </div>
@endsection
@section('js')
    <script>
			$('#likedVideosBan').on('click', function () {
				$('#abtMeSec').hide();
				$('#abtMeMan').removeClass('active')
				$('#likedVidSec').show();
				$('#likedVidMan').addClass('active')

				$('#profileSettinsMan').removeClass('active');
				$('#profileSettingSec').hide()
			});

			$('#abtMeBan').on('click', function () {
				$('#abtMeSec').show();
				$('#abtMeMan').addClass('active')
				$('#likedVidSec').hide();
				$('#likedVidMan').removeClass('active')

				$('#profileSettinsMan').removeClass('active');
				$('#profileSettingSec').hide()
			});

			$('#profileSettingsBan').on('click', function () {
				$('#abtMeSec').hide();
				$('#abtMeMan').removeClass('active');
				$('#likedVidSec').hide();
				$('#likedVidMan').removeClass('active');

				$('#profileSettinsMan').addClass('active');
				$('#profileSettingSec').show()
			});
    </script>
@endsection