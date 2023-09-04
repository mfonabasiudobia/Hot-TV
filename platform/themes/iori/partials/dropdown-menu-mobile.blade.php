<div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-content-area">
            @if ($logo = theme_option('logo'))
                <div class="mobile-logo">
                    <a class="d-flex" href="{{ route('public.index') }}">
                        <img src="{{ RvMedia::getImageUrl($logo) }}" alt="logo" >
                    </a>
                </div>
            @endif
            <div class="burger-icon burger-icon-white">
                <span class="burger-icon-top"></span>
                <span class="burger-icon-mid"></span>
                <span class="burger-icon-bottom"></span>
            </div>
            <div class="perfect-scroll">
                <div class="mobile-menu-wrap mobile-header-border w-full">
                    <ul class="nav nav-tabs nav-tabs-mobile mt-25" role="tablist">
                        <li>
                            <a class="active" href="#tab-menu" data-bs-toggle="tab" role="tab" aria-controls="tab-menu" aria-selected="true">
                                <svg class="w-6 h-6 icon-16" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>{{ __('Menu') }}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-menu" role="tabpanel" aria-labelledby="tab-menu">
                            <nav class="mt-15">
                                <ul class="mobile-menu font-heading">
                                    {!!
                                       Menu::renderMenuLocation('main-menu', [
                                           'view' => 'main-menu',
                                       ])
                                   !!}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
