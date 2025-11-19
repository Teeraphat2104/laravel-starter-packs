@extends('master')

@section('title', 'สรุปรายสัปดาห์')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">📘 สรุปรายสัปดาห์</h1>
        <p class="text-muted mb-0">
            {{ $startDate->locale('th')->translatedFormat('d F Y') }} 
            - 
            {{ $endDate->locale('th')->translatedFormat('d F Y') }}
        </p>
    </div>

    <div class="btn-group">
        <a href="{{ route('daily-entries.weekly-summary', ['week' => $startDate->copy()->subWeek()->format('Y-m-d')]) }}" 
           class="btn btn-outline-secondary btn-sm">← สัปดาห์ก่อน</a>

        <a href="{{ route('daily-entries.weekly-summary') }}" 
           class="btn btn-outline-secondary btn-sm">สัปดาห์นี้</a>

        <a href="{{ route('daily-entries.weekly-summary', ['week' => $startDate->copy()->addWeek()->format('Y-m-d')]) }}" 
           class="btn btn-outline-secondary btn-sm">สัปดาห์ถัดไป →</a>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">

        @if($entries->isEmpty())
            <p class="text-muted text-center my-5">ยังไม่มีบันทึกในสัปดาห์นี้</p>
        @else

        <div class="timeline">

            @php
            $moods = [
                'ดีมาก' => ['icon' => '😀', 'color' => 'primary'],
                'ดี' => ['icon' => '🙂', 'color' => 'success'],
                'ปกติ' => ['icon' => '😐', 'color' => 'secondary'],
                'ไม่ดี' => ['icon' => '😔', 'color' => 'warning'],
                'แย่' => ['icon' => '😢', 'color' => 'danger'],
            ];
            @endphp

            @foreach($entries as $entry)
                <div class="timeline-item mb-4 position-relative">

                    <!-- จุดบอก timeline -->
                    <div class="timeline-dot bg-primary"></div>

                    <div class="border rounded-4 p-4 ms-4 shadow-sm bg-white">

                        <div class="d-flex justify-content-between">
                            <div>

                                <h5 class="fw-bold mb-1">
                                    📅 {{ $entry->entry_date->locale('th')->translatedFormat('l d F Y') }}
                                </h5>

                                @if($entry->mood)
                                    @php
                                        $m = $moods[$entry->mood] ?? ['icon' => '', 'color' => 'dark'];
                                    @endphp

                                    <span class="badge bg-{{ $m['color'] }} px-3 py-2 rounded-pill">
                                        {{ $m['icon'] }} {{ $entry->mood }}
                                    </span>
                                @endif

                            </div>

                            <a href="{{ route('daily-entries.edit', $entry->id) }}" 
                               class="btn btn-link btn-sm">แก้ไข →</a>
                        </div>

                        @if($entry->activities)
                            <div class="mt-3">
                                <h6 class="text-muted small">📝 สิ่งที่ทำวันนี้</h6>
                                <p class="mb-0">{{ $entry->activities }}</p>
                            </div>
                        @endif

                        @if($entry->notes)
                            <div class="mt-3">
                                <h6 class="text-muted small">📌 หมายเหตุ</h6>
                                <p class="mb-0">{{ $entry->notes }}</p>
                            </div>
                        @endif

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

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 20px;
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
