@extends('client.layout.app')
@section('content')
    <!-- ad Section -->
    <div class="googleAdv">
        @include('client.partials.add2')
    </div><!-- End ad Section -->


    <section class="error-page">
        <div class="row secBg">
            <div class="large-8 large-centered columns">
                <div class="error-page-content text-center">
                    <div class="error-img text-center">
                        <img src="{{asset('assets/client/images/404-error.png')}}" alt="404 page">
                        <div class="spark">
                            <img class="flash" src="images/spark.png" alt="">
                        </div>
                    </div>
                    <h1>Page Not Found</h1>
                    <a href="/" class="button">Go Back Home Page</a>
                </div>
            </div>
        </div>
    </section>
@endsection