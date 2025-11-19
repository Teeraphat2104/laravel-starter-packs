<section class="mb-4">
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body p-4">

            {{-- Header --}}
            <div class="mb-4">
                <h4 class="fw-semibold mb-1">🔐 เปลี่ยนรหัสผ่าน</h4>
                <p class="text-muted mb-0">ตั้งรหัสผ่านที่ยาวและปลอดภัย เพื่อปกป้องบัญชีของคุณ</p>
            </div>

            {{-- ฟอร์มเปลี่ยนรหัสผ่าน --}}
            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="update_password_current_password" class="form-label">รหัสผ่านปัจจุบัน</label>
                    <input type="password" id="update_password_current_password" name="current_password"
                           class="form-control" autocomplete="current-password">
                    @error('current_password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="update_password_password" class="form-label">รหัสผ่านใหม่</label>
                    <input type="password" id="update_password_password" name="password"
                           class="form-control" autocomplete="new-password">
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="update_password_password_confirmation" class="form-label">ยืนยันรหัสผ่านใหม่</label>
                    <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                           class="form-control" autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-primary">บันทึก</button>

                    @if (session('status') === 'password-updated')
                        <span class="text-success small">บันทึกเรียบร้อย</span>
                    @endif
                </div>
            </form>

        </div>
    </div>
</section>
