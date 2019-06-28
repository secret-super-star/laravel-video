@extends('client.layout.app')
@section('content')
    <!-- ad Section -->
    <div class="googleAdv">
        @include('client.partials.add2')
    </div><!-- End ad Section -->

    <div class="row">
        {!! isset($content->content) ? $content->content : 'No Content Found..!' !!}
    </div>
@endsection