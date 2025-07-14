<?php
namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\InternshipApplication;
// ✅ This is the key: you're using the correct base Controller class
class CertificateController extends Controller
{
    public function __construct()
    {
        // ✅ Now this will work
        $this->middleware('auth:sanctum'); // or 'auth:api' based on your auth setup
    }

    public function generate(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $application = InternshipApplication::where('user_id', $userId)
            ->where('status', 'completed')
            ->latest()
            ->first();

        if (!$application) {
            return response()->json(['message' => 'No completed internship found for this user.'], 403);
        }

        $startDate = $request->start_date ?? now()->subMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');
        $category = $application->category ?? 'Intern';
     
        $pdf = Pdf::loadView('certificates.internship', [
            'name' => $user->name,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'category' => $category,
        ]);

        $fileName = 'certificates/' . $user->id . '_certificate.pdf';
        Storage::disk('public')->put($fileName, $pdf->output());

        $certificate = Certificate::create([
            'user_id' => $user->id,
            'file_path' => 'storage/' . $fileName,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return response()->json([
            'message' => 'Certificate generated successfully',
            'certificate' => $certificate,
        ]);
    }

    public function download($id)
    {
        $certificate = Certificate::where('user_id', $id)->first();

        if (!$certificate) {
            return response()->json(['message' => 'Certificate not found'], 404);
        }

        $relativePath = str_replace('storage/', '', $certificate->file_path);

        if (!Storage::disk('public')->exists($relativePath)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        return Storage::disk('public')->download($relativePath);
    }

    public function userCertificates(Request $request)
    {
        return Certificate::where('user_id', $request->user()->id)->get();
    }
}
