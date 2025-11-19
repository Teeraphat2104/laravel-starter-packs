@extends('master')
@section('title', 'สรุปรายเดือน')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">📅 สรุปรายเดือน</h1>
        <p class="text-muted mb-0">{{ $startDate->locale('th')->translatedFormat('F Y') }}</p>
    </div>

    <div class="btn-group">
        <a href="{{ route('daily-entries.monthly-summary', ['year' => $startDate->copy()->subMonth()->year, 'month' => $startDate->copy()->subMonth()->month]) }}" 
           class="btn btn-outline-secondary btn-sm">← เดือนก่อน</a>

        <a href="{{ route('daily-entries.monthly-summary') }}" 
           class="btn btn-outline-secondary btn-sm">เดือนนี้</a>

        <a href="{{ route('daily-entries.monthly-summary', ['year' => $startDate->copy()->addMonth()->year, 'month' => $startDate->copy()->addMonth()->month]) }}" 
           class="btn btn-outline-secondary btn-sm">เดือนถัดไป →</a>
    </div>
</div>

<!-- สรุปตัวเลขสำคัญ -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-muted mb-1">จำนวนวันที่บันทึก</p>
                <h3 class="fw-bold text-primary">
                    <i class="bi bi-journal-check me-1"></i> {{ $totalDays }} / {{ $daysInMonth }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-muted mb-1">เปอร์เซ็นต์การบันทึก</p>
                <h3 class="fw-bold text-success">
                    <i class="bi bi-graph-up-arrow me-1"></i>
                    {{ $daysInMonth ? round(($totalDays / $daysInMonth) * 100) : 0 }}%
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-muted mb-1">จำนวนบันทึก</p>
                <h3 class="fw-bold text-info">
                    <i class="bi bi-file-earmark-text me-1"></i> {{ $entries->count() }}
                </h3>
            </div>
        </div>
    </div>
</div>

<!-- สถิติอารมณ์ -->
@if($moodStats->isNotEmpty())
<div class="mb-4">
    <h4 class="fw-semibold mb-3">😊 สถิติความรู้สึกประจำเดือน</h4>

    <div class="row g-3">
        @php
        $moodEmojis = [
            'ดีมาก' => '😀',
            'ดี' => '🙂',
            'ปกติ' => '😐',
            'ไม่ดี' => '😔',
            'แย่' => '😢'
        ];

        $moodColors = [
            'ดีมาก' => 'primary',
            'ดี' => 'success',
            'ปกติ' => 'secondary',
            'ไม่ดี' => 'warning',
            'แย่' => 'danger'
        ];
        @endphp

        @foreach($moodStats as $mood => $count)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="card shadow-sm border-0 text-center h-100">
                    <div class="card-body">
                        <div class="display-6">{{ $moodEmojis[$mood] }}</div>
                        <p class="text-muted small mb-1">{{ $mood }}</p>
                        <span class="badge bg-{{ $moodColors[$mood] }} rounded-pill px-3 py-2">
                            {{ $count }} ครั้ง
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- รายการบันทึกแบบ Timeline -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">

        <h4 class="fw-semibold mb-3">📝 บันทึกประจำเดือน</h4>

        @if($entries->isEmpty())
            <p class="text-center text-muted my-5">ยังไม่มีบันทึกในเดือนนี้</p>
        @else
            <div class="timeline">
                @foreach($entries as $entry)
                <div class="timeline-item mb-4 position-relative">
                    <div class="timeline-dot bg-primary"></div>

                    <div class="border rounded-4 p-4 ms-4 shadow-sm">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="fw-bold mb-1">
                                    {{ $entry->entry_date->locale('th')->translatedFormat('d F Y') }}
                                </h5>

                                @if($entry->mood)
                                    <span class="badge bg-primary rounded-pill">
                                        {{ ($moodEmojis[$entry->mood] ?? '') . ' ' . $entry->mood }}
                                    </span>
                                @endif

                                @if($entry->activities)
                                    <p class="mt-2 text-muted mb-0">
                                        {{ Str::limit($entry->activities, 120) }}
                                    </p>
                                @endif
                            </div>

                            <a href="{{ route('daily-entries.edit', $entry->id) }}" class="btn btn-link btn-sm">
                                ดูรายละเอียด →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="text-center">
    <a href="{{ route('daily-entries.calendar') }}" class="btn btn-outline-primary">
        ← กลับไปยังปฏิทิน
    </a>
</div>

@endsection

<!-- CSS สำหรับ Timeline -->
@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 20px;
    margin-left: 10px;
}
.timeline::before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    width: 3px;
    left: 9px;
    background: #dee2e6;
}
.timeline-dot {
    width: 16px;
    height: 16px;
    position: absolute;
    left: 3px;
    border-radius: 50%;
}
</style>
@endpush
