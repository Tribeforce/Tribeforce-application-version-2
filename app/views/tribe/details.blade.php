@extends('layouts.offcanvas')

@section('sidebar')
@endsection

@section('main')
<div id="tribe-details">
  <div class="section-container auto" data-section id="test">
    <section>
      <div class="title" data-section-title><a href="#about">@lang("ui.about")</a></div>
      <div class="content" data-slug="about" data-section-content>
        <div data-section-content class="row">
          <div class="columns small-12 large-6">
          @include('field', array('name' => 'avatar'))
          </div>
          <div class="columns small-12 large-6">
          @include('field', array('name' => 'full_name'))
          @include('field', array('name' => 'email'))
          @include('field', array('name' => 'birth_date'))
          @include('field', array('name' => 'hire_date'))
          @include('field', array('name' => 'destiny', 'label' => true))
          @include('field', array('name' => 'character', 'label' => true))
          @include('field', array('name' => 'calling', 'label' => true))
          {{link_to_route('users.edit', trans('forms.edit'), $d->id, array('class' => 'button small right'))}}
          </div>

        </div>
      </div>
    </section>
    <section>
      <div class="title" data-section-title><a href="#competencies">@lang("ui.competencies")</a></div>
      <div class="content" data-slug="competencies" data-section-content>
        <div data-section-content>
        </div>
      </div>
    </section>
    <section>
      <div class="title" data-section-title><a href="#occupation">@lang("ui.occupation")</a></div>
      <div class="content" data-slug="occupation" data-section-content>
        <h5>Occupation name (since 2013-05-21)</h5>
        <div class="section-container auto" data-section>
          <section>
            <div class="title" data-section-title><a href="#tasks">@lang("ui.tasks")</a></div>
            <div class="content" data-slug="tasks" data-section-content>
              <div data-section-content>
              </div>
            </div>
          </section>
          <section>
            <div class="title" data-section-title><a href="#objectives">@lang("ui.objectives")</a></div>
            <div class="content" data-slug="objectives" data-section-content>
        <div data-section-content>
        </div>
            </div>
          </section>
          <section>
            <div class="title" data-section-title><a href="#current-competencies">@lang("ui.competencies")</a></div>
            <div class="content" data-slug="current-competencies" data-section-content>
        <div data-section-content>
        </div>
            </div>
          </section>
        </div>
      </div>
    </section>
    <section>
      <div class="title" data-section-title><a href="#evolution">@lang("ui.evolution")</a></div>
      <div class="content" data-slug="evolution" data-section-content>
      </div>
    </section>
  </div>
  {{ link_to('tribe', trans('ui.back'), array('class' => 'left')) }}
</div>
@endsection
