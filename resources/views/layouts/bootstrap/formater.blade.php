@if($type == "boolean")
{{ ($value == 1) ? 'Oui' : 'Non' }}
@elseif($type == "enum" && isset($data[$value]))
{{ $data[$value] }}
@elseif($type == "image" && gettype($value) == 'string')
<img src="{{ $value }}" />
@elseif($type == "image")
{{ dd($value) }}
@elseif($type == "readonly")
{{ $value }}
@endif