@extends('master')

@section('title', 'แก้ไขบันทึกประจำวัน')

@push('styles')
    <style>
        .mood-selector {
            display: flex;
            justify-content: space-between;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .mood-option {
            position: relative;
            width: 100%;
        }

        .mood-option input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .mood-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1rem 0.5rem;
            border: 2px solid #eef2f6;
            border-radius: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            height: 100%;
            background: #fff;
        }

        .mood-emoji {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            transition: transform 0.2s;
            line-height: 1;
        }

        .mood-text {
            font-size: 0.85rem;
            font-weight: 600;
            color: #697a8d;
        }

        .mood-option input:checked+.mood-label {
            border-color: #696cff;
            background-color: #f5f6ff;
            box-shadow: 0 4px 12px rgba(105, 108, 255, 0.15);
        }

        .mood-option input:checked+.mood-label .mood-emoji {
            transform: scale(1.2);
        }

        .mood-option:hover .mood-label {
            border-color: #b4b6ff;
            background-color: #f8f9fa;
        }

        .form-card {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.02);
        }

        .form-control,
        .form-select {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border-color: #d9dee3;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #696cff;
            box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.1);
        }

        .btn-delete-zone {
            border: 2px dashed #ff3e1d;
            background: #fff5f5;
            border-radius: 1rem;
            transition: all 0.2s;
        }

        .btn-delete-zone:hover {
            background: #ffe0db;
        }

        @media (max-width: 576px) {
            .mood-emoji {
                font-size: 2rem;
            }

            .mood-text {
                font-size: 0.75rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold py-3 mb-0">
                            <span class="text-muted fw-light">Daily /</span> Edit Entry
                        </h4>
                        <p class="text-muted mb-0">
                            แก้ไขบันทึกวันที่ {{ $entry->entry_date->locale('th')->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <a href="{{ route('daily-entries.calendar') }}" class="btn btn-outline-secondary rounded-pill">
                        <i class="fa-solid fa-arrow-left me-1"></i> ย้อนกลับ
                    </a>
                </div>

                <div class="card form-card mb-4">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('daily-entries.update', $entry->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Date (Readonly) -->
                            <div class="mb-4">
                                <label class="form-label text-uppercase text-muted small fw-bold">วันที่</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="fa-regular fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 rounded-end-3 bg-light"
                                        value="{{ $entry->entry_date->format('d/m/Y') }}" disabled>
                                </div>
                            </div>

                            <!-- Mood Selection -->
                            <div class="mb-4">
                                <label
                                    class="form-label text-uppercase text-muted small fw-bold mb-3">วันนี้รู้สึกอย่างไร?</label>
                                <div class="mood-selector">
                                    @php
                                        $moods = [
                                            'ดีมาก' => ['emoji' => '🤩', 'label' => 'ดีมาก'],
                                            'ดี' => ['emoji' => '😊', 'label' => 'ดี'],
                                            'ปกติ' => ['emoji' => '😐', 'label' => 'ปกติ'],
                                            'ไม่ดี' => ['emoji' => '😔', 'label' => 'ไม่ดี'],
                                            'แย่' => ['emoji' => '😫', 'label' => 'แย่'],
                                        ];
                                    @endphp

                                    @foreach ($moods as $value => $data)
                                        <div class="mood-option">
                                            <input type="radio" name="mood" id="mood_{{ $loop->index }}"
                                                value="{{ $value }}"
                                                {{ old('mood', $entry->mood) == $value ? 'checked' : '' }}>
                                            <label class="mood-label" for="mood_{{ $loop->index }}">
                                                <span class="mood-emoji">{{ $data['emoji'] }}</span>
                                                <span class="mood-text">{{ $data['label'] }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('mood')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Activities -->
                            <div class="mb-4">
                                <label for="activities"
                                    class="form-label text-uppercase text-muted small fw-bold">เรื่องราววันนี้</label>
                                <textarea id="activities" name="activities" rows="5"
                                    class="form-control @error('activities') is-invalid @enderror" placeholder="วันนี้คุณทำอะไรบ้าง?">{{ old('activities', $entry->activities) }}</textarea>
                                @error('activities')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="mb-5">
                                <label for="notes"
                                    class="form-label text-uppercase text-muted small fw-bold">บันทึกเพิ่มเติม</label>
                                <textarea id="notes" name="notes" rows="2" class="form-control @error('notes') is-invalid @enderror"
                                    placeholder="โน้ตเล็กๆ น้อยๆ...">{{ old('notes', $entry->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> อัปเดตบันทึก
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Zone -->
                <div class="card form-card border-danger border-opacity-25">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-danger fw-bold mb-1">ลบบันทึกนี้</h6>
                                <p class="text-muted small mb-0">การลบจะไม่สามารถกู้คืนได้</p>
                            </div>
                            <form method="POST" action="{{ route('daily-entries.destroy', $entry->id) }}"
                                onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบบันทึกนี้?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fa-solid fa-trash me-1"></i> ลบ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
