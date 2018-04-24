<ul class="navbar-nav mr-auto">
    @auth
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="purchase" data-toggle="dropdown">{{ __('purchase') }}</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="/docs/po">{{ __('docs.po') }}</a>
              <a class="dropdown-item" href="/docs/ro">{{ __('docs.ro') }}</a>
              <a class="dropdown-item" href="/docs/ri">{{ __('docs.ri') }}</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="sales" data-toggle="dropdown">{{ __('sales') }}</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="/docs/so">{{ __('docs.so') }}</a>
              <a class="dropdown-item" href="/docs/do">{{ __('docs.do') }}</a>
              <a class="dropdown-item" href="/docs/si">{{ __('docs.si') }}</a>
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
