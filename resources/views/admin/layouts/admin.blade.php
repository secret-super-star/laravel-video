@extends('layouts.app')

@section('body_class','nav-md')

@section('page')
    <div class="container body">
        <div id="loading"></div>
        <div class="main_container">
            @section('header')
                @include('admin.sections.navigation')
                @include('admin.sections.header')
            @show

            @yield('left-sidebar')

            <div class="right_col" role="main">
                <div class="page-title">
                    <div class="title_left">
                        <h1 class="h3">
                            @yield('title')
                        </h1>
                    </div>
                    @if(Breadcrumbs::exists())
                        <div class="title_right">
                            <div class="pull-right">
                                {!! Breadcrumbs::render() !!}
                            </div>
                        </div>
                    @endif
                    @yield('headerButton')
                </div>
                @yield('content')
            </div>

            <footer>
                @include('admin.sections.footer')
            </footer>
        </div>
    </div>
@stop

@section('styles')
    {{ Html::style(mix('assets/admin/css/admin.css')) }}
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay_progress.min.js"></script>

    @yield('js')
    <!-- Include external JS libs. -->
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=yt7hu8pxr9s2u2bz7dq3b02xv9kmjqgfs0p3bmmstiek29yo"></script>

    @if(\Request::path() == 'admin/privacy-policy' || \Request::path() == 'admin/terms-conditions' || \Request::path() == 'admin/mass-emails' || \Request::path() == 'admin/new/celebrity')
    <!-- Initialize the editor. -->
    <script>tinymce.init({ selector:'textarea' });</script>

    @endif

    @yield('scriptEnd')
@endsection