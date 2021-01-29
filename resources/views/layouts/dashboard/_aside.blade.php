<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ auth()->user()->image_path }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{-- auth()->user()->first_name }} {{ auth()->user()->last_name --}}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

{{--        <!-- search form (Optional) -->--}}
{{--        <form action="#" method="get" class="sidebar-form">--}}
{{--            <div class="input-group">--}}
{{--                <input type="text" name="q" class="form-control" placeholder="Search...">--}}
{{--                <span class="input-group-btn">--}}
{{--                      <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>--}}
{{--                      </button>--}}
{{--                    </span>--}}
{{--            </div>--}}
{{--        </form>--}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">

            <!-- Optionally, you can add icons to the links -->

            <li class="">
                <a href="{{ route('dashboard.index') }}"> <i class="fa fa-th"></i> <span>@lang('site.dashboard')</span></a>
            </li>
            
 
            @if (auth()->user()->can('read_categories'))
                <li>
                    <a href="{{ route('dashboard.categories.index') }}"> <i class="fa fa-th"></i> <span>@lang('site.categories')</span></a>
                </li>
            @endif

            @if (auth()->user()->hasPermission('read_products'))
                <li>
                    <a href="{{ route('dashboard.products.index') }}"> <i class="fa fa-th"></i> <span>@lang('site.products')</span></a>
                </li>
            @endif

            @if (auth()->user()->can('read_clients'))
                <li>
                    <a href="{{ route('dashboard.clients.index') }}"> <i class="fa fa-th"></i> <span>@lang('site.clients')</span></a>
                </li>
            @endif

            @if (auth()->user()->can('read_orders'))
                <li>
                    <a href="{{ route('dashboard.orders.index') }}"> <i class="fa fa-th"></i> <span>@lang('site.orders')</span></a>
                </li>
            @endif
            @if (auth()->user()->can('read_users'))
                <li>
                    <a href="{{ route('dashboard.users.index') }}"> <i class="fa fa-th"></i> <span>@lang('site.users')</span></a>
                </li>
            @endif

            <!--<li class="treeview active menu-open">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>UI Elements</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="general.html"><i class="fa fa-circle-o"></i> General</a></li>
                    <li><a href="icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
                    <li><a href="buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
                    <li><a href="sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
                    <li><a href="timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
                    <li><a href="modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
                </ul>
            </li>-->
             {!! pages() !!}
        </ul>

       
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
