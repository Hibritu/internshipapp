<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use App\Notifications\InterviewScheduled;

class InterviewController extends Controller
{
    // GET /interviews
    public function index()
    {
        $interviews = Interview::with('internshipApplication.user')->latest()->get();

        return response()->json([
            'message' => 'All interviews fetched successfully',
            'interviews' => $interviews
        ]);
    }

    // POST /interviews
    public function store(Request $request)
    {
        $request->validate([
            'internship_application_id' => 'required|exists:internship_applications,id',
            'interview_time' => 'required|date',
            'interview_link' => 'nullable|url',
            'notes' => 'nullable|string',
        ]);

        $application = InternshipApplication::findOrFail($request->internship_application_id);

        if ($application->status !== 'accepted') {
            return response()->json([
                'message' => 'Interview can only be scheduled for accepted applications.'
            ], 403);
        }

        $interview = Interview::create([
            'internship_application_id' => $application->id,
            'interview_time' => $request->interview_time,
            'interview_link' => $request->interview_link,
            'notes' => $request->notes,
        ]);

        $application->user->notify(new InterviewScheduled($interview));

        return response()->json([
            'message' => 'Interview scheduled and email sent',
            'interview' => $interview
        ]);
    }

    // GET /interviews/{id}
    public function show($id)
    {
        $interview = Interview::with('internshipApplication.user')->findOrFail($id);

        return response()->json([
            'message' => 'Interview detail',
            'interview' => $interview
        ]);
    }

    // PUT/PATCH /interviews/{id}
    public function update(Request $request, $id)
    {
        $request->validate([
            'interview_time' => 'required|date',
            'interview_link' => 'nullable|url',
            'notes' => 'nullable|string',
        ]);

        $interview = Interview::findOrFail($id);

        $interview->update([
            'interview_time' => $request->interview_time,
            'interview_link' => $request->interview_link,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'message' => 'Interview updated successfully',
            'interview' => $interview
        ]);
    }

    // DELETE /interviews/{id}
    public function destroy($id)
    {
        $interview = Interview::findOrFail($id);
        $interview->delete();

        return response()->json([
            'message' => 'Interview deleted successfully'
        ]);
    }
}
