@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            <li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">@lang('global.app_dashboard')</span>
                </a>
            </li>
            
            @can('users_manage')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span class="title">@lang('global.user-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                    <li class="{{ $request->segment(2) == 'abilities' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.abilities.index') }}">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                                @lang('global.abilities.title')
                            </span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(2) == 'roles' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.roles.index') }}">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                                @lang('global.roles.title')
                            </span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.users.index') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                @lang('global.users.title')
                            </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-car"></i>
                    <span class="title">Експрес-доставка</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                    <li class="{{ Request::is('admin/dispositions/packed') ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.dispositions.packed') }}">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                                Онлайн екран
                            </span>
                        </a>
                    </li>
                    <li style="color: #ccc">Для складу</li>
                    <li class="{{ Request::is('admin/dispositions') ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.dispositions.index') }}">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                                Не опрацьовані пакування
                            </span>
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/dispositions/all_packs') ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.dispositions.all_packs') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                Всі пакування
                            </span>
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/dispositions/my_packs') ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.dispositions.my_packs') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                Мої пакування
                            </span>
                        </a>
                    </li>
                    <li style="color: #ccc">Для водіїв</li>
                    <li class="{{ Request::is('admin/dispositions/get_parcels') ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.dispositions.get_parcels') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                Отримати товар
                            </span>
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/dispositions/all_parcels') ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.dispositions.all_parcels') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                Товар у водіїв
                            </span>
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/dispositions/my_parcels') ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.dispositions.my_parcels') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                Мій товар
                            </span>
                        </a>
                    </li>
                    <li style="color: #ccc">Для менеджерів</li>
                    <li class="{{ Request::is('admin/dispositions/shipped_parcels') ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.dispositions.shipped_parcels') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                Відправлений товар
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            <li class="{{ $request->segment(1) == 'change_password' ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-key"></i>
                    <span class="title">@lang('global.app_change_password')</span>
                </a>
            </li>

            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">@lang('global.app_logout')</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
{!! Form::open(['route' => 'store.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('global.logout')</button>
{!! Form::close() !!}
