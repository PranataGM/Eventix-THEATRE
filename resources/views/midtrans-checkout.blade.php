<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Midtrans - Eventix</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-YOUR_KEY') }}"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md text-center">
        <h2 class="text-2xl font-bold mb-6">Penyelesaian Pembayaran</h2>
        
        <p class="text-gray-600 mb-1">Tiket: {{ $registration->ticketType->name }} x {{ $registration->quantity_total }}</p>
        <p class="text-gray-600 mb-2">Total Tagihan:</p>
        <p class="text-3xl font-bold text-[#8b5a3e] mb-4">Rp {{ number_format($registration->ticketType->price * $registration->quantity_total, 0, ',', '.') }}</p>

        <div class="bg-red-50 text-red-600 text-xs text-left p-3 rounded mb-6 border border-red-200">
            <strong>Perhatian:</strong> Tiket yang sudah dibeli dan dibayar tidak dapat dibatalkan atau di-refund dengan alasan apa pun.
        </div>

        <button id="pay-button" class="w-full bg-[#8b5a3e] text-white font-bold py-3 px-4 rounded hover:bg-[#7a4e35] transition-colors mb-4">
            Bayar Sekarang
        </button>

        <a href="{{ route('event.checkout.fallback', $registration->id) }}" class="text-sm text-blue-600 hover:underline">
            (Simulasi jika API Key Midtrans kosong)
        </a>
    </div>

    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $snapToken }}', {
          onSuccess: function(result){
            alert("Pembayaran berhasil!"); console.log(result);
            window.location.href = "{{ route('ticket.download', $registration->id) }}";
          },
          onPending: function(result){
            alert("Menunggu pembayaran Anda!"); console.log(result);
          },
          onError: function(result){
            alert("Pembayaran gagal!"); console.log(result);
          },
          onClose: function(){
            alert('Anda menutup popup sebelum menyelesaikan pembayaran');
          }
        });
      };
    </script>
</body>
</html>
