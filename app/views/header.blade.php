<nav class="top-bar">
  <ul class="title-area">
    <li class="toggle-sidebar menu-icon">
      <a id="sidebarButton" href="#sidebar">
        <span>Menu</span>
      </a>
    </li>
    <li class="name">
      <a href="/" class="left logo">
        {{ HTML::image('/images/logo.png', 'Tribeforce logo') }}
      </a>
    </li>
    <li class="toggle-topbar menu-icon">
      <a href="#"><span>Menu</span></a>
    </li>
  </ul>
  <section class="top-bar-section">
    <ul class="left">
      <li class="divider"></li>
      @include('menu')
    </ul>
  </section>
</nav>
