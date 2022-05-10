<nav class="{{ $cssNs }} sidebar">

            <div class="sidebar-header">

                <a href="{{ url('/') }}" target="_blank" class="sidebar-brand">
                  <figure>
                      <img src="{{ URL::asset('img/admin/logo-main.png') }}" alt="Logo {{ env('APP_NAME') }}"/>
                  </figure>
                </a>

                <div class="sidebar-toggler not-active">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>

            </div>

            <div class="sidebar-body">

                <ul class="nav">

                    <li class="nav-item nav-category">{{ __('Website') }}</li>
                    @can('modules.dashboard.index')

                    <li class="nav-item {{ active(['*/dashboard']) }}">
                        <a href="{{ url('/admin/modules/dashboard') }}" class="nav-link">
                            <i class="link-icon fa-regular fa-gauge"></i><span class="link-title">{{ __('Dashboard') }}</span>
                        </a>
                    </li>
                    @endcan

                    @can('modules.page.index')

                    <li class="nav-item {{ active(['*/pages', '*/pages/*']) }}">
                        <a href="{{ url('/admin/modules/pages') }}" class="nav-link">
                            <i class="link-icon fa-regular fa-browsers"></i><span class="link-title">{{ __('Pages') }}</span>
                        </a>
                    </li>
                    @endcan

                    @can(['modules.post.index', 'modules.category.index'])

                    <li class="nav-item {{ active(['*/posts', '*/posts/*', '*/categories', '*/categories/create','*/categories/*/edit']) }}">
                        <a class="nav-link" data-bs-toggle="collapse" href="#posts" role="button" aria-expanded="false" aria-controls="posts">
                            <i class="link-icon fa-regular fa-newspaper"></i>
                            <span class="link-title">{{ __('Articles') }}</span>
                             <i class="link-arrow fa-regular fa-chevron-down"></i>
                        </a>

                        <div class="collapse" id="posts">

                            <ul class="nav sub-menu">
                                @can('modules.post.index')

                                <li class="nav-item">
                                    <a href="{{ url('/admin/modules/posts') }}" class="nav-link {{ active(['*/posts', '*/posts/create', '*/posts/*/edit']) }}">{{ __('Post') }}</a>
                                </li>
                                @endcan
                                @can('modules.category.index')

                                <li class="nav-item">
                                    <a href="{{ url('/admin/modules/categories') }}" class="nav-link {{ active(['*/categories', '*/categories/create','*/categories/*/edit']) }}">{{ __('Categories') }}</a>
                                </li>
                                @endcan

                            </ul>

                        </div>

                    </li>
                    @endcan

                    @can('modules.social.index')

                    <li class="nav-item {{ active(['*/socials', '*/socials/*']) }}">
                        <a href="{{ url('/admin/modules/socials') }}" class="nav-link">
                            <i class="link-icon fa-regular fa-share-nodes"></i><span class="link-title">{{ __('Social Media') }}</span>
                        </a>
                    </li>
                    @endcan

                    <li class="nav-item nav-category">{{ __('Admin') }}</li>
                    @can('modules.administrator.index')

                    <li class="nav-item {{ active(['*/administrators', '*/administrators/*']) }}">
                        <a href="{{ url('/admin/modules/administrators') }}" class="nav-link">
                            <i class="link-icon fa-regular fa-user-group"></i><span class="link-title">{{ __('Users') }}</span>
                        </a>
                    </li>
                    @endcan

                    <li class="nav-item">

                        <form method="post" action="{{ route('logout') }}" id="logoutForm">

                            @csrf

                            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();" role="button">
                                <i class="link-icon fa-regular fa-right-from-bracket"></i><span class="link-title">{{ __('Logout') }}</span>
                            </a>

                        </form>

                    </li>

                </ul>

            </div>

        </nav>
