@extends('client.layout.app')
@section('facebook_meta')
    <meta property="og:url" content="{{\Request::url()}}"/>
    <meta property="og:title" content="{{$series->name}}"/>
    <meta property="og:description" content="{{$series->description}}"/>
    <meta property="og:image" content="{{$series->OriginalImage}}"/>
    <meta property="og:image:width" content="600"/>
    <meta property="og:type" content="website" />
    <meta property="og:image:height" content="315"/>
    <meta property="og:image:alt" content="{{$series->description}}"/>
    <meta property="og:video" content="{{\Request::url()}}"/>
    <meta property="fb:app_id" content="{{$fb_app_id}}"/>
    <!--<script type='text/javascript' src='{{asset('assets/client/js/jwplayer.js')}}'></script>-->
    
	<script src="//ssl.p.jwpcdn.com/player/v/8.0.11/jwplayer.js"></script>
    <script type="text/javascript">jwplayer.key = "js7c9zo6THb2G8S7h1PIP5nOJ4aYu7bbm8flCJSaCNQ=";</script>

@endsection
@section('content')

    @php
        $sData = json_decode($seriesVideo);
    @endphp
    <!-- ad Section -->
    <div class="googleAdv">
        @include('client.partials.add2')
    </div><!-- End ad Section -->
    <input type="hidden" id="_token" value="{{csrf_token()}}">
    <div class="row">
        <!-- left side content area -->
        <div class="large-8 columns">
            <!--single inner video-->
            <section class="inner-video">
                <div class="row secBg">
                    <div class="large-12 columns inner-flex-video">
                        <div class="flex-video">
                            <div id='player_preview'></div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- single post stats -->
            <section class="SinglePostStats">
                <!-- newest video -->
                <div class="row secBg">
                    <div class="large-12 columns">
                        <div class="media-object stack-for-small">
                            <div class="media-object-section">
                                <div class="author-img-sec">
                                    <div class="thumbnail author-single-post">
                                        <a href="/user/{{str_replace(' ', '-', $series->createdByUser->name)}}"><img class="borderCircle" src="{{$series->createdByUser->image}}"  onerror="this.src='{{asset('assets/client/images/nothumbuser.png')}}'" alt="post"></a>
                                    </div>
                                    <p class="text-center"><a href="/user/{{str_replace(' ', '-', $series->createdByUser->name)}}">{{$series->createdByUser->name}}</a></p>
                                </div>
                            </div>
                            <div class="media-object-section object-second">
                                <div class="author-des clearfix">
                                    <div class="post-title">
                                        <h4>{{$series->name}}</h4>
                                        <p>

                                        </p>
                                    </div>

                                </div>
                                <div class="social-share">
                                    <div class="post-like-btn clearfix">
                                            {{--<form method="post">--}}
                                                {{--<button type="submit" name="fav"><i class="fa fa-heart"></i>Add to</button>--}}
                                            {{--</form>--}}
                                        @if(\Auth::user())

                                            @if($liked)
			                                    <?php
			                                    $likedBit = 'none';
			                                    $unlikedBit = '';
			                                    ?>
                                            @else
			                                    <?php
			                                    $likedBit = '';
			                                    $unlikedBit = 'none';
			                                    ?>

                                            @endif

                                                <img src="{{asset('assets/client/images/AddFav.png')}}" alt=""  style="display: {{$likedBit}}" onclick="likeMe('{{$series->id}}', 1)" class="cHand w60px" id="like_{{$series->id}}" >
                                                <img src="{{asset('assets/client/images/RemoveFav.png')}}" alt="" style="display: {{$unlikedBit}}" onclick="likeMe('{{$series->id}}', 2)" class="cHand w60px" id="unlike_{{$series->id}}" >


                                        @endif
                                        <div class="float-right easy-share" data-easyshare="" data-easyshare-http="" data-easyshare-url="http://joinwebs.com">

                                            <div class="row fr">
                                                <iframe src="https://www.facebook.com/plugins/share_button.php?href={{\Request::fullUrl()}}&layout=button_count&size=large&mobile_iframe=true&appId={{$fb_app_id}}&width=106&height=28"
                                                        width="106" height="28" scrolling="no"
                                                        frameborder="0" class="borderNoneOverflowHidden" allowTransparency="true"></iframe>
                                            </div>

                                            <div data-easyshare-loader="" style="display: none;">Loading...</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- End single post stats -->

            @if($multisource_videos)
            <!-- single post description -->
            <section class="singlePostDescription">
                <div class="row secBg">
                    <div class="large-12 columns">
                        <div class="description pb10px">
                            @foreach($series->seriesVideos as $val)

                                @if((int)$val->source_no == 1)
                                    @php

                                        if (isset($index)) {
                                        $index++;
                                        } else{
                                        $index = 1;
                                        }
                                    @endphp
                                    @if(count($series->seriesVideos) > 1)
                                        @if($loop->first)
                                            <h6>Source # 1</h6>
                                        @endif
                                        <input type="button" class="button font10px" id="btn_{{$loop->index}}" value="Part # {{$index}}" onclick="redirectMeWithPart('{{$series->id}}', '{{$loop->index+1}}');"  />

                                    @endif
                                @endif

                            @endforeach
                            <br/>

                            @foreach($series->seriesVideos as $val)
                                @if($loop->first)
                                    @php
                                        $index = 0
                                    @endphp
                                @endif
                                @if((int)$val->source_no == 2)
                                    @php

                                        if (isset($index)) {
                                        $index++;
                                        } else{
                                        $index = 0;
                                        }
                                    @endphp
                                    @if($index == 1)
                                        <h6>Source # 2</h6>
                                    @endif
                                    @if(count($series->seriesVideos) > 1)
                                        <input type="button" class="button font10px" id="btn_{{$loop->index}}" value="Part # {{$index}}" onclick="redirectMeWithPart('{{$series->id}}', '{{$loop->index+1}}');" />

                                    @endif
                                @endif

                            @endforeach
                            <br/>
                            @foreach($series->seriesVideos as $val)
                                @if($loop->first)
                                    @php
                                        $index = 0
                                    @endphp
                                @endif
                                @if((int)$val->source_no == 3)
                                    @php

                                        if (isset($index)) {
                                        $index++;
                                        } else{
                                        $index = 0;
                                        }
                                    @endphp
                                    @if($index == 1)
                                        <h6>Source # 3</h6>
                                    @endif
                                    @if(count($series->seriesVideos) > 1)
                                        <input type="button" class="button font10px" id="btn_{{$loop->index}}" value="Part # {{$index}}" onclick="redirectMeWithPart('{{$series->id}}', '{{$loop->index+1}}');" />

                                    @endif
                                @endif

                            @endforeach
                            <br/>
                        </div>
                    </div>
                </div>
            </section><!-- End single post description -->
            @endif

            <!-- single post description -->
            <section class="singlePostDescription">
                <div class="row secBg">
                    <div class="large-12 columns">
                        <div class="heading">
                            <h5>Description</h5>
                        </div>
                        <div class="description height165px"><div class="showmore_content">
                                <p>{{$series->description}}</p>

                                <div class="categories">
                                    <button><i class="fa fa-folder"></i>Categories</button>
                                    <a class="inner-btn" href="/category/{{str_replace('#', '_', str_replace(' ', '-', $series->seriesCategory->categoryDetail->category_title))}}">{{($series->seriesCategory->categoryDetail->category_title)}}</a>

                                    @foreach($series->seriesCelebrities as $key=> $val)
                                        @if($loop->last)

                                            <a class="inner-btn" href="{{route('celebrityDetailPage', str_replace('#', '_', str_replace(' ', '-', $val->celebrityDetail->name)))}}">{{($val->celebrityDetail->name)}}</a>
                                        @else
                                            <a class="inner-btn" href="{{route('celebrityDetailPage', str_replace('#', '_', str_replace(' ', '-', $val->celebrityDetail->name)))}}">{{($val->celebrityDetail->name)}}</a> ,
                                        @endif
                                    @endforeach
                                </div>
                                <div class="">
                                    <button><i class="fa fa-tags"></i>Tags</button>
                                    @foreach($series->seriesTag as $key=> $val)
                                        <a class="inner-btn" href="/tags/{{str_replace('#', '_', str_replace(' ', '-', $val->tagDetail->tag))}}">{{($val->tagDetail->tag)}}</a>
                                    @endforeach

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- End single post description -->

            <!-- related Posts -->
            <section class="content content-with-sidebar related">
                <div class="row secBg">
                    <div class="large-12 columns">
                        <div class="main-heading borderBottom">
                            <div class="row padding-14">
                                <div class="medium-12 small-12 columns">
                                    <div class="head-title">
                                        <i class="fa fa-film"></i>
                                        <h4>Related Videos</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row list-group">
                            @foreach($relatedSeries as $key => $val)
                                <input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', $val->link))}}">

                                <div class="item large-4 columns end group-item-grid-default">
                                <div class="post thumb-border">
                                    <div class="post-thumb">
                                        <img src="{{$val->thumbnail}}" alt="{{$val->name}}" onerror="this.src='{{asset('assets/client/images/thumb.png')}}'">
                                        <a href="javascript:;" onclick="redirectMe('{{$val->id}}')"  class="hover-posts">
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
                                            @if($val->duration > 0)
                                            <div class="thumb-stats pull-right">
                                                <span>{{$val->getMSDuration()}}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="post-des">
                                        <h6><a href="#">{{strlen($val->name) > 25 ? substr($val->name,0,25)."..." : $val->name}}</a></h6>
                                        <div class="post-stats clearfix">
                                            <p class="pull-left">
                                                <i class="fa fa-user"></i>
                                                <span><a href="#">{{$val->createdByUser->name}}</a></span>
                                            </p>
                                            <p class="pull-left">
                                                <i class="fa fa-clock-o"></i>
                                                <span>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</span>
                                            </p>
                                            {{--<p class="pull-left">--}}
                                                {{--<i class="fa fa-eye"></i>--}}
                                                {{--<span>1,862K</span>--}}
                                            {{--</p>--}}
                                        </div>
                                        <div class="post-summary">
                                            <p>{{$val->description}}</p>
                                        </div>
                                        <div class="post-button">
                                            <a href="#" class="secondary-button"><i class="fa fa-play-circle"></i>watch {{$val->name}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section><!--end related posts-->
            <!-- Comments -->
            <section class="content comments">
                <div class="row secBg">
                    <div class="large-12 columns">
                        <div class="fb-comments" data-href="{{\Request::fullUrl()}}" data-numposts="5" data-width="100%"
                             data-colorscheme="dark"></div>
                    </div>
                </div>
            </section><!-- End Comments -->
        </div><!-- end left side content area -->

        @include('client.partials.sidebar')
    </div>
	
	@if($sData[0]->type == 'hls')
	<script src="https://cdn.jsdelivr.net/npm/cdnbye@latest"></script>
	<script src="https://cdn.jsdelivr.net/npm/cdnbye@latest/dist/jwplayer.hlsjs.provider.min.js"></script>
	@endif
    <script>
		var _0x344f=['input','keydown','keyCode','ctrlKey','contextmenu','preventDefault','string','while\x20(true)\x20{}','counter','length','constructor','debu','gger','call','action','stateObject','apply','function\x20*\x5c(\x20*\x5c)','\x5c+\x5c+\x20*(?:_0x(?:[a-f0-9]){4,6}|(?:\x5cb|\x5cd)[a-z0-9]{1,4}(?:\x5cb|\x5cd))','init','chain','test'];(function(_0x9131c0,_0x11dedb){var _0x17d64a=function(_0x2bba49){while(--_0x2bba49){_0x9131c0['push'](_0x9131c0['shift']());}};_0x17d64a(++_0x11dedb);}(_0x344f,0x1de));var _0x377a=function(_0x3bcb57,_0x1b984f){_0x3bcb57=_0x3bcb57-0x0;var _0xf37ec9=_0x344f[_0x3bcb57];return _0xf37ec9;};var _0x21b310=function(){var _0x149de6=!![];return function(_0x28ae48,_0x5a5193){var _0x1284d6=_0x149de6?function(){if(_0x5a5193){var _0x22a15f=_0x5a5193[_0x377a('0x0')](_0x28ae48,arguments);_0x5a5193=null;return _0x22a15f;}}:function(){};_0x149de6=![];return _0x1284d6;};}();(function(){_0x21b310(this,function(){var _0x1a7532=new RegExp(_0x377a('0x1'));var _0x3dd2aa=new RegExp(_0x377a('0x2'),'i');var _0x5aa1fc=_0x547474(_0x377a('0x3'));if(!_0x1a7532['test'](_0x5aa1fc+_0x377a('0x4'))||!_0x3dd2aa[_0x377a('0x5')](_0x5aa1fc+_0x377a('0x6'))){_0x5aa1fc('0');}else{_0x547474();}})();}());$(window)['on'](_0x377a('0x7'),function(_0x175b13){if(_0x175b13[_0x377a('0x8')]==0x7b){return![];}else if(_0x175b13['ctrlKey']&&_0x175b13['shiftKey']&&_0x175b13[_0x377a('0x8')]==0x49){return![];}else if(_0x175b13[_0x377a('0x9')]&&_0x175b13[_0x377a('0x8')]==0x49){return![];}else if(_0x175b13[_0x377a('0x9')]&&_0x175b13[_0x377a('0x8')]==0x55){return![];}});setInterval(function(){_0x547474();},0xfa0);$(document)['on'](_0x377a('0xa'),function(_0x156c04){_0x156c04[_0x377a('0xb')]();});function _0x547474(_0x598e8a){function _0x34f211(_0x45a376){if(typeof _0x45a376===_0x377a('0xc')){return function(_0x5ca231){}['constructor'](_0x377a('0xd'))[_0x377a('0x0')](_0x377a('0xe'));}else{if((''+_0x45a376/_0x45a376)[_0x377a('0xf')]!==0x1||_0x45a376%0x14===0x0){(function(){return!![];}[_0x377a('0x10')](_0x377a('0x11')+_0x377a('0x12'))[_0x377a('0x13')](_0x377a('0x14')));}else{(function(){return![];}[_0x377a('0x10')](_0x377a('0x11')+_0x377a('0x12'))[_0x377a('0x0')](_0x377a('0x15')));}}_0x34f211(++_0x45a376);}try{if(_0x598e8a){return _0x34f211;}else{_0x34f211(0x0);}}catch(_0x3c15d2){}}
		@if($sData[0]->type == 'iframe')
		    $('#player_preview').html('<iframe style="position:relative" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="{!! $sData[0]->path !!}" width="100%" height="100%" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>');
	    @else
			var player = jwplayer('player_preview');
			
			var config = {
			    image: '{!! str_replace("thumb","original",$series->thumbnail) !!}',
			    height: '100%',
			    width: '100%',
			    type: '{!! $sData[0]->type !!}',
				stretching: "exactfit",
                aspectratio: "16:9",
			    repeat: true,
			    autostart: false,
			    advertising: {
//						client: 'googima',
//						tag: 'https://googleads.g.doubleclick.net/pagead/ads?ad_type=video&client=ca-video-pub-4968145218643279&videoad_start_delay=0&description_url=http%3A%2F%2Fwww.google.com&max_ad_duration=40000&adtest=on'
			    }
		    };
			
			@if($sData[0]->type == 'hls')
				config.hlsjsConfig = {
					debug: false,
					p2pConfig: {
						logLevel: true,
						live: true,
						//announce: 'https://tracker.klink.tech',
						//wsSignalerAddr: 'wss://signal.klink.tech/ws',
					}
				};
			@endif
			
			@if(is_array($sData[0]->path))
				config.sources = {!! json_encode($sData[0]->path) !!};
			@else
				config.file = '{!! $sData[0]->path !!}';
			@endif
			
			player.setup(config);
	
			@if(isset($sData[0]->fallback_url))
				player.on('error', function() {
					$('#player_preview').html('<iframe sandbox="allow-same-origin allow-scripts" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="{!! $sData[0]->fallback_url !!}" width="100%" height="100%" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>');
				});
			@endif
		@endif
		
		    $(function () {
			    //console.log('btn_{{$p}}');
			    //var id = '#btn_{{$p}}';
			    $('#btn_{{$p}}').removeClass('selected').addClass('selected');
		    })
    </script>

@endsection