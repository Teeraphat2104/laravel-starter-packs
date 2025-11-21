@extends('master')

@section('title', 'ปฏิทินบันทึกประจำวัน')

@push('styles')
    <style>
        :root {
            --calendar-bg: #ffffff;
            --calendar-border: #eef2f6;
            --calendar-hover: #f8faff;
            --primary-soft: #e3f2fd;
            --primary-border: #90caf9;
        }

        .calendar-wrapper {
            background: var(--calendar-bg);
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.02);
        }

        .calendar-header {
            background: linear-gradient(to right, #ffffff, #f8f9fa);
            border-bottom: 1px solid var(--calendar-border);
            border-radius: 1.5rem 1.5rem 0 0;
            padding: 1.5rem;
        }

        .calendar-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding: 1.5rem;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(100px, 1fr));
            gap: 0.75rem;
            min-width: 800px;
        }

        .calendar-weekday {
            text-align: center;
            font-weight: 600;
            color: #697a8d;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding-bottom: 0.5rem;
        }

        .calendar-cell {
            background: #fff;
            border: 1px solid var(--calendar-border);
            border-radius: 1rem;
            padding: 0.75rem;
            min-height: 120px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .calendar-cell:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.04);
            border-color: var(--primary-border);
            z-index: 1;
        }

        .calendar-cell.has-entry {
            background: linear-gradient(145deg, #ffffff 0%, #f8faff 100%);
            border-color: #e0e7ff;
        }

        .calendar-cell.today {
            border: 2px solid #696cff;
            background-color: #f5f6ff !important;
        }

        .day-number {
            font-weight: 700;
            font-size: 1.1rem;
            color: #566a7f;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .today .day-number {
            color: #696cff;
        }

        .mood-badge {
            font-size: 1.5rem;
            line-height: 1;
            margin-bottom: 0.25rem;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
            transition: transform 0.2s;
        }

        .calendar-cell:hover .mood-badge {
            transform: scale(1.1);
        }

        .activity-preview {
            font-size: 0.75rem;
            color: #8592a3;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 0.5rem;
            padding: 2px 4px;
        }

        .btn-nav {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid #d9dee3;
            color: #697a8d;
            transition: all 0.2s;
            background: white;
        }

        .btn-nav:hover {
            background: #f5f6ff;
            border-color: #696cff;
            color: #696cff;
        }

        .summary-card {
            border: none;
            border-radius: 1rem;
            transition: transform 0.2s;
            background: white;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .summary-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .calendar-grid {
                grid-template-columns: repeat(7, minmax(80px, 1fr));
                min-width: 600px;
            }

            .calendar-cell {
                min-height: 100px;
                padding: 0.5rem;
            }

            .mood-badge {
                font-size: 1.2rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Header Section -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold py-3 mb-0">
                    <span class="text-muted fw-light">Daily /</span> Calendar
                </h4>
                <p class="text-muted mb-0">บันทึกเรื่องราวและความรู้สึกในแต่ละวันของคุณ</p>
            </div>
            <a href="{{ route('daily-entries.create', ['date' => today()->format('Y-m-d')]) }}"
                class="btn btn-primary shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> บันทึกวันนี้
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="calendar-wrapper mb-4">
            <!-- Calendar Header -->
            <div class="calendar-header d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <h3 class="mb-0 fw-bold text-primary">
                        {{ \Carbon\Carbon::create($year, $month, 1)->locale('th')->translatedFormat('F Y') }}
                    </h3>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('daily-entries.calendar', ['year' => $startDate->copy()->subMonth()->year, 'month' => $startDate->copy()->subMonth()->month]) }}"
                        class="btn-nav" title="เดือนก่อนหน้า">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                    <a href="{{ route('daily-entries.calendar') }}"
                        class="btn btn-outline-primary btn-sm px-3 rounded-pill">เดือนนี้</a>
                    <a href="{{ route('daily-entries.calendar', ['year' => $startDate->copy()->addMonth()->year, 'month' => $startDate->copy()->addMonth()->month]) }}"
                        class="btn-nav" title="เดือนถัดไป">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="calendar-container">
                <div class="calendar-grid mb-2">
                    @foreach (['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัส', 'ศุกร์', 'เสาร์'] as $day)
                        <div class="calendar-weekday">{{ $day }}</div>
                    @endforeach
                </div>

                <div class="calendar-grid">
                    <!-- Empty cells before first day -->
                    @for ($i = 0; $i < $firstDayOfWeek; $i++)
                        <div class="calendar-cell border-0 bg-transparent"></div>
                    @endfor

                    <!-- Days -->
                    @for ($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $currentDate = $startDate->copy()->setDay($day);
                            $dateKey = $currentDate->format('Y-m-d');
                            $entry = $entries[$dateKey] ?? null;
                            $isToday = $currentDate->isToday();

                            $moodEmojis = [
                                'ดีมาก' => '🤩',
                                'ดี' => '😊',
                                'ปกติ' => '😐',
                                'ไม่ดี' => '😔',
                                'แย่' => '😫',
                            ];
                        @endphp

                        <div class="calendar-cell {{ $entry ? 'has-entry' : '' }} {{ $isToday ? 'today' : '' }}"
                            data-date="{{ $dateKey }}" data-mood="{{ $entry->mood ?? '' }}"
                            data-activities="{{ $entry->activities ?? '' }}" onclick="openEntryModal(this)">

                            <div class="day-number">
                                {{ $day }}
                                @if ($isToday)
                                    <span class="badge text-black bg-label-primary rounded-pill px-2"
                                        style="font-size: 0.6rem;">TODAY</span>
                                @endif
                            </div>

                            @if ($entry)
                                <div class="flex-grow-1 d-flex flex-column justify-content-center align-items-center">
                                    @if ($entry->mood)
                                        <div class="mood-badge" title="{{ $entry->mood }}">
                                            {{ $moodEmojis[$entry->mood] ?? '' }}
                                        </div>
                                    @endif
                                    @if ($entry->activities)
                                        <div class="activity-preview w-100 text-center">
                                            {{ Str::limit($entry->activities, 40) }}
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="flex-grow-1 d-flex align-items-center justify-content-center opacity-25">
                                    <i class="fa-solid fa-circle-plus fs-4"></i>
                                </div>
                            @endif
                        </div>

                    @endfor
                </div>
            </div>
        </div>

        <!-- Quick Stats / Links -->
        <div class="row g-4">
            <div class="col-md-6">
                <a href="{{ route('daily-entries.weekly-summary') }}" class="text-decoration-none">
                    <div class="summary-card p-4 h-100">
                        <div class="d-flex align-items-center">
                            <div class="summary-icon bg-label-info text-info me-3">
                                <i class="fa-solid fa-list-ul"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 text-dark">สรุปรายสัปดาห์</h5>
                                <p class="text-muted mb-0 small">ทบทวนเรื่องราวในสัปดาห์ที่ผ่านมา</p>
                            </div>
                            <i class="fa-solid fa-chevron-right ms-auto text-muted fs-4"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('daily-entries.monthly-summary') }}" class="text-decoration-none">
                    <div class="summary-card p-4 h-100">
                        <div class="d-flex align-items-center">
                            <div class="summary-icon bg-label-success text-success me-3">
                                <i class="fa-solid fa-chart-column"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 text-dark">สรุปรายเดือน</h5>
                                <p class="text-muted mb-0 small">ดูสถิติและแนวโน้มอารมณ์ของคุณ</p>
                            </div>
                            <i class="fa-solid fa-chevron-right ms-auto text-muted fs-4"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>


    <!-- Modal แสดงบันทึกวันนั้น -->
    <div class="modal fade" id="entryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg"
                style="background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);">
                <div class="modal-header border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-gradient me-3"
                            style="width: 45px; height: 45px;">
                            <i class="fa-regular fa-calendar fa-lg text-white"></i>
                        </div>
                        <h5 class="modal-title fw-bold mb-0">รายละเอียดบันทึก</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-calendar-day text-primary me-2"></i>
                            <strong class="text-dark">วันที่:</strong>
                        </div>
                        <div class="ps-4">
                            <span id="modalDate" class="text-muted"></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-face-smile text-primary me-2"></i>
                            <strong class="text-dark">อารมณ์:</strong>
                        </div>
                        <div class="ps-4">
                            <span id="modalMood" class="badge bg-light text-dark px-3 py-2 rounded-pill"></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-list-check text-primary me-2"></i>
                            <strong class="text-dark">กิจกรรม:</strong>
                        </div>
                        <div class="ps-4">
                            <p id="modalActivities" class="text-muted mb-0" style="white-space: pre-wrap;"></p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark me-1"></i> ปิด
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openEntryModal(cell) {
            const date = cell.getAttribute('data-date');
            const mood = cell.getAttribute('data-mood') || 'ไม่มีข้อมูล';
            const activities = cell.getAttribute('data-activities') || 'ไม่มีรายละเอียด';

            // Mood emoji mapping
            const moodEmojis = {
                'ดีมาก': '🤩',
                'ดี': '😊',
                'ปกติ': '😐',
                'ไม่ดี': '😔',
                'แย่': '😫'
            };

            const moodWithEmoji = mood !== 'ไม่มีข้อมูล' ? `${moodEmojis[mood] || ''} ${mood}` : mood;

            document.getElementById('modalDate').innerText = date;
            document.getElementById('modalMood').innerText = moodWithEmoji;
            document.getElementById('modalActivities').innerText = activities;

            const modal = new bootstrap.Modal(document.getElementById('entryModal'));
            modal.show();
        }
    </script>
@endsection
