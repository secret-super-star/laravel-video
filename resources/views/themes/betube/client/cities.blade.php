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
                @foreach($cities as $val)
                    @if($loop->last)
                        <div class="item large-2 medium-6 columns grid-medium end">
                            @else
                                <div class="item large-2 medium-4 columns grid-medium">
                                    @endif
                                    <div class="card hovercard cardHeigh140">
                                        <div class="cardheader banner banner_{{$val->id}}"
                                             style=" background: url('{{$val->thumbnail}}')">

                                        </div>

                                        <div class="info">
                                            <div class="title">
                                                <a class="colorWhite font18" href="/city/{{str_replace(' ', '-', $val->name)}}">{{$val->name}}</a>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                @endforeach
                        </div>

                        @include('pagination.default',array(
                                              'series' => $cities
                                          ))
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