@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            <li class="{{ $request->segment(2) == 'home' ? 'active' : '' }}">
                <a href="@if (Auth::guard('store')->check()) {{ url('/store/home') }} @else {{ url('/admin/home') }}@endif">
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
            @endcan
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-car"></i>
                    <span class="title">Експрес-доставка</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @can('store_manage')
                    <li class="{{ $request->segment(3) == 'packed' ? 'active active-sub' : '' }}">
                        <a href="@if (Auth::guard('store')->check()) {{ route('store.dispositions.packed') }} @else {{ route('admin.dispositions.packed') }}@endif">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                                Онлайн екран
                            </span>
                        </a>
                    </li>
                    <li style="color: #ccc">Для складу</li>
                    <li class="">
                        <a href="@if (Auth::guard('store')->check()) {{ route('store.dispositions.index') }} @else {{ route('admin.dispositions.index') }}@endif">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                                Не опрацьовані пакування
                            </span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(3) == 'all_packs' ? 'active active-sub' : '' }}">
                        <a href="@if (Auth::guard('store')->check()) {{ route('store.dispositions.all_packs') }} @else {{ route('admin.dispositions.all_packs') }}@endif">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                Всі пакування
                            </span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(3) == 'my_packs' ? 'active active-sub' : '' }}">
                        <a href="@if (Auth::guard('store')->check()) {{ route('store.dispositions.my_packs') }} @else {{ route('admin.dispositions.my_packs') }}@endif">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                Мої пакування
                            </span>
                        </a>
                    </li>
                    @endcan
                    @can('driver_manage')
                    <li style="color: #ccc">Для водіїв</li>
                    <li class="{{ $request->segment(3) == 'get_parcels' ? 'active active-sub' : '' }}">
                        <a href="@if (Auth::guard('store')->check()) {{ route('store.dispositions.get_parcels') }} @else {{ route('admin.dispositions.get_parcels') }}@endif">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                Отримати товар
                            </span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(3) == 'all_parcels' ? 'active active-sub' : '' }}">
                        <a href="@if (Auth::guard('store')->check()) {{ route('store.dispositions.all_parcels') }} @else {{ route('admin.dispositions.all_parcels') }}@endif">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                Товар у водіїв
                            </span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(3) == 'my_parcels' ? 'active active-sub' : '' }}">
                        <a href="@if (Auth::guard('store')->check()) {{ route('store.dispositions.my_parcels') }} @else {{ route('admin.dispositions.my_parcels') }}@endif">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                Мій товар
                            </span>
                        </a>
                    </li>
                    @endcan
                    @can('manager_manage')
                    <li style="color: #ccc">Для менеджерів</li>
                    <li class="{{ $request->segment(3) == 'shipped_parcels' ? 'active active-sub' : '' }}">
                        <a href="@if (Auth::guard('store')->check()) {{ route('store.dispositions.shipped_parcels') }} @else {{ route('admin.dispositions.shipped_parcels') }}@endif">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                Відправлений товар
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
        </ul>
    </section>
</aside>
{!! Form::open(['route' => 'admin.logout', 'style' => 'display:none;', 'id' => 'admin_logout']) !!}
{!! Form::close() !!}

{!! Form::open(['route' => 'store.logout', 'style' => 'display:none;', 'id' => 'store_logout']) !!}
{!! Form::close() !!}