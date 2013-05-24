@extends('basic')

@section('body')
  <div class="row">
    <div id="nav" class="large-3 columns">
      <div class="version">{{ trans('ui.version') . ": " . Config::get('tf.version') }}</div>
      @section('nav')
        {{ HTML::image('images/logo.png', 'Tribeforce logo') }}
      @show
    </div>
    <div id="page" class="large-9 columns">
      @include('header', array('show_menu' => FALSE))
      @include('messages')
      <div id="content" class="row">
        <div class="columns">
      @yield('content')
      </div>
      </div>
    </div>
  </div>
@endsection
