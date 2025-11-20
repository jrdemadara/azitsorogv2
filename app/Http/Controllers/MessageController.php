<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'notes' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $message = Message::create([
            'fullname' => $request->name,
            'email' => $request->email,
            'company' => $request->company,
            'message' => $request->notes,
            'is_read' => false,
        ]);

        return response()->json([
            'message' => 'Your message has been sent successfully. We will get back to you soon.',
            'data' => [
                'id' => $message->id,
            ],
        ], 201);
    }
}

