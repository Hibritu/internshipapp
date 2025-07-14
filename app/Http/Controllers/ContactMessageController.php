<?php
namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $message = ContactMessage::create($request->all());

        return response()->json([
            'message' => 'Contact message sent successfully!',
            'data' => $message
        ], 201);
    }

    public function index() // Optional: Admin view
    {
        return ContactMessage::latest()->get();
    }
}
