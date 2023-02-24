<!-- Sidebar -->
<ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" >
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.index')}}">
        <div class="sidebar-brand-icon">
            <img src="{{asset('images/defaults/IMG_3922.PNG')}}" width="50">
        </div>
        <div class="sidebar-brand-text mx-3 text-gray-700">1Bonus</div>
    </a>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if (request()->route()->getName() == 'admin.index') active @endif">
        <a class="nav-link text-gray-700" href="{{ route('admin.index')}}">
            <i class="fas fa-fw fa-tachometer-alt text-gray-700"></i>
            <span>Дашборд</span>
        </a>
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if (request()->route()->getName() == 'admin.main') active @endif">
        <a class="nav-link text-gray-700" href="{{ route('admin.main')}}">
            <i class="fas fa-fw fa-tachometer-alt text-gray-700"></i>
            <span>Главная</span>
        </a>
    </li>
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item @if ( request()->route()->getName() == 'admin.users' ) active @endif">
        <a class="nav-link text-gray-700" href="{{ route('admin.users')  }}">
            <i class="fas fa-fw fa-users text-gray-700"></i>
            <span>Пользователи</span>
        </a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item @if ( request()->route()->getName() == 'admin.institutions' ) active @endif">
        <a class="nav-link text-gray-700" href="{{ route('admin.institutions')  }}">
            <i class="fas fa-fw fa-building text-gray-700"></i>
            <span>Заведения</span>
        </a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item @if ( request()->route()->getName() == 'admin.categories' ) active @endif">
        <a class="nav-link text-gray-700" href="{{ route('admin.categories')  }}">
            <i class="fas fa-fw fa-building text-gray-700"></i>
            <span>Категория</span>
        </a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item @if ( request()->route()->getName() == 'admin.tags' ) active @endif">
        <a class="nav-link text-gray-700" href="{{ route('admin.tags')  }}">
            <i class="fas fa-fw fa-tags text-gray-700"></i>
            <span>Метки</span>
        </a>
    </li>


    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item @if ( request()->route()->getName() == 'admin.sms' ) active @endif">
        <a class="nav-link text-gray-700" href="{{ route('admin.sms')  }}">
            <i class="fas fa-fw fa-sms text-gray-700"></i>
            <span>SMS</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->
