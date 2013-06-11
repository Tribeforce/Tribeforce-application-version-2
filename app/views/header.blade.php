<nav class="top-bar">
  <ul class="title-area">
    <li class="toggle-sidebar menu-icon show-for-small">
      <a id="sidebarButton" href="#sidebar">
        <span>Menu</span>
      </a>
    </li>
    <li class="name greeting">
      <a href="/" class="left hide-for-small">
        {{ HTML::image('/images/logo.png', 'Tribeforce logo') }}
      </a>
      {{ HTML::linkAction('ApplicationController@getLogout', trans('ui.logout'),
      array(), array('class' => 'logout has-tip right show-for-small', 'data-tooltip' => '',
      'title' => trans('ui.logout'))) }}

      {{ HTML::linkAction('ApplicationController@getSettings', trans('ui.settings'),
      array(), array('class' => 'settings has-tip right show-for-small', 'data-tooltip' => '',
      'title' => trans('ui.settings'))) }}
      <span class="right show-for-small">
        {{ trans('ui.greeting', array('name' => User::current()->first_name)) }}
      </span>
    </li>
    <li class="toggle-topbar menu-icon show-for-small">
      <a href="#"><span>Menu</span></a>
    </li>
  </ul>
  <section class="top-bar-section">
    <ul class="left">
      <li class="divider"></li>
      @include('menu')
    </ul>
    <ul class="right hide-for-small">
      <li class="divider"></li>
      <li class="greeting">
        {{ HTML::linkAction('ApplicationController@getLogout', trans('ui.logout'),
        array(), array('class' => 'logout has-tip right', 'data-tooltip' => '',
        'title' => trans('ui.logout'))) }}

        {{ HTML::linkAction('ApplicationController@getSettings', trans('ui.settings'),
        array(), array('class' => 'settings has-tip right', 'data-tooltip' => '',
        'title' => trans('ui.settings'))) }}
        <span class="right">
          {{ trans('ui.greeting', array('name' => User::current()->first_name)) }}
        </span>
      </li>
    </ul>
  </section>
</nav>
