@extends('client.layout.app')
@section('content')
    <!-- ad Section -->
    <div class="googleAdv">
        @include('client.partials.add2')
    </div><!-- End ad Section -->

    <div class="row">
        <!-- left side content area -->
        <div class="large-8 columns">
            <div class="row secBg">
                <div class="large-12 columns">
                    <div class="row list-group">
                        @foreach($celebrities as $val)
                            @if($loop->last)
                            <div class="item large-4 medium-6 columns grid-medium end">
                            @else
                            <div class="item large-4 medium-6 columns grid-medium">
                            @endif
                                <div class="card hovercard">
                                    <div class="cardheader banner banner_{{$val->id}}">
                                        <script>
                                            if('{{$val->banner}}'.length > 0) {
                                                $('.banner_{{$val->id}}').css('background', 'url({{$val->banner}})');
                                            } else {
                                                $('.banner_{{$val->id}}').css('background', 'url({{asset('assets/client/images/defaultbanner.jpg')}})');
                                                $('.banner_{{$val->id}}').css('background-repeat', 'no-repeat !important');
                                                $('.banner_{{$val->id}}').css('background-position', 'center center !important');
                                            }
                                        </script>
                                    </div>
                                    <div class="avatar">
                                        <img alt="user image" src="{{$val->image}}" onerror="this.src='{{asset('assets/client/images/nothumbuser.png')}}'" >
                                    </div>
                                    <div class="info">
                                        <div class="title">
                                            <a class="colorWhite font18" href="/user/{{str_replace(' ', '-', $val->name)}}">{{$val->name}}</a>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- ad Section -->
            <div class="googleAdv text-center">
                @include('client.partials.add1')
            </div><!-- End ad Section -->


        </div><!-- end left side content area -->

        @include('client.partials.sidebar')
    </div>

@endsection