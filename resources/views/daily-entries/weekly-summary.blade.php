@extends('master')

@section('title', 'สรุปรายสัปดาห์')

@push('styles')
    <style>
        .timeline-wrapper {
            position: relative;
            padding-left: 2rem;
        }

        .timeline-wrapper::before {
            content: '';
            position: absolute;
            left: 0;
            top: 1rem;
            bottom: 0;
            width: 2px;
            background: #eef2f6;
            border-radius: 2px;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 2.5rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -2.35rem;
            top: 0.25rem;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background: #fff;
            border: 3px solid #696cff;
            z-index: 1;
            box-shadow: 0 0 0 4px #fff;
        }

        .entry-card {
            background: #fff;
            border-radius: 1rem;
            border: 1px solid #eef2f6;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
            transition: all 0.2s ease;
        }

        .entry-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            border-color: #e0e7ff;
        }

        .mood-summary-card {
            background: linear-gradient(145deg, #ffffff, #f8faff);
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        .nav-btn-group {
            background: #fff;
            padding: 0.25rem;
            border-radius: 0.75rem;
            border: 1px solid #eef2f6;
            display: inline-flex;
            align-items: center;
        }

        .nav-btn {
            padding: 0.4rem 0.8rem;
            border-radius: 0.5rem;
            color: #697a8d;
            transition: all 0.2s;
            border: none;
            background: transparent;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .nav-btn:hover {
            color: #696cff;
            background: #f5f6ff;
        }

        .nav-btn.active {
            background: #696cff;
            color: #fff;
            box-shadow: 0 2px 6px rgba(105, 108, 255, 0.3);
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Header -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold py-3 mb-0">
                    <span class="text-muted fw-light">Daily /</span> Weekly Summary
                </h4>
                <p class="text-muted mb-0">
                    {{ $startDate->locale('th')->translatedFormat('d M') }} -
                    {{ $endDate->locale('th')->translatedFormat('d M Y') }}
                </p>
            </div>

            <div class="nav-btn-group shadow-sm">
                <a href="{{ route('daily-entries.weekly-summary', ['week' => $startDate->copy()->subWeek()->format('Y-m-d')]) }}"
                    class="nav-btn" title="สัปดาห์ก่อน">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
                <a href="{{ route('daily-entries.weekly-summary') }}" class="nav-btn active">
                    สัปดาห์นี้
                </a>
                <a href="{{ route('daily-entries.weekly-summary', ['week' => $startDate->copy()->addWeek()->format('Y-m-d')]) }}"
                    class="nav-btn" title="สัปดาห์ถัดไป">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Timeline -->
            <div class="col-lg-8">
                @if ($entries->isEmpty())
                    <div class="card border-0 shadow-sm p-5 text-center">
                        <div class="mb-3">
                            <i class="fa-regular fa-calendar-xmark text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h5 class="text-muted">ไม่มีบันทึกในช่วงเวลานี้</h5>
                        <p class="text-muted mb-4">เริ่มเขียนบันทึกของคุณได้เลย</p>
                        <div>
                            <a href="{{ route('daily-entries.create', ['date' => today()->format('Y-m-d')]) }}"
                                class="btn btn-primary">
                                <i class="fa-solid fa-plus me-1"></i> เขียนบันทึกวันนี้
                            </a>
                        </div>
                    </div>
                @else
                    <div class="timeline-wrapper">
                        @php
                            $moodConfig = [
                                'ดีมาก' => ['emoji' => '🤩', 'color' => 'primary', 'bg' => 'e7e7ff'],
                                'ดี' => ['emoji' => '😊', 'color' => 'success', 'bg' => 'e8fadf'],
                                'ปกติ' => ['emoji' => '😐', 'color' => 'info', 'bg' => 'd7f5fc'],
                                'ไม่ดี' => ['emoji' => '😔', 'color' => 'warning', 'bg' => 'fff2d6'],
                                'แย่' => ['emoji' => '😫', 'color' => 'danger', 'bg' => 'ffe0db'],
                            ];
                        @endphp

                        @foreach ($entries as $entry)
                            @php
                                $config = $moodConfig[$entry->mood] ?? [
                                    'emoji' => '📝',
                                    'color' => 'secondary',
                                    'bg' => 'f5f5f9',
                                ];
                            @endphp
                            <div class="timeline-item">
                                <div class="timeline-dot" style="border-color: var(--bs-{{ $config['color'] }})"></div>

                                <div class="entry-card p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-3 p-2 d-flex align-items-center justify-content-center"
                                                style="background-color: #{{ $config['bg'] }}; width: 48px; height: 48px; font-size: 1.5rem;">
                                                {{ $config['emoji'] }}
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0 text-dark">
                                                    {{ $entry->entry_date->locale('th')->translatedFormat('lที่ d F') }}
                                                </h6>
                                                <span class="badge bg-label-{{ $config['color'] }} rounded-pill"
                                                    style="font-size: 0.75rem;">
                                                    {{ $entry->mood }}
                                                </span>
                                            </div>
                                        </div>

                                        <a href="{{ route('daily-entries.edit', $entry->id) }}"
                                            class="btn btn-icon btn-sm btn-outline-secondary rounded-circle">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </div>

                                    @if ($entry->activities)
                                        <div class="mb-3">
                                            <p class="mb-0 text-secondary" style="line-height: 1.6;">
                                                {{ $entry->activities }}
                                            </p>
                                        </div>
                                    @endif

                                    @if ($entry->notes)
                                        <div class="bg-light rounded-3 p-3 mt-3">
                                            <div class="d-flex gap-2 text-muted small fw-bold mb-1">
                                                <i class="fa-solid fa-note-sticky"></i> Note
                                            </div>
                                            <p class="mb-0 text-muted small">{{ $entry->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Column: Stats -->
            <div class="col-lg-4">
                <div class="card mood-summary-card mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">ภาพรวมอารมณ์</h5>

                        @if ($entries->isNotEmpty())
                            @php
                                $moodCounts = $entries->groupBy('mood')->map->count();
                                $total = $entries->count();
                            @endphp

                            <div class="d-flex flex-column gap-3">
                                @foreach ($moodConfig as $moodName => $conf)
                                    @if (isset($moodCounts[$moodName]))
                                        @php $percent = ($moodCounts[$moodName] / $total) * 100; @endphp
                                        <div>
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="fw-semibold small">
                                                    {{ $conf['emoji'] }} {{ $moodName }}
                                                </span>
                                                <span class="fw-bold small text-{{ $conf['color'] }}">
                                                    {{ $moodCounts[$moodName] }} วัน
                                                </span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-{{ $conf['color'] }}" role="progressbar"
                                                    style="width: {{ $percent }}%"></div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <hr class="my-4 border-light">

                            <div class="text-center">
                                <h2 class="fw-bold text-primary mb-0">{{ $total }}</h2>
                                <p class="text-muted small">บันทึกทั้งหมดในสัปดาห์นี้</p>
                            </div>
                        @else
                            <p class="text-muted text-center small">ยังไม่มีข้อมูลสำหรับสรุป</p>
                        @endif
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('daily-entries.calendar') }}" class="btn btn-outline-primary">
                        <i class="fa-regular fa-calendar me-1"></i> กลับไปปฏิทิน
                    </a>
                    <a href="{{ route('daily-entries.monthly-summary') }}" class="btn btn-label-secondary">
                        ดูสรุปรายเดือน <i class="fa-solid fa-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
