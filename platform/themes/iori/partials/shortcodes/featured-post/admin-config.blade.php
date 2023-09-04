@php
    $categoryIds = explode(',', Arr::get($attributes, 'category_ids'));
@endphp

<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" />
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Choose categories') }}</label>
        <select class="select-full" name="category_ids" multiple>
            @foreach($categories as $category)
                <option @selected(in_array($category->id, $categoryIds)) value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</section>
