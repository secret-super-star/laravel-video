@extends('client.layout.app')
@section('content')

    <section class="registration">
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="login-register-content">
                    <div class="row collapse borderBottom">
                        <div class="medium-6 large-centered medium-centered">
                            <div class="page-heading text-center">
                                <h3>User login</h3>
                                <p>{{$metaDescription}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row" data-equalizer="dkx0bc-equalizer" data-equalize-on="medium" id="test-eq" data-resize="bpocf4-eq" data-events="resize">
                        <div class="large-4 large-offset-1 medium-6 columns">
                            <div class="social-login height314px" data-equalizer-watch="">
                                <h5 class="text-center">Login via Social Profile</h5>
                                <div class="social-login-btn facebook">
                                    <a href="{{ route('social.redirect', ['facebook']) }}"><i class="fa fa-facebook"></i>login via facebook</a>
                                </div>
                            </div>
                        </div>
                        <div class="large-2 medium-2 columns show-for-large">
                            <div class="middle-text text-center hide-for-small-only height314px" data-equalizer-watch="">
                                <p>
                                    <i class="fa fa-arrow-left arrow-left"></i>
                                    <span>OR</span>
                                    <i class="fa fa-arrow-right arrow-right"></i>
                                </p>
                            </div>
                        </div>
                        <div class="large-4 medium-6 columns end">
                            <div class="register-form">
                                <h5 class="text-center">Create your Account</h5>
                                <form method="post" data-abide="u6ir3s-abide" novalidate="" action="{{route('login')}}">
                                    {{csrf_field()}}
                                    <div data-abide-error="" class="alert callout" style="display: none;">
                                        <p><i class="fa fa-exclamation-triangle"></i> There are some errors in your form.</p>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-label"><i class="fa fa-user"></i></span>
                                        <input class="input-group-field" type="email" placeholder="Enter your email" required=""  name="email" value="{{ old('email') }}" autofocus>
                                        <span class="form-error">email is required</span>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-label"><i class="fa fa-lock"></i></span>
                                        <input type="password" id="password" placeholder="Enter your password" required=""  name="password">
                                        <span class="form-error">password is required</span>
                                    </div>
                                    <div class="checkbox">
                                        <input id="remember" type="checkbox" name="remember" value="remember">
                                        <label class="customLabel" for="remember">Remember me</label>
                                    </div>
                                    <button class="button expanded" type="submit" name="submit">login Now</button>
                                    <p class="loginclick"><a href="/password/reset">Forgot Password</a> New Here? <a href="/register">Create a new Account</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection