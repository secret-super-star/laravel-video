@extends('client.layout.app')
@section('content')

    <section class="content">
        <!-- End newest video -->
        <!-- popular Videos -->
        @if(isset($groupCategories) &&  count($groupCategories) > 0 || isset($places) && count($places) > 0)
            <div class="main-heading mt10">
                <div class="row secBg p10">
                    <div class="col-md-12 biggerBadgeParent">
                        <a href="javascript:;">

                            @if(isset($groupCategories))
                                @foreach($groupCategories as $val)
                                    <span class="tags"
                                          onclick="window.location='/groups/category/{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}'">{{$val->name}}</span>
                                @endforeach
                            @endif

                            @if(isset($places))
                                @foreach($places as $val)
                                    <span class="tags"
                                          onclick="window.location='/city/{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->name)))}}'">{{$val->name}}</span>
                                @endforeach
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <!-- left side content area -->
            <div class="large-8 columns">
                <section class="content content-with-sidebar">
                    <!-- newest video -->
                    <div class="main-heading">
                        <div class="row secBg padding-14">
                            <div class="medium-8 small-8 columns">
                                <div class="head-title">
                                    <i class="fa fa-film"></i>
                                    <h4>{{\Route::currentRouteName() == 'cities' ? ucfirst($cityName) : 'Groups'}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row secBg">
                        <div class="large-12 columns">
                            <div class="row column head-text clearfix">
                                <p class="pull-left">All Groups : <span>{{count($series)}}</span></p>
                                <div class="grid-system pull-right show-for-large">
                                    <a class="secondary-button current grid-default" href="javascript:;"><i
                                                class="fa fa-th"></i></a>
                                    <a class="secondary-button grid-medium" href="javascript:;"><i
                                                class="fa fa-th-large"></i></a>
                                    <a class="secondary-button list" href="javascript:;"><i
                                                class="fa fa-th-list"></i></a>
                                </div>
                            </div>
                            <div class="tabs-content" data-tabs-content="newVideos">


                                <div class="tabs-content" data-tabs-content="popularVideos">
                                    <div class="tabs-panel is-active" id="popular-all">
                                        <div class="row list-group">
                                            @foreach($series as $key => $val)
                                                @if($loop->last)
                                                    @php
                                                        $cls= 'end';
                                                    @endphp
                                                @else
                                                    @php
                                                        $cls= '';
                                                    @endphp
                                                @endif
                                                <input type="hidden" id="linkMe_{{$val->id}}"
                                                       value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}">
                                                @if($loop->last)
                                                    <div class="item large-3 medium-6 columns group-item-grid-default end">
                                                        @else
                                                            <div class="item large-3 medium-6 columns group-item-grid-default end">
                                                                @endif
                                                                <div class="post thumb-border">
                                                                    <div class="post-thumb">
                                                                        <img src="{{$val->thumbnail}}" alt="new video"
                                                                             onerror="this.src='{{asset('assets/client/images/thumb.png')}}'">
                                                                        <a href="javascript:;" class="hover-posts"
                                                                           onclick="redirectMeForGroup('{{$val->id}}')">
                                                                            <span><i class="fa fa-play"></i>Watch {{$val->name}}</span>
                                                                        </a>
                                                                        <div class="video-stats clearfix">
                                                                            {{--<div class="thumb-stats pull-left">--}}
                                                                            {{--<h6>HD</h6>--}}
                                                                            {{--</div>--}}
                                                                            {{--<div class="thumb-stats pull-left">--}}
                                                                            {{--<i class="fa fa-heart"></i>--}}
                                                                            {{--<span>506</span>--}}
                                                                            {{--</div>--}}
                                                                            {{--<div class="thumb-stats pull-right">--}}
                                                                            {{--<span>{{$val->getMSDuration()}}</span>--}}
                                                                            {{--</div>--}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="post-des">
                                                                        <h6><a href="javascript:;"
                                                                               onclick="redirectMeForGroup('{{$val->id}}')">{{strlen($val->name) > 28 ? substr($val->name,0,28)."..." : $val->name}}</a>
                                                                        </h6>
                                                                        <div class="post-stats clearfix">
                                                                            <p class="pull-left">
                                                                                <i class="fa fa-user"></i>
                                                                                <span>
            @php
              $placeName = strlen($val->name) > 8 ? substr($val->name,0,8)."..." : $val->name;
            @endphp
    <a href="javascript:;">
        <span onclick="window.location = '/city/{{str_replace('#', '_', str_replace(' ', '-', isset($val->cities->name) ? $val->cities->name : ''))}}'">{{$val->cities->name or ''}} </span>
        <span onclick="window.location = '/city/{{str_replace('#', '_', str_replace(' ', '-', isset($val->places->name) ? $val->places->name : ''))}}'">{{isset($val->places->name) ? ' / '.$placeName : ''}}</span>
    </a>
</span>
                                                                            </p>
                                                                            {{--<p class="pull-left">--}}
                                                                            {{--<i class="fa fa-clock-o"></i>--}}
                                                                            {{--<span>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</span>--}}
                                                                            {{--</p>--}}
                                                                        </div>
                                                                        <div class="post-summary">
                                                                            <p>{{$val->description}}</p>
                                                                        </div>
                                                                        <div class="post-button">
                                                                            <a href="javascript:;"
                                                                               class="secondary-button"
                                                                               onclick="redirectMeForGroup('{{$val->id}}')"><i
                                                                                        class="fa fa-play-circle"></i>watch
                                                                                video</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                    </div>
                                        </div>
                                    </div>

                                    @include('pagination.default',array(
                                        'series' => $series
                                    ))

                                </div>
                </section>
                <!-- ad Section -->
                <div class="googleAdv text-center">
                    @include('client.partials.add1')
                </div><!-- End ad Section -->


            </div><!-- end left side content area -->

            @include('client.partials.sidebar')
        </div>

    </section><!-- End main content -->
    <!-- movies -->

@endsection