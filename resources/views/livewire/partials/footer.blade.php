<footer class="w-full">
    <section class="bg-[#0F0000] text-light w-full py-10">
        <div class="container grid md:grid-cols-5 2xl:grid-cols-7 gap-10 py-5">
            <section class="md:col-span-2 space-y-5">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo-white.png') }}" />
                </a>
    
                <p>HTS is video streaming lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                    incididunt ut
                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>

                <section class="py-3 space-y-3">
                    <h2 class="text-xl">Follow Us</h2>

                    <ul class="flex items-center">
                        <li>
                            <a href="#" class="text-2xl flex items-center justify-center rounded-2xl h-[50px] min-w-[50px] hover:bg-danger">
                                <i class="lab la-facebook-f"></i>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="text-2xl flex items-center justify-center rounded-2xl h-[50px] min-w-[50px] hover:bg-danger">
                               <i class="lab la-youtube"></i>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="text-2xl flex items-center justify-center rounded-2xl h-[50px] min-w-[50px] hover:bg-danger">
                                <i class="lab la-twitter"></i>
                            </a>
                        </li>


                        <li>
                            <a href="#" class="text-2xl flex items-center justify-center rounded-2xl h-[50px] min-w-[50px] hover:bg-danger">
                               <i class="lab la-linkedin"></i>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="text-2xl flex items-center justify-center rounded-2xl h-[50px] min-w-[50px] hover:bg-danger">
                                <i class="lab la-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </section>
            </section>
    
            <section class="space-y-3">
                <h2 class="font-medium text-xl">Quick Links</h2>
                <ul class="space-y-3">
                    <li>
                        <a href="#">About us</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                    <li>
                        <a href="#">Products</a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">Sign Up</a>
                    </li>
                </ul>
            </section>
    
    
            <section class="space-y-3 md:col-span-2">
                <h2 class="font-medium text-xl">Movie Categories +</h2>
                <section class="grid grid-cols-2 gap-5">
                    <ul class="space-y-3">
                        <li>
                            <a href="#">Christian Show</a>
                        </li>
                        <li>
                            <a href="#">Boxing Show</a>
                        </li>
                        <li>
                            <a href="#">Football Show</a>
                        </li>
                        <li>
                            <a href="#">All Islam</a>
                        </li>
                        <li>
                            <a href="#">Comedy Show</a>
                        </li>
    
                        <li>
                            <a href="#">Pop Show</a>
                        </li>
    
                        <li>
                            <a href="#">Jewish Show</a>
                        </li>
    
                        <li>
                            <a href="#">Bring 'em Home Bail Bonds</a>
                        </li>
                    </ul>
    
                    <ul class="space-y-3">
                        <li>
                            <a href="#">Hip Hop Show</a>
                        </li>
                        <li>
                            <a href="#">Jazz Show</a>
                        </li>
                        <li>
                            <a href="#">Fishing Show</a>
                        </li>
                        <li>
                            <a href="#">Sports Show</a>
                        </li>
                        <li>
                            <a href="#">Caribbean Show</a>
                        </li>
                        <li>
                            <a href="#">Women of Wealth</a>
                        </li>
                        <li>
                            <a href="#">Pedicab</a>
                        </li>
                        <li>
                            <a href="#">Community Affairs Show</a>
                        </li>
                    </ul>
                </section>
            </section>
    
            <section class="md:col-span-2">
                <div class="space-y-3 p-5 rounded-lg bg-gradient-to-r from-[#FF055F] to-[#630047]">
                    <h2>Watch HTS Everywhere & Anytime Now</h2>
                    <p class="text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
    
                    <div>
                        <a href="#" class="btn btn-xl bg-white font-bold text-dark whitespace-nowrap">
                            Get Premium Access
                        </a>
                    </div>
                </div>
            </section>
    
        </div>
    </section>
    <section class="bg-danger text-sm py-5 text-white">
        <div class="container flex text-center md:text-left flex-col md:flex-row justify-between items-center">
            <ul>
                <li>
                    HTS VIDEO STREAMING - © 2020 All Rights Reserved
                </li>
            </ul>

            {{-- <ul>
                <li>
                    Made with 🤍 by Saivra.co
                </li>
            </ul> --}}
        </div>
    </section>
</footer>