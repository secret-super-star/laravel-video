@extends('client.layout.app')
@section('content')

    <!-- ad Section -->
    <div class="googleAdv">
        @include('client.partials.add2')
    </div><!-- End ad Section -->

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
                                <h4>Newest Videos</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row secBg">
                    <div class="large-12 columns">
                        <div class="row column head-text clearfix">
                            <p class="pull-left">All Videos : <span>{{count($series)}}</span></p>
                            <div class="grid-system pull-right show-for-large">
                                <a class="secondary-button grid-default" href="#"><i class="fa fa-th"></i></a>
                                <a class="secondary-button current grid-medium" href="#"><i class="fa fa-th-large"></i></a>
                                <a class="secondary-button list" href="#"><i class="fa fa-th-list"></i></a>
                            </div>
                        </div>
                        <div class="tabs-content" data-tabs-content="newVideos">


                            <div class="tabs-content" data-tabs-content="newVideos">
                                <div class="tabs-panel is-active" id="new-all" role="tabpanel" aria-hidden="false"
                                     aria-labelledby="new-all-label">
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
                                            <div class="item large-4 medium-6 columns grid-medium">
                                                <div class="post thumb-border">
                                                    <div class="post-thumb">
                                                        <img src="{{$val->thumbnail}}" alt="new video"
                                                             onerror="this.src='{{asset('assets/client/images/thumb.png')}}'">
                                                        <a href="javascript:;" class="hover-posts"
                                                           onclick="redirectMe('{{$val->id}}')">
                                                            <span><i class="fa fa-play"></i>Watch {{$val->name}}</span>
                                                        </a>
                                                        <div class="video-stats clearfix">

                                                            <div class="thumb-stats pull-right">
                                                                <span>{{$val->getMSDuration()}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="post-des">
                                                        <h6><a href="javascript:;"
                                                               onclick="redirectMe('{{$val->id}}')">{{strlen($val->name) > 22 ? substr($val->name,0,22)."..." : $val->name}}</a>
                                                        </h6>
                                                        <div class="post-stats clearfix">
                                                            <p class="pull-left">
                                                                <i class="fa fa-user"></i>
                                                                <span onclick="window.location = '/user/{{str_replace('#', '_', str_replace(' ', '-', isset($val->createdByUser->name) ? $val->createdByUser->name : ''))}}'"><a
                                                                            href="javascript:;">{{$val->createdByUser->name or ''}}</a></span>
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

                        </div>
                    </div>
            </section>
            <!-- ad Section -->
            <div class="googleAdv text-center">
                @include('client.partials.add1')
            </div><!-- End ad Section -->


        </div><!-- end left side content area -->
        <!-- sidebar -->
        <div class="large-4 columns padding-right-remove">
            <aside class="secBg sidebar">
                <div class="row">


                    <div class="large-12 medium-7 medium-centered columns">
                        <div class="widgetBox">
                            <div class="widgetTitle">
                                <h5>categories</h5>
                            </div>
                            <div class="widgetContent">
                                <ul class="accordion" data-accordion="wtkjkg-accordion" role="tablist">
                                    @foreach($categories as $key => $val)
                                        <li class="accordion-item " data-accordion-item="">
                                            <a href="#" class="accordion-title" aria-controls="i2bjiu-accordion"
                                               role="tab" id="i2bjiu-accordion-label" aria-expanded="true"
                                               aria-selected="true">{{$val->category_title}}</a>
                                            <div class="accordion-content" data-tab-content="" role="tabpanel"
                                                 aria-labelledby="i2bjiu-accordion-label" aria-hidden="false"
                                                 id="i2bjiu-accordion" style="display: none;">
                                                <ul>
                                                    @foreach($val->subCategories as $key1 => $val1)
                                                        <li class="clearfix">
                                                            <i class="fa fa-play-circle-o"></i>
                                                            <a href="javascript:;"
                                                               onclick="window.location='/category/{{str_replace(' ', '-', $val1->category_title)}}'">{{$val1->category_title}}</a>
                                                        </li>
                                                    @endforeach
                                                    @if(count($val->subCategories) < 1)
                                                        <li class="clearfix">
                                                            <i class="fa fa-play-circle-o"></i>
                                                            <a href="javascript:;">No Sub Category</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>


                </div>
            </aside>
        </div><!-- end sidebar -->
    </div>

@endsection