@extends('layouts.offcanvas')
<?php
$sections =  array(
  'administrative',
  'competencies',
  'objectives',
  'vision',
);
?>

@section('sidebar')
@endsection

@section('main')
<div id="tribe-details">
  <div class="row">
    <div class="columns small-5">
      {{link_to_route('users.edit', trans('forms.edit'), $d->id, array('class' => 'button small expand'))}}
    </div>

  </div>
  <div class="section-container auto" data-section data-options="deep_linking: true">
    @foreach($sections as $section)
    <section>
      <div class="title" data-section-title><a href="#{{$section}}">@lang("ui.$section")</a></div>
      <div class="content" data-slug="{{$section}}" data-section-content>
        <div data-section-content>
        </div>
      </div>
    </section>
    @endforeach
  </div>
  {{ link_to('tribe', trans('ui.back'), array('class' => 'left')) }}
</div>
@endsection
