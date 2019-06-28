@extends('client.layout.app')
@section('content')

{{--
	@include('client.partials.premiumVideosSlider')

    <!-- ad Section -->
    <div class="googleAdv">
        @include('client.partials.add2')
    </div><!-- End ad Section -->
--}}
    <!-- ad Section -->
    <div class="googleAdv">
        @include('client.partials.add2')
    </div><!-- End ad Section -->


    @include('client.partials.videosSection', array(
        'viewAllBtn' => true,
        'data' => $series
    ))

    @include('client.partials.categories')
    
    <!-- Category -->
    @if(isset($celebrity_module) && $celebrity_module)
    <section id="category">
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="column row">
                    <div class="heading category-heading clearfix">
                        <div class="cat-head pull-left">
                            <i class="fa fa-folder-open"></i>
                            <h4>Browse Videos By Reciters</h4>
                        </div>
                        <div>
                            <div class="navText pull-right show-for-large">
                                <a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
                                <a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- category carousel -->
                <div class="mycar carousel" data-car-length="6" data-items="6" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="4000" data-auto-width="true" data-margin="10" data-dots="false">
                    @foreach($celebrities as $ley => $val)
                        <div class="item-cat item thumb-border txtAlignCenter">
                            <figure class="premium-img figureMargin" onclick="window.location='/category/{{str_replace(' ', '-', $val->name)}}'">
                                <img src="{{$val->image}}" alt="{{$val->name}}" onerror="this.src='{{asset('assets/client/images/nothumbuser.png')}}'" class="w184h128">
                                <a href="{{route('celebrityDetailPage', str_replace(' ', '-', $val->name))}}" class="hover-posts">
                                    <span><i class="fa fa-search"></i></span>
                                </a>
                            </figure>
                            <h6><a href="{{route('celebrityDetailPage', str_replace(' ', '-', $val->name))}}" class="txtColor">{{$val->name }}</a></h6>
                        </div>
                    @endforeach
                </div><!-- end carousel -->
                <div class="row collapse">
                    <div class="large-12 columns text-center row-btn">
                        <a href="/reciters" class="button radius">View All Reciters</a>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Category -->
    @endif

    @if(isset($video_groups_module) && $video_groups_module)
        {{-- LISTING GROUPS --}}

        <section class="content">
            <!-- End newest video -->
            <!-- popular Videos -->
            <div class="main-heading">
                <div class="row secBg padding-14">
                    <div class="medium-8 small-8 columns">
                        <div class="head-title">
                            <i class="fa fa-star"></i>
                            <h4>All Groups</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row secBg">
                <div class="large-12 columns">
                    <div class="row column head-text clearfix">
                        <p class="pull-left">New Groups : <span>{{count($videoGroups)}} Videos</span></p>
                        <div class="grid-system pull-right show-for-large">
                            <a class="secondary-button current grid-default" href="#"><i class="fa fa-th"></i></a>
                            <a class="secondary-button grid-medium" href="#"><i class="fa fa-th-large"></i></a>
                            <a class="secondary-button list" href="#"><i class="fa fa-th-list"></i></a>
                        </div>
                    </div>
                    <div class="tabs-content" data-tabs-content="popularVideos">
                        <div class="tabs-panel is-active" id="popular-all">
                            <div class="row list-group">
                                @foreach($videoGroups as $key => $val)
                                    <input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}">
                                    @if($loop->last)
                                    <div class="item large-3 medium-6 columns group-item-grid-default end">
                                    @else
                                    <div class="item large-3 medium-6 columns group-item-grid-default">
                                    @endif
                                        <div class="post thumb-border">
                                            <div class="post-thumb">
                                                <img src="{{$val->thumbnail}}" alt="{{$val->name}}" onerror="this.src='{{asset('assets/client/images/thumb.png')}}'" >
                                                <a href="javascript:;" class="hover-posts" onclick="redirectMeForGroup('{{$val->id}}')">
                                                    <span><i class="fa fa-play"></i>Watch {{$val->name}}</span>
                                                </a>
                                                <div class="video-stats clearfix">
                                                    @if($val->duration > 0)
                                                    <div class="thumb-stats pull-right">
                                                        <span>{{$val->getMSDuration()}}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="post-des">
                                                <h6><a href="javascript:;" onclick="redirectMeForGroup('{{$val->id}}')" >{{strlen($val->name) > 22 ? substr($val->name,0,22)."..." : $val->name}}</a></h6>
                                                <div class="post-stats clearfix">
                                                    <p class="pull-left">
                                                        <i class="fa fa-user"></i>
                                                        <span onclick="window.location = '/user/{{str_replace('#', '_', str_replace(' ', '-', isset($val->createdByUser->name) ? $val->createdByUser->name : ''))}}'"><a href="#">{{$val->createdByUser->name or ''}}</a></span>
                                                    </p>
                                                    <p class="pull-left">
                                                        <i class="fa fa-clock-o"></i>
                                                        <span>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</span>
                                                    </p>
                                                </div>
                                                <div class="post-summary">
                                                    <p>{{$val->description}}</p>
                                                </div>
                                                <div class="post-button">
                                                    <a href="/watch" class="secondary-button" onclick="redirectMeForGroup('{{$val->id}}')"><i class="fa fa-play-circle"></i>watch video</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                                        <div class="text-center row-btn">
                                            <a class="button radius" href="/groups">View All Groups</a>
                                        </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- ad Section -->
            <div class="googleAdv">
                @include('client.partials.add2')
            </div><!-- End ad Section -->
        </section><!-- End main content -->
        <!-- movies -->
    @endif



    {{--last slider--}}
    @if(isset($celebrity_module) && $celebrity_module)
    <section id="category">
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="column row">
                    <div class="heading category-heading clearfix">
                        <div class="cat-head pull-left">
                            <i class="fa fa-folder-open"></i>
                            <h4>Browse Videos By Albums</h4>
                        </div>
                        <div>
                            <div class="navText pull-right show-for-large">
                                <a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
                                <a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- category carousel -->
                <div class="albumsCar carousel" data-car-length="6" data-items="6" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="4000" data-auto-width="true" data-margin="10" data-dots="false">
                    @foreach($albums as $ley => $val)
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
                    @endforeach
                </div><!-- end carousel -->
                <div class="row collapse">
                    <div class="large-12 columns text-center row-btn">
                        <a href="/reciters" class="button radius">View All Reciters</a>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Category -->
    @endif
@endsection