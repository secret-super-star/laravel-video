@extends('client.layout.app')
@section('content')

    <!-- ad Section -->
    <div class="googleAdv">
        @include('client.partials.add2')
    </div><!-- End ad Section -->


    <div class="row">

        <div class="large-8 columns">
            <section class="content content-with-sidebar">
                <!-- newest video -->
                <div class="main-heading">
                    <div class="row secBg padding-14">
                        <div class="medium-8 small-8 columns">
                            <div class="head-title">
                                <i class="fa fa-film"></i>
                                <h4>Newest Videos</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row secBg">
                    <div class="large-12 columns">
                        <div class="row column head-text clearfix">
                            <p class="pull-left">All Videos : <span>24</span></p>
                            <div class="grid-system pull-right show-for-large">
                                <a class="secondary-button current grid-default" href="javascript:;"><i
                                            class="fa fa-th"></i></a>
                                <a class="secondary-button grid-medium" href="javascript:;"><i
                                            class="fa fa-th-large"></i></a>
                                <a class="secondary-button list" href="javascript:;"><i class="fa fa-th-list"></i></a>
                            </div>
                        </div>
                        <div class="tabs-content" data-tabs-content="newVideos">


                            <div class="tabs-content" data-tabs-content="popularVideos">
                                <div class="tabs-panel is-active" id="popular-all">
                                    <div class="row list-group">
                                        @foreach($series as $key => $val)
                                            <input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}">

                                            <div class="item large-3 medium-6 columns group-item-grid-default end">
                                                <div class="post thumb-border">
                                                    <div class="post-thumb">
                                                        <img src="{{$val->thumbnail}}" alt="new video"
                                                             onerror="this.src='{{asset('assets/client/images/thumb.png')}}'">
                                                        <a href="javascript:;" class="hover-posts"
                                                           onclick="redirectMe('{{$val->id}}')">
                                                            <span><i class="fa fa-play"></i>Watch {{$val->name}}</span>
                                                        </a>
                                                        <div class="video-stats clearfix">

                                                        </div>
                                                    </div>
                                                    <div class="post-des">
                                                        <h6><a href="javascript:;"
                                                               onclick="redirectMe('{{$val->id}}')">{{strlen($val->name) > 22 ? substr($val->name,0,22)."..." : $val->name}}</a>
                                                        </h6>
                                                        <div class="post-stats clearfix">
                                                            <p class="pull-left">
                                                                <i class="fa fa-user"></i>
                                                                <span onclick="window.location = '/user/{{str_replace('#', '_', str_replace(' ', '-', isset($val->createdByUser->name) ? $val->createdByUser->name : ''))}}'"><a href="javascript:;">{{$val->createdByUser->name or ''}}</a></span>
                                                            </p>
                                                            <p class="pull-left">
                                                                <i class="fa fa-clock-o"></i>
                                                                <span>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</span>
                                                            </p>
                                                        </div>
                                                        <div class="post-summary">
                                                            <p></p>
                                                        </div>
                                                        <div class="post-button">
                                                            <a href="javascript:;" class="secondary-button"
                                                               onclick="redirectMe('{{$val->id}}')"><i
                                                                        class="fa fa-play-circle"></i>watch video</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Call our function from above -->

                            @include('pagination.default',array(
                                    'series' => $series
                            ))
                        </div>
                    </div>
                </div>
            </section>
            <!-- ad Section -->
            <div class="googleAdv text-center">
                <!-- ad Section -->
                <div class="googleAdv">
                    @include('client.partials.add2')
                </div><!-- End ad Section -->
            </div><!-- End ad Section -->


        </div>

        @include('client.partials.sidebar')
    </div>

@endsection