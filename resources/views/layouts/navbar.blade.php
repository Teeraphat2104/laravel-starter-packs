<nav class="navbar navbar-expand-lg navbar-light shadow-sm mx-2 mt-2 rounded blur sticky-top" id="layout-navbar style="background:
    linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%); backdrop-filter: blur(10px);">
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
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-1">
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded {{ request()->routeIs('dashboard') ? 'active bg-gray text-white' : 'text-dark' }}"
                        href="{{ route('dashboard') }}">
                        <i class="fa-solid fa-house me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded {{ request()->routeIs('daily-entries.*') ? 'active bg-gray text-white' : 'text-dark' }}"
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
                            <a class="dropdown-item py-2" href="#" data-bs-toggle="modal"
                                data-bs-target="#settingsModal">
                                <i class="fa-solid fa-gear me-2"></i> ตั้งค่า
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="button" class="dropdown-item py-2 text-danger"
                                    onclick="confirmLogout()">
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

<!-- Settings Modal -->
<div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg"
            style="background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-gradient me-3"
                        style="width: 45px; height: 45px;">
                        <i class="fa-solid fa-gear fa-lg text-white"></i>
                    </div>
                    <h5 class="modal-title fw-bold mb-0" id="settingsModalLabel">ตั้งค่า</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3">
                <!-- Theme Settings -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3">
                        <i class="fa-solid fa-palette text-primary me-2"></i>ธีม
                    </h6>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="theme" id="themeLight" checked>
                            <label class="form-check-label" for="themeLight">
                                <i class="fa-solid fa-sun me-1"></i> สว่าง
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="theme" id="themeDark">
                            <label class="form-check-label" for="themeDark">
                                <i class="fa-solid fa-moon me-1"></i> มืด
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="theme" id="themeAuto">
                            <label class="form-check-label" for="themeAuto">
                                <i class="fa-solid fa-circle-half-stroke me-1"></i> อัตโนมัติ
                            </label>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Language Settings -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3">
                        <i class="fa-solid fa-language text-primary me-2"></i>ภาษา
                    </h6>
                    <select class="form-select rounded-3" id="languageSelect">
                        <option value="th" selected>ไทย (Thai)</option>
                        <option value="en">English</option>
                    </select>
                </div>

                <hr class="my-4">

                <!-- Notification Settings -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3">
                        <i class="fa-solid fa-bell text-primary me-2"></i>การแจ้งเตือน
                    </h6>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="notifEmail" checked>
                        <label class="form-check-label" for="notifEmail">
                            แจ้งเตือนผ่านอีเมล
                        </label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="notifWeeklySummary" checked>
                        <label class="form-check-label" for="notifWeeklySummary">
                            สรุปรายสัปดาห์
                        </label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="notifReminder" checked>
                        <label class="form-check-label" for="notifReminder">
                            เตือนบันทึกประจำวัน
                        </label>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Data Management -->
                <div class="mb-3">
                    <h6 class="fw-semibold mb-3">
                        <i class="fa-solid fa-database text-primary me-2"></i>จัดการข้อมูล
                    </h6>
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-outline-primary btn-sm rounded-pill">
                            <i class="fa-solid fa-download me-1"></i> ส่งออกข้อมูล
                        </button>
                        <button class="btn btn-outline-secondary btn-sm rounded-pill">
                            <i class="fa-solid fa-clock-rotate-left me-1"></i> ล้างแคช
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark me-1"></i> ปิด
                </button>
                <button type="button" class="btn btn-primary rounded-pill px-4" onclick="saveSettings()">
                    <i class="fa-solid fa-check me-1"></i> บันทึก
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    function confirmLogout() {
        Swal.fire({
            title: 'ออกจากระบบ?',
            text: "คุณต้องการออกจากระบบใช่หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'ออกจากระบบ',
            cancelButtonText: 'ยกเลิก',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }

    function saveSettings() {
        // Get theme selection
        const theme = document.querySelector('input[name="theme"]:checked').id.replace('theme', '').toLowerCase();

        // Get language selection
        const language = document.getElementById('languageSelect').value;

        // Get notification preferences
        const notifEmail = document.getElementById('notifEmail').checked;
        const notifWeeklySummary = document.getElementById('notifWeeklySummary').checked;
        const notifReminder = document.getElementById('notifReminder').checked;

        // Save to localStorage
        localStorage.setItem('userSettings', JSON.stringify({
            theme: theme,
            language: language,
            notifications: {
                email: notifEmail,
                weeklySummary: notifWeeklySummary,
                reminder: notifReminder
            }
        }));

        // Show success message
        Swal.fire({
            title: 'บันทึกสำเร็จ!',
            text: 'การตั้งค่าของคุณถูกบันทึกแล้ว',
            icon: 'success',
            confirmButtonColor: '#0d6efd',
            confirmButtonText: 'ตกลง',
            timer: 2000
        }).then(() => {
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('settingsModal'));
            modal.hide();

            // Apply theme if changed
            applyTheme(theme);
        });
    }

    function applyTheme(theme) {
        // This is a placeholder for theme application logic
        // You can implement actual theme switching here
        if (theme === 'dark') {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    }

    // Load settings on page load
    document.addEventListener('DOMContentLoaded', function() {
        const savedSettings = localStorage.getItem('userSettings');
        if (savedSettings) {
            const settings = JSON.parse(savedSettings);

            // Apply saved theme
            if (settings.theme) {
                document.getElementById('theme' + settings.theme.charAt(0).toUpperCase() + settings.theme.slice(
                    1)).checked = true;
                applyTheme(settings.theme);
            }

            // Apply saved language
            if (settings.language) {
                document.getElementById('languageSelect').value = settings.language;
            }

            // Apply saved notification preferences
            if (settings.notifications) {
                document.getElementById('notifEmail').checked = settings.notifications.email;
                document.getElementById('notifWeeklySummary').checked = settings.notifications.weeklySummary;
                document.getElementById('notifReminder').checked = settings.notifications.reminder;
            }
        }
    });
</script>
