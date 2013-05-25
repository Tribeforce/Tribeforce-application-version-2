@extends('layouts.master')

@section('nav')
  @parent

  Navigation bar
@endsection

@section('content')
<div id="user-show">
  @include('form.field', array('type' => 'text', 'name' => 'email'))
  @include('form.field', array('type' => 'password', 'name' =>'password'))
  @include('form.field', array('type' => 'password', 'name' =>'password_confirmation'))
  @if( ! $d->facebook_id)
    {{ link_to_action('ApplicationController@getFacebook', trans('forms.fb_connect'), null, array('class' => 'left')) }}
  @else
    {{ link_to_action('ApplicationController@getForgetFacebook', trans('forms.fb_forget'), null, array('class' => 'left')) }}
  @endif
  @include('form.field', array('type' => 'submit', 'name' => trans('forms.save')))
</div>
@endsection
