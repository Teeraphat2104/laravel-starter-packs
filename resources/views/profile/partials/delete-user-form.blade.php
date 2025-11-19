<section class="mb-4">
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body p-4">

            {{-- Header --}}
            <div class="mb-4">
                <h4 class="fw-semibold mb-1 text-danger">⚠️ ลบบัญชีผู้ใช้</h4>
                <p class="text-muted mb-0">
                    เมื่อบัญชีถูกลบ ข้อมูลทั้งหมดจะถูกลบอย่างถาวร กรุณาดาวน์โหลดข้อมูลที่ต้องการเก็บก่อน
                </p>
            </div>

            {{-- ปุ่มเปิด Modal --}}
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                ลบบัญชีผู้ใช้
            </button>

            {{-- Modal --}}
            <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content rounded-4">
                        <div class="modal-header">
                            <h5 class="modal-title text-danger" id="deleteAccountModalLabel">ยืนยันการลบบัญชี</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form method="post" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('delete')

                            <div class="modal-body">
                                <p class="text-muted mb-3">
                                    เมื่อบัญชีถูกลบ ข้อมูลทั้งหมดจะถูกลบอย่างถาวร กรุณากรอกรหัสผ่านเพื่อยืนยัน
                                </p>

                                <div class="mb-3">
                                    <label for="password" class="form-label">รหัสผ่าน</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="รหัสผ่าน">
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                <button type="submit" class="btn btn-danger">ลบบัญชี</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
