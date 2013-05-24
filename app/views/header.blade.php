{{--
This template expects following variables:
- Mandatory
- Optional
--}}

<div id="header" class="row">
  @if(!(isset($show_menu) && !$show_menu))
  <div class="menu large-7 columns">het menu</div>
  @endif
  <div class="buttons {{ (isset($show_menu) && !$show_menu) ? 'large-offset-8 ' : '' }}large-5 columns">
    <div class="greeting left">
    {{ trans('ui.greeting', array('name' => Sentry::getUser()->email)) }}
    </div>

    {{ HTML::linkAction('ApplicationController@getLogout', trans('ui.logout'),
    array(), array('class' => 'logout has-tip left', 'data-tooltip' => '',
    'title' => trans('ui.logout'))) }}

    {{ HTML::linkAction('ApplicationController@getSettings', trans('ui.settings'),
    array(), array('class' => 'settings has-tip left', 'data-tooltip' => '',
    'title' => trans('ui.settings'))) }}
  </div>

</div>
