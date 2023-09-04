<section>
    <div class="container text-center customer-reset-password">
        <div>
            <h2 class="color-brand-1 mb-15 wow animate__animated animate__fadeIn" data-wow-delay=".0s">{{ __('Reset Password') }}</h2>
            @if ($lineImage = theme_option('authentication_line_image'))
                <div class="line-login mt-25 mb-50" style="background: url('{{ RvMedia::getImageUrl($lineImage) }}')"></div>
            @endif
            <div class="wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                <form method="POST" class="row" action="{{ route('customer.password.reset.post') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}" />
                    <div class="col-lg-12">
                        <div class="form-group mb-25">
                            <input class="form-control icon-user @if($errors->has('email')) is-invalid @endif" name="email" type="email" placeholder="{{ __('Your email') }}" value="{{ old('email') }}">
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
                    <div class="col-lg-12 mb-25">
                        <button class="btn btn-brand-lg btn-full font-md-bold" type="submit">{{ __('Reset Password') }}</button>
                    </div>
                </form>

                @if (session('status'))
                    <div class="text-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('success_msg'))
                    <div class="text-success">
                        {{ session('success_msg') }}
                    </div>
                @endif

                @if (session('error_msg'))
                    <div class="text-danger">
                        {{ session('error_msg') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
