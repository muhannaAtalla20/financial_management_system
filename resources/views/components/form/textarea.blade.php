@props([
    'value' => '',
    'name',
    'label'=>'',
])
@if ($label)
    <label for="{{$name}}">
        {{ $label }}
    </label>
@endif

<textarea
    name="{{$name}}"
    rows="4"
    {{$attributes->class([
        'form-control',
        'is-invalid' => $errors->has($name)
    ])}};
>{{old($name,$value)}}</textarea>

{{-- Validation --}}
@error($name)
    <div class="invalid-feedback">
        {{$message}}
    </div>
@enderror
