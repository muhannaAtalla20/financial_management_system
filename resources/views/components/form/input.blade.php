@props([
    'type' => 'text',
    'value' => '',
    'name',
    'label'=>'',
])
@if ($label)
    <label for="{{$name}}">
        {{ $label }}
    </label>
@endif

<input
    type="{{$type}}"
    id="{{$name}}"
    name="{{$name}}"
    value="{{old($name, $value)}}"
    {{$attributes->class([
        'form-control',
        'is-invalid' => $errors->has($name)
    ])}}
/>

{{-- Validation --}}
@error($name)
    <div class="invalid-feedback">
        {{$message}}
    </div>
@enderror
