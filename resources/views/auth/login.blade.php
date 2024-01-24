@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('SFMS LOGIN') }}</div>
                <link rel="stylesheet"
                    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="org_code" class="col-md-4 col-form-label text-md-end">{{ __('Organisation Code')
                                }}</label>

                            <div class="col-md-6">
                                <input id="organisation_code" type="text"
                                    class="form-control @error('organisation_code') is-invalid @enderror"
                                    name="organisation_code" value="{{ old('organisation_code') }}"
                                    autocomplete="organisation_code" autofocus>

                                <span id="orgError" style="color:red;font-size: 12px;"></span>

                                @error('organisation_code')
                                <span class="invalid-feedback" role="alert">
                                    <span>{{ $message }}</span>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" autocomplete="username" autofocus>
                                <span id="UsernameError" style="color:red;font-size: 12px;"></span>
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <span>{{ $message }}</span>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password')}}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="current-password">
                                <span id="passwordError" style="color:red;font-size: 12px;"></span>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <span>{{ $message }}</span>
                                </span>
                                @enderror

                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Captcha') }}</label>

                            <div class="col-md-6">
                                {!! Captcha::img() !!}
                                <a href="javascript:void(0);" onclick="refreshCaptcha()">
                                    <span class="glyphicon glyphicon-refresh"
                                        style="margin-left:20px;color:green"></span>
                                </a>


                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end"></label>

                            <div class="col-md-6">

                                <input id="captcha" type="text"
                                    class="form-control @error('captcha') is-invalid @enderror" name="captcha">


                                <span id="CaptchaError" style="color:red;font-size: 12px;"></span>
                                @error('captcha')
                                <span class="invalid-feedback" role="alert">
                                    <span>{{ $message }}</span>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-3 text-center">
                                <button type="submit" id="submitBtn" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function () {
        var form = $('form');
        form.validate({
            rules: {
                organisation_code: {
                    required: true
                },
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                captcha: {
                    required: true
                }
            },
            messages: {
                organisation_code: {
                    required: 'Organisation Code is required.'
                },
                username: {
                    required: 'Username is required.'
                },
                password: {
                    required: 'Password is required.'
                },
                captcha: {
                    required: 'Captcha is required.'
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {

                error.appendTo(element.next('span'));
            },
            submitHandler: function (form) {
                // If validation passes, submit the form
                form.submit();
            }
        });

        // Refresh captcha on click
        $('a').on('click', function (event) {
            event.preventDefault();
            refreshCaptcha();
        });

        function refreshCaptcha() {

            var captchaImg = $('img');
            captchaImg.attr('src', captchaImg.attr('src').split('?')[0] + '?' + new Date().getTime());
        }
    });
</script>
@endsection