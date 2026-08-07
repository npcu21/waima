<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-primary" href="https://fivoflow.com/wclm/public/country-admin/dashboard" style="font-size: 1.3rem;">
            ADMIN WAIMA
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <ul class="navbar-nav align-items-center">

                {{-- Language Switch --}}
                <li class="nav-item me-3">
                    <form method="GET" action="{{ route('countryadmin.dashboard') }}">
                        <select name="lang" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="en" {{ request('lang') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="fr" {{ request('lang') == 'fr' ? 'selected' : '' }}>Français</option>
                        </select>
                    </form>
                </li>

                {{-- Admin --}}
                <li class="nav-item me-3">
                    <span class="fw-medium">{{ __('dashboard.admin') }}</span>
                </li>

                {{-- Profile --}}
                <li class="nav-item dropdown">
                    <button class="btn border-0 bg-transparent dropdown-toggle p-0" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-4"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end mt-2 shadow" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="https://fivoflow.com/wclm/public/country-admin/dashboard"><i class="bi bi-speedometer2 me-2"></i>{{ __('dashboard.dashboard') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.product.overview.country') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.overview') }}</a></li>
                        <li><a class="dropdown-item" href="https://fivoflow.com/wclm/public/admin/country/users"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.farmer_list') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('supplier.countryList') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.supplier_list') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('agents.country.list') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.agent_list') }}</a></li>
                        <li><a class="dropdown-item" href="https://fivoflow.com/wclm/public/products-all-country"><i class="bi bi-table me-2"></i>{{ __('dashboard.product_management') }}</a></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('countryadmin.country.form.selector') }}">
                                <i class="bi bi-flag me-2"></i>Country Form Selector
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="https://fivoflow.com/wclm/public/admin/announcements/country"><i class="bi bi-megaphone me-2"></i>{{ __('dashboard.country_announcements') }}</a></li>


                        <li><a class="dropdown-item text-danger" href="{{ route('masteradmin.logout') }}"><i class="bi bi-box-arrow-right me-2"></i>{{ __('dashboard.logout') }}</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
