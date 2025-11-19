@extends('master')
@section('title', 'โปรไฟล์ของฉัน')

@section('content')

<style>
    /* ทำให้หน้าโปรไฟล์ดู modern */
    .profile-section-card {
        border-radius: 18px;
        border: 1px solid #e9ecef !important;
        transition: 0.25s ease;
    }
    .profile-section-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }

    .section-title {
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Divider สวย ๆ */
    .section-divider {
        height: 2.5px;
        width: 55px;
        background: #0d6efd;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    /* ปรับฟอร์มให้ดูดีขึ้น */
    .form-control {
        border-radius: 12px !important;
        padding: 10px 14px;
    }

    .btn {
        border-radius: 12px !important;
        padding: 10px 16px;
        font-weight: 500;
    }

    /* ย่อปุ่ม danger */
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        font-weight: 600;
    }
</style>

<div class="py-4">
    <div class="container" style="max-width: 880px;">

        {{-- Heading --}}
        <div class="mb-4 text-center">
            <h2 class="fw-bold text-dark mb-2">👤 โปรไฟล์ของฉัน</h2>
            <p class="text-muted">จัดการข้อมูลส่วนตัว เปลี่ยนรหัสผ่าน หรือลบบัญชีของคุณ</p>
        </div>

        {{-- ข้อมูลโปรไฟล์ --}}
        <div class="card profile-section-card shadow-sm mb-4">
            <div class="card-body p-4">

                <h5 class="section-title">✨ ข้อมูลโปรไฟล์</h5>
                <div class="section-divider"></div>

                <div style="max-width: 500px;">
                    @include('profile.partials.update-profile-information-form')
                </div>

            </div>
        </div>

        {{-- เปลี่ยนรหัสผ่าน --}}
        <div class="card profile-section-card shadow-sm mb-4">
            <div class="card-body p-4">

                <h5 class="section-title">🔐 เปลี่ยนรหัสผ่าน</h5>
                <div class="section-divider"></div>

                <div style="max-width: 500px;">
                    @include('profile.partials.update-password-form')
                </div>

            </div>
        </div>

        {{-- ลบบัญชี --}}
        <div class="card profile-section-card shadow-sm mb-5">
            <div class="card-body p-4">

                <h5 class="section-title text-danger">⚠️ ลบบัญชีผู้ใช้</h5>
                <div class="section-divider" style="background:#dc3545;"></div>

                <div style="max-width: 500px;">
                    @include('profile.partials.delete-user-form')
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
