@extends('layouts.basic')

@section('body')
<div id="404">
  <div class="row header">
    <div class="columns small-10 small-centered large-6 large-centered">
      {{ HTML::image('images/logo.png', 'Tribeforce logo') }}
    </div>
  </div>

  <div class="row">
    <div class="columns small-10 small-centered large-6 large-centered">
      <h1>{{$title}}</h1>
      {{ trans($message) }}
    </div>
  </div>
</div>
@endsection
