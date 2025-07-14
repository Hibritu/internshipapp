<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Internship;
use App\Models\Interview;
use App\Notifications\InterviewScheduled;
use App\Models\InternshipApplication;
use App\Notifications\ApplicationStatusChanged;
use App\Models\User;

class AdminInternshipController extends Controller
{
    public function internships()
    {
        $internships = Internship::all();
        return response()->json(['internships' => $internships]);
    }
    public function applications()
{
    $applications = InternshipApplication::with('user')->latest()->get();

    foreach ($applications as $app) {
        $app->cv_url = \Storage::url($app->cv_path);
    }

    return response()->json(['applications' => $applications]);
}


  public function updateStatus(Request $request, $id)
{
    $application = InternshipApplication::findOrFail($id);
    $application->status = $request->status;
    $application->save();

    // ✅ Trigger interview email only if accepted
    if ($application->status === 'accepted') {
        $interview = Interview::firstOrCreate([
            'internship_application_id' => $application->id,
        ], [
            'interview_time' => now()->addDays(1), // or set this via request
            'interview_link' => 'https://meet.example.com/abc',
            'notes' => 'Please be on time.',
        ]);

        // 🔔 Send email notification
        $application->user->notify(new InterviewScheduled($interview));
        $application->user->notify(new ApplicationStatusChanged($request->status));
    }

    return response()->json(['message' => 'Status updated']);
}
    public function show($id)
    {
        $internship = Internship::findOrFail($id);
        return response()->json(['internship' => $internship]);
    }

}
