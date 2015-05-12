@if($type == "boolean")
{{ ($value == 1) ? 'Oui' : 'Non' }}
@elseif($type == "enum" && isset($data[$value]))
{{ $data[$value] }}
@endif
