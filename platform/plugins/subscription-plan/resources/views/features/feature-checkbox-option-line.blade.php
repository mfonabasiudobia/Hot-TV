@php
/**
 * @var string $value
 */
$value = isset($value) ? (array)$value : [];
@endphp
@if($features)
    <ul>
        @foreach($features as $feature)
            
                <li value="{{ $feature->id ?? '' }}"
                        {{ $feature->id == $value ? 'selected' : '' }}>
                    {!! Form::customCheckbox([
                        [
                            $name, $feature->id, $feature->name, in_array($feature->id, $value),
                        ]
                    ]) !!}
                </li>
            
        @endforeach
    </ul>
@endif
