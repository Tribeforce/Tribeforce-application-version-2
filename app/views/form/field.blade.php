<?php
/*
This template expects following variables:
- Mandatory
  - $type: the type of the field. Needs to correspond to a Blade form function
  - $name: the name attribute for the input field
- Optional
  - $sl: show_label indicates if label needs to be shown or not. TRUE or FALSE
  - $classes: Classes to be set on the container

The label will be taken from the language file lang/<language>/forms.php
*/

// Preppare variables
$classes = isset($classes) ? $classes : '';
$classes = "form-field type-$type name-$name $classes";
$classes = $errors->has($name) ? "$classes error" : $classes;
$show_label = isset($sl) && !$sl ? false : true;
if($type === 'submit') $show_label = false;

// Set the default value
$old = Input::old($name);
if(!empty($old)) {
  $default = $old;
} elseif(isset($d->$name)) {
  $default = $d->$name;
} else {
  $default = null;
}

if($type === 'switch') {
  $on  = isset($on)  ? $on  : trans('forms.on');
  $off = isset($off) ? $off : trans('forms.off');
  $checked = isset($checked) ? $checked : $default;
}

?>

<div class="{{ $classes }}">
  <?php // Label ?>
  @if($show_label)
    {{ Form::label($name, trans("forms.$name")) }}
  @endif

  <?php // Field ?>
  @if($type === 'text')
    {{ Form::$type($name,$default,array('placeholder'=>trans("forms.$name"))) }}
  @elseif($type === 'password')
    {{ Form::$type($name) }}
  @elseif($type === 'switch')
    <div class="switch small">
    {{ Form::radio($name, 0, !$checked) }}
    {{ Form::label($name, $off) }}
    {{ Form::radio($name, 1, $checked) }}
    {{ Form::label($name.'1', $on) }}
    <span></span>
    </div>
  @elseif($type === 'submit')
    {{ Form::$type($name, array('class' => 'button radius right')) }}
  @endif

  <?php // Error message ?>
  @if($errors->has($name))
    @foreach($errors->get($name) as $message)
    <small>{{ $message }}</small>
    @endforeach
  @endif

</div>
