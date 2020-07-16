<button class="m-aside-left-close  m-aside-left-close--skin-light " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-light ">
    <!-- BEGIN: Brand -->
    <div class="m-brand  m-brand--skin-light ">
        <a href="{{ url('/') }}" class="m-brand__logo">
            <img alt="logo.png" src="{{ asset('assets/media/img/logo/logo.png') }}"/>
        </a>
    </div>
    <!-- END: Brand -->
    <!-- BEGIN: Aside Menu -->
    <div 
        id="m_ver_menu" 
        class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light " 
        data-menu-vertical="true"
        data-menu-scrollable="true" data-menu-dropdown-timeout="500"  
        >
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item m-menu__item--submenu m-menu__item--submenu-fullheight" aria-haspopup="true"  data-menu-submenu-toggle="click" data-menu-dropdown-toggle-class="m-aside-menu-overlay--on">
                <a  href="#" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-menu"></i>
                    <span class="m-menu__link-text">
                        Applications
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <div class="m-menu__wrapper">
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item m-menu__item--parent m-menu__item--submenu-fullheight" aria-haspopup="true" >
                                <span class="m-menu__link">
                                    <span class="m-menu__link-text">
                                        Applications
                                    </span>
                                </span>
                            </li>
                            @foreach ($menus as $menu)
                            <li class="m-menu__section">
                                <h4 class="m-menu__section-text">
                                    {{ $menu['name'] }}
                                </h4>
                                <i class="m-menu__section-icon flaticon-more-v3"></i>
                            </li>
                                @foreach ($menu['modules'] as $module)
                                <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="click" data-menu-submenu-mode="accordion">
                                    <a  href="#" class="m-menu__link m-menu__toggle">
                                        <span class="m-menu__link-text">
                                            <i class="{{ $module['icon'] }} module-icons"></i> {{ $module['name'] }}
                                        </span>
                                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                                    </a>
                                    @if ( !empty($menu['sub_modules'][$module['id']]) )
                                    <div class="m-menu__submenu ">
                                        <span class="m-menu__arrow"></span>
                                        <ul class="m-menu__subnav">
                                            @foreach ($menu['sub_modules'][$module['id']] as $submodule)
                                                @if ($submodule['name'] == 'Infoblast' || $submodule['name'] == 'Emailblast') 
                                                    <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="click" data-menu-submenu-mode="accordion" data-redirect="true">
                                                        <a href="#" class="m-menu__link m-menu__toggle">
                                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="m-menu__link-text">
                                                                {{ $submodule['name'] }}
                                                            </span>
                                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                                        </a>
                                                        <div class="m-menu__submenu " style="">
                                                            <span class="m-menu__arrow"></span>
                                                            <ul class="m-menu__subnav">
                                                                <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                                                    <a href="{{ url($menu['slug'].'/'.$module['slug'].'/'.$submodule['slug'].'/new') }}" class="m-menu__link ">
                                                                        <i class="m-menu__link-icon flaticon-computer"></i>
                                                                        <span class="m-menu__link-title">
                                                                            <span class="m-menu__link-wrap">
                                                                                <span class="m-menu__link-text">
                                                                                    New
                                                                                </span>
                                                                                <span class="m-menu__link-badge">
                                                                                </span>
                                                                            </span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                                                    <a href="inner.html" class="m-menu__link ">
                                                                        <i class="m-menu__link-icon flaticon-signs-2"></i>
                                                                        <span class="m-menu__link-title">
                                                                            <span class="m-menu__link-wrap">
                                                                                <span class="m-menu__link-text">
                                                                                    Inbox
                                                                                </span>
                                                                                <span class="m-menu__link-badge">
                                                                                    <span class="m-badge m-badge--danger">
                                                                                        6
                                                                                    </span>
                                                                                </span>
                                                                            </span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                                                    <a href="inner.html" class="m-menu__link ">
                                                                        <i class="m-menu__link-icon flaticon-clipboard"></i>
                                                                        <span class="m-menu__link-title">
                                                                            <span class="m-menu__link-wrap">
                                                                                <span class="m-menu__link-text">
                                                                                    Outbox
                                                                                </span>
                                                                                <span class="m-menu__link-badge">
                                                                                    <span class="m-badge m-badge--success">
                                                                                        2
                                                                                    </span>
                                                                                </span>
                                                                            </span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                                                    <a href="inner.html" class="m-menu__link ">
                                                                        <i class="m-menu__link-icon flaticon-multimedia-2"></i>
                                                                        <span class="m-menu__link-title">
                                                                            <span class="m-menu__link-wrap">
                                                                                <span class="m-menu__link-text">
                                                                                    Tracking
                                                                                </span>
                                                                                <span class="m-menu__link-badge">
                                                                                    <span class="m-badge m-badge--info m-badge--wide">
                                                                                        245
                                                                                    </span>
                                                                                </span>
                                                                            </span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-menu__item " aria-haspopup="true" data-redirect="true">
                                                                    <a href="inner.html" class="m-menu__link ">
                                                                        <i class="m-menu__link-icon flaticon-multimedia-2"></i>
                                                                        <span class="m-menu__link-title">
                                                                            <span class="m-menu__link-wrap">
                                                                                <span class="m-menu__link-text">
                                                                                    Templates
                                                                                </span>
                                                                                <span class="m-menu__link-badge">
                                                                                    <span class="m-badge m-badge--info m-badge--wide">
                                                                                        245
                                                                                    </span>
                                                                                </span>
                                                                            </span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                                                        <a  href="{{ url($menu['slug'].'/'.$module['slug'].'/'.$submodule['slug']) }}" class="m-menu__link ">
                                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                                <span></span>
                                                            </i>
                                                            <span class="m-menu__link-text">
                                                                {{ $submodule['name'] }}
                                                            </span>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                </div>
            </li>
            <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="click" data-redirect="true">
                <a  href="#" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-add"></i>
                    <span class="m-menu__link-text">
                        Add
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item m-menu__item--parent" aria-haspopup="true"  data-redirect="true">
                            <span class="m-menu__link">
                                <span class="m-menu__link-text">
                                    Add
                                </span>
                            </span>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-icon fa fa-file-text-o"></i>
                                <span class="m-menu__link-text">
                                    Grading Sheet
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-icon fa fa-calendar-check-o"></i>
                                <span class="m-menu__link-text">
                                    Attendance Sheet
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-icon la la-comments"></i>
                                <span class="m-menu__link-text">
                                    Message
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-icon la la-user"></i>
                                <span class="m-menu__link-text">
                                    User
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item m-menu__item--submenu m-menu__item--bottom" aria-haspopup="true"  data-menu-submenu-toggle="click" data-redirect="true">
                <a  href="#" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-stopwatch"></i>
                    <span class="m-menu__link-text">
                        Customers
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item m-menu__item--parent m-menu__item--bottom" aria-haspopup="true"  data-redirect="true">
                            <span class="m-menu__link">
                                <span class="m-menu__link-text">
                                    Customers
                                </span>
                            </span>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Reports
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover" data-redirect="true">
                            <a  href="#" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Cases
                                </span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                                        <a  href="inner.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-computer"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                        Pending
                                                    </span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--warning">
                                                            10
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                                        <a  href="inner.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-signs-2"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                        Urgent
                                                    </span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--danger">
                                                            6
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                                        <a  href="inner.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-clipboard"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                        Done
                                                    </span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--success">
                                                            2
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                                        <a  href="inner.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-multimedia-2"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                        Archive
                                                    </span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--info m-badge--wide">
                                                            245
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Clients
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Audit
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item m-menu__item--submenu m-menu__item--bottom-2" aria-haspopup="true"  data-menu-submenu-toggle="click">
                <a  href="#" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-settings"></i>
                    <span class="m-menu__link-text">
                        Settings
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu m-menu__submenu--up">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item m-menu__item--parent m-menu__item--bottom-2" aria-haspopup="true" >
                            <span class="m-menu__link">
                                <span class="m-menu__link-text">
                                    Settings
                                </span>
                            </span>
                        </li>
                        <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover" data-redirect="true">
                            <a  href="inner.html" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Profile
                                </span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                                        <a  href="inner.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-computer"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                        Pending
                                                    </span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--warning">
                                                            10
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                                        <a  href="inner.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-signs-2"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                        Urgent
                                                    </span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--danger">
                                                            6
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                                        <a  href="inner.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-clipboard"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                        Done
                                                    </span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--success">
                                                            2
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                                        <a  href="inner.html" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-multimedia-2"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                        Archive
                                                    </span>
                                                    <span class="m-menu__link-badge">
                                                        <span class="m-badge m-badge--info m-badge--wide">
                                                            245
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Accounts
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Help
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--line">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Notifications
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item m-menu__item--submenu m-menu__item--bottom-1" aria-haspopup="true"  data-menu-submenu-toggle="click">
                <a  href="#" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-info"></i>
                    <span class="m-menu__link-text">
                        Help
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu m-menu__submenu--up">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item m-menu__item--parent m-menu__item--bottom-1" aria-haspopup="true" >
                            <span class="m-menu__link">
                                <span class="m-menu__link-text">
                                    Help
                                </span>
                            </span>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Support
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Blog
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Documentation
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Pricing
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item" aria-haspopup="true"  data-redirect="true">
                            <a  href="inner.html" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Terms
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
<div class="m-aside-menu-overlay"></div>