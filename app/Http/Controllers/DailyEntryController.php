<?php

namespace App\Http\Controllers;

use App\Models\DailyEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EntryCreated;
use App\Mail\EntryUpdated;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DailyEntryController extends Controller
{
    /**
     * Display calendar view.
     */
    public function calendar(Request $request): View
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $startDate = now()->setDate($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $entries = DailyEntry::where('user_id', Auth::id())
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->get()
            ->keyBy(function ($entry) {
                return $entry->entry_date->format('Y-m-d');
            });

        $firstDayOfWeek = $startDate->dayOfWeek;
        $daysInMonth = $startDate->daysInMonth;

        return view('daily-entries.calendar', compact('year', 'month', 'entries', 'startDate', 'firstDayOfWeek', 'daysInMonth'));
    }

    /**
     * Show weekly summary.
     */
    public function weeklySummary(Request $request): View
    {
        $weekStart = $request->get('week', now()->startOfWeek()->format('Y-m-d'));
        $startDate = Carbon::parse($weekStart)->startOfWeek();
        $endDate = $startDate->copy()->endOfWeek();

        $entries = DailyEntry::where('user_id', Auth::id())
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->orderBy('entry_date')
            ->get();

        return view('daily-entries.weekly-summary', compact('entries', 'startDate', 'endDate'));
    }

    /**
     * Show monthly summary.
     */
    public function monthlySummary(Request $request): View
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $startDate = now()->setDate($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $entries = DailyEntry::where('user_id', Auth::id())
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->orderBy('entry_date')
            ->get();

        $moodStats = $entries->groupBy('mood')->map->count();
        $totalDays = $entries->count();
        $daysInMonth = $startDate->daysInMonth;

        return view('daily-entries.monthly-summary', compact('entries', 'startDate', 'endDate', 'moodStats', 'totalDays', 'daysInMonth', 'year', 'month'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        $entry = DailyEntry::where('user_id', Auth::id())
            ->where('entry_date', $date)
            ->first();

        return view('daily-entries.create', compact('date', 'entry'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'entry_date' => 'required|date',
            'activities' => 'nullable|string',
            'mood' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        DailyEntry::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'entry_date' => $validated['entry_date'],
            ],
            $validated
        );

        $entry = DailyEntry::where('user_id', Auth::id())
            ->where('entry_date', $validated['entry_date'])
            ->first();

        Mail::to($entry->user->email)->send(new EntryCreated($entry));

        return redirect()->route('daily-entries.calendar')
            ->with('200', 'บันทึกประจำวันสำเร็จแล้ว');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $entry = DailyEntry::where('user_id', Auth::id())->findOrFail($id);

        return view('daily-entries.edit', compact('entry'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $entry = DailyEntry::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'activities' => 'nullable|string',
            'mood' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $entry->update($validated);

        Mail::to($entry->user->email)->send(new EntryUpdated($entry));

        return redirect()->route('daily-entries.calendar')
            ->with('200', 'อัปเดตบันทึกประจำวันสำเร็จแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $entry = DailyEntry::where('user_id', Auth::id())->findOrFail($id);
        $entry->delete();

        return redirect()->route('daily-entries.calendar')
            ->with('200', 'ลบบันทึกประจำวันสำเร็จแล้ว');
    }
}
