@extends('layouts.offcanvas')

@section('sidebar')
  Navigation bar
@endsection

@section('main')
<div id="dashboard">
  <ul class="small-block-grid-2 large-block-grid-3">
    @include('menu', array('grid' => TRUE))
  </ul>
</div>
@endsection
