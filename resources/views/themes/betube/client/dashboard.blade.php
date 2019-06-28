@extends('client.layout.app')
@section('content')
    <style href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></style>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .topProfile {
            background: url('{{Auth::user()->banner}}') no-repeat;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }
    </style>
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
                        <img src="{{\Auth::user()->image}}"
                             onerror="this.src='{{asset('assets/client/images/nothumbuser.png')}}'"
                             alt="profile author img">
                    </div>

                    <div class="clearfix">
                        <div class="profile-author-name float-left">
                            <h4>{{\Auth::user()->name}}</h4>
                            <p>Join Date :
                                <span>{{\Carbon\Carbon::parse(\Auth::user()->created_at)->toDateString()}}</span></p>
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

                                    <li class="clearfix" id="profileSettingsBan">
                                        <a href="javascript:;" id="profileSettinsMan">
                                            <i class="fa fa-gears"></i>Profile Settings</a>
                                    </li>

                                    <li class="clearfix" id="likedVideosBan">
                                        <a href="javascript:;" id="likedVidMan">
                                            <i class="fa fa-heart"></i>Favorite Videos
                                            <span class="float-right">{{count($likedVideos)}}</span>
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
                                            <a href="#" class="inner-btn">{{\Auth::user()->name}}</a>
                                        </div>
                                        <div class="email profile-margin">
                                            <button><i class="fa fa-globe"></i>Country</button>
                                            <span class="inner-btn">{{\Auth::user()->country}}</span>
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
                                                            <input type="text" placeholder="enter you full name" required="" name="name" id="name" value="{{\Auth::user()->name}}">
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
            <!-- single post description -->
            <section class="profile-videos">
                <div class="row secBg">
                    <div class="large-12 columns">
                        <div class="heading">
                            <i class="fa fa-video-camera"></i>
                            <h4>My Videos</h4>
                        </div>
                        @foreach($likedVideos as $val)
                            <input type="hidden" id="linkMe_{{$val->videoDetail->id}}"
                                   value="{{str_replace('#', '_', str_replace(' ', '-', $val->videoDetail->link))}}">
                            <div class="profile-video">
                                <div class="media-object stack-for-small">
                                    <div class="media-object-section media-img-content">
                                        <div class="video-img">
                                            <img src="{{$val->videoDetail->thumbnail}}"
                                                 onerror="this.src='http://localhost:8000/assets/client/images/thumb.png'"
                                                 alt="video thumbnail">
                                        </div>
                                    </div>
                                    <div class="media-object-section media-video-content">
                                        <div class="video-content">
                                            <h5>
                                                <a href="javascript:;"
                                                   onclick="redirectMe('{{$val->videoDetail->id}}')">
                                                    {{$val->videoDetail->name}}
                                                </a>
                                            </h5>
                                            <p>{{$val->videoDetail->description}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section><!-- End single post description -->
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