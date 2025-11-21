@extends('master')

@section('title', 'Dashboard')

@push('styles')
    <style>
        .welcome-card {
            background: linear-gradient(135deg, #696cff 0%, #8592a3 100%);
            color: white;
            border-radius: 1rem;
            border: none;
            overflow: hidden;
            position: relative;
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTAwIDAgQzUgMCAwIDUgMCAxMDAgQzAgMTk1IDUgMjAwIDEwMCAyMDAgQzE5NSAyMDAgMjAwIDE5NSAyMDAgMTAwIEMyMDAgNSAxOTUgMCAxMDAgMFoiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIvPjwvc3ZnPg==') no-repeat right center;
            background-size: contain;
            pointer-events: none;
        }

        .stat-card {
            border: none;
            border-radius: 1rem;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05);
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .timeline-mini .timeline-item {
            padding-left: 1.5rem;
            border-left: 2px solid #eef2f6;
            position: relative;
            padding-bottom: 1.5rem;
        }

        .timeline-mini .timeline-item:last-child {
            border-left: 2px solid transparent;
            padding-bottom: 0;
        }

        .timeline-mini .timeline-dot {
            position: absolute;
            left: -0.35rem;
            top: 0.25rem;
            width: 0.7rem;
            height: 0.7rem;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #696cff;
        }

        .mood-btn {
            transition: transform 0.2s;
            cursor: pointer;
        }

        .mood-btn:hover {
            transform: scale(1.2);
        }
    </style>
@endpush

@section('content')
    @php
        $user = auth()->user();
        $todayEntry = \App\Models\DailyEntry::where('user_id', $user->id)->where('entry_date', today())->first();

        $recentEntries = \App\Models\DailyEntry::where('user_id', $user->id)
            ->where('entry_date', '!=', today())
            ->latest('entry_date')
            ->take(3)
            ->get();

        $totalEntries = \App\Models\DailyEntry::where('user_id', $user->id)->count();
        $thisMonthEntries = \App\Models\DailyEntry::where('user_id', $user->id)
            ->whereMonth('entry_date', now()->month)
            ->whereYear('entry_date', now()->year)
            ->count();

        $moodConfig = [
            'ดีมาก' => ['emoji' => '🤩', 'color' => 'primary', 'bg' => 'e7e7ff'],
            'ดี' => ['emoji' => '😊', 'color' => 'success', 'bg' => 'e8fadf'],
            'ปกติ' => ['emoji' => '😐', 'color' => 'info', 'bg' => 'd7f5fc'],
            'ไม่ดี' => ['emoji' => '😔', 'color' => 'warning', 'bg' => 'fff2d6'],
            'แย่' => ['emoji' => '😫', 'color' => 'danger', 'bg' => 'ffe0db'],
        ];
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card welcome-card p-4">
                    <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 1;">
                        <div>
                            <h3 class="text-white fw-bold mb-1">สวัสดี, {{ $user->name }}! 👋</h3>
                            <p class="text-white-50 mb-0">วันนี้คุณเป็นอย่างไรบ้าง? อย่าลืมบันทึกเรื่องราวของคุณนะ</p>
                        </div>
                        <div class="d-none d-md-block">
                            <span style="font-size: 3rem;">✨</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">

                <!-- Today's Status -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 1rem;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">
                            <i class="fa-solid fa-sun text-warning me-2"></i>บันทึกของวันนี้
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if ($todayEntry)
                            @php
                                $config = $moodConfig[$todayEntry->mood] ?? [
                                    'emoji' => '📝',
                                    'color' => 'secondary',
                                    'bg' => 'f5f5f9',
                                ];
                            @endphp
                            <div class="d-flex align-items-start gap-4">
                                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                                    style="background-color: #{{ $config['bg'] }}; width: 80px; height: 80px; font-size: 2.5rem;">
                                    {{ $config['emoji'] }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="fw-bold mb-1">{{ $todayEntry->mood }}</h5>
                                            <p class="text-muted small mb-2">
                                                {{ today()->locale('th')->translatedFormat('d F Y') }}</p>
                                        </div>
                                        <a href="{{ route('daily-entries.edit', $todayEntry->id) }}"
                                            class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="fa-solid fa-pen me-1"></i> แก้ไข
                                        </a>
                                    </div>
                                    @if ($todayEntry->activities)
                                        <p class="mb-0 text-secondary">{{ $todayEntry->activities }}</p>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <h5 class="mb-3">วันนี้คุณรู้สึกอย่างไร?</h5>
                                <div class="d-flex justify-content-center gap-3 mb-4">
                                    @foreach ($moodConfig as $moodName => $conf)
                                        <a href="{{ route('daily-entries.create', ['date' => today()->format('Y-m-d')]) }}"
                                            class="text-decoration-none mood-btn" title="{{ $moodName }}">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                style="width: 50px; height: 50px; background-color: #{{ $conf['bg'] }}; font-size: 1.5rem;">
                                                {{ $conf['emoji'] }}
                                            </div>
                                            <span
                                                class="d-block text-center small text-muted mt-1">{{ $moodName }}</span>
                                        </a>
                                    @endforeach
                                </div>
                                <a href="{{ route('daily-entries.create', ['date' => today()->format('Y-m-d')]) }}"
                                    class="btn btn-primary rounded-pill px-4">
                                    <i class="fa-solid fa-plus me-1"></i> เขียนบันทึก
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">
                                <i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>บันทึกล่าสุด
                            </h5>
                            <a href="{{ route('daily-entries.calendar') }}"
                                class="btn btn-sm btn-label-secondary">ดูทั้งหมด</a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if ($recentEntries->isEmpty())
                            <p class="text-muted text-center py-3">ยังไม่มีบันทึกย้อนหลัง</p>
                        @else
                            <div class="timeline-mini">
                                @foreach ($recentEntries as $entry)
                                    @php
                                        $config = $moodConfig[$entry->mood] ?? [
                                            'emoji' => '⚪',
                                            'color' => 'secondary',
                                        ];
                                    @endphp
                                    <div class="timeline-item">
                                        <div class="timeline-dot" style="border-color: var(--bs-{{ $config['color'] }})">
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span
                                                class="fw-semibold text-dark">{{ $entry->entry_date->locale('th')->translatedFormat('d M Y') }}</span>
                                            <span
                                                class="badge bg-label-{{ $config['color'] }} rounded-pill">{{ $entry->mood }}
                                                {{ $config['emoji'] }}</span>
                                        </div>
                                        <p class="text-muted small mb-0 text-truncate" style="max-width: 300px;">
                                            {{ $entry->activities ?: 'ไม่มีรายละเอียด' }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Right Column -->
            <div class="col-lg-4">

                <!-- Stats -->
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="stat-card p-3 h-100">
                            <div class="icon-box bg-label-primary text-primary mb-2">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                            <h4 class="fw-bold mb-0">{{ $totalEntries }}</h4>
                            <small class="text-muted">บันทึกทั้งหมด</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card p-3 h-100">
                            <div class="icon-box bg-label-success text-success mb-2">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <h4 class="fw-bold mb-0">{{ $thisMonthEntries }}</h4>
                            <small class="text-muted">เดือนนี้</small>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush rounded-3">
                            <a href="{{ route('daily-entries.calendar') }}"
                                class="list-group-item list-group-item-action p-3 d-flex align-items-center gap-3 border-0">
                                <div class="icon-box bg-label-info text-info"
                                    style="width: 40px; height: 40px; font-size: 1.2rem;">
                                    <i class="fa-regular fa-calendar"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">ปฏิทิน</h6>
                                    <small class="text-muted">ดูมุมมองปฏิทิน</small>
                                </div>
                                <i class="fa-solid fa-chevron-right ms-auto text-muted"></i>
                            </a>
                            <a href="{{ route('daily-entries.weekly-summary') }}"
                                class="list-group-item list-group-item-action p-3 d-flex align-items-center gap-3 border-0">
                                <div class="icon-box bg-label-warning text-warning"
                                    style="width: 40px; height: 40px; font-size: 1.2rem;">
                                    <i class="fa-solid fa-chart-simple"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">สรุปรายสัปดาห์</h6>
                                    <small class="text-muted">ดูไทม์ไลน์สัปดาห์นี้</small>
                                </div>
                                <i class="fa-solid fa-chevron-right ms-auto text-muted"></i>
                            </a>
                            <a href="{{ route('daily-entries.monthly-summary') }}"
                                class="list-group-item list-group-item-action p-3 d-flex align-items-center gap-3 border-0">
                                <div class="icon-box bg-label-danger text-danger"
                                    style="width: 40px; height: 40px; font-size: 1.2rem;">
                                    <i class="fa-solid fa-chart-pie"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">สรุปรายเดือน</h6>
                                    <small class="text-muted">ดูสถิติประจำเดือน</small>
                                </div>
                                <i class="fa-solid fa-chevron-right ms-auto text-muted"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
