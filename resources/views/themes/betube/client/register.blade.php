@extends('client.layout.app')
@section('content')

    <section class="registration">
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="login-register-content">
                    <div class="row collapse borderBottom">
                        <div class="medium-6 large-centered medium-centered">
                            <div class="page-heading text-center">
                                <h3>User Registeration</h3>
                                <p>{{$metaDescription}}</p>
                            </div>
                        </div>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (!$errors->isEmpty())
                        <div class="alert alert-danger" role="alert">
                            {!! $errors->first() !!}
                        </div>
                    @endif

                    <div class="large-4 medium-6 columns end cntr">
                        <div class="register-form">
                            <h5 class="text-center">Create your Account</h5>
                            <form method="post" action="{{route('register')}}" data-abide="qrm7nd-abide" novalidate="">
                                {{csrf_field()}}
                                <div data-abide-error="" class="alert callout" style="display: none;">
                                    <p><i class="fa fa-exclamation-triangle"></i> There are some errors in your form.</p>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-user"></i></span>
                                    <input class="input-group-field" type="text" placeholder="Enter your username" name="name"  required="" value="{{old('name')}}">
                                </div>

                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-envelope"></i></span>
                                    <input class="input-group-field" type="email" placeholder="Enter your email" name="email"  required=""  value="{{old('email')}}">
                                </div>

                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-lock"></i></span>
                                    <input type="password" id="password" name="password"  placeholder="Enter your password" required="">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-lock"></i></span>
                                    <input type="password" placeholder="Re-type your password" required="" name="password_confirmation"  pattern="alpha_numeric" data-equalto="password">
                                </div>
                                <span class="form-error">your email is invalid</span>
                                <button class="button expanded" type="submit" name="submit">register Now</button>
                                <p class="loginclick"> <a href="/login">{{--Login here--}}</a><a href="/login">Already have acoount?</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

@endsection