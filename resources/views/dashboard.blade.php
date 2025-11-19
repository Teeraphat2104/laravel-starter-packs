@extends('master')

@section('title', 'Dashboard')

@section('content')
    @php
        $todayEntry = \App\Models\DailyEntry::where('user_id', auth()->id())
            ->where('entry_date', today())
            ->first();
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-semibold">Dashboard</h1>
            <p class="text-muted mb-0">ภาพรวมการบันทึกประจำวันของคุณ</p>
        </div>
        <a href="{{ route('daily-entries.create', ['date' => today()->format('Y-m-d')]) }}" class="btn btn-primary">
            + บันทึกวันนี้
        </a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <a href="{{ route('daily-entries.create', ['date' => today()->format('Y-m-d')]) }}" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex align-items-center">
                        <div class="display-5 me-3">📝</div>
                        <div>
                            <h5 class="card-title mb-1">บันทึกวันนี้</h5>
                            <p class="card-text text-muted mb-0">{{ today()->locale('th')->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('daily-entries.calendar') }}" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex align-items-center">
                        <div class="display-5 me-3">📅</div>
                        <div>
                            <h5 class="card-title mb-1">ปฏิทิน</h5>
                            <p class="card-text text-muted mb-0">ดูบันทึกทั้งหมด</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('daily-entries.weekly-summary') }}" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex align-items-center">
                        <div class="display-5 me-3">📊</div>
                        <div>
                            <h5 class="card-title mb-1">สรุปรายสัปดาห์</h5>
                            <p class="card-text text-muted mb-0">ดูสรุปประจำสัปดาห์</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    @if($todayEntry)
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">บันทึกวันนี้</h5>
                    <a href="{{ route('daily-entries.edit', $todayEntry->id) }}" class="btn btn-outline-primary btn-sm">
                        แก้ไข
                    </a>
                </div>

                @if($todayEntry->mood)
                    <div class="mb-3">
                        @php
                            $moodEmojis = [
                                'ดีมาก' => '😊 ดีมาก',
                                'ดี' => '🙂 ดี',
                                'ปกติ' => '😐 ปกติ',
                                'ไม่ดี' => '😔 ไม่ดี',
                                'แย่' => '😢 แย่'
                            ];
                        @endphp
                        <span class="badge rounded-pill text-bg-primary">
                            {{ $moodEmojis[$todayEntry->mood] ?? $todayEntry->mood }}
                        </span>
                    </div>
                @endif

                @if($todayEntry->activities)
                    <div class="mb-3">
                        <h6 class="text-muted">สิ่งที่ทำวันนี้</h6>
                        <p class="mb-0">{{ $todayEntry->activities }}</p>
                    </div>
                @endif

                @if($todayEntry->notes)
                    <div>
                        <h6 class="text-muted">หมายเหตุ</h6>
                        <p class="mb-0">{{ $todayEntry->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body text-center">
                <p class="text-muted mb-3">คุณยังไม่ได้บันทึกวันนี้</p>
                <a href="{{ route('daily-entries.create', ['date' => today()->format('Y-m-d')]) }}" class="btn btn-primary">
                    บันทึกตอนนี้
                </a>
            </div>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title mb-4">ลิงก์ด่วน</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <a href="{{ route('daily-entries.calendar') }}" class="card h-100 border shadow-none text-decoration-none text-dark">
                        <div class="card-body">
                            <h6>📅 ปฏิทินบันทึกประจำวัน</h6>
                            <p class="text-muted mb-0">ดูและจัดการบันทึกทั้งหมด</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('daily-entries.monthly-summary') }}" class="card h-100 border shadow-none text-decoration-none text-dark">
                        <div class="card-body">
                            <h6>📊 สรุปรายเดือน</h6>
                            <p class="text-muted mb-0">ดูสถิติและสรุปประจำเดือน</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
