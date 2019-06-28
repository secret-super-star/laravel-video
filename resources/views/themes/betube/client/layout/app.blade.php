<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    {{--<title> {{$meta_title}} </title>--}}
        <meta name="description" content="{{$meta_description or ''}}">
    <meta name="Keywords" content="video, online, movies, GMA, PBA, Tonight with Boy Abunda" />
    <meta name="author" content="">
    <meta name="csrf-token" content="">
    <link rel="icon" href="{{$favicon}}">
    <link rel="stylesheet" href="{{mix('assets/themes/betube/css/betube.css')}}">
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

    {{--Theme Styling--}}
        @include('client.partials.theming')
    {{--Theme Styling--}}
    <style>
        .g {
            background-color: #444444 !important;
        }
        .ui-autocomplete {
            width: 1204px;
            top: -2808.47px ;
            left: 46px !important ;
            background-color: #2e2e2e !important;
            color: white  !important;
        }

        .content .main-heading {
            margin-bottom: 10px !important;
        }

        .main-heading {
            margin-bottom: 10px !important;
        }

        .content .post .post-thumb img {
            object-fit: fill;
        }

        #navBar .search-bar-light .search-input {
            width: 100%
        }
        .height314px {
            height: 314px;
        }
        .height165px {
            height: 240px;
        }
        .w184h128 {
            width: 184px;
            height: 128px;
        }
        .w185h260 {
            width: 185px;
            height: 260px;
        }
        .w60px {
            width: 60px !important;
        }
        .txtAlignCenter {
            text-align: center;
        }

        .figureMargin {
            margin: 13px 8px 20px !important;
        }

        .marginzero {
            margin-bottom: 0px !important;
        }

        .premium {
            margin-bottom: 0px !important;
        }

        .moviesImage {
            position: relative;
            width: 190px;
            height: 260px;
            margin: 0;
            border: 1px solid #ececec;
        }
        .w100P {
            width: 100%;
        }
        .borderNoneOverflowHidden {
            border: none;
            overflow: hidden;
        }
        .pb10px {
            padding-bottom: 10px;
        }
        .font10px {
            font-size: 10px;
        }
        .tags {
            display: inline-block;
            background: #6c6c6c;
            color: #aaaaaa;
            font-size: 13px;
            text-transform: capitalize;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 5px;
            line-height: 13px;
        }

        .tags:hover {
            background: #e96969;
            color: #fff;
        }

        .p10 {
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .mt10 {
            margin-top: 10px;
        }

        .topButtons {
            border-top: 1px solid #ECECEC;
            margin: 14px 0px 22px -11px;
            padding: 9px;
            width: 100%;
        }
        .cntr {
            transform: translate(-51%, 0%);
            margin-left: 50%;
        }

        .video-content {
            border-bottom: 0px !important;
        }

        select {
            padding: 11px 11px 11px 18px;
            font-size: 12px;
            color: #afafaf;

        }

        .video-content {
            border-bottom: 0px !important;
        }

        select {
            padding: 11px 11px 11px 18px;
            font-size: 12px;
            color: #afafaf;

        }

        .cardHeigh140 {
            height: 140px !important;
        }
        /**
        ** Card CSS
        **/

        /*a.colorWhite.font18 {*/
        /*color: #444;*/
        /*}*/

        .card {
            padding-top: 20px;
            margin: 10px 0 20px 0;
            background-color: rgba(214, 224, 226, 0.2);
            border-top-width: 0;
            border-bottom-width: 2px;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .card .card-heading {
            padding: 0 20px;
            margin: 0;
        }

        .card .card-heading.simple {
            font-size: 20px;
            font-weight: 300;
            color: #777;
            border-bottom: 1px solid #e5e5e5;
        }

        .card .card-heading.image img {
            display: inline-block;
            width: 46px;
            height: 46px;
            margin-right: 15px;
            vertical-align: top;
            border: 0;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
        }

        .card .card-heading.image .card-heading-header {
            display: inline-block;
            vertical-align: top;
        }

        .card .card-heading.image .card-heading-header h3 {
            margin: 0;
            font-size: 14px;
            line-height: 16px;
            color: #262626;
        }

        .card .card-heading.image .card-heading-header span {
            font-size: 12px;
            color: #999999;
        }

        .card .card-body {
            padding: 0 20px;
            margin-top: 20px;
        }

        .card .card-media {
            padding: 0 20px;
            margin: 0 -14px;
        }

        .card .card-media img {
            max-width: 100%;
            max-height: 100%;
        }

        .card .card-actions {
            min-height: 30px;
            padding: 0 20px 20px 20px;
            margin: 20px 0 0 0;
        }

        .card .card-comments {
            padding: 20px;
            margin: 0;
            background-color: #f8f8f8;
        }

        .card .card-comments .comments-collapse-toggle {
            padding: 0;
            margin: 0 20px 12px 20px;
        }

        .card .card-comments .comments-collapse-toggle a,
        .card .card-comments .comments-collapse-toggle span {
            padding-right: 5px;
            overflow: hidden;
            font-size: 12px;
            color: #999;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .card-comments .media-heading {
            font-size: 13px;
            font-weight: bold;
        }

        .card.people {
            position: relative;
            display: inline-block;
            width: 170px;
            height: 300px;
            padding-top: 0;
            margin-left: 20px;
            overflow: hidden;
            vertical-align: top;
        }

        .card.people:first-child {
            margin-left: 0;
        }

        .card.people .card-top {
            position: absolute;
            top: 0;
            left: 0;
            display: inline-block;
            width: 170px;
            height: 150px;
            background-color: #ffffff;
        }

        .card.people .card-top.green {
            background-color: #53a93f;
        }

        .card.people .card-top.blue {
            background-color: #427fed;
        }

        .card.people .card-info {
            position: absolute;
            top: 150px;
            display: inline-block;
            width: 100%;
            height: 101px;
            overflow: hidden;
            background: #ffffff;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .card.people .card-info .title {
            display: block;
            margin: 8px 14px 0 14px;
            overflow: hidden;
            font-size: 16px;
            font-weight: bold;
            line-height: 18px;
            color: #404040;
        }

        .card.people .card-info .desc {
            display: block;
            margin: 8px 14px 0 14px;
            overflow: hidden;
            font-size: 12px;
            line-height: 16px;
            color: #737373;
            text-overflow: ellipsis;
        }

        .card.people .card-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            display: inline-block;
            width: 100%;
            padding: 10px 20px;
            line-height: 29px;
            text-align: center;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .card.hovercard {
            position: relative;
            padding-top: 0;
            overflow: hidden;
            text-align: center;
            background-color: rgba(214, 224, 226, 0.2);
            height: 187px;
        }

        .card.hovercard .cardheader {
            background-size: cover;
            height: 83px;
        }

        .banner {
            background: url("http://lorempixel.com/850/280/nature/4/");
            background-position: center center !important;
            background-size: cover !important;
        }

        .card.hovercard .avatar {
            position: relative;
            top: -50px;
            margin-bottom: -50px;
        }

        .card.hovercard .avatar img {
            width: 100px;
            height: 100px;
            max-width: 100px;
            max-height: 100px;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            border: 5px solid rgba(255,255,255,0.5);
        }

        .card.hovercard .info {
            padding: 4px 8px 10px;
        }

        .card.hovercard .info .title {
            margin-bottom: 4px;
            font-size: 24px;
            line-height: 1;
            color: #262626;
            vertical-align: middle;
            cursor: pointer !important;
        }

        .card.hovercard .info .desc {
            overflow: hidden;
            font-size: 12px;
            line-height: 20px;
            color: #737373;
            text-overflow: ellipsis;
        }

        .card.hovercard .bottom {
            padding: 0 20px;
            margin-bottom: 17px;
        }

        .font18 {
            font-size: 18px
        }

        .pl3pr3{
            padding-left: 3px;
            padding-right: 3px
        }

        .biggerBadgeParent {
            border-radius: 3px;
            margin-left: -11px;
            padding: 5px
        }

        .biggerBadge {
            background-color: #444444 !important;
            padding: 14px 20px !important;
            color: red;
        }

        .fn14 {
            font-size: 14px !important;
        }
        .topProfile {
            margin-bottom: 55px;
        }
        .pagination a {
            padding: 0px 0px
        }
        /*.content .post .post-thumb img {*/
            /*object-fit: contain;*/
        /*}*/
        #category #owl-demo-cat .item-cat figure img {
            object-fit: contain;
        }
        .selected {
            background-color: #e96969;
        }


        /* Smartphones (portrait and landscape) ----------- */
        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
            /* Styles */
        }

        /* Smartphones (landscape) ----------- */
        @media only screen and (min-width: 321px) {
            /* Styles */
        }

        /* Smartphones (portrait) ----------- */
        @media only screen and (max-width: 320px) {
            /* Styles */
        }

        /* iPads (portrait and landscape) ----------- */
        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
            /* Styles */
        }

        /* iPads (landscape) ----------- */
        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) {
            /* Styles */
        }

        /* iPads (portrait) ----------- */
        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait) {
            /* Styles */
        }

        /* iPad 3 (landscape) ----------- */
        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 2) {
            /* Styles */
        }

        /* iPad 3 (portrait) ----------- */
        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait) and (-webkit-min-device-pixel-ratio: 2) {
            /* Styles */
        }

        /* Desktops and laptops ----------- */
        @media only screen and (min-width: 1224px) {
            /* Styles */
        }

        /* Large screens ----------- */
        @media only screen and (min-width: 1824px) {
            /* Styles */
        }

        /* iPhone 4 (landscape) ----------- */
        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 2) {
            /* Styles */
        }

        /* iPhone 4 (portrait) ----------- */
        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) and (orientation: portrait) and (-webkit-min-device-pixel-ratio: 2) {
            /* Styles */
        }

        /* iPhone 5 (landscape) ----------- */
        @media only screen and (min-device-width: 320px) and (max-device-height: 568px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2) {
            /* Styles */
        }

        /* iPhone 5 (portrait) ----------- */
        @media only screen and (min-device-width: 320px) and (max-device-height: 568px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2) {
            /* Styles */
        }

        /* iPhone 6 (landscape) ----------- */
        @media only screen and (min-device-width: 375px) and (max-device-height: 667px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2) {
            /* Styles */
        }

        /* iPhone 6 (portrait) ----------- */
        @media only screen and (min-device-width: 375px) and (max-device-height: 667px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2) {
            /* Styles */
        }

        /* iPhone 6+ (landscape) ----------- */
        @media only screen and (min-device-width: 414px) and (max-device-height: 736px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2) {
            /* Styles */
        }

        /* iPhone 6+ (portrait) ----------- */
        @media only screen and (min-device-width: 414px) and (max-device-height: 736px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2) {
            /* Styles */
        }

        /* Samsung Galaxy S3 (landscape) ----------- */
        @media only screen and (min-device-width: 320px) and (max-device-height: 640px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2) {
            /* Styles */
        }

        /* Samsung Galaxy S3 (portrait) ----------- */
        @media only screen and (min-device-width: 320px) and (max-device-height: 640px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2) {
            /* Styles */
        }

        /* Samsung Galaxy S4 (landscape) ----------- */
        @media only screen and (min-device-width: 320px) and (max-device-height: 640px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 3) {
            /* Styles */
        }

        /* Samsung Galaxy S4 (portrait) ----------- */
        @media only screen and (min-device-width: 320px) and (max-device-height: 640px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 3) {
            /* Styles */
        }

        /* Samsung Galaxy S5 (landscape) ----------- */
        @media only screen and (min-device-width: 360px) and (max-device-height: 640px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 3) {
            /* Styles */
        }

        /* Samsung Galaxy S5 (portrait) ----------- */
        @media only screen and (min-device-width: 360px) and (max-device-height: 640px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 3) {
            /* Styles */
        }


        /* Large desktop */
        @media (min-width: 1200px) {
            .inner-video .inner-flex-video .flex-video.widescreen {
                padding-bottom: 50.2%;
            }
        }

        /* Portrait tablet to landscape and desktop */
        @media (min-width: 768px) and (max-width: 979px) {
            .inner-video .inner-flex-video .flex-video.widescreen {
                padding-bottom: 50.2%;
            }
        }

        /* Landscape phone to portrait tablet */
        @media (max-width: 767px) {
            .inner-video .inner-flex-video .flex-video.widescreen {
                padding-bottom: 386.2px;
            }
        }

        /* Landscape phones and down */
        @media (max-width: 480px) {
            .inner-video .inner-flex-video .flex-video.widescreen {
                padding-bottom: 380px;
            }
        }


        /*@media (max-width:770px)  {*/
            /*!* smartphones, iPhone, portrait 480x320 phones *!*/
            /*.inner-video .inner-flex-video .flex-video.widescreen {*/
                /*padding-bottom: 50.2%;*/
            /*}*/
        /*}*/
        /*@media (max-width:600px)  {*/
            /*!* smartphones, iPhone, portrait 480x320 phones *!*/
            /*.inner-video .inner-flex-video .flex-video.widescreen {*/
                /*padding-bottom: 80%;*/
            /*}*/
        /*}*/
        /*@media (max-width:722px)  {*/
            /*!* smartphones, iPhone, portrait 480x320 phones *!*/
            /*.inner-video .inner-flex-video .flex-video.widescreen {*/
                /*padding-bottom: 65%;*/
            /*}*/
        /*}*/
        /*@media (max-width:700px)  {*/
            /*!* smartphones, iPhone, portrait 480x320 phones *!*/
            /*.inner-video .inner-flex-video .flex-video.widescreen {*/
                /*padding-bottom: 100%;*/
            /*}*/
        /*}*/
        /*@media (max-width:415px)  {*/
            /*!* smartphones, iPhone, portrait 480x320 phones *!*/
            /*.inner-video .inner-flex-video .flex-video.widescreen {*/
                /*padding-bottom: 120%;*/
            /*}*/
        /*}*/
        .mobAppsImgs{
            width: 240px;
            padding: 3px;
            border-radius: 17px;
            cursor: pointer;
        }

        /*handling H1 and H2 for SEO Purpose*/
        h1 {
            font-size: 1.125rem !important;
        }
        h2 {
            font-size: 13px !important;
        }
        h2 a{
            color: white !important;
        }
    </style>
</head>
<body>
<div class="off-canvas-wrapper">
    <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
        <!--header-->
        <div class="off-canvas position-left light-off-menu" id="offCanvas-responsive" data-off-canvas>
            <div class="off-menu-close">
                <h3>Menu</h3>
                <span data-toggle="offCanvas-responsive"><i class="fa fa-times"></i></span>
            </div>
            <ul class="vertical menu off-menu" data-responsive-menu="drilldown">
                <li class="has-submenu">
                    <a href="/"><i class="fa fa-home"></i>Home</a>
                </li>
                <li class="has-submenu" data-dropdown-menu="example1">
                    <a href="/watch"><i class="fa fa-video-camera"></i>Watch</a>
                </li>
                @if(isset($blog_module))
                <li class="has-submenu" data-dropdown-menu="example1">
                    <a href="/blog"><i class="fa fa-video-camera"></i>Blog</a>
                </li>
                @endif
                @if(isset($celebrity_module) && $celebrity_module)
                <li><a href="{{route('reciters')}}"><i class="fa fa-star"></i>Celebrities</a></li>
                @endif
                @if(isset($video_groups_module) && $video_groups_module)
                <li><a href="/groups"><i class="fa fa-play-circle"></i>Groups</a></li>
                <li><a href="/cities"><i class="fa fa-globe"></i>Cities</a></li>
                @endif

                <li><a href="/users"><i class="fa fa-users"></i>Users</a></li>

            @if(Auth::user())
                @if(\Auth::user() && \Auth::user()->hasRole('administrator'))
                <li><a href="/admin"><i class="fa fa-users"></i>Admin Dashboard</a></li>
                @endif
                <li><a href="/dashboard"><i class="fa fa-users"></i>Dashboard</a></li>
                <li><a href="/logout"><i class="fa fa-users"></i>Logout</a></li>

            @else
            </ul>


            <div class="top-button">
                <ul class="menu">
                    <li class="dropdown-login">
                        <a href="/login">login/Register</a>
                    </li>
                </ul>
            </div>
            @endif
        </div>
        <div class="off-canvas-content" data-off-canvas-content>
            <header>
                <!-- Top -->
                <section id="top" class="topBar show-for-large">
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="socialLinks">
                                <a  href="https://www.facebook.com/YamiraanNetwork/" target="_blank"><i class="fa fa-facebook-f"></i></a>
                                <a href="javascript:;"><i class="fa fa-twitter"></i></a>
                                <a href="javascript:;"><i class="fa fa-google-plus"></i></a>
                                <a href="javascript:;"><i class="fa fa-instagram"></i></a>
                                <a href="javascript:;"><i class="fa fa-vimeo"></i></a>
                                <a href="javascript:;"><i class="fa fa-youtube"></i></a>
                            </div>
                        </div>
                        <div class="medium-6 columns">
                            <div class="top-button">
                                <ul class="menu float-right">
                                    {{--<li>--}}
                                        {{--<a href="submit-post.html">upload Video</a>--}}
                                    {{--</li>--}}
                                    <li class="dropdown-login">
                                        @if(!\Auth::user())
                                        <a class="" href="/login">login/Register</a>
                                        @endif
                                        <div class="login-form">
                                            <h6 class="text-center">Great to have you back!</h6>
                                            <form method="post">
                                                <div class="input-group">
                                                    <span class="input-group-label"><i class="fa fa-user"></i></span>
                                                    <input class="input-group-field" type="text" placeholder="Enter username">
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-label"><i class="fa fa-lock"></i></span>
                                                    <input class="input-group-field" type="text" placeholder="Enter password">
                                                </div>
                                                <div class="checkbox">
                                                    <input id="check1" type="checkbox" name="check" value="check">
                                                    <label class="customLabel" for="check1">Remember me</label>
                                                </div>
                                                <input type="submit" name="submit" value="Login Now">
                                            </form>
                                            <p class="text-center">New here? <a class="newaccount" href="/register">Create a new Account</a></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section><!-- End Top -->
                <!--Navber-->
                <section id="navBar">
                    <nav class="sticky-container" data-sticky-container>
                        <div >
                            <div class="row">
                                <div class="large-12 columns">
                                    <div class="title-bar" data-responsive-toggle="beNav" data-hide-for="large">
                                        <button class="menu-icon" type="button" data-toggle="offCanvas-responsive"></button>
                                        <div class="title-bar-title"><img src="{{$logo}}" alt="logo"></div>
                                    </div>

                                    <div class="top-bar show-for-large w100P" id="beNav">
                                        <div class="top-bar-left">
                                            <ul class="menu">
                                                <li class="menu-text">
                                                    <a href="/"><img src="{{$logo}}" alt="logo"></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="top-bar-right search-btn">
                                            <ul class="menu">
                                                <li class="search">
                                                    <i class="fa fa-search"></i>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="top-bar-right">
                                            <ul class="menu vertical medium-horizontal" data-responsive-menu="drilldown medium-dropdown">
                                                <li><a href="/"><i class="fa fa-home"></i>Home</a></li>
                                                <li><a href="/watch"><i class="fa fa-video-camera"></i>Watch</a></li>
                                                @if(isset($blog_module))
                                                <li><a href="/blog"><i class="fa fa-rss"></i>Blog</a></li>
                                                @endif
                                                {{--<li><a href="/categories"><i class="fa fa-television"></i>Categories</a></li>--}}
                                                @if(isset($celebrity_module) && $celebrity_module)
                                                    <li><a href="{{route('reciters')}}"><i class="fa fa-star"></i>Celebrities</a></li>
                                                @endif
                                                @if(isset($video_groups_module) && $video_groups_module)
                                                    <li><a href="/groups"><i class="fa fa-play-circle"></i>Groups</a></li>
                                                    <li><a href="/cities"><i class="fa fa-globe"></i>City</a></li>
                                                @endif
                                                <li><a href="/users"><i class="fa fa-users"></i>Users</a></li>

                                                @if(Auth::user())
                                                <li>
                                                    <a href="javascript:;"><i class="fa fa-user"></i>{{ucfirst(Auth::user()->name)}}</a>
                                                    <ul class="submenu menu vertical" data-submenu data-animate="slide-in-down slide-out-up">
                                                        <li>
                                                            @if(\Auth::user() && \Auth::user()->hasRole('administrator'))
                                                            <a href="/admin">
                                                                <i class="fa fa-edit"></i>Admin Dashboard
                                                            </a>
                                                            @endif
                                                            <a href="/dashboard">
                                                                <i class="fa fa-edit"></i>Dashboard
                                                            </a>
                                                            <a href="/logout">
                                                                <i class="fa fa-edit"></i>Logout
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="search-bar" class="clearfix search-bar-light">
                                    <div class="search-input float-left">
                                        <input type="search" name="q" placeholder="Seach Here your video" id="project">
                                    </div>
                                    {{--<div class="search-btn float-right text-right">--}}
                                        {{--<button class="button" name="search" type="submit">search now</button>--}}
                                    {{--</div>--}}
                            </div>
                        </div>
                    </nav>
                </section>
            </header><!-- End Header -->
            <!--breadcrumbs-->
            <section id="breadcrumb">
                <div class="row">
                    <div class="large-12 columns">
                        <nav aria-label="You are here:" role="navigation">
                           <ul class="breadcrumbs">
                               <li><i class="fa fa-home"></i><a href="/">Home</a></li>
                                <li>
                                    @php
                                      $cityandplace= '';
                                      $route  = ucfirst(\Route::currentRouteName());
                                      if (\Route::currentRouteName() == 'cities') {
                                        $cityandplace = isset($cityName) ? '/ '. $cityName : '';
                                      } else {
                                        $cityandplace = '';
                                      }

                                    if($route == 'CelebrityPage') {
                                        $route = isset($data->name) ? $data->name : '';
                                     }
                                    @endphp
                                    <span class="show-for-sr">Current: </span>
                                    {{$route == 'Root' ? '' : $route}} {{$cityandplace}}
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </section><!--end breadcrumbs-->

            {{--<div id="overlay">--}}
                {{--<div id="progstat"></div>--}}
                {{--<div id="progress"></div>--}}
            {{--</div>--}}
            <script src="{{mix('assets/themes/betube/js/betube.js')}}" ></script>

             @yield('content')

             <!-- script files -->
            <script src="https://code.jquery.com/jquery-1.12.1.min.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

            @yield('js')
            <script>
                function showCategories(name) {
                    event.stopPropagation();
	                window.location='/category/'+name;
                }

 setTimeout(function(){
//$('#head1').hide();
//$('#head2').hide();
                }, 1900)



                setTimeout(function() {

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
		                select: function (event, ui) {
			                console.log("Selected: " + ui.item.value + " aka " + ui.item.label);
			                window.location = '/video/' + ui.item.link;
		                }
	                });

	                $("#project").data("ui-autocomplete")._renderItem = function (ul, item) {

		                return $("<li></li>")
		                .data("item.autocomplete", item)
		                .append("" + "<div class='col-sm-12 pt10pb10'>" +
			                "<div class='col-sm-3 pl0' > " +
                          "<img style='padding:10px' width='150' src='" + item.thumb + "' /> " + item.label + " </div>" +
			                "</div>" +
			                "")
		                .appendTo(ul);

		                return $li.appendTo(ul);
	                };
                }, 300)
            </script>
            <!-- footer -->
            <footer>
                <div class="row">
                    <div class="large-3 medium-6 columns">
                        <div class="widgetBox">
                            <div class="widgetTitle">
                                <h5>About {{$webName}}</h5>
                            </div>
                            <div class="textwidget">
                                {{$metaDescription}}
                            </div>
                        </div>
                    </div>
                    @if(env('APPS'))
                    <div class="large-3 medium-6 columns">
                        <div class="widgetBox">
                            <div class="widgetTitle">
                                <h5>Download Mobile Apps</h5>
                            </div>
                            @php
                             $ser = new \App\Models\Series();
                             $videos = $ser->getRecentThree();
                            @endphp
                            <div class="widgetContent">
                                <img class="mobAppsImgs" onclick="window.open('{{env('IOS_APP')}}')" src="{{asset('assets/client/images/ios.png')}}" alt="IOS App">
                                <img class="mobAppsImgs" onclick="window.open('{{env('ANDROID_APP')}}')" src="{{asset('assets/client/images/android.png')}}" alt="Android App">
                            </div>
                        </div>
                    </div>
                    @else
                        <div class="large-3 medium-6 columns">
                            <div class="widgetBox">
                                <div class="widgetTitle">
                                    <h5>Recent Videos</h5>
                                </div>
                                @php
                                    $ser = new \App\Models\Series();
                                    $videos = $ser->getRecentThree();
                                @endphp
                                <div class="widgetContent">
                                    @foreach($videos as $val)
                                        <input type="hidden" id="linkMe_{{$val->id}}" value="{{str_replace('#', '_', str_replace(' ', '-', str_replace('-', '*', $val->link)))}}">
                                        <div class="media-object">
                                            <div class="media-object-section">
                                                <div class="recent-img">
                                                    <img src= "{{$val->thumbnail}}" alt="recent">
                                                    <a href="javascript:;" onclick="redirectMe('{{$val->id}}')" class="hover-posts">
                                                        <span><i class="fa fa-play"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="media-object-section">
                                                <div class="media-content">
                                                    <h6><a href="javascript:;" onclick="redirectMe('{{$val->id}}')">{{$val->name}}</a></h6>
                                                    <p>
                                                        <i class="fa fa-user"></i>
                                                        <span>{{$val->createdByUser->name}}</span><i class="fa fa-clock-o"></i>
                                                        <span>{{\Carbon\Carbon::parse($val->created_at)->diffForHumans()}}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    @endif
                    <div class="large-3 medium-6 columns">
                        <div class="widgetBox">
                            <div class="widgetTitle">
                                <h5>Tags</h5>
                            </div>
                            <div class="tagcloud">
                                @foreach($tags as $key=> $val)
                                    <a href="/tags/{{str_replace(' ', '-', $val->tag)}}">{{$val->tag}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="large-3 medium-6 columns">
                        <div class="widgetBox">
                            <div class="widgetTitle">
                                <h5>Social Network</h5>
                            </div>
                            <div class="widgetContent">
                                {!! $fb_page_widget !!}
                            </div>
                        </div>
                    </div>
                </div>
                <a href="javascript:;" id="back-to-top" title="Back to top"><i class="fa fa-angle-double-up"></i></a>
            </footer><!-- footer -->
            <div id="footer-bottom">
                <div class="logo text-center">
                    <img src="{{$logo}}" alt="footer logo">
                </div>
                <div class="btm-footer-text text-center">
                    <p>2018 © {{\Config::get('app.name')}}</p>
                </div>
            </div>
        </div><!--end off canvas content-->
    </div><!--end off canvas wrapper inner-->
</div><!--end off canvas wrapper-->


<div id="fb-root"></div>
<script>
    (function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId={{$fb_app_id}}";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>

{!! $g_analytics !!}

</body>
</html>