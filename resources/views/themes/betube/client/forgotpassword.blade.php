@extends('client.layout.app')
@section('content')

    <section class="registration">
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="login-register-content">
                    <div class="row collapse borderBottom">
                        <div class="medium-6 large-centered medium-centered">
                            <div class="page-heading text-center">
                                <h3>Forgot Password</h3>
                                <p>{{$metaDescription}}</p>
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row" data-equalizer="3xv9ei-equalizer" data-equalize-on="medium" id="test-eq" data-resize="006y63-eq" data-events="resize">
                        <div class="large-4 medium-6 large-centered medium-centered columns">
                            <div class="register-form">
                                <h5 class="text-center">Enter Email</h5>
                                <form method="post" action="{{route('password.email')}}" data-abide="gwy51b-abide" novalidate="">
                                    {{csrf_field()}}
                                    <div class="input-group">
                                        <span class="input-group-label"><i class="fa fa-user"></i></span>
                                        <input type="email"  name="email" value="{{ old('email') }}" placeholder="Enter your email" required="">
                                        <span class="form-error">email is required</span>
                                    </div>
                                    <button class="button expanded" type="submit" name="submit">reset Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection