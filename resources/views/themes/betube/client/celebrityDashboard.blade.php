@extends('client.layout.app')
@section('content')
    <style href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></style>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        /*.content.content-with-sidebar .list-group .group-item-grid-default {*/
            /*width: auto !important;*/
        /*}*/
        .item.large-3.medium-6.columns.group-item-grid-default {
            padding-left: 6px !important;
        }
    </style>
    @php
        try {
            if(isset($data->banner) && $data->banner.length > 0) {
                $banner = $data->banner;
            } else {
                $banner = asset('assets/client/images/defaultbanner.jpg');
            }
        } catch(\Exception $e) {
                $banner = asset('assets/client/images/defaultbanner.jpg');
        }
    @endphp
    <style>
        .topProfile {
            background: url('{{$banner}}') no-repeat;
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
                        <img src="{{$data->image}}"
                             onerror="this.src='{{asset('assets/client/images/nothumbuser.png')}}'"
                             alt="profile author img">
                    </div>

                    <div class="clearfix">
                        <div class="profile-author-name float-left">
                            <h4>{{$data->name}}</h4>
                            <p>Join Date :
                                <span>{{\Carbon\Carbon::parse($data->created_at)->toDateString()}}</span></p>
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
                                    <li class="clearfix" id="profileSettingsBan">
                                        <a class="active" href="javascript:;" id="profileSettinsMan">
                                            <i class="fa fa-user"></i>Videos
                                            <span class="float-right">{{($videos->total())}}</span>

                                        </a>
                                    </li>

                                    <li class="clearfix" id="abtMeBan">
                                        <a class="" href="javascript:;" id="abtMeMan">
                                            <i class="fa fa-user"></i>About
                                        </a>
                                    </li>


                                    <li class="clearfix" id="likedVideosBan">
                                        <a href="javascript:;" id="likedVidMan">
                                            <i class="fa fa-heart"></i>Albums
                                            <span class="float-right">{{count($data->album)}}</span>
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

        <div id="abtMeSec" class="large-8 columns profile-inner" style="display: none" >
            <!-- single post description -->
            <section class="singlePostDescription">
                <div class="row secBg">
                    <div class="large-12 columns">
                        <section class="singlePostDescription">
                            <div class="row secBg">
                                <div class="large-12 columns">
                                    <div class="large-12 columns">
                                        <div class="heading">
                                            <i class="fa fa-user"></i>
                                            <h4>{{$data->name}}</h4>
                                        </div>
                                        <div class="description">
                                            <p>{!! $data->bio !!}</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </section><!-- End single post description -->
        </div>


        <div id="likedVidSec" style="display: none" class="large-8 columns profile-inner">
            <section class="profile-videos content content-with-sidebar">
                <!-- newest video -->
                <div class="main-heading">
                    <div class="row secBg padding-14">
                        <div class="medium-8 small-8 columns">
                            <div class="head-title">
                                <i class="fa fa-film"></i>
                                <h4>Albums</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row secBg">
                    <div class="large-12 columns">
                        <div class="row column head-text clearfix">
                            <p class="pull-left">All Albums : <span>{{count($videos)}}</span></p>
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
                                        @foreach($data->album as $key => $val)
                                            <input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}">

                                            <div class="item large-3 medium-6 columns group-item-grid-default @if($loop->last) end @endif " style="width: auto !important;">
                                                <div class="item-cat item thumb-border txtAlignCenter">
                                                    <figure class="premium-img moviesImage" onclick="window.location='/album/{{str_replace('#', '_', str_replace(' ', '-', $val->name))}}'" >
                                                        <img src="{{$val->thumbnail}}" alt="{{$val->name}}" onerror="this.src='{{asset('assets/client/images/nothumbuser.png')}}'" class="w185h260">
                                                        <a href="{{route('celebrityDetailPage', str_replace(' ', '-', $val->name))}}" class="hover-posts">
                                                            <span><i class="fa fa-search"></i></span>
                                                        </a>
                                                    </figure>
                                                    <h6>
                                                        <a href="javascript:;" onclick="window.location='/album/{{str_replace('#', '_', str_replace(' ', '-', $val->name))}}'" class="txtColor">{{strlen($val->name) > 22 ? substr($val->name,0,22)."..." : $val->name}}</a>
                                                    </h6>
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

        <div id="profileSettingSec" class="large-8 columns profile-inner">
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
                            <p class="pull-left">All Videos : <span>{{($videos->total())}}</span></p>
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
                                        @foreach($videos as $key => $val)
                                                        <div class="item large-3 medium-6 columns group-item-grid-default @if($loop->last) end @endif ">
                                                            <input type="hidden" id="linkMe_{{$val->seriesDetail->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->seriesDetail->link)))}}">

                                                            <div class="post thumb-border">
                                                                <div class="post-thumb">
                                                                    <img src="{{$val->seriesDetail->thumbnail}}" alt="new video" onerror="this.src='{{asset('assets/client/images/thumb.png')}}'" >
                                                                    <a href="javascript:;" class="hover-posts"  onclick="redirectMe('{{$val->seriesDetail->id}}')">
                                                                        <span><i class="fa fa-play"></i>Watch {{$val->seriesDetail->name}}</span>
                                                                    </a>
                                                                    <div class="video-stats clearfix">
                                                                    </div>
                                                                </div>
                                                                <div class="post-des">
                                                                    <h6><a href="javascript:;" onclick="redirectMe('{{$val->seriesDetail->id}}')">{{strlen($val->seriesDetail->name) > 22 ? substr($val->seriesDetail->name,0,22)."..." : $val->seriesDetail->name}}</a></h6>
                                                                    <div class="post-stats clearfix">
                                                                        <p class="pull-left">
                                                                            <i class="fa fa-user"></i>
                                                                            <span onclick="window.location = '/user/{{str_replace('#', '_', str_replace(' ', '-', isset($val->seriesDetail->createdByUser->name) ? $val->seriesDetail->createdByUser->name : ''))}}'"><a href="javascript:;">{{$val->seriesDetail->createdByUser->name or ''}}</a></span>
                                                                        </p>
                                                                        <p class="pull-left">
                                                                            <i class="fa fa-clock-o"></i>
                                                                            <span>{{\Carbon\Carbon::parse($val->seriesDetail->created_at)->diffForHumans()}}</span>
                                                                        </p>
                                                                    </div>
                                                                    <div class="post-summary">
                                                                        <p>{{$val->seriesDetail->description}}</p>
                                                                    </div>
                                                                    <div class="post-button">
                                                                        <a href="javascript:;" class="secondary-button" onclick="redirectMe('{{$val->seriesDetail->id}}')"><i class="fa fa-play-circle"></i>watch video</a>
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