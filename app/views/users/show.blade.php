@extends('layouts.offcanvas')

@section('sidebar')
  Navigation bar
@endsection

@section('main')
<div id="user-show">
  <div class="full-name">
    {{ $d->first_name . ' ' . $d->last_name }}
  </div>
  <div class="email">
    {{ $d->email }}
  </div>
  <?php // TODO: use link_to_route.  Seems buggy at this moment ?>
  {{ link_to(route('users.edit', array('users' => $d->id)), trans('forms.edit'), array('class' => 'button right')) }}
  </a>
</div>
@endsection
