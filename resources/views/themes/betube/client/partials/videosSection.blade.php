@if(isset($showAdd))
<!-- ad Section -->
<div class="googleAdv">
    @include('client.partials.add2')
</div><!-- End ad Section -->

@endif
<section class="content">
    <!-- End newest video -->

    <!-- popular Videos -->
    <div class="main-heading" style="margin-top: 12px;">
        <div class="row secBg padding-14">
            <div class="medium-8 small-8 columns">
                <div class="head-title">
                    <i class="fa fa-star"></i>
                    <h4>New Videos</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="row column head-text clearfix">
                <p class="pull-left">New Videos : <span>{{count($data)}} Videos</span></p>
                <div class="grid-system pull-right show-for-large">
                    <a class="secondary-button current grid-default" href="#"><i class="fa fa-th"></i></a>
                    <a class="secondary-button grid-medium" href="#"><i class="fa fa-th-large"></i></a>
                    <a class="secondary-button list" href="#"><i class="fa fa-th-list"></i></a>
                </div>
            </div>
            <div class="tabs-content" data-tabs-content="popularVideos">
                <div class="tabs-panel is-active" id="popular-all">
                    <div class="row list-group">
                        @foreach($data as $key => $val)


                            <script type="application/ld+json">
								{
								  "@context": "http://schema.org",
								  "@type": "VideoObject",
								  "name": "{{$val->name or 'Dummy Name'}}",
								  "description": "{{$val->description}}",
								  "thumbnailUrl": "{{$val->thumbnail}}",
								  "uploadDate": "{{$val->created_at}}",
								  "duration": "{{$val->duration}}",
								  "publisher": {
								    "@type": "Organization",
								    "name": "{{$val->createdByUser->name or ''}}",
								    "logo": {
								      "@type": "ImageObject",
								      "url": "{{$val->thumbnail}}",
								      "width": 600,
								      "height": 60
								    }
								  },
								  "contentUrl": "{{URL::to('video/'.str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link))))}}",
								  "embedUrl": "{{URL::to('video/'.str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link))))}}",
								  "interactionCount": "{{count($val->videoViews)}}"
								}
								</script>


                            <input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}">
                            <div class="item large-3 medium-6 columns group-item-grid-default">
                                <div class="post thumb-border">
                                    <div class="post-thumb">
                                        <img src="{{$val->thumbnail}}" alt="new video" onerror="this.src='{{asset('assets/client/images/thumb.png')}}'" >
                                        <a href="/video/{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}" class="hover-posts" onclick="redirectMe('{{$val->id}}')">
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
                                        <h2><a href="/video/{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}" onclick="redirectMe('{{$val->id}}')">{{strlen($val->name) > 22 ? substr($val->name,0,22)."..." : $val->name}}</a></h2>
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
                                            <a href="/watch" class="secondary-button" onclick="redirectMe('{{$val->id}}')"><i class="fa fa-play-circle"></i>watch video</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            @if($viewAllBtn)
            <div class="text-center row-btn">
                <a class="button radius" href="/watch">View All Video</a>
            </div>
            @endif
        </div>
    </div>
    <!-- ad Section -->
    <div class="googleAdv">
        @include('client.partials.add2')
    </div><!-- End ad Section -->
</section><!-- End main content -->
<!-- movies -->