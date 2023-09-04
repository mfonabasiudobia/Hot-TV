@php
    $spinTemplate = json_decode(setting('ai_writer_spin_template'), true);
@endphp

<div class="d-inline-block editor-action-item">
    <button type="button" class="btn btn-info btn-ai-writer btn-ai-writer-generate">
        <i class="fas fa-robot me-1"></i>
        {{ trans('plugins/ai-writer::ai-writer.generate') }}
    </button>
    @empty(! $spinTemplate)
        <button type="button" class="btn btn-primary btn-ai-writer btn-ai-writer-spin">{{ trans('plugins/ai-writer::ai-writer.spin') }}</button>
    @endempty
</div>

@pushonce('footer')
    <div id="ai-writer-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">
                        <i class="til_img"></i>
                        <strong>{{ trans('plugins/ai-writer::ai-writer.form.title') }}</strong>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>

                <div class="modal-body with-padding">
                    @include('plugins/ai-writer::generate-content')
                </div>

                <div class="modal-footer">
                    <button type="button" class="float-start btn btn-warning" data-bs-dismiss="modal">{{ trans('core/base::tables.cancel') }}</button>
                    <button type="button" class="float-end btn btn-info" id="generate-content" data-generate-url="{{ route('ai-writer.generate') }}" href="">{{ trans('plugins/ai-writer::ai-writer.form.generate') }}</button>
                    <button type="button" class="float-end btn btn-success" id="push-content-to-target" href="" data-copied-text="{{ trans('plugins/ai-writer::ai-writer.form.copied') }}">{{ trans('plugins/ai-writer::ai-writer.form.push') }}</button>
                </div>
            </div>
        </div>
    </div>

    @empty(! $spinTemplate)
    <div id="ai-writer-spin-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">
                        <i class="til_img"></i>
                        <strong>{{ trans('plugins/ai-writer::ai-writer.form.title') }}</strong>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>

                <div class="modal-body with-padding">
                    @include('plugins/ai-writer::spin-content')
                </div>

                <div class="modal-footer">
                    <button type="button" class="float-start btn btn-warning" data-bs-dismiss="modal">{{ trans('core/base::tables.cancel') }}</button>
                    <a class="float-end btn btn-info" id="spin-content" href="">{{ trans('plugins/ai-writer::ai-writer.form.spin') }}</a>
                    <a class="float-end btn btn-success" id="push-spin-content-to-target" href="" data-copied-text="{{ trans('plugins/ai-writer::ai-writer.form.copied') }}">{{ trans('plugins/ai-writer::ai-writer.form.push') }}</a>
                </div>
            </div>
        </div>
    </div>
    @endempty
@endpushonce
