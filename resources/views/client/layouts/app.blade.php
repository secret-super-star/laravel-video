<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php
	if (isset(request()->route()->action['title']) ) {
		$title = request()->route()->action['title'];
	} else {
		if (isset($series) && isset($series->name)) {
			$title = $series->name;
		} else {
			$title = '404';
		}
	}
	
	?>
	
	<title> {{\Config::get('app.name')}} | {{$title}}</title>
	<meta name="description" content="{{$meta_description or ''}}">
	<meta name="Keywords" content="video, online, movies, GMA, PBA, Tonight with Boy Abunda" />
	<meta name="author" content="index.html">
	<meta name="csrf-token" content="">
	<link rel="icon" href="{{$favicon}}">
	<link rel="stylesheet" href="{{mix('/assets/client/gulp/client.css')}}">
	<link rel="stylesheet" href="{{asset('/assets/css/style.css')}}">
	
	<style>
		/*@media (min-width: 768px) {*/
			/*#project {*/
				/*width: 170px !important;*/
			/*}*/
		/*}*/
	</style>
	@if(strpos(\URL::to('/'),"yamiraan.tv") > 0)
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
			(adsbygoogle = window.adsbygoogle || []).push({
				google_ad_client: "ca-pub-7898445716532125",
				enable_page_level_ads: true
			});
		</script>
	@endif

	@yield('facebook_meta')
</head>
<style>
	.cc_message {
		height: 60px !important;
		color: white !important;
		padding-top: 20px !important;
		padding-left: 23px !important;
	}

	.cc_btn {
		margin-top: 20px;
		float: right;
	}

	.cc_btn_clr {
		background-color: yellow !important;
		color: black !important;
	}
</style>
<body class="">
<div class="col-sm-12" id="ckalert" style="display: none">
	<div class="col-sm-8">
		<p class="cc_message">
			This website uses cookies to ensure you get the best experience on our website
			<a data-cc-if="options.link" target="_blank" class="cc_more_info" href="/privacy">More info</a>
		</p>
	</div>
	<div class="col--sm-4 cc_btn" >
		<input type="button " class="btn btn-primary cc_btn_clr" id="git" value="Got it">
	</div>
</div>
	<div class="clearfix"></div>
<header>
	
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">
					<img src="{{$logo}}" alt="Logo Image" class="logoSize">
				
				</a>
			</div>
			
			<div id="navbar" class="navbar-collapse collapse mr15">
				<div class="navbar-form navbar-right" action="http://pakone.tv/search/" method="post" role="search" content="ml35">
					<div class="form-group">
						<input name="q" type="text" id="project" class="form-control w240" placeholder="Search" required="">
					</div>
					{{--<button type="submit" class="btn btn-default">Send</button>--}}
				</div>
				<ul class="nav navbar-nav navbar-left">
					@if(\Auth::user() )
						{{--<li><a href="/logout"><i class="fa fa-sign-out"></i>Logout</a></li>--}}
					@else
						<li><a href="/login"><i class="fa fa-sign-in"></i>Login</a></li>
					@endif
					{{--@if(\Auth::user() && \Auth::user()->hasRole('administrator'))--}}
						{{--<li><a href="/admin"><i class="fa fa-television"></i>Admin Dashboard</a></li>--}}
					{{--@endif--}}
					<li><a href="/"><i class="fa fa-home"></i>Home</a></li>
					<li><a href="/watch"><i class="fa fa-video-camera"></i>Watch</a></li>
					<li><a href="/categories"><i class="fa fa-television"></i>Categories</a></li>
					@if(isset($celebrity_module) && $celebrity_module)
						<li><a href="/reciters"><i class="fa fa-star"></i>Reciters</a></li>
					@endif
					@if(isset($video_groups_module) && $video_groups_module)
						<li><a href="/groups"><i class="fa fa-play-circle"></i>Groups</a></li>
						<li><a href="/cities"><i class="fa fa-globe"></i>City</a></li>
					@endif
					<li><a href="/users"><i class="fa fa-users"></i>Users</a></li>
					@if(Auth::user())
					<li class=" dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user"> </i> {{ucfirst(Auth::user()->name)}} <b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							@if(\Auth::user() && \Auth::user()->hasRole('administrator'))
							<li><a href="/admin">Admin Dashboard</a></li>
							@endif
								<li><a href="/dashboard">Dashboard</a></li>
							<li class="divider"></li>
							<li><a href="/logout">Logout</a></li>
						</ul>
					</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
	
</header>
<div class="container">
	
	<script src="{{mix('/assets/client/js/gulp/myclient.js')}}"></script>
	
	<main>
		
		@yield('content')
	
	</main>

</div>

<footer>
	<div class="copyright">
		<div class="container">
			<div class="col-sm-3 col-md-6">
				<p>© 2017 - {{\Config::get('app.name')}} -  <span class="cPointer" onclick="window.open('http://www.ahsanhussain.info')"><span class="fa fa-power-off "> </span> Ahsan Hussain </span></p>
			</div>
			<div class="col-md-6">
				<ul class="bottom_ul">
					<li>
						<a href="/privacy">Privacy Policy</a></li>
					<li><a href="/terms">Terms and Conditions</a></li>
				</ul>
			</div>
		</div>
	</div>
</footer>
<div id="subir" class=""><i class="fa fa-angle-double-up"></i></div>

<script>
  var interval;
  jQuery(function($) {
    $('a.video_img_link').hover(function() {
      var $image = $(this).find('img:eq(0)');
      var limite = $image.data('total');
      var files = $image.data('files').split(',');
      if ($image.length > 0 && limite > 1) {
        if ($image.data('tipo') == "youtube") {
          limite = 1;
        }
        interval = setInterval(function() {
          var newIndex = (parseInt($image.attr('data-current')) + 1);
          if (newIndex > limite) {
            newIndex = 1;
          }
          //var URL = 'uploads/thumbs/'+$image.data('name')+'-0'+newIndex+'.jpg';
          var URL = 'uploads/thumbs/' + files[newIndex - 1];
          if ($image.data('tipo') == "youtube") {
            URL = 'https://img.youtube.com/vi/' + $image.data('name') + '/' + (newIndex - 1) + '.jpg';
          }
          $image.attr('src', URL);
          $image.attr('data-current', newIndex);
        }, 350);
      }
    }, function() {
      clearInterval(interval);
    });
  });

  $("#project").autocomplete({
    source: function (request, response) {
      jQuery.get("/filterSeries", {
        query: request.term
      }, function (data) {
        // assuming data is a JavaScript array such as
        // ["one@abc.de", "onf@abc.de","ong@abc.de"]
        // and not a string
        response(data);
      });
    },
    minLength: 3,
    select: function( event, ui ) {
      console.log( "Selected: " + ui.item.value + " aka " + ui.item.label );
      window.location = '/video/'+ui.item.link;
    }
  });

  $("#project").data( "ui-autocomplete" )._renderItem = function( ul, item ) {

    return $( "<li></li>" )
      .data( "item.autocomplete", item )
      .append( "" + "<div class='col-sm-12 pt10pb10'>" +
        "<div class='col-sm-3 pl0' > <img width='80px' src='" + item.thumb + "' /> </div>" +
        "<div class='col-sm-9 pl35' > "+item.label+" </div>" +
        "</div>" +
        "" )
      .appendTo( ul );

    return $li.appendTo(ul);
  };

	$(function () {
		console.log(localStorage.getItem("acceptCookie"));
		if (localStorage.getItem("acceptCookie") == 'true') {

		} else {
			$('#ckalert').toggle('slow')
		}
	})

	$('#git').on('click', function(){
		$('#ckalert').toggle('slow')
		localStorage.setItem("acceptCookie", "true");
		console.log(localStorage.getItem("acceptCookie"));;
	});

</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId={{$fb_app_id}}";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>


{!! $g_analytics !!}

</body>

</html>