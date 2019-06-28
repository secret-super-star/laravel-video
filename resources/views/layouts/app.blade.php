<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{--CSRF Token--}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="This is the video based website consist different type of videos from all over the glob">
        <link rel="icon" href="{{$favicon}}">
        <title>{{\Config::get('app.name')}} | Admin</title>
        {{--Title and Meta--}}
        @meta

        {{--Common App Styles--}}
        {{ Html::style(mix('assets/app/css/app.css')) }}

        {{--Styles--}}
        @yield('styles')

        {{--Head--}}
        @yield('head')

    </head>
    <body class="@yield('body_class')">
    <style>
      .paginate_button.current {
        background: red !important;
        color: white !important;
      }

      .paginate_button {
        cursor: pointer;
      }

      .fancybox-nav.fancybox-prev {
        display: none !important;
      }

      .fancybox-nav.fancybox-next {
        display: none !important;
      }
    </style>
        {{--Page--}}
        @yield('page')

        {{--Common Scripts--}}
        {{ Html::script(mix('assets/app/js/app.js')) }}
        <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

         {{--Documentation link for sortable.js https://johnny.github.io/jquery-sortable/--}}
        <script src="{{ asset('assets/admin/js/jquery-sortable.js') }}"></script>

        {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>--}}
        <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.css"/>
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.2/css/dataTables.responsive.css"/>

        <script src="{{ asset('assets/admin/js/select2.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('assets/admin/css/select2.css') }}">
        {{--Laravel Js Variables--}}

        
        {{--Fancy Box Library--}}
        <!-- Add mousewheel plugin (this is optional) -->
        <script type="text/javascript" src="{{asset('assets/admin/js/jquery.mousewheel.pack.js')}}"></script>
        

        <!-- Add fancyBox -->
        <link rel="stylesheet" href="{{asset('assets/admin/css/jquery.fancybox.css')}}" type="text/css" media="screen" />
        <script type="text/javascript" src="{{asset('assets/admin/js/jquery.fancybox.pack.js')}}"></script>

        <!-- Optionally add helpers - button, thumbnail and/or media -->
        <link rel="stylesheet" href="{{asset('assets/admin/css/jquery.fancybox-buttons.css')}}" type="text/css" media="screen" />

        <script type="text/javascript" src="{{asset('assets/admin/js/jquery.fancybox-buttons.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/admin/js/jquery.fancybox-media.js')}}"></script>

        <link rel="stylesheet" href="{{asset('assets/admin/css/jquery.fancybox-thumbs.css')}}" type="text/css" media="screen" />
        
        <script type="text/javascript" src="{{asset('assets/admin/js/jquery.fancybox-thumbs.js')}}"></script>
        {{--Fancy Box Library--}}

        <script type="text/javascript">
          $(document).ready(function() {
            $(".fancybox").fancybox({
              'width'		: 900,
              'height'	: 900,
              'type'		: 'iframe',
              'autoScale'    	: false,
              'fitToView': false,
              'maxWidth': 940,
              'afterClose': function() {
               $('#addVideoThumb').attr('src', $('#mythumbnail').val());
               $('#addVideoThumb').css('width', '100px');
               $('#addVideoThumbHeader').attr('href', $('#mythumbnail').val());
              }
            });
          });

          $(document).ready(function() {
            $(".banner").fancybox({
              'width'		: 900,
              'height'	: 900,
              'type'		: 'iframe',
              'autoScale'    	: false,
              'fitToView': false,
              'maxWidth': 940,
              'afterClose': function() {
               $('#bannerVideoThumb').attr('src', $('#bannerThumb').val());
               $('#bannerVideoThumb').css('width', '100px');
               $('#addVideoThumbHeader').attr('href', $('#bannerThumb').val());
              }
            });
          });
        </script>
        @tojs


        <script src="{{asset('assets/admin/js/bootstrap-datepicker.js')}}"></script>
        <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-datepicker.css')}}">

        {{ Html::script(mix('assets/admin/js/admin.js')) }}
        <script src="{{asset('assets/admin/js/custom.js')}}"></script>

    {{--Scripts--}}
        @yield('scripts')
    </body>
</html>
