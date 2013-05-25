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
  {{ link_to_action('ApplicationController@getFacebook', trans('forms.facebook'), null, array('class' => 'left')) }}
  @include('form.field', array('type' => 'submit', 'name' => trans('forms.save')))
</div>
@endsection
