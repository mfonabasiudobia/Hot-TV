<textarea 
    {{ $attributes->merge(['class' => "form-control tinymce-editor"]) }}
    wire:key="{{$modelName}}"
    x-ref="{{$modelName}}"
    wire:model.defer="{{$modelName}}"
    placeholder="Content"
    @if($alpineModel) 
        x-model="{{$alpineModel}}"
    @endif
    x-data 
    x-init="() => {
        tinymce.init({
            selector: '.tinymce-editor',
            defer: true,
            height: 400,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount', 'image'
            ],
            setup: function (editor) {
                editor.on('change', function () {
                    $dispatch('input', editor.getContent());
                    //editor.setContent(editor.getContent());
                });
            }
        });
    }"
></textarea>