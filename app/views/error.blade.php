@extends('layouts.basic')

@section('body')
<div id="404">
  <h1>{{$title}}</h1>
  {{ trans($message) }}
</div>
@endsection
