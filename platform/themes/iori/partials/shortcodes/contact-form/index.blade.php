@php
    $tabs = [];
    $quantity = max((int) $shortcode->quantity, 3);
    if ($quantity) {
        for ($i = 1; $i <= $quantity; $i++) {
            if (($heading = $shortcode->{'heading_' . $i})) {
                $description = $shortcode->{'description_' . $i} ?: '' ;
                $tabs[] = [
                    'heading' => $heading,
                    'description' => $description,
                    'icon' => $shortcode->{'icon_' . $i},
                    'data_wow_delay' => '.' . ($i - 1) * 2 . 's',
                ];
            }
        }
    }
@endphp

<section class="section mt-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                @if ($title = $shortcode->title)
                    <h2 class="color-brand-1 mb-15">{!! BaseHelper::clean($title) !!}</h2>
                @endif

                @if ($subtitle = $shortcode->subtitle)
                    <p class="font-sm color-grey-500">{!! BaseHelper::clean($subtitle) !!}</p>
                @endif
                <div class="mt-50">
                    @foreach($tabs as $tab)
                        <div class="wow animate__animated animate__fadeInUp" data-wow-delay="{{ Arr::get($tab, 'data_wow_delay') }}">
                            <div class="card-offer card-we-do card-contact hover-up">
                                <div class="card-image">
                                    <img src="{{ RvMedia::getImageUrl(Arr::get($tab, 'icon'), null, false, RvMedia::getDefaultImage()) }}" alt="{{ Arr::get($tab, 'heading') }}">
                                </div>
                                <div class="card-info">
                                    <h6 class="color-brand-1 mb-10">{{ Arr::get($tab, 'heading') }}</h6>
                                    <p class="font-md color-grey-500 mb-5">{!! BaseHelper::clean(Arr::get($tab, 'description')) !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-7">
                <div class="box-form-contact wow animate__animated animate__fadeIn" data-wow-delay=".6s">
                    {!! Form::open(['route' => 'public.send.contact', 'class' => 'contact-form cons-contact-form']) !!}
                        {!! apply_filters('pre_contact_form', null) !!}
                        <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group mb-25">
                                <input name="name" class="form-control icon-user" type="text" placeholder="{{ __('Your name') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group mb-25">
                                <input name="email" class="form-control icon-email" type="text" placeholder="{{ __('Email') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group mb-25">
                                <input name="phone" class="form-control icon-phone" type="text" placeholder="{{ __('Phone') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group mb-25">
                                <input name="company" class="form-control icon-company" type="text" placeholder="{{ __('Company') }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-25">
                                <input name="address" class="form-control" type="text" placeholder="{{ __('Address') }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-25">
                                <input name="subject" class="form-control" type="text" placeholder="{{ __('Subject') }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-25">
                                <textarea name="content" class="form-control textarea-control" placeholder="{{ __('Write something') }}"></textarea>
                            </div>
                        </div>
                        @if (is_plugin_active('captcha'))
                            @if (setting('enable_captcha'))
                                <div class="col-12">
                                    <div class="mb-3">
                                        {!! Captcha::display() !!}
                                    </div>
                                </div>
                            @endif

                            @if (setting('enable_math_captcha_for_contact_form', 0))
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="math-group">{{ app('math-captcha')->label() }}</label>
                                        {!! app('math-captcha')->input(['class' => 'form-control', 'id' => 'math-group', 'placeholder' => app('math-captcha')->getMathLabelOnly() . ' = ?']) !!}
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="col-xl-4 col-lg-5 col-md-5 col-sm-6 col-9">
                            <div class="form-group">
                                <button class="btn btn-brand-1-full font-sm" type="submit">{!! BaseHelper::clean($shortcode->title_button ?: __('Send message')) !!}
                                    <svg class="w-6 h-6 icon-16 ms-1" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    {!! apply_filters('after_contact_form', null) !!}
                    <div class="col-span-12">
                        <div class="contact-form-group mt-4">
                            <div class="contact-message contact-success-message" style="display: none"></div>
                            <div class="contact-message contact-error-message" style="display: none"></div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
