@extends('master')

@section('title', 'ปฏิทินบันทึกประจำวัน')

@push('styles')
<style>
    .calendar-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; /* ลื่นบน iOS */
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, minmax(90px, 1fr));
        gap: 0.5rem;
        min-width: 700px; /* ป้องกันบีบแคบเกินไป */
    }

    .calendar-cell {
        border: 1px solid #dee2e6;
        border-radius: 0.75rem;
        padding: 0.65rem;
        min-height: 110px;
        cursor: pointer;
        transition: all 0.2s ease;
        background-color: #ffffff;
        font-size: 0.875rem;
        position: relative;
    }

    .calendar-cell:hover {
        background-color: #f8f9fa;
        box-shadow: 0 0 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .calendar-cell.has-entry {
        background-color: #e3f2fd;
        border-color: #90caf9;
    }

    .calendar-cell.today {
        border: 2px solid #0d6efd;
        background-color: #e7f3ff !important;
    }

    .calendar-weekday {
        font-weight: 600;
        text-align: center;
        color: #495057;
        font-size: 0.85rem;
        padding: 0.5rem 0;
        background: #f8f9fa;
        border-radius: 0.5rem;
    }

    .day-number {
        font-weight: 600;
        font-size: 1rem;
        display: block;
    }

    .mood-text {
        font-weight: 600;
        font-size: 0.9rem;
        margin-top: 4px;
    }

    .activity-preview {
        font-size: 0.75rem;
        line-height: 1.3;
        margin-top: 4px;
        color: #555;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Responsive สำหรับมือถือ */
    @media (max-width: 768px) {
        .calendar-grid {
            grid-template-columns: repeat(7, minmax(75px, 1fr));
            gap: 0.4rem;
            min-width: 600px;
        }

        .calendar-cell {
            min-height: 100px;
            padding: 0.5rem;
            font-size: 0.8rem;
        }

        .day-number {
            font-size: 0.95rem;
        }

        .calendar-weekday {
            font-size: 0.8rem;
        }

        .btn-group .btn {
            font-size: 0.85rem;
            padding: 0.35rem 0.65rem;
        }

        .card-title {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 480px) {
        .calendar-grid {
            min-width: 560px;
        }

        .calendar-cell {
            min-height: 95px;
            padding: 0.4rem;
        }

        .activity-preview {
            -webkit-line-clamp: 2;
            font-size: 0.7rem;
        }

        .mood-text {
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-3 px-md-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="h4 h3-md fw-bold mb-1">ปฏิทินบันทึกประจำวัน</h1>
            <p class="text-muted small mb-0">แตะที่วันที่เพื่อบันทึกหรือแก้ไข</p>
        </div>
        <a href="{{ route('daily-entries.create', ['date' => today()->format('Y-m-d')]) }}"
           class="btn btn-primary btn-sm">
            + บันทึกวันนี้
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-body p-4">

            <!-- เดือน + ปุ่มเปลี่ยนเดือน -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
                <h5 class="mb-0 fw-bold text-primary">
                    {{ \Carbon\Carbon::create($year, $month, 1)->locale('th')->translatedFormat('F Y') }}
                </h5>
                <div class="btn-group flex-wrap" role="group">
                    <a href="{{ route('daily-entries.calendar', ['year' => $startDate->copy()->subMonth()->year, 'month' => $startDate->copy()->subMonth()->month]) }}"
                       class="btn btn-outline-secondary btn-sm">← ก่อนหน้า</a>
                    <a href="{{ route('daily-entries.calendar') }}"
                       class="btn btn-outline-primary btn-sm">เดือนนี้</a>
                    <a href="{{ route('daily-entries.calendar', ['year' => $startDate->copy()->addMonth()->year, 'month' => $startDate->copy()->addMonth()->month]) }}"
                       class="btn btn-outline-secondary btn-sm">ถัดไป →</a>
                </div>
            </div>

            <!-- ปฏิทิน (เลื่อนซ้าย-ขวาได้บนมือถือ) -->
            <div class="calendar-container">
                <div class="calendar-grid mb-3">
                    @foreach(['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'] as $day)
                        <div class="calendar-weekday">{{ $day }}</div>
                    @endforeach
                </div>

                <div class="calendar-grid">
                    <!-- ช่องว่างก่อนวันแรก -->
                    @for($i = 0; $i < $firstDayOfWeek; $i++)
                        <div></div>
                    @endfor

                    <!-- วันที่ในเดือน -->
                    @for($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $currentDate = $startDate->copy()->setDay($day);
                            $dateKey = $currentDate->format('Y-m-d');
                            $entry = $entries[$dateKey] ?? null;
                            $isToday = $currentDate->isToday();
                        @endphp

                        <div class="calendar-cell {{ $entry ? 'has-entry' : '' }} {{ $isToday ? 'today' : '' }}"
                             onclick="window.location='{{ route('daily-entries.create', ['date' => $dateKey]) }}'">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="day-number">{{ $day }}</span>
                                @if($isToday)
                                    <span class="badge bg-primary small">วันนี้</span>
                                @endif
                            </div>

                            @if($entry)
                                @if($entry->mood)
                                    @php
                                        $moodEmojis = [
                                            'ดีมาก' => 'Very Happy',
                                            'ดี' => 'Happy',
                                            'ปกติ' => 'Neutral',
                                            'ไม่ดี' => 'Sad',
                                            'แย่' => 'Very Sad'
                                        ];
                                    @endphp
                                    <div class="mood-text">
                                        {{ $moodEmojis[$entry->mood] ?? 'Neutral' }} {{ $entry->mood }}
                                    </div>
                                @endif
                                @if($entry->activities)
                                    <div class="activity-preview">
                                        {{ Str::limit($entry->activities, 60) }}
                                    </div>
                                @endif
                            @else
                                <small class="text-muted opacity-75">ยังไม่มีบันทึก</small>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- การ์ดลัดไปสรุป -->
    <div class="row g-3 mt-4">
        <div class="col-12 col-md-6">
            <a href="{{ route('daily-entries.weekly-summary') }}"
               class="card h-100 text-decoration-none shadow-sm border-0 hover-lift">
                <div class="card-body text-center py-4">
                    <h5 class="mb-2">สรุปรายสัปดาห์</h5>
                    <p class="text-muted small mb-0">ดูบันทึกย้อนหลัง 7 วัน</p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-6">
            <a href="{{ route('daily-entries.monthly-summary') }}"
               class="card h-100 text-decoration-none shadow-sm border-0 hover-lift">
                <div class="card-body text-center py-4">
                    <h5 class="mb-2">สรุปรายเดือน</h5>
                    <p class="text-muted small mb-0">สถิติและแนวโน้มอารมณ์</p>
                </div>
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
    .hover-lift {
        transition: transform 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-4px);
    }
</style>
@endpush
@endsection