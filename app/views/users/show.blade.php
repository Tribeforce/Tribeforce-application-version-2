@extends('layouts.master')

@section('nav')
  @parent

  Navigation bar
@endsection

@section('content')
<div id="user-show">
  <div class="email">
    {{ $d->email }}
  </div>
  <?php // TODO: use link_to_route.  Seems buggy at this moment ?>
  {{ link_to(route('users.edit', array('users' => $d->id)), trans('forms.edit'), array('class' => 'button radius')) }}
  </a>
</div>
@endsection
