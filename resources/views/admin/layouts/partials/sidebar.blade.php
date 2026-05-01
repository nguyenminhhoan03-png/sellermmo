<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="header-logo">
            <img src="{{ setting_asset('logo_light') }}" alt="logo" class="desktop-logo">
            <img src="{{ setting_asset('logo_light') }}" alt="logo" class="toggle-logo">
            <img src="{{ setting_asset('logo_dark', 'assets/media/logos/custom-3.svg') }}" alt="logo" class="desktop-dark">
            <img src="{{ setting_asset('logo_dark', 'assets/media/logos/custom-3.svg') }}" alt="logo" class="toggle-dark">
            <img src="{{ setting_asset('logo_light') }}" alt="logo" class="desktop-white">
            <img src="{{ setting_asset('logo_light') }}" alt="logo" class="toggle-white">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('admin.dashboard') }}"
                        class="side-menu__item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bx bx-home side-menu__icon"></i>
                        <span class="side-menu__label">{{ 'Bảng Điều Khiển' }}</span>
                    </a>
                </li>
                <li class="slide has-sub {{ request()->routeIs('admin.dashboard.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);"
                        class="side-menu__item {{ request()->routeIs('admin.dashboard.*') ? 'active open' : '' }}">
                        <i class="bx bx-history side-menu__icon"></i>
                        <span class="side-menu__label">Lịch sử</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1" data-popper-placement="bottom"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 139px); box-sizing: border-box; display: none;">
                        <li class="slide">
                            <a href="{{ route('admin.dashboard.logs') }}"
                                class="side-menu__item {{ request()->routeIs('admin.dashboard.logs') ? 'active' : '' }}">Nhật
                                ký hoạt
                                động</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.dashboard.transactions') }}" class="side-menu__item {{ request()->routeIs('admin.dashboard.transactions') ? 'active' : '' }}">Biến động
                                số dư</a>
                        </li>
                    </ul>
                </li>
                <!-- End::slide -->
                <li class="slide__category"><span class="category-name">Mã Nguồn</span></li>
                <li class="slide">
                    <a href="{{ route('admin.manguon.index') }}"
                        class="side-menu__item {{ request()->routeIs('admin.manguon.index') ? 'active' : '' }} {{ request()->routeIs('admin.manguon.edit') ? 'active' : '' }}">
                        <i class="bx bx-code-alt side-menu__icon"></i>
                        <span class="side-menu__label">{{ 'Danh sách mã nguồn' }}</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.manguon.history') }}"
                        class="side-menu__item {{ request()->routeIs('admin.manguon.history') ? 'active' : '' }}">
                        <i class="bx bx-history side-menu__icon"></i>
                        <span class="side-menu__label">{{ 'Lịch sử bán mã nguồn' }}</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.manguon.pay') }}"
                        class="side-menu__item {{ request()->routeIs('admin.manguon.pay') ? 'active' : '' }}">
                        <i class="bx bxs-wallet-alt side-menu__icon"></i>
                        <span class="side-menu__label">{{ 'Đơn rút tiền CTV' }}</span>
                    </a>
                </li>
                <li class="slide__category"><span class="category-name">Tên Miền</span></li>
                <li class="slide">
                    <a href="{{ route('admin.domain.index') }}"
                        class="side-menu__item {{ request()->routeIs('admin.domain.index') ? 'active' : '' }} {{ request()->routeIs('admin.domain.edit') ? 'active' : '' }}">
                        <i class="bx bx-aperture side-menu__icon"></i>
                        <span class="side-menu__label">{{ 'Danh sách tên miền' }}</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.domain.history') }}"
                        class="side-menu__item {{ request()->routeIs('admin.domain.history') ? 'active' : '' }}">
                        <i class="bx bx-history side-menu__icon"></i>
                        <span class="side-menu__label">{{ 'Lịch sử bán tên miền' }}</span>
                    </a>
                </li>
                <li class="slide__category"><span class="category-name">CronJobs</span></li>
                <li class="slide">
                    <a href="{{ route('admin.cron.index') }}"
                        class="side-menu__item {{ request()->routeIs('admin.cron.index') ? 'active' : '' }}">
                        <i class="bx bx-timer side-menu__icon"></i>
                        <span class="side-menu__label">{{ 'Quản lý máy chủ cron' }}</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.cron.list') }}"
                        class="side-menu__item {{ request()->routeIs('admin.cron.list') ? 'active' : '' }}">
                        <i class="bx bx-history side-menu__icon"></i>
                        <span class="side-menu__label">{{ 'Quản lý link cron' }}</span>
                    </a>
                </li>
                 <li class="slide__category"><span class="category-name">Logo</span></li>
                <li class="slide">
                    <a href="{{ route('admin.logo.index') }}"
                        class="side-menu__item {{ request()->routeIs('admin.logo.index') ? 'active' : '' }}">
                        <i class="bx bx-image-alt side-menu__icon"></i>
                        <span class="side-menu__label">{{ 'Danh sách logo' }}</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.logo.history') }}"
                        class="side-menu__item {{ request()->routeIs('admin.logo.history') ? 'active' : '' }}">
                        <i class="bx bx-history side-menu__icon"></i>
                        <span class="side-menu__label">{{ 'Lịch sử tạo logo' }}</span>
                    </a>
                </li>
                <li class="slide__category"><span class="category-name">Tài Khoản AI</span></li>
                <li class="slide">
                    <a href="{{ route('admin.ai.index') }}"
                        class="side-menu__item {{ request()->routeIs('admin.ai.index') ? 'active' : '' }}">
                        <i class="bx bx-bot side-menu__icon"></i>
                        <span class="side-menu__label">Danh sách tài khoản AI</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.ai.orders') }}"
                        class="side-menu__item {{ request()->routeIs('admin.ai.orders') ? 'active' : '' }}">
                        <i class="bx bx-receipt side-menu__icon"></i>
                        <span class="side-menu__label">Đơn hàng AI</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.ai.categories') }}"
                        class="side-menu__item {{ request()->routeIs('admin.ai.categories') ? 'active' : '' }}">
                        <i class="bx bx-category side-menu__icon"></i>
                        <span class="side-menu__label">Danh mục AI</span>
                    </a>
                </li>
                <li class="slide__category"><span class="category-name">Tạo web</span></li>
                <li class="slide">
                    <a href="{{ route('admin.web.index') }}"
                        class="side-menu__item {{ request()->routeIs('admin.web.index') ? 'active' : '' }}">
                        <i class="bx bx-mail-send side-menu__icon"></i>
                        <span class="side-menu__label">{{ 'Danh sách website' }}</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.web.history') }}"
                        class="side-menu__item {{ request()->routeIs('admin.web.history') ? 'active' : '' }}">
                        <i class="bx bx-history side-menu__icon"></i>
                        <span class="side-menu__label">{{ 'Lịch sử tạo website' }}</span>
                    </a>
                </li>
                <li class="slide__category"><span class="category-name">Hosing</span></li>
                <li class="slide has-sub {{ request()->routeIs('admin.hosting.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item {{ request()->routeIs('admin.hosting.*') ? 'active open' : '' }}">
                        <i class="fa-brands fa-cpanel side-menu__icon"></i>
                        <span class="side-menu__label">Hosting</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1" data-popper-placement="bottom"
                    style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 139px); box-sizing: border-box; display: none;">
                        <li class="slide">
                            <a href="{{ route('admin.hosting.category') }}" class="side-menu__item {{ request()->routeIs('admin.hosting.category') ? 'active' : '' }}">Danh mục hosting</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.hosting.whm') }}" class="side-menu__item {{ request()->routeIs('admin.hosting.whm') ? 'active' : '' }}">Máy Chủ hosting</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.hosting.packages') }}" class="side-menu__item {{ request()->routeIs('admin.hosting.packages') ? 'active' : '' }}">Danh sách gói hosting</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.hosting.list') }}" class="side-menu__item {{ request()->routeIs('admin.hosting.list') ? 'active' : '' }}">Quản lý hosting</a>
                        </li>
                    </ul>
                </li>
                <li class="slide__category"><span class="category-name">Voucher</span></li>
                <li class="slide">
                    <a href="{{ route('admin.voucher.index') }}" class="side-menu__item {{ request()->routeIs('admin.voucher.index') ? 'active' : '' }}">
                        <i class="bx bxs-discount side-menu__icon"></i>
                        <span class="side-menu__label">Danh sách Voucher</span>
                    </a>
                </li>
                <li class="slide__category"><span class="category-name">Quản lý</span></li>
                @php
                    $sidebarUnreadChat = \App\Models\ChatConversation::sum('unread_admin');
                @endphp
                <li class="slide">
                    <a href="{{ route('admin.chat.index') }}"
                        class="side-menu__item {{ request()->routeIs('admin.chat.index') ? 'active' : '' }}" style="position:relative;">
                        <i class="bx bx-message-dots side-menu__icon"></i>
                        <span class="side-menu__label">Quản lý Chat</span>
                        @if($sidebarUnreadChat > 0)
                            <span style="position:absolute;top:7px;right:10px;min-width:18px;height:18px;padding:0 5px;border-radius:999px;background:#ea5455;color:#fff;font-size:11px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;line-height:1;box-shadow:0 0 0 2px #fff;">
                                {{ $sidebarUnreadChat > 99 ? '99+' : $sidebarUnreadChat }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.users.index') }}"
                        class="side-menu__item {{ request()->routeIs('admin.users.index') ? 'active' : '' }} {{ request()->routeIs('admin.users.edit') ? 'active' : '' }}">
                        <i class="bx bxs-user side-menu__icon"></i>
                        <span class="side-menu__label">Quản lý thành viên</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.transfer.index') }}"
                        class="side-menu__item {{ request()->routeIs('admin.transfer.index') ? 'active' : '' }}">
                        <i class="bx bx-data side-menu__icon"></i>
                        <span class="side-menu__label">Quản Lý Hoá Đơn</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.recharge.bank') }}"
                        class="side-menu__item {{ request()->routeIs('admin.recharge.bank') ? 'active' : '' }} {{ request()->routeIs('admin.recharge.bank.config') ? 'active' : '' }}">
                        <i class="bx bx-credit-card side-menu__icon"></i>
                        <span class="side-menu__label">Quản Lý Ngân Hàng</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.recharge.card') }}"
                        class="side-menu__item {{ request()->routeIs('admin.recharge.card') ? 'active' : '' }}">
                        <i class="bx bx-credit-card side-menu__icon"></i>
                        <span class="side-menu__label">Quản Lý Nạp Thẻ</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{ route('admin.recharge.apibank') }}"
                        class="side-menu__item {{ request()->routeIs('admin.recharge.apibank') ? 'active' : '' }}">
                        <i class='bx bxs-wrench side-menu__icon'></i>
                        <span class="side-menu__label">Cấu Hình API Bank</span>
                    </a>
                </li>
                <li class="slide has-sub {{ request()->routeIs('admin.blog.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item {{ request()->routeIs('admin.blog.*') ? 'active open' : '' }}">
                        <i class="bx bxl-blogger side-menu__icon"></i>
                        <span class="side-menu__label">Bài viết</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1" data-popper-placement="bottom"
                    style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 139px); box-sizing: border-box; display: none;">
                        <li class="slide">
                            <a href="{{ route('admin.blog.add') }}" class="side-menu__item {{ request()->routeIs('admin.blog.add') ? 'active' : '' }}">Viết bài mới</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.blog.index') }}" class="side-menu__item {{ request()->routeIs('admin.blog.index') ? 'active' : '' }}">Tất cả bài
                                viết</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.blog.crawl.page') }}" class="side-menu__item {{ request()->routeIs('admin.blog.crawl.page') ? 'active' : '' }}">Crawl bài viết</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.blog.category') }}" class="side-menu__item {{ request()->routeIs('admin.blog.category') ? 'active' : '' }}">Chuyên
                                mục</a>
                        </li>
                    </ul>
                </li>
                <li class="slide__category"><span class="category-name">Website Setting</span></li>
                <li class="slide">
                    <a href="{{ route('admin.setting.notices') }}" class="side-menu__item {{ request()->routeIs('admin.setting.notices') ? 'active' : '' }}">
                      <i class="bx bx-bell side-menu__icon"></i>
                      <span class="side-menu__label">Cài Đặt Thông Báo</span>
                    </a>
                  </li>
                  <li class="slide">
                    <a href="{{ route('admin.settings.general') }}" class="side-menu__item {{ request()->routeIs('admin.settings.general') ? 'active' : '' }}">
                      <i class="bx bx-cog side-menu__icon"></i>
                      <span class="side-menu__label">Cài Đặt Hệ Thống</span>
                    </a>
                  </li> 
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
