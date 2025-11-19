@extends('master')

@section('title', 'บันทึกประจำวัน')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-semibold mb-1">บันทึกประจำวัน</h1>
            <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($date)->locale('th')->translatedFormat('d F Y') }}</p>
        </div>
        <a href="{{ route('daily-entries.calendar') }}" class="btn btn-outline-secondary">ย้อนกลับ</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('daily-entries.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="entry_date" class="form-label">วันที่</label>
                    <input type="date" class="form-control @error('entry_date') is-invalid @enderror" id="entry_date" name="entry_date" value="{{ old('entry_date', $date) }}" required>
                    @error('entry_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="activities" class="form-label">สิ่งที่ทำวันนี้</label>
                    <textarea id="activities" name="activities" rows="5" class="form-control @error('activities') is-invalid @enderror" placeholder="วันนี้คุณทำอะไรบ้าง...">{{ old('activities', $entry->activities ?? '') }}</textarea>
                    @error('activities')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="mood" class="form-label">ความรู้สึก</label>
                    <select id="mood" name="mood" class="form-select @error('mood') is-invalid @enderror">
                        <option value="">-- เลือกความรู้สึก --</option>
                        <option value="ดีมาก" {{ old('mood', $entry->mood ?? '') == 'ดีมาก' ? 'selected' : '' }}>ดีมาก 😊</option>
                        <option value="ดี" {{ old('mood', $entry->mood ?? '') == 'ดี' ? 'selected' : '' }}>ดี 🙂</option>
                        <option value="ปกติ" {{ old('mood', $entry->mood ?? '') == 'ปกติ' ? 'selected' : '' }}>ปกติ 😐</option>
                        <option value="ไม่ดี" {{ old('mood', $entry->mood ?? '') == 'ไม่ดี' ? 'selected' : '' }}>ไม่ดี 😔</option>
                        <option value="แย่" {{ old('mood', $entry->mood ?? '') == 'แย่' ? 'selected' : '' }}>แย่ 😢</option>
                    </select>
                    @error('mood')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="notes" class="form-label">หมายเหตุเพิ่มเติม</label>
                    <textarea id="notes" name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" placeholder="อยากเพิ่มเติมอะไรอีกไหม...">{{ old('notes', $entry->notes ?? '') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('daily-entries.calendar') }}" class="btn btn-outline-secondary">ยกเลิก</a>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
@endsection

