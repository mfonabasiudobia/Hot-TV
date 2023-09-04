@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="max-width-1200">
        <form action="{{ route('ai-writer.settings') }}" method="post">
            @csrf

            <x-core-setting::section
                :title="trans('plugins/ai-writer::ai-writer.setting.generate')"
                :description="trans('plugins/ai-writer::ai-writer.setting.generate_description')"
            >
                @if(BaseHelper::getRichEditor() !== 'ckeditor')
                    <div class="note note-warning" role="alert">
                        {{ trans('plugins/ai-writer::ai-writer.setting.editor_not_support') }}
                    </div>
                @endif

                <x-core-setting::text-input
                    name="ai_writer_openai_key"
                    type="password"
                    :label="trans('plugins/ai-writer::ai-writer.setting.openai_key')"
                    :value="old('ai_writer_openai_key', BaseHelper::hasDemoModeEnabled() ? Str::mask(setting('ai_writer_openai_key'), '*', 30) : setting('ai_writer_openai_key'))"
                    placeholder="**********"
                />

                <x-core-setting::text-input
                    name="ai_writer_openai_temperature"
                    type="text"
                    :label="trans('plugins/ai-writer::ai-writer.setting.openai_temperature')"
                    :value="old('ai_writer_openai_temperature', setting('ai_writer_openai_temperature'))"
                    :placeholder="trans('plugins/ai-writer::ai-writer.setting.openai_temperature')"
                />

                <x-core-setting::text-input
                    name="ai_writer_openai_max_tokens"
                    type="text"
                    :label="trans('plugins/ai-writer::ai-writer.setting.openai_max_tokens')"
                    :value="old('ai_writer_openai_max_tokens', setting('ai_writer_openai_max_tokens', 2000))"
                    :placeholder="trans('plugins/ai-writer::ai-writer.setting.openai_max_tokens')"
                />

                <x-core-setting::text-input
                    name="ai_writer_openai_frequency_penalty"
                    type="text"
                    :label="trans('plugins/ai-writer::ai-writer.setting.openai_frequency_penalty')"
                    :value="old('ai_writer_openai_frequency_penalty', setting('ai_writer_openai_frequency_penalty'))"
                    :placeholder="trans('plugins/ai-writer::ai-writer.setting.openai_frequency_penalty')"
                />

                <x-core-setting::text-input
                    name="ai_writer_openai_presence_penalty"
                    type="text"
                    :label="trans('plugins/ai-writer::ai-writer.setting.openai_presence_penalty')"
                    :value="old('ai_writer_openai_presence_penalty', setting('ai_writer_openai_presence_penalty'))"
                    :placeholder="trans('plugins/ai-writer::ai-writer.setting.openai_presence_penalty')"
                />

                @if ($models)
                    <x-core-setting::select
                        name="ai_writer_openai_default_model"
                        :label="trans('plugins/ai-writer::ai-writer.setting.openai_model')"
                        :options="$models"
                        :value="setting('ai_writer_openai_default_model')"
                        helper-text="<a href='https://platform.openai.com/docs/models/model-endpoint-compatibility' target='_blank'>{{ trans('plugins/ai-writer::ai-writer.setting.see_documentation', ['link' => 'https://platform.openai.com/docs/models/model-endpoint-compatibility']) }}</a>"
                    />
                @endif
            </x-core-setting::section>

            <x-core-setting::section
                :title="trans('plugins/ai-writer::ai-writer.setting.generate_default')"
            >
                <div id="prompt-template-wrapper">
                    <a class="link add-template">
                        <small>+ {{ trans('plugins/ai-writer::ai-writer.setting.add_more') }}</small>
                    </a>
                </div>
            </x-core-setting::section>

            <x-core-setting::section
                :title="trans('plugins/ai-writer::ai-writer.setting.proxy')"
                :description="trans('plugins/ai-writer::ai-writer.setting.proxy_description')"
            >
                <div class="form-group mb-3">
                    <label class="text-title-field" for="ai_writer_proxy_enable">{{ trans('plugins/ai-writer::ai-writer.setting.proxy_enable') }}</label>
                    <label class="me-2">
                        <input type="radio" name="ai_writer_proxy_enable" class="setting-selection-option" data-target="#autocontent-proxy-settings" value="1" @if (setting('ai_writer_proxy_enable')) checked @endif>{{ trans('core/setting::setting.general.yes') }}
                    </label>
                    <label>
                        <input type="radio" name="ai_writer_proxy_enable" class="setting-selection-option" data-target="#autocontent-proxy-settings" value="0" @if (!setting('ai_writer_proxy_enable')) checked @endif>{{ trans('core/setting::setting.general.no') }}
                    </label>
                </div>

                <div id="autocontent-proxy-settings" class="mb-4 border rounded-top rounded-bottom p-3 bg-light @if (!setting('ai_writer_proxy_enable')) d-none @endif">
                    <div class="form-group mb-3">
                        <label>{{ trans('plugins/ai-writer::ai-writer.setting.proxy_protocol') }} </label>
                        <div class="ui-select-wrapper">
                            {!! Form::select(
                                'ai_writer_proxy_protocol',
                                ['0' => 'http', '1' => 'https'],
                                setting('ai_writer_proxy_protocol'),
                                ['class' => 'ui-select', 'id' => 'ai_writer_proxy_protocol'],
                            ) !!}
                            <svg class="svg-next-icon svg-next-icon-size-16">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>{{ trans('plugins/ai-writer::ai-writer.setting.proxy_ip') }}</label>
                        {!! Form::text('ai_writer_proxy_ip', setting('ai_writer_proxy_ip'), [
                            'placeholder' => '192.168.1.1',
                            'class' => 'next-input',
                        ]) !!}
                    </div>
                    <div class="form-group mb-3">
                        <label>{{ trans('plugins/ai-writer::ai-writer.setting.proxy_port') }}</label>
                        {!! Form::text('ai_writer_proxy_port', setting('ai_writer_proxy_port'), [
                            'placeholder' => '3304',
                            'class' => 'next-input',
                        ]) !!}
                    </div>
                    <div class="form-group mb-3">
                        <label>{{ trans('plugins/ai-writer::ai-writer.setting.proxy_username') }}</label>
                        {!! Form::text('ai_writer_proxy_username', setting('ai_writer_proxy_username'), [
                            'placeholder' => 'username',
                            'class' => 'next-input',
                        ]) !!}
                    </div>
                    <div class="form-group mb-3">
                        <label>{{ trans('plugins/ai-writer::ai-writer.setting.proxy_password') }}</label>
                        <input type="password" placeholder="**********" name="ai_writer_proxy_password" class="next-input" value="{{ old('ai_writer_proxy_password', setting('ai_writer_proxy_password')) }}" />
                    </div>
                </div>
            </x-core-setting::section>

            <x-core-setting::section
                :title="trans('plugins/ai-writer::ai-writer.setting.spin')"
                :description="trans('plugins/ai-writer::ai-writer.setting.spin_description')"
            >
                <div id="spin-template-wrapper">
                    <a class="link add-template" data-placeholder="">
                        <small>+ {{ trans('plugins/ai-writer::ai-writer.setting.add_more') }}</small>
                    </a>
                </div>
            </x-core-setting::section>

            <div class="flexbox-annotated-section" style="border: none">
                <div class="flexbox-annotated-section-annotation">
                    &nbsp;
                </div>
                <div class="flexbox-annotated-section-content">
                    <button class="btn btn-info" type="submit">{{ trans('core/setting::setting.save_settings') }}</button>
                </div>
            </div>
        </form>
    </div>

    @push('footer')
        <script>
            @php
                $templateJson = setting('ai_writer_spin_template') ?: '[]';
                $promptJson = setting('ai_writer_prompt_template') ?: '[]';
            @endphp

            var $spinTemplates;
            var $promptTemplates;

            try {
                $spinTemplates = JSON.parse(@json($templateJson));
            } catch (error) {
                $spinTemplates = [];
            }
            try {
                $promptTemplates = JSON.parse(@json($promptJson));
            } catch (error) {
                $promptTemplates = [];
            }
        </script>

        <template id="spin-html-template">
            <div class="mb-4 border rounded-top rounded-bottom p-3 bg-light more-template">
                <div class="form-group mb-3">
                    <label class="text-title-field">
                        {{ trans('plugins/ai-writer::ai-writer.setting.spin_template_title') }}
                        <a class="btn btn-link text-danger remove-template"><i class="fas fa-minus"></i></a>
                    </label>
                    {!! Form::text('ai_writer_spin_template[][title]', null, [
                        'placeholder' => trans('plugins/ai-writer::ai-writer.setting.spin_template_title'),
                        'class' => 'next-input item-title',
                    ]) !!}
                </div>
                <div class="form-group mb-3">
                    <label class="text-title-field">{{ trans('plugins/ai-writer::ai-writer.setting.spin_label') }}
                    </label>
                    {!! Form::textarea('ai_writer_spin_template[][content]', null, [
                        'placeholder' => trans('plugins/ai-writer::ai-writer.setting.spin_example'),
                        'class' => 'next-input item-content',
                    ]) !!}
                </div>
            </div>
        </template>
        <template id="prompt-html-template">
            <div class="mb-4 border rounded-top rounded-bottom p-3 bg-light more-template">
                <div class="form-group mb-3">
                    <label class="text-title-field">
                        {{ trans('plugins/ai-writer::ai-writer.setting.generate_label') }}
                        <a class="btn btn-link text-danger remove-template"><i class="fas fa-minus"></i></a>
                    </label>
                    {!! Form::text('ai_writer_prompt_template[][title]', null, [
                        'placeholder' => trans('plugins/ai-writer::ai-writer.setting.generate_label'),
                        'class' => 'next-input item-title',
                    ]) !!}
                </div>
                <div class="form-group mb-3">
                    <label class="text-title-field">{{ trans('plugins/ai-writer::ai-writer.setting.generate_content') }}</label>
                    {!! Form::textarea('ai_writer_prompt_template[][content]', null, [
                        'placeholder' => trans('plugins/ai-writer::ai-writer.setting.generate_content'),
                        'class' => 'next-input item-content',
                    ]) !!}
                </div>
            </div>
        </template>
    @endpush

    {!! $jsValidation !!}
@endsection
