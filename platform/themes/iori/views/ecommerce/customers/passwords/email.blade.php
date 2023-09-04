<section>
    <div class="container text-center customer-reset-password">
       <div>
           <h2 class="color-brand-1 mb-15 wow animate__animated animate__fadeIn" data-wow-delay=".0s">{{ __('Forgot Password') }}</h2>
           <p class="font-md color-grey-500 wow animate__animated animate__fadeIn mb-10" data-wow-delay=".2s">{{ __('Iori is a Multipurpose Agency Laravel Script. It is a powerful, clean, modern, and fully responsive template. It is designed for agency, business, corporate, creative, freelancer, portfolio, photography, personal, resume, and any kind of creative fields.') }}</p>
           @if ($lineImage = theme_option('authentication_line_image'))
               <div class="line-login mt-25 mb-50" style="background: url('{{ RvMedia::getImageUrl($lineImage) }}')"></div>
           @endif
           <div class="wow animate__animated animate__fadeIn" data-wow-delay=".4s">
               <form method="POST" class="row" action="{{ route('customer.password.request') }}">
                   @csrf
                   <div class="col-lg-12">
                       <div class="form-group mb-25">
                           <input class="form-control icon-user @if($errors->has('email')) is-invalid @endif" name="email" type="email" placeholder="{{ __('Your email') }}">
                           @error('email')
                           <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>
                   </div>
                   <div class="col-lg-12 mb-25">
                       <button class="btn btn-brand-lg btn-full font-md-bold" type="submit">{{ __('Send Password Reset Link') }}</button>
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
