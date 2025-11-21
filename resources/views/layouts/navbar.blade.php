<nav class="navbar navbar-expand-lg navbar-light shadow-sm mx-2 mt-1 rounded" id="layout-navbar style="background: linear-gradient(135deg,
    #ffffff 0%, #f8f9ff 100%); backdrop-filter: blur(10px);">
    <div class="container-fluid px-4 py-2">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-gradient me-2"
                style="width: 45px; height: 45px;">
                <i class="fa-solid fa-calendar-days fa-lg text-white"></i>
            </div>
            <span class="fw-bold fs-4 text-primary">Daily App</span>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Left Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill {{ request()->routeIs('dashboard') ? 'active bg-gray text-white' : 'text-dark' }}"
                        href="{{ route('dashboard') }}">
                        <i class="fa-solid fa-house me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded-pill {{ request()->routeIs('daily-entries.*') ? 'active bg-gray text-white' : 'text-dark' }}"
                        href="{{ route('daily-entries.calendar') }}">
                        <i class="fa-regular fa-calendar me-1"></i> บันทึกประจำวัน
                    </a>
                </li>
            </ul>

            <!-- Search -->
            <form class="d-flex me-3" role="search">
                <div class="input-group rounded-pill overflow-hidden" style="background: rgba(255,255,255,0.8);">
                    <span class="input-group-text bg-transparent border-0">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                    </span>
                    <input class="form-control border-0 bg-transparent" type="search" placeholder="ค้นหา..."
                        aria-label="Search" />
                </div>
            </form>

            <!-- Right Icons -->
            <ul class="navbar-nav align-items-center">
                <!-- Notification Dropdown -->
                <li class="nav-item dropdown me-2">
                    <a class="nav-link position-relative p-2" href="#" id="notifDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bell fa-lg text-dark"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 0.65rem;">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" aria-labelledby="notifDropdown"
                        style="min-width: 300px;">
                        <li class="dropdown-header d-flex justify-content-between align-items-center">
                            <span class="fw-bold">การแจ้งเตือน</span>
                            <span class="badge bg-primary rounded-pill">3</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider my-0" />
                        </li>
                        <li>
                            <a class="dropdown-item py-3" href="#">
                                <div class="d-flex align-items-start">
                                    <i class="fa-solid fa-comment text-primary me-3 mt-1"></i>
                                    <div>
                                        <div class="fw-semibold">ความคิดเห็นใหม่</div>
                                        <small class="text-muted">มีคนแสดงความคิดเห็นในโพสต์ของคุณ</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-3" href="#">
                                <div class="d-flex align-items-start">
                                    <i class="fa-solid fa-calendar-check text-success me-3 mt-1"></i>
                                    <div>
                                        <div class="fw-semibold">สรุปรายสัปดาห์พร้อมแล้ว</div>
                                        <small class="text-muted">ดูสรุปกิจกรรมของคุณ</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-3" href="#">
                                <div class="d-flex align-items-start">
                                    <i class="fa-solid fa-circle-info text-info me-3 mt-1"></i>
                                    <div>
                                        <div class="fw-semibold">อัพเดทระบบ</div>
                                        <small class="text-muted">มีการอัพเดทใหม่พร้อมใช้งาน</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Dark Mode Toggle -->
                <li class="nav-item me-2">
                    <button class="btn btn-link nav-link p-2" id="dark-mode-toggle">
                        <i class="fa-solid fa-moon fa-lg text-dark"></i>
                    </button>
                </li>

                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center p-2" href="#" id="userDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff"
                            alt="{{ Auth::user()->name }}" class="rounded-circle me-2" width="36" height="36"
                            style="border: 2px solid #e0e0e0;" />
                        <span class="d-none d-lg-inline fw-semibold text-dark">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" aria-labelledby="userDropdown">
                        <li class="dropdown-header">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff"
                                    alt="{{ Auth::user()->name }}" class="rounded-circle me-2" width="40"
                                    height="40" />
                                <div>
                                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                <i class="fa-regular fa-user me-2"></i> โปรไฟล์
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="#">
                                <i class="fa-solid fa-gear me-2"></i> ตั้งค่า
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="fa-solid fa-power-off me-2"></i> ออกจากระบบ
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
