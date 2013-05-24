@extends('master')

@section('nav')
  @parent

  Navigation bar
@endsection

@section('content')
<div id="dashboard">
  @include('menu')
</div>
@endsection
