@extends('master')
@section('title', 'โปรไฟล์ของฉัน')

@section('content')
    <div class="py-4">
        <div class="container">

            {{-- Heading --}}
            <div class="mb-4 text-center">
                <h2 class="fw-bold text-dark mb-2">👤 โปรไฟล์ของฉัน</h2>
                <p class="text-muted">จัดการข้อมูลส่วนตัว เปลี่ยนรหัสผ่าน หรือลบบัญชีของคุณ</p>
            </div>

            {{-- ข้อมูลโปรไฟล์ --}}
            <div class="mb-4">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- เปลี่ยนรหัสผ่าน --}}
            <div class="mb-4">
                @include('profile.partials.update-password-form')
            </div>

            {{-- ลบบัญชี --}}
            <div class="mb-5">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* ทำให้หน้าโปรไฟล์ดู modern */
        .profile-section-card {
            border-radius: 18px;
            border: 1px solid #e9ecef !important;
            transition: 0.25s ease;
        }

        .profile-section-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#confirmDeleteModal').on('shown.bs.modal', function() {
                // disable ปุ่มลบเมื่อ modal เปิด
                $('#confirmDeleteModal .btn-danger[type="submit"]').prop('disabled', true);

                // ให้ enable เมื่อพิมพ์รหัสผ่าน
                $('#password').on('input', function() {
                    const hasValue = $(this).val().trim().length > 0;
                    $('#confirmDeleteModal .btn-danger[type="submit"]').prop('disabled', !hasValue);
                });
            });

            // reset เมื่อ modal ถูกปิด
            $('#confirmDeleteModal').on('hidden.bs.modal', function() {
                $('#confirmDeleteModal .btn-danger[type="submit"]').prop('disabled', true);
                $('#password').val('');
            });
        });
    </script>
@endpush
