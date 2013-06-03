<?php
/*
This template expects following variables:
- Mandatory
  - $type: the type of the field. Needs to correspond to a Blade form function
  - $name: the name attribute for the input field
  - $default: only for the switch
- Optional
  - $sl: show_label indicates if label needs to be shown or not. TRUE or FALSE
  - $classes: Classes to be set on the container
  - $default: The default value

The label will be taken from the language file lang/<language>/forms.php
*/

// Preppare variables
$classes = isset($classes) ? $classes : '';
$classes = "form-field type-$type name-$name $classes";
$classes = $errors->has($name) ? "$classes error" : $classes;
$show_label = isset($sl) && !$sl ? false : true;
if($type === 'submit') $show_label = false;

// Set the default value
if($type === 'switch') {
  $on  = isset($custom) && $custom ? trans("forms.$name"."_on") : trans('forms.on');
  $off = isset($custom) && $custom ? trans("forms.$name"."_off") : trans('forms.off');
  $switch_class = isset($custom) && $custom ? ' custom' : '';
} else {
  $old = Input::old($name);
  if(!empty($old)) {
    $def = $old;
  } elseif(isset($d->$name)) {
    $def = $d->$name;
  } else {
    $def = null;
  }
}
?>

<div class="{{ $classes }}">
  <?php // Label ?>
  @if($show_label)
    {{ Form::label($name, trans("forms.$name")) }}
  @endif

  <?php // Field ?>
  @if($type === 'text')
    {{ Form::$type($name, $def, array('placeholder'=>trans("forms.$name"))) }}
  @elseif($type === 'password')
    {{ Form::$type($name) }}
  @elseif($type === 'switch')
    <div class="switch small{{$switch_class}}">
    {{ Form::radio($name, '0', !$default, array('id' => $name)) }}
    {{ Form::label($name, $off) }}
    {{ Form::radio($name, '1', $default, array('id' => $name.'1')) }}
    {{ Form::label($name.'1', $on) }}
    <span></span>
    </div>
  @elseif($type === 'select')
    {{ Form::select($name, $values, $default) }}
  @elseif($type === 'submit')
    {{ Form::$type(trans("forms.$name"), array('class' => 'button right')) }}
  @endif

  <?php // Error message ?>
  @if($errors->has($name))
    @foreach($errors->get($name) as $message)
    <small>{{ $message }}</small>
    @endforeach
  @endif

</div>
