<!DOCTYPE html>
<html lang="vi" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Kênh Người Bán</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS Bootstrap & SweetAlert -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #ff9800, #f57c00);
            --sidebar-bg: #0f172a;
            --sidebar-hover: rgba(255, 255, 255, 0.05);
            --body-bg: #f8fafc;
            --sidebar-width: 260px;
            --header-height: 70px;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            --border-color: #e2e8f0;
            --text-dark: #1e293b;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Glassmorphism Header */
        .seller-header {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: var(--header-height);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            z-index: 1020;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            transition: all 0.3s ease;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo-text {
            font-weight: 800;
            font-size: 1.4rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .home-circle-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: #ffffff;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        .home-circle-btn:hover {
            background: var(--primary-gradient);
            color: #ffffff;
            border-color: transparent;
            transform: translateY(-2px);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-meta-name {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .user-meta-role {
            font-size: 0.75rem;
            color: #64748b;
            display: block;
        }

        /* Rebuilt Dark Slate Sidebar */
        .seller-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            z-index: 1030;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-brand-area {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-brand-name {
            font-weight: 800;
            font-size: 1.15rem;
            color: #ffffff;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand-name i {
            color: #f59e0b;
        }

        .sidebar-title {
            font-size: 0.7rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 24px 24px 10px 24px;
            margin: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0 12px;
            margin: 0;
        }

        .menu-item-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 8px;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }

        .menu-item-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-item-left i {
            font-size: 1.05rem;
            width: 20px;
            text-align: center;
            color: #64748b;
            transition: color 0.2s ease;
        }

        .menu-item-link:hover {
            background-color: var(--sidebar-hover);
            color: #ffffff;
        }

        .menu-item-link:hover i {
            color: #ffffff;
        }

        .menu-item-link.active {
            background: var(--primary-gradient) !important;
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(245, 124, 0, 0.3);
        }

        .menu-item-link.active i {
            color: #ffffff !important;
        }

        /* Main Content area */
        .seller-main {
            padding-top: 94px;
            padding-bottom: 40px;
            margin-left: var(--sidebar-width);
            padding-left: 30px;
            padding-right: 30px;
            transition: all 0.3s ease;
        }

        .toggle-sidebar-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.4rem;
            color: var(--text-dark);
            cursor: pointer;
        }

        /* Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 1025;
            display: none;
        }

        .premium-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            box-shadow: var(--card-shadow);
            margin-bottom: 24px;
        }

        @media (max-width: 991.98px) {
            .seller-sidebar {
                transform: translateX(-100%);
            }

            .seller-sidebar.show {
                transform: translateX(0);
                box-shadow: 10px 0 30px rgba(15, 23, 42, 0.15);
            }

            .seller-header {
                left: 0;
                padding: 0 20px;
            }

            .seller-main {
                margin-left: 0;
                padding-left: 15px;
                padding-right: 15px;
            }

            .toggle-sidebar-btn {
                display: block;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Header -->
    <header class="seller-header">
        <div class="header-brand">
            <button class="toggle-sidebar-btn" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
            <span class="brand-logo-text">{{ env('APP_NAME', 'Seller Portal') }}</span>
        </div>

        <div class="header-right">
            <a href="/" class="home-circle-btn" title="Về trang chủ">
                <i class="fas fa-home"></i>
            </a>

            <div class="d-none d-sm-flex align-items-center gap-2">
                <div class="text-end">
                    <span class="user-meta-name">{{ auth()->user()->username }}</span>
                    <span class="user-meta-role">Đối tác CTV</span>
                </div>
            </div>

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown">
                    <img src="/assets/media/avatars/user-placeholder.svg" alt="Avatar" width="38" height="38" class="rounded-circle border border-2 border-warning" onerror="this.src='https://api.dicebear.com/7.x/bottts/svg?seed={{ auth()->user()->username }}'">
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li><a class="dropdown-item" href="{{ route('account.profile.index') }}"><i class="fas fa-user-circle me-2"></i>Tài khoản</a></li>
                    <li><a class="dropdown-item" href="{{ route('author-form') }}"><i class="fas fa-id-card me-2"></i>Xác thực CCCD</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="seller-sidebar" id="sellerSidebar">
        <div class="sidebar-brand-area">
            <div class="sidebar-brand-name">
                <i class="fas fa-crown"></i>
                <span>SELLER CONSOLE</span>
            </div>
        </div>

        <h5 class="sidebar-title">Menu quản lý</h5>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('seller.dashboard') }}" class="menu-item-link {{ Request::routeIs('seller.dashboard') ? 'active' : '' }}">
                    <div class="menu-item-left">
                        <i class="fas fa-chart-pie"></i>
                        <span>Tổng quan</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('seller.products') }}" class="menu-item-link {{ Request::routeIs('seller.products') || Request::routeIs('seller.products.edit') || Request::routeIs('seller.products.upload') ? 'active' : '' }}">
                    <div class="menu-item-left">
                        <i class="fas fa-cubes"></i>
                        <span>Sản phẩm</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('seller.revenue') }}" class="menu-item-link {{ Request::routeIs('seller.revenue') ? 'active' : '' }}">
                    <div class="menu-item-left">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Đơn hàng đã bán</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('seller.withdraw') }}" class="menu-item-link {{ Request::routeIs('seller.withdraw') ? 'active' : '' }}">
                    <div class="menu-item-left">
                        <i class="fas fa-wallet"></i>
                        <span>Rút tiền doanh thu</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('seller.chat.inbox') }}" class="menu-item-link {{ Request::routeIs('seller.chat.inbox') || Request::routeIs('seller.chat.conversation') ? 'active' : '' }}">
                    <div class="menu-item-left">
                        <i class="fas fa-comments"></i>
                        <span>Inbox Khách Hàng</span>
                    </div>
                </a>
            </li>

            <li>
                <a href="{{ route('seller.settings') }}" class="menu-item-link {{ Request::routeIs('seller.settings') ? 'active' : '' }}">
                    <div class="menu-item-left">
                        <i class="fas fa-cog"></i>
                        <span>Cấu hình gian hàng</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('author-form') }}" class="menu-item-link {{ Request::routeIs('author-form') ? 'active' : '' }}">
                    <div class="menu-item-left">
                        <i class="fas fa-id-card"></i>
                        <span>Xác thực CCCD</span>
                    </div>
                    @php
                    $userForm = \App\Models\AuthorForm::where('user_id', auth()->id())->first();
                    $statusForm = $userForm ? $userForm->status : 0;
                    @endphp
                    @if($statusForm == 1)
                    <span class="badge bg-success" title="Đã xác minh"><i class="fas fa-check"></i></span>
                    @else
                    <span class="badge bg-secondary" title="Chưa xác minh"><i class="fas fa-exclamation"></i></span>
                    @endif
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="seller-main">
        @yield('content')
    </main>

    <!-- JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Sidebar responsive toggler
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sellerSidebar = document.getElementById('sellerSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (toggleSidebar) {
            toggleSidebar.addEventListener('click', () => {
                sellerSidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sellerSidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });
        }
    </script>
    @yield('scripts')
</body>

</html>