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
  {{ Form::open(array('url' => 'login')) }}
    @include('form.field', array('type' => 'text', 'name' => 'email'))
    @include('form.field', array('type' => 'password', 'name'=>'password'))
    @include('form.field', $remember_options)
    <div class="row actions">
      <div class="small-6 columns">
      @lang('forms.login_with')
      {{ link_to_action('ApplicationController@getFacebook',
                   ' ', null, array('class' => 'soc foundicon-facebook')) }}
      {{ link_to_action('ApplicationController@getRegister',
                   trans('forms.register')) }}
      </div>
      <div class="small-6 columns">
      @include('form.field', array('type' => 'submit', 'name' => 'login'))
      </div>
    </div>
  {{ Form::close() }}
</div>
@endsection
