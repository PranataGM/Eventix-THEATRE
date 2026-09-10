<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TicketType;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('ticketTypes')->where('event_date', '>=', now());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $events = $query->orderBy('event_date', 'asc')->get();
        return view('welcome', compact('events'));
    }

    public function show($id)
    {
        $event = Event::with('ticketTypes', 'organizer')->findOrFail($id);
        return view('event-detail', compact('event'));
    }

    public function register(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $event = Event::findOrFail($id);
        $ticketType = TicketType::where('event_id', $id)->findOrFail($request->ticket_type_id);

        if ($request->quantity > $ticketType->remaining_quota) {
            return back()->with('error', 'Maaf, sisa tiket jenis ini tidak mencukupi untuk pesanan Anda.');
        }

        $user = User::firstOrCreate(
            ['email' => $request->email],
            ['name' => $request->name, 'password' => bcrypt(Str::random(10))]
        );

        $orderNumber = 'ORD-' . strtoupper(Str::random(10));
        $quantity = $request->quantity;
        
        $firstRegistration = null;

        for ($i = 0; $i < $quantity; $i++) {
            $ticketCode = 'TIX-' . strtoupper(Str::random(8));

            $registration = Registration::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'ticket_type_id' => $ticketType->id,
                'order_number' => $orderNumber,
                'ticket_code' => $ticketCode,
                'status' => 'pending',
                'payment_method' => 'Midtrans',
                'payment_status' => 'pending',
                'quantity' => 1, // Kita set 1 karena ini merepresentasikan 1 tiket unik
            ]);

            if ($i === 0) {
                $firstRegistration = $registration;
            }
        }

        // Setup Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $grossAmount = $ticketType->price * $quantity;

        $params = array(
            'transaction_details' => array(
                'order_id' => $orderNumber,
                'gross_amount' => $grossAmount,
            ),
            'customer_details' => array(
                'first_name' => $user->name,
                'email' => $user->email,
            ),
        );

        // Memanggil API Midtrans (Pastikan Server Key sudah terisi di .env)
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        
        $registration = $firstRegistration;
        $registration->quantity_total = $quantity; 
        
        return view('midtrans-checkout', compact('registration', 'snapToken'));
    }

    public function midtransCallback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                Registration::where('order_number', $request->order_id)
                    ->update(['payment_status' => 'paid', 'status' => 'confirmed']);
            }
        }
        return response()->json(['message' => 'Callback received']);
    }

    public function downloadTicket($id)
    {
        $registration = Registration::with(['event', 'user', 'ticketType'])->findOrFail($id);
        
        // Cek IDOR: Pastikan hanya pemilik tiket yang dapat mengunduh PDF ini
        if ($registration->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda tidak diizinkan mengunduh tiket ini.');
        }

        if ($registration->status !== 'confirmed') {
            abort(403, 'Tiket belum dikonfirmasi atau pembayaran belum diverifikasi.');
        }

        // Mengambil QR Code dari API publik sebagai gambar PNG dan mengubahnya ke Base64
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($registration->ticket_code);
        $qrCodeBase64 = base64_encode(file_get_contents($qrCodeUrl));

        $pdf = Pdf::loadView('ticket-pdf', compact('registration', 'qrCodeBase64'));
        $pdf->setOption(['isRemoteEnabled' => true]);
        
        return $pdf->download('Ticket-' . $registration->ticket_code . '.pdf');
    }
}
