@extends('layouts.master')

@section('nav')
  @parent

  Navigation bar
@endsection

@section('content')
<div id="user-show">
  <?php
  // TODO: use 'route' => 'users.update' as in the doc. This is currently buggy
  $is_admin = $current_user->inGroup(Sentry::getGroupProvider()->findByName('admin'));

  ?>

  {{ Form::model($d, array('url' => 'users/'.$d->id, 'method' => 'put')) }}
    @if($is_admin)
      @include('form.field', array('type' => 'switch', 'name' => 'activated'))
    @endif

    @include('form.field', array('type' => 'text', 'name' => 'first_name'))
    @include('form.field', array('type' => 'text', 'name' => 'last_name'))
    @include('form.field', array('type' => 'text', 'name' => 'email'))
    @if($is_admin)
      @include('form.groups', array('groups' => $d->getGroups()))
    @endif
    @if($d->id == Sentry::getUser()->id)
      @if( ! $d->facebook_id)
        {{ link_to_action('ApplicationController@getFacebook', trans('forms.fb_connect'), null, array('class' => 'left')) }}
      @else
        {{ link_to_action('ApplicationController@getForgetFacebook', trans('forms.fb_forget'), null, array('class' => 'left')) }}
      @endif
    @endif
    {{ link_to('users/'.$d->id, trans('forms.cancel'), array('class' => 'left')) }}
    @include('form.field', array('type' => 'submit', 'name' => trans('forms.save')))
  {{ Form::close() }}
</div>
@endsection
