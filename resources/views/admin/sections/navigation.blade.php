<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('admin.dashboard') }}" class="site_title">
                <span>{{ config('app.name') }}</span>
            </a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ auth()->user()->image }}" onerror="this.src='{{asset('assets/client/images/nothumbuser.png')}}'"  alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <h2>{{ auth()->user()->name }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            {{--<div class="menu_section">--}}
                {{--<h3>{{ __('views.backend.section.navigation.sub_header_0') }}</h3>--}}
                {{--<ul class="nav side-menu">--}}
                    {{--<li>--}}
                        {{--<a href="{{ route('admin.dashboard') }}">--}}
                            {{--<i class="fa fa-home" aria-hidden="true"></i>--}}
                            {{--{{ __('views.backend.section.navigation.menu_0_1') }}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            <div class="menu_section">
                {{--<h3>{{ __('views.backend.section.navigation.sub_header_1') }}</h3>--}}
                <ul class="nav side-menu">
                    {{--<li>--}}
                        {{--<a href="{{ route('admin.dashboard') }}">--}}
                            {{--<i class="fa fa-home" aria-hidden="true"></i>--}}
                            {{--{{ __('views.backend.section.navigation.menu_0_1') }}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <li>
                        <a href="{{ route('admin.users') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.menu_1_1') }}
                        </a>
                    </li>
                    <li>
                        <a href="/admin/categories">
                            <i class="fa fa-list" aria-hidden="true"></i>
                            Categories
                        </a>
                    </li>
                    <li>
                        <a href="/admin/tags">
                            <i class="fa fa-tags" aria-hidden="true"></i>
                            Tags
                        </a>
                    </li>
                    <li>
                        <a href="/admin/servers">
                            <i class="fa fa-server" aria-hidden="true"></i>
                            Servers
                        </a>
                    </li>
                    @if(isset($celebrity_module) && $celebrity_module)
                        <li>
                            <a href="/admin/celebrities">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                Celebrities
                            </a>
                        </li>
                        <li>
                            <a href="/admin/celebrity/album">
                                <i class="fa fa-video-camera" aria-hidden="true"></i>
                                Celebrities Albums
                            </a>
                        </li>
                    @endif
                    @if(isset($video_groups_module) && $video_groups_module)
                        <li>
                            <a href="/admin/cities">
                                <i class="fa fa-globe" aria-hidden="true"></i>
                                Cities
                            </a>
                        </li>
                        <li>
                            <a href="/admin/video-group-categories">
                                <i class="fa fa-compress" aria-hidden="true"></i>
                                Video Groups Categories
                            </a>
                        </li>
                        <li>
                            <a href="/admin/video-groups">
                                <i class="fa fa-play-circle" aria-hidden="true"></i>
                                Video Groups
                            </a>
                        </li>
                    @endif
                    <li>
                        <a>
                            <i class="fa fa-play"></i>
                            Videos <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li><a href="/admin/videos">All Videos</a></li>
                            <li><a href="/admin/videos/?featured=1">Featured Videos</a></li>
                        </ul>
                    </li>
    
                    <li>
                        <a>
                            <i class="fa fa-cog"></i>
                            Configuration <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li><a href="/admin/website-configuration">Website Configuration</a></li>
                            <li><a href="/admin/adds">Configure Add</a></li>
                            <li><a href="/admin/privacy-policy">Privacy Policy</a></li>
                            <li><a href="/admin/terms-conditions">Terms and Conditions</a></li>
                            <li><a href="/admin/modules">Modules Setup</a></li>
                        </ul>
                    </li>
    
                    <li>
                        <a href="/admin/mass-emails">
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            Mass Emails
                        </a>
                    </li>

                    <li>
                        <a href="/admin/combination-images">
                            <i class="fa fa-image" aria-hidden="true"></i>
                            Combinational Images
                        </a>
                    </li>
                </ul>
            </div>

            {{--<div class="menu_section">--}}
                {{--<h3>{{ __('views.backend.section.navigation.sub_header_2') }}</h3>--}}

                {{--<ul class="nav side-menu">--}}
                    {{--<li>--}}
                        {{--<a>--}}
                            {{--<i class="fa fa-list"></i>--}}
                           {{--Categories--}}
                            {{--<span class="fa fa-chevron-down"></span>--}}
                        {{--</a>--}}
                        {{--<ul class="nav child_menu">--}}
                            {{--<li>--}}
                                {{--<a href="{{ route('log-viewer::dashboard') }}">--}}
                                    {{--{{ __('views.backend.section.navigation.menu_2_2') }}--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="{{ route('log-viewer::logs.list') }}">--}}
                                    {{--{{ __('views.backend.section.navigation.menu_2_3') }}--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            {{--<div class="menu_section">--}}
                {{--<h3>{{ __('views.backend.section.navigation.sub_header_2') }}</h3>--}}

                {{--<ul class="nav side-menu">--}}
                    {{--<li>--}}
                        {{--<a>--}}
                            {{--<i class="fa fa-list"></i>--}}
                            {{--{{ __('views.backend.section.navigation.menu_2_1') }}--}}
                            {{--<span class="fa fa-chevron-down"></span>--}}
                        {{--</a>--}}
                        {{--<ul class="nav child_menu">--}}
                            {{--<li>--}}
                                {{--<a href="{{ route('log-viewer::dashboard') }}">--}}
                                    {{--{{ __('views.backend.section.navigation.menu_2_2') }}--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="{{ route('log-viewer::logs.list') }}">--}}
                                    {{--{{ __('views.backend.section.navigation.menu_2_3') }}--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            {{--<div class="menu_section">--}}
                {{--<h3>{{ __('views.backend.section.navigation.sub_header_3') }}</h3>--}}
                {{--<ul class="nav side-menu">--}}
                  {{--<li>--}}
                      {{--<a href="http://netlicensing.io/?utm_source=Laravel&utm_medium=github&utm_campaign=laravel&utm_content=credits" target="_blank" title="Online Software License Management"><i class="fa fa-lock" aria-hidden="true"></i>NetLicensing</a>--}}
                  {{--</li>--}}
                  {{--<li>--}}
                      {{--<a href="https://photolancer.zone/?utm_source=Laravel&utm_medium=github&utm_campaign=laravel&utm_content=credits" target="_blank" title="Individual digital content for your next campaign"><i class="fa fa-camera-retro" aria-hidden="true"></i>Photolancer Zone</a>--}}
                  {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        </div>
        <!-- /sidebar menu -->
    </div>
</div>
