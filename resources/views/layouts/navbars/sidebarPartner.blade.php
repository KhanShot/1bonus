
<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('partner.index')}}">
        <div class="sidebar-brand-icon">
            <img src="{{asset('images/defaults/IMG_3922.PNG')}}" width="50">
        </div>
        <div class="sidebar-brand-text mx-3 text-gray-700">1Bonus</div>
    </a>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if (request()->route()->getName() == 'partner.index') active @endif">
        <a class="nav-link text-gray-700" href="{{ route('partner.index')}}">
            <i class="fas fa-fw fa-tachometer-alt text-gray-700"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if (request()->route()->getName() == 'partner.institution') active @endif">
        <a class="nav-link text-gray-700" href="{{ route('partner.institution')}}">
            <i class="fas fa-fw fa-tachometer-alt text-gray-700"></i>
            <span>Информация</span>
        </a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li  class="nav-item @if (request()->route()->getName() == 'partner.qr') active @endif">
        <a class="nav-link text-gray-700" href="{{ route('partner.qr')  }}" >
            <i class="fas fa-fw fa-business-time text-gray-700"></i>
            <span>Посещения</span>
        </a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item @if ( request()->route()->getName() == 'partner.cards' ) active @endif">
        <a class="nav-link text-gray-700" href="{{ route('partner.cards')  }}">
            <i class="fas fa-fw fa-id-card text-gray-700"></i>
            <span>Карточка посещения</span>
        </a>
    </li>
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item @if ( request()->route()->getName() == 'partner.services' ) active @endif">
        <a class="nav-link text-gray-700" href="{{ route('partner.services')  }}">
            <i class="fas fa-fw fa-users text-gray-700"></i>
            <span>Услуги</span>
        </a>
    </li>


    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item @if ( request()->route()->getName() == 'partner.schedule' ) active @endif">
        <a class="nav-link text-gray-700" href="{{ route('partner.schedule')  }}">
            <i class="fas fa-fw fa-building text-gray-700"></i>
            <span>График работы</span>
        </a>
    </li>

    <li class="mb-5">

    </li>
    <div class="card bg-danger p-2 text-white">
        <div class="card-title">
            <small style="line-height: 1.2; font-size: 13px;  ">
                Для того чтобы ваше заведение отобразилось в 1Bonus добавьте следующую информацию:
            </small>
        </div>
        <hr>
        <div class="">
            <small>
                <li><a class="text-decoration-none text-white" href="#">Карточка посещения</a> </li>
                <li><a class="text-decoration-none text-white" href="#">Услуги</a></li>
                <li>
                    <s><a class="text-decoration-none text-white" href="#">График работы</a></s>
                </li>
            </small>

        </div>
    </div>



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->
