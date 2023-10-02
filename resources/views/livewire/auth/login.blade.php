<div 
        class="min-h-screen flex items-center justify-center py-10" 
        style="background-image: url('{{ asset('images/background-image-01.png') }}">

        <div class="md:w-1/2 lg:w-[430px] border border-[#878787] rounded-xl bg-black text-white p-7 space-y-5">
            <header class="space-y-3">
                <h3 class="font-thin text-xl">Welcome !</h3>
                <section class="space-y-2">
                    <h1 class="font-medium text-2xl md:text-3xl">Sign in to Hot TV Station</h1>
                    <p>Your Next Stop for Traveling and streaming Station</p>
                </section>
            </header>

            @if(session()->has('confirmation-email-message'))
               <div 
               
               x-data="{ canResend: false, countdown: 60 }" 
               @trigger-email-sent.window="() => {
                    countdown = 60;
                    canResend = false;
               }"
               x-init="() => {
                    setInterval(() => {
                        if(countdown >= 1){
                            --countdown;
                        }else{
                            canResend = true;
                        } 
                    }, 1000)
                }">
                <div class="p-3 rounded-xl bg-danger text-sm space-y-1">
                    <span>A confirmation email has been sent to your email address. Please confirm your account by clicking the
                        confirm button</span><br />
            
                   <div class="flex items-center space-x-2">
                    <x-atoms.loading-button text="Resend link" wire:click="resendVerificationMail" class=""
                        x-bind:class="!canResend ? 'opacity-70' : ''" x-bind:disabled="!canResend" target="resendVerificationMail" />
                    
                    <span x-show="!canResend">in 00:<span x-text="countdown"></span>s</span>
                   </div>
                </div>
            </div>
            @endIf

            @if(session()->has('verification-email-message'))
                <div class="p-3 rounded bg-success text-sm">
                    Congratulations! Your email has been verified. Please log in to your account to proceed.
                </div>
            @endIf

            @if(session()->has('email-already-verified-message'))
                <div class="p-3 rounded bg-success text-sm">
                    Congratulations! Your email has been verified already. Please log in to your account to proceed.
                </div>
            @endIf


            <form class="grid gap-5" wire:submit.prevent='submit'>
                <div class="form-group">
                    <label>Username</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        placeholder="Enter your username" 
                        wire:model.defer="username" 
                    />
                </div>
                
                <div class="form-group" x-data="{ show : false}">
                    <label>Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" class="form-control" 
                            placeholder="Enter your Password" 
                            wire:model.defer="password" 
                        />
                        <button type='button' class="absolute top-3 right-3" x-on:click="show = !show">
                            <i class="las" :class="show ? 'la-eye' : 'la-eye-slash'"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                   <a href="{{ route('forgot_password') }}" class="semibold text-sm">Forgot Password?</a>
                </div>


                <div class="form-group">
                    <x-atoms.loading-button text="Log in" target="submit" class="btn btn-lg btn-danger btn-block" />
                </div>
            </form>

            <div class="text-center">
                <span class="font-thin">Don't have an Account ?</span> <a href="{{ route('register') }}" class="semibold">Register</a>
            </div>
        </div>
    </div>
    