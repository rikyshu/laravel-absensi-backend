<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $attendances = Attendance::with('user')
        ->when($request->input('name'), function($query, $name) {
            $query->whereHas('user', function($query) use ($name) {
                $query->where('name', 'like', "%.$name.%");
            });
        })->orderBy('id', 'desc')->paginate(10);
        return view('pages.absensi.index', compact('attendances'));
    }

    public function edit(Attendance $attendance)
    {
        return view('pages.absensi.edit', compact('attendance'));
    }

    // public function update(Request $request, Attendance $attendance)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //     ]);

    //     $attendance->user->update([
    //         'name' => $request->name,
    //     ]);

    //     return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully');
    // }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'Attendance deleted successfully');
    }
}
