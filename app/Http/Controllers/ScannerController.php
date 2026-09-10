<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    public function index()
    {
        return view('scanner');
    }

    public function process(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required|string',
        ]);

        $registration = Registration::with('user', 'ticketType')->where('ticket_code', $request->ticket_code)->first();

        if (!$registration) {
            return response()->json(['success' => false, 'message' => 'Ticket not found!'], 404);
        }

        if ($registration->is_checked_in) {
            return response()->json(['success' => false, 'message' => 'Ticket already checked in at ' . $registration->checked_in_at->format('H:i')]);
        }

        $registration->update([
            'is_checked_in' => true,
            'checked_in_at' => now(),
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Check-in successful for ' . $registration->user->name . ' (' . $registration->ticketType->name . ')'
        ]);
    }
}
