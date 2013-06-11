@extends('layouts.offcanvas')

@section('sidebar')
  Navigation bar
@endsection

@section('main')
<div id="user-create">
  <?php
  // TODO: use 'route' => 'users.update' as in the doc. This is currently buggy
  $type_params = array(
    'type'    => "select",
    'name'    => 'type',
    'values'  => key_val("ui.users.type", array_keys(User::getAllTypes())),
    'default' => false,
  );


  ?>

  {{ Form::open(array('route' => 'users.store', 'files' => true)) }}
    @include('form.field', array('type' => 'switch', 'name' => 'activated', 'custom' => true, 'default' => true))

    @include('form.field', $type_params)
    @include('form.field', array('type' => 'image', 'name' => 'avatar'))
    @include('form.field', array('type' => 'text', 'name' => 'first_name', 'classes' => 'mandatory'))
    @include('form.field', array('type' => 'text', 'name' => 'last_name', 'classes' => 'mandatory'))
    @include('form.field', array('type' => 'text', 'name' => 'email', 'classes' => 'mandatory'))
    @include('form.field', array('type' => 'date', 'name' => 'birth_date'))
    @if($is_admin)
      @include('form.field', array('type' =>'date', 'name' => 'hire_date'))
    @endif

    @include('form.settings')
    @include('form.groups')

    {{ link_to('tribe', trans('forms.cancel'), array('class' => 'left')) }}
    @include('form.field', array('type' => 'submit', 'name' => 'save'))
  {{ Form::close() }}
</div>
@endsection
