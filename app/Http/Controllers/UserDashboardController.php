<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;

class UserDashboardController extends Controller
{
    public function myTickets()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $registrations = Registration::with(['event', 'ticketType'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by order_number
        $groupedTickets = $registrations->groupBy('order_number');

        return view('user.tickets', compact('groupedTickets'));
    }
}
