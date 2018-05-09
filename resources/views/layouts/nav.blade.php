<ul class="navbar-nav mr-auto">
    @auth
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="purchase" data-toggle="dropdown">{{ __('purchase') }}</a>
            <div class="dropdown-menu">
              <h6 class="dropdown-header">pending</h6>
              <a class="dropdown-item" href="/doc_items/po">&middot; {{ __('doc_items.po') }}</a>
              <a class="dropdown-item" href="/doc_items/ro">&middot; {{ __('doc_items.ro') }}</a>
              <a class="dropdown-item" href="/doc_items/ri">&middot; {{ __('doc_items.ri') }}</a>
              <div class="dropdown-divider"></div>
              <h6 class="dropdown-header">history</h6>
              <a class="dropdown-item" href="/docs/po">&middot; {{ __('docs.po') }}</a>
              <a class="dropdown-item" href="/docs/ro">&middot; {{ __('docs.ro') }}</a>
              <a class="dropdown-item" href="/docs/ri">&middot; {{ __('docs.ri') }}</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="sales" data-toggle="dropdown">{{ __('sales') }}</a>
            <div class="dropdown-menu">
              <h6 class="dropdown-header">pending</h6>
              <a class="dropdown-item" href="/doc_items/so">&middot; {{ __('doc_items.so') }}</a>
              <a class="dropdown-item" href="/doc_items/do">&middot; {{ __('doc_items.do') }}</a>
              <a class="dropdown-item" href="/doc_items/si">&middot; {{ __('doc_items.si') }}</a>
              <div class="dropdown-divider"></div>
              <h6 class="dropdown-header">history</h6>
              <a class="dropdown-item" href="/docs/so">&middot; {{ __('docs.so') }}</a>
              <a class="dropdown-item" href="/docs/do">&middot; {{ __('docs.do') }}</a>
              <a class="dropdown-item" href="/docs/si">&middot; {{ __('docs.si') }}</a>
            </div>
        </li>
    
        @can('index', App\Item::class)
            <li class="nav-item">
                <a class="nav-link" href="/items">{{ __('items') }}</a>
            </li>
        @endcan

        @can('index', App\Location::class)
            <li class="nav-item">
                <a class="nav-link" href="/locations">{{ __('locations') }}</a>
            </li>
        @endcan
    
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="partners" data-toggle="dropdown">{{ __('partners') }}</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="/partners/customer">{{ __('partners.customer') }}</a>
              <a class="dropdown-item" href="/partners/supplier">{{ __('partners.supplier') }}</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="users" data-toggle="dropdown">{{ __('users') }}</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="/users">{{ __('users') }}</a>
              <a class="dropdown-item" href="/roles">{{ __('roles') }}</a>
              <a class="dropdown-item" href="/permissions">{{ __('permissions') }}</a>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/reports">{{ __('reports') }}</a>
        </li>

    @endauth
</ul>
