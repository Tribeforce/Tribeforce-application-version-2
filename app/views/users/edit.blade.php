@extends('layouts.offcanvas')

@section('sidebar')
  Navigation bar
@endsection

@section('main')
<div id="user-show">
  <?php
  // TODO: use 'route' => 'users.update' as in the doc. This is currently buggy
  $type_params = array(
    'type'    => "select",
    'name'    => 'type',
    'values'  => key_val("ui.users.type", array_keys(User::getAllTypes())),
    'default' => false,
  );
  ?>

  {{ Form::model($d, array('url' => 'users/'.$d->id, 'method' => 'put', 'files' => true)) }}
    @if($is_admin)
      @include('form.field', array('type' => 'switch', 'name' => 'activated', 'custom' => true, 'default' => $d->activated))
      @include('form.field', $type_params)
    @endif

    @include('form.field', array('type' => 'image', 'name' => 'avatar'))

    @include('form.field', array('type' => 'text', 'name' => 'first_name', 'classes' => 'mandatory'))
    @include('form.field', array('type' => 'text', 'name' => 'last_name', 'classes' => 'mandatory'))
    @include('form.field', array('type' => 'text', 'name' => 'email', 'classes' => 'mandatory'))
    @include('form.field', array('type' => 'date', 'name' => 'birth_date'))
    @if(User::current()->hasGroup('admin'))
      @include('form.field', array('type' =>'date', 'name' => 'hire_date'))
    @endif

    @include('form.settings')
    @include('form.groups')

    @if($d->id == $current_user->id)
      @if( ! $d->facebook_id)
        {{ link_to_action('ApplicationController@getFacebook', trans('forms.fb_connect'), null, array('class' => 'left')) }}
      @else
        {{ link_to_action('ApplicationController@getForgetFacebook', trans('forms.fb_forget'), null, array('class' => 'left')) }}
      @endif
    @endif
    {{ link_to('tribe/details/'.$d->id, trans('forms.cancel'), array('class' => 'left')) }}
    @include('form.field', array('type' => 'submit', 'name' => 'save'))
  {{ Form::close() }}
</div>
@endsection
