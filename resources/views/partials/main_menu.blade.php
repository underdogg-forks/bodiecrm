{{-- General sidebar menu --}}

<ul>
  <li {{ (Request::is('campaign*') ? 'class=active' : '') }}>
    <a href="{{ url('campaigns') }}"><i class="fa fa-briefcase"></i><br>Campaigns</a>
  </li>

  <li {{ (Request::is('landing_pages*') ? 'class=active' : '') }}>
    <a href="{{ url('landing_pages') }}"><i class="fa fa-stack-overflow"></i><br>Landing Pages</a>
  </li>

  <li {{ (Request::is('leads*') ? 'class=active' : '') }}>
    <a class="main_menu_leads" data-options="align:right" data-dropdown="drop" href="{{ url('leads') }}">
      <i class="fa fa-file-text-o"></i><br>Leads
    </a>
    <ul id="drop" class="f-dropdown" data-dropdown-content>
      <li><a href="{{ url('leads/owner') }}">Leads that you own</a></li>
      <li><a href="{{ url('leads/watcher') }}">Leads that you watch</a></li>
      <li><a href="{{ url('leads') }}">All Leads</a></li>
      <li class="divider"></li>
      <li><a href="{{ url('leads/create') }}">Manually add a lead</a></li>
    </ul>
  </li>
</ul>