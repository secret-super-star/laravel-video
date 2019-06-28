@extends('client.layouts.app')
@section('facebook_meta')
    <meta property="og:url" content="{{\Request::url()}}"/>
    <meta property="og:title" content="{{$series->name}}"/>
    <meta property="og:description" content="{{$series->description}}"/>
    <meta property="og:image" content="{{$series->thumbnail}}"/>
    <meta property="og:image:width" content="600"/>
    <meta property="og:image:height" content="315"/>
    <meta property="og:image:alt" content="{{$series->description}}"/>
    <meta property="og:video" content="{{\Request::url()}}"/>
    <meta property="fb:app_id" content="{{$fb_app_id}}"/>
    <script type='text/javascript' src='https://phpflock.com/jwplayer8/jwplayer.js'></script>
    <script type="text/javascript">jwplayer.key = "js7c9zo6THb2G8S7h1PIP5nOJ4aYu7bbm8flCJSaCNQ=";</script>

@endsection
@section('content')
    <div class="row row1">

        <div class="col-sm-9 sv1 ">

            @include('client.includes.add1')

            <div class="row panel panel-default mt15 panelForDetail">
                <div class="panel-heading">
                    <i></i>{{$series->name}}
                </div>
                <div class="panel-body" id="video-container">
                    <div id="player"></div>

                    <h3>{{$series->title}}</h3>
                    @php
                        $sData = json_decode($seriesVideo);
                    @endphp
                    <div id='player_preview'></div>

                    @foreach($series->seriesVideos as $val)
                        <input type="hidden" id="linkMe_{{$val->id}}"
                               value="{{str_replace('#', '_', str_replace(' ', '-', $val->link))}}">

                        @if(count($series->seriesVideos) > 1)
                            <input type="button" class="btn btn-default" id="btn_{{$loop->index}}"
                                   value="Part # {{$loop->index+1}}"
                                   onclick="redirectMeWithPart('{{$series->id}}', '{{$loop->index+1}}');"/>
                        @endif
                    @endforeach

									<?php
									$likedBit = 'none';
									$unlikedBit = 'block';
									?>
                    @if(\Auth::user())
                        @if($liked)
											<?php
											$likedBit = 'block';
											$unlikedBit = 'none';
											?>
                        @else
											<?php
											$likedBit = 'none';
											$unlikedBit = 'block';
											?>
                        @endif
                        <br/>
                        <button type="button" class="form-control btn btn-primary likeButton"
                                id="like_{{$val->series_id}}" onclick="likeMe('{{$val->series_id}}', 1)"
                                style="display: {{$unlikedBit}}">
                            <span class="fa fa-thumbs-o-up"></span> Like
                        </button>

                        <button type="button" class="form-control btn btn-primary likeButton"
                                id="unlike_{{$val->series_id}}" onclick="likeMe('{{$val->series_id}}', 2)"
                                style="display: {{$likedBit}}">
                            <span class="fa fa-thumbs-up"></span> UnLike
                        </button>
                        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

                    @endif

                    <div class="row fr">
                        <iframe src="https://www.facebook.com/plugins/share_button.php?href={{\Request::fullUrl()}}&layout=button_count&size=large&mobile_iframe=true&appId={{$fb_app_id}}&width=106&height=28"
                                width="106" height="28" style="border:none;overflow:hidden" scrolling="no"
                                frameborder="0" allowTransparency="true"></iframe>
                    </div>
                    <br/>
                    <br/>
                    @include('client.includes.add2')
                    <p><strong>Description:</strong> {{$series->description}}</p>
                    <p><strong>Category:</strong>
                        <span>	<a
                                    href="/category/{{str_replace('#', '_', str_replace(' ', '-', $series->seriesCategory->categoryDetail->category_title))}}">{{($series->seriesCategory->categoryDetail->category_title)}}</a></span>
                        @if(count($series->seriesCelebrities) > 0)
                            <span class="colorWhite">,</span>
                        @endif
                        @foreach($series->seriesCelebrities as $key=> $val)
                            @if($loop->last)
                                <a href="/reciter/{{str_replace('#', '_', str_replace(' ', '-', $val->celebrityDetail->name))}}">{{($val->celebrityDetail->name)}}</a>
                            @else
                                <a href="/reciter/{{str_replace('#', '_', str_replace(' ', '-', $val->celebrityDetail->name))}}">{{$val->celebrityDetail->name}}</a>
                                ,
                            @endif
                        @endforeach
                    </p>
                    <p><strong>Tag: </strong>
                        @foreach($series->seriesTag as $key=> $val)
                            @if($loop->last)
                                <a href="/tags/{{str_replace('#', '_', str_replace(' ', '-', $val->tagDetail->tag))}}">{{($val->tagDetail->tag)}}</a>
                            @else
                                <a href="/tags/{{str_replace('#', '_', str_replace(' ', '-', $val->tagDetail->tag))}}">{{($val->tagDetail->tag)}}</a>
                                ,
                            @endif
                        @endforeach
                    </p>
                    <div class="fb-comments" data-href="{{\Request::fullUrl()}}" data-numposts="5" data-width="100%"
                         data-colorscheme="dark"></div>

                </div>
            </div>

        </div>

        @include('client.includes.relatedVideos')

    </div>
    @php

        if(gettype($sData[0]->path) == 'array') {
            $path = $sData[0]->path[0]->file;
        }else {
          $path = $sData[0]->path;
        }
    @endphp
    <script type='text/javascript'>
			var type = '{{$sData[0]->type}}';
			if (type == 'video/mp4') {
				jwplayer('player_preview').setup({
					sources: [
						{file: '{!! $path !!}',},
					],
					image: '{!! $sData[0]->thumbnail !!}',
					height: 480,
					type: '{{$sData[0]->type}}',
					width: '100%',
					tracks: [],
					repeat: true,
					autostart: false,
					advertising: {
//			    client: 'googima',
//			    tag: 'https://googleads.g.doubleclick.net/pagead/ads?ad_type=video&client=ca-video-pub-4968145218643279&videoad_start_delay=0&description_url=http%3A%2F%2Fwww.google.com&max_ad_duration=40000&adtest=on'
					}
				});
			} else if (type == 'iframe') {
				$('#player_preview').html('<iframe scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="https://yastatic.net/yandex-video-player-iframe-api-bundles/1.0-173/?mq_url=' + encodeURIComponent('{!! $path !!}') + '&auto_quality=true&preload=true&preview=&host=" width="694px" height="480px"></iframe>');
			} else {
				jwplayer('player_preview').setup({
					file: '{!! $path !!}',
					image: '{!! $sData[0]->thumbnail !!}',
					height: 480,
					type: 'video/mp4',
					width: '100%',
					tracks: [],
					repeat: true,
					autostart: false,
					advertising: {
//						client: 'googima',
//						tag: 'https://googleads.g.doubleclick.net/pagead/ads?ad_type=video&client=ca-video-pub-4968145218643279&videoad_start_delay=0&description_url=http%3A%2F%2Fwww.google.com&max_ad_duration=40000&adtest=on'
					}
				});
			}
    </script>

@endsection