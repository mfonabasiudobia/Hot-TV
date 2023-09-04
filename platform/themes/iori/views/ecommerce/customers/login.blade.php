<section class="section banner-login position-relative float-start">
    <div class="box-banner-abs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xxl-5 col-xl-12 col-lg-12">
                    <div class="box-banner-login">
                        <h2 class="color-brand-1 mb-15 wow animate__animated animate__fadeIn" data-wow-delay=".0s">{{ __('Welcome back') }}</h2>
                        <p class="font-md color-grey-500 wow animate__animated animate__fadeIn mb-10" data-wow-delay=".2s">{{ __('Fill your email address and password to sign in.') }}</p>
                        @if ($lineImage = theme_option('authentication_line_image'))
                            <div class="line-login mt-25 mb-50" style="background: url('{{ RvMedia::getImageUrl($lineImage) }}')"></div>
                        @endif
                        <div class="wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                            <form method="POST" class="row" action="{{ route('customer.login.post') }}">
                                @csrf
                                <div class="col-lg-12">
                                    <div class="form-group mb-25">
                                        <input class="form-control icon-user @if($errors->has('email')) is-invalid @endif" name="email" type="email" placeholder="{{ __('Your email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-25">
                                        <input class="form-control icon-password  @if($errors->has('password')) is-invalid @endif" name="password" type="password" placeholder="{{ __('Password') }}">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-6 mt-15">
                                    <div class="form-group mb-25">
                                        <label class="cb-container">
                                            <input type="checkbox" value="1" name="remember" id="remember-check" @if(old('remember', 1)) checked @endif>
                                            <span class="text-small">{{ __('Remember me') }}</span>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-6 mt-15">
                                    <div class="form-group mb-25 text-end">
                                        <a class="font-xs color-grey-500" href="{{ route('customer.password.reset') }}">{{ __('Forgot password?') }}</a>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-25">
                                    <button class="btn btn-brand-lg btn-full font-md-bold" type="submit">{{ __('Sign in') }}</button>
                                </div>

                                {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Botble\Ecommerce\Models\Customer::class) !!}

                            </form>

                            <div class="col-lg-12"><span class="color-grey-500 d-inline-block align-middle font-sm">
                        {{ __('Don’t have an account?') }}
                        </span><a class="d-inline-block align-middle color-success ms-1" href="{{ route('customer.register') }}">{{ __('Sign up now') }}</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-0">
        <div class="col-xxl-5 col-xl-7 col-lg-6"></div>
        <div class="col-xxl-7 col-xl-5 col-lg-6 pe-0">
            <div class="d-none d-xxl-block pl-70">
                @if($backgroundImage = theme_option('authentication_background_image'))
                    <div class="img-reveal">
                        <img class="w-100 d-block" src="{{ RvMedia::getImageUrl($backgroundImage) }}" alt="{{ __('Background Image') }}">
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
