@extends('master')
@section('title', 'สรุปรายเดือน')

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

        .stat-card {
            border: none;
            border-radius: 1rem;
            background: #fff;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
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
                    <span class="text-muted fw-light">Daily /</span> Monthly Summary
                </h4>
                <p class="text-muted mb-0">
                    {{ $startDate->locale('th')->translatedFormat('F Y') }}
                </p>
            </div>

            <div class="nav-btn-group shadow-sm">
                <a href="{{ route('daily-entries.monthly-summary', ['year' => $startDate->copy()->subMonth()->year, 'month' => $startDate->copy()->subMonth()->month]) }}"
                    class="nav-btn" title="เดือนก่อน">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
                <a href="{{ route('daily-entries.monthly-summary') }}" class="nav-btn active">
                    เดือนนี้
                </a>
                <a href="{{ route('daily-entries.monthly-summary', ['year' => $startDate->copy()->addMonth()->year, 'month' => $startDate->copy()->addMonth()->month]) }}"
                    class="nav-btn" title="เดือนถัดไป">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card p-4">
                    <div class="stat-icon bg-label-primary text-primary">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $totalDays }} <span class="fs-6 text-muted fw-normal">/
                            {{ $daysInMonth }} วัน</span></h3>
                    <p class="text-muted mb-0 small">จำนวนวันที่บันทึก</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card p-4">
                    <div class="stat-icon bg-label-success text-success">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $daysInMonth ? round(($totalDays / $daysInMonth) * 100) : 0 }}%</h3>
                    <p class="text-muted mb-0 small">ความต่อเนื่องในการบันทึก</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card p-4">
                    <div class="stat-icon bg-label-info text-info">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $entries->count() }}</h3>
                    <p class="text-muted mb-0 small">จำนวนรายการทั้งหมด</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Chart & Moods -->
            <div class="col-lg-4 order-lg-2">
                <!-- Mood Chart -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 1rem;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Mood Overview</h5>
                    </div>
                    <div class="card-body px-2">
                        <div id="moodChart"></div>
                    </div>
                </div>

                <!-- Mood Breakdown -->
                @if ($moodStats->isNotEmpty())
                    <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Mood Breakdown</h5>
                            <div class="d-flex flex-column gap-3">
                                @php
                                    $moodConfig = [
                                        'ดีมาก' => ['emoji' => '🤩', 'color' => 'primary', 'bg' => 'e7e7ff'],
                                        'ดี' => ['emoji' => '😊', 'color' => 'success', 'bg' => 'e8fadf'],
                                        'ปกติ' => ['emoji' => '😐', 'color' => 'info', 'bg' => 'd7f5fc'],
                                        'ไม่ดี' => ['emoji' => '😔', 'color' => 'warning', 'bg' => 'fff2d6'],
                                        'แย่' => ['emoji' => '😫', 'color' => 'danger', 'bg' => 'ffe0db'],
                                    ];
                                @endphp

                                @foreach ($moodStats as $mood => $count)
                                    @php $conf = $moodConfig[$mood] ?? ['emoji' => '😐', 'color' => 'secondary']; @endphp
                                    <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-light">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="fs-4">{{ $conf['emoji'] }}</span>
                                            <span class="fw-semibold">{{ $mood }}</span>
                                        </div>
                                        <span class="badge bg-{{ $conf['color'] }} rounded-pill px-3">
                                            {{ $count }} ครั้ง
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column (Left visually): Timeline -->
            <div class="col-lg-8 order-lg-1">
                <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-0">Timeline</h5>
                    </div>
                    <div class="card-body p-4">
                        @if ($entries->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted">ยังไม่มีบันทึกในเดือนนี้</p>
                            </div>
                        @else
                            <div class="timeline-wrapper">
                                @foreach ($entries as $entry)
                                    @php
                                        $config = $moodConfig[$entry->mood] ?? [
                                            'emoji' => '📝',
                                            'color' => 'secondary',
                                            'bg' => 'f5f5f9',
                                        ];
                                    @endphp
                                    <div class="timeline-item">
                                        <div class="timeline-dot" style="border-color: var(--bs-{{ $config['color'] }})">
                                        </div>

                                        <div class="entry-card p-4">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="rounded-3 p-2 d-flex align-items-center justify-content-center"
                                                        style="background-color: #{{ $config['bg'] }}; width: 42px; height: 42px; font-size: 1.25rem;">
                                                        {{ $config['emoji'] }}
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-0 text-dark">
                                                            {{ $entry->entry_date->locale('th')->translatedFormat('d F Y') }}
                                                        </h6>
                                                        <span class="text-muted small">{{ $entry->mood }}</span>
                                                    </div>
                                                </div>

                                                <a href="{{ route('daily-entries.edit', $entry->id) }}"
                                                    class="btn btn-icon btn-sm btn-outline-secondary rounded-circle">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                            </div>

                                            @if ($entry->activities)
                                                <p class="mb-0 text-secondary mt-2 small" style="line-height: 1.6;">
                                                    {{ Str::limit($entry->activities, 150) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options = {
                series: [{
                    name: 'จำนวนครั้ง',
                    data: [
                        {{ $moodStats['ดีมาก'] ?? 0 }},
                        {{ $moodStats['ดี'] ?? 0 }},
                        {{ $moodStats['ปกติ'] ?? 0 }},
                        {{ $moodStats['ไม่ดี'] ?? 0 }},
                        {{ $moodStats['แย่'] ?? 0 }}
                    ]
                }],
                chart: {
                    height: 300,
                    type: 'bar',
                    fontFamily: 'Public Sans',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '40%',
                        distributed: true,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: false
                },
                xaxis: {
                    categories: ['ดีมาก', 'ดี', 'ปกติ', 'ไม่ดี', 'แย่'],
                    labels: {
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Public Sans'
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Public Sans'
                        }
                    }
                },
                colors: ['#696cff', '#71dd37', '#03c3ec', '#ffab00', '#ff3e1d'],
                grid: {
                    borderColor: '#f1f1f1',
                    padding: {
                        top: 0,
                        bottom: 0
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#moodChart"), options);
            chart.render();
        });
    </script>
@endsection
