@extends('layouts.offcanvas')


@section('sidebar')
@endsection

@section('main')
<div id="tribe-index">
  <div class="row">
    <div class="columns small-5">
      {{link_to_route('users.create', trans('forms.add'), null, array('class' => 'button small expand'))}}
    </div>
    <div class="columns small-7">
      <input type="text" placeholder="@lang('forms.filter')" class="right">
    </div>
  </div>
  <div class="section-container auto" data-section>
    @foreach(User::getAllTypes() as $key => $type)
    <section class="section">
      <div class="title" data-section-title><a href="#{{$type}}">@lang("ui.users.type.$key")</a></div>
      <div class="content" data-slug="{{$type}}" data-section-content>
        <ul class="small-block-grid-1 large-block-grid-2" data-section-content>
          @if(!empty($d[$key]))
          @foreach($d[$key] as $person)
            <li>
              <a href="{{action('TribeController@getDetails', array($person->id))}}">
                @include('field', array('name' => 'avatar', 'd' => $person))
              </a>
              @include('field', array('name' => 'full_name', 'd' => $person))
              <div class="occupation">Occupation</div>
            </li>
          @endforeach
          @endif
        </ul>
      </div>
    </section>
    @endforeach
  </div>
</div>
@endsection
