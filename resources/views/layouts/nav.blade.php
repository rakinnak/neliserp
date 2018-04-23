<ul class="navbar-nav mr-auto">
    @auth
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="buying" data-toggle="dropdown">{{ __('buying') }}</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="/docs">{{ __('buying.po') }}</a>
              <a class="dropdown-item" href="/docs">{{ __('buying.do') }}</a>
              <a class="dropdown-item" href="/docs">{{ __('buying.invoice') }}</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="selling" data-toggle="dropdown">{{ __('selling') }}</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="/docs">{{ __('selling.po') }}</a>
              <a class="dropdown-item" href="/docs">{{ __('selling.do') }}</a>
              <a class="dropdown-item" href="/docs">{{ __('selling.invoice') }}</a>
            </div>
        </li>
    
        @can('index', App\Item::class)
            <li class="nav-item">
                <a class="nav-link" href="/items">{{ __('items') }}</a>
            </li>
        @endcan
    
        <li class="nav-item">
            <a class="nav-link" href="/companies">{{ __('companies') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/reports">{{ __('reports') }}</a>
        </li>
    @endauth
</ul>
