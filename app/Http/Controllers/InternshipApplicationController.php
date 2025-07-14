<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternshipApplication;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Notifications\NewApplicationSubmitted;



class InternshipApplicationController extends Controller
{
    
     public function index()
    {
        $applications = InternshipApplication::with('user')->latest()->get();
        return response()->json(['applications' => $applications]);
    }
public function store(Request $request)
{
    // store application...
    $application = InternshipApplication::create([
        // fields...
    ]);

   
    return response()->json(['message' => 'Application submitted successfully']);
}

  public function apply(Request $request)
{
    $request->validate([
        'cover_letter' => 'required|string',
        'category' => 'required|in:frontend Developer,backend Developer,mobile app Developer',
        'telegram_username' => 'required|string|max:255',
        'portfolio_link' => 'required|url',
        'cv' => 'required|file|mimes:pdf|max:2048',
        'type' => 'required|in:remote,on-site',
    ]);

    $path = $request->file('cv')->store('public/cvs');

    $application = InternshipApplication::create([
        'user_id' => $request->user()->id,
        'cover_letter' => $request->cover_letter,
        'category' => $request->get('category'), // instead of $request->category

        'telegram_username' => $request->telegram_username,
        'portfolio_link' => $request->portfolio_link,
        'cv_path' => $path,
        'type' => $request->type,
        'status' => 'pending',
    ]);

    // ✅ Notify all admins about new application
    $admins = User::where('role', 'admin')->get();
    foreach ($admins as $admin) {
        $admin->notify(new NewApplicationSubmitted(auth()->user()->name));
    }

    return response()->json(['message' => 'Application submitted successfully']);
}
  public function update(Request $request, $id)
    {
        $application = InternshipApplication::findOrFail($id);

        $request->validate([
            'cover_letter' => 'sometimes|required|string',
            'category' => 'sometimes|required|in:frontend Developer,backend Developer,mobile app Developer',
            'telegram_username' => 'sometimes|required|string|max:255',
            'portfolio_link' => 'sometimes|required|url',
            'cv' => 'sometimes|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('cv')) {
            Storage::delete($application->cv_path);
            $application->cv_path = $request->file('cv')->store('public/cvs');
        }

        $application->update($request->only([
            'cover_letter', 'category', 'telegram_username', 'portfolio_link'
        ]));

        return response()->json(['message' => 'Application updated successfully', 'application' => $application]);
    }

    // ✅ DELETE application
    public function destroy($id)
    {
        $application = InternshipApplication::findOrFail($id);
        Storage::delete($application->cv_path); // delete uploaded CV file
        $application->delete();

        return response()->json(['message' => 'Application deleted successfully']);
    }

    public function myApplication(Request $request)
    {
        $application = InternshipApplication::where('user_id', $request->user()->id)->latest()->first();

        if (!$application) {
            return response()->json(['message' => 'No application found']);
        }

        return response()->json($application);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

}
