<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket: {{ $registration->event->name }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; }
        .ticket-box { border: 2px dashed #8b5a3e; padding: 20px; width: 100%; max-width: 600px; margin: 0 auto; text-align: center; }
        .header { background-color: #8b5a3e; color: white; padding: 10px; font-size: 24px; font-weight: bold; letter-spacing: 2px; }
        .event-title { font-size: 28px; margin: 20px 0 10px; font-family: serif; }
        .details { margin-bottom: 20px; font-size: 16px; text-align: left; padding: 0 40px; }
        .qrcode { margin: 20px 0; }
        .footer { font-size: 12px; color: #777; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="ticket-box">
        <div class="header">
            E-TICKET EVENTIX
        </div>
        
        <h1 class="event-title">{{ $registration->event->name }}</h1>
        
        <div class="details">
            <p><strong>Nama Pemesan:</strong> {{ $registration->user->name }}</p>
            <p><strong>Jenis Tiket:</strong> {{ $registration->ticketType->name }}</p>
            <p><strong>Jumlah Tiket:</strong> {{ $registration->quantity }} tiket (Berlaku untuk {{ $registration->quantity }} orang)</p>
            <p><strong>Tanggal:</strong> {{ $registration->event->event_date->format('d M Y, H:i') }} WIB</p>
            <p><strong>Lokasi:</strong> {{ $registration->event->location }}</p>
            <p><strong>Kode Tiket:</strong> {{ $registration->ticket_code }}</p>
        </div>

        <div class="qrcode">
            <img src="data:image/png;base64, {{ $qrCodeBase64 }}" alt="QR Code" width="150" height="150">
        </div>
        
        <p>Tunjukkan QR Code ini kepada petugas di pintu masuk.</p>
        
        <div class="footer">
            Dibuat pada {{ now()->format('d M Y H:i:s') }}
        </div>
    </div>
</body>
</html>
