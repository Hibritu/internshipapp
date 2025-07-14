<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LangTestController extends Controller
{
    public function welcomeMessage()
    {
        return response()->json([
            'message' => __('messages.welcome'),
        ]);
    }
}


