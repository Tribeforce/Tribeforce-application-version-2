<?php
/*
This template expects following variables:
- Mandatory
  $name: The name of the field
  $d: the object holding the fields
- Optional
  $label

The label will be taken from the language file lang/<language>/forms.php
*/

$val = nl2br($d->getAttribute($name));


switch($name) {
  case 'avatar':
    $type = 'image';
    break;
  case 'email':
    $type = 'email';
    break;
  default:
    $type = 'all';
}
?>

@if($type === 'image')
  <div class="{{$name}}">
  @if(empty($val))
    <image src="/images/{{$name}}.png">
  @else
    <image src="/files/{{$val}}.small">
  @endif
  </div>
@else
  @if(!empty($val))
  <div class="{{$name}}">
    @if(isset($label) && $label)
    <h5>@lang("forms.$name")</h5>
    @endif
    @if($type === 'email')
    {{HTML::mailto($val, null, array('target' => '_blank'))}}
    @else
    {{$val}}
    @endif
  </div>
  @endif
@endif
