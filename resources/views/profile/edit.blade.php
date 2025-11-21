@extends('master')
@section('title', 'โปรไฟล์ของฉัน')

@section('content')
    <div class="py-4">
        <div class="container">
            {{-- Heading --}}
            <div class="mb-5">
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-gradient me-3"
                        style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-user fa-lg text-white"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold text-dark mb-0">โปรไฟล์ของฉัน</h2>
                        <p class="text-muted mb-0">จัดการข้อมูลส่วนตัว เปลี่ยนรหัสผ่าน หรือลบบัญชีของคุณ</p>
                    </div>
                </div>
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
            background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
            backdrop-filter: blur(10px);
        }

        .profile-section-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            transform: translateY(-3px);
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
            height: 3px;
            width: 60px;
            background: linear-gradient(90deg, #0d6efd, #6ea8fe);
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* ปรับฟอร์มให้ดูดีขึ้น */
        .form-control {
            border-radius: 12px !important;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        .btn {
            border-radius: 12px !important;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0a58ca, #084298);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        /* ย่อปุ่ม danger */
        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #bb2d3b);
            border: none;
            font-weight: 600;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #bb2d3b, #a02834);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        /* Label styling */
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
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
