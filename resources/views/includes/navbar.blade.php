
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('admin/dashboard') }}" style="font-size: 1.3rem;">
                ADMIN WAIMA
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav align-items-center">

                    <!-- Language Switch -->
                    <li class="nav-item me-3">
                        <form method="GET" action="{{ route('masteradmin.dashboard') }}">
                            <select name="lang" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="en" {{ request('lang') == 'en' ? 'selected' : '' }}>English</option>
                                <option value="fr" {{ request('lang') == 'fr' ? 'selected' : '' }}>Français</option>
                            </select>
                        </form>
                    </li>

                    <!-- Admin Label -->
                    <li class="nav-item me-3">
                        <span class="fw-medium">{{ __('dashboard.admin') }}</span>
                    </li>

                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <button class="btn border-0 bg-transparent dropdown-toggle p-0" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-4"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end mt-2 shadow" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="{{ url('admin/dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>{{ __('dashboard.dashboard') }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('admin/product-overview') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.overview') }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('admin/users') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.farmer_list') }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('admin/suppliers') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.supplier_list') }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('admin/agents') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.agent_list') }}</a></li>
   
                                <a href="{{ route('masteradmin.list') }}" class="dropdown-item"> <i class="bi bi-list-ul"></i> Administrator List </a>

                                <li><a class="dropdown-item" href="{{ url('admin/products/form-selector') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.add_product') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.products.all') }}"><i class="bi bi-table me-2"></i>{{ __('dashboard.product_management') }}</a></li>
                            <!-- <li><a class="dropdown-item" href="{{ url('admin/create-user') }}"><i class="bi bi-plus-circle me-2"></i>{{ __('dashboard.create_user') }}</a></li> -->
                            <li><a class="dropdown-item" href="{{ url('admin/documents') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.documents_list') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('dynamic.index') }}"><i class="bi bi-ui-checks-grid me-2"></i>{{ __('dashboard.dynamic_form') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('country.list') }}"><i class="bi bi-flag me-2"></i>{{ __('dashboard.country_list') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('region.list') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.region_list') }}</a></li>
                                     <!-- <li>
                                          <a class="dropdown-item" href="{{ route('masteradmin.list') }}">
                                              <i class="bi bi-card-list me-2"></i>{{ __('dashboard.country_user') }}
                                          </a>
                                      </li> -->
                                                                    <!-- <li>
                                  <a class="dropdown-item" href="{{ url('/admin/products-map?category=') }}">
                                      <i class="bi bi-geo-alt me-2"></i>{{ __('dashboard.products_map') }}
                                  </a>
                              </li> -->
                              <!-- <li>
                                  <a class="dropdown-item" href="{{ url('/price-chart') }}">
                                      <i class="bi bi-bar-chart-line me-2"></i>{{ __('dashboard.price_chart') }}
                                  </a>
                              </li> -->
                                <li><a href="{{ route('languages.index') }}" class="dropdown-item">
                                    <i class="bi bi-list-ul"></i> View Languages List
                                    </a>
                                </li>



                            <li><a class="dropdown-item text-danger" href="{{ route('masteradmin.logout') }}"><i class="bi bi-box-arrow-right me-2"></i>{{ __('dashboard.logout') }}</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>