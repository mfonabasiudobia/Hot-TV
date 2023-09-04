<section class="section box-page-register">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                @if($steps = json_decode(theme_option('step_create_account')))
                    <div class="box-steps-small">
                    @foreach($steps as $step)
                        @php($step = collect($step)->pluck('value', 'key'))
                        <div @class(['item-number hover-up wow animate__animated animate__fadeInLeft', 'active' => $loop->first]) data-wow-delay=".{{ $loop->index }}s">
                            <div class="num-ele">{{ $loop->iteration }}</div>
                            <div class="info-num">
                                <h5 class="color-brand-1 mb-15">{!! BaseHelper::clean($step->get('title')) !!}</h5>
                                <p class="font-md color-grey-500">{!! BaseHelper::clean($step->get('description')) !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="col-lg-7">
                <div class="box-register">
                    <h2 class="color-brand-1 mb-15 wow animate__animated animate__fadeIn" data-wow-delay=".0s">{{ __('Create an account') }}</h2>
                    <p class="font-md color-grey-500 wow animate__animated animate__fadeIn mb-10" data-wow-delay=".0s">{{ __('Create an account today and start using our platform') }}</p>
                    @if ($lineImage = theme_option('authentication_line_image'))
                        <div class="line-register mt-25 mb-50" style="background: url('{{ RvMedia::getImageUrl($lineImage) }}')"></div>
                    @endif
                    <div class="wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                        <form method="POST" class="row" action="{{ route('customer.register.post') }}">
                            @csrf
                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group mb-25">
                                    <input required class="form-control icon-name @if($errors->has('name')) is-invalid  @endif" type="text" name="name" placeholder="{{ __('Your name') }}" value="{{ old('name') }}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group mb-25">
                                    <input required class="form-control icon-email @if($errors->has('email')) is-invalid  @endif" type="email" name="email" placeholder="{{ __('Your email') }}" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group mb-25">
                                    <input required class="form-control icon-password @if($errors->has('password')) is-invalid @else input-green-bd @endif" type="password" name="password" autocomplete="new-password" placeholder="{{ __('Password') }}">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group mb-25">
                                    <input required class="form-control icon-password @if($errors->has('password_confirmation')) is-invalid @else input-green-bd @endif" type="password" name="password_confirmation" placeholder="{{ __('Password confirmation') }}">
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 mt-15">
                                <div class="form-group mb-25">
                                    <label>
                                        <span class="text-small">{{ __('Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy.') }}</span>
                                    </label>
                                </div>
                                <div class="form-group mb-25">
                                    <label class="cb-container">
                                        <input type="checkbox" name="agree_terms_and_policy" id="agree-terms-and-policy" value="1" @if (old('agree_terms_and_policy') == 1) checked @endif>
                                        <span class="text-small">{{ __('I agree to terms & Policy.') }}</span>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            @if (is_plugin_active('captcha'))
                                @if(Captcha::isEnabled() && get_ecommerce_setting('enable_recaptcha_in_register_page', 0))
                                    <div class="form-group">
                                        {!! Captcha::display() !!}
                                    </div>
                                @endif

                                @if (get_ecommerce_setting('enable_math_captcha_in_register_page', 0))
                                    <div class="form-group">
                                        {!! app('math-captcha')->input(['class' => 'form-control', 'id' => 'math-group', 'placeholder' => app('math-captcha')->getMathLabelOnly()]) !!}
                                    </div>
                                @endif
                            @endif

                            <div class="row align-items-center mt-30 wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6 col-6">
                                    <div class="form-group">
                                        <button class="btn btn-brand-lg btn-full font-md-bold" type="submit">{{ __('Sign up now') }}</button>
                                    </div>
                                </div>
                                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-6 col-6"><span class="d-inline-block align-middle font-sm color-grey-500">{{ __('Already have an account?') }}</span>
                                    <a class="d-inline-block align-middle color-success ms-1" href="{{ route('customer.login') }}"> {{ __('Sign In') }}</a>
                                </div>
                            </div>

                            {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Botble\Ecommerce\Models\Customer::class) !!}

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
