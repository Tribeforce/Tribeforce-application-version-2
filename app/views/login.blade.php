@extends('layouts.basic')

<?php
$remember_options = array(
  'type'    => 'switch',
  'name'    => 'remember',
  'sl'      => false,
  'custom'  => true,
  'default' => Session::get('remember'),
);

Session::forget('remember');
?>

@section('body')
<div id="login">
  <div class="row header">
    <div class="columns small-10 small-centered large-6 large-centered">
      {{ HTML::image('images/logo.png', 'Tribeforce logo') }}
    </div>
  </div>

  @include('messages')

  <div class="row">
    <div class="columns small-10 small-centered large-6 large-centered">
      {{ Form::open(array('url' => 'login')) }}
        @include('form.field', array('type' => 'text', 'name' => 'email'))
        @include('form.field', array('type' => 'password', 'name'=>'password'))
        @include('form.field', $remember_options)
        {{ link_to_action('ApplicationController@getFacebook',
                     trans('forms.fb_login'), null, array('class' => 'left button secondary')) }}
        {{ link_to_action('ApplicationController@getRegister',
                     trans('forms.register'), null, array('class' => 'left')) }}
        @include('form.field', array('type' => 'submit', 'name' => trans('forms.login')))
      {{ Form::close() }}
    </div>
  </div>
</div>
@endsection
