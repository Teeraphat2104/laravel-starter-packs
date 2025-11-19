<section class="mb-4">
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body p-4">

            {{-- Header --}}
            <div class="mb-4">
                <h4 class="fw-semibold mb-1">✨ ข้อมูลโปรไฟล์</h4>
                <p class="text-muted mb-0">ปรับปรุงข้อมูลบัญชีและอีเมลของคุณ</p>
            </div>

            {{-- ฟอร์มยืนยันอีเมล --}}
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            {{-- ฟอร์มแก้ไขโปรไฟล์ --}}
            <form method="post" action="{{ route('profile.update') }}" class="mt-3">
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label for="name" class="form-label">ชื่อ</label>
                    <input type="text" id="name" name="name" class="form-control" 
                           value="{{ old('name', $user->name) }}" required autofocus>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">อีเมล</label>
                    <input type="email" id="email" name="email" class="form-control" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="small text-muted mb-1">
                                อีเมลของคุณยังไม่ได้ยืนยัน
                                <button form="send-verification" type="submit" class="btn btn-link btn-sm p-0">คลิกที่นี่เพื่อส่งอีเมลยืนยันอีกครั้ง</button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="small text-success mb-0">ส่งลิงก์ยืนยันไปยังอีเมลเรียบร้อยแล้ว</p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-primary">บันทึก</button>

                    @if (session('status') === 'profile-updated')
                        <span class="text-success small">บันทึกเรียบร้อย</span>
                    @endif
                </div>

            </form>
        </div>
    </div>
</section>
