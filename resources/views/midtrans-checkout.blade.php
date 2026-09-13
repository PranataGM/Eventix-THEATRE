<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Midtrans - Eventix THEATRE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        theater: {
                            dark: '#1a1818',
                            brown: '#8b5a3e',
                            light: '#fbfaf8',
                        }
                    }
                }
            }
        }
    </script>
    @if(env('MIDTRANS_IS_PRODUCTION', false))
        <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    @else
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-theater-light font-sans text-gray-800 antialiased min-h-screen flex flex-col"> 
    @include('partials.toast')

    @include('partials.navbar')

    <!-- Main Content -->
    <div class="flex-grow flex items-center justify-center py-12 px-4">
        <div class="bg-white p-10 rounded-sm border border-gray-200 shadow-sm w-full max-w-md text-center">
            <h2 class="text-3xl font-serif font-bold text-gray-900 mb-6">Pembayaran Tiket</h2>
            
            <div class="border-y border-dashed border-gray-300 py-4 mb-6">
                <p class="text-gray-500 text-sm mb-1 uppercase tracking-widest font-medium">{{ $registration->ticketType->event->name ?? 'Acara' }}</p>
                <p class="text-gray-900 font-bold mb-2">{{ $registration->ticketType->name }} <span class="text-gray-400 mx-1">x</span> {{ $registration->quantity_total }}</p>
                <p class="text-xs text-gray-500 mb-1">Total Tagihan:</p>
                <p class="text-4xl font-serif font-bold text-theater-brown">Rp {{ number_format($registration->ticketType->price * $registration->quantity_total, 0, ',', '.') }}</p>
            </div>

            <div class="bg-red-50 text-red-600 text-xs text-left p-4 rounded-sm mb-8 border border-red-200">
                <strong class="uppercase tracking-wider font-bold">Perhatian:</strong> Tiket yang sudah dibeli dan dibayar tidak dapat dibatalkan atau di-refund dengan alasan apa pun.
            </div>

            <button id="pay-button" class="w-full bg-theater-dark text-white font-bold tracking-widest py-4 px-4 rounded-sm hover:bg-black transition-colors mb-4 uppercase text-sm">
                Bayar Sekarang
            </button>
        </div>
    </div>

    @include('partials.footer')

    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $snapToken }}', {
          onSuccess: function(result){
            Swal.fire({
                title: 'Pembayaran Berhasil!',
                text: 'Tiket sedang diproses. Anda akan dialihkan ke Dasbor.',
                icon: 'success',
                confirmButtonColor: '#8b5a3e'
            }).then(() => {
                window.location.href = "{{ route('user.tickets') }}";
            });
            console.log(result);
          },
          onPending: function(result){
            Swal.fire('Menunggu Pembayaran', 'Silakan selesaikan pembayaran Anda.', 'info');
            console.log(result);
          },
          onError: function(result){
            Swal.fire('Gagal', 'Pembayaran gagal diproses!', 'error');
            console.log(result);
          },
          onClose: function(){
            Swal.fire('Dibatalkan', 'Anda menutup popup sebelum pembayaran selesai.', 'warning');
          }
        });
      };
    </script>
</body>
</html>
