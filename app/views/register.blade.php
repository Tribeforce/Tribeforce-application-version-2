@extends('layouts.basic')

@section('body')
<div id="login">
  <div class="row header">
    <div class="columns">
      {{ HTML::image('images/logo.png', 'Tribeforce logo') }}
    </div>
  </div>

  @include('messages')

  <div class="row">
    <div class="columns">
      {{ Form::open(array('url' => 'register')) }}
        @include('form.field', array('type' => 'text', 'name' => 'email'))
        @include('form.field', array('type' => 'password', 'name' =>'password'))
        @include('form.field', array('type' => 'password', 'name' =>'password_confirmation'))
        {{ link_to_action('ApplicationController@getLogin',
                     trans('forms.login'), null, array('class' => 'left')) }}
        @include('form.field', array('type' => 'submit', 'name' => trans('forms.register')))
      {{ Form::close() }}
    </div>
  </div>
</div>
@endsection
