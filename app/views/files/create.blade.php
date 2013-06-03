@extends('layouts.offcanvas')

@section('sidebar')
@endsection

@section('main')
<div id="files-create">
  <?php
  // TODO: use 'route' => 'users.update' as in the doc. This is currently buggy
  $is_admin = $current_user->hasGroup('admin');
  ?>

  {{ Form::open(array('route' => 'files.store', 'files' => true)) }}
    {{ Form::file('image') }}
    @include('form.field', array('type' => 'text', 'name' => 'name'))
    @include('form.field', array('type' => 'submit', 'name' => 'save'))
  {{ Form::close() }}
</div>
@endsection
