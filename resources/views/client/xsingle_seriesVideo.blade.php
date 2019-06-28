@extends('client.layouts.app')
@section('facebook_meta')
	<meta property="og:url" content="{{\Request::url()}}" />
	<meta property="og:title" content="{{$series->name}}" />
	<meta property="og:description" content="{{$series->description}}" />
	<meta property="og:image" content="{{$series->thumbnail}}" />
	<meta property="og:image:width" content="600" />
	<meta property="og:image:height" content="315" />
	<meta property="og:image:alt" content="{{$series->description}}" />
	<meta property="og:video" content="{{\Request::url()}}" />
	<meta property="fb:app_id" content="{{$fb_app_id}}" />
@endsection
@section('content')
	<style>
		#player {
				height: 480px;
			}
			
		@media only screen and (max-width: 759px) {
			#player {
				height: auto;
			}
		}
	</style>
	<script src="https://ssl.p.jwpcdn.com/player/v/7.12.6/jwplayer.js"></script>
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
					
					@foreach($series->seriesVideos as $val)
						<input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', $val->link))}}">
						
					@if(count($series->seriesVideos) > 1)
						<input type="button" class="btn btn-default" id="btn_{{$loop->index}}" value="Part # {{$loop->index+1}}" onclick="redirectMeWithPart('{{$series->id}}', '{{$loop->index+1}}');" />
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

						<button type="button" class="form-control btn btn-primary likeButton" id="like_{{$val->series_id}}" onclick="likeMe('{{$val->series_id}}', 1)" style="display: {{$unlikedBit}}">
							<span class="fa fa-thumbs-o-up"></span> Like
						</button>
						
						<button type="button" class="form-control btn btn-primary likeButton" id="unlike_{{$val->series_id}}" onclick="likeMe('{{$val->series_id}}', 2)" style="display: {{$likedBit}}">
							<span class="fa fa-thumbs-up"></span> UnLike
						</button>
						<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
					
					@endif
					
					<div class="row fr">
						<iframe src="https://www.facebook.com/plugins/share_button.php?href={{\Request::fullUrl()}}&layout=button_count&size=large&mobile_iframe=true&appId={{$fb_app_id}}&width=106&height=28" width="106" height="28" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
					</div>
					<br/>
					<br/>
					@include('client.includes.add2')
						<p><strong>Description:</strong> {{$series->description}}</p>
					<p><strong>Category:</strong>
						<span>	<a href="/category/{{str_replace('#', '_', str_replace(' ', '-', $series->seriesCategory->categoryDetail->category_title))}}">{{($series->seriesCategory->categoryDetail->category_title)}}</a></span>
					@if(count($series->seriesCelebrities) > 0)
						<span class="colorWhite">,</span>
					@endif
						@foreach($series->seriesCelebrities as $key=> $val)
							@if($loop->last)
							<a href="/reciter/{{str_replace('#', '_', str_replace(' ', '-', $val->celebrityDetail->name))}}">{{($val->celebrityDetail->name)}}</a>
							@else
							<a href="/reciter/{{str_replace('#', '_', str_replace(' ', '-', $val->celebrityDetail->name))}}">{{$val->celebrityDetail->name}}</a> ,
							@endif
						@endforeach
					</p>
					<p><strong>Tag: </strong>
						@foreach($series->seriesTag as $key=> $val)
							@if($loop->last)
								<a href="/tags/{{str_replace('#', '_', str_replace(' ', '-', $val->tagDetail->tag))}}">{{($val->tagDetail->tag)}}</a>
							@else
								<a href="/tags/{{str_replace('#', '_', str_replace(' ', '-', $val->tagDetail->tag))}}">{{($val->tagDetail->tag)}}</a>,
							@endif
						@endforeach
					</p>
					<div class="fb-comments" data-href="{{\Request::fullUrl()}}" data-numposts="5" data-width="100%" data-colorscheme="dark"></div>
				
				</div>
			</div>
			
			<script type="text/javascript">
        var item = ('{!! $seriesVideo !!}');
        var item = JSON.parse(item);
        var obj = [];
		is_fallback = false;
		
        $.each(item, function (key, val) {
		  if (val.type == 'video/mp4')
		  {
			  obj.push({
				"sources": val.path,
				"image": val.thumbnail,
				"title": 'video # ' + key+1,
				"type": val.type
			  });

			  if (val.hasOwnProperty('fallback_url'))
			  {
				  is_fallback = val.fallback_url;
			  }
			  
		  } else if (val.type == 'iframe') {
			  $('#player').html('<iframe scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="https://yastatic.net/yandex-video-player-iframe-api-bundles/1.0-173/?mq_url=' + encodeURIComponent(val.path) + '&auto_quality=true&preload=true&preview=&host=" width="100%" height="100%"></iframe>');
		  }  else {
			  obj.push({
				"file": val.path,
				"image": val.thumbnail,
				"title": 'video # ' + key+1,
				"type": val.type
			  });
		  }
        });
				
		player = jwplayer('player');
        //Create a function to load a playlist var
        function loadPlaylist(thePlaylist) {
          player.setup({
            autostart: false,
			key: 'XYS/ica6YQUMq9rC6J2E77obUFoIPLeM',
			playlist: thePlaylist,
			width: "100%",
			height: 480,
			aspectratio: "16:9",
			controls: true,
			displaydescription: false,
			displaytitle: false,
          });
		  
		  if (is_fallback !== false)
		  {
			player.on('error', function () {
			  if (is_fallback.indexOf('vid.me') !== -1)
			  {//vid.me
				$('#player').html('<iframe scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="' + is_fallback + '" width="100%" height="480"></iframe>');
			  } else {			//youtube	  
				  player.load({
					file:is_fallback,
					width: "100%",
					height: 480,
					aspectratio: "16:9",
					controls: true,
					displaydescription: false,
					displaytitle: false,
				  });
				  
				  player.play();
			  }
			 });
		  }
		  
          player.on('play', function () {
            //console.log('index now');
            var id =player.getPlaylistIndex();
            console.log(player.getPlaylistIndex());

            var count = '{{count($series->seriesVideos)}}';
            for (var i =0; i < count; i++) {
              $('#btn_'+i).removeClass('btn-primary');
              $('#btn_'+i).removeClass('btn-default');
              $('#btn_'+i).addClass('btn-default');
            }

            setTimeout(function () {
              $('#btn_'+id).removeClass('btn-default');
              $('#btn_'+id).addClass('btn-primary');
            }, 300)

          })
        }
		
		if (obj.length > 0)
		{
			loadPlaylist(obj);
		}
		
        function playPart(id) {
          player.playlistItem(id);
        }

        $(function () {
          setTimeout(function () {
            console.log('{{$p}}');
            if (parseInt('{{$p}}') == 0) {
            } else {
              player.playlistItem('{{$p-1}}');
            }
          }, 300);

        })
			</script>
		
		</div>
		
		@include('client.includes.relatedVideos')
	
	</div>

@endsection